<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'NCB_Submodule_Impl' ) ) {
	trait NCB_Submodule_Impl {
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
			$this->modules = $modules;

			foreach ( $this->modules as $idx => $module ) {
				if ( is_string( $module ) && is_subclass_of( $module, NCB_Module::class ) ) {
					$this->modules[ $idx ] = new $module( $this->get_container() );
				}
			}
		}
	}
}
