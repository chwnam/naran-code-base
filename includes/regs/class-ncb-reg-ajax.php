<?php
/**
 * Naran Code Base: Reg (Registerer) for AJAX.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_AJAX' ) ) {
	class NCB_Reg_AJAX extends NCB_Module implements NCB_Reg {
		use NCB_Hooks_Impl;

		private array $real_callbacks = [];

		public function __construct( NCB_Container $container ) {
			parent::__construct( $container );

			$this->add_action( 'init', 'register' );
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Reg_Item_AJAX ) {
					$this->real_callbacks[ $item->action ] = $item->callback;
					if ( is_null( $item->priority ) ) {
						$item->priority = $this->get_container()->get_priority();
					}
					$item->register( [ $this, 'dispatch' ] );
				}
			}
		}

		public function dispatch() {
			$action = $_REQUEST['action'] ?? '';
			if ( $action && isset( $this->real_callbacks[ $action ] ) ) {
				$callback = $this->get_container()->parse_callback( $this->real_callbacks[ $action ] );
				if ( is_callable( $callback ) ) {
					call_user_func( $callback );
				}
			}
		}

		public function get_items(): array {
			return ncb_include_file_array(
				$this->get_container()->get_root_path() . '/includes/reg-items/ajax.php'
			);
		}
	}
}
