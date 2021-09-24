<?php
/**
 * Naran Code Base: Render trait
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'NCB_Render_Impl' ) ) {
	trait NCB_Render_Impl {
		/**
		 * @param string $tmpl_type
		 * @param string $relpath
		 * @param string $variant
		 * @param string $ext
		 *
		 * @return false|string
		 */
		protected function locate_file(
			string $tmpl_type,
			string $relpath,
			string $variant = '',
			string $ext = 'php'
		) {
			$located = false;

			$tmpl_type = trim( $tmpl_type, '\\/' );
			$relpath   = trim( $relpath, '\\/' );
			$variant   = sanitize_key( $variant );
			$ext       = ltrim( $ext, '.' );

			$cache_name = "{$tmpl_type}:{$relpath}:{$variant}";
			$cache      = $this->get_container()->get( 'ncb:located_files', [] );

			if ( array_key_exists( $cache_name, $cache ) ) {
				$located = $cache[ $cache_name ];
			} else {
				$paths = $this->get_container()->get_template_paths( $relpath, $variant, $ext );

				foreach ( $paths as $path ) {
					if ( file_exists( $path ) && is_readable( $path ) ) {
						$located = $path;
						break;
					}
				}

				$cache[ $cache_name ] = $located;
				$this->get_container()->set( 'ncb:located_files', $cache );
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
			$ejs = $this->get_container()->get( 'ncb:ejs' );

			if ( ! $ejs ) {
				$ejs = new NCB_EJS_Queue( $this->get_container() );
				$this->get_container()->set( 'ncb:ejs', $ejs );
			}

			$ejs->enqueue( $relpath . ( $variant ? "-{$variant}" : '' ), compact( 'context', 'variant' ) );
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
