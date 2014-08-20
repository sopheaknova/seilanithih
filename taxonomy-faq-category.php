<?php get_header(); ?>
<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>	
	<div id="main" class="main">

		<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php echo $term->name; ?>
			</h1>
		</header><!-- .page-header -->

		<?php
				// Start the Loop.
				echo '<ul>';
				while ( have_posts() ) : the_post();
				echo '<li><a href="' . get_permalink() .'" title="' . sprintf( esc_attr__( 'Permalink to %s', SP_TEXT_DOMAIN ), the_title_attribute( 'echo=0' ) ) . '">' . get_the_title() . '</a></li>';				
				endwhile;
				echo '</ul>';

			else :
				// If no content, include the "No posts found" template.
				get_template_part('library/content/error404');

			endif;
		?>
	</div><!-- #main -->
	<?php get_sidebar();?>
	<?php do_action( 'sp_end_content_wrap_html' ); ?>
</div><!-- #content -->	
<?php get_footer(); ?>
