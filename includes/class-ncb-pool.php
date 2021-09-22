<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Pool' ) ) {
	final class NCB_Pool {
		private static ?NCB_Pool $instance = null;

		private array $containers;

		public static function get_instance(): NCB_Pool {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		private function __construct() {
			$this->containers = [];
		}

		public function get( string $id ) {
			if ( ! isset( $this->containers[ $id ] ) ) {
				$this->containers[ $id ] = new NCB_Container( $id );
			}
			return $this->containers[ $id ];
		}
	}
}
