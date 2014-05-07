<?php get_header(); ?>
		<?php $options = get_option('oblivion_theme_options'); ?>
		

		<section class="page-header">
			<div class="inner" data-type="prlx" data-speed="0.375">
				<h1 class="page-title">
					<?php if($options['logo']) : ?>
						<img id="logo-image" src="<?php echo $options['logo']; ?>" alt="<?php bloginfo('name'); ?>" />
					<?php else : ?>
						<span id="logo-name"><?php bloginfo('name'); ?></span>
					<?php endif; ?>
				</h1>
			</div>
			<?php if(get_header_image()) : ?>
				<div id="page-header-cover" class="page-header-cover" data-type="prlx" data-speed="0.625"></div>
			<?php endif; ?>
		</section>
		
		
		<?php if(is_home()) : ?>
		
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
		   Blog
		   ========================================================================== */
		?>		
		
		<section id="section-blog" class="frontpage-section scroll-item" title="<?php _e('Blog','oblivion'); ?>">
			<div class="inner">
				<?php
				$cats = $options['highlight-category'];
				$tags = $options['highlight-tag'];
				$args = array(
					'posts_per_page' => 32
				);
				$counter = 0;
				query_posts($args);
				if (have_posts()) : ?>
				
				<div id="masonry">
				
				<?php while (have_posts()) : the_post();
					$counter++;
					if(has_category($cats, $post_ID) || has_tag($tags, $post_ID)) {
						$highlight = 'highlight';
					} else {
						$highlight = '';
					}
				?>
					<section id="post-<?php the_ID(); ?>" <?php post_class($highlight . ' post-count-'.$counter.' featured-post masonry-item'); ?>>
						<div class="post-inner">
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
							<?php if(get_post_meta($post->ID, 'video', true)) : ?>
								<figure class="post-video">
									<?php echo get_post_meta($post->ID, 'video', true); ?>
								</figure>
							<?php elseif(has_post_thumbnail()) : ?>
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
							<article class="post-excerpt post-article">
								<?php echo custom_excerpt(48); ?>
							</article>
							<div class="clear"></div>
						</div>
					</section>
				<?php endwhile; ?>
				
				</div>

				<?php endif; wp_reset_query(); ?>
				<div class="clear"></div>
			</div>
		</section>
		
		
		<section id="section-blog-more">
			<div class="inner">
				<aside class="featured-post-more">
					<?php $count_posts = wp_count_posts(); ?>
					<span class="sp sp-post-count"><span><?php printf(_n('One post','%s posts',$count_posts->publish,'oblivion'), $count_posts->publish); ?></span></span>
					<?php $bloglink = _get_page_link(get_option('page_for_posts')); ?>
					<a class="sp sp-blog" href="<?php echo $bloglink; ?>"><span><?php _e('See all Posts','oblivion'); ?> <i class="fa fa-play-circle fa-fw"></i></span></a>
					<div class="clear"></div>
				</aside>
					
			</div>
		</section>

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