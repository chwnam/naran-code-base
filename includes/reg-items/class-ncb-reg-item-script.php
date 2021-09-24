<?php
/**
 * Naran Code Base: Reg (Registerer) Item for JavaScript files.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Item_Script' ) ) {
	class NCB_Reg_Item_Script implements NCB_Reg_Item {
		public string $handle;

		public string $src;

		public array $deps;

		/** @var string|bool|null */
		public $ver;

		public bool $in_footer;

		public function __construct(
			string $handle,
			string $src,
			array $deps = [],
			$ver = null,
			$in_footer = false
		) {
			$this->handle    = $handle;
			$this->src       = $src;
			$this->deps      = $deps;
			$this->ver       = $ver;
			$this->in_footer = $in_footer;
		}

		public function register() {
			if ( $this->handle && $this->src ) {
				wp_register_script( $this->handle, $this->src, $this->deps, $this->ver, $this->in_footer );
			}
		}
	}
}
