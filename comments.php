 <?php
	_deprecated_file( sprintf( __( 'Theme without %1$s' ), basename(__FILE__) ), '3.0', null, sprintf( __('Please include a %1$s template in your theme.'), basename(__FILE__) ) );
	/* Do not delete these lines */
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) {
		?><p class="nocomments"><?php _e('This is not the content you are looking for.','oblivion'); ?></p><?php
		return;
	}
?>

<?php if (have_comments()) : ?>
	<div id="comments-wrapper">
		<div class="inner">
			<h3 id="comments"><?php	printf( _n( 'One comment', '%1$s comments', get_comments_number(),'oblivion' ), number_format_i18n( get_comments_number() )); ?></h3>
	
			<ol class="commentlist">
				<?php $comment_counter = count($comments_by_type['comment']); ?>
				<?php wp_list_comments(array('callback' => 'custom_comment')); ?>
			</ol>
			<?php if ((int) get_option('page_comments') === 1): ?>
				<nav class="post-nav">
					<span class="post-nav-prev"><?php previous_comments_link(__('Older comments','oblivion')) ?></span>
					<span class="post-nav-next"><?php next_comments_link(__('Newer Comments','oblivion')) ?></span>
				</nav>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>


<?php if(comments_open()) : ?>
	<div id="respond-wrapper">
		<div class="inner">
			<h3 id="reply"><?php comment_form_title( __('What do you think?','oblivion'), '<i class="fa fa-reply"></i> ' . __('Leave a reply to %s','oblivion') ); ?></h3>
			<?php cancel_comment_reply_link('<i class="fa fa-times"></i> <span>'. __('cancel reply','oblivion').'</span>') ?>
			<div class="clear"></div>
			<div id="respond">
				<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
					<p>
						<?php printf(__('You have to be <a href="%s">logged in</a>.','oblivion'), wp_login_url( get_permalink() )); ?>
					</p>
				<?php else : ?>
					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
						<?php if(is_user_logged_in()) : ?>
							<p>
								<small><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.','oblivion'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('Log out','oblivion'); ?> &raquo;</a></small>
							</p>
						<?php else : ?>
							<p class="input-col input-col-1">
								<label for="author"><?php _e('Name','oblivion'); ?> <?php if ($req) { ?><span class="req"><?php _e('required','oblivion'); ?></span><?php } ?></label>
								<input class="input" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
	
							</p>
				
							<p class="input-col input-col-2">
								<label for="email"><?php _e('Email','oblivion'); ?> <?php if ($req) { ?><span class="req"><?php _e('required','oblivion'); ?></span><?php } ?></label>
								<input class="input" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
	
							</p>
				
							<p class="input-col input-col-3">
								<label for="url"><?php _e('Website','oblivion'); ?></label>
								<input class="input" type="text" name="url" id="url" value="<?php echo  esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
							</p>
							<div class="clear"></div>
						<?php endif; ?>
			
						<!--<p><small><?php printf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>'), allowed_tags()); ?></small></p>-->
						<p class="input-col input-col-4">
							<label for="comment"><?php _e('Comment','oblivion'); ?> <?php if ($req) { ?><span class="req"><?php _e('required','oblivion'); ?></span><?php } ?></label>
							<textarea class="input" name="comment" id="comment" cols="58" rows="10" tabindex="5"></textarea>
						</p>
						<p class="input-col input-col-5">
							<input class="input" name="submit" type="submit" id="submit" class="button" tabindex="6" value="<?php _e('Submit','oblivion'); ?>" />
							<?php comment_id_fields(); ?>
						</p>
						<?php do_action('comment_form', $post->ID); ?>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>