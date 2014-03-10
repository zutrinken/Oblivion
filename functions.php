<?php

/* load theme options */
$options = get_option('oblivion_theme_options');

$Imagefilter = false;
if (extension_loaded('gd') && function_exists('imagecopy') && function_exists('imagefilter') ) {
	$Imagefilter = true;
	include 'inc/imagefilter.php';
}

	/* ==========================================================================
	   Initials
	   ========================================================================== */


add_action('wp_enqueue_scripts', 'oblivion_fonts');
function oblivion_fonts() {
	wp_register_style('oblivion-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600,400italic,700italic|Inconsolata:400|Vollkorn:400,400italic,700italic');
	wp_enqueue_style('oblivion-fonts');
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');
function enqueue_scripts() {
	$template = get_template_directory_uri();
	
	wp_enqueue_script('oblivion-modernizr', $template.'/js/libs/modernizr-2.6.2.min.js', array(), null, false);

	wp_enqueue_script('jquery');
	wp_enqueue_script('oblivion-jquery.fitvids', $template.'/js/libs/jquery.fitvids.js', array(), null, false);
	
	if(!is_front_page() && (is_page() || is_single())) {
		wp_enqueue_style( 'oblivion-highlight-style', $template.'/css/highlight.css', array(), null, false);
		wp_enqueue_script('oblivion-highlight-script', $template.'/js/libs/highlight.pack.js', array(), null, false);
	}
	if(is_front_page()) {
		wp_enqueue_style( 'oblivion-frontpage-style', $template.'/css/front-page.css', array(), null, false);
	}
	wp_enqueue_script('oblivion-index', $template.'/js/index.js', array(), null, true);
}

/* localization */
load_theme_textdomain('oblivion', TEMPLATEPATH .'/languages');

/* add "editor-style.css" for the admin-interface */
add_editor_style('css/editor-style.css');

/* add a favicon for the admin area */
function favicon4admin() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . TEMPLATEPATH . '/favicon.ico" />';
}
add_action( 'admin_head', 'favicon4admin' );

/* load "login.css" for the login */
function custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . TEMPLATEPATH . '/css/login.css" />';
}
add_action('login_head', 'custom_login');

/* add custom theme-options */
require_once(TEMPLATEPATH .'/inc/theme-options.php');

/* add twitter and wiki profile */
function add_twitter_contactmethod( $contactmethods ) {
	/* Add Twitter */
	$contactmethods['twitter'] = __('Twitter (without @)','oblivion');
	return $contactmethods;
}
add_filter('user_contactmethods','add_twitter_contactmethod',10,1);

/* Disable default Gallery Style */
add_filter( 'use_default_gallery_style', '__return_false' );

/* register post formats */
add_theme_support (
	'post-formats',
	array (
		'video',
		'audio'
	)
);

	/* ==========================================================================
	   WP Title
	   ========================================================================== */


function oblivion_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}
	$title .= get_bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'oblivion' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'oblivion_wp_title', 10, 2 );


	/* ==========================================================================
	   Images Setup
	   ========================================================================== */

/* add custom image-sizes */
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support('post-thumbnails');

	add_image_size('medium-featured', 560, 350, true);
	add_image_size('medium-square', 480, 480, true);

	if ($Imagefilter) {
		imagefilter_add_image_size('large-landscape', 480, 180, true, true);
	} else {
		add_image_size('large-landscape', 480, 180, true, true);
	}
}

	/* ==========================================================================
	   Navigation
	   ========================================================================== */

/* register all menus */
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'header' => __('Header','oblivion'),
			'footer' => __('Footer','oblivion')
		)
	);
}

function fallback_menu() {
    wp_page_menu(
    	array(
    		'show_home' => __('Start','oblivion'),
    		'menu_class' => 'menu-container'
    	)
    );
}

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
	/* add css class for li with submenu */
	public function display_element($el, &$children, $max_depth, $depth = 0, $args, &$output) {
		$id = $this->db_fields['id'];
		if(isset($children[$el->$id])) $el->classes[] = 'has-children';
		parent::display_element($el, $children, $max_depth, $depth, $args, $output);
	}
      
	/* modify xfn attribute for keyboard shortcut */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
		$class_names = $value = '';
	
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
	
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
	
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  		. esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' 		. esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' accesskey="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   		. esc_attr( $item->url        ) .'"' : '';
		
		// First applying the filters. After that, underline the accesskey in the title if present...
		$item_title = apply_filters( 'the_title', $item->title, $item->ID );
		if( ! empty( $item->xfn ) ) {
			$letterpos = strpos($item_title, esc_attr( $item->xfn ) );
			$item_title = substr($item_title, 0, $letterpos)."<u>".substr($item_title, $letterpos, 1)."</u>".substr($item_title, $letterpos+1);
		}
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $item_title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
	
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}





	/* ==========================================================================
	   Sidebar
	   ========================================================================== */

