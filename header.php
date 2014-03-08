<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <![endif]-->
<html class='no-js'>
<!-- <![endif] -->

	<?php $options = get_option('oblivion_theme_options'); ?>
	<?php $template_url = get_bloginfo('template_url'); ?>
	<head>
		
		<!--
                    
                                  ..:MMMMMMM8::..                                
                               MMMMMMMMMMMMMMMMMMO                              
                           .MMMMMMMMMMMMMMMMMMMMMMMM..                          
                         MMMMMMMMMMMMMMMMMMMMMMMMMMMMMM:                        
                      .MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM                        
                    ..MM MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMO:                    
                   .MM.  .MMMMMMMMMMMMMMMMMM.   .MMMMMMMMMM.                    
                   MM     .MMMMMMMMMMMMMM.         MMMMMMMMM                    
                  MM.       MMMMMMMMMMM.            .MMMMMMMM                   
                 MM.  MM   .MMMMMMMMMM.              .MMMMMMM.                  
                MM.  MMMM.  .MMMMMMMM     .MMMM.       MMMMMMM.                 
               MM   .MMMM   .MMMMMMM:     MMMMMM.      MMMMMMMM                 
              :MM   .MMM$   MMMMMMMM     .MMMMMM.       MMMMMMMM                
              MM           MMMMMMMMMM     MMMMMM.       MMMMMMMM.               
             .MM..         MMMMMMMMMM     .MMMM        .MMMMMMMMM               
             MMMM..         .MMMMMMM.                   MMMMMMMMM.              
             MMMMM..                                   .MMMMMMMMM.              
            MMMMMMMM..                                 MMMMMMMMMMM.             
            MMMMMMMMMMM:.                            .MMMMMMMMMMMM.             
           .MMM,,,,,,.:MMMMMM:..                ..MMMMMMMMMMMMMMMMM.            
           MMM,,,,,,,,,,,,,,,MMMMMMMMMMMMMMMMMMMMMMMMMMMM,,,,,,:MMM.            
           MM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMMM,,,,,,,,,,,MMM.           
          .M8,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,=MMM:,,,,,,,,,,,,,,MM.           
          =M,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMM,,,,,,,,,,,,,,,,,MM.          
          MM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMM,,,,,,,,,,,,,,,,,,,MM.          
          MM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MM,,,,,,,,,,,,,,,,,,,,,,M:          
          MM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MM,,,,,,,,,,,,,,,,,,,,,,,MM          
          MO,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMM,,,,,,,,,,,,,,,,,,,,,,,MM.         
          M,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MM,,,,,,,,,,,,,,,,,,,,,,,,NM.         
          M,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MM,,,,,,,,,,,,,,,,,,,,,,,,,M.         
          M,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMM,,,,,,,,,,,,,,,,,,,,,,,,M.         
          M=,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MM,:,,,,,,,,,,,,,,,,,,,,,,M          
          MM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMM,,,,,,,,,,,,,,,,,,,,,,M.         
          MM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMM,,,,,,,,,,MM,,,,,,,M.         
        MMMM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMMMMMMMMM,,,,,,,,IM:        
      MMMMMMMMM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMM         
      MMMMMMMMMMM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMZ        
       MMMMMMMMMMMM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMMM        
       MMMMMMMMMMMMM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMMMM        
       .8MMMMMMMMMMMM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,OMMMMMM        
          MMMMMMMMMMMM,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,MMMMMM.        
           .MMMMMMMMMMMN,,,DMMMMMMMMMMMMMMMMMMM:,,,,,,,,,,,,,,,MMMMMMMM         
              .MMMMM ..,MMM~.                ..MMMMMMMN,,,,+MMMMMMMMMM         
                                                      ,MMMMZ.MMMMMMMM.          
                                                             .MMMMMM.           
                                                              .MMM.             
                                                                         
			
		-->

		<title><?php wp_title(' - ', true, 'right'); ?></title>

		<meta name="description" content="<?php bloginfo('description'); ?>" />

		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss2_url'); ?>">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel='canonical' href='<?php bloginfo('url'); ?>' />

		<link rel="dns-prefetch" href="//fonts.googleapis.com">
		<link rel="dns-prefetch" href="https://img.youtube.com" />

		<link type="text/css" rel="stylesheet" href="<?php echo $template_url; ?>/style.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="<?php echo $template_url; ?>/css/print.css" media="print" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo $template_url; ?>/images/touch-icon.png"/>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	
		<header id="header" role="banner">
			<div class="inner">
				<h1 id="logo">
					<a title="<?php bloginfo('name'); ?>" href="<?php bloginfo('url'); ?>">
						<?php if($options['icon']) : ?>
							<img class="icon" src="<?php echo $options['icon']; ?>" alt="<?php bloginfo('name'); ?>" />
						<?php /* else : ?>
							<span class="name"><?php bloginfo('name'); ?></span>
						<?php */ endif; ?>
					</a>
				</h1>
				<a id="search-handler">
					<i class="fa fa-times search-close"></i>
					<i class="fa fa-search search-open"></i>
				</a>
				<nav id="navigation" role="navigation">
					<div id="navigation-inner">
						<h2 class="visuallyhidden"><?php _e('Navigation','oblivion'); ?></h2>
						<a id="navigation-handler"><i class="fa fa-bars"></i></a>
						<?php wp_nav_menu(
								array(
									'theme_location' => 'header',
									'container_class' => 'menu-container',
									'fallback_cb' => fallback_menu,
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
		<div id="loading">
			<div class="spinner">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>