<?php 
/*
 * Press Releases Archive
 *
 */
?>
<?php get_header(); ?>

<section id="template-press-release">
	<div class="inner clearfix">
	<?php if( have_posts() ): ?>
		<div class="accordion">
			<?php $i = 0; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="<?php the_id(); ?>" class="item press-item <?php echo ($i == 0) ? 'current' : ''; ?>">	
				    <a href="#<?php the_id(); ?>" class="btn"><?php the_title(); ?>
				    </a>
				    <div class="content" >
				    	<div class="inner clearfix">
					    	<div class="span two-and-half description break-on-mobile">
					    		 <?php the_content(); ?>
					    	</div>				    
					    	<div class="span seven-and-half gallery break-on-mobile">
								<?php 
									$images = get_field('images');

								if( $images ): ?>
								        <?php foreach( $images as $image ): ?>
						                    <img src="<?php echo bfi_thumb($image['url'], array('width' => 200, 'height' => 270) ); ?>" alt="<?php echo $image['alt']; ?>" />
								        <?php endforeach; ?>
								<?php endif; ?>				    		
					    	</div>
					    </div>  
				    </div>
				</article>
				<?php $i++; ?>
			<?php endwhile; ?>
			<?php get_template_part('inc/pagination'); ?>	
		</div>
	<?php endif; ?>		
	</div>
</section><!-- #template-about -->
<?php get_footer(); ?>