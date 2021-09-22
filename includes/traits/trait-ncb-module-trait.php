<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'NCB_Module_Trait' ) ) {
	trait NCB_Module_Trait {
		private NCB_COntainer $container;

		public function __construct( NCB_Container_Interface $container ) {
			$this->set_container( $container );
		}

		public function get_container(): NCB_Container_Interface {
			return $this->container;
		}

		/**
		 * @param NCB_Container_Interface $container
		 */
		public function set_container( NCB_Container_Interface $container ) {
			$this->container = $container;
		}
	}
}