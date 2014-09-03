<?php

add_action( 'widgets_init', 'sp_service_widget' );
function sp_service_widget() {
	register_widget( 'sp_widget_service' );
}

/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/

class sp_widget_service extends WP_Widget {
	/*
	*****************************************************
	* widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-service';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Products & Services Nav', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-service',
			'description' => __( 'A widget that allows to view service as navigation','sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	}
		
		
	function widget( $args, $instance) {
		extract ($args);

		global $post;
		
		$current_service = $post->ID;
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title']);
		
		/* Before widget (defined by themes). */
		$out = $before_widget;
		
		/* Title of widget (before and after define by theme). */
		if ( $title )
			$out .= $before_title . $title . $after_title;
		
		$args = array(
				'post_type'		=>	'service',
				'order'			=> 	'ASC',
				'orderby'		=> 	'menu_order',
				'post_status'	=>	'publish'
			);
		$custom_query = new WP_Query( $args );
		if( $custom_query->have_posts() ) :
		$out .= '<ul>';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
			if ( get_the_ID() == $current_service ) {
				$out .= '<li class="current_page_item"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>'; 
			} else {
				$out .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>'; 
			}
			endwhile; wp_reset_postdata();
		$out .= '</ul>';	
		endif; 

		/* After widget (defined by themes). */		
		$out .= $after_widget;

		echo $out;
	}	
	
	/**
	 * Update the widget settings.
	 */	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Products & Services');
		$instance = wp_parse_args( (array) $instance, $defaults); ?>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sptheme_widget') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat">
		</p>
        
	   <?php 
    }
} //end class
?>