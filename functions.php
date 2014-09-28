<?php

define( 'THEME_NAME', 'peonylim');

define( 'BFITHUMB_UPLOAD_DIR', 'resampled' );

$template_directory = get_template_directory();

$template_directory_uri = get_template_directory_uri();

require( $template_directory . '/inc/default/functions.php' );

require( $template_directory . '/inc/default/hooks.php' );

require( $template_directory . '/inc/default/shortcodes.php' );

require( $template_directory . '/inc/classes/primary-nav-walker.php' );

require( $template_directory . '/inc/classes/category-dropdown-url-walker.php' );

// Custom Actions

add_action( 'after_setup_theme', 'custom_setup_theme' );

add_action( 'init', 'custom_init');

add_action( 'wp', 'custom_wp');

add_action( 'widgets_init', 'custom_widgets_init' );

add_action( 'wp_enqueue_scripts', 'custom_scripts', 30);

add_action( 'wp_print_styles', 'custom_styles', 30);

add_action('admin_head', 'custom_admin_head');

//add_filter( 'manage_nav-menus_columns', 'custom_manage_nav_menus_columns' );

// Custom Filters

add_filter( 'wp_nav_menu_items', 'custom_nav_menu_items', 10, 2);

add_filter( 'intermediate_image_sizes_advanced', 'custom_intermediate_image_sizes_advanced');

add_filter( 'image_size_names_choose', 'custom_image_size_names_choose');

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

//add_filter( 'dynamic_sidebar_params', 'custom_dynamic_sidebar_params' );

//add_filter( 'date_rewrite_rules', 'custom_date_rewrite_rules');

add_filter( 'month_link', 'custom_month_link', 10, 3);

//add_filter( 'template_include', 'custom_template_include');

add_filter( 'pre_get_posts', 'custom_pre_get_posts');

add_filter( 'comment_form_defaults', 'custom_comment_form_defaults');

add_filter( 'wp_prepare_attachment_for_js', 'custom_wp_prepare_attachment_for_js', 10, 3);

add_filter( 'media_meta', 'custom_media_meta', 10, 2);

add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

//add_filter( 'nav_menu_link_attributes', 'custom_nav_menu_link_attributes', 10, 3);

add_filter( 'the_content_feed', 'custom_the_content_feed', 10, 2);

//add_filter( 'get_archives_link', 'custom_get_archives_link' );

//add_filter( 'pre_option_link_manager_enabled', '__return_true' );

//add_filter('parse_query', 'custom_parse_query');

//Custom shortcodes

//add_shortcode( 'phone_number', 'custom_phone_number');

remove_shortcode('show_shopthepost_widget', 'shopthepost_show_widget');

add_shortcode('show_shopthepost_widget', 'custom_shop_the_post');



function custom_setup_theme() {
	
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'post-thumbnails' );

	add_theme_support('woocommerce');

	add_theme_support('editor_style');

	add_post_type_support('page', 'excerpt');

	register_nav_menus( array(
		'primary' => __( 'Primary', THEME_NAME ),
		'secondary' => __( 'Secondary', THEME_NAME )
	) );

	add_role('photographer', 'Photographer');

	add_editor_style('css/editor-style.css');

}

function custom_init(){
	global $template_directory;

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
					'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
					'plural' => "Press Releases"
				)
			);
		}

		$locations_page = get_field('locations_page', 'options');

		if( !empty($locations_page->ID) ){
			$locations_uri = get_page_uri($locations_page->ID);

			$location = new Custom_Post_Type( 'Location', 
				array(
					'rewrite' => array('with_front' => false, 'slug' => $locations_uri),
					'capability_type' => 'post',
					'publicly_queryable' => true,
					'has_archive' => true, 
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
					'plural' => "Locations"
				)
			);

			register_taxonomy(
				'city',
				'location',
				array(
					'labels' => array(
						'name'                       => _x( 'Cities', 'taxonomy general name' ),
						'singular_name'              => _x( 'City', 'taxonomy singular name' )
					),
					'rewrite' => array( 'slug' => 'city' ),
					'hierarchical' => true,
				)
			);


			register_taxonomy(
				'type',
				'location',
				array(
					'labels' => array(
						'name'                       => _x( 'Types', 'taxonomy general name' ),
						'singular_name'              => _x( 'Type', 'taxonomy singular name' )
					),
					'rewrite' => array( 'slug' => 'type' ),
					'hierarchical' => true,
				)
			);
		}
	}

	if( function_exists('acf_add_options_page') ) acf_add_options_page();

}

function custom_wp(){
	
}

