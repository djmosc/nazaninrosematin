
<?php get_header(); ?>

<section id="page" >
<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php get_template_part('inc/post-header'); ?>

		<?php get_template_part('inc/post-content'); ?>

	</article>
<?php endwhile; // end of the loop. ?>
</section><!-- #page -->
<?php get_footer(); ?>
