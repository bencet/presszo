<?php
/* New function "EVENTS" for presszo */

function custom_post_type_events() {

	$labels = array(
		'name'                => _x( 'events', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'event', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Esemény', 'text_domain' ),
		'name_admin_bar'      => __( 'Esemény', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'Összes esemény', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Új hozzáadása', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Esemény szerkesztése', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'Esemény megtekintése', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'event', 'text_domain' ),
		'description'         => __( 'new type for events', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'event', $args );

}
add_action( 'init', 'custom_post_type_events', 0 );

function my_wp_subtitle_page_part_support() {
    add_post_type_support( 'event', 'wps_subtitle' );
}
add_action( 'init', 'my_wp_subtitle_page_part_support' );

?>
