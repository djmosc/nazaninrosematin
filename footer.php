<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package nazaninrosematin
 * @since nazaninrosematin 1.0
 */
?>
	</div><!-- #main .site-main -->
	
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="container inner">

			<div class="top">
				<?php get_template_part('inc/social-links'); ?>
				<?php wp_nav_menu( array( 'depth' => 1, 'theme_location' => 'footer', 'menu_class' => 'clearfix menu', 'container' => 'nav', 'container_class' => 'footer-navigation navigation' )); ?>
			</div>
			<div class="bottom">
				<p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> <?php _e("All rights reserved.", THEME_NAME); ?></p>
			</div>
		</div>
	</div>
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>

</body>
</html>
