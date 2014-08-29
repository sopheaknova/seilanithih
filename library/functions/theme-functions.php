<?php


/* ---------------------------------------------------------------------- */
/* Show language list on header
/* ---------------------------------------------------------------------- */
if( !function_exists('languages_list_header')) {

	function languages_list_header(){
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages) && ot_get_option('show-lang-flag') != 'off' ){
			echo '<div class="language"><ul>';
			//echo '<li>' . __('Language: ', 'sptheme') . '</li>';
			foreach($languages as $l){
				echo '<li class="'.$l['language_code'].'">';

				if(!$l['active']) echo '<a href="'.$l['url'].'" title="' . $l['native_name'] . '" class="active">';
				echo '<img src="' . $l['country_flag_url'] . '" alt="' . $l['native_name'] . '" />';
				if(!$l['active']) echo '</a>';

				echo '</li>';
			}
			echo '</ul></div>';
		}
	}

}

/* ---------------------------------------------------------------------- */
/* Translating arrays of IDs
/* ---------------------------------------------------------------------- */

function lang_object_ids($ids_array, $type) {
	if(function_exists('icl_object_id')) {
		$res = array();
		foreach ($ids_array as $id) {
			$xlat = icl_object_id($id,$type,false);
			if(!is_null($xlat)) $res[] = $xlat;
		}
		return $res;
	} else {
		return $ids_array;
	}
}

/* ---------------------------------------------------------------------- */
/*	Get images attached to post
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_post_images' ) ) {

	function sp_post_images( $args=array() ) {
		global $post;

		$defaults = array(
			'numberposts'		=> -1,
			'order'				=> 'ASC',
			'orderby'			=> 'menu_order',
			'post_mime_type'	=> 'image',
			'post_parent'		=>  $post->ID,
			'post_type'			=> 'attachment',
		);

		$args = wp_parse_args( $args, $defaults );

		return get_posts( $args );
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Get thumbnail post
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_post_thumbnail') ) {

	function sp_post_thumbnail($size = 'thumbnail'){
		global $post;
		$thumb = '';
		
		//get the post thumbnail;
		$thumb_id = get_post_thumbnail_id($post->ID);
		$thumb_url = wp_get_attachment_image_src($thumb_id, $size);
		$thumb = $thumb_url[0];
		if ($thumb) return $thumb;
	}		

}

/* ---------------------------------------------------------------------- */
/*	Start content wrap
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_start_content_wrap') ) {

	add_action( 'sp_start_content_wrap_html', 'sp_start_content_wrap' );

	function sp_start_content_wrap() {
		echo '<section id="content" class="container clearfix">';
	}
	
}

/* ---------------------------------------------------------------------- */
/*	End content wrap
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_end_content_wrap') ) {

	add_action( 'sp_end_content_wrap_html', 'sp_end_content_wrap' );

	function sp_end_content_wrap() {
		echo '</section> <!-- #content .container .clearfix -->';
	}

}

/* ---------------------------------------------------------------------- */
/*	Thumnail for social share
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_facebook_thumb') ) {

	function sp_facebook_thumb() {
		if ( is_singular( 'sp_work' ) ) {
			global $post;

			$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
			echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '" />';
		}
	}

	add_action('wp_head', 'sp_facebook_thumb');
}


/* ---------------------------------------------------------------------- */               							
/*  Retrieve the terms list and return array
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_get_terms_list') ) {

	function sp_get_terms_list($taxonomy){
		$args = array(
				'hide_empty'	=> 0
			);
		$taxonomies = get_terms($taxonomy, $args);
		return $taxonomies;
	}

}


/* ---------------------------------------------------------------------- */               							
/*  Get related post by Taxonomy
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_get_posts_related_by_taxonomy') ) {

	function sp_get_posts_related_by_taxonomy($post_id, $taxonomy, $args=array()) {

		//$query = new WP_Query();
		$terms = wp_get_object_terms($post_id, $taxonomy);
		if (count($terms)) {
		
		// Assumes only one term for per post in this taxonomy
		$post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
		$post = get_post($post_id);
		$args = wp_parse_args($args,array(
		  'post_type' => $post->post_type, // The assumes the post types match
		  //'post__in' => $post_ids,
		  'post__not_in' => array($post_id),
		  'tax_query' => array(
		  			array(
						'taxonomy' => $taxonomy,
						'field' => 'term_id',
		  				'terms' => $terms[0]->term_id
					)),
		  'orderby' => 'rand',
		  'posts_per_page' => -1
		  
		));
		$query = new WP_Query($args);
		}
		return $query;
	}

}

/* ---------------------------------------------------------------------- */               							
/*  Taxonomy has children and has parent
/* ---------------------------------------------------------------------- */
function has_children($cat_id, $taxonomy) {
    $children = get_terms(
        $taxonomy,
        array( 'parent' => $cat_id, 'hide_empty' => false )
    );
    if ($children){
        return true;
    }
    return false;
}

