<?php if( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || ( !empty($_GET['ajax']) && $_GET['ajax'] == 1) ) : ?>
	<?php get_template_part('inc/posts-grid'); ?>
<?php else: ?>
	<?php get_header(); ?>
	<?php wp_enqueue_script('ajaxposts'); ?>
	<section id="archive-press-release" >
		
		<div class="container inner">
			<header class="lined-header header">
				<h2 class="title"><?php _e("Press", THEME_NAME); ?></h2>
			</header>
			<?php get_template_part('inc/posts-grid'); ?>
			<footer class="archive-footer footer">
				<div class="pagination">
					<?php next_posts_link(__("Next Page", THEME_NAME)); ?>
				</div>
			</footer>
		</div>
	</section><!-- #archive-press-release -->
	<?php get_footer(); ?>
<?php endif; ?>