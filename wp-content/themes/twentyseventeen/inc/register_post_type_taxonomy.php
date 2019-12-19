<?php

/**
 * Custom post type Real-Estates
 */

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

}

add_action( 'init', 'custom_post_type', 10 );


/**
 * Custom taxonomy Location
 */

//hook into the init action and call create_locations_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_locations_nonhierarchical_taxonomy', 10 );

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
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
//		'update_count_callback' => '_update_real_estate_term_count',
		'has_archive'           => true,
		'query_var'             => 'locations',
		'rewrite'               => array(
			'slug' => 'location',
		),
	) );

}


/**
 * Custom taxonomy Type
 */

//hook into the init action and call create_locations_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_type_nonhierarchical_taxonomy', 10 );

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
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
//		'update_count_callback' => '_update_real_estate_term_count',
		'has_archive'           => true,
		'query_var'             => 'types',
		'rewrite'               => [
			'slug' => 'estates'
		]
	) );
}

/**
 * @param WP_Query $query
 *
 * @return mixed
 */

function add_my_post_types_to_query( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'real_estates' ) );
	}

	return $query;
}

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );


//

function wpa_show_permalinks( $post_link, $post ){
	if ( is_object( $post ) && $post->post_type == 'real_estates' ){
		$terms = wp_get_object_terms( $post->ID, 'types' );
		if( $terms ){
			return str_replace( '%types%' , $terms[0]->slug , $post_link );
		}
	}
	return $post_link;
}
add_filter( 'post_type_link', 'wpa_show_permalinks', 1, 2 );



//
//function get_custom_single_template($single_template) {
//	global $post;
//
//	if ($post->post_type == 'real_estates') {
//		$terms = get_the_terms($post->ID, 'locations');
//		if($terms && !is_wp_error( $terms )) {
//			//Make a foreach because $terms is an array but it supposed to be only one term
//			foreach($terms as $term){
//				$single_template = dirname( __FILE__ ) . '/single-'.$term->slug.'.php';
//			}
//		}
//	}
//	return $single_template;
//}
//
//add_filter( "single_template", "get_custom_single_template" ) ;
