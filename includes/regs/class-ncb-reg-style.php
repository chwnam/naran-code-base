<?php
/**
 * Naran Code Base: Reg (Registerer) for CSS stylesheets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Style' ) ) {
	class NCB_Reg_Style extends NCB_Module implements NCB_Reg {
		use NCB_Hooks_Impl;

		public function __construct( NCB_Container $container ) {
			parent::__construct( $container );

			$this
				->add_action( 'init', 'register' )
			;
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Reg_Item_Style ) {
					if ( is_null( $item->ver ) ) {
						$item->ver = $this->get_container()->get_version();
					}
					$item->register();
				}
			}
		}

		public function get_items(): array {
			return ncb_include_file_array( $this->get_container()->get_root_path() . '/includes/reg-items/style.php' );
		}
	}
}
