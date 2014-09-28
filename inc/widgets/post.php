<?php 

class Post extends WP_Widget {

	function Post() {
		$widget_opts = array( 'description' => __('Use this widget is to show a post by it\'s position or by it\'s name.') );
		parent::WP_Widget(false, 'Post', $widget_opts);
	}

	function form($instance) {
		$offset = (isset($instance['offset'])) ? esc_attr($instance['offset']) : '1';
		$category_id = (isset($instance['category_id'])) ? esc_attr($instance['category_id']) : '';
		$post_id = (isset($instance['post_id'])) ? esc_attr($instance['post_id']) : '';
		$size = (isset($instance['size'])) ? esc_attr($instance['size']) : 'small';
		$custom_query = new WP_Query( array('no_found_rows' => true, 'post_type' => array('post'), 'order' => 'DESC', 'post_status' => 'publish', 'posts_per_page' => 50)); 
	?>
		<p>
			<label>Select post number&nbsp;&nbsp;<input class="widefat" style="width: 40px;" name="<?php echo $this->get_field_name('offset') ?>" type="text" value="<?php echo $offset; ?>" /></label>
			&nbsp;&nbsp;
			<label>in&nbsp;&nbsp;
				<?php wp_dropdown_categories(array('hierarchical' => true, 'selected' => $category_id, 'show_option_none' => 'Current', 'show_option_all' => 'All', 'name' => $this->get_field_name('category_id'))); ?>
			</label>
		</p>
		<p>
		 <?php if ( $custom_query->have_posts() ) : ?>
			
			<label>or a specific post:
				<select name="<?php echo $this->get_field_name('post_id'); ?>" style="width: 170px;">
					<option value="">--None--</option>
					<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();  ?>
					<option value="<?php echo get_the_ID() ?>"  <?php if(get_the_ID() == $post_id) echo 'selected'; ?> ><?php the_title(); ?></option>
					<?php endwhile; ?>
				</select>
			</label>
		<?php endif; ?>
		</p>
	<?php 
	}

	function update($new_instance, $old_instance){
		return $new_instance;
	}

	function widget($args, $instance) {
		global $post;
		$args['offset'] = ($instance['offset']) ? intval($instance['offset']) - 1 : 0;
		$args['category_id'] = (isset($instance['category_id']) && $instance['category_id'] != 0) ? $instance['category_id'] : '';		
		$args['post_id'] = (isset($instance['post_id'])) ? $instance['post_id'] : null;
		
		$options = array('posts_per_page' => 1, 'post_type' => array('post'), 'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish');
		if($args['post_id']){
			$options['p'] = $args['post_id'];
		} else {
			$options['offset'] = $args['offset'];
			if($args['category_id']){
				$options['category__in'] = array($args['category_id']);
			}
		}

		$custom_query = new WP_Query($options);

		if ( $custom_query->have_posts() ) :
			echo $args['before_widget'];
			while ( $custom_query->have_posts() ) : $custom_query->the_post();

				$title = get_the_title();
				
				$image_id = get_post_thumbnail_id(get_the_ID());
				$image = wp_get_attachment_image_src( $image_id, array(600, 808, 'bfi_thumb' => true) );
				if($image):
			?>
				<a href="<?php the_permalink(); ?>" class="thumbnail featured-image">
					<img src="<?php echo $image[0]?>" />
				</a>
				<div class="content <?php echo (strlen($title) > 30) ? 'title-long' : 'title-short'; ?>">
					<div class="inner">
						<?php get_template_part( 'inc/post-category'); ?>
						<h4 class="title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h4>						
						<hr />
						<div class="excerpt"><?php echo get_excerpt(100); ?></div>
						<!--div class="meta">
							<span class="date"><?php the_time(get_option('date_format')); ?></span>
							<a href="<?php the_permalink(); ?>#comments" class="comments-btn">36</a>
						</div-->
						<a class="read-more-btn white-btn" href="<?php the_permalink(); ?>"><?php _e("Read More", THEME_NAME); ?></a>
					</div>
				</div>
			<?php
				endif;
			endwhile;
			echo $args['after_widget'];	
			wp_reset_postdata();
			wp_reset_query();
		endif;
	}
}

register_widget('Post');
