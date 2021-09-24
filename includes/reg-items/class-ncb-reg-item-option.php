<?php
/**
 * Naran Code Base: Reg (Registerer) item for options.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Item_Option' ) ) {
	/**
	 * Class NCB_Reg_Item_Option
	 *
	 * @property string        $type
	 * @property string        $group
	 * @property string        $description
	 * @property callable|null $sanitize_callback
	 * @property bool          $show_in_rest
	 * @property mixed         $default
	 */
	class NCB_Reg_Item_Option implements NCB_Reg_Item {
		private static array $options = [];

		private string $option_group;

		private string $option_name;

		private array $args;

		public static function factory( string $option_name ): ?NCB_Reg_Item_Option {
			global $wp_registered_settings;

			if ( isset( $wp_registered_settings[ $option_name ] ) ) {
				if ( ! isset( static::$options[ $option_name ] ) ) {
					$args = $wp_registered_settings[ $option_name ];

					static::$options[ $option_name ] = new NCB_Reg_Item_Option(
						$args['group'],
						$option_name,
						$args['autoload']
					);
				}

				return static::$options[ $option_name ];
			}

			return null;
		}

		public function __construct( string $option_group, string $option_name, bool $autoload, array $args = [] ) {
			$this->option_group = $option_group;
			$this->option_name  = $option_name;
			$this->args         = wp_parse_args(
				$args,
				[
					'type'              => 'string',
					'group'             => $this->option_group,
					'description'       => '',
					'sanitize_callback' => null,
					'show_in_rest'      => false,
					'default'           => '',
					'autoload'          => $autoload,
				]
			);
		}

		/**
		 * @param string $prop
		 *
		 * @return mixed|null
		 */
		public function __get( string $prop ) {
			if ( 'group' === $prop ) {
				return $this->option_group;
			}

			return $this->args[ $prop ] ?? null;
		}

		/**
		 * @param string $prop
		 * @param mixed  $value
		 */
		public function __set( string $prop, $value ) {
			$this->args[ $prop ] = $value;
		}

		public function register() {
			if ( $this->option_group && $this->option_name ) {

				register_setting( $this->option_group, $this->option_name, $this->args );
			}
		}

		public function get_option_group(): string {
			return $this->option_group;
		}

		public function get_option_name(): string {
			return $this->option_name;
		}

		public function get_value( $default = false ) {
			if ( func_num_args() > 0 ) {
				return get_option( $this->get_option_name(), $default );
			} else {
				return get_option( $this->get_option_name() );
			}
		}

		public function is_autoload(): bool {
			return $this->args['autoload'];
		}

		public function update( $value ): bool {
			return update_option( $this->get_option_name(), $value, $this->is_autoload() );
		}

		public function update_from_request(): bool {
			if ( isset( $_REQUEST[ $this->get_option_name() ] ) && is_callable( $this->sanitize_callback ) ) {
				return $this->update( $_REQUEST[ $this->get_option_name() ] );
			}

			return false;
		}

		public function delete(): bool {
			return delete_option( $this->get_option_name() );
		}
	}
}
