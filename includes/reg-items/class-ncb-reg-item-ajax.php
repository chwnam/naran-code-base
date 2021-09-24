<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Item_Ajax' ) ) {
	class NCB_Reg_Item_Ajax implements NCB_Reg_Item {
		/** @var string */
		public string $action;

		/** @var string|callable */
		public $callback;

		/** @var string|bool */
		public $allow_nopriv;

		public bool $is_wc_ajax;

		public int $priority;

		public function __construct(
			string $action,
			$callback,
			$allow_nopriv = false,
			bool $is_wc_ajax = false,
			int $priority = null
		) {
			$this->action       = $action;
			$this->callback     = $callback;
			$this->allow_nopriv = $allow_nopriv;
			$this->is_wc_ajax   = $is_wc_ajax;
			$this->priority     = $priority;
		}

		public function register() {
			$dispatch = func_get_arg( 0 );

			if ( $this->action && $this->callback ) {
				if ( $this->is_wc_ajax ) {
					add_action( "wc_ajax_{$this->action}", $dispatch, $this->priority );
				} else {
					if ( 'only_nopriv' !== $this->allow_nopriv ) {
						add_action( "wp_ajax_{$this->action}", $dispatch, $this->priority );
					}
					if ( true === $this->allow_nopriv || 'only_nopriv' === $this->allow_nopriv ) {
						add_action( "wp_ajax_nopriv_{$this->action}", $dispatch, $this->priority );
					}
				}
			}
		}
	}
}
