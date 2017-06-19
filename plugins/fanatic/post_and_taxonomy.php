<?php
// Register Custom Post Type
// function block() {

// 	$labels = array(
// 		'name'                  => _x( 'Blocks', 'Post Type General Name', 'fanatic' ),
// 		'singular_name'         => _x( 'Block', 'Post Type Singular Name', 'fanatic' ),
// 		'menu_name'             => __( 'Block', 'fanatic' ),
// 		'name_admin_bar'        => __( 'Block', 'fanatic' ),
// 		'archives'              => __( 'Block Archives', 'fanatic' ),
// 		'parent_item_colon'     => __( 'Parent Block:', 'fanatic' ),
// 		'all_items'             => __( 'All Blocks', 'fanatic' ),
// 		'add_new_item'          => __( 'Add New Block', 'fanatic' ),
// 		'add_new'               => __( 'Add New', 'fanatic' ),
// 		'new_item'              => __( 'New Block', 'fanatic' ),
// 		'edit_item'             => __( 'Edit Block', 'fanatic' ),
// 		'update_item'           => __( 'Update Block', 'fanatic' ),
// 		'view_item'             => __( 'View Block', 'fanatic' ),
// 		'search_items'          => __( 'Search Block', 'fanatic' ),
// 		'not_found'             => __( 'Not found', 'fanatic' ),
// 		'not_found_in_trash'    => __( 'Not found in Trash', 'fanatic' ),
// 		'featured_image'        => __( 'Featured Image', 'fanatic' ),
// 		'set_featured_image'    => __( 'Set featured image', 'fanatic' ),
// 		'remove_featured_image' => __( 'Remove featured image', 'fanatic' ),
// 		'use_featured_image'    => __( 'Use as featured image', 'fanatic' ),
// 		'insert_into_item'      => __( 'Insert into item', 'fanatic' ),
// 		'uploaded_to_this_item' => __( 'Uploaded to this item', 'fanatic' ),
// 		'items_list'            => __( 'Items list', 'fanatic' ),
// 		'items_list_navigation' => __( 'Items list navigation', 'fanatic' ),
// 		'filter_items_list'     => __( 'Filter items list', 'fanatic' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Block', 'fanatic' ),
// 		'description'           => __( 'Building block', 'fanatic' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title', 'editor', 'thumbnail','page-attributes', ),
// 		'taxonomies'            => array( 'area' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 20,
// 		'menu_icon'             => 'dashicons-screenoptions',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => false,
// 		'can_export'            => true,
// 		'has_archive'           => false,
// 		'exclude_from_search'   => true,
// 		'publicly_queryable'    => false,
// 		'rewrite'               => false,
// 		'capability_type'       => 'page',
// 	);
// 	register_post_type( 'block', $args );

// }
// add_action( 'init', 'block', 0 );

// Register Custom Post Type
// function single_line() {

