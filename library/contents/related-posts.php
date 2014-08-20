<?php //$related = sp_related_posts(); ?>
<?php $related = sp_get_posts_related_by_taxonomy(get_the_ID(), 'category', array('posts_per_page' => 3)); ?>

<?php if ( $related->have_posts() ): ?>
<section class="related-posts">
<h4 class="heading"><?php _e('You may also like...', SP_TEXT_DOMAIN); ?></h4>

<ul class="clearfix">
	
	<?php while ( $related->have_posts() ) : $related->the_post(); ?>
	<li class="related post-hover">
		<article <?php post_class(); ?>>

			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php if ( has_post_thumbnail() ): ?>
						<?php the_post_thumbnail('thumb-medium'); ?>
					<?php elseif ( ot_get_option('placeholder') != 'off' ): ?>
						<img class="wp-image-placeholder" src="<?php echo SP_ASSETS_THEME; ?>images/placeholder/thumb-medium.png" alt="<?php the_title(); ?>" />
					<?php endif; ?>
				</a>
			</div><!--/.post-thumbnail-->
			
			<div class="related-inner">
				
				<h4 class="post-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h4><!--/.post-title-->
				
				<div class="entry-meta clearfix">
					<p class="post-date"><?php the_time('j M, Y'); ?></p>
				</div><!--/.post-meta-->
			
			</div><!--/.related-inner-->

		</article>
	</li><!--/.related-->
	<?php endwhile; ?>

</ul><!--/.post-related-->
</section>
<?php endif; ?>

<?php wp_reset_query(); ?>
