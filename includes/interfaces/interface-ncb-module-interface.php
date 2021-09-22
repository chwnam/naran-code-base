<?php
/**
 * Naran Code Base: Module Interface
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'NCB_Module_Interface' ) ) {
	interface NCB_Module_Interface {
		public function get_container(): NCB_Container_Interface;

		public function set_container( NCB_Container_Interface $container );
	}
}
