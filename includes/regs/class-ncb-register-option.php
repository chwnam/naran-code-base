<?php
/**
 * Option register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class_alias( NCB_Registrable_Option::class, 'NCB_Option' );

if ( ! class_exists( 'NCB_Register_Option' ) ) {
	/**
	 * Class NCB_Register_Option
	 *
	 * @property-read NCB_Option $lang_code
	 * @property-read NCB_Option $nat_code
	 */
	class NCB_Register_Option implements NCB_Register {
		use NCB_Hooks_Impl;

		/**
		 * @var array<string, string>
		 */
		private array $fields = [];

		public function __construct() {
			$this->add_action( 'init', 'register' );
		}

		public function __get( string $alias ): ?NCB_Option {
			if ( isset( $this->fields[ $alias ] ) ) {
				return NCB_Option::factory( $this->fields[ $alias ] );
			} else {
				return null;
			}
		}

		public function register() {
			foreach ( $this->get_items() as $idx => $item ) {
				if ( $item instanceof NCB_Option ) {
					$item->register();
					$this->fields[ is_int( $idx ) ? $item->get_option_name() : $idx ] = $item->get_option_name();
				}
			}
		}

		/**
		 * @return Generator
		 */
		public function get_items(): Generator {
			yield 'lang_code' => new NCB_Option(
				'hws_settings',
				'hws_api_language_code',
				false, // autoload
				[
					'type'              => 'array',
					'description'       => '',
					'sanitize_callback' => function ( $value ) {
						return hws()->api_handler->sanitize_language_codes( $value );
					},
					'show_in_rest'      => false,
					'default'           => [],
				]
			);

			yield 'nat_code' => new NCB_Option(
				'hws_settings',
				'hws_api_national_code',
				false, // autoload
				[
					'type'              => 'array',
					'description'       => '',
					'sanitize_callback' => function ( $value ) {
						return hws()->api_handler->sanitize_national_codes( $value );
					},
					'show_in_rest'      => false,
					'default'           => [],
				]
			);
		}
	}
}
