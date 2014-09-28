<?php $layout = get_layout(); ?>
<?php if( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || ( !empty($_GET['ajax']) && $_GET['ajax'] == 1) ) : ?>
	<?php 
		switch( $layout ): 
			case 'full':
				get_template_part('inc/posts-full');
			break;
			case 'list':
				get_template_part('inc/posts-list');
			break;
			case 'grid':
			default:
				get_template_part('inc/posts-grid');
			break;
		endswitch;
	?>
<?php else: ?>
	<?php get_header(); ?>
	
	<section id="index" class="layout-<?php echo $layout; ?>">
		<?php 
		switch( $layout ): 
			case 'full':
		?>
		<?php get_template_part('inc/posts-full'); ?>
		<footer class="index-footer footer">
			<div class="navigation container">

				<?php previous_posts_link(__("Newer", THEME_NAME)); ?>
			
				<?php next_posts_link(__("Older", THEME_NAME)); ?>
			</div>
		</footer>
		<?php 
		break;	
		case 'list':
			wp_enqueue_script('ajaxposts');
		?>
		<header class="lined-header header container">
			<h2 class="title"><?php _e("Archive", THEME_NAME); ?></h2>
		</header>
		<?php get_template_part('inc/posts-list'); ?>
		<footer class="index-footer footer">
			<div class="pagination container">
				<?php next_posts_link(__("Next Page", THEME_NAME)); ?>
			</div>
		</footer>
		<?php 
		break;
		case 'grid':
		default: 
			wp_enqueue_script('ajaxposts');
			
			$category_id = get_query_var('cat');
		?>
		<div class="container inner">
			<header class="lined-header header">
				<h2 class="title"><?php _e("Archive", THEME_NAME); ?></h2>
			</header>
			<div class="filters clearfix">
				<div class="span three omega alpha hide-on-tablet">
					<p class="label">
						<?php _e("You are viewing:", THEME_NAME); ?>
						<?php if( is_category() || $category_id ): ?>
						<?php 
							
							$category = get_category($category_id);

							if($category->parent != 0) $parent_category = get_category($category->parent);
						?>
						<span class="value"><?php 
						if( !empty($parent_category) ) echo $parent_category->name . ' - ';
						echo single_term_title(); 
						?></span>
						<?php else: ?>
						<span class="value"><?php _e("All", THEME_NAME); ?></span>
						<?php endif; ?>
					</p>
				</div>

				<?php
				$tag = get_query_var('tag');
				$category = ( !empty($category_id) ) ? get_top_level_category($category_id) : null;
				?>

				<form class="span seven right omega alpha break-on-tablet" action="<?php echo home_url(); ?>" mathod="GET">
					<input type="text" class="query" name="s" placeholder="Search" value="<?php echo esc_attr( get_search_query() ); ?>" />
					<?php if( $category && ((is_category() || $category_id) || $tag) ) : ?>
					<?php
						$tag_ids = get_field('tags', 'category_'.$category->term_id);

						if( !empty($tag_ids)) $tags = get_terms('post_tag', array('include' => $tag_ids, 'hide_empty' => 0, 'limit' => 4));

						if( !empty($tags)) :
						?>
						<select class="tag" name="tag">
							<option value=""><?php _e("Select a theme", THEME_NAME); ?></option>
							<?php foreach ($tags as $term) : ?>
							<option value="<?php echo $term->slug; ?>" <?php selected($term->slug, $tag); ?>><?php echo $term->name;  ?></option>
							<?php endforeach;?>
						</select>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php wp_dropdown_categories(array('class' => 'category', 'show_option_all' => __("All Categories", THEME_NAME), 'hierarchical' => 1, 'selected' => $category_id)); ?>
					
					<?php if( !( ( is_category() || $category_id ) && !get_query_var('m')) ) : ?>
					<select name="m" class="date">
						<option value=""><?php _e("Select a date", THEME_NAME); ?></option>
						<?php wp_get_archives(array('format' => 'option')); ?>
					</select>
					<?php endif; ?>

					<button type="submit" class="submit-btn search-btn" ></button>
				</form>
			</div>
			<?php get_template_part('inc/posts-grid'); ?>
			<footer class="index-footer footer">
				<div class="pagination">
					<?php next_posts_link(__("Next Page", THEME_NAME)); ?>
				</div>
			</footer>
		</div>
		<?php endswitch; ?>
	</section><!-- #page -->
	<?php get_footer(); ?>
<?php endif; ?>