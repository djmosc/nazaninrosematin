<?php get_header(); ?>

<div id="single" >

<?php while ( have_posts() ) : the_post(); ?>
	<?php 
		$class = array();
		$class[] = (has_post_thumbnail()) ? 'has-featured-image' : 'no-featured-image';
		$class[] = 'single';
		$type = get_field('type');
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(implode(' ', $class)); ?>>
	
		<?php get_template_part('inc/post-header'); ?>	

		<?php 
		if($type) :

			switch($type):

				case 'location':
					get_template_part('inc/post-locations');
				break;
				case 'recipe':
					get_template_part('inc/post-foods');
				break;
			endswitch;
		endif; 
		?>
		<?php get_template_part('inc/content'); ?>

		<?php get_template_part('inc/post-meta'); ?>

		<?php get_template_part('inc/post-footer'); ?>

		<?php //get_template_part('inc/post-products-text'); ?>

		<?php //get_template_part('inc/post-products'); ?>

		<?php get_template_part('inc/post-comments'); ?>

		<?php //get_template_part('inc/post-navigation'); ?>


	</article>
<?php endwhile; // end of the loop. ?>

</div><!-- #single -->
<?php get_footer(); ?>
