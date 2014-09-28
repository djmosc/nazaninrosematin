<?php get_header(); ?>
<section id="taxonomy-collection">
	<div class="inner container">
		<?php if( have_posts() ): ?>
		<div class="carousel">
			<?php while( have_posts() ) : the_post(); ?>
			<div class="item">
				<figure class="collection-image">
					<?php the_post_thumbnail(); ?>
				</figure>
			</div>
			<?php endwhile; ?>
		</div>
		<?php endif; ?>
	</div>
</section><!-- #taxonomy-collection -->
<?php get_footer(); ?>