function custom_widgets_init() {
	global $template_directory;

	require( $template_directory . '/inc/widgets/post.php' );

	require( $template_directory . '/inc/widgets/category.php' );

	require( $template_directory . '/inc/widgets/advert.php' );

	require( $template_directory . '/inc/widgets/products.php' );

	require( $template_directory . '/inc/widgets/popular_posts.php' );

	require( $template_directory . '/inc/widgets/social.php' );

	//require( $template_directory . '/inc/widgets/twitter/feed.php' );
	
	// 	/********************** Sidebars ***********************/

	// register_sidebar( array(
	// 	'name' => __( 'Default', THEME_NAME ),
	// 	'id' => 'default',
	// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	// 	'after_widget' => '</aside>',
	// 	'before_title' => '<h5 class="widget-title">',
	// 	'after_title' => '</h5>',	
	// ) );

	register_sidebar( array(
		'name' => __( 'Homepage - Four boxes', THEME_NAME ),
		'id' => 'homepage_latest',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );

	// register_sidebar( array(
	// 	'name' => __( 'Homepage - Popular', THEME_NAME ),
	// 	'id' => 'homepage_popular',
	// 	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	// 	'after_widget' => '</aside>',
	// 	'before_title' => '<h5 class="widget-title">',
	// 	'after_title' => '</h5>',
	// ) );

	
	register_sidebar( array(
		'name' => __( 'Post - Comments', THEME_NAME ),
		'id' => 'post_comments',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );

	register_sidebar( array(
		'name' => __( 'Popular', THEME_NAME ),
		'id' => 'popular',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );

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
	wp_enqueue_script('plugins', $template_directory_uri.'/js/plugins.js', array('jquery', 'modernizr'), '', true);
	wp_enqueue_script('main', $template_directory_uri.'/js/main.js', array('jquery', 'modernizr', 'plugins'), '', true);

	wp_register_script('ajaxposts', $template_directory_uri.'/js/plugins/jquery.ajaxposts.js', array('jquery'), '', true);
	wp_register_script('lazyload', $template_directory_uri.'/js/plugins/jquery.lazyload.js', array('jquery'), '', true);
	wp_register_script('googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', false, '', true);
	wp_register_script('cssmap', $template_directory_uri.'/js/plugins/jquery.cssmap.js', array('jquery'), '', true);
	wp_register_script('masonry', $template_directory_uri.'/js/plugins/masonry.js', array('jquery'), '', true);
}


function custom_styles() {
	global $wp_styles, $template_directory_uri;

	wp_enqueue_style( 'style', $template_directory_uri . '/css/style.css' );	
	wp_enqueue_style( 'fonts', '//fast.fonts.net/cssapi/60068eba-c265-4718-9b55-28b562f428f2.css' );	
	wp_register_style( 'cssmap', $template_directory_uri . '/css/cssmap.css' );	
}



function custom_admin_head() {
  echo '<style>
    .acf-table td.acf-label,
    table.acf_input tbody tr td.label {
    	width: 10%;
    }

    .acf-table tr.acf-tab-wrap td .acf-tab-group {
    	padding-left: 8px;
    }
  </style>';
}


function custom_manage_nav_menus_columns(){
	add_meta_box( 'add-custom-section', __( 'Divider' ), 'custom_nav_menu_item_section_meta_box', 'nav-menus', 'side', 'default' );
}

function custom_nav_menu_item_section_meta_box(){
	global $_nav_menu_placeholder, $nav_menu_selected_id;

	$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;

	?>
	<div class="customlinkdiv" id="customlinkdiv">
		<input type="hidden" value="custom" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" />
		<input id="custom-menu-item-url" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-url]" type="hidden" class="code menu-item-textbox" value="" />
		<input id="custom-menu-item-name" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" type="hidden" class="regular-text menu-item-textbox input-with-default-title" title= />
		
		<p class="button-controls">
			<span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add Divider'); ?>" name="add-custom-menu-item" id="submit-customlinkdiv" />
				<span class="spinner"></span>
			</span>
		</p>

	</div>
	<?php
}

function custom_nav_menu_items( $items, $args ){
	if($args->theme_location == 'primary' && $args->container_id == 'header-navigation') {
		$layout = get_layout();

		$items .= '<li class="menu-item menu-item-view right view-btn-container">
			<span>View</span>
			<a href="'.get_permalink( get_option('page_for_posts') ).'" ';
		if(is_home() && $layout == 'grid') $items .= 'class="current" ';
		$items .= '><i class="icon-grid"></i></a>';
		$items .= '<a href="'.get_permalink( get_option('page_for_posts') ).'?layout=full" ';
		if(is_home() && $layout == 'full') $items .= 'class="current" ';
		$items .= '><i class="icon-list"></i></a></li>';
	}
	return $items;
}

function custom_intermediate_image_sizes_advanced( $sizes) {
	//unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);
	//unset( $sizes['wysija-newsletters-max']);
	return $sizes;
}

function custom_image_size_names_choose($sizes) {

	$sizes = array(
		'thumbnail' => __( "Thumbnail" ),
		'full' => __( "Original size" )
	);
	return $sizes;
}

function custom_pre_get_posts( $query ) {
	$layout = get_layout();
	$layouts = array('list', 'full');

	if ( $query->is_main_query() && in_array($layout, $layouts) ) {
		if($layout == 'full') {
			$query->set('posts_per_page', 3);
		} elseif($layout == 'list') {
			$query->set('posts_per_page', 4);
		}
	} else {
		if($layout == 'list') {
			$query->set('posts_per_page', 4);
		}
	}

	if(	$query->is_tax('city')) {
	 	$query->set('posts_per_page', -1);
	}

	if ($query->is_search && !is_admin() ) {
        $query->set('post_type', array('post'));
    }

	
	return $query;
}

function get_layout() {
	return ( isset($_GET['layout']) ) ? $_GET['layout'] : 'grid';
}

function get_instagram_images($count, $user_id) {
	$images = get_transient( 'instagram_images' );
	
	if( $images !== false ) return $images;

	$response = wp_remote_get('https://api.instagram.com/v1/users/'.$user_id.'/media/recent?count='.$count.'&access_token=975210125.a2e2346.7be3fa000252400aacc231aca788fa7a');
	
	if ( ! is_wp_error($response)) {
		$json = json_decode(wp_remote_retrieve_body($response));
		$data = (isset($json->data)) ? $json->data : null;
		$images = [];

		foreach($data as $image) {
			$images[] = array(
				'url' => $image->images->low_resolution->url,
				'link' => $image->link
			);
		}

		set_transient( 'instagram_images', $images, 60*60*24);
	} else {
		//$result->get_error_message()
	}

	return $images;
}

function custom_comment_form_defaults($args){
	$args['title_reply'] = '<span class="title">'.__( 'Comments' ).'</span>';
	$args['title_reply_to'] = '<span class="title">'.__( 'Comments' ).'</span>';
	$args['comment_notes_before'] = '';
	//$args['cancel_reply_link'] = __( 'Cancel reply' );
	//$args['label_submit'] = __( 'Post Comment' );
	return $args;
}

function get_image_url($attachment_id, $size = 'thumbnail') {
	$image = wp_get_attachment_image_src( $attachment_id, $size );
			
	return $image[0];
}

global $wpdb;
if( isset($_GET['move_content'])) {
	$results = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE meta_key = 'content'");

	if( !empty($results)) {

		foreach( $results as $result ){
			wp_update_post(array(
				'ID' => $result->post_id,
				'post_content' => $result->meta_value
			));
		}
	}
	die("Success");
}

function custom_shop_the_post($atts) {
    extract(shortcode_atts(array(
        'id'    => '0'
    ), $atts));

    return '<div class="shop-the-post" id="shop-the-post-' .$id. '" data-id="'.$id.'"></div>';
}

function custom_wp_prepare_attachment_for_js($response, $attachment, $meta ) {
	$image = wp_get_attachment_image_src($attachment->ID, 'thumbnail');
	if( !empty($image) ) $response['url'] = $image[0];
	return $response;
}

function custom_month_link($monthlink, $year, $month) {
	return home_url( '?m=' . $year . zeroise( $month, 2 ) );
}

function formatted_list($list) {
	if( !empty($list) ) {
		$i = 0;
		$total = count($list);
		foreach($list as $type) {
			echo $type->name;
			if($i > 0 && $i == $total - 2) {
				echo ' &amp; ';
			} elseif($total > 1 && $i !== $total - 1) {
				echo ', ';
			}
			$i++;
		}
	}
}

function custom_media_meta($meta, $post) {
	$attachment = wp_get_attachment_image_src($post->ID, 'full');

	if( !empty($attachment)) {
		$meta = "<strong>Orientation</strong>: ";
		$width = $attachment[1];
		$height = $attachment[2];
		if($width > $height) {
			$meta .= "Landscape";
		} else if( $width == $height) {
			$meta .= "Square";
		} else {
			$meta .= "Portrait";
		}
	}
	return $meta;	
}

function custom_the_content_feed($content, $type){
	ob_start();
    get_template_part('inc/content');
    $content = ob_get_contents();
    ob_end_clean();

	return $content;
}