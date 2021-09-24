<?php
/**
 * Naran Code Base: Reg Item interface.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'NCB_Reg_Item' ) ) {
	interface NCB_Reg_Item {
		public function register();
	}
}
