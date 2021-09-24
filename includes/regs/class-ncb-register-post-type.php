<?php
/**
 * Post type register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NCB_Register_Post_Type' ) ) {
	class NCB_Register_Post_Type implements NCB_Register {
		use NCB_Hooks_Impl;

		private array $post_types = [];

		private array $excludes = [];

		public function __construct() {
			$this
				->add_action( 'init', 'register' )
				->add_action( 'registered_post_type', 'registered_post_type', null, 2 )
			;

			$this
				->add_filter( 'post_type_link', 'modify_post_permalink', null, 4 )
				->add_filter( 'rewrite_rules_array', 'modify_rewrite_rules' )
			;

			$this->excludes = [ 'hws_solution', 'hws_tech' ];
		}

		public function register() {
			$excludes = apply_filters( 'hws_post_type_register_excludes', $this->excludes );

			foreach ( $this->get_items() as $item ) {
				if ( $item instanceof NCB_Registrable_Post_Type ) {
					if ( ! in_array( $item->post_type, $excludes ) ) {
						$this->post_types[] = $item->post_type;
					}
					$item->register();
				}
			}
		}

		public function get_items(): Generator {
			// Post Type: Case Study.
			yield new NCB_Registrable_Post_Type(
				'hws_case_study',
				[
					'labels'              => [
						'name'                     => _x( 'Case Studies', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Case Study', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new case study', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit case study', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New case study', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View case study', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View case study', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search case study', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All case study', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Case study archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into case study', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this case study', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Case Studies', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter case study list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Case study list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Case study list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Case study published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Case study published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Case study reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Case study scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Case study updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Case study post type.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-portfolio',
					'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
					'has_archive'         => true,
					'rewrite'             => [
						'slug'    => 'solutions/case-study',
						'feeds'   => false,
						'pages'   => true,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: News center.
			yield new NCB_Registrable_Post_Type(
				'hws_news_center',
				[
					'labels'              => [
						'name'                     => _x( 'News Centers', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'News Center', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new news', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit news', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New news', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View news', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View news', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search news', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All news', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'News Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into news', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this news', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'News Center', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter news list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'News list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'News list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'News published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'News published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'News reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'News scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'News updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for news center.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => false,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-microphone',
					'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
					'has_archive'         => false,
					// NOTE: the taxonomies related to this post type will have archives.
					'rewrite'             => [
						'slug'    => 'news-center',
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => false,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Data center.
			yield new NCB_Registrable_Post_Type(
				'hws_data_center',
				[
					'labels'              => [
						'name'                     => _x( 'Data Centers', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Data Center', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new data center', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit data center', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New data center', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View data center', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View data center', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search data center', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All data center', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Data center Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into data center', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this data center', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Data Center', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter data center list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Data center list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Data center list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Data center published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Data center published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Data center reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Data center scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Data center updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for data center.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-vault',
					'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
					'has_archive'         => true,
					// NOTE: the taxonomies related to this post type will have archives.
					'rewrite'             => [
						'slug'    => 'support/data-center',
						'feeds'   => false,
						'pages'   => true,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Videos.
			yield new NCB_Registrable_Post_Type(
				'hws_video',
				[
					'labels'              => [
						'name'                     => _x( 'Videos', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Video', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new video', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit video', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New video', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View video', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View video', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search video', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All video', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Video Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into video', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this video', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Videos', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter video list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Video list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Video list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Video published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Video published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Video reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Video scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Video updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Custom post type for videos.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-format-video',
					'supports'            => [ 'title', 'editor', 'thumbnail' ],
					'has_archive'         => true,
					// NOTE: the taxonomies related to this post type will have archives.
					'rewrite'             => [
						'slug'    => 'support/videos',
						'feeds'   => false,
						'pages'   => true,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => true,
				]
			);

			// Post Type: F.A.Q.
			yield new NCB_Registrable_Post_Type(
				'hws_faq',
				[
					'labels'              => [
						'name'                     => _x( 'FAQs', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'FAQ', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new FAQ', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit FAQ', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New FAQ', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View FAQ', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View FAQs', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search FAQ', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All FAQs', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'FAQ Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into FAQ', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this FAQ', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'FAQs', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter FAQs list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'FAQ list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'FAQs list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'FAQ published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'FAQ published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'FAQ reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'FAQ scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'FAQ updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for frequently asked question (F.A.Q).',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-editor-help',
					'supports'            => [ 'title', 'editor', 'revisions' ],
					'has_archive'         => true,
					'rewrite'             => [
						'slug'    => 'support/faq',
						'feeds'   => false,
						'pages'   => true,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Service Center.
			yield new NCB_Registrable_Post_Type(
				'hws_service_center',
				[
					'labels'              => [
						'name'                     => _x( 'Service Centers', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Service Center', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new center', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit center', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New center', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View center', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View centers', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search centers', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All centers', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Service Centers Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into center', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this center', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Service Center', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter centers list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Service centers list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Service centers list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Service center published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Service center published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Service center reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Service center scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Service center updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for service center.',
					'public'              => false,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => false,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => false,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-admin-site-alt2',
					'supports'            => [ 'title' ],
					'has_archive'         => false,
					'rewrite'             => [
						'slug'    => false,
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => false,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Recruit. (채용 안내)
			yield new NCB_Registrable_Post_Type(
				'hws_recruit',
				[
					'labels'              => [
						'name'                     => _x( 'Recruits', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Recruit', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new recruit', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit recruit', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New recruit', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View recruit', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View recruits', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search recruits', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All recruits', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Recruits Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into recruit', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this recruit', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Recruit', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter recruits list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Recruits list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Recruits list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Recruit published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Recruit published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Recruit reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Recruit scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Recruit updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for recruit board.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-groups',
					'supports'            => [ 'title', 'editor', 'revisions' ],
					'has_archive'         => true,
					'rewrite'             => [
						'slug'    => 'about-us/recruit/recruit-info',
						'feeds'   => false,
						'pages'   => true,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Notice. (전자 공고)
			yield new NCB_Registrable_Post_Type(
				'hws_notice',
				[
					'labels'              => [
						'name'                     => _x( 'Notices', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Notice', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new notice', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit notice', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New notice', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View notice', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View notices', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search notices', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All notices', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Notices Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into notice', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this notice', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Notice', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter notices list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Notices list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Notices list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Notice published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Notice published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Notice reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Notice scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Notice updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for notice board.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-format-quote',
					'supports'            => [ 'title', 'editor', 'revisions' ],
					'has_archive'         => true,
					'rewrite'             => [
						'slug'    => 'about-us/notice',
						'feeds'   => false,
						'pages'   => true,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: White Paper (기술 백서)
			yield new NCB_Registrable_Post_Type(
				'hws_white_paper',
				[
					'labels'              => [
						'name'                     => _x( 'White Papers', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'White Paper', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new white paper', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit white paper', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New white paper', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View white paper', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View white papers', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search white papers', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All white papers', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'White Papers Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into white paper', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this white paper', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'White Paper', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter white papers list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'White Papers list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'White Papers list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'White Paper published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'White Paper published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'White Paper reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'White Paper scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'White Paper updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for white paper board.',
					'public'              => false,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-book-alt',
					'supports'            => [ 'title' ],
					'has_archive'         => true,
					'rewrite'             => [
						'slug'    => 'technical-guides/white-papers',
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => false,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Solution (솔루션)
			yield new NCB_Registrable_Post_Type(
				'hws_solution',
				[
					'labels'              => [
						'name'                     => _x( 'Solutions', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Solution', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new solution', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit solution', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New solution', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View solution', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View solutions', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search solutions', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All solutions', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Solutions Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into solution', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this solution', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Solutions', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter solutions list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Solutions list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Solutions list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Solution published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Solution published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Solution reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Solution scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Solution updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for solution pages.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-lightbulb',
					'supports'            => [ 'title', 'editor', 'revisions', 'thumbnail' ],
					'has_archive'         => false,
					'rewrite'             => [
						'slug'    => 'solutions',
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Tech (제품)
			yield new NCB_Registrable_Post_Type(
				'hws_tech',
				[
					'labels'              => [
						'name'                     => _x( 'Techs', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Tech', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new tech', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit tech', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New tech', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View tech', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View techs', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search techs', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All techs', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Techs Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into tech', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this tech', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Techs', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter techs list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Techs list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Techs list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Tech published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Tech published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Tech reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Tech scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Tech updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for tech pages.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-shield',
					'supports'            => [ 'title', 'editor', 'revisions', 'thumbnail' ],
					'has_archive'         => false,
					'rewrite'             => [
						'slug'    => 'technical-guides',
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Webinar (웨비나)
			yield new NCB_Registrable_Post_Type(
				'hws_webinar',
				[
					'labels'              => [
						'name'                     => _x( 'Webinars', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Webinar', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new webinar', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit webinar', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New webinar', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View webinar', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View webinars', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search webinars', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All webinars', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Webinars Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into webinar', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this webinar', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Webinars', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter webinars list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Webinars list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Webinars list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Webinar published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Webinar published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Webinar reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Webinar scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Webinar updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for webinars.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-welcome-learn-more',
					'supports'            => [ 'title', 'editor', 'revisions' ],
					'has_archive'         => true,
					'rewrite'             => [
						'slug'    => 'support/academy/webinars',
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Enrollment (웨비나 등록)
			yield new NCB_Registrable_Post_Type(
				'hws_enrollment',
				[
					'labels'              => [
						'name'                     => _x( 'Enrollments', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Enrollment', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new enrollment', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit enrollment', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New enrollment', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View enrollment', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View enrollments', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search enrollments', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All enrollments', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Enrollments Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into enrollment', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this enrollment', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Enrollments', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter enrollments list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Enrollments list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Enrollments list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Enrollment published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Enrollment published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Enrollment reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Enrollment scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Enrollment updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for enrollments.',
					'public'              => false,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => false,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => false,
					'show_in_admin_bar'   => false,
					'menu_icon'           => 'dashicons-nametag',
					'supports'            => [ 'title' ],
					'has_archive'         => false,
					'rewrite'             => [
						'slug'    => false,
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => false,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: Webinar Domestic (국내 전용 웨비나)
			yield new NCB_Registrable_Post_Type(
				'hws_webinar_domestic',
				[
					'labels'              => [
						'name'                     => _x( 'Domestic Webinars', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'Domestic Webinar', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new domestic webinar', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit domestic webinar', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New domestic webinar', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View domestic webinar', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View domestic webinars', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search domestic webinars', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All domestic webinars', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'Domestic Webinars Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into domestic webinar', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this domestic webinar', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'Domestic Webinars', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter domestic webinars list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'Domestic webinars list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'Domestic webinars list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'Domestic webinar published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'Domestic webinar published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'Domestic webinar reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'Domestic webinar scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'Domestic webinar updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for domestic webinars.',
					'public'              => true,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_icon'           => 'dashicons-video-alt3',
					'supports'            => [ 'title', 'editor', 'revisions', 'thumbnail' ],
					'has_archive'         => true,
					'rewrite'             => [
						'slug'    => 'support/academy/dom-webinars',
						'feeds'   => false,
						'pages'   => true,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => true,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);

			// Post Type: CyberSecurity (사이버보안 게시물)
			yield new NCB_Registrable_Post_Type(
				'hws_cyber_security',
				[
					'labels'              => [
						'name'                     => _x( 'CyberSecurities', 'post_type_label', 'hws' ),
						'singular_name'            => _x( 'CyberSecurity', 'post_type_label', 'hws' ),
						'add_new'                  => _x( 'Add new', 'post_type_label', 'hws' ),
						'add_new_item'             => _x( 'Add new CyberSecurity', 'post_type_label', 'hws' ),
						'edit_item'                => _x( 'Edit CyberSecurity', 'post_type_label', 'hws' ),
						'new_item'                 => _x( 'New CyberSecurity', 'post_type_label', 'hws' ),
						'view_item'                => _x( 'View CyberSecurity', 'post_type_label', 'hws' ),
						'view_items'               => _x( 'View CyberSecurities', 'post_type_label', 'hws' ),
						'search_items'             => _x( 'Search CyberSecurities', 'post_type_label', 'hws' ),
						'not_found'                => _x( 'Not found', 'post_type_label', 'hws' ),
						'not_found_in_trash'       => _x( 'Not found in trash', 'post_type_label', 'hws' ),
						'all_items'                => _x( 'All CyberSecurities', 'post_type_label', 'hws' ),
						'archives'                 => _x( 'CyberSecurities Archives', 'post_type_label', 'hws' ),
						'insert_into_item'         => _x( 'Insert into CyberSecurity', 'post_type_label', 'hws' ),
						'upload_to_this_item'      => _x( 'Upload to this CyberSecurity', 'post_type_label', 'hws' ),
						'featured_image'           => _x( 'Featured image', 'post_type_label', 'hws' ),
						'set_featured_image'       => _x( 'Set featured image', 'post_type_label', 'hws' ),
						'remove_featured_image'    => _x( 'Remove featured image', 'post_type_label', 'hws' ),
						'use_featured_image'       => _x( 'Use as featured image', 'post_type_label', 'hws' ),
						'menu_name'                => _x( 'CyberSecurities', 'post_type_label', 'hws' ),
						'filter_items_list'        => _x( 'Filter CyberSecurities list', 'post_type_label', 'hws' ),
						'filter_by_date'           => _x( 'Filter by date', 'post_type_label', 'hws' ),
						'items_list_navigation'    => _x( 'CyberSecurities list navigation', 'post_type_label', 'hws' ),
						'items_list'               => _x( 'CyberSecurities list', 'post_type_label', 'hws' ),
						'item_published'           => _x( 'CyberSecurity published', 'post_type_label', 'hws' ),
						'item_published_privately' => _x( 'CyberSecurity published privately', 'post_type_label', 'hws' ),
						'item_reverted_to_draft'   => _x( 'CyberSecurity reverted to draft', 'post_type_label', 'hws' ),
						'item_scheduled'           => _x( 'CyberSecurity scheduled', 'post_type_label', 'hws' ),
						'item_updated'             => _x( 'CyberSecurity updated', 'post_type_label', 'hws' ),
					],
					'description'         => 'Post type for CyberSecurity.',
					'public'              => false,
					'hierarchical'        => false,
					'exclude_from_search' => true,
					'publicly_queryable'  => false,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => false,
					'show_in_admin_bar'   => false,
					'menu_icon'           => 'dashicons-privacy',
					'supports'            => [ 'title' ],
					'has_archive'         => false,
					'rewrite'             => [
						'slug'    => false,
						'feeds'   => false,
						'pages'   => false,
						'ep_mask' => EP_NONE,
					],
					'query_var'           => false,
					'can_export'          => true,
					'delete_with_user'    => false,
					'show_in_rest'        => false,
				]
			);
		}

		/**
		 * Modify permalinks of new center posts.
		 *
		 * @callback
		 * @filter   post_type_link
		 *
		 * @param string  $post_link
		 * @param WP_Post $post
		 *
		 * @return string
		 */
		public function modify_post_permalink( string $post_link, WP_Post $post ): string {
			if ( in_array( $post->post_type, $this->post_types, true ) ) {
				$post_link = str_replace( '%post_id%', $post->ID, $post_link );
			}

			return $post_link;
		}

		public function registered_post_type( string $post_type, WP_Post_Type $post_type_object ) {
			global $wp_rewrite;

			if ( in_array( $post_type, $this->post_types, true ) ) {
				if ( $post_type_object->rewrite['with_front'] ) {
					$struct = $wp_rewrite->front . $post_type_object->rewrite['slug'] . '/%post_id%';
				} else {
					$struct = $wp_rewrite->root . $post_type_object->rewrite['slug'] . '/%post_id%';
				}

				$wp_rewrite->extra_permastructs[ $post_type ]['struct'] = $struct;
			}
		}

		/**
		 * Modify custom post permastruct.
		 *
		 * @callback
		 * @filter    rewrite_rules_array
		 *
		 * @param array $rules
		 *
		 * @return array
		 *
		 * @see       WP_Rewrite::rewrite_rules()
		 * @see       NCB_Register_Post_Type::modify_post_permalink()
		 */
		public function modify_rewrite_rules( array $rules ): array {
			foreach ( $this->post_types as $post_type ) {
				$obj = get_post_type_object( $post_type );

				if ( $obj ) {
					$key = $obj->rewrite['slug'] . '/([0-9]+)/page/?([0-9]{1,})/?$';
					if ( isset( $rules[ $key ] ) ) {
						$rules[ $key ] = "index.php?post_type={$post_type}&p=\$matches[1]&paged=\$matches[2]";
					}

					$key = $obj->rewrite['slug'] . '/([0-9]+)(?:/([0-9]+))?/?$';
					if ( isset( $rules[ $key ] ) ) {
						$rules[ $key ] = "index.php?post_type={$post_type}&p=\$matches[1]&page=\$matches[2]";
					}
				}
			}

			// Remove solutions/[^/]+/([^/]+)/?$ => index.php?attachment=$matches[1] rewrite rule.
			if ( isset( $rules['solutions/[^/]+/([^/]+)/?$'] ) ) {
				unset( $rules['solutions/[^/]+/([^/]+)/?$'] );
			}

			return $rules;
		}
	}
}
