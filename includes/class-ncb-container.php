<?php
/**
 * Naran Code Base: Container.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CLASSNAME' ) ) {
	class NCB_Container implements NCB_Container_Interface, NCB_Module_Interface {
		use NCB_Submodules_Trait;

		private int $default_priority;

		private string $id;

		private array $storage = [];

		private string $version;

		public function __construct( array $args = [] ) {
			$default = [
				'default_priority' => 10,
				'id'               => '',
				'modules'          => [],
				'type'             => 'plugin',
				'version'          => '',
			];

			$args = wp_parse_args( $args, $default );

			$this->default_priority = intval( $args['default_priority'] );
			$this->id               = strval( $args['id'] );
			$this->modules          = (array) $args['modules'];
			$this->version          = strval( $args['version'] );
		}

		public function get( string $key, $default = null ) {
			return $this->storage[ $key ] ?? $default;
		}

		public function set( string $key, $value ) {
			if ( is_null( $value ) ) {
				unset( $this->storage[ $key ] );
			} else {
				$this->storage[ $key ] = $value;
			}
		}

		public function activation() {
			do_action( 'ncb_activation' );
		}

		public function deactivation() {
			do_action( 'ncb_activation' );
		}

		public function get_default_priority(): int {
			return $this->default_priority;
		}

		public function get_container(): NCB_Container_Interface {
			return $this;
		}

		public function get_id(): string {
			return $this->id;
		}

		public function get_version(): string {
			return $this->version;
		}

		public function initialize() {
			$this->init_modules( $this->modules );

			do_action( 'ncb_loaded', $this->get_container() );
		}

		/**
		 * @param NCB_Container_Interface $container
		 *
		 * @throws Exception
		 */
		public function set_container( NCB_Container_Interface $container ) {
			throw new Exception( 'Container assignment is impossible.' );
		}
	}
}
