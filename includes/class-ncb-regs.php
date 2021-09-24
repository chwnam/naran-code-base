<?php
/**
 * Naran Code Base: Reg (Registerer) Group container module.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Regs' ) ) {
	class NCB_Regs extends NCB_Module {
		use NCB_Submodule_Impl;

		public function __construct( NCB_Container $container, array $supports ) {
			parent::__construct( $container );

			$modules = [];

			foreach ( $supports as $support ) {
				switch ( $support ) {
					case 'ajax':
						$modules['ajax'] = NCB_Reg_Ajax::class;
						break;

					case 'script':
						$modules['script'] = NCB_Reg_Script::class;
						break;

					case 'shortcode':
						$modules['shortcode'] = NCB_Reg_Shortcode::class;
						break;

					case 'style':
						$modules['style'] = NCB_Reg_Style::class;
						break;
				}
			}

			$this->init_modules( $modules );
		}
	}
}
