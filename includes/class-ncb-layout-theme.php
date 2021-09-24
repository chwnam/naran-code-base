<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Layout_Theme' ) ) {
	class NCB_Layout_Theme extends NCB_Module implements NCB_Layout {
		use NCB_Hooks_Impl;

		private WP_Theme $theme;

		public function __construct( NCB_Container $container ) {
			parent::__construct( $container );

			$this->theme = wp_get_theme();

			$this
				->add_action( 'after_switch_theme', 'activation' )
				->add_action( 'switch_theme', 'deactivation' )
			;
		}

		public function activation() {
			do_action( 'ncb_activation', $this->get_container()->get_id() );
		}

		public function deactivation() {
			do_action( 'ncb_deactivation', $this->get_container()->get_id() );
		}

		public function get_root_path(): string {
			return get_stylesheet_directory();
		}

		public function get_root_path_uri(): string {
			return get_stylesheet_directory_uri();
		}

		public function get_template_paths( string $relpath, string $variant, string $ext ): array {
			$dirname   = dirname( $relpath );
			$file_name = wp_basename( $relpath );

			$paths = [
				$variant ? STYLESHEETPATH . "/{$dirname}/{$file_name}-{$variant}.{$ext}" : false,
				STYLESHEETPATH . "/{$dirname}/{$file_name}.{$ext}",
				$variant ? TEMPLATEPATH . "/{$dirname}/{$file_name}-{$variant}.{$ext}" : false,
				TEMPLATEPATH . "/{$dirname}/{$file_name}.{$ext}",
			];

			return apply_filters( 'ncb/layout/template_paths', array_filter( $paths ), $this->get_container()->get_id() );
		}

		public function get_version(): string {
			return $this->theme->get( 'version' ) ?: '';
		}
	}
}