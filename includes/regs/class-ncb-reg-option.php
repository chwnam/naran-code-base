<?php
/**
 * Naran Code Base: Reg (Registerer) for options.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class_alias( NCB_Reg_Item_Option::class, 'NCB_Option' );

if ( ! class_exists( 'NCB_Reg_Option' ) ) {
	/**
	 * Class NCB_Register_Option
	 */
	class NCB_Reg_Option extends NCB_Module implements NCB_Reg {
		use NCB_Hooks_Impl;

		/** @var array<string, string> */
		private array $fields = [];

		protected function init() {
			$this->add_action( 'init', 'register' );
		}

		public function __get( string $alias ): ?NCB_Option {
			if ( isset( $this->fields[ $alias ] ) ) {
				return NCB_Option::factory( $this->fields[ $alias ] );
			} else {
				return null;
			}
		}

		public function register() {
			foreach ( $this->get_items() as $idx => $item ) {
				if ( $item instanceof NCB_Option ) {
					if ( $item->sanitize_callback ) {
						$item->sanitize_callback = $this->get_container()->parse_callback( $item->sanitize_callback );
					}

					$item->register();

					$alias = is_int( $idx ) ? $item->get_option_name() : $idx;

					$this->fields[ $alias ] = $item->get_option_name();
				}
			}
		}

		/**
		 * @return array
		 */
		public function get_items(): array {
			return ncb_include_file_array(
				$this->get_container()->get_root_path() . '/includes/reg-items/option.php'
			);
		}
	}
}
