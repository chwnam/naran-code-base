<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Register_Term_Meta' ) ) {
	/**
	 * Class NCB_Register_Post_Meta
	 *
	 * @property-read NCB_Meta $icon_class
	 * @property-read NCB_Meta $service_center_url
	 */
	class NCB_Register_Term_Meta extends NCB_Register_Meta {
		public function get_items(): Generator {
			yield 'icon_class' => new NCB_Meta(
				'term',
				'hws_icon_class',
				[
					'object_subtype'    => 'hws_case_study_cat',
					'type'              => 'string',
					'description'       => '프로젝트 사례 아이콘 CSS 클래스',
					'default'           => '',
					'single'            => true,
					'sanitize_callback' => 'sanitize_html_class',
				]
			);

			yield 'service_center_url' => new NCB_Meta(
				'term',
				'hws_service_center_url',
				[
					'object_subtype'    => 'hws_service_center_loc',
					'type'              => 'string',
					'description'       => '서비스 센터 대분류 URL. ACF 에서 폼을 지원.',
					'default'           => '',
					'single'            => true,
					'sanitize_callback' => 'esc_url_raw',
				]
			);
		}
	}
}
