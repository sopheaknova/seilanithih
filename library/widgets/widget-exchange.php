<?php

add_action( 'widgets_init', 'sp_exchange_widget' );
function sp_exchange_widget() {
	register_widget( 'sp_widget_exchange' );
}

/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/

class sp_widget_exchange extends WP_Widget {
	/*
	*****************************************************
	* widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-exchange';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Exchange Rate', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-exchange',
			'description' => __( 'A widget to present exchange rate table','sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	}
		
		
	function widget( $args, $instance) {
		extract ($args);
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title']);
		$date_rate = $instance['date_rate'];
		
		/* Before widget (defined by themes). */
		$out = $before_widget;
		
		/* Title of widget (before and after define by theme). */
		if ( $title )
			$out .= $before_title . $title . $after_title;

		$out .= sp_get_exchange_rate();
		$out .= '<small>' . $date_rate . '</small>';
	
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
		$instance['date_rate'] = strip_tags( $new_instance['date_rate'] );

		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form( $instance ) {
		global $post;
		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => 'Exchange Rate',
			'date_rate' => 'Exchange Rate on 13 August, 2014 07:00'
			);
		$instance = wp_parse_args( (array) $instance, $defaults); 

		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sptheme_widget') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'date_rate' ); ?>"><?php _e('Date:', 'sptheme_widget') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'date_rate' ); ?>" name="<?php echo $this->get_field_name( 'date_rate' ); ?>" value="<?php echo $instance['date_rate']; ?>"  class="widefat">
		</p>
        
	   <?php 
    }
} //end class
?>