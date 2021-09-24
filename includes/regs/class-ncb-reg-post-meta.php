<?php
/**
 * Naran Code Base: Reg (Registerer) for post meta.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Post_Meta' ) ) {
	/**
	 * Class NCB_Register_Post_Meta
	 */
	class NCB_Reg_Post_Meta extends NCB_Reg_Meta {
		public function get_items(): array {
			return ncb_include_file_array(
				$this->get_container()->get_root_path() . '/includes/reg-items/post-meta.php'
			);
		}
	}
}
