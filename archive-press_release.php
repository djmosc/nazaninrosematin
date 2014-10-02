<?php 
/*
 * Press Releases Archive
 *
 */
?>
<?php get_header(); ?>

<section id="template-press">
	<div class="inner clearfix">
	<?php if( have_posts() ): ?>
		<div id="accordion">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="press-item">	
				    <a href="#<?php the_id(); ?>" class="trigger"><?php the_title(); ?>
						<span class="status close"><span>Close</span></span>
						<span class="status read-more"><span>Read More</span></span>
				    </a>
				    <div class="content" id="<?php the_id(); ?>">
				    	<div class="span two-and-half description break-on-mobile">
				    		 <?php the_content(); ?>
				    	</div>				    
				    	<div class="span seven-and-half gallery break-on-mobile">
							<?php 
								$images = get_field('images');

							if( $images ): ?>
							        <?php foreach( $images as $image ): ?>
					                    <img src="<?php echo $image['sizes']['press-release']; ?>" alt="<?php echo $image['alt']; ?>" />
							        <?php endforeach; ?>
							<?php endif; ?>				    		
				    	</div>				       
				    </div>
				</article>
			<?php endwhile; ?>
			<?php get_template_part('inc/pagination'); ?>	
		</div>
	<?php endif; ?>		
	</div>
</section><!-- #template-about -->
<?php get_footer(); ?>