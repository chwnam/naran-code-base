<?php
/**
 * Taxonomy register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Register_Taxonomy' ) ) {
	class NCB_Register_Taxonomy implements NCB_Register {
		use NCB_Hooks_Impl;

		public function __construct() {
			$this
				->add_action( 'init', 'register' )
				->add_action( 'hws_activation', 'add_initial_terms' )
			;
		}

		/**
		 * Register all defined taxonomies.
		 *
		 * @callback
		 * @action    init
		 */
		public function register() {
			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Registrable_Taxonomy ) {
					$item->register();
				}
			}
		}

		/**
		 * Create initial terms.
		 *
		 * @callback
		 * @action    hws_activation
		 */
		public function add_initial_terms() {
			$this->register();

			foreach ( $this->get_initial_terms() as $taxonomy => $terms ) {
				if ( taxonomy_exists( $taxonomy ) ) {
					foreach ( $terms as $term ) {
						if ( ! term_exists( $term['name'], $taxonomy ) ) {
							$p = $term['parent'] ?? false;
							if ( $p ) {
								$parent = get_term_by( 'slug', $p, $taxonomy );
							} else {
								$parent = false;
							}

							$t = wp_insert_term(
								$term['name'],
								$taxonomy,
								[
									'slug'        => $term['slug'],
									'description' => $term['description'],
									'parent'      => $parent ? $parent->term_id : 0,
								]
							);

							if ( ! is_wp_error( $t ) && isset( $term['meta'] ) && is_array( $term['meta'] ) ) {
								foreach ( $term['meta'] as $key => $value ) {
									if ( $key && $value ) {
										add_term_meta( $t['term_id'], $key, $value );
									}
								}
							}
						}
					}
				}
			}
		}

		/**
		 * Return all taxonomy registrable objects.
		 *
		 * @return Generator
		 */
		public function get_items(): Generator {
			// Taxonomy: Case Study.
			yield new NCB_Registrable_Taxonomy(
				'hws_case_study_cat',
				[ 'hws_case_study' ],
				[
					'labels'             => [
						'name'          => _x( 'Case study categories', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Case study category', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'Case study taxonomy.',
					'public'             => true,
					'publicly_queryable' => true,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => 'solutions/case-study',
						'with_front'   => false,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => true,
				]
			);

			yield new NCB_Registrable_Taxonomy(
				'hws_case_study_country',
				[ 'hws_case_study' ],
				[
					'labels'             => [
						'name'          => _x( 'Case study countries', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Case study country', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'Case study country taxonomy.',
					'public'             => false,
					'publicly_queryable' => false,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => false,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'with_front'   => false,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);

			// Taxonomy: Data center category.
			yield new NCB_Registrable_Taxonomy(
				'hws_data_center_cat',
				[ 'hws_data_center' ],
				[
					'labels'             => [
						'name'          => _x( 'Data center categories', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Data center category', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'Data center taxonomy.',
					'public'             => false,
					'publicly_queryable' => true,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => 'support/data-center',
						'with_front'   => true,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);

			// Taxonomy: F.A.Q. category.
			yield new NCB_Registrable_Taxonomy(
				'hws_faq_cat',
				[ 'hws_faq' ],
				[
					'labels'             => [
						'name'          => _x( 'F.A.Q categories', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'F.A.Q category', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'F.A.Q taxonomy.',
					'public'             => true,
					'publicly_queryable' => true,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => 'support/faq',
						'with_front'   => true,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => true,
				]
			);

			// Taxonomy: News center category. Defines its article sub-types.
			yield new NCB_Registrable_Taxonomy(
				'hws_news_center_cat',
				[ 'hws_news_center' ],
				[
					'labels'             => [
						'name'          => _x( 'News center categories', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'News center category', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'News center taxonomy.',
					'public'             => false,
					'publicly_queryable' => true,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => 'news-center',
						'with_front'   => true,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);

			// Taxonomy: Service center cat.
			yield new NCB_Registrable_Taxonomy(
				'hws_service_center_cat',
				[ 'hws_service_center' ],
				[
					'labels'             => [
						'name'          => _x( 'Service center categories', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Service center category', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'Service center category taxonomy.',
					'public'             => false,
					'publicly_queryable' => false,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => false,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => false,
						'with_front'   => false,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);

			// Taxonomy: Service center location.
			yield new NCB_Registrable_Taxonomy(
				'hws_service_center_loc',
				[ 'hws_service_center' ],
				[
					'labels'             => [
						'name'          => _x( 'Service center locations', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Service center location', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'News center taxonomy.',
					'public'             => false,
					'publicly_queryable' => false,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => false,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => false,
						'with_front'   => false,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);

			// Taxonomy: Video category
			yield new NCB_Registrable_Taxonomy(
				'hws_video_cat',
				[ 'hws_video' ],
				[
					'labels'             => [
						'name'          => _x( 'Video categories', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Video category', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'Video category.',
					'public'             => true,
					'publicly_queryable' => true,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'show_in_rest'       => true,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => true,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => 'support/videos',
						'with_front'   => true,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => true,
				]
			);

			// Taxonomy: Webinar type
			yield new NCB_Registrable_Taxonomy(
				'hws_webinar_type',
				[ 'hws_webinar' ],
				[
					'labels'             => [
						'name'          => _x( 'Webinar Types', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Webinar Type', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'Webinar type taxonomy.',
					'public'             => false,
					'publicly_queryable' => false,
					'hierarchical'       => false,
					'show_ui'            => false,
					'show_in_menu'       => false,
					'show_in_nav_menus'  => false,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => false,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => false,
						'with_front'   => false,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);

			// Taxonomy: Enrollment type
			yield new NCB_Registrable_Taxonomy(
				'hws_enrollment_type',
				[ 'hws_enrollment' ],
				[
					'labels'             => [
						'name'          => _x( 'Enrollment Types', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'Enrollment Type', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'Enrollment type taxonomy.',
					'public'             => false,
					'publicly_queryable' => false,
					'hierarchical'       => false,
					'show_ui'            => false,
					'show_in_menu'       => false,
					'show_in_nav_menus'  => false,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => false,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => false,
						'with_front'   => false,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);

			// Taxonomy: CyberSecurity type.
			yield new NCB_Registrable_Taxonomy(
				'hws_cyber_security_type',
				[ 'hws_cyber_security' ],
				[
					'labels'             => [
						'name'          => _x( 'CyberSecurity Types', 'taxonomy_label', 'hws' ),
						'singular_name' => _x( 'CyberSecurity Type', 'taxonomy_label', 'hws' ),
					],
					'description'        => 'CyberSecurity taxonomy.',
					'public'             => false,
					'publicly_queryable' => false,
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => false,
					'show_in_rest'       => false,
					'show_tagcloud'      => false,
					'show_in_quick_edit' => false,
					'show_admin_column'  => true,
					'rewrite'            => [
						'slug'         => false,
						'with_front'   => false,
						'hierarchical' => false,
						'ep_mask'      => EP_NONE,
					],
					'query_var'          => false,
				]
			);
		}

		/**
		 * Return all initial terms.
		 *
		 * @return Generator
		 */
		public function get_initial_terms(): Generator {
			yield 'hws_case_study_cat' => [
				[
					'name'        => _x( '리테일', 'term_name', 'hws' ),
					'slug'        => 'retail',
					'description' => '프로젝트 사례 &gt; 리테일.',
					'meta'        => [ 'hws_icon_class' => 'ico-case3' ],
				],
				[
					'name'        => _x( '병원', 'term_name', 'hws' ),
					'slug'        => 'hospital',
					'description' => '프로젝트 사례 &gt; 병원.',
					'meta'        => [ 'hws_icon_class' => 'ico-case4' ],
				],
				[
					'name'        => _x( '스마트 시티', 'term_name', 'hws' ),
					'slug'        => 'smart-city',
					'description' => '프로젝트 사례 &gt; 스마트 시티.',
					'meta'        => [ 'hws_icon_class' => 'ico-case5' ],
				],
				[
					'name'        => _x( '은행', 'term_name', 'hws' ),
					'slug'        => 'bank',
					'description' => '프로젝트 사례 &gt; 은행.',
					'meta'        => [ 'hws_icon_class' => 'ico-case6' ],
				],
				[
					'name'        => _x( '교통', 'term_name', 'hws' ),
					'slug'        => 'transportation',
					'description' => '프로젝트 사례 &gt; 교통.',
					'meta'        => [ 'hws_icon_class' => 'ico-case7' ],
				],
				[
					'name'        => _x( '교육', 'term_name', 'hws' ),
					'slug'        => 'education',
					'description' => '프로젝트 사례 &gt; 교육.',
					'meta'        => [ 'hws_icon_class' => 'ico-case8' ],
				],
				[
					'name'        => _x( '호텔 / 주거', 'term_name', 'hws' ),
					'slug'        => 'hotel-residence',
					'description' => '프로젝트 사례 &gt; 호텔 / 주거.',
					'meta'        => [ 'hws_icon_class' => 'ico-case9' ],
				],
				[
					'name'        => _x( '상업 빌딩', 'term_name', 'hws' ),
					'slug'        => 'commercial-building',
					'description' => '프로젝트 사례 &gt; 상업 빌딩.',
					'meta'        => [ 'hws_icon_class' => 'ico-case11' ],
				],
				[
					'name'        => _x( '기타', 'term_name', 'hws' ),
					'slug'        => 'misc',
					'description' => '프로젝트 사례 &gt; 기타.',
					'meta'        => [ 'hws_icon_class' => 'ico-case10' ],
				],
			];

			yield 'hws_data_center_cat' => [
				[
					'name'        => _x( '카탈로그', 'term_name', 'hws' ),
					'slug'        => 'catalog',
					'description' => '',
				],
				[
					'name'        => _x( 'HDD 호환 리스트', 'term_name', 'hws' ),
					'slug'        => 'hdd-compat',
					'description' => '',
				],
				[
					'name'        => _x( 'SNMP MIB', 'term_name', 'hws' ),
					'slug'        => 'snmp-mib',
					'description' => '',
				],
				[
					'name'        => _x( '인증/법규', 'term_name', 'hws' ),
					'slug'        => 'certificate',
					'description' => '',
				],
				[
					'name'        => _x( '제안서/기타', 'term_name', 'hws' ),
					'slug'        => 'misc',
					'description' => '',
				],
			];

			yield 'hws_faq_cat' => [
				[
					'name'        => _x( '서비스 일반', 'term_name', 'hws' ),
					'slug'        => 'general',
					'description' => '',
				],
				[
					'name'        => _x( '네트워크 카메라', 'term_name', 'hws' ),
					'slug'        => 'network-camera',
					'description' => '',
				],
				[
					'name'        => _x( '아날로그 카메라', 'term_name', 'hws' ),
					'slug'        => 'analog-camera',
					'description' => '',
				],
				[
					'name'        => _x( 'DVR', 'term_name', 'hws' ),
					'slug'        => 'dvr',
					'description' => '',
				],
				[
					'name'        => _x( 'NVR', 'term_name', 'hws' ),
					'slug'        => 'nvr',
					'description' => '',
				],
				[
					'name'        => _x( 'SW', 'term_name', 'hws' ),
					'slug'        => 'software',
					'description' => '',
				],
				[
					'name'        => _x( '액세서리(기타)', 'term_name', 'hws' ),
					'slug'        => 'accessory',
					'description' => '',
				],
				[
					'name'        => _x( '모바일', 'term_name', 'hws' ),
					'slug'        => 'mobile',
					'description' => '',
				],
			];

			yield 'hws_news_center_cat' => [
				[
					'name'        => _x( '공지사항', 'term_name', 'hws' ),
					'slug'        => 'notice',
					'description' => '뉴스센터 &gt; 공지사항 카테고리.',
				],
				[
					'name'        => _x( '뉴스레터', 'term_name', 'hws' ),
					'slug'        => 'newsletter',
					'description' => '뉴스센터 &gt; 뉴스레터 카테고리.',
				],
				[
					'name'        => _x( '뉴스센터', 'term_name', 'hws' ),
					'slug'        => 'news-center',
					'description' => '뉴스센터 &gt; 뉴스센터 카테고리.',
				],
				[
					'name'        => _x( '프로모션', 'term_name', 'hws' ),
					'slug'        => 'promotion',
					'description' => '뉴스센터 &gt; 프로모션 카테고리.',
				],
				[
					'name'        => _x( '전시 이벤트', 'term_name', 'hws' ),
					'slug'        => 'exhibition-event',
					'description' => '뉴스센터 &gt; 전시 이벤트 카테고리.',
				],
			];

			yield 'hws_service_center_loc' => [
				[
					'name'        => _x( 'Asia', 'term_name', 'hws' ),
					'slug'        => 'asia',
					'description' => '',
				],
				[
					'name'        => _x( 'Middle East', 'term_name', 'hws' ),
					'slug'        => 'middle-east',
					'description' => '',
				],
				[
					'name'        => _x( 'Africa', 'term_name', 'hws' ),
					'slug'        => 'africa',
					'description' => '',
				],
				[
					'name'        => _x( 'Oceania', 'term_name', 'hws' ),
					'slug'        => 'oceania',
					'description' => '',
				],
				[
					'name'        => _x( 'North America', 'term_name', 'hws' ),
					'slug'        => 'north-america',
					'description' => '',
				],
				[
					'name'        => _x( 'South America', 'term_name', 'hws' ),
					'slug'        => 'south-america',
					'description' => '',
				],
				[
					'name'        => _x( 'Europe', 'term_name', 'hws' ),
					'slug'        => 'europe',
					'description' => '',
				],
				[
					'name'        => _x( 'Russia/CIS', 'term_name', 'hws' ),
					'slug'        => 'russia-cis',
					'description' => '',
				],
				[
					'name'        => _x( '대한민국', 'term_name', 'hws' ),
					'slug'        => 'south-korea',
					'description' => 'South Korea area only.',
				],
				[
					'name'        => _x( '서울', 'term_name', 'hws' ),
					'slug'        => 'seoul',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '인천', 'term_name', 'hws' ),
					'slug'        => 'incheon',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '경기도', 'term_name', 'hws' ),
					'slug'        => 'gyeonggi',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '강원도', 'term_name', 'hws' ),
					'slug'        => 'gangwon',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '충청도', 'term_name', 'hws' ),
					'slug'        => 'chungcheong',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '경상도', 'term_name', 'hws' ),
					'slug'        => 'gyeongsang',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '대전', 'term_name', 'hws' ),
					'slug'        => 'daejeon',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '대구', 'term_name', 'hws' ),
					'slug'        => 'daegu',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '전라도', 'term_name', 'hws' ),
					'slug'        => 'jeolla',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '광주', 'term_name', 'hws' ),
					'slug'        => 'gwangju',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '부산', 'term_name', 'hws' ),
					'slug'        => 'busan',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '울산', 'term_name', 'hws' ),
					'slug'        => 'ulsan',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '세종', 'term_name', 'hws' ),
					'slug'        => 'sejong',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( '제주', 'term_name', 'hws' ),
					'slug'        => 'jeju',
					'description' => '',
					'parent'      => 'south-korea',
				],
				[
					'name'        => _x( 'China', 'term_name', 'hws' ),
					'slug'        => 'china',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Hong Kong', 'term_name', 'hws' ),
					'slug'        => 'hong-kong',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'India', 'term_name', 'hws' ),
					'slug'        => 'india',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Indonesia', 'term_name', 'hws' ),
					'slug'        => 'indonesia',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Japan', 'term_name', 'hws' ),
					'slug'        => 'japan',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Malaysia', 'term_name', 'hws' ),
					'slug'        => 'malaysia',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Mongolia', 'term_name', 'hws' ),
					'slug'        => 'mongolia',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Philippines', 'term_name', 'hws' ),
					'slug'        => 'philippines',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Singapore', 'term_name', 'hws' ),
					'slug'        => 'singapore',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Taiwan', 'term_name', 'hws' ),
					'slug'        => 'taiwan',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Thailand', 'term_name', 'hws' ),
					'slug'        => 'thailand',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Vietnam', 'term_name', 'hws' ),
					'slug'        => 'vietnam',
					'description' => '',
					'parent'      => 'asia',
				],
				[
					'name'        => _x( 'Israel', 'term_name', 'hws' ),
					'slug'        => 'israel',
					'description' => '',
					'parent'      => 'middle-east',
				],
				[
					'name'        => _x( 'Kuwait', 'term_name', 'hws' ),
					'slug'        => 'kuwait',
					'description' => '',
					'parent'      => 'middle-east',
				],
				[
					'name'        => _x( 'Lebanon', 'term_name', 'hws' ),
					'slug'        => 'lebanon',
					'description' => '',
					'parent'      => 'middle-east',
				],
				[
					'name'        => _x( 'Qatar', 'term_name', 'hws' ),
					'slug'        => 'qatar',
					'description' => '',
					'parent'      => 'middle-east',
				],
				[
					'name'        => _x( 'Saudi Arabia', 'term_name', 'hws' ),
					'slug'        => 'saudi-arabia',
					'description' => '',
					'parent'      => 'middle-east',
				],
				[
					'name'        => _x( 'UAE', 'term_name', 'hws' ),
					'slug'        => 'uae',
					'description' => '',
					'parent'      => 'middle-east',
				],
				[
					'name'        => _x( 'Yemen', 'term_name', 'hws' ),
					'slug'        => 'yemen',
					'description' => '',
					'parent'      => 'middle-east',
				],
				[
					'name'        => _x( 'Algeria', 'term_name', 'hws' ),
					'slug'        => 'algeria',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Egypt', 'term_name', 'hws' ),
					'slug'        => 'egypt',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Ethiopia', 'term_name', 'hws' ),
					'slug'        => 'ethiopia',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Ghana', 'term_name', 'hws' ),
					'slug'        => 'ghana',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Kenya', 'term_name', 'hws' ),
					'slug'        => 'kenya',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Libya', 'term_name', 'hws' ),
					'slug'        => 'libya',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Morocco', 'term_name', 'hws' ),
					'slug'        => 'morocco',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Nigeria', 'term_name', 'hws' ),
					'slug'        => 'nigeria',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Rwanda', 'term_name', 'hws' ),
					'slug'        => 'rwanda',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'South Africa', 'term_name', 'hws' ),
					'slug'        => 'south-africa',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Tunisia', 'term_name', 'hws' ),
					'slug'        => 'tunisia',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Uganda', 'term_name', 'hws' ),
					'slug'        => 'uganda',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Zimbabwe', 'term_name', 'hws' ),
					'slug'        => 'zimbabwe',
					'description' => '',
					'parent'      => 'africa',
				],
				[
					'name'        => _x( 'Australia', 'term_name', 'hws' ),
					'slug'        => 'australia',
					'description' => '',
					'parent'      => 'oceania',
				],
				[
					'name'        => _x( 'New Zealand', 'term_name', 'hws' ),
					'slug'        => 'new-zealand',
					'description' => '',
					'parent'      => 'oceania',
				],
				[
					'name'        => _x( 'USA', 'term_name', 'hws' ),
					'slug'        => 'usa',
					'description' => '',
					'parent'      => 'North-america',
				],
				[
					'name'        => _x( 'Argentina', 'term_name', 'hws' ),
					'slug'        => 'argentina',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Bolivia', 'term_name', 'hws' ),
					'slug'        => 'bolivia',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Brazil', 'term_name', 'hws' ),
					'slug'        => 'brazil',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Chile', 'term_name', 'hws' ),
					'slug'        => 'chile',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Colombia', 'term_name', 'hws' ),
					'slug'        => 'colombia',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Ecuador', 'term_name', 'hws' ),
					'slug'        => 'ecuador',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Guatemala', 'term_name', 'hws' ),
					'slug'        => 'guatemala',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Mexico', 'term_name', 'hws' ),
					'slug'        => 'mexico',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Peru', 'term_name', 'hws' ),
					'slug'        => 'peru',
					'description' => '',
					'parent'      => 'south-america',
				],
				[
					'name'        => _x( 'Albania', 'term_name', 'hws' ),
					'slug'        => 'albania',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Austria', 'term_name', 'hws' ),
					'slug'        => 'austria',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Belgium', 'term_name', 'hws' ),
					'slug'        => 'belgium',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Bosnia', 'term_name', 'hws' ),
					'slug'        => 'bosnia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Bulgaria', 'term_name', 'hws' ),
					'slug'        => 'bulgaria',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Croatia', 'term_name', 'hws' ),
					'slug'        => 'croatia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Czech Republic', 'term_name', 'hws' ),
					'slug'        => 'czech-republic',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Denmark', 'term_name', 'hws' ),
					'slug'        => 'denmark',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Estonia', 'term_name', 'hws' ),
					'slug'        => 'estonia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Finland', 'term_name', 'hws' ),
					'slug'        => 'finland',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'France', 'term_name', 'hws' ),
					'slug'        => 'france',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Germany', 'term_name', 'hws' ),
					'slug'        => 'germany',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Greece', 'term_name', 'hws' ),
					'slug'        => 'greece',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Herzegovina', 'term_name', 'hws' ),
					'slug'        => 'herzegovina',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Hungary', 'term_name', 'hws' ),
					'slug'        => 'hungary',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Iceland', 'term_name', 'hws' ),
					'slug'        => 'iceland',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Ireland', 'term_name', 'hws' ),
					'slug'        => 'ireland',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Italy', 'term_name', 'hws' ),
					'slug'        => 'italy',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Kosovo', 'term_name', 'hws' ),
					'slug'        => 'kosovo',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Latvia', 'term_name', 'hws' ),
					'slug'        => 'latvia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Lithuania', 'term_name', 'hws' ),
					'slug'        => 'lithuania',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Macedonia', 'term_name', 'hws' ),
					'slug'        => 'macedonia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Moldova', 'term_name', 'hws' ),
					'slug'        => 'moldova',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Montenegro', 'term_name', 'hws' ),
					'slug'        => 'montenegro',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Netherlands', 'term_name', 'hws' ),
					'slug'        => 'netherlands',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Norway', 'term_name', 'hws' ),
					'slug'        => 'norway',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Poland', 'term_name', 'hws' ),
					'slug'        => 'poland',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Portugal', 'term_name', 'hws' ),
					'slug'        => 'portugal',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Romania', 'term_name', 'hws' ),
					'slug'        => 'romania',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Serbia', 'term_name', 'hws' ),
					'slug'        => 'serbia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Slovakia', 'term_name', 'hws' ),
					'slug'        => 'slovakia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Slovenia', 'term_name', 'hws' ),
					'slug'        => 'slovenia',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Spain', 'term_name', 'hws' ),
					'slug'        => 'spain',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Sweden', 'term_name', 'hws' ),
					'slug'        => 'sweden',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Switzerland', 'term_name', 'hws' ),
					'slug'        => 'switzerland',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Turkey', 'term_name', 'hws' ),
					'slug'        => 'turkey',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'United Kingdom', 'term_name', 'hws' ),
					'slug'        => 'united-kingdom',
					'description' => '',
					'parent'      => 'europe',
				],
				[
					'name'        => _x( 'Armenia', 'term_name', 'hws' ),
					'slug'        => 'armenia',
					'description' => '',
					'parent'      => 'russia-cis',
				],
				[
					'name'        => _x( 'Azerbaijan', 'term_name', 'hws' ),
					'slug'        => 'azerbaijan',
					'description' => '',
					'parent'      => 'russia-cis',
				],
				[
					'name'        => _x( 'Belarus', 'term_name', 'hws' ),
					'slug'        => 'belarus',
					'description' => '',
					'parent'      => 'russia-cis',
				],
				[
					'name'        => _x( 'Georgia', 'term_name', 'hws' ),
					'slug'        => 'georgia',
					'description' => '',
					'parent'      => 'russia-cis',
				],
				[
					'name'        => _x( 'Kazakhstan', 'term_name', 'hws' ),
					'slug'        => 'kazakhstan',
					'description' => '',
					'parent'      => 'russia-cis',
				],
				[
					'name'        => _x( 'Russia', 'term_name', 'hws' ),
					'slug'        => 'russia',
					'description' => '',
					'parent'      => 'russia-cis',
				],
				[
					'name'        => _x( 'Ukraine', 'term_name', 'hws' ),
					'slug'        => 'ukraine',
					'description' => '',
					'parent'      => 'russia-cis',
				],
				[
					'name'        => _x( 'Uzbekistan', 'term_name', 'hws' ),
					'slug'        => 'uzbekistan',
					'description' => '',
					'parent'      => 'russia-cis',
				],
			];

			yield 'hws_video_cat' => [
				[
					'name'        => _x( '데모', 'term_name', 'hws' ),
					'slug'        => 'demo-video',
					'description' => '',
				],
				[
					'name'        => _x( 'How to Use', 'term_name', 'hws' ),
					'slug'        => 'how-to-use-video',
					'description' => '',
				],
				[
					'name'        => _x( '홍보 영상', 'term_name', 'hws' ),
					'slug'        => 'promotion-video',
					'description' => '',
				],
			];

			yield 'hws_webinar_type' => [
				[
					'name'        => _x( 'Online Training', 'term_name', 'hws' ),
					'slug'        => 'online-training',
					'description' => 'Webinar Type: Online training.',
				],
				[
					'name'        => _x( 'Offline Training', 'term_name', 'hws' ),
					'slug'        => 'offline-training',
					'description' => 'Webinar Type: Offline training.',
				],
			];

			yield 'hws_enrollment_type' => [
				[
					'name'        => _x( 'Webinar', 'term_name', 'hws' ),
					'slug'        => 'webinar',
					'description' => 'Webinar enrollment',
				],
			];

			yield 'hws_cyber_security_type' => [
				[
					'name'        => _x( '사이버보안 강화 활동', 'term_name', 'hws' ),
					'slug'        => 'cyber-security-activity',
					'description' => '',
				],
				[
					'name'        => _x( '사이버보안 가이드', 'term_name', 'hws' ),
					'slug'        => 'cyber-security-guide',
					'description' => '',
				],
				[
					'name'        => _x( '취약점 리포트', 'term_name', 'hws' ),
					'slug'        => 'vulnerability-report',
					'description' => '',
				],
				[
					'name'        => _x( '침투 테스트 성적서', 'term_name', 'hws' ),
					'slug'        => 'infiltration-test-result',
					'description' => '',
				],
			];
		}
	}
}

