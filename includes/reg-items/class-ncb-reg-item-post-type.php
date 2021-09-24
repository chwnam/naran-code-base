<?php
/**
 * Naran Code Base: Reg (Registerer) item for custom post types.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Item_Post_Type' ) ) {
	class NCB_Reg_Item_Post_Type implements NCB_Reg_Item {
		public string $post_type;

		public array $args;

		public function __construct( string $post_type, array $args ) {
			$this->post_type = $post_type;
			$this->args      = $args;
		}

		public function register() {
			if ( ! post_type_exists( $this->post_type ) ) {
				$return = register_post_type( $this->post_type, $this->args );
				if ( is_wp_error( $return ) ) {
					wp_die( $return );
				}
			}
		}
	}
}
