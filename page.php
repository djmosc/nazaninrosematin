
<?php get_header(); ?>

<div id="page" >

<?php while ( have_posts() ) : the_post(); ?>
	<?php 
		$class = array();
		$class[] = (has_post_thumbnail()) ? 'has-featured-image' : 'no-featured-image';
		$class[] = 'single';
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(implode(' ', $class)); ?>>
		
		<?php get_template_part('inc/page-header'); ?>

		<?php get_template_part('inc/content'); ?>

	</article>
<?php endwhile; // end of the loop. ?>

</div><!-- #page -->
<?php get_footer(); ?>
