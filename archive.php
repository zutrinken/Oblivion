<?php get_header(); ?>

		<section class="page-header">
			<div class="inner" data-type="prlx" data-speed="0.375">
				<h2 class="page-title">
					<?php if (is_category()) : ?>
						<?php _e('Category','oblivion'); ?>: <?php single_cat_title(); ?>
				
					<?php elseif (is_tag()) : ?>
						<?php _e('Tag','oblivion'); ?>: <?php single_tag_title(); ?>

					<?php elseif (is_author()) : ?>
						<?php _e('Author','oblivion'); $authordata = get_userdata($post->post_author); echo ': ' . $authordata->display_name; ?>

					<?php elseif (is_day()) : ?>
						<?php _e('Day','oblivion'); ?>: <?php the_time('j. F Y'); ?>
						
					<?php elseif (is_month()) : ?>
						<?php _e('Month','oblivion'); ?>: <?php the_time('F Y'); ?>
						
					<?php elseif (is_year()) : ?>
						<?php _e('Year','oblivion'); ?>: <?php the_time('Y'); ?>
						
					<?php else : ?>
						<?php _e('Archive','oblivion'); ?>
						
					<?php endif; ?>
				</h2>
				<?php if ((is_category()) && (category_description())) : ?>
					<aside class="page-meta">
						<?php echo category_description(); ?>
					</aside>
				<?php else : ?>
					<aside class="page-meta">
						<?php 
							$post_count = $wp_query->found_posts;
							if($post_count == 0) {
								echo __('No Posts','oblivion');
							} elseif($post_count == 1) {
								echo $post_count . '&#32;' . __('Post','oblivion');
							} else {
								echo $post_count . '&#32;' . __('Posts','oblivion');
							}
						?>
					</aside>
				<?php endif; ?>
			</div>
		</section>
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
		<?php if($wp_query->max_num_pages > 1) : ?>
			<nav id="pagination">
				<div class="inner">
					<div class="pagination-info">
						<span><?php oblivion_current_paged(); ?></span>
					</div>
					<nav class="pagination-pager">
					<?php
						$args = array(
							'prev_text' => '<i class="fa fa-angle-left"></i> <span>' . __('previous','oblivion') .'</span>',
							'next_text' => '<span>' . __('next','oblivion') .'</span> <i class="fa fa-angle-right"></i>',
						);
						echo paginate_links($args);
					?>
					</nav>
					<div class="clear"></div>
				</div>
			</nav>
		<?php endif; ?>
	<?php endif; ?>

	<?php /* get_sidebar(); */ ?>

<?php get_footer(); ?>