// 	$labels = array(
// 		'name'                  => _x( 'Single lines', 'Post Type General Name', 'fanatic' ),
// 		'singular_name'         => _x( 'Single line', 'Post Type Singular Name', 'fanatic' ),
// 		'menu_name'             => __( 'Single line', 'fanatic' ),
// 		'name_admin_bar'        => __( 'Single line', 'fanatic' ),
// 		'archives'              => __( 'Item Archives', 'fanatic' ),
// 		'parent_item_colon'     => __( 'Parent Item:', 'fanatic' ),
// 		'all_items'             => __( 'All Items', 'fanatic' ),
// 		'add_new_item'          => __( 'Add New Item', 'fanatic' ),
// 		'add_new'               => __( 'Add New', 'fanatic' ),
// 		'new_item'              => __( 'New Item', 'fanatic' ),
// 		'edit_item'             => __( 'Edit Item', 'fanatic' ),
// 		'update_item'           => __( 'Update Item', 'fanatic' ),
// 		'view_item'             => __( 'View Item', 'fanatic' ),
// 		'search_items'          => __( 'Search Item', 'fanatic' ),
// 		'not_found'             => __( 'Not found', 'fanatic' ),
// 		'not_found_in_trash'    => __( 'Not found in Trash', 'fanatic' ),
// 		'featured_image'        => __( 'Featured Image', 'fanatic' ),
// 		'set_featured_image'    => __( 'Set featured image', 'fanatic' ),
// 		'remove_featured_image' => __( 'Remove featured image', 'fanatic' ),
// 		'use_featured_image'    => __( 'Use as featured image', 'fanatic' ),
// 		'insert_into_item'      => __( 'Insert into item', 'fanatic' ),
// 		'uploaded_to_this_item' => __( 'Uploaded to this item', 'fanatic' ),
// 		'items_list'            => __( 'Items list', 'fanatic' ),
// 		'items_list_navigation' => __( 'Items list navigation', 'fanatic' ),
// 		'filter_items_list'     => __( 'Filter items list', 'fanatic' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Single line', 'fanatic' ),
// 		'description'           => __( 'Single line fields', 'fanatic' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title','page-attributes', ),
// 		'taxonomies'            => array( 'area' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 21,
// 		'menu_icon'             => 'dashicons-format-quote',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => true,
// 		'can_export'            => true,
// 		'has_archive'           => false,
// 		'exclude_from_search'   => true,
// 		'publicly_queryable'    => false,
// 		'rewrite'               => false,
// 		'capability_type'       => 'page',
// 	);
// 	register_post_type( 'single_line', $args );

// }
// add_action( 'init', 'single_line', 0 );

// Register Custom Post Type
// function nugget() {

// 	$labels = array(
// 		'name'                  => _x( 'Content Blocks', 'Post Type General Name', 'fanatic' ),
// 		'singular_name'         => _x( 'Content Block', 'Post Type Singular Name', 'fanatic' ),
// 		'menu_name'             => __( 'Content Block', 'fanatic' ),
// 		'name_admin_bar'        => __( 'Content Blocks', 'fanatic' ),
// 		'archives'              => __( 'Item Archives', 'fanatic' ),
// 		'parent_item_colon'     => __( 'Parent Item:', 'fanatic' ),
// 		'all_items'             => __( 'All Items', 'fanatic' ),
// 		'add_new_item'          => __( 'Add New Item', 'fanatic' ),
// 		'add_new'               => __( 'Add New', 'fanatic' ),
// 		'new_item'              => __( 'New Item', 'fanatic' ),
// 		'edit_item'             => __( 'Edit Item', 'fanatic' ),
// 		'update_item'           => __( 'Update Item', 'fanatic' ),
// 		'view_item'             => __( 'View Item', 'fanatic' ),
// 		'search_items'          => __( 'Search Item', 'fanatic' ),
// 		'not_found'             => __( 'Not found', 'fanatic' ),
// 		'not_found_in_trash'    => __( 'Not found in Trash', 'fanatic' ),
// 		'featured_image'        => __( 'Featured Image', 'fanatic' ),
// 		'set_featured_image'    => __( 'Set featured image', 'fanatic' ),
// 		'remove_featured_image' => __( 'Remove featured image', 'fanatic' ),
// 		'use_featured_image'    => __( 'Use as featured image', 'fanatic' ),
// 		'insert_into_item'      => __( 'Insert into item', 'fanatic' ),
// 		'uploaded_to_this_item' => __( 'Uploaded to this item', 'fanatic' ),
// 		'items_list'            => __( 'Items list', 'fanatic' ),
// 		'items_list_navigation' => __( 'Items list navigation', 'fanatic' ),
// 		'filter_items_list'     => __( 'Filter items list', 'fanatic' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Content Block', 'fanatic' ),
// 		'description'           => __( 'Single line fields', 'fanatic' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title', 'editor', 'thumbnail','page-attributes', ),
// 		'taxonomies'            => array( 'area' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 24,
// 		'menu_icon'             => 'dashicons-welcome-widgets-menus',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => true,
// 		'can_export'            => true,
// 		'has_archive'           => true,
// 		'exclude_from_search'   => true,
// 		'publicly_queryable'    => false,
// 		'rewrite'               => false,
// 		'capability_type'       => 'page',
// 	);
// 	register_post_type( 'nugget', $args );

