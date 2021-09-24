<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Module' ) ) {
	class NCB_Module {
		private NCB_Container $container;

		public function __construct( NCB_Container $container ) {
			$this->container = $container;
			$this->init();
		}

		public function get_container(): NCB_Container {
			return $this->container;
		}

		protected function init() {
		}
	}
}
