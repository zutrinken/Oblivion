<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php if(has_post_thumbnail() && $Imagefilter) : $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large-landscape-filter'); ?>
			<style>
				.page-header-cover {background: url('<?php echo $image[0]; ?>') scroll center center / cover #000 !important;}
				.page-header {background: #000 !important;}
			</style>
		<?php endif; ?>
		<header class="page-header">
			<div class="inner" data-type="prlx" data-speed="0.375">
				<h2 class="page-title">
					<?php the_title(); ?>
				</h2>
				<aside class="page-meta">
					<?php _e('Posted by','oblivion'); ?>
					<?php the_author_posts_link(); ?>
					<?php _e('on','oblivion'); ?>
					<?php the_time('j.m.y'); ?>
				</aside>
			</div>
			<?php if(has_post_thumbnail() && $Imagefilter) : ?>
				<div class="page-header-cover" data-type="prlx" data-speed="0.625"></div>
			<?php endif; ?>
		</header>
		<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="inner">
				<article class="post-content post-article">
					<?php the_content(); ?>
				</article>
				<aside class="post-info">
					<div class="post-meta">
						<?php _e('Posted in:','oblivion'); ?>
						<?php the_category(', '); ?><br />						
						<?php the_tags(__('Tagged with:','oblivion').' ',', ',''); ?>
					</div>
					<div class="clear"></div>
					<div class="post-sharing">
						<a class="sl sl-twitter" target="_blank" href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>"><i class="fa fa-twitter fa-fw"></i> <span>twitter</span></a>
						<a class="sl sl-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook fa-fw"></i> <span>facebook</span></a>
						<a class="sl sl-googleplus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus fa-fw"></i> <span>Google+</span></a>
						<div class="clear"></div>
					</div>
				</aside>
				<div class="clear"></div>
			</div>
		</section>
		<nav class="post-nav" role="navigation">
			<div class="inner">
				<h2 class="visuallyhidden"><?php _e('Article Navigation','oblivion'); ?></h2>
				<span class="post-nav-prev">
					<span class="post-nav-inner">
						<?php previous_post_link('%link', '<span class="label">'. __('previous post','oblivion') . '</span> <span class="title"><i class="fa fa-angle-left"></i> %title</span>', true); ?>
					</span>
				</span>
				<span class="post-nav-next">
					<span class="post-nav-inner">
						<?php next_post_link('%link', '<span class="label">'. __('next post','oblivion') . '</span> <span class="title"><i class="fa fa-angle-right"></i> %title</span>', true); ?>
					</span>
				</span>
				<div class="clear"></div>
			</div>
		</nav>
	
		<section id="replies">
			<?php comments_template(); ?>
		</section>
	<?php endwhile; endif; ?>

	<?php /* get_sidebar(); */ ?>

<?php get_footer(); ?>