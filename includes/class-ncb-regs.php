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

			$classes = [
				'admin_post' => NCB_Reg_Admin_Post::class,
				'ajax'       => NCB_Reg_Ajax::class,
				'option'     => NCB_Reg_Option::class,
				'post_type'  => NCB_Reg_Post_Type::class,
				'script'     => NCB_Reg_Script::class,
				'shortcode'  => NCB_Reg_Shortcode::class,
				'style'      => NCB_Reg_Style::class,
				'post_meta'  => NCB_Reg_Post_Meta::class,
				'taxonomy'   => NCB_Reg_Taxonomy::class,
				'term_meta'  => NCB_Reg_Term_Meta::class,
			];

			$modules = [];

			foreach ( $supports as $support ) {
				if ( isset( $classes[ $support ] ) ) {
					$modules[ $support ] = $classes[ $support ];
				}
			}

			$this->init_modules( $modules );
		}
	}
}
