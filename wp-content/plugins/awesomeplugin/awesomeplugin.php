<?php
/*
Plugin Name: Awesomeness Creator
Plugin URI: http://my-awesomeness-emporium.com
description: >-
a plugin to create awesomeness and spread joy
Version: 1.2
Author: Hajdi
Author URI: http://hajdi.com
License: GPL2
*/

defined( 'ABSPATH' ) or die( 'Hey, you cant access this file' );

class  AwesomePlugin {


	public function __construct() {
		$this->getPost();
		$this->create_post_type();
		$this->createLocations();
		$this->createTypes();
		$this->registerFields();
		$this->getPermalinks();
		add_action( 'template_include', array( $this, 'cc_links_init_template_logic' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'script_add' ) );
		add_action( 'wp_ajax_edit_ajax_request', array( $this, 'edit_ajax_request' ) );
		add_filter( 'posts_clauses_request', array( $this, 'customSearchClause' ) );
	}

	public function activate() {
		require_once plugin_dir_path( __FILE__ ) . 'inc/awesome-plugin-activate.php';
		AwesomePluginActivate::activate();
	}

	public function deactivate() {
		require_once plugin_dir_path( __FILE__ ) . 'inc/awesome-plugin-deactivate.php';
		AwesomePluginDeactivate::deactivate();
	}

//	public function activate() {
//		$this->getPost();
//		$this->custom_post_type();
//		$this->createLocations();
//		$this->createTypes();
//		$this->registerFields();
////		add_action( 'init', array( $this, 'custom_post_type' ), 10 );
////		$this->create_locations_nonhierarchical_taxonomy();
////		$this->create_type_nonhierarchical_taxonomy();
//		flush_rewrite_rules();
//	}

	function script_add() {

		// Register the JS file with a unique handle, file location, and an array of dependencies
		wp_enqueue_script( "ajax-test", plugin_dir_url( __FILE__ ) . 'js/ajax-test.js', array( 'jquery' ) );

		// localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
		wp_localize_script( 'ajax-test', 'ajax_params', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'x_nonce' => wp_create_nonce( 'update_action' ) ) );
	}

	protected function getPost() {
		add_action( 'pre_get_posts', array( $this, 'add_my_post_types_to_query' ) );
	}


	protected function create_post_type() {
		add_action( 'init', array( $this, 'custom_post_type' ), 10 );
	}

	protected function createLocations() {
		add_action( 'init', 'create_locations_nonhierarchical_taxonomy', 10 );
	}

	protected function createTypes() {
		add_action( 'init', array( $this, 'create_type_nonhierarchical_taxonomy' ), 10 );
	}

	protected function registerFields() {
		add_action( 'init', array( $this, 'register_fields' ), 10 );
		add_action( 'init', array( $this, 'loaction_type_fields_to_taxonomy' ), 10 );
	}

	protected function getPermalinks() {
		add_filter( 'post_type_link', array( $this, 'wpa_show_permalinks' ), 1, 2 );
	}

	static function enqueue() {
		wp_enqueue_script( 'mypluginscript', plugins_url( '/js/my_script.js', __FILE__ ) );
	}

