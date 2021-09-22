<?php
/**
 * Naran Code Base: Container Interface
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'NCB_Container_Interface' ) ) {
	interface NCB_Container_Interface {
		public function activation();

		public function deactivation();

		public function initialize();

		public function get( string $key, $default = null );

		public function set( string $key, $value );

		public function get_default_priority(): int;

		public function get_id(): string;

		public function get_version(): string;
	}
}
