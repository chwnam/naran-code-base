<?php
/**
 * Naran Code Base: Reg (Registerer) interface.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'NCB_Reg' ) ) {
	interface NCB_Reg {
		public function register();

		public function get_items(): array;
	}
}