function category_has_parent($catid){
    $category = get_category($catid);
    if ($category->category_parent > 0){
        return true;
    }
    return false;
}

/* ---------------------------------------------------------------------- */
/*  Get related pages
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_get_related_pages') ) {

	function sp_get_related_pages() {

		$orig_post = $post;
		global $post;
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag)
			$tag_ids[] = $individual_tag->term_id;
			$args=array(
			'post_type' => 'page',
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=>5
			);
			$pages_query = new WP_Query( $args );
			if( $pages_query->have_posts() ) {
				echo '<div id="relatedpages"><h3>Related Pages</h3><ul>';
				while( $pages_query->have_posts() ) {
				$pages_query->the_post(); ?>
				<li><div class="relatedthumb"><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumb'); ?></a></div>
				<div class="relatedcontent">
				<h3><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<?php the_time('M j, Y') ?>
				</div>
				</li>
			<?php }
				echo '</ul></div>';
			} else { 
				echo "No Related Pages Found:";
			}
		}
		$post = $orig_post;
		wp_reset_postdata(); 

	}
	
}

/* ---------------------------------------------------------------------- */
/*  Get related post
/* ---------------------------------------------------------------------- */ 
if ( ! function_exists( 'sp_related_posts' ) ) {

	function sp_related_posts() {
		wp_reset_postdata();
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'				=> true,
			'update_post_meta_cache'	=> false,
			'update_post_term_cache'	=> false,
			'ignore_sticky_posts'		=> 1,
			'orderby'					=> 'rand',
			'post__not_in'				=> array($post->ID),
			'posts_per_page'			=> 3
		);
		// Related by categories
		if ( ot_get_option('related-posts') == 'categories' ) {
			
			$cats = get_post_meta($post->ID, 'related-cat', true);
			
			if ( !$cats ) {
				$cats = wp_get_post_categories($post->ID, array('fields'=>'ids'));
				$args['category__in'] = $cats;
			} else {
				$args['cat'] = $cats;
			}
		}
		// Related by tags
		if ( ot_get_option('related-posts') == 'tags' ) {
		
			$tags = get_post_meta($post->ID, 'related-tag', true);
			
			if ( !$tags ) {
				$tags = wp_get_post_tags($post->ID, array('fields'=>'ids'));
				$args['tag__in'] = $tags;
			} else {
				$args['tag_slug__in'] = explode(',', $tags);
			}
			if ( !$tags ) { $break = true; }
		}
		
		$query = !isset($break) ? new WP_Query($args) : new WP_Query;
		return $query;
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Displays a page pagination
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', SP_TEXT_DOMAIN) . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', SP_TEXT_DOMAIN) . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

