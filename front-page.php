<?php get_header(); ?>
<section id="front-page">
	<div class="latest container">
		<header class="lined-header"><h4 class="title"><?php _e("Latest In", THEME_NAME); ?></h4></header>
		<div class="inner clearfix widgets">
			<?php dynamic_sidebar('homepage_latest'); ?>			
		</div>
	</div>

	<?php get_template_part('inc/social-bar'); ?>
	<div class="locations-bar-container container">
		<?php get_template_part('inc/locations-bar'); ?>
	</div>
	<div class="closet-container container">
		<?php get_template_part('inc/closet'); ?>
	</div>

	<?php get_template_part('inc/popular'); ?>
</section><!-- #index -->
<?php get_footer(); ?>