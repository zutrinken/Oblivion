<!DOCTYPE HTML>
<!--[if IE 7]><html class="no-js lt-ie10 lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie10 lt-ie9"><![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" <?php language_attributes(); ?>> <!--<![endif]-->

	<?php $options = get_option('oblivion_theme_options'); ?>
	<?php $template_url = get_template_directory_uri(); ?>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss2_url'); ?>">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="canonical" href="<?php echo home_url(); ?>" />

		<link rel="dns-prefetch" href="//fonts.googleapis.com">
		<link rel="dns-prefetch" href="https://img.youtube.com" />

		<link type="text/css" rel="stylesheet" href="<?php echo $template_url; ?>/style.css" media="screen" />
		<!--[if IE]>
		<link type="text/css" rel="stylesheet" href="<?php echo $template_url; ?>/css/ie.css" media="screen" />
		<![endif]-->
		<link type="text/css" rel="stylesheet" href="<?php echo $template_url; ?>/css/print.css" media="print" />
		
		<?php if(is_single()) : ?>
			<?php
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'thumbnail', true);
			?>
			<meta property="og:title" content="<?php the_title(); ?>" />
			<meta property="og:type" content="article" />
			<meta property="og:url" content="<?php the_permalink(); ?>" />
			<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
			<meta property="og:description" content="<?php if(have_posts()) { while(have_posts()) { the_post(); echo strip_tags(get_the_excerpt()); }} ?>" />
			<?php if($image_url) : ?>
			<meta property="og:image" content="<?php echo $image_url[0]; ?>" />
			<meta property="og:image:width" content="150" />
			<meta property="og:image:height" content="150" />
			<?php endif; ?>
			<meta property="twitter:card" content="summary" />
			<meta property="twitter:title" content="<?php the_title(); ?>" />
			<meta property="og:description" content="<?php if(have_posts()) { while(have_posts()) { the_post(); echo strip_tags(get_the_excerpt()); }} ?>" />
			<?php if($image_url) : ?>
			<meta property="twitter:image" content="<?php echo $image_url[0]; ?>" />
			<?php endif; ?>
		<?php else : ?>
			<meta property="og:title" content="<?php bloginfo('name'); ?>" />
			<meta property="og:type" content="website" />
			<meta property="og:url" content="<?php echo home_url(); ?>" />
			<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
			<meta property="og:description" content="<?php bloginfo('description'); ?>" />
			<meta property="twitter:card" content="summary" />
			<meta property="twitter:title" content="<?php the_title(); ?>" />
			<meta property="twitter:description" content="<?php bloginfo('description'); ?>" />
		<?php endif; ?>
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	
		<header id="header" role="banner">
			<div class="inner">
				<h1 id="logo">
					<a title="<?php bloginfo('name'); ?>" href="<?php echo home_url(); ?>">
						<?php if($options['icon']) : ?>
							<img class="icon" src="<?php echo $options['icon']; ?>" alt="<?php bloginfo('name'); ?>" />
						<?php else : ?>
							<span class="home"><i class="icon-home"></i></span>
						<?php endif; ?>
					</a>
				</h1>
				<a id="search-link" class="search-handler" href="<?php echo home_url(); ?>/?s=&nbsp;&submit="><i class="icon-search"></i></a>
				<a id="search-handler" class="search-handler">
					<i class="icon-close search-close"></i>
					<i class="icon-search search-open"></i>
				</a>
				<nav id="navigation" role="navigation">
					<div id="navigation-inner">
						<h2 class="visuallyhidden"><?php _e('Navigation','oblivion'); ?></h2>
						<a id="navigation-handler"><i class="icon-menu"></i></a>
						<?php wp_nav_menu(
								array(
									'theme_location' => 'header',
									'container_class' => 'menu-container',
									'fallback_cb' => 'oblivion_fallback_menu',
									'walker' => new My_Walker_Nav_Menu()
								)
							); ?>
						<div class="clear"></div>
					</div>
				</nav>
				<div class="clear"></div>
			</div>
		</header>
		<div id ="search" class="searcharea">
			<h2 class="visuallyhidden"><?php _e('Search','oblivion'); ?></h2>
			<?php get_search_form(); ?>
		</div>