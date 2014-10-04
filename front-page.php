<?php get_header(); ?>
<section id="front-page">
	<div class="inner">
	<?php if( have_posts() ): ?>
		<?php $i = 0; ?>
		<?php while( have_posts() ) : the_post(); ?>
		<div class="carousel owl-carousel">
			<?php if( $images = get_field('images') ): ?>
		    	<?php foreach( $images as $image ): ?>
			<div class="item">
				<img src="<?php echo bfi_thumb($image['url'], array('width' => 900, 'height' => 500) ); ?>" alt="<?php echo $image['alt']; ?>" />
			</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php $i++; ?>
		<?php endwhile; ?>
	<?php endif; ?>
	</div>
</section><!-- #index -->
<?php get_footer(); ?>