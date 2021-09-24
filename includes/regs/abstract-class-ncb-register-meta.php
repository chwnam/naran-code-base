<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class_alias( NCB_Registrable_Meta::class, 'NCB_Meta' );

if ( ! class_exists( 'NCB_Register_Meta' ) ) {
	/**
	 * Class NCB_Register_Meta
	 */
	abstract class NCB_Register_Meta implements NCB_Register {
		use NCB_Hooks_Impl;

		/**
		 * @var array<string, string[]>
		 */
		private array $fields = [];

		public function __construct() {
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
