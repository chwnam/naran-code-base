<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'NCB_Submodules_Trait' ) ) {
	trait NCB_Submodules_Trait {
		private array $modules = [];

		/**
		 * Get submodule by name.
		 *
		 * @param string $name
		 *
		 * @return mixed|null
		 */
		public function __get( string $name ) {
			$module = $this->modules[ $name ] ?? null;

			if ( $module instanceof Closure ) {
				$this->modules[ $name ] = $module = $module();
			}

			return $module;
		}

		/**
		 * Check if submodule exists
		 *
		 * @param string $name
		 *
		 * @return bool
		 */
		public function __isset( string $name ): bool {
			return isset( $this->modules[ $name ] );
		}

		/**
		 * Block __set() magic method.
		 *
		 * @param string $name
		 * @param mixed  $value
		 */
		public function __set( string $name, $value ) {
			throw new RuntimeException( 'Module assignment is not allowed.' );
		}

		/**
		 * Assign modules.
		 *
		 * @param array $modules
		 */
		protected function init_modules( array $modules ) {
			$container     = method_exists( $this, 'get_container' ) ? $this->get_container() : null;
			$this->modules = $modules;

			foreach ( $this->modules as $idx => $module ) {
				if ( is_string( $module ) && class_exists( $module ) ) {
					if ( $module instanceof NCB_Module_Interface && $container ) {
						$this->modules[ $idx ] = new $module( $container );
					} else {
						$this->modules[ $idx ] = new $module();
					}
				}
			}
		}
	}
}