<?php

class Primary_Navigation_Walker extends Walker_Nav_Menu {


    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '<div class="primary-dropdown clearfix"><div class="taxonomies"><ul class="sub-menu categories">';
        return $output;
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        global $post;
        $output .= '</ul>';
        if( isset($args->element) ) {
            
            $element = $args->element;
            
            if($element->object == 'category') {

                $tag_ids = get_field('tags', 'category_'.$element->post_parent);
                
                if( !empty($tag_ids) ) {
                    $tags = get_terms('post_tag', array('include' => $tag_ids, 'hide_empty' => 0, 'limit' => 4, 'orderby' => 'none'));
                }

                if( !empty($tags) ) {
                    $output .= '<div class="tags"><h5 class="title">'.__("Themes", THEME_NAME).'</h5><ul class="sub-menu clearfix">';
                    $i = 0;
                    foreach($tags as $tag) {
                        if($i >= 4) continue;
                     
                        $output .= '<li class="tag">';
                        $output .= '<a href='.get_term_link($tag).'>'.$tag->name.'</a>';
                        $output .= '</li>';
                        $i++;
                    }

                    $output .= '<li class="see-all"><a href="'.get_term_link($element->post_parent, 'category').'">'.__("See all", THEME_NAME).'</a></li>';

                    $output .= '</ul></div>';

                }

                $output .= '</div>';
                $query = new WP_Query(array(
                    'posts_per_page' => 3,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'id',
                            'terms'    =>  $element->post_parent
                        )
                    )
                ));

                if ($query->have_posts()) { 
                    $output .= '<div class="posts">';
                    while ($query->have_posts()) { 
                        $query->the_post();
                        
                        $categories = get_the_category();
                        $parent_category = (isset($categories[0])) ? get_top_level_category($categories[0]->term_id) : null;
                        $category = null;

                        foreach($categories as $cat) {
                            if($cat->parent == $parent_category->term_id) $category = $cat;
                        }

                        if( empty($category)) $category = $parent_category;

                        $output .= '<a href="'.get_permalink().'" class="post btn">'.
                            '<div class="category"><span>'.$category->name.'</span></div>'.
                            '<div class="thumbnail">'.get_the_post_thumbnail(get_the_ID(), array(150, 190, 'bfi_thumb' => true)).'</div>'.
                            '<h5 class="title">'.get_the_title().'</h5>'.
                        '</a>';
                    }
                    wp_reset_postdata();
                    $output .= '</div>';
                }
            }

        }
        $output .= '</div>';
        return $output;
    }

    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

        if ( !$element )
            return;

        if(isset( $args[0] ) )
            $args[0]->element = $element;

        $id_field = $this->db_fields['id'];

        //display this element
        if ( isset( $args[0] ) && is_array( $args[0] ) )
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array($this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

            foreach( $children_elements[ $id ] as $child ){

                if ( !isset($newlevel) ) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array($this, 'start_lvl'), $cb_args);
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel ){
            //end the child delimiter
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array($this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array($this, 'end_el'), $cb_args);
    }
}