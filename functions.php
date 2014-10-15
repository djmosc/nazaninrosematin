<?php

define( 'THEME_NAME', 'nazaninrosematin');

define( 'BFITHUMB_UPLOAD_DIR', 'resampled' );

$template_directory = get_template_directory();

$template_directory_uri = get_template_directory_uri();

require( $template_directory . '/inc/default/functions.php' );

require( $template_directory . '/inc/default/hooks.php' );

require( $template_directory . '/inc/default/shortcodes.php' );

// Custom Actions

add_action( 'after_setup_theme', 'custom_setup_theme' );

add_action( 'init', 'custom_init');

add_action( 'wp', 'custom_wp');

add_action( 'widgets_init', 'custom_widgets_init' );

add_action( 'wp_enqueue_scripts', 'custom_scripts', 30);

add_action( 'wp_print_styles', 'custom_styles', 30);

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_thumbnails', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );

add_action( 'admin_menu', 'custom_admin_menu' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


// Custom Filters

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

add_filter( 'pre_get_posts', 'custom_pre_get_posts');

add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

add_filter( 'the_content_feed', 'custom_the_content_feed', 10, 2);

add_filter( 'woocommerce_taxonomy_args_product_cat', '__return_false');

add_filter( 'woocommerce_taxonomy_objects_product_cat', '__return_false');

add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_single_add_to_cart_text');

//Custom shortcodes


function custom_setup_theme() {
	
	add_theme_support( 'post-thumbnails' );

	add_theme_support('woocommerce');

	add_theme_support('editor_style');

	add_post_type_support('page', 'excerpt');

	register_nav_menus( array(
		'primary' => __( 'Primary', THEME_NAME ),
		'footer' => __( 'Footer', THEME_NAME )
	) );

	add_editor_style('css/editor-style.css');

}

function custom_init(){
	global $template_directory, $wp_taxonomies;

	require( $template_directory . '/inc/classes/bfi-thumb.php' );

	require( $template_directory . '/inc/classes/custom-post-type.php' );


	if(function_exists('get_field')) {
	
		$press_releases_page = get_field('press_releases_page', 'options');




		if( !empty($press_releases_page->ID) ){
			$press_releases_uri = get_page_uri($press_releases_page->ID);

			$press_release = new Custom_Post_Type( 'Press Release', 
				array(
					'rewrite' => array('with_front' => false, 'slug' => $press_releases_uri),
					'capability_type' => 'post',
					'publicly_queryable' => true,
					'has_archive' => true, 
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title', 'editor'),
					'plural' => "Press Releases"					
				)
			);			
		}
	}

	register_taxonomy(
		'collection',
		'product',
		array(
			'labels' => array(
				'name'                       => _x( 'Collections', 'taxonomy general name' ),
				'singular_name'              => _x( 'Collection', 'taxonomy singular name' )
			),
			'rewrite' => array( 'slug' => 'collection' ),
			'hierarchical' => true,
		)
	);

}

function custom_wp(){
	
}

function custom_widgets_init() {
	global $template_directory;

	// 	/********************** Content ***********************/

	// register_sidebar( array(
	// 	'name' => __( 'Homepage Content', THEME_NAME ),
	// 	'id' => 'homepage_content',
	// 	'before_widget' => '<aside id="%1$s" class="widget span one-third %2$s">',
	// 	'after_widget' => '</aside>',
	// 	'before_title' => '<h5 class="widget-title text-center light-brown uppercase">',
	// 	'after_title' => '</h5>',
	// ) );

	unregister_widget( 'WC_Widget_Recent_Products' );
	unregister_widget( 'WC_Widget_Featured_Products' );
	unregister_widget( 'WC_Widget_Product_Categories' );
	unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
	unregister_widget( 'WC_Widget_Cart' );
	unregister_widget( 'WC_Widget_Layered_Nav' );
	unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
	unregister_widget( 'WC_Widget_Price_Filter' );
	unregister_widget( 'WC_Widget_Product_Search' );
	unregister_widget( 'WC_Widget_Top_Rated_Products' );
	unregister_widget( 'WC_Widget_Recent_Reviews' );
	unregister_widget( 'WC_Widget_Recently_Viewed' );
	unregister_widget( 'WC_Widget_Best_Sellers' );
	unregister_widget( 'WC_Widget_Onsale' );
	unregister_widget( 'WC_Widget_Random_Products' );
	//unregister_widget( 'WC_Widget_Products' );
}

function custom_scripts() {
	global $template_directory_uri;

	
	wp_enqueue_script('jquery');
	wp_enqueue_script('modernizr', $template_directory_uri.'/js/libs/modernizr.min.js');
	wp_enqueue_script('owlcarousel', $template_directory_uri.'/js/plugins/jquery.owlcarousel.js', array('jquery'), '', true);
	wp_register_script('zoom', $template_directory_uri.'/js/plugins/jquery.elevatezoom.js', array('jquery'), '', true);
	wp_enqueue_script('main', $template_directory_uri.'/js/main.js', array('jquery'), '', true);
}


function custom_styles() {
	global $wp_styles, $template_directory_uri;

	wp_enqueue_style( 'style', $template_directory_uri . '/css/style.css' );	
	wp_enqueue_style( 'fonts', '//fast.fonts.net/cssapi/5b55f0ce-9999-48c6-b452-c34c42a2e348.css' );		
}

function custom_pre_get_posts( $query ) {
	
	if ( $query->get('post_type') == 'press_release' ) {
		$query->set('posts_per_page', 4);
	}

	return $query;
}

function custom_woocommerce_product_single_add_to_cart_text(){
	return __("Add to shopping bag");
}

function custom_admin_menu(){
	//remove_menu_page( 'index.php' )
	//remove_menu_page( 'edit-comments.php' );
}