add_action( 'widgets_init', 'my_register_sidebars' );
function my_register_sidebars() {
	register_sidebar(
		array(
			'id'=>'frontpage',
			'name'=>__('Frontpage','oblivion'),
			'description' => __('The default sidebar.','oblivion'),
			'before_widget' => '<aside id="%1$s" class="widget frontpage-widget %2$s" role="group"><div class="widget-inner">',
			'after_widget' => '</div></aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
}

	/* ==========================================================================
	   Custom Header Image
	   ========================================================================== */

define('NO_HEADER_TEXT', true );
define('HEADER_IMAGE_WIDTH', 1440);
define('HEADER_IMAGE_HEIGHT', 540);

function header_style() {
		if (get_header_image()) {
		?><style type="text/css">
			.home .page-header-cover {			
				background: url('<?php header_image(); ?>') no-repeat scroll center center / cover transparent;
			}
			.home .page-header {
				background: #000 !important;
			}
		</style><?php
		}

}

function admin_header_style() {
    ?><style type="text/css">
		div#headimg {
			background-size: cover;
			background-position: center center;
			width: 100%;
			height: 0;
			padding-bottom: 0.5625;
		}
		.default-header label img {
			width: 37.5%;
			height: auto;
		}
    </style><?php
}
add_custom_image_header('header_style', 'admin_header_style');



	/* ==========================================================================
	   Shortcodes
	   ========================================================================== */

/* Enable shortcodes in widget areas */
add_filter( 'widget_text', 'do_shortcode' );

/* Replace WP autop formatting */
if (!function_exists( "oblivion_remove_wpautop")) {
	function oblivion_remove_wpautop($content) { 
		$content = do_shortcode( shortcode_unautop( $content ) ); 
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}


/* Two Columns */
function oblivion_shortcode_two_columns_one( $atts, $content = null ) {
   return '<div class="two-columns-one">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'oblivion_shortcode_two_columns_one' );

function oblivion_shortcode_two_columns_one_last( $atts, $content = null ) {
   return '<div class="two-columns-one last">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one_last', 'oblivion_shortcode_two_columns_one_last' );


/* Three Columns */
function oblivion_shortcode_three_columns_one($atts, $content = null) {
   return '<div class="three-columns-one">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'oblivion_shortcode_three_columns_one' );

function oblivion_shortcode_three_columns_one_last($atts, $content = null) {
   return '<div class="three-columns-one last">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one_last', 'oblivion_shortcode_three_columns_one_last' );

function oblivion_shortcode_three_columns_two($atts, $content = null) {
   return '<div class="three-columns-two">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'oblivion_shortcode_three_columns_two' );

function oblivion_shortcode_three_columns_two_last($atts, $content = null) {
   return '<div class="three-columns-two last">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two_last', 'oblivion_shortcode_three_columns_two_last' );


/* Four Columns */
function oblivion_shortcode_four_columns_one($atts, $content = null) {
   return '<div class="four-columns-one">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'oblivion_shortcode_four_columns_one' );

function oblivion_shortcode_four_columns_one_last($atts, $content = null) {
   return '<div class="four-columns-one last">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one_last', 'oblivion_shortcode_four_columns_one_last' );

function oblivion_shortcode_four_columns_two($atts, $content = null) {
   return '<div class="four-columns-two">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'oblivion_shortcode_four_columns_two' );

function oblivion_shortcode_four_columns_two_last($atts, $content = null) {
   return '<div class="four-columns-two last">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two_last', 'oblivion_shortcode_four_columns_two_last' );

function oblivion_shortcode_four_columns_three($atts, $content = null) {
   return '<div class="four-columns-three">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'oblivion_shortcode_four_columns_three' );

function oblivion_shortcode_four_columns_three_last($atts, $content = null) {
   return '<div class="four-columns-three last">' . oblivion_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three_last', 'oblivion_shortcode_four_columns_three_last' );

/* Divide Text Shortcode */
function oblivion_shortcode_divider($atts, $content = null) {
   return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'oblivion_shortcode_divider' );



function oblivion_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'link'	=> '#',
    'target' => '',
    'color'	=> '',
    'size'	=> '',
	 'form'	=> '',
	 'font'	=> '',
    ), $atts));

	$color = ($color) ? ' '.$color. '-btn' : '';
	$size = ($size) ? ' '.$size. '-btn' : '';
	$form = ($form) ? ' '.$form. '-btn' : '';
	$font = ($font) ? ' '.$font. '-btn' : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="standard-btn' .$color.$size.$form.$font. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

    return $out;
}
add_shortcode('button', 'oblivion_button');



	/* ==========================================================================
	   Caption
	   ========================================================================== */

function custom_caption($attr, $content = null) {
	/* New-style shortcode with the caption inside the shortcode with the link and image tags. */
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ($id) $id = 'id="' . esc_attr($id) . '" ';
	
	/* set the initial class output */
	$class = 'wp-caption';
	
	/* use a preg match to catch the img class attribute */
	preg_match('/<img.*class[ \t]*=[ \t]*["\']([^"\']*)["\'][^>]+>/', $content, $matches);
	$class_attr = isset($matches[1]) && $matches[1] ? $matches[1] : false;
	
	/* if the class attribute is not empty get an array of all classes */
	if ( $class_attr ) {
		foreach ( explode(' ', $class_attr) as $aclass ) {
			if ( strpos($aclass, 'size-') === 0 ) $class .= ' ' . $aclass;
		}
	}
	
	$class .= ' ' . esc_attr($align);

	return '<figure '. $id .'class="'. esc_attr($class) .'" style="width: '. ($width) .'px">'. do_shortcode($content) .'<span class="wp-caption-text">'. $caption .'</span></figure>';
}

add_shortcode('wp_caption', 'custom_caption');
add_shortcode('caption', 'custom_caption');


	/* ==========================================================================
	   Trim Post Title
	   ========================================================================== */

function short_title($after = '', $length) {
	$mytitle = explode(' ', get_the_title(), $length);
	if (count($mytitle)>=$length) {
		array_pop($mytitle);
		$mytitle = implode(" ",$mytitle). $after;
	} else {
		$mytitle = implode(" ",$mytitle);
	}
	return $mytitle;
}

	/* ==========================================================================
	   Excerpt
	   ========================================================================== */


function custom_wp_trim_excerpt($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		// Retrieve the post content
		$text = get_the_content('');
 
		// Delete all shortcode tags from the content
		$text = strip_shortcodes( $text );
 
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text); 
 		// MODIFY THIS. Add the allowed HTML tags separated by a comma
		$allowed_tags = '<p>,<br>,<br />';
		$text = strip_tags($text, $allowed_tags);
 
		$text = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $text);

 
 		// MODIFY THIS. change the excerpt word count to any integer you like
		$excerpt_word_count = 54;
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);

 		// MODIFY THIS. change the excerpt endind to something else
		$excerpt_end = ' <span class="post-cut">[...]</span> <a class="post-more" href="'. get_permalink($post->ID) . '">'. __("read more","oblivion") .'</a>';

		$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
 
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');



function custom_excerpt($excerpt_length = 55, $id = false, $echo = true) {
	$text = '';
	
	if($id) {
		$the_post = & get_post( $my_id = $id );
		$text = ($the_post->post_excerpt) ? $the_post->post_excerpt : $the_post->post_content;
	} else {
		global $post;
		$text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
	}
	
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = strip_tags($text);
	$text = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $text);
	
	$excerpt_more = ' <span class="post-cut">[...]</span> <a class="post-more" href="'. get_permalink($post->ID) . '">'. __("read more","oblivion") .'</a>';
	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = implode(' ', $words);
	}
	if($echo)
	echo apply_filters('the_content', $text);
	else
	return $text;
}
	
function get_custom_excerpt($excerpt_length = 55, $id = false, $echo = false) {
	return custom_excerpt($excerpt_length, $id, $echo);
}


	/* ==========================================================================
	   Current Page
	   ========================================================================== */

function current_paged( $var = '' ) {
    if( empty( $var ) ) {
        global $wp_query;
        if( !isset( $wp_query->max_num_pages ) )
            return;
        $pages = $wp_query->max_num_pages;
    }
    else {
        global $$var;
            if( !is_a( $$var, 'WP_Query' ) )
                return;
        if( !isset( $$var->max_num_pages ) || !isset( $$var ) )
            return;
        $pages = absint( $$var->max_num_pages );
    }
    if( $pages < 1 )
        return;
    $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    echo __('Page ','oblivion') . $page . __(' of ','oblivion') . $pages;
}


	/* ==========================================================================
	   Pagination
	   ========================================================================== */

function wp_pagination_navi($num_page_links = 5, $min_max_offset = 2){
	global $wp_query;
	/* Do not show paging on single pages */
	if( !is_single() ){
		$current_page       = intval(get_query_var('paged'));
		$total_pages        = $wp_query->max_num_pages;
		$left_offset        = floor(($num_page_links - 1) / 2);
		$right_offset       = ceil(($num_page_links -1) / 2);
		if( empty($current_page) || $current_page ==  0 ) {
			$current_page = 1;
		}
		// More than one page -> render pagination
		if ( $total_pages > 1 ) {
			echo '<div class="pagination-info"><span>'. __('Page ','oblivion') . $current_page . __(' of ','oblivion') . $total_pages .'</span></div>';
			echo '<nav class="pagination-pager">';
           	if ( $current_page > 1 ) {
				echo '<a class="pagination-previous" href="' .get_pagenum_link($current_page-1) .'" title="previous"><i class="fa fa-angle-left"></i> <span>' . __('previous','oblivion') .'</span></a>';
			} else {
				echo '<span class="pagination-previous" title="previous"><i class="fa fa-angle-left"></i> <span>' . __('previous','oblivion') .'</span></span>';
			}
			for ( $i = 1; $i <= $total_pages; $i++) {
				if ( $i == $current_page ){
					// Current page
					echo '<a href="'.get_pagenum_link($current_page).'" class="current-page" title="page '.$i.'" >'.($current_page).'</a>';
				} else {
					// Pages before and after the current page
					if ( ($i >= ($current_page - $left_offset)) && ($i <= ($current_page + $right_offset)) ){
						echo '<a href="'.get_pagenum_link($i).'" title="page '.$i.'" >'.$i.'</a>';
					} elseif ( ($i <= $min_max_offset) || ($i > ($total_pages - $min_max_offset)) ) {
						// Start and end pages with min_max_offset
						echo '<a href="'.get_pagenum_link($i).'" title="page '.$i.'" >'.$i.'</a>';
					} elseif ( (($i == ($min_max_offset + 1)) && ($i < ($current_page - $left_offset + 1))) ||
								(($i == ($total_pages - $min_max_offset)) && ($i > ($current_page + $right_offset ))) ) {
						// Dots after/before min_max_offset
						echo '<span class="pagination-dots">&bull;&bull;&bull;</span>';
					}
				}
			}
			if ( $current_page != $total_pages ) {
				echo '<a class="pagination-next" href="'.get_pagenum_link($current_page+1).'" title="next"><span>' . __('next','oblivion') .'</span> <i class="fa fa-angle-right"></i></a>';
			} else {
				echo '<span class="pagination-next" title="next"><span>' . __('next','oblivion') .'</span> <i class="fa fa-angle-right"></i></span>';
			}
			echo '</nav><div class="clear"></div>'; //Close pagination
		}
	}
}


	/* ==========================================================================
	   Comments
	   ========================================================================== */

function custom_comment($comment, $args, $depth) {
	global $comment_counter;
	if ($comment->comment_parent < 1) {
		$comment_counter ++;
	}
	$GLOBALS['comment'] = $comment;
	$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );
	?>
	<li id="li-comment-<?php comment_ID() ?>" <?php comment_class($parent_class); ?>>
		<?php if ($comment->comment_parent < 1) {echo '<span class="comment-number">' . $comment_counter . '</span>';} ?>
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-info">
				<figure class="comment-avatar"><?php echo get_avatar($comment->comment_author_email, 128); ?></figure>
				<cite class="comment-fn"><?php printf(__('%s','oblivion'), get_comment_author_link()); ?></cite>
				<a class="comment-date" href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s'), get_comment_date('d.m.Y')) ?></a>
				<span class="comment-reply"><?php comment_reply_link(array('reply_text' => '<i class="fa fa-reply"></i> <span>' ._x('reply','oblivion').'</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'])); ?></span>
				<div class="clear"></div>
			</div><!--comment-info-->
			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
					<span class="unlock"><?php _e('Your comment will be public soon.','oblivion') ?></span>
					<br />
				<?php endif; ?>
				<?php comment_text() ?>
				<div class="clear"></div>
			</div><!--comment-text-->
		</div><!--comment-body-->
		<?php
}
?>