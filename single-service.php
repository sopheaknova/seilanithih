<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>
<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div id="main" class="main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php echo sp_sliders( 2, $post->ID, 'large' ); ?>
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php if ( ot_get_option('social_share') != 'off' ) { get_template_part('library/contents/social-share'); } ?>
			</article><!-- #post -->
		<?php endwhile;
		else : 
			get_template_part('library/contents/error404');
		endif; ?>
	</div><!-- #main -->
	<?php get_sidebar();?>
<?php do_action( 'sp_end_content_wrap_html' ); ?>
	
<?php get_footer(); ?>