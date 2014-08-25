<?php

//All custom posts
load_template( SP_BASE_DIR . 'library/custom-posts/cp-home-slider.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-service.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-team.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-client.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-logo.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-branch.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-faq.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-exchange.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-slider.php' );

//Taxonomies
load_template( SP_BASE_DIR . 'library/custom-posts/taxonomy-team.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/taxonomy-logo.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/taxonomy-branch.php' );
	
/*==========================================================================*/

//Change title text when creating new post
if ( is_admin() )
	add_filter( 'enter_title_here', 'sp_change_new_post_title' );	
	
/*
* Changes "Enter title here" text when creating new post
*/
if ( ! function_exists( 'sp_change_new_post_title' ) ) {
	function sp_change_new_post_title( $title ){
		$screen = get_current_screen();

		if ( 'gallery' == $screen->post_type )
			$title = __( "Album name", 'sptheme_admin' );

		if ( 'faq' == $screen->post_type )
			$title = __( "Question title", 'sptheme_admin' );

		return $title;
	}
} // /sp_change_new_post_title