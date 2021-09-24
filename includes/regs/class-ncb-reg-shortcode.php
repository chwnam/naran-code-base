<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Shortcode' ) ) {
	class NCB_Reg_Shortcode extends NCB_Module implements NCB_Reg {
		use NCB_Hooks_Impl;

		private array $real_callbacks;

		private array $heading_actions;

		private array $found_tags;

		public function __construct( NCB_Container $container ) {
			parent::__construct( $container );

			$this
				->add_action( 'init', 'register' )
				->add_action( 'wp', 'handle_header_action' )
			;

			$this->real_callbacks  = [];
			$this->heading_actions = [];
			$this->found_tags      = [];
		}

		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Reg_Item_Shortcode ) {
					$item->register( [ $this, 'dispatch' ] );
					$this->real_callbacks[ $item->tag ] = $item->callback;
					if ( $item->heading_action ) {
						$this->heading_actions[ $item->tag ] = $item->heading_action;
					}
				}
			}
		}

		/**
		 * Unified shortcode callback.
		 *
		 * @param array|string $atts
		 * @param string       $enclosed
		 * @param string       $tag
		 *
		 * @return string
		 */
		public function dispatch( $atts, string $enclosed, string $tag ): string {
			if ( isset( $this->real_callbacks[ $tag ] ) ) {
				$callback = $this->get_container()->parse_callback( $this->real_callbacks[ $tag ] );
				if ( is_callable( $callback ) ) {
					return call_user_func_array( $callback, [ $atts, $enclosed, $tag ] );
				}
			}
			return '';
		}

		public function get_items(): array {
			return ncb_include_file_array(
				$this->get_container()->get_root_path() . '/includes/reg-items/shortcode.php'
			);
		}

		public function handle_header_action() {
			if ( is_singular() && ! empty( $this->heading_actions ) ) {
				$post = get_post();
				$this->find_shortcode( $post->post_content );

				foreach ( array_unique( $this->found_tags ) as $tag ) {
					$callback = $this->get_container()->parse_callback( $this->heading_actions[ $tag ] );
					if ( is_callable( $callback ) ) {
						call_user_func( $callback );
					}
				}
			}
		}

		private function find_shortcode( $content ) {
			if ( false === strpos( $content, '[' ) ) {
				return;
			}

			preg_match_all(
				'/' . get_shortcode_regex( array_keys( $this->heading_actions ) ) . '/',
				$content,
				$matches,
				PREG_SET_ORDER
			);

			if ( empty( $matches ) ) {
				return;
			}

			foreach ( $matches as $shortcode ) {
				if ( isset( $this->heading_actions[ $shortcode[2] ] ) ) {
					$this->found_tags[] = $shortcode[2];
				} elseif ( ! empty( $shortcode[5] ) ) {
					$this->find_shortcode( $shortcode[5] );
				}
			}
		}
	}
}