/* ---------------------------------------------------------------------- */
/*	Comment Template
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_comment_template' ) ) {

	function sp_comment_template( $comment, $args, $depth ) {
		global $retina;
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>

		<li id="comment-<?php comment_ID(); ?>" class="comment clearfix">

			<?php $av_size = isset($retina) && $retina === 'true' ? 96 : 48; ?>
			
			<div class="user"><?php echo get_avatar( $comment, $av_size, $default=''); ?></div>

			<div class="message">
				
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => 3 ) ) ); ?>

				<div class="info">
					<h4><?php echo (get_comment_author_url() != '' ? comment_author_link() : comment_author()); ?></h4>
					<span class="meta"><?php echo comment_date('F jS, Y \a\t g:i A'); ?></span>
				</div>

				<?php comment_text(); ?>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="await"><?php _e( 'Your comment is awaiting moderation.', SP_TEXT_DOMAIN ); ?></em>
				<?php endif; ?>

			</div>

		</li>

		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', SP_TEXT_DOMAIN ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', SP_TEXT_DOMAIN), ' ' ); ?></p></li>
		<?php
				break;
		endswitch;
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Ajaxify Comments
/* ---------------------------------------------------------------------- */

add_action('comment_post', 'ajaxify_comments',20, 2);
function ajaxify_comments($comment_ID, $comment_status){
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//If AJAX Request Then
		switch($comment_status){
			case '0':
				//notify moderator of unapproved comment
				wp_notify_moderator($comment_ID);
			case '1': //Approved comment
				echo "success";
				$commentdata=&get_comment($comment_ID, ARRAY_A);
				$post=&get_post($commentdata['comment_post_ID']); 
				wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
			break;
			default:
				echo "error";
		}
		exit;
	}
}

/* ---------------------------------------------------------------------- */
/*	Full Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_post_meta' ) ) {
	function sp_post_meta() {
		printf( __( '<i class="icon icon-calendar-1"></i><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s"> %4$s</time></a><span class="by-author"> by </span><span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="posted-in"> in </span><i class="icon icon-tag"> </i> %8$s ', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', SP_TEXT_DOMAIN ), get_the_author() ) ),
			get_the_author(),
			get_the_category_list( ', ' )
		);
		if ( comments_open() ) : ?>
				<span class="with-comments"><?php _e( ' with ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '<i class="icon icon-comment-1"></i> % Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open() ?>
		<?php edit_post_link( __( 'Edit', SP_TEXT_DOMAIN ), '<span class="sep"> | </span><span class="edit-link">', '</span>' );
	}
};

/* ---------------------------------------------------------------------- */
/*	Mini Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_meta_mini' ) ) :
	function sp_meta_mini() {
		printf( __( '<a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="sep"> |  </span>', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
			//get_the_category_list( ', ' )
		);
		if ( comments_open() ) : ?>
				<span class="sep"><?php _e( ' | ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '% Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open()
	}
endif;

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_get_video_img($url) {
	
	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video_id =  $my_array_of_vars['v'] ;
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video_id = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video_id = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		$output .=$hash[0]['thumbnail_large'];
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='http://www.dailymotion.com/thumbnail/video/'.$video_id;
	}

	return $output;
	
}

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_add_video ($url, $width = 620, $height = 349) {

	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video =  $my_array_of_vars['v'] ;
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
	}

	return $output;
}

/* ---------------------------------------------------------------------- */
/*	Embeded soundcloud
/* ---------------------------------------------------------------------- */

function sp_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}

function sp_portfolio_grid( $col = 'list', $posts_per_page = 5 ) {
	
	$temp ='';
	$output = '';
	
	$args = array(
			'posts_per_page' => (int) $posts_per_page,
			'post_type' => 'portfolio',
			);
			
	$post_list = new WP_Query($args);
		
	ob_start();
	if ($post_list && $post_list->have_posts()) {
		
		$output .= '<ul class="portfolio ' . $col . '">';
		
		while ($post_list->have_posts()) : $post_list->the_post();
		
		$output .= '<li>';
		$output .= '<div class="two-fourth"><div class="post-thumbnail">';
		$output .= '<a href="'.get_permalink().'"><img src="' . sp_post_thumbnail('portfolio-2col') . '" /></a>';
		$output .= '</div></div>';
		
		$output .= '<div class="two-fourth last">';
		$output .= '<a href="'.get_permalink().'" class="port-'. $col .'-title">' . get_the_title() .'</a>';
		$output .= '</div>';	
		
		$output .= '</li>';	
		endwhile;
		
		$output .= '</ul>';
		
	}
	$temp = ob_get_clean();
	$output .= $temp;
	
	wp_reset_postdata();
	
	return $output;
	
}

