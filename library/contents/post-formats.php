<?php $meta = get_post_custom($post->ID); ?>

<?php if ( has_post_format( 'audio' ) ): // Audio ?>
	
	<div class="post-format">		
		<?php
			$embed_url = get_post_meta( $post->ID, 'sp_audio_external', true ); 
			echo sp_soundcloud($embed_url); 
		?>	
	</div>
	
<?php endif; ?>

<?php if ( has_post_format( 'gallery' ) ): // Gallery ?>
	
	<div class="post-format">
		<?php $images = sp_post_images(); if ( !empty($images) ): ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
			 	/* Single Post slider */
				$('#post-slider-<?php echo the_ID(); ?>').flexslider({
					animation: "slide",
					slideshowSpeed: 5000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
					animationDuration: 200,         //Integer: Set the speed of animations, in milliseconds
					animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
					pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
					pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
					before: function(slider) {
					    $('.flex-caption').delay(100).fadeOut(100);
					},
					after: function(slider) {
					  $('.flex-active-slide').find('.flex-caption').delay(200).fadeIn(400);
					}
				});
			});
		</script>
		<div class="flex-container">
			<div class="flexslider" id="post-slider-<?php the_ID(); ?>">
				<ul class="slides">
					<?php foreach ( $images as $image ): ?>
						<li>
							<?php $imageid = wp_get_attachment_image_src($image->ID,'post-slider'); ?>
							<img src="<?php echo $imageid[0]; ?>" alt="<?php echo $image->post_title; ?>">
							
							<?php if ( $image->post_excerpt ): ?>
								<p class="flex-caption"><?php echo $image->post_excerpt; ?></p>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
	</div>
	
<?php endif; ?>

<?php if ( has_post_format( 'image' ) || !has_post_format() ): // Image ?>

	<div class="post-format">
		<div class="wp-caption">
			<?php if ( has_post_thumbnail() ) {	
				the_post_thumbnail('large'); 
				$caption = get_post(get_post_thumbnail_id())->post_excerpt;
				if ( isset($caption) && $caption && is_singular() ) echo '<p class="wp-caption-text">'.$caption.'</p>';
			} ?>
		</div>
	</div>
	
<?php endif; ?>

<?php if ( has_post_format( 'video' ) ): // Video ?>

	<div class="post-format">
		<?php 
			if ( isset($meta['sp_video_url'][0]) && !empty($meta['sp_video_url'][0]) ) {
				global $wp_embed;
				$video = $wp_embed->run_shortcode('[embed]'.$meta['sp_video_url'][0].'[/embed]');
				echo $video;
			} elseif ( isset($meta['sp_video_embed_code'][0]) && !empty($meta['sp_video_embed_code'][0]) ) {
				echo '<div class="video-container">';
				echo $meta['sp_video_embed_code'][0];
				echo '</div>';
			}
		?>	
	</div>
	
<?php endif; ?>

<?php if ( has_post_format( 'quote' ) ): // Quote ?>

	<div class="post-format">
		<div class="format-container">
			<blockquote><?php echo isset($meta['sp_quote'][0])?wpautop($meta['sp_quote'][0]):''; ?></blockquote>
			<p class="quote-author"><?php echo (isset($meta['sp_quote_author'][0])?'&mdash; '.$meta['sp_quote_author'][0]:''); ?></p>
		</div>
	</div>
	
<?php endif; ?>

<?php if ( has_post_format( 'chat' ) ): // Chat ?>

	<div class="post-format">
		<div class="format-container">
			<blockquote>
				<?php echo (isset($meta['sp_chat'][0])?wpautop($meta['sp_chat'][0]):''); ?>
			</blockquote>
		</div>
	</div>
	
<?php endif; ?>

<?php if ( has_post_format( 'link' ) ): // Link ?>

	<div class="post-format">
		<div class="format-container">
			<p><a href="<?php echo (isset($meta['sp_link_url'][0])?$meta['sp_link_url'][0]:'#'); ?>">
				<i class="fa fa-link"></i>
				<?php echo (isset($meta['sp_link_title'][0])?$meta['sp_link_title'][0]:get_the_title()); ?> &rarr;
			</a></p>
		</div>
	</div>
	
<?php endif; ?>
