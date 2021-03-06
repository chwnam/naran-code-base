<?php
/**
 * Naran Code Base: EJS Queue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Ejs_Queue' ) ) {
	class NCB_Ejs_Queue extends NCB_Module {
		use NCB_Render_Impl;

		private array $queue = [];

		protected function init() {
			if ( is_admin() ) {
				if ( ! has_action( 'admin_print_footer_scripts', [ $this, 'do_template' ] ) ) {
					add_action( 'admin_print_footer_scripts', [ $this, 'do_template' ], 99999 );
				}
			} else {
				if ( ! has_action( 'wp_print_footer_scripts', [ $this, 'do_template' ] ) ) {
					add_action( 'wp_print_footer_scripts', [ $this, 'do_template' ], 99999 );
				}
			}
		}

		public function enqueue( string $relpath, array $data = [] ): void {
			$this->queue[ $relpath ] = $data;
		}

		public function do_template() {
			foreach ( $this->queue as $relpath => $data ) {
				$tmpl_id = 'tmpl-' . pathinfo( wp_basename( $relpath ), PATHINFO_FILENAME );
				$content = $this->render_file(
					$this->locate_file( 'ejs', $relpath, $data['variant'], 'ejs' ),
					$data['context'],
					false
				);
				$content = preg_replace( '/\s+/', ' ', $content );
				$content = trim( str_replace( '> <', '><', $content ) );

				if ( ! empty( $content ) ) {
					echo "\n<script type='text/template' id='" . esc_attr( $tmpl_id ) . "'>\n";
					echo $content;
					echo "\n</script>\n";
				}
			}
		}
	}
}
