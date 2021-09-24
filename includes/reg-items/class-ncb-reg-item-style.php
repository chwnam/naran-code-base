<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Reg_Item_Style' ) ) {
	class NCB_Reg_Item_Style implements NCB_Reg_Item {
		public string $handle;

		public string $src;

		public array $deps;

		/** @var bool|null|string| */
		public $ver;

		public string $media;

		public function __construct(
			string $handle,
			string $src,
			array $deps = [],
			$ver = null,
			$media = 'all'
		) {
			$this->handle = $handle;
			$this->src    = $src;
			$this->deps   = $deps;
			$this->ver    = $ver;
			$this->media  = $media;
		}

		public function register() {
			if ( $this->handle && $this->src ) {
				wp_register_style( $this->handle, $this->src, $this->deps, $this->ver, $this->media );
			}
		}
	}
}