/* ---------------------------------------------------------------------- */
/*	Get Most Racent posts from Category
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_last_posts_cat' ) ) {
	function sp_last_posts_cat( $post_num = 5 , $thumb = true , $category = 1 ) {

		global $post;
		
		$out = '';
		if ( is_singular() ) :
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'post__not_in' => array($post->ID) );	
		else : 
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'post__not_in' => get_option( 'sticky_posts' ) );
		endif;
		

		$custom_query = new WP_Query( $args );

		$out .= '<section class="custom-posts clearfix">';
		if( $custom_query->have_posts() ) :
			while ( $custom_query->have_posts() ) : $custom_query->the_post();

			$out .= '<article>';
			$out .= '<a href="' . get_permalink() . '" class="clearfix">';
			if ( has_post_thumbnail() && $thumb ) :
				$out .= get_the_post_thumbnail();
			else :
				$out .= '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME .'images/placeholder/thumb-small.png">';	
			endif;
			$out .= '<h5>' . get_the_title() . '</h5>';
			$out .= '<span class="time">' . get_the_time('j M, Y') . '</span>';
			$out .= '</a>';
			$out .= '</article>';

			endwhile; wp_reset_postdata();
		endif;
		$out .= '<a href="' . esc_url(get_category_link( $category )) . '" class="learn-more">' . __('More news', SP_TEXT_DOMAIN) .'</a>';
		$out .= '</section>';

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Get latest gallery/album
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_album_gallery' ) ) {
	function sp_get_album_gallery( $album_id = '', $photo_num = 10, $size = 'thumbnail' ) {

		global $post;

		$gallery = explode( ',', get_post_meta( $album_id, 'sp_gallery', true ) );
		/*$args = array(
			'posts_per_page'	=>	$photo_num,
			'post_parent'		=>	$album_id
		);

		$gallery = sp_post_images( $args );*/

		$out = '<div class="gallery clearfix">';
		
		if ( $gallery[0] != '' ) :
			foreach ( $gallery as $image ) :
			$imageid = wp_get_attachment_image_src($image, $size);
			$out .= '<div class="one-third">';
			$out .= '<a href="' . wp_get_attachment_url($image) . '">';
			$out .= '<img class="attachment-medium wp-post-image" src="' . $imageid[0] . '">';
			$out .= '</a>';
			$out .= '</div><!-- .one-third -->';
			endforeach; 
		else : 
			$out .= __( 'Sorry there is no image for this album.', SP_TEXT_DOMAIN );
		endif;
		
		/*foreach ( $gallery as $image ) : setup_postdata( $image );
			$imageid = wp_get_attachment_image_src($image->ID, $size);
			$out .= '<div class="one-third">';
			$out .= '<a href="' . wp_get_attachment_url($image->ID) . '">';
			$out .= '<img class="attachment-medium wp-post-image" src="' . $imageid[0] . '" alt="' . $image->post_title . '">';
			$out .= '</a>';
			$out .= '</div><!-- .one-third -->';
		endforeach; wp_reset_postdata();*/

		$out .= '</div>';

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Get Cover of Album
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_cover_album' ) ) {
	function sp_get_cover_album( $photo_num = 10, $size = 'thumbnail' ) {

		global $post;

		$args = array(
			'post_type' 		=>	'gallery',
			'posts_per_page'	=>	$photo_num,
		);

		$custom_query = new WP_Query( $args );

		if( $custom_query->have_posts() ) :
			$out = '<div class="album-cover clearfix">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$out .= '<div class="two-fourth">';
				$out .= sp_post_thumbnail( $size );
                $out .= '<h5>' . get_the_title() . '</h5>';
                $out .= '</a>';
                $out .= '</div><!-- .two-fourth -->';

			endwhile; wp_reset_postdata();
			$out .= '</div><!-- .album-cover -->';
		endif;

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Display sliders
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_sliders' ) ) {
	function sp_sliders( $slide_sytle = 1, $slide_id, $size = 'thumbnail' ){
		
		$sliders = explode( ',', get_post_meta( $slide_id, 'sp_sliders', true ) );
		$out = '';
		if ( $slide_sytle == 1 ) {
			$out .='<script type="text/javascript">
					jQuery(document).ready(function($){
						$(".post-slider").flexslider({
							animation: "slide",
							pauseOnHover: true,
							controlNav: false
						});
					});		
					</script>';
		} else {
			$out .='<script type="text/javascript">
					jQuery(document).ready(function($){
						$(".post-slider-thumb").flexslider({
							animation: "slide",
							controlNav: false,
							itemWidth: 120,
							itemMargin: 20,
							asNavFor: ".post-slider"
						});

						$(".post-slider").flexslider({
							animation: "slide",
							pauseOnHover: true,
							controlNav: false,
							sync: ".post-slider-thumb"
						});
					});		
					</script>';
		}	

		$out .= '<div class="post-slider flexslider">';
		$out .= '<ul class="slides">';

		foreach ( $sliders as $image ){
			
			$image_url = wp_get_attachment_image_src($image, $size);

			$out .= '<li>';
			$out .= '<img src="' . $image_url[0] . '">';
			$out .= '</li>';
		
		}

		$out .= '</ul>';
		$out .= '</div>';
		
		if ( $slide_sytle == 2 ) {
			$out .= '<div class="post-slider-thumb flexslider">';
			$out .= '<ul class="slides">';
			
			foreach ( $sliders as $thumb ){
				
				$thumb_url = wp_get_attachment_image_src($thumb, 'thumb-medium');

				$out .= '<li>';
				$out .= '<img src="' . $thumb_url[0] . '">';
				$out .= '</li>';
			
			}

			$out .= '</ul>';
			$out .= '</div>';
		}

		return $out;	
	}
}

