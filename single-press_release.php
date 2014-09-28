
<?php get_header(); ?>

<div id="single-press-release" >

<?php while ( have_posts() ) : the_post(); ?>
	<?php 
		$class = array();
		$class[] = (has_post_thumbnail()) ? 'has-featured-image' : 'no-featured-image';
		$class[] = 'single';
		$type = get_field('type');
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(implode(' ', $class)); ?>>
	
		<?php get_template_part('inc/press-release-header'); ?>	

		<?php get_template_part('inc/content'); ?>

		<?php get_template_part('inc/post-meta'); ?>

	</article>
<?php endwhile; // end of the loop. ?>

</div><!-- #single -->
<?php get_footer(); ?>
