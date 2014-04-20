		<?php $options = get_option('oblivion_theme_options'); ?>
		<section id="section-social">
			<div class="inner">
				<aside class="featured-post-more">
					<a class="sp sp-rss" target="_blank" href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('RSS','oblivion'); ?>"><span><i class="fa fa-rss fa-fw"></i></span></a>
					<?php if($options['twitter']) : ?>
					<a class="sp sp-twitter" target="_blank" href="<?php echo $options['twitter']; ?>" title="<?php _e('Twitter','oblivion'); ?>"><span><i class="fa fa-twitter fa-fw"></i></span></a>
					<?php endif; ?>
					<?php if($options['facebook']) : ?>
					<a class="sp sp-facebook" target="_blank" href="<?php echo $options['facebook']; ?>" title="<?php _e('Facebook','oblivion'); ?>"><span><i class="fa fa-facebook fa-fw"></i></span></a>
					<?php endif; ?>
					<?php if($options['google']) : ?>
					<a class="sp sp-googleplus" target="_blank" href="<?php echo $options['google']; ?>" title="<?php _e('Google+','oblivion'); ?>"><span><i class="fa fa-google-plus fa-fw"></i></span></a>
					<?php endif; ?>
					<?php if($options['youtube']) : ?>
					<a class="sp sp-youtube" target="_blank" href="<?php echo $options['youtube']; ?>" title="<?php _e('Youtube','oblivion'); ?>"><span><i class="fa fa-youtube-play fa-fw"></i></span></a>
					<?php endif; ?>
					<div class="clear"></div>
				</aside>
					
			</div>
		</section>

		<div id="footer">
			<div class="inner">
				<nav id="footer-navigation" role="navigation">
					<h2 class="visuallyhidden"><?php _e('Navigation','oblivion'); ?></h2>
					<?php wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'fallback_cb' => 'FALSE',
							'walker' => new My_Walker_Nav_Menu()
						)
					); ?>
					<div class="clear"></div>
				</nav>
			</div>
		</div>
		<script type="text/javascript">
			window.onload = function () {
				jQuery(function($) {
					var loading = $('#loading');
					loading.fadeOut(500, function() {
						$(this).hide();
					});
					$('a').click(function() {
						if($(this).attr('href').indexOf(window.location.protocol + '//' + window.location.host) === 0) {
							loading.fadeIn(500, function() {
								setTimeout(function() {
									loading.fadeOut(500, function() {
										$(this).hide();
									});
								}, 2500);
							});
						}
					});
				});
			};
		</script>
		<?php wp_footer(); ?>
	</body>
</html>