/* ---------------------------------------------------------------------- */
/*	Team Member
/* ---------------------------------------------------------------------- */

/* Single Team */ 
if ( ! function_exists( 'sp_single_team_meta' ) ) {
	function sp_single_team_meta( $size = 'thumbnail', $style = 'default' ){
		global $post;

		$out = '';
		$out .= '<div class="sp-team ' . $style . '">';
		if ( has_post_thumbnail() ) :
			$out .= get_the_post_thumbnail($post->ID, $size);
		else :
			$out .= '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME .'images/placeholder/people-placeholder.jpg">';	
		endif;
		$out .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
	    $out .= '<h5>' . get_post_meta( get_the_ID(), 'sp_team_position', true) . '</h5>';
	    $out .= '<a class="team-email" href="mailto:' . antispambot(get_post_meta( get_the_ID(), 'sp_team_email', true)) . '">' . antispambot(get_post_meta( get_the_ID(), 'sp_team_email', true)) . '</a>';
	    $out .= '</div>';

		return $out;	
	}
}

/* Get team member */ 
if ( ! function_exists( 'sp_get_team_member' ) ) {
	function sp_get_team_member( $category_id = '', $numberposts = '10' ){
		global $post;

		$out = '';

		$args = array(
			'post_type' => 'team',
			'post_status' => 'publish',
			'posts_per_page' => $numberposts,
			'tax_query' => array(
				array(
					'taxonomy' => 'team-category',
					'field' => 'term_id',
					'terms' => $category_id
				)
			)	
			);
		$custom_query = new WP_Query( $args );

		$out .='<script type="text/javascript">
					jQuery(document).ready(function($){
						$(".team-carousel").flexslider({
							animation: "slide",
							controlNav: false,
							itemWidth: 218,
							itemMargin: 5
						});
					});		
					</script>';

		$out .= '<div class="team-carousel flexslider">';
		$out .= '<ul class="slides">';
		while ( $custom_query->have_posts() ) : $custom_query->the_post();

			$team_position = get_post_meta($post->ID, 'sp_team_position', true);
        	$team_email = get_post_meta($post->ID, 'sp_team_email', true);

        	$out .= '<li>';
        	$out .= '<figure class="sp-team ' . $post->ID . '">';
			$out .= sp_single_team_meta( 'large' );
			$out .= '</figure>';
			$out .= '</li>';
		
		endwhile;
		wp_reset_postdata();

		$out .= '</ul>';
		$out .= '</div>';
		return $out;	
	}
}

