<?php 

class Widget_Popular_Posts extends WP_Widget {

	function __construct() {
		$widget_opts = array( 'description' => __('Use this widget to show the popular posts') );
		parent::WP_Widget(false, 'Popular Posts', $widget_opts);
	}

	function form($instance) {
		$title = (isset($instance['title'])) ? esc_attr($instance['title']) : ''; 
		$sub_title = (isset($instance['sub_title'])) ? esc_attr($instance['sub_title']) : ''; 
		?>
        <p>
        	<label><?php _e('Title:') ?><input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title ?>" /></label>
        </p>
        <p>
        	<label><?php _e('Sub Title:') ?><input class="widefat" name="<?php echo $this->get_field_name('sub_title'); ?>" type="text" value="<?php echo $sub_title ?>" /></label>
        </p>
        <?php
	}

	function update($new_instance, $old_instance){
		return $new_instance;
	}

	function widget($args, $instance) {
		global $post;

		$posts = get_field('posts', 'widget_'.$args['widget_id']);

		if( !empty($posts) ) {
			$keys = array_rand($posts, 8);
			$temp_posts = array();

			foreach ($keys as $key) {
			    $temp_posts[$key] = $posts[$key];
			}

			$posts = $temp_posts;
		}
		
		if( $posts ) :
		echo $args['before_widget'];
		?>
			<header class="widget-header header">
				<?php echo $args['before_title'].$instance['title'].$args['after_title'];?>
				<hr />
				<p class="sub-title"><?php echo $instance['sub_title']; ?></p>

				<p>
					<a href="<?php echo get_permalink( get_option('page_for_posts') )?>" class="archive-btn white-btn"><?php _e("View archive", THEME_NAME); ?></a>
				</p>
			</header>
			<div class="posts">
				<div class="inner clearfix">
					<?php foreach($posts as $post) : ?>
					<?php setup_postdata($post); ?>
					<a href="<?php the_permalink(); ?>" class="post-btn overlay-btn">

						<figure class="featured-image thumbnail">
							<?php the_post_thumbnail( array( 200, 250, 'bfi_thumb' => true ) ); ?>
						</figure>
						<div class="overlay">
							<header class="header">
								<?php //get_template_part('inc/post-category'); ?>
								<h5 class="title"><?php the_title(); ?></h5>
								<span class="white-btn"><?php _e("Read More", THEME_NAME); ?></span>
							</header>
						</div>
					</a>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		<?php
		echo $args['after_widget'];
		endif;
	}
}

register_widget('Widget_Popular_Posts');