// }
// add_action( 'init', 'nugget', 0 );

// Register Custom Post Type
// function button_link() {

// 	$labels = array(
// 		'name'                  => _x( 'Buttons', 'Post Type General Name', 'fanatic' ),
// 		'singular_name'         => _x( 'Button', 'Post Type Singular Name', 'fanatic' ),
// 		'menu_name'             => __( 'Button', 'fanatic' ),
// 		'name_admin_bar'        => __( 'Button', 'fanatic' ),
// 		'archives'              => __( 'Item Archives', 'fanatic' ),
// 		'parent_item_colon'     => __( 'Parent Item:', 'fanatic' ),
// 		'all_items'             => __( 'All Items', 'fanatic' ),
// 		'add_new_item'          => __( 'Add New Item', 'fanatic' ),
// 		'add_new'               => __( 'Add New', 'fanatic' ),
// 		'new_item'              => __( 'New Item', 'fanatic' ),
// 		'edit_item'             => __( 'Edit Item', 'fanatic' ),
// 		'update_item'           => __( 'Update Item', 'fanatic' ),
// 		'view_item'             => __( 'View Item', 'fanatic' ),
// 		'search_items'          => __( 'Search Item', 'fanatic' ),
// 		'not_found'             => __( 'Not found', 'fanatic' ),
// 		'not_found_in_trash'    => __( 'Not found in Trash', 'fanatic' ),
// 		'featured_image'        => __( 'Featured Image', 'fanatic' ),
// 		'set_featured_image'    => __( 'Set featured image', 'fanatic' ),
// 		'remove_featured_image' => __( 'Remove featured image', 'fanatic' ),
// 		'use_featured_image'    => __( 'Use as featured image', 'fanatic' ),
// 		'insert_into_item'      => __( 'Insert into item', 'fanatic' ),
// 		'uploaded_to_this_item' => __( 'Uploaded to this item', 'fanatic' ),
// 		'items_list'            => __( 'Items list', 'fanatic' ),
// 		'items_list_navigation' => __( 'Items list navigation', 'fanatic' ),
// 		'filter_items_list'     => __( 'Filter items list', 'fanatic' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Button', 'fanatic' ),
// 		'description'           => __( 'Buttons', 'fanatic' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'page-attributes' ),
// 		'taxonomies'            => array( 'area' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 23,
// 		'menu_icon'             => 'dashicons-tag',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => true,
// 		'can_export'            => true,
// 		'has_archive'           => false,
// 		'exclude_from_search'   => true,
// 		'publicly_queryable'    => false,
// 		'rewrite'               => false,
// 		'capability_type'       => 'page',
// 	);
// 	register_post_type( 'button_link', $args );

// }
// add_action( 'init', 'button_link', 0 );


// Register Custom Post Type
function vehicles() {

	$labels = array(
		'name'                  => _x( 'Vehicle', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Vehicle', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Vehicles', 'text_domain' ),
		'name_admin_bar'        => __( 'Vehicles', 'text_domain' ),
		'archives'              => __( 'Vehicle Archives', 'text_domain' ),
		'attributes'            => __( 'Vehicle Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Vehicle', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'vehicles', $args );

}
add_action( 'init', 'vehicles', 0 );

// Register Custom Post Type
function slider() {

	$labels = array(
		'name'                  => _x( 'Banner Images', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Banner Image', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Banner Images', 'text_domain' ),
		'name_admin_bar'        => __( 'Banner Images', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Banner Image', 'text_domain' ),
		'description'           => __( 'Images for the banner slider', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'slider', $args );

}
add_action( 'init', 'slider', 0 );