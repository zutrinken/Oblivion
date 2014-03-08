<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php if(has_post_thumbnail() && $Imagefilter) : $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large-landscape-filter'); ?>
			<style>
				.page-header-cover {background: url('<?php echo $image[0]; ?>') scroll center center / cover #000 !important;}
				.page-header {background: #000 !important;}
			</style>
		<?php endif; ?>
		<section class="page-header" id="opener">
			<div class="inner">
				<h2 class="page-title">
					<?php the_title(); ?>
				</h2>
			</div>
			<?php if(has_post_thumbnail() && $Imagefilter) : ?>
				<div class="page-header-cover"></div>
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
	<?php endwhile; ?>

	<?php endif; ?>

	<?php /* get_sidebar(); */ ?>

<?php get_footer(); ?>