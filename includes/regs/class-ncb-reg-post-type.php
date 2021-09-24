<?php
/**
 * Naran Code Base: Reg (Registerer) for custom post types.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Post_Type' ) ) {
	class NCB_Reg_Post_Type extends NCB_Module implements NCB_Reg {
		use NCB_Hooks_Impl;

		protected function init() {
			$this->add_action( 'init', 'register' );
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Reg_Item_Post_Type ) {
					$item->register();
				}
			}
		}

		public function get_items(): array {
			return ncb_include_file_array(
				$this->get_container()->get_root_path() . '/includes/reg-items/post-type.php'
			);
		}
	}
}
