<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Register_Post_Meta' ) ) {
	/**
	 * Class NCB_Register_Post_Meta
	 *
	 * @property-read NCB_Meta $faq_karma
	 * @property-read NCB_Meta $related_products
	 */
	class NCB_Register_Post_Meta extends NCB_Register_Meta {
		public function get_items(): Generator {
			yield 'faq_karma' => new NCB_Meta(
				'post',
				'hws_faq_karma',
				[
					'object_subtype'    => 'hws_faq',
					'type'              => 'integer',
					'description'       => 'F.A.Q 페이지 \'도움이 되었습니다\' 클릭 수 기록.',
					'default'           => 0,
					'single'            => true,
					'sanitize_callback' => 'absint'
				]
			);

			yield 'related_products' => new NCB_Meta(
				'post',
				'hws_news_center_related_products',
				[
					'object_subtype'    => '',
					'type'              => 'array',
					'description'       => '뉴스 센터의 연관 상품 목록.',
					'default'           => [],
					'single'            => true,
					'sanitize_callback' => function ( $input ) {
						$output = [];

						if ( is_array( $input ) ) {
							foreach ( $input as $item ) {
								$output[] = [
									'model'         => sanitize_text_field( $item['model'] ?? '' ),
									'code'          => sanitize_text_field( $item['code'] ?? '' ),
									'name'          => sanitize_text_field( $item['name'] ?? '' ),
									'url'           => esc_url_raw( $item['url'] ?? '' ),
									'thumbnail_url' => esc_url_raw( $item['thumbnail_url'] ?? '' ),
								];
							}
						}

						return $output;
					}
				]
			);
		}
	}
}
