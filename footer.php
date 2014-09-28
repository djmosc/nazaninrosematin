<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package peonylim
 * @since peonylim 1.0
 */
?>
	</div><!-- #main .site-main -->
	<div id="back-to-top">
		<a href="#" class="up-btn"><?php _e("Back to top", THEME_NAME); ?></a>
	</div>
	<div id="instagram">
		<header class="header">
			<div class="inner container">
				<a class="corner-btn" href="<?php echo 'http://liketoknow.it/peonylim'; ?>" target="_blank"><i class="icon-instagram"></i> @peonylim</a>
			</div>
		</header>
		<?php
		$images = get_instagram_images(10, 4560806);

		if( !empty($images) ):
		?>
		<div class="images clearfix">
			<?php foreach($images as $image): ?>
			<a class="image overlay-btn" href="<?php echo $image['link']; ?>" target="_blank">
				<img src="<?php echo $image['url']; ?>" />
			</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="top">
			<div class="container inner">
				<h1 class="logo-container">
					<a class="logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php //bloginfo( 'name' ); ?></a>
				</h1>
				
				<?php get_template_part('inc/social-links'); ?>
				
				<?php wp_nav_menu( array( 'depth' => 1, 'theme_location' => 'primary', 'menu_class' => 'clearfix menu', 'container' => 'nav', 'container_class' => 'primary-navigation navigation' )); ?>
				
				<?php wp_nav_menu( array( 'depth' => 1, 'theme_location' => 'secondary', 'menu_class' => 'clearfix menu', 'container' => 'nav', 'container_class' => 'secondary-navigation navigation' )); ?>
				
			</div>	
		</div>		
		<div class="bottom">
			<div class="container inner">
				<div class="copyright span five omega alpha">
					<p class="italic">
						<?php _e("All rights reserved.", THEME_NAME); ?> &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>
					</p>
				</div>
				<div class="span by five">
					<p class="text-right">
						<?php _e("Design", THEME_NAME); ?> <a href="http://bit.ly/PcPVGP" target="_blank">Park &amp; Cube</a> | <?php _e("Development", THEME_NAME); ?> <a href="http://www.mindblownmedia.com" target="_blank">Mind Blown Media</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>

<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-38610061-1']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>

</body>
</html>