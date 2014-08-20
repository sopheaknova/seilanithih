<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>
<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div id="main" class="main">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post(); 
		?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
					<header class="entry-header">
						<h1 class="entry-title">
							<?php the_title(); ?>
						</h1>
					</header>

					<div class="entry-content">
					<ul class="branch-info">
					<?php
						$out = '<li class="address">' . get_post_meta( get_the_ID(), 'sp_branch_address', true) . '</li>';
						$out .= '<li>';
						$out .= '<span class="left">' . __('Tel:', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( get_the_ID(), 'sp_branch_tel', true) . '</span>';
						$out .= '</li>';
						$out .= '<li>';
						$out .= '<span class="left">' . __('E-mail:', SP_TEXT_DOMAIN ) . '</span><span class="right">' . get_post_meta( get_the_ID(), 'sp_branch_email', true) . '</span>';
						$out .= '</li>';
						echo $out;
					?>
					</ul>
					</div><!-- .entry-content -->

				</article><!-- #post -->

		<?php		
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			endwhile;
		?>
		
	</div><!-- #main -->
	<?php get_sidebar();?>
<?php do_action( 'sp_end_content_wrap_html' ); ?>
<?php get_footer(); ?>