<?php
/**
 * Taxonomy register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Taxonomy' ) ) {
	class NCB_Reg_Taxonomy extends NCB_Module implements NCB_Reg {
		use NCB_Hooks_Impl;

		protected function init() {
			$this->add_action( 'init', 'register' );
		}

		/**
		 * Register all defined taxonomies.
		 *
		 * @callback
		 * @action    init
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Reg_Item_Taxonomy ) {
					$item->register();
				}
			}
		}

		/**
		 * Return all taxonomy registrable objects.
		 *
		 * @return array
		 */
		public function get_items(): array {
			return ncb_include_file_array(
				$this->get_container()->get_root_path() . '/includes/reg-items/taxonomy.php'
			);
		}
	}
}

