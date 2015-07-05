		<?php if (is_active_sidebar('Footer-Sidebar')) : ?>

		<section id="section-widgets" title="<?php _e('Widgets','oblivion'); ?>">
			<div class="inner">
				<h2 class="visuallyhidden"><?php _e('Widgets','oblivion'); ?></h2>
				<div class="widget-wrapper">
					<?php dynamic_sidebar('Footer-Sidebar'); ?>
					<div class="clear"></div>
				</div>
			</div>
		</section>

		<?php endif; ?>

		<?php $options = get_option('oblivion_theme_options'); ?>
		<section id="section-social">
			<div class="inner">
				<aside class="featured-post-more">
					<a class="sp sp-rss" target="_blank" href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('RSS','oblivion'); ?>"><span><i class="icon-rss"></i></span></a>
					<?php if($options['twitter']) : ?>
					<a class="sp sp-twitter" target="_blank" href="<?php echo $options['twitter']; ?>" title="<?php _e('Twitter','oblivion'); ?>"><span><i class="icon-twitter"></i></span></a>
					<?php endif; ?>
					<?php if($options['facebook']) : ?>
					<a class="sp sp-facebook" target="_blank" href="<?php echo $options['facebook']; ?>" title="<?php _e('Facebook','oblivion'); ?>"><span><i class="icon-facebook"></i></span></a>
					<?php endif; ?>
					<?php if($options['google']) : ?>
					<a class="sp sp-googleplus" target="_blank" href="<?php echo $options['google']; ?>" title="<?php _e('Google+','oblivion'); ?>"><span><i class="icon-googleplus"></i></span></a>
					<?php endif; ?>
					<?php if($options['youtube']) : ?>
					<a class="sp sp-youtube" target="_blank" href="<?php echo $options['youtube']; ?>" title="<?php _e('Youtube','oblivion'); ?>"><span><i class="icon-youtube"></i></span></a>
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
		<?php wp_footer(); ?>
	</body>
</html>