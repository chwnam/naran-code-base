<?php
/**
 * Naran Code Base: Reg (Registerer) for term meta.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Term_Meta' ) ) {
	/**
	 * Class NCB_Reg_Term_Meta
	 */
	class NCB_Reg_Term_Meta extends NCB_Reg_Meta {
		public function get_items(): array {
			return ncb_include_file_array(
				$this->get_container()->get_root_path() . '/includes/reg-items/term-meta.php'
			);
		}
	}
}
