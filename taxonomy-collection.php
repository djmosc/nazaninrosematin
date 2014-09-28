<?php global $wp_query; ?>
<?php get_header(); ?>
<section id="taxonomy-collection">
	<div class="inner container">
		<?php if( have_posts() ): ?>
		<div class="carousel owl-carousel">
			<?php $i = 0; ?>
			<?php while( have_posts() ) : the_post(); ?>
			<div class="item">
				<a class="btn" href="<?php the_permalink(); ?>">
					<figure class="collection-image">
						<?php the_post_thumbnail(array('width' => 780, 'height' => 500, 'bfi_thumb' => true)); ?>
					</figure>
				</a>

				<span class="page">
					<?php echo ($i + 1).'/'.$wp_query->found_posts; ?>
				</span>
			</div>
			<?php $i++; ?>
			<?php endwhile; ?>
		</div>

		<?php single_cat_title(); ?>
		<?php endif; ?>
	</div>
</section><!-- #taxonomy-collection -->
<?php get_footer(); ?>