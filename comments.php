<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments">

	<?php comment_form(array(
		'comment_notes_after' => ''
	)); ?>

	<?php if ( have_comments() ) : ?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', THEME_NAME ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', THEME_NAME ) ); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      => 'ul',
				'short_ping' => false,
				'avatar_size'=> 0,
			) );
		?>
	</ol><!-- .comment-list -->

	<?php //if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', THEME_NAME ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', THEME_NAME ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php //endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.', THEME_NAME ); ?></p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>


</div><!-- #comments -->
