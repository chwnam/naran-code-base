<?php
/**
 * Naran Code Base: Reg (Registerer) for metadata.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class_alias( NCB_Reg_Item_Meta::class, 'NCB_Meta' );

if ( ! class_exists( 'NCB_Reg_Meta' ) ) {
	/**
	 * Class NCB_Reg_Meta
	 */
	abstract class NCB_Reg_Meta extends NCB_Module implements NCB_Reg {
		use NCB_Hooks_Impl;

		/** @var array */
		private array $fields = [];

		protected function init() {
			$this->add_action( 'init', 'register' );
		}

		public function __get( string $alias ): ?NCB_Meta {
			if ( isset( $this->fields[ $alias ] ) ) {
				return NCB_Meta::factory( ...$this->fields[ $alias ] );
			} else {
				return null;
			}
		}

		public function register(): void {
			foreach ( $this->get_items() as $idx => $item ) {
				if ( $item instanceof NCB_Meta ) {
					if ( $item->sanitize_callback ) {
						$item->sanitize_callback = $this->get_container()->parse_callback( $item->sanitize_callback );
					}

					if ( $item->auth_callback ) {
						$item->auth_callback = $this->get_container()->parse_callback( $item->auth_callback );
					}

					$item->register();

					$alias = is_int( $idx ) ? $item->get_key() : $idx;

					$this->fields[ $alias ] = [
						$item->get_object_type(),
						$item->object_subtype,
						$item->get_key()
					];
				}
			}
		}
	}
}
