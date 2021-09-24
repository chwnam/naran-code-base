<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Registrable_Submit' ) ) {
	class NCB_Registrable_Submit implements NCB_Registrable {
		/** @var string */
		public string $action;

		/** @var string|callable */
		public $callback;

		/** @var string|bool */
		public $allow_nopriv;

		public int $priority;

		public function __construct(
			string $action,
			$callback,
			$allow_nopriv = false,
			?int $priority = null
		) {
			$this->action       = $action;
			$this->callback     = $callback;
			$this->allow_nopriv = $allow_nopriv;
			$this->priority     = is_null( $priority ) ? hws()->get_priority() : $priority;
		}

		public function register() {
			$dispatch = func_get_arg( 0 );

			if ( $this->action && $this->callback ) {
				if ( 'only_nopriv' !== $this->allow_nopriv ) {
					add_action( "admin_post_{$this->action}", $dispatch, $this->priority );
				}
				if ( true === $this->allow_nopriv || 'only_nopriv' === $this->allow_nopriv ) {
					add_action( "admin_post_nopriv_{$this->action}", $dispatch, $this->priority );
				}
			}
		}
	}
}
