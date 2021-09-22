<?php
/**
 * Naran Code Base: Render trait
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'NCB_Render_Trait' ) ) {
	trait NCB_Render_Trait {
		/**
		 * @param string $tmpl_type
		 * @param string $relpath
		 * @param string $variant
		 * @param string $ext
		 *
		 * @return false|string
		 */
		protected function locate_file( string $tmpl_type, string $relpath, string $variant = '', $ext = 'php' ) {
			$located = false;

			if (
				method_exists( $this, 'get_container' ) &&
				( $container = $this->get_container() ) instanceof NCB_Container_Interface
			) {
				$tmpl_type = trim( $tmpl_type, '\\/' );
				$relpath   = trim( $relpath, '\\/' );
				$variant   = sanitize_key( $variant );
				$ext       = ltrim( $ext, '.' );

				$cache_name = "{$tmpl_type}:{$relpath}:{$variant}";
				$cache      = $container->get( 'ncb:locate_file', [] );

				if ( array_key_exists( $cache_name, $cache ) ) {
					$located = $cache[ $cache_name ];
				} else {
					$dir       = dirname( $relpath );
					$file_name = wp_basename( $relpath );

					if ( empty( $dir ) ) {
						$dir = '.';
					}

					$paths = [
						$variant ? STYLESHEETPATH . "/{$dir}/{$file_name}-{$variant}.{$ext}" : false,
						STYLESHEETPATH . "/{$dir}/{$file_name}.{$ext}",
						$variant ? TEMPLATEPATH . "/{$dir}/{$file_name}-{$variant}.{$ext}" : false,
						TEMPLATEPATH . "/{$dir}/{$file_name}.{$ext}",
					];

					$paths = apply_filters( 'ncb_locate_file_paths', array_filter( $paths ) );

					foreach ( (array) $paths as $path ) {
						if ( file_exists( $path ) && is_readable( $path ) ) {
							$located = $path;
							break;
						}
					}

					$cache[ $cache_name ] = $located;
					$container->set( 'ncb:locate_file', $cache );
				}
			}

			return $located;
		}

		protected function render_file( string $file_name, array $context = [], bool $echo = true ): string {
			if ( file_exists( $file_name ) && is_readable( $file_name ) ) {
				if ( ! empty( $context ) ) {
					extract( $context, EXTR_SKIP );
				}

				if ( ! $echo ) {
					ob_start();
				}

				include $file_name;

				if ( ! $echo ) {
					return ob_get_clean();
				}
			}

			return '';
		}

		protected function enqueue_ejs( string $relpath, array $context = [], string $variant = '' ): void {
			$ejs_queue = hws()->get( 'ejs_queue' );

			if ( ! $ejs_queue ) {
				$ejs_queue = new NCB_EJS_Queue();
				hws()->set( 'ejs_queue', $ejs_queue );
			}

			$ejs_queue->enqueue( $relpath . ( $variant ? "-{$variant}" : '' ), compact( 'context', 'variant' ) );
		}

		/**
		 * Render a template file.
		 *
		 * @param string $relpath Relative path to the theme. Do not append file extension.
		 * @param array  $context Context array.
		 * @param string $variant Variant slug.
		 * @param bool   $echo
		 * @param string $ext
		 *
		 * @return string
		 */
		protected function template(
			string $relpath,
			array $context = [],
			string $variant = '',
			bool $echo = true,
			string $ext = 'php'
		): string {
			return $this->render_file(
				$this->locate_file( 'template', $relpath, $variant, $ext ),
				$context,
				$echo
			);
		}
	}
}
