<?php
if ( post_password_required() ) {
	return;
}
?>

<?php if (have_comments()) : ?>
	<div id="comments-wrapper">
		<div class="inner">
			<h3 id="comments"><?php	printf( _n( 'One comment', '%1$s comments', get_comments_number(),'oblivion' ), number_format_i18n( get_comments_number() )); ?></h3>
			<?php if ((int) get_option('page_comments') === 1): ?>
				<div class="pagination" id="comment-pagination-top">
					<span class="post-nav-prev"><?php previous_comments_link('<i class="fa fa-angle-left"></i> <span>' . __('previous','oblivion') .'</span>') ?></span>
					<span class="post-nav-next"><?php next_comments_link('<span>' . __('next','oblivion') .'</span> <i class="fa fa-angle-right"></i>') ?></span>
					<div class="clear"></div>
				</div>
			<?php endif; ?>
			<ol class="commentlist">
				<?php wp_list_comments(array('callback' => 'oblivion_custom_comment')); ?>
			</ol>
			<?php if ((int) get_option('page_comments') === 1): ?>
				<div class="pagination" id="comment-pagination-bottom">
					<span class="post-nav-prev"><?php previous_comments_link('<i class="fa fa-angle-left"></i> <span>' . __('previous','oblivion') .'</span>') ?></span>
					<span class="post-nav-next"><?php next_comments_link('<span>' . __('next','oblivion') .'</span> <i class="fa fa-angle-right"></i>') ?></span>
					<div class="clear"></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>


<?php if(comments_open()) : ?>
	<div id="respond-wrapper">
		<div class="inner">
			<?php
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );
			$args = array(
				'id_form'           => 'commentform',
				'id_submit'         => 'submit',
				'cancel_reply_link' => '<i class="fa fa-times"></i> <span>' . __('Cancel Reply','oblivion') . '</span>',
				'label_submit'      => __('Post Comment','oblivion'),
				'comment_notes_after' => '',
				'fields' => apply_filters( 'comment_form_default_fields', array(
					'author' =>
					'<p class="comment-form-author">' .
					'<label for="author">' . __('Name','oblivion') . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' /></p>',
					
					'email' =>
					'<p class="comment-form-email"><label for="email">' . __('Email','oblivion') . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"' . $aria_req . ' /></p>',
					
					'url' =>
					'<p class="comment-form-url"><label for="url">' .
					__('Website','oblivion') . '</label>' .
					'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" /></p>'
					)
				)
			); ?>
			<?php comment_form($args); ?>
		</div>
	</div>
<?php endif; ?>