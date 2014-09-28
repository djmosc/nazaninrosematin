<?php get_header(); ?>
<section id="front-page">
	<div class="latest container">
		<header class="lined-header"><h4 class="title"><?php _e("Latest In", THEME_NAME); ?></h4></header>
		<div class="inner clearfix widgets">
			<?php dynamic_sidebar('homepage_latest'); ?>			
		</div>
	</div>
</section><!-- #index -->
<?php get_footer(); ?>