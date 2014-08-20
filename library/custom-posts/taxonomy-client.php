<?php
add_action('init', 'sp_tax_client_category_init', 0);

function sp_tax_client_category_init() {
	register_taxonomy(
		'clients-category',
		array( 'client' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Client Categories', 'sptheme_admin' ),
				'singular_name' => __( 'Client Categories', 'sptheme_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'client-category' ),
			'show_in_nav_menus' => false
		)
	);
}