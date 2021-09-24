<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Register_Submit' ) ) {
	class NCB_Register_Submit implements NCB_Register {
		use NCB_Hooks_Impl;

		private array $real_callbacks = [];

		public function __construct() {
			$this->add_action( 'init', 'register' );
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Registrable_Submit ) {
					$this->real_callbacks[ $item->action ] = $item->callback;
					$item->register( [ $this, 'dispatch' ] );
				}
			}
		}

		public function dispatch() {
			$action = $_REQUEST['action'] ?? '';
			if ( $action && isset( $this->real_callbacks[ $action ] ) ) {
				$callback = hws_parse_callback( $this->real_callbacks[ $action ] );
				if ( is_callable( $callback ) ) {
					call_user_func( $callback );
				}
			}
		}

		public function get_items(): Generator {
			/**
			 * Webinar enrollment
			 *
			 * @see  template-parts/tmpl/webinar-enrollment.php
			 * @uses NCB_Tmpl_Webinar_Enrollment::response_webinar_enrollment()
			 */
			yield new NCB_Registrable_Submit(
				'hws_webinar_enrollment',
				'tmpl.webinar_enrollment@response_webinar_enrollment',
				true
			);
		}
	}
}
