<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'CLASSNAME' ) ) {
	interface NCB_Layout {
		public function activation();

		public function deactivation();

		public function get_root_path(): string;

		public function get_root_path_uri(): string;

		public function get_template_paths( string $relpath, string $variant, string $ext ): array;

		public function get_version(): string;
	}
}