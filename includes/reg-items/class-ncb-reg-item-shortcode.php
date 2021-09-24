<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Item_Shortcode' ) ) {
	class NCB_Reg_Item_Shortcode implements NCB_Reg_Item {
		public string $tag;

		/**
		 * @var string|callable
		 */
		public $callback;

		/**
		 * @var string|callable|null
		 */
		public $heading_action;

		/**
		 * @param string          $tag
		 * @param string|callable $callback
		 * @param null            $heading_action
		 */
		public function __construct( string $tag, $callback, $heading_action = null ) {
			$this->tag            = $tag;
			$this->callback       = $callback;
			$this->heading_action = $heading_action;
		}

		/**
		 * Dispatch method is passed by argument 0.
		 *
		 * @see NCB_Reg_Shortcode::register()
		 */
		public function register() {
			add_shortcode( $this->tag, func_get_arg( 0 ) );
		}
	}
}
