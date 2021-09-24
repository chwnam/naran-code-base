<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Layout_Plugin' ) ) {
	class NCB_Layout_Plugin extends NCB_Module implements NCB_Layout {
		private string $main_file;

		private string $version;

		public function __construct( NCB_Container $container, string $main_file, string $version = '' ) {
			parent::__construct( $container );

			$this->main_file = $main_file;
			$this->version   = $version;

			register_activation_hook( $this->get_main_file(), [ $this, 'activation' ] );
			register_deactivation_hook( $this->get_main_file(), [ $this, 'deactivation' ] );
		}

		public function get_main_file(): string {
			return $this->main_file;
		}

		public function activation() {
			do_action( 'ncb_activation', $this->get_container()->get_id() );
		}

		public function deactivation() {
			do_action( 'ncb_deactivation', $this->get_container()->get_id() );
		}

		public function get_root_path(): string {
			return plugin_dir_path( $this->get_main_file() );
		}

		public function get_root_path_uri(): string {
			return plugin_dir_url( $this->get_main_file() );
		}

		public function get_template_paths( string $relpath, string $variant, string $ext ): array {
			$id   = $this->get_container()->get_id();
			$path = $this->get_root_path();

			$dirname = dirname( $relpath );
			if ( empty( $dirname ) ) {
				$dirname = '.';
			}

			$file_name = wp_basename( $relpath );

			$paths = [
				$variant ? STYLESHEETPATH . "/{$id}/{$file_name}-{$variant}.{$ext}" : false,
				STYLESHEETPATH . "/{$id}/{$file_name}.{$ext}",
				$variant ? TEMPLATEPATH . "/{$id}/{$file_name}-{$variant}.{$ext}" : false,
				TEMPLATEPATH . "/{$id}/{$file_name}.{$ext}",
				$variant ? "{$path}includes/templates/{$dirname}/{$file_name}-{$variant}.{$ext}" : false,
				"{$path}includes/templates/{$dirname}/{$file_name}.{$ext}",
			];

			return apply_filters( 'ncb/layout/template_paths', array_filter( $paths ), $this->get_container()->get_id() );
		}

		public function get_version(): string {
			return $this->version;
		}
	}
}
