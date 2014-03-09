<?php get_header(); ?>
		<?php $options = get_option('oblivion_theme_options'); ?>
		
		<?php if(is_home()) : ?>
		
		<header class="page-header">
			<div class="inner" data-type="prlx" data-speed="0.375">
				<h2 class="page-title">
					<?php bloginfo('name'); ?>
				</h2>
				<aside class="page-meta">
					<?php bloginfo('description'); ?>
				</aside>
			</div>
			<?php if(get_header_image()) : ?>
				<div id="page-header-cover" class="page-header-cover" data-type="prlx" data-speed="0.625"></div>
			<?php endif; ?>
		</header>
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="inner">
					<?php if(get_post_meta($post->ID, 'video', true)) : ?>
						<figure class="post-video">
							<?php echo get_post_meta($post->ID, 'video', true); ?>
						</figure>
					<?php elseif(has_post_thumbnail()) : ?>
						<figure class="post-thumbnail">
							<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('medium-square'); ?>
							</a>
							<?php if(get_post(get_post_thumbnail_id())->post_excerpt) : ?>
								<figcaption class="post-thumbnail-caption">
									<?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
								</figcaption>
							<?php endif; ?>
						</figure>
					<?php endif; ?>
					<header class="post-header">
						<h2 class="post-title">
							<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<aside class="post-meta">
							<?php _e('Posted by','oblivion'); ?>
							<?php the_author_posts_link(); ?>
							<?php _e('on','oblivion'); ?>
							<?php the_time('j.m.y'); ?>
						</aside>
					</header>
					<article class="post-excerpt post-article">
						<?php the_excerpt(); ?>
					</article>
					<div class="clear"></div>
				</div>
			</section>
		<?php endwhile; ?>
			<nav id="pagination">
				<div class="inner">
					<?php wp_pagination_navi(); ?>
				</div>
			</nav>
		<?php endif; ?>
		
		<?php else : ?>
		
		<?php
		/* ==========================================================================
		   Banner
		   ========================================================================== */
		?>

		
		<section class="page-header">
			<div class="inner" data-type="prlx" data-speed="0.375">
				<h1 class="page-title" id="logoless">
					<?php if($options['logo']) : ?>
						<img id="logo-large" src="<?php echo $options['logo']; ?>" alt="<?php bloginfo('name'); ?>" />
					<?php else : ?>
						<?php bloginfo('name'); ?>
					<?php endif; ?>
				</h1>
			</div>
			<?php if(get_header_image()) : ?>
				<div id="page-header-cover" class="page-header-cover" data-type="prlx" data-speed="0.625"></div>
			<?php endif; ?>
		</section>
		

		
		
		<?php
		/* ==========================================================================
		   Blog
		   ========================================================================== */
		?>
		<section id="section-blog" class="frontpage-section scroll-item" title="<?php _e('Blog','oblivion'); ?>">
			<div class="inner">
				<?php
				$args = array(
					'offset' => 0,
					'posts_per_page' => 6,
					'meta_key' => '_thumbnail_id',
					'ignore_sticky_posts' => 1
				);
				$counter = 0;
				query_posts($args);
				if (have_posts()) : while (have_posts()) : the_post(); $counter++; ?>
					<section id="post-<?php the_ID(); ?>" <?php post_class('post-count-'.$counter.' featured-post'); ?>>
						<div class="post-inner">
							<?php if(has_post_thumbnail()) : ?>
								<figure class="post-thumbnail">
									<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">								
										<?php the_post_thumbnail('medium-featured'); ?>
									</a>
									<?php if(get_post(get_post_thumbnail_id())->post_excerpt) : ?>
										<figcaption class="post-thumbnail-caption">
											<?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
										</figcaption>
									<?php endif; ?>
								</figure>
							<?php endif; ?>
							<header class="post-header">
								<h3 class="post-title">
									<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo short_title(' ...', 10); ?></a>
								</h3>
								<aside class="post-meta">
									<?php _e('Posted by','oblivion'); ?>
									<?php the_author_posts_link(); ?>
									<?php _e('on','oblivion'); ?>
									<?php the_time('j.m.y'); ?>
								</aside>
							</header>
							<article class="post-excerpt post-article">
								<?php echo custom_excerpt(48); ?>
							</article>
							<div class="clear"></div>
						</div>
					</section>
				<?php endwhile; ?><?php endif; wp_reset_query(); ?>
				<div class="clear"></div>

			</div>
		</section>


		<section id="section-blog-more" class="frontpage-section">
			<div class="inner">

				<aside class="featured-post-more">
					<?php $bloglink = _get_page_link(get_option('page_for_posts')); ?>
					<a class="standard-btn orange-btn blog-btn" href="<?php echo $bloglink; ?>">
						<span><?php _e('See all Posts','oblivion'); ?> <i class="fa fa-arrow-circle-o-right fa-fw"></i></span>
					</a>
					<?php if($options['twitter']) : ?>
					<a class="standard-btn sp sp-twitter" target="_blank" href="<?php echo $options['twitter']; ?>" title="<?php _e('Twitter','oblivion'); ?>"><span><i class="fa fa-twitter fa-fw"></i></span></a>
					<?php endif; ?>
					<?php if($options['facebook']) : ?>
					<a class="standard-btn sp sp-facebook" target="_blank" href="<?php echo $options['facebook']; ?>" title="<?php _e('Facebook','oblivion'); ?>"><span><i class="fa fa-facebook fa-fw"></i></span></a>
					<?php endif; ?>
					<?php if($options['google']) : ?>
					<a class="standard-btn sp sp-googleplus" target="_blank" href="<?php echo $options['google']; ?>" title="<?php _e('Google+','oblivion'); ?>"><span><i class="fa fa-google-plus fa-fw"></i></span></a>
					<?php endif; ?>
					<?php if($options['youtube']) : ?>
					<a class="standard-btn sp sp-youtube" target="_blank" href="<?php echo $options['youtube']; ?>" title="<?php _e('Youtube','oblivion'); ?>"><span><i class="fa fa-youtube-play fa-fw"></i></span></a>
					<?php endif; ?>
					<a class="standard-btn sp sp-rss" target="_blank" href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('RSS','oblivion'); ?>"><span><i class="fa fa-rss fa-fw"></i></span></a>
					<div class="clear"></div>
				</aside>
					
			</div>
		</section>


		<?php
		/* ==========================================================================
		   Newsletter
		   ========================================================================== */
		?>
		<?php /* if($options['newsletter']) : ?>
		<section id="section-newsletter" class="frontpage-section" title="<?php _e('Newsletter','oblivion'); ?>">
			<div class="inner">
				<header class="section-header">
					<h2 class="section-title"><?php _e('Newsletter','oblivion'); ?></h2>
				</header>
				<aside class="section-aside">
					<p><?php _e('Subscribe to our awesome newsletter.','oblivion'); ?></p>
					<form id="newsletter-form" action="<?php echo $options['newsletter']; ?>" method="post">
						<input id="newsletter-email" type="email" placeholder="<?php _e('Your Email','oblivion'); ?>" name="email">
						<button id="newsletter-submit" type="submit" name="submit"><?php _e('Subscribe','oblivion'); ?></button>
					</form>
				</aside>
			</div>
		</section>
		<?php endif; */ ?>
			
		

		<?php
		/* ==========================================================================
		   Widgets
		   ========================================================================== */
		?>

		<?php if (is_active_sidebar('Frontpage')) : ?>

		<section id="section-widgets" class="frontpage-section" title="<?php _e('Widgets','oblivion'); ?>">
			<div class="inner">
				<h2 class="visuallyhidden"><?php _e('Widgets','oblivion'); ?></h2>

				<?php dynamic_sidebar('Frontpage'); ?>
				<div class="clear"></div>
			</div>
		</section>

		<?php endif; ?>
		
		<?php endif; ?>

<?php get_footer(); ?>