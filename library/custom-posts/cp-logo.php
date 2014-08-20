<?php
/*
*****************************************************
* Logo custom post
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
		add_action( 'init', 'sp_logo_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'sp_logo_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-logo_columns', 'sp_logo_cp_columns' );




/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_logo_cp_init' ) ) {
		function sp_logo_cp_init() {
			global $cp_menu_position;

			/*if ( $smof_data['sp_newsticker_revisions'] )
				$supports[] = 'revisions';*/
			$labels = array(
				'name'               => __( 'Logos', 'sptheme_admin' ),
				'singular_name'      => __( 'Logo', 'sptheme_admin' ),
				'add_new'            => __( 'Add New', 'sptheme_admin' ),
				'all_items'          => __( 'All Logos', 'sptheme_admin' ),
				'add_new_item'       => __( 'Add New Logo', 'sptheme_admin' ),
				'new_item'           => __( 'Add New Logo', 'sptheme_admin' ),
				'edit_item'          => __( 'Edit Logo', 'sptheme_admin' ),
				'view_item'          => __( 'View Logo', 'sptheme_admin' ),
				'search_items'       => __( 'Search Logo', 'sptheme_admin' ),
				'not_found'          => __( 'No Logo found', 'sptheme_admin' ),
				'not_found_in_trash' => __( 'No Logo found in trash', 'sptheme_admin' ),
				'parent_item_colon'  => __( 'Parent Logo', 'sptheme_admin' ),
			);	

			$role     = 'post'; // page
			$slug     = 'logo';
			$supports = array('title', 'thumbnail'); // 'title', 'editor', 'thumbnail'

			$args = array(
				'labels' 				=> $labels,
				'rewrite'               => array( 'slug' => $slug ),
				'menu_position'         => $cp_menu_position['menu_logo'],
				'menu_icon'           	=> 'dashicons-awards',
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
			register_post_type( 'logo' , $args );
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
	if ( ! function_exists( 'sp_logo_cp_columns' ) ) {
		function sp_logo_cp_columns( $columns ) {
			
			$columns = array(
				'cb'                   	=> '<input type="checkbox" />',
				'logo_thumbnail'	   	=> __( 'Thumbnail', 'sptheme_admin' ),
				'title'                	=> __( 'Company Name', 'sptheme_admin' ),
				'logo_type'		 		=> __( 'Logo Type', 'sptheme_admin' ),
				'date'		 			=> __( 'Date', 'sptheme_admin' )
			);

			return $columns;
		}
	}

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_logo_cp_custom_column' ) ) {
		function sp_logo_cp_custom_column( $column ) {
			global $post;
			
			switch ( $column ) {
				case "logo_thumbnail":
					echo get_the_post_thumbnail( $post->ID, array(50, 50) );
				break;

				case "logo_type":
					$terms = get_the_terms( $post->ID, 'logo-type' );

					if ( empty( $terms ) )
					break;
	
					$output = array();
	
					foreach ( $terms as $term ) {
						
						$output[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'logo-type' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'logo-type', 'display' ) )
						);
	
					}
	
					echo join( ', ', $output );

				break;
				
				default:
				break;
			}
		}
	} // /sp_logo_cp_custom_column

	
	