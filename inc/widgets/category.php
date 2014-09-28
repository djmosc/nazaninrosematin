<?php 

class Category extends WP_Widget {

	function Category() {
		$widget_opts = array( 'description' => __('Use this widget is to show a category') );
		parent::WP_Widget(false, 'Category', $widget_opts);
	}

	function form($instance) {
		$category_id = (isset($instance['category_id'])) ? esc_attr($instance['category_id']) : '';
	?>
		<p>
			<label>Category: 
				<?php wp_dropdown_categories(array('hierarchical' => true, 'selected' => $category_id, 'show_option_none' => false, 'show_option_all' => false, 'name' => $this->get_field_name('category_id'))); ?>
			</label>
		</p>
		
	<?php 
	}

	function update($new_instance, $old_instance){
		return $new_instance;
	}

	function widget($args, $instance) {
		global $post;
		
		$args['category_id'] = (isset($instance['category_id'])) ? $instance['category_id'] : null;				
		$category = get_category($args['category_id']);	

		if($category) :
			echo $args['before_widget'];

			$image_id = get_field('image', 'category_'.$category->term_id);
			$image_attributes = wp_get_attachment_image_src( $image_id, array( 400, 180, 'bfi_thumb' => true) ); ?>
		<a class="btn" href="<?php echo get_term_link($category); ?>">
			<div class="cta-container">
				<span class="black-btn skew"><span><?php echo $category->name; ?></span></span>
			</div>
			<div class="image">
				<img src="<?php echo $image_attributes[0]; ?>">
			</div>
		</a>
		<?php
		echo $args['after_widget'];	
		wp_reset_postdata();
		wp_reset_query();
		endif;
	}
}

register_widget('Category');