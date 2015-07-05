<?php get_header(); ?>

	<?php if(!is_home()) : ?>
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php if(has_post_thumbnail() && $Imagefilter) : $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large-landscape-filter'); ?>
				<style>
					.page-header-cover {background: url('<?php echo $image[0]; ?>') scroll center center / cover #000 !important;}
					.page-header {background: #000 !important;}
				</style>
			<?php endif; ?>
			<section class="page-header" id="opener">
				<div class="inner" data-type="prlx" data-speed="0.375">
					<h2 class="page-title">
						<?php the_title(); ?>
					</h2>
				</div>
				<?php if(has_post_thumbnail() && $Imagefilter) : ?>
					<div class="page-header-cover" data-type="prlx" data-speed="0.625"></div>
				<?php endif; ?>
			</section>
			<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="inner">
					<article class="post-content post-article">
						<?php the_content(); ?>
					</article>
					<div class="clear"></div>
				</div>
			</section>
		<?php endwhile; endif; ?>
	<?php else : ?>
	
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
		
		<?php if (have_posts()) : ?>
		
		<section id="section-blog" class="frontpage-section scroll-item" title="<?php _e('Blog','oblivion'); ?>">
			<div class="inner">
				<?php $counter = 0; ?>

				<div id="masonry">
				
				<?php while (have_posts()) : the_post(); $counter++; ?>
					<section id="post-<?php the_ID(); ?>" <?php post_class(' post-count-'.$counter.' featured-post masonry-item'); ?>>
						<div class="post-inner">
							<header class="post-header">
								<h3 class="post-title">
									<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo oblivion_short_title(' ...', 8); ?></a>
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
								<?php echo oblivion_custom_excerpt(48); ?>
							</article>
							<div class="clear"></div>
						</div>
					</section>
				<?php endwhile; ?>
				
				</div>

			</div>
		</section>

		<?php if($wp_query->max_num_pages > 1) : ?>
			<div class="pagination" id="index-pagination">
				<div class="inner">
					<div class="pagination-info">
						<span><?php oblivion_current_paged(); ?></span>
					</div>
					<nav class="pagination-pager">
					<?php
						$args = array(
							'prev_text' => '<i class="icon-angle-left"></i> <span>' . __('previous','oblivion') .'</span>',
							'next_text' => '<span>' . __('next','oblivion') .'</span> <i class="icon-angle-right"></i>',
						);
						echo paginate_links($args);
					?>
					</nav>
					<div class="clear"></div>
				</div>
			</div>
		<?php endif; ?>

		<?php endif;?>
	
	<?php endif; ?>
<?php get_footer(); ?>