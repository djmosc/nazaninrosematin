<?php 

class Advert extends WP_Widget {

    function Advert() {
        $widget_opts = array( 'description' => __('Use this widget is to show a Advertiment.') );
        parent::WP_Widget(false, 'Advertisment', $widget_opts);
    }

    function form($instance) {
        $link = (isset($instance['link'])) ? esc_attr($instance['link']) : '';  
        echo '<p><label>';
        echo _e('Ad link:').'<input class="widefat" name="'. $this->get_field_name('link').'" type="text" value="'. $link.'" />';
        echo '</label></p>';
         $image_url_portrait = (isset($instance['image_url_portrait'])) ? esc_attr($instance['image_url_portrait']) : '';  
        echo '<p><label>';
        echo _e('Ad image url (portrait):').'<input class="widefat" name="'. $this->get_field_name('image_url_portrait').'" type="text" value="'. $image_url_portrait.'" />';
        echo '</label><small>Recommended size: 300x600</small></p>';

        $image_url_landscape = (isset($instance['image_url_landscape'])) ? esc_attr($instance['image_url_landscape']) : '';  
        echo '<p><label>';
        echo _e('Ad image url (landscape):').'<input class="widefat" name="'. $this->get_field_name('image_url_landscape').'" type="text" value="'. $image_url_landscape.'" />';
        echo '</label><small>Recommended size: 600x300</small></p>';
    }

    function update($new_instance, $old_instance){
        return $new_instance;
    }

    function widget($args, $instance) {
        global $post;
        $args['link'] = $instance['link'];
        $args['image_url_landscape'] = $instance['image_url_landscape'];
        $args['image_url_portrait'] = $instance['image_url_portrait'];

        echo $args['before_widget'];?>
        <a href="<?php echo $args['link']; ?>" target="_blank">
            <img src="<?php echo get_template_directory_uri().'/images/misc/blank.gif'; ?>" data-src-landscape="<?php echo $args['image_url_landscape']; ?>" data-src-portrait="<?php echo $args['image_url_portrait']; ?>" class="scale" />
        </a>
        <?php echo $args['after_widget'];
    }
}

register_widget('Advert');