<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package peonylim
 * @since peonylim 1.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 7]>         <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html xmlns:fb="http://ogp.me/ns/fb#" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link href="<?php echo get_template_directory_uri(); ?>/images/misc/favicon.png" rel="shortcut icon" type="image/x-icon">

    <script type="text/javascript">
		var themeUrl = '<?php bloginfo( 'template_url' ); ?>';
		var baseUrl = '<?php bloginfo( 'url' ); ?>';
	</script>
    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="tortilla">
<?php if(is_front_page()): ?>
	<?php if( have_rows('slides') ): ?>
	<div id="carousel" class="flexslider">
		<a class="logo scroll-down-btn"></a>
		<ul class="slides">
			<?php while ( have_rows('slides') ) : the_row(); ?>
			<?php
				$the_post = get_sub_field('post');
				$image_id = get_sub_field('image');
				
				if( !empty($image_id) ) {
					$image_url = wp_get_attachment_image_src($image_id, array(1200, 800, 'bfi_thumb' => true));
				} else {
					$image_id = get_post_thumbnail_id($the_post->ID);
					$image_url = get_image($image_id, array(1200, 800, 'bfi_thumb' => true));
				}
			?>
			<li class="slide" style="background-image: url(<?php echo $image_url; ?>)">
				
				<div class="content">
					<div class="inner">
						<h3 class="title"><a href="<?php echo get_the_permalink($the_post->ID); ?>"><?php echo get_the_title($the_post->ID); ?></a></h3>
						<div class="excerpt"><?php echo get_excerpt(100, $the_post->ID); ?></div>
					</div>
				</div>
			</li>
			<?php endwhile; ?>
		</ul>
		<button class="down-btn scroll-down-btn"></button>
	</div>
	<?php wp_reset_postdata(); ?>
	<?php endif; ?>
<?php endif; ?>	
	<header id="header" role="banner">
		<div class="top">
			<div class="inner container">
				<?php if(is_front_page()): ?>
				<!-- <button class="up-btn"></button> -->
				<?php endif; ?>
				<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'clearfix menu', 'container' => 'nav', 'container_class' => 'secondary-navigation navigation', 'depth' => 2 )); ?>
				
				<div class="info clearfix">

					<?php get_template_part('inc/social-links'); ?>
	
					<?php get_search_form(); ?>

				</div>
			</div>
		</div>
		<div class="bottom">
			<div class="inner container">
				<h1 class="logo-container">
					<a class="logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php //bloginfo( 'name' ); ?></a>
				</h1>
				<button class="menu-btn"></button>
				<button class="search-btn"></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'clearfix menu', 'container' => 'nav', 'container_class' => 'primary-navigation navigation', 'walker' => new Primary_Navigation_Walker, 'depth' => 2, 'container_id' => 'header-navigation' )); ?>
			</div>			
		</div>
	</header><!-- #header -->
	<div id="main" class="site-main" role="main">