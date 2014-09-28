<?php 
/*
 *
 * Template Name: About
 *
 */
?>
<?php get_header(); ?>
<section id="template-about">
	<div class="inner clearfix">
	<?php if( have_posts() ): ?>
		<?php get_template_part('inc/post-header'); ?>
		<div class="span three image">
			<?php the_post_thumbnail(); ?>
		</div>
		<div class="span seven content">
			<?php get_template_part('inc/post-content'); ?>
		</div>
	<?php endif; ?>		
	</div>
</section><!-- #template-about -->
<?php get_footer(); ?>