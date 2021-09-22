<?php
/**
 * Naran Code Base: Container.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CLASSNAME' ) ) {
	class NCB_Container {
		use NCB_Submodule_Impl;

		private string $id;

		private int $priority;

		private string $version;

		private array $storage;

		private $layout;

		public function __construct( string $id ) {
			$this->id       = $id;
			$this->priority = 10;
			$this->version  = '';
			$this->storage  = [];
			$this->layout   = null;
		}

		public function get_container(): self {
			return $this;
		}

		public function get_id(): string {
			return $this->id;
		}

		public function get_priority(): int {
			return $this->priority;
		}

		public function set_priority( int $priority ): self {
			$this->priority = $priority;
			return $this;
		}

		public function set_layout( string $type, ...$args ): self {
			if ( 'plugin' === $type ) {
				$this->layout = new NCB_Layout_Plugin( $this, ...$args );
			}
			return $this;
		}

		public function get_template_paths( string $relpath, string $variant, string $ext ): array {
			return $this->layout->get_template_paths( $relpath, $variant, $ext );
		}

		public function get_version(): string {
			return $this->layout->get_version();
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

		public function initialize( array $modules ) {
			$this->init_modules( $modules );

			do_action( 'ncb_initialized', $this->get_id() );
		}
	}
}
