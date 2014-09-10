<?php get_header(); ?>

		<section class="page-header" id="opener">
			<div class="inner" data-type="prlx" data-speed="0.375">
				<h2 class="page-title">
					<?php _e('404','oblivion'); ?>
				</h2>
				<aside class="page-meta">
					<?php _e('Nothing found here.','oblivion'); ?>
				</aside>
			</div>
			<div class="page-header-cover" data-type="prlx" data-speed="0.625"></div>
		</section>
		<section id="post-404" class="page hentry">
			<div class="inner">
				<article class="post-content post-article">
					<p><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/penguin.png" width="256" height="256" style="padding-bottom: 4.8em;" /></a></p>
				</article>
				<div class="clear"></div>
			</div>
		</section>

<?php get_footer(); ?>