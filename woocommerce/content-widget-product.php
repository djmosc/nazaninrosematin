<?php global $product; ?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>" class="overlay-btn product-btn">
		<?php echo $product->get_image(); ?>
		<div class="overlay">
			<header class="header">
				<h4 class="title"><?php echo $product->get_title(); ?></h4>
				<hr />
				<span class="meta"><?php echo $product->get_price_html(); ?></span>
			</header>
		</div>
		<span class="white-btn"><?php _e("Shop Now", THEME_NAME); ?></span>
	</a>
</li>