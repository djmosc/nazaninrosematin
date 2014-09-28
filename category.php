<?php 
$category_id = get_query_var('cat');
$category = get_category($category_id);
?>
<?php if( !isset($_GET['dev']) || $category->parent != 0): ?>
<?php get_template_part('index'); ?>
<?php else: ?>
<?php
	$tag_ids = get_field('tags', 'category_'.$category_id);
	if( !empty($tag_ids)) $tags = get_terms('post_tag', array('include' => $tag_ids, 'hide_empty' => 0, 'limit' => 4));

	$secondary_tag_ids = get_field('secondary_tags', 'category_'.$category_id);
	if( !empty($secondary_tag_ids)) $secondary_tags = get_terms('post_tag', array('include' => $secondary_tag_ids, 'hide_empty' => 0, 'limit' => 4));

	$image = get_field('image', 'category_'.$category_id);
	if( $image ) $image_url = bfi_thumb($image['url'], array('width' => 1000, 'height' => 500));
?>
<?php get_header(); ?>
<section id="category">
	<header class="container lined-header category-header">
		<h5 class="title"><?php single_term_title(); ?></h5>
	</header>
	<div class="category-feature">
		<div class="inner container">
			<nav class="sub-category-navigation">
				<ul class="clearfix">
					<?php wp_list_categories(array('title_li' => '', 'child_of' => $category_id, 'depth' => 1)); ?>
				</ul>
			</nav>
			<?php if( !empty($secondary_tags) || !empty($image_url) ): ?>
			<div class="tags-navigations">
				<?php if( !empty($image_url) ): ?>
				<figure class="category-image">
					<img src="<?php echo $image_url; ?>" />
				</figure>
				<?php endif; ?>
				<?php if( !empty($image_url) ): ?>
				<nav class="seconary-tags-navigation">
					<header class="header">
						<h5 class="title">Title</h5>
						<hr />
					</header>
					<ul>
						<?php foreach($secondary_tags as $tag): ?>
						<li>
							<a href="<?php echo get_term_link($tag); ?>"><?php echo $tag->name; ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</nav>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<?php if( !empty($tags) ): ?>
	<div class="tags">
		<div class="inner container">
			<header class="header tags-header">
				<h4 class="title"><?php _e("View by themes", THEME_NAME); ?></h4>
				<hr />
			</header>

			<ul class="tag-list clearfix">
			<?php 
				$i = 0; 
				$total = count($tags);
			?>
			<?php foreach($tags as $tag): ?>
				<?php 
					$class = array();
					$last = ($i == $total - 1);
					$first = ($i == 0);
					$size = ($first || $last) ? 'large' : 'small';
					$class[] = ($last) ? 'products' : 'tag';
					$class[] = $size;
					$image_size = ($size == 'small') ? array('width' => 400, 'height' => 400) : array('width' => 820, 'height' => 400)
				?>
				<li class="<?php echo implode(' ', $class); ?>">
					<?php if($i == $total - 1 ) : ?>
					<div class="inner">
						<?php get_template_part('inc/category-products'); ?>
					</div>
					<?php else: ?>
					<?php 
						$image = get_field('image', 'post_tag_'.$tag->term_id); 
						$image_url = bfi_thumb($image['url'], $image_size);
					?>
					<a href="<?php echo get_term_link($tag) ?>" style="background-image: url(<?php echo $image_url; ?>);" class="inner btn">
						<header class="header">
							<h5 class="title"><?php echo $tag->name; ?></h5>
							<?php if( !empty($tag->description) ): ?>
							<p class="description"><?php echo $tag->description; ?></p>
							<?php endif; ?>
						</header>
					</a>
					<?php endif; ?>
				</li>
				
			<?php $i++; ?>
			<?php endforeach; ?>

			</ul>
		</div>
	</div>
	<?php endif; ?>
	<footer class="category-footer footer container">
		<a class="posts-btn" href="<?php echo get_permalink(get_option('page_for_posts')); ?>"><?php echo sprintf(__("See all features in %s"), $category->name); ?></a>
	</footer>

	<?php get_template_part('inc/social-bar'); ?>

	<?php get_template_part('inc/popular'); ?>
</section><!-- #index -->
<?php get_footer(); ?>
<?php endif; ?>