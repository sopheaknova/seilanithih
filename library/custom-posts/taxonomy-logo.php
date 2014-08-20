<?php
add_action('init', 'sp_tax_logo_type_init', 0);

function sp_tax_logo_type_init() {
	register_taxonomy(
		'logo-type',
		array( 'logo' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Logo Type', 'sptheme_admin' ),
				'singular_name' => __( 'Logo type', 'sptheme_admin' ),
				'search_items' =>  __( 'Search Logo type', 'sptheme_admin' ),
				'all_items' => __( 'All Logos', 'sptheme_admin' ),
				'parent_item' => __( 'Parent Logo type', 'sptheme_admin' ),
				'parent_item_colon' => __( 'Parent Logo type:', 'sptheme_admin' ),
				'edit_item' => __( 'Edit Logo type', 'sptheme_admin' ),
				'update_item' => __( 'Update Logo type', 'sptheme_admin' ),
				'add_new_item' => __( 'Add New Logo type', 'sptheme_admin' ),
				'new_item_name' => __( 'Logo type', 'sptheme_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'logo-type' ),
			'show_in_nav_menus' => false
		)
	);
}