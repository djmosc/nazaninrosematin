<?php
class Category_Dropdown_Url_Walker extends Walker_CategoryDropdown {

	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$pad = str_repeat('&nbsp;', $depth * 3);

		$cat_name = apply_filters('list_cats', $category->name, $category);
		$output .= '<option class="level-'.$depth.'" value="'.get_term_link($category).'"';
		if ( $category->term_id == $args['selected'] )
			$output .= ' selected="selected"';
		$output .= '>';
		$output .= $pad.$cat_name;
		$output .= '</option>';
	}
}