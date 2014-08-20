<?php

add_action( 'widgets_init', 'sp_logos_widget' );
function sp_logos_widget() {
	register_widget( 'sp_widget_logos' );
}

/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/

class sp_widget_logos extends WP_Widget {
	/*
	*****************************************************
	* widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-logos';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Logos', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-logos',
			'description' => __( 'A widget to present logo by category','sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	}
		
		
	function widget( $args, $instance) {
		extract ($args);
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title']);
		$logo_type = $instance['logo_type'];
		$logo_num = $instance['logo_num'];
		
		/* Before widget (defined by themes). */
		$out = $before_widget;
		
		/* Title of widget (before and after define by theme). */
		if ( $title )
			$out .= $before_title . $title . $after_title;

		$out .= sp_get_logos_by_type( $logo_type, $logo_num );
	
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
		$instance['logo_type'] = strip_tags( $new_instance['logo_type'] );
		$instance['logo_num'] = strip_tags( $new_instance['logo_num'] );

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
			'title' => 'Title', 
			'logo_type' => 'Select logo type',
			'logo_num' => '10');
		$instance = wp_parse_args( (array) $instance, $defaults); 

		$args = array(
				'hide_empty'	=> 0
			);
		$taxonomies = get_terms('logo-type', $args);

		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sptheme_widget') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat">
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'logo_type' ); ?>">Logo type: </label>
			<select id="<?php echo $this->get_field_id( 'logo_type' ); ?>" name="<?php echo $this->get_field_name( 'logo_type' ); ?>">
				<?php foreach ( $taxonomies as $term ) : ?>
				<option value="<?php echo $term->term_id; ?>" <?php if ( $instance['logo_type'] == $term->term_id ) { echo ' selected="selected"' ; } ?>><?php echo $term->name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'logo_num' ); ?>">Number of logos: </label>
			<input id="<?php echo $this->get_field_id( 'logo_num' ); ?>" name="<?php echo $this->get_field_name( 'logo_num' ); ?>" value="<?php echo $instance['logo_num']; ?>" type="text" size="3" />
		</p>
        
	   <?php 
    }
} //end class
?>