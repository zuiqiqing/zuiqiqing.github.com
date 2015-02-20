<div id="comments">
<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.'); ?></p>
<!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>
	<?php if (comments_open()): ?>
		<div id="respond">
			<div class="cancel_comment_reply">
				<?php cancel_comment_reply_link('取消回复'); ?>
			</div>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				<div class="f-publish" id="real-avatar">
					<span>
					<?php if(isset($_COOKIE['comment_author_email_'.COOKIEHASH])) : ?>
						<?php echo get_avatar($comment_author_email, 50);?>
					<?php else :?>
						<?php global $user_email;?><?php echo get_avatar($user_email, 50); ?>
					<?php endif;?>		
					</span>
					<textarea name="comment" id="comment" tabindex="4" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};" placeholder="你想说点什么~"></textarea>
				</div>
				<div>
					<input name="submit" type="submit" id="submit" tabindex="5" value="发布" />
					<?php comment_id_fields(); ?>
				</div>
				<?php if($user_ID): ?>
					<div class="welcome">已登录 : <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>&nbsp;，&nbsp;<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">注销？</a></div>
					<?php else: ?>
					<?php if(isset($_COOKIE['comment_author_email_'.COOKIEHASH]) && isset($_COOKIE['comment_author_'.COOKIEHASH]))  : ?>
					<div class="welcome">
					<?php printf(__('hello, <a>%1s</a>, 欢迎回来~'), $comment_author); ?>
					</div>					
					<?php else:?>
					<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/realgravatar.js"></script>
					<?php endif; ?>
					<div class="comment-show" style="display:none;">
					<ul>
					<li class="form-inline">
						<label>名称（必填）：</label>
						<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" <?php if($req) echo "aria-required='true'"; ?> />
					</li>
					<li class="form-inline">
						<label>邮箱（必填）：</label>
						<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" <?php if($req) echo "aria-required='true'"; ?> />
					</li>
					<li class="form-inline">
						<label>网站（选填）：</label>
						<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" />
					</li>
					</ul>
					</div>
				<?php endif; ?>
				<?php do_action('comment_form',$post->ID); ?>
			</form>
		</div>
	<?php endif; ?>
	<?php if(have_comments()):?>
		<p id="prompt">已经有<?php comments_number('', '1 人', '% 人' );?>抢在你前面了~</p>
	<?php else : ?>
		<p id="prompt">还没有人抢沙发呢~</p>
		<?php endif; ?>
		<ul class="commentlist">
			<?php wp_list_comments("type=comment&callback=commentlist"); ?>
		</ul>
		<div class="commentnavi">
			<span id="cp_post_id" style="display:none;">
				<?php echo $post->ID; ?>
			</span>
			<?php paginate_comments_links('');?>
		</div>
</div>