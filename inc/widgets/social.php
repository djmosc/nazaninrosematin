<?php 

class Social extends WP_Widget {

    function Social() {
        $widget_opts = array( 'description' => __('Use this widget is to show the social links and newsletter subscribe form.') );
        parent::WP_Widget(false, 'Social', $widget_opts);
    }

    function form($instance) {
        $form_id = (isset($instance['form_id'])) ? esc_attr($instance['form_id']) : '';  
        echo '<p><label>';
        echo _e('Form Id:').'<input class="widefat" name="'. $this->get_field_name('form_id').'" type="text" value="'. $form_id.'" />';
        echo '</label></p>';
       
    }

    function update($new_instance, $old_instance){
        return $new_instance;
    }

    function widget($args, $instance) {
        global $post;
        
        $args['form_id'] = $instance['form_id'];

        echo $args['before_widget'].$args['before_title'];?>
        <a href="http://www.twitter.com/peonylim" class="corner-btn">@peonylim</a>
        <?php echo $args['after_title']; ?>  
        <?php get_template_part('inc/social-links'); ?>
        <?php gravity_form( $args['form_id'] ); ?>
        <?php 
        echo $args['after_widget'];
    }
}

register_widget('Social');