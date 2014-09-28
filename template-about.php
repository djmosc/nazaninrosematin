<?php get_header(); ?>
<section id="template-about">
	<div class="inner clearfix">
	<?php if( have_posts() ): ?>
		<div class="span three image">
			<?php the_post_thumbnail(); ?>
		</div>
		<div class="span seven content">

		</div>
	<?php endif; ?>		
	</div>
</section><!-- #template-about -->
<?php get_footer(); ?>