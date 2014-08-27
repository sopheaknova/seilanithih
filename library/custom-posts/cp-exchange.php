<?php
/*
*****************************************************
* Exchange Rate custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_exchange_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_exchange_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-exchange_columns', 'sp_exchange_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_exchange_cp_init' ) ) {
		function sp_exchange_cp_init() {
			global $cp_menu_position;

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/
			$labels = array(
				'name'               => __( 'Exchanges Rate', 'sptheme_admin' ),
				'singular_name'      => __( 'Exchange Rate', 'sptheme_admin' ),
				'add_new'            => __( 'Add New', 'sptheme_admin' ),
				'all_items'          => __( 'All Exchange Rates', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New Exchange Rate', 'sptheme_admin' ),
				'new_item'           => __( 'Add New Exchange Rate', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit Exchange Rate', 'sptheme_admin' ),
				'view_item'          => __( 'View Exchange Rate', 'sptheme_admin' ),
				'search_items'       => __( 'Search Exchange Rate', 'sptheme_admin' ),
				'not_found'          => __( 'No Exchange Rate found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No Exchange Rate found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent Exchange Rate', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'exchange';
			$supports = array('title'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_exchange'],
				'menu_icon'           	=> 'dashicons-analytics',
				'supports'              => $supports,
				'capability_type'     	=> $role,
				'query_var'           	=> true,
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_nav_menus'	    => false,
				'publicly_queryable'	=> true,
				'exclude_from_search'   => false,
				'has_archive'			=> false,
				'can_export'			=> true
			);
			register_post_type( 'exchange' , $args );
		}
	} 


/*
*****************************************************
*      3) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'sp_exchange_cp_columns' ) ) {
		function sp_exchange_cp_columns( $columns ) {
			
			$columns['cb']                   = '<input type="checkbox" />';
			$columns['title']                = __( 'Company Name', 'sptheme_admin' );
			$columns['exchange_buy']         = __( 'Buy', 'sptheme_admin' );
			$columns['exchange_sell']        = __( 'Sell', 'sptheme_admin' );
			$columns['date']		 		 = __( 'Date', 'sptheme_admin' );
			
			return $columns;
		}
	}

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_exchange_cp_custom_column' ) ) {
		function sp_exchange_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				
				case "exchange_buy":
					echo get_post_meta( $post->ID, 'sp_buy_rate', true );
				break;

				case "exchange_sell":
					echo get_post_meta( $post->ID, 'sp_sell_rate', true );
				break;

				default:
				break;
			}
		}
	} // /sp_exchange_cp_custom_column

	
	