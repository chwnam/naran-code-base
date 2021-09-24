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

		private array $reg_supports;

		private ?NCB_Layout $layout;

		private array $module_notations;

		public function __construct( string $id ) {
			$this->id               = $id;
			$this->priority         = 10;
			$this->version          = '';
			$this->storage          = [];
			$this->reg_supports     = [];
			$this->layout           = null;
			$this->module_notations = [];
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
			} elseif ( 'theme' === $type ) {
				$this->layout = new NCB_Layout_Theme( $this );
			}
			return $this;
		}

		public function set_reg_supports( string ...$args ): self {
			$this->reg_supports = array_map( 'sanitize_key', array_filter( $args ) );

			return $this;
		}

		public function get_root_path(): string {
			return $this->layout->get_root_path();
		}

		public function get_root_path_uri(): string {
			return $this->layout->get_root_path_uri();
		}

		public function get_template_paths( string $relpath, string $variant, string $ext ): array {
			return $this->layout->get_template_paths( $relpath, $variant, $ext );
		}

		public function get_registrable_items( string $type ) {
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

		/**
		 * Parse input string and turn it into a callable method, if possible.
		 *
		 * @param string|array|callable $maybe_callback
		 *
		 * @return array|callable|false
		 */
		public function parse_callback( $maybe_callback ) {
			if ( is_callable( $maybe_callback ) ) {
				return $maybe_callback;
			} elseif ( is_string( $maybe_callback ) && false !== strpos( $maybe_callback, '@' ) ) {
				[ $module_part, $method ] = explode( '@', $maybe_callback, 2 );

				$module = $this->parse_module( $module_part );

				if ( $module && method_exists( $module, $method ) ) {
					$callback = [ $module, $method ];
				} else {
					$callback = false;
				}

				return $callback;
			}

			return false;
		}

		/**
		 * @param string $module_notation
		 *
		 * @return NCB_Module|false;
		 */
		public function parse_module( string $module_notation ) {
			if ( class_exists( $module_notation ) && is_subclass_of( $module_notation, NCB_Module::class ) ) {
				return new $module_notation( $this );
			} elseif ( $module_notation ) {
				if ( ! isset( $this->module_notations[ $module_notation ] ) ) {
					$module = $this;
					foreach ( explode( '.', $module_notation ) as $crumb ) {
						if ( isset( $module->{$crumb} ) ) {
							$module = $module->{$crumb};
						} else {
							$module = false;
							break;
						}
					}
					$this->module_notations[ $module_notation ] = $module;
				}
				return $this->module_notations[ $module_notation ];
			}

			return false;
		}

		public function initialize( array $modules = [] ) {
			if ( ! $this->layout ) {
				wp_die( 'Layout is not assigned.' );
			}

			if ( ! empty( $this->reg_supports ) ) {
				$modules['_reg'] = new NCB_Regs( $this->get_container(), $this->reg_supports );
			}

			$this->init_modules( $modules );

			do_action( 'ncb_initialized', $this->get_id() );
		}
	}
}