//make custom post type

	function custom_post_type() {

		$labels = array(
			'name'               => _x( 'Real Estates', 'Post Type General Name', 'real_estate' ),
			'singular_name'      => _x( 'Real Estate', 'Post Type Singular Name', 'real_estate' ),
			'menu_name'          => __( 'Real Estates', 'real_estate' ),
			'parent_item_colon'  => __( 'Parent Real Estate', 'real_estate' ),
			'all_items'          => __( 'All Real Estates', 'real_estate' ),
			'view_item'          => __( 'View Real Estate', 'real_estate' ),
			'add_new_item'       => __( 'Add New Real Estate', 'real_estate' ),
			'add_new'            => __( 'Add New', 'real_estate' ),
			'edit_item'          => __( 'Edit Real Estate', 'real_estate' ),
			'update_item'        => __( 'Update Real Estate', 'real_estate' ),
			'search_items'       => __( 'Search Real Estate', 'real_estate' ),
			'not_found'          => __( 'Not Found', 'real_estate' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'real_estate' ),
		);


		$args = array(
			'description'         => __( 'Real Estate news and reviews', 'real_estate' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			'taxonomies'          => array( 'locations', 'types' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'rewrite'             => [
				'slug' => 'estates/%types%',
			],
		);

		// Registering your Custom Post Type
		register_post_type( 'real_estates', $args );


		//create taxonomy

		function create_locations_nonhierarchical_taxonomy() {


			$labels = array(
				'name'                       => _x( 'Locations', 'taxonomy general name' ),
				'singular_name'              => _x( 'Location', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Locations' ),
				'popular_items'              => __( 'Popular Locations' ),
				'all_items'                  => __( 'All Locations' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Location' ),
				'update_item'                => __( 'Update Location' ),
				'add_new_item'               => __( 'Add New Location' ),
				'new_item_name'              => __( 'New Location Name' ),
				'separate_items_with_commas' => __( 'Separate Locations with commas' ),
				'add_or_remove_items'        => __( 'Add or remove Locations' ),
				'choose_from_most_used'      => __( 'Choose from the most used Locations' ),
				'menu_name'                  => __( 'Locations' ),
			);

// Now register the non-hierarchical taxonomy like tag

			register_taxonomy( 'locations', 'real_estates', array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'meta_box_cb'       => false,
				'show_admin_column' => true,
//		'update_count_callback' => '_update_real_estate_term_count',
				'has_archive'       => true,
				'query_var'         => 'locations',
				'rewrite'           => array(
					'slug' => 'location',
				),
			) );

		}


	}

	//Taxonomy type


	function create_type_nonhierarchical_taxonomy() {


		$labels = array(
			'name'                       => _x( 'Types', 'taxonomy general name' ),
			'singular_name'              => _x( 'Type', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Types' ),
			'popular_items'              => __( 'Popular Types' ),
			'all_items'                  => __( 'All Types' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Type' ),
			'update_item'                => __( 'Update Type' ),
			'add_new_item'               => __( 'Add New Type' ),
			'new_item_name'              => __( 'New Type Name' ),
			'separate_items_with_commas' => __( 'Separate Type with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Types' ),
			'choose_from_most_used'      => __( 'Choose from the most used Types' ),
			'menu_name'                  => __( 'Types' ),
		);

// Now register the non-hierarchical taxonomy like tag

		register_taxonomy( 'types', 'real_estates', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'meta_box_cb'       => false,
			'show_ui'           => true,
			'show_admin_column' => true,
//		'update_count_callback' => '_update_real_estate_term_count',
			'has_archive'       => true,
			'query_var'         => 'types',
			'rewrite'           => [
				'slug' => 'estates'
			]
		) );
	}


	function add_my_post_types_to_query( $query ) {
		if ( is_home() && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'real_estates' ) );
		}

		return $query;
	}

	//register fields
	function register_fields() {
		if ( function_exists( 'acf_add_local_field_group' ) ):

			acf_add_local_field_group( array(
				'key'                   => 'group_5dd3f6953c32a',
				'title'                 => 'Real estate Field Group',
				'fields'                => array(
					array(
						'key'               => 'field_5dd3f6c8df323',
						'label'             => 'Gallery',
						'name'              => 'gallery',
						'type'              => 'gallery',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'min'               => '',
						'max'               => '',
						'insert'            => 'append',
						'library'           => 'all',
						'min_width'         => '',
						'min_height'        => '',
						'min_size'          => '',
						'max_width'         => '',
						'max_height'        => '',
						'max_size'          => '',
						'mime_types'        => '',
					),
					array(
						'key'               => 'field_5dd3f6e1df324',
						'label'             => 'Slides',
						'name'              => 'slides',
						'type'              => 'repeater',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'collapsed'         => '',
						'min'               => 0,
						'max'               => 0,
						'layout'            => 'table',
						'button_label'      => '',
						'sub_fields'        => array(
							array(
								'key'               => 'field_5dd3f6fadf325',
								'label'             => 'text',
								'name'              => 'text',
								'type'              => 'text',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
						),
					),
					array(
						'key'               => 'field_5dd3f78c11c70',
						'label'             => 'Subtitle',
						'name'              => 'subtitle',
						'type'              => 'text',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'real_estates',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );

		endif;

	}

	function loaction_type_fields_to_taxonomy() {
		if ( function_exists( 'acf_add_local_field_group' ) ):

			acf_add_local_field_group( array(
				'key'                   => 'group_5ddd239f82e41',
				'title'                 => 'terms',
				'fields'                => array(
					array(
						'key'               => 'field_5ddd23a83f70e',
						'label'             => 'Location',
						'name'              => 'location',
						'type'              => 'taxonomy',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'taxonomy'          => 'locations',
						'field_type'        => 'select',
						'allow_null'        => 0,
						'add_term'          => 1,
						'save_terms'        => 1,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 0,
					),
					array(
						'key'               => 'field_5ddd2c7f121f3',
						'label'             => 'Type',
						'name'              => 'type',
						'type'              => 'taxonomy',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'taxonomy'          => 'types',
						'field_type'        => 'select',
						'allow_null'        => 0,
						'add_term'          => 1,
						'save_terms'        => 1,
						'load_terms'        => 0,
						'return_format'     => 'id',
						'multiple'          => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'real_estates',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );

		endif;
	}

	//permalinks

	function wpa_show_permalinks( $post_link, $post ) {
		if ( is_object( $post ) && $post->post_type == 'real_estates' ) {
			$terms = wp_get_object_terms( $post->ID, 'types' );
			if ( $terms ) {
				return str_replace( '%types%', $terms[0]->slug, $post_link );
			}
		}

		return $post_link;
	}


// Template Logic

	function cc_links_init_template_logic( $original_template ) {

		if ( is_home() ) {
			// some additional logic goes here^.
			if ( file_exists( trailingslashit( get_template_directory() ) . 'awesomeplugin/homepage.php' ) ) {
				return trailingslashit( get_template_directory() ) . 'awesomeplugin/homepage.php';
			} else {
				return plugin_dir_path( __FILE__ ) . 'templates/homepage.php';
			}
		} elseif ( is_archive( 'real_estates' ) ) {
			// some additional logic goes here^.
			if ( file_exists( trailingslashit( get_template_directory() ) . 'awesomeplugin/archive-real_estates.php' ) ) {
				return trailingslashit( get_template_directory() ) . 'awesomeplugin/archive-real_estates.php';
			} else {
				return plugin_dir_path( __FILE__ ) . 'templates/archive-real_estates.php';
			}
		} elseif ( is_singular( 'real_estates' ) ) {
			if ( file_exists( get_template_directory_uri() . '/awesomeplugin/single-real_estates.php' ) ) {
				return get_template_directory_uri() . '/awesomeplugin/single-real_estates.php';
			} else {
				return plugin_dir_path( __FILE__ ) . 'templates/single-real_estates.php';

			}
		}

		return $original_template;
	}

	//Edit real eatate function


	public function edit_ajax_request() {

		if ( isset( $_POST['post_title'] ) ) {

			$post_id = acf_maybe_get_POST( 'post_id' );
			$post    = get_post( $post_id );
			$author  = (int) $post->post_author;

			if ( check_ajax_referer( 'update_action', 'x_nonce' ) ) {

				if ( ( current_user_can( 'update_core' ) ) || ( get_current_user_id() === $author ) ) {

					$my_post = array(
						'post_type'  => 'real_estates',
						'ID'         => $post_id,
						'post_title' => acf_maybe_get_POST( 'post_title' ),
						'meta_input' => [
							'subtitle' => acf_maybe_get_POST( 'subtitle' ),
						]
					);

					wp_update_post( $my_post );
					update_field( 'gallery', acf_maybe_get_POST( 'gallery' ), $post );
					update_field( 'slides', acf_maybe_get_POST( 'slides' ), $post );
					update_field( 'location', [ acf_maybe_get_POST( 'location' ) ], $post );

					wp_send_json_success();
				}
			}
		}


		wp_die( "You can't do that" );

	}

	function customSearchClause( $query ) {
		global $wp_query;

		if ( ! is_search() || ! $wp_query->is_main_query() ) {
			return $query;
		}

		$term           = $wp_query->query['s'];
		$query['join']  = 'INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
		INNER JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
		INNER JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
		INNER JOIN wp_terms ON (wp_term_taxonomy.term_id = wp_terms.term_id)';
		$query['where'] = "AND wp_posts.post_type = 'real_estates'
    AND (
        (wp_posts.post_title LIKE '%{$term}%')
        OR (wp_postmeta.meta_key = 'subtitle' AND wp_postmeta.meta_value LIKE '%{$term}%')
        OR (wp_term_taxonomy.taxonomy = 'locations' AND  wp_terms.slug LIKE '%{$term}%')
        OR (wp_term_taxonomy.taxonomy = 'types' AND  wp_terms.slug LIKE '%{$term}%')
    )
        GROUP BY wp_posts.ID
    ";

		return $query;
	}

}

if ( class_exists( 'AwesomePlugin' ) ) {
	$awesomePlugin = new AwesomePlugin();
//    $awesomePlugin->register_admin_scripts();
//	AwesomePlugin::register_admin_scripts();
}

//activation
register_activation_hook( __FILE__, array( $awesomePlugin, 'activate' ) );

//deactivation
register_deactivation_hook( __FILE__, array( $awesomePlugin, 'deactivate' ) );


//uninstall
//register_uninstall_hook( __FILE__, array($awesomePlugin,'uninstall'));
