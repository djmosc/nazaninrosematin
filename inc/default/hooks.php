<?php 

// Add actions

add_action( 'tiny_mce_before_init', 'custom_tinymce_options'); 

add_action( 'gform_enqueue_scripts', 'custom_gform_enqueue_scripts', 10, 2);

add_action( 'gform_field_standard_settings', 'custom_gform_standard_settings', 10, 2);

add_action( 'admin_head', 'custom_admin_head');

// Custom Filters

add_filter( 'next_posts_link_attributes', 'custom_next_post_link_class');

add_filter( 'previous_posts_link_attributes', 'custom_prev_post_link_class');

add_filter( 'excerpt_more', 'custom_excerpt_more');

add_filter( 'post_thumbnail_html', 'custom_thumbnail_html', 10, 3 );

add_filter( 'widget_text', 'do_shortcode');

add_filter( 'gform_tabindex', '__return_false');

add_filter( 'get_terms_orderby', 'custom_get_terms_orderby', 10, 2 );

//add_filter('jpeg_quality', create_function('', 'return 100;'));

function custom_get_terms_orderby( $orderby, $args ) {
  if ( isset( $args['orderby'] ) && 'include' == $args['orderby'] ) {
        $include = implode(',', array_map( 'absint', $args['include'] ));
        $orderby = "FIELD( t.term_id, $include )";
    }
    return $orderby;
}


function custom_next_post_link_class() {
	return 'class="next-btn"';
} 


function custom_prev_post_link_class() {
	return 'class="prev-btn"';
}


function custom_excerpt_more($more) {
	return '...';
}

function custom_thumbnail_html( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}


function custom_gform_standard_settings($position, $form_id){
    if($position == 25){
    	?>
        <li style="display: list-item; ">
            <label for="field_placeholder">Placeholder Text</label>
            <input type="text" id="field_placeholder" size="35" onkeyup="SetFieldProperty('placeholder', this.value);">
        </li>
        <?php
    }
}


function custom_gform_enqueue_scripts($form, $is_ajax=false){
    wp_dequeue_script('gforms_datepicker');
    wp_dequeue_style('gforms_datepicker_css');
    ?>
	<script>
    jQuery(function(){
        <?php
        foreach($form['fields'] as $i=>$field){
            if(isset($field['placeholder']) && !empty($field['placeholder'])){
                ?>
                jQuery('#input_<?php echo $form['id']?>_<?php echo $field['id']?>').attr('placeholder','<?php echo $field['placeholder']?>');
                <?php
            }
        }
        ?>
    });
    </script>
    <?php
}

function custom_tinymce_options($init){ 
	$init['apply_source_formatting'] = true; 
	return $init; 
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