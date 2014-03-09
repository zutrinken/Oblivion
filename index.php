<?php get_header(); ?>

	<?php if(is_home() && get_option('page_for_posts')) : ?>	
		<header class="page-header">
			<div class="inner">
				<?php $blog_page_id = get_option('page_for_posts'); ?>
				<h2 class="page-title">
					<?php echo get_page($blog_page_id)->post_title; ?>
				</h2>
				<aside class="page-meta">
					<?php current_paged(); ?>
				</aside>
			</div>
		</header>
	<?php endif; ?>

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

<?php get_footer(); ?>