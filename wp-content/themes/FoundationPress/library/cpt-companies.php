<?php
// Register Custom Post Type
function alb_companys_cpt() {

	$labels = array(
		'name'                  => _x( 'Companies', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Company', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Companies', 'text_domain' ),
		'name_admin_bar'        => __( 'Companies', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
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
		'label'                 => __( 'Company', 'text_domain' ),
		'description'           => __( 'Company post type', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'revisions', ),
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
		'capability_type'       => 'post',
		'rewrite' => array('slug' => 'company')
	);
	register_post_type( 'company', $args );

}
function alb_companys_taxonomy() {
    register_taxonomy(
        'company-types',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'company',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Company Types',  //Display name
            'query_var' => true,
            'rewrite' => array(
                //'slug' => 'product-types', // This controls the base slug that will display before each term
                //'with_front' => true // Don't display the category base before
				'hierarchical' => true

            )
        )
    );
}
add_action( 'init', 'alb_companys_cpt', 0 );
//add_action( 'init', 'ad_companys_taxonomy', 0);