/* ---------------------------------------------------------------------- */
/*	Client
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_client' ) ) {
	function sp_get_client( $style = 'light', $numberposts = '10' ){
		global $post;

		$out = '';
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'client',
			'post_status' => 'publish',
			'posts_per_page' => $numberposts,
			'paged' => $paged
			);
		$custom_query = new WP_Query( $args );

		while ( $custom_query->have_posts() ) : $custom_query->the_post();

			$testimonial_photo = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
			$testimonial_text = get_the_content();
        	$testimonial_cite = get_post_meta($post->ID, 'sp_testimonial_cite', true);
        	$testimonial_cite_subtext = get_post_meta($post->ID, 'sp_testimonial_cite_subtext', true);

        	$out .= '<figure class="testimonial ' . $style . '">';
			$out .= '<blockquote>';
			$out .= $testimonial_text;
			$out .= '</blockquote>';
			if ( has_post_thumbnail() ) :
				$out .= '<a href="' . $testimonial_photo[0] . '">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</a>';
			else :
				$out .= '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME .'images/placeholder/people-placeholder.jpg">';	
			endif;
			$out .= '<figcaption>';
			$out .= '<p>' . get_the_title() . '</p>';
			$out .= '<span>' . do_shortcode($testimonial_cite) . '</span>';
			if ( $testimonial_cite_subtext )
				$out .= '<span>' . do_shortcode($testimonial_cite_subtext) . '</span>';
			$out .= '</figcaption>';
			$out .= '</figure>';
		
		endwhile;
		wp_reset_postdata();
		// Pagination
        if(function_exists('wp_pagenavi'))
            $out .= wp_pagenavi();
        else 
            $out .= sp_pagination($custom_query->max_num_pages);

		return $out;	
	}
}

/* ---------------------------------------------------------------------- */
/*	FAQs
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_faqs' ) ) {
	function sp_get_faqs( $numberposts = '10' ){
		global $post;

		$out = '';
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'faq',
			'post_status' => 'publish',
			'posts_per_page' => $numberposts,
			'paged' => $paged
			);
		$custom_query = new WP_Query( $args );

		$out .= '<div class="accordion small one clearfix" data-opened="0">';
		while ( $custom_query->have_posts() ) : $custom_query->the_post();
			$content = get_the_content();
            $content = apply_filters( 'the_content', get_the_content() );
            $content = str_replace( ']]>', ']]&gt;', $content );

            $out .= '<section>';
            $out .= '<h4>' . get_the_title() . '</h4>';
            $out .= '<div>' . $content . '</div>';
            $out .= '</section>';
		endwhile;
		wp_reset_postdata();
		$out .= '</div>';
		// Pagination
        if(function_exists('wp_pagenavi'))
            $out .= wp_pagenavi();
        else 
            $out .= sp_pagination($custom_query->max_num_pages);

		return $out;	
	}
}

/* ---------------------------------------------------------------------- */
/*	Get logos by type 
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_logos_by_type' ) ) {
	function sp_get_logos_by_type( $term_id = '', $logo_num = 10 ) {

		global $post;

		$out = '';
		$args = array(
			 'post_type' =>	'logo',
             'posts_per_page' => $logo_num,
             'post_status' => 'publish',
             'tax_query' => array(
                    array(
                        'taxonomy' => 'logo-type',
                        'field' => 'id',
                        'terms' => lang_object_ids(array($term_id), 'logo-type')
                    )
                )
        );
        $sponsors = new WP_Query( $args );

        if( $sponsors->have_posts() ) :
        	
        	$out .='<script type="text/javascript">
					jQuery(document).ready(function($){
						$(".partner-logos").flexslider({
							animation: "slide",
							controlNav: false,
							itemWidth: 183,
							itemMargin: 5
						});
					});		
					</script>';

        	$out .= '<div class="partner-logos flexslider">';
        	$out .= '<ul class="slides">';
            while ( $sponsors->have_posts() ) : $sponsors->the_post();
        		$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
        		$logo_resized = aq_resize( $thumb_url[0], 250, 80 );
                if ( has_post_thumbnail() ) :
                    $out .= '<li><img src="' . $logo_resized . '"></li>'; 
                else : 
                	$out .= '<li><img src="' . SP_ASSETS_THEME .'images/placeholder/partner-logo-placeholder.jpg"></li>';	
                endif;
            endwhile; wp_reset_postdata();
            $out .= '</ul>';
            $out .= '</div>';
        endif;

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Branch
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'sp_get_branch_by_tax' ) ) {
	function sp_get_branch_by_tax( $term_id = '', $postnum = 10 ){

		global $post;

		$out = '';
		$args = array(
			 'post_type' =>	'branch',
             'posts_per_page' => $postnum,
             'post_status' => 'publish',
             'tax_query' => array(
                    array(
                        'taxonomy' => 'branch-location',
                        'field' => 'id',
                        'terms' => lang_object_ids(array($term_id), 'branch-location')
                    )
                )
        );
        $custom_query = new WP_Query( $args ); 
        if( $custom_query->have_posts() ) :
    
        $out .= map_branch_by_location( $term_id, $postnum );
    	$out .= '<div class="brand-container">';

        while ( $custom_query->have_posts() ) : $custom_query->the_post();
    	$out .= '<div class="two-fourth">';	
		$out .= '<ul class="branch-info">';
		$out .= '<li class="name"><h5>' . get_the_title() . '</h5></li>';
		$out .= '<li class="address">' . get_post_meta( get_the_ID(), 'sp_branch_address', true) . '</li>';
		$out .= '<li>';
		$out .= '<span class="left">' . __('Tel:', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( get_the_ID(), 'sp_branch_tel', true) . '</span>';
		$out .= '</li>';
		$out .= '<li>';
		$out .= '<span class="left">' . __('E-mail:', SP_TEXT_DOMAIN ) . '</span><span class="right"><a href="mailto:' . antispambot(get_post_meta( get_the_ID(), 'sp_branch_email', true)) . '">' . antispambot(get_post_meta( get_the_ID(), 'sp_branch_email', true)) . '</a></span>';
		$out .= '</li>';
		$out .= '</ul>';
	    $out .= '</div>';
		endwhile; wp_reset_postdata();
		
	    $out .= '</div>';

	    endif;

		return $out;	
	}
}

if ( ! function_exists( 'map_branch_by_location' ) ) {
	function map_branch_by_location ( $term_id, $postnum ){
		global $post;
		?>

	    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">					
		  jQuery(document).ready(function ($)
			{
				var locations = [ 
			<?php
			$args = array(
				 'post_type' =>	'branch',
	             'posts_per_page' => $postnum,
	             'post_status' => 'publish',
	             'tax_query' => array(
	                    array(
	                        'taxonomy' => 'branch-location',
	                        'field' => 'id',
	                        'terms' => lang_object_ids(array($term_id), 'branch-location')
	                    )
	                )
	        );
	        $custom_query = new WP_Query( $args );

			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
        		$branch_photo = aq_resize( $thumb_url[0], 135, 90 );

				echo '[';
				echo '\'<div class="map-item-info clearfix">';
				if ( has_post_thumbnail() ) :
					echo '<img class="left wp-image-placeholder" src="' . $branch_photo . '">';
				else :
					echo '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME .'images/placeholder/thumb-small.png" width="135" height="90">';	
				endif;
				echo '<ul class="branch-info">';
				echo '<li class="name"><h5>' . get_the_title() . '</h5></li>';
				echo '<li class="address">' . get_post_meta( get_the_ID(), 'sp_branch_address', true) . '</li>';
				echo '<li>';
				echo '<span class="left">' . __('Tel:', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( get_the_ID(), 'sp_branch_tel', true) . '</span>';
				echo '</li>';
				echo '<li>';
				echo '<span class="left">' . __('E-mail:', SP_TEXT_DOMAIN ) . '</span><span class="right"><a href="mailto:' . antispambot(get_post_meta( get_the_ID(), 'sp_branch_email', true)) . '">' . antispambot(get_post_meta( get_the_ID(), 'sp_branch_email', true)) . '</a></span>';
				echo '</li>';
				echo '</ul></div>\'';
				echo ', ' . get_post_meta( get_the_ID(), 'sp_lat_long', true);
				echo '],';
			endwhile; wp_reset_postdata();
			?>	
		        ];
				
				var map = new google.maps.Map(document.getElementById('branch-map'), {
					  mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				
				var infowindow = new google.maps.InfoWindow();
				var bounds = new google.maps.LatLngBounds();
				var marker, i;

				for (i = 0; i < locations.length; i++) {  
				  marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map,
					travelMode: google.maps.TravelMode["Driving"], //Driving or Walking or Bicycling or Transit
					animation: google.maps.Animation.DROP,
				  });

				  bounds.extend(marker.position);
			
				  google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
					  map.panTo(marker.getPosition());	
					  infowindow.setContent(locations[i][0]);
					  infowindow.open(map, marker);
					}
				  })(marker, i));
				
				    google.maps.event.addListener(map, "click", function(){
					  infowindow.close();
					});
				};

				map.fitBounds(bounds);

				//(optional) restore the zoom level after the map is done scaling
				/*var listener = google.maps.event.addListener(map, "idle", function () {
				    map.setZoom(7);
				    google.maps.event.removeListener(listener);
				});*/
			});
		</script>
		<div id="branch-map"></div>

	<?php
	}
}	

/* ---------------------------------------------------------------------- */
/*	Branch
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'sp_get_exchange_rate' ) ) {
	function sp_get_exchange_rate(){

		$out = '';
		
		$args = array(
			'post_type'	=> 'exchange',
			'post_status' => 'publish'
		);
		$custom_query = new WP_Query( $args );

		if( $custom_query->have_posts() ) :
			$out .= '<table>';
			$out .= '<tr>';
			$out .= '<td>' . __('Currency', SP_TEXT_DOMAIN ) . '</td>';
			$out .= '<td>' . __('Selling', SP_TEXT_DOMAIN ) . '</td>';
			$out .= '<td>' . __('Buying', SP_TEXT_DOMAIN ) . '</td>';
			$out .= '</tr>';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$out .= '<tr>';
				$out .= '<td>' . get_the_title() . '</td>';
				$out .= '<td>' . get_post_meta( get_the_ID(), 'sp_sell_rate', true ) . '</td>';
				$out .= '<td>' . get_post_meta( get_the_ID(), 'sp_buy_rate', true ) . '</td>';
				$out .= '</tr>';
			endwhile; wp_reset_postdata();
			$out .= '</table>';
		endif;

		return $out;

	}
}

/* ---------------------------------------------------------------------- */
/*	Social icons - Widget
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_show_social_icons' ) ) {
	function sp_show_social_icons() {

		$social_icons = ot_get_option( 'social-links' );
		
		if ( $social_icons ) {
		$out = '<section class="social-btn clearfix icons">';
		$out .= '<ul>';
		
		foreach ($social_icons as $icons) {
			if ( $icons['social-icon'] == 'icon-facebook' )	
				$out .= '<li class="icon-facebook-squared"><a href="' . $icons['social-link'] . '" target="_self"></a></li>';
			
			if ( $icons['social-icon'] == 'icon-twitter' )
				$out .= '<li class="icon-twitter"><a href="' . $icons['social-link'] . '" target="_self"></a></li>';
			
			if ( $icons['social-icon'] == 'icon-gplus' )
				$out .= '<li class="icon-gplus"><a href="' . $icons['social-link'] . '" target="_self"></a></li>';
			
			if ( $icons['social-icon'] == 'icon-youtube' )	
				$out .= '<li class="icon-youtube"><a href="' . $icons['social-link'] . '" target="_self"></a></li>';
		}

		$out .= '</ul>';
		$out .= '</section>';

		return $out;
		} 

	}
}

