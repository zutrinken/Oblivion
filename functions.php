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
	wp_register_style('oblivion-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600,400italic,700italic|Vollkorn:400italic,700italic');
	wp_enqueue_style('oblivion-fonts');
}

add_action('wp_enqueue_scripts', 'oblivion_enqueue_scripts');
function oblivion_enqueue_scripts() {
	$template = get_template_directory_uri();
	
	wp_enqueue_script('oblivion-modernizr', $template.'/js/libs/modernizr-2.8.3.min.js', array(), null, false);

	wp_enqueue_script('jquery');
	wp_enqueue_script('oblivion-jquery.fitvids', $template.'/js/libs/jquery.fitvids.js', array(), null, false);
	
	if(!is_home() && (is_page() || is_single())) {
		wp_enqueue_style( 'oblivion-highlight-style', $template.'/css/highlight.css', array(), null, false);
		wp_enqueue_script('oblivion-highlight-script', $template.'/js/libs/highlight.pack.js', array(), null, false);
	}
	if(is_single() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	if(is_front_page() && is_home()) {
		wp_enqueue_style( 'oblivion-frontpage-style', $template.'/css/front-page.css', array(), null, false);
		wp_enqueue_script('jquery-masonry');
		wp_enqueue_script('oblivion-frontpage-script', $template.'/js/front-page.js', array(), null, true);
	}
	wp_enqueue_script('oblivion-index', $template.'/js/index.js', array(), null, true);
}

/* localization */
load_theme_textdomain('oblivion', get_template_directory() .'/languages');

/* add "editor-style.css" for the admin-interface */
add_editor_style('css/editor-style.css');

/* add custom theme-options */
require_once(get_template_directory() .'/inc/theme-options.php');

/* Disable default Gallery Style */
add_filter( 'use_default_gallery_style', '__return_false' );

/* Enable post and comment RSS feed links to head */
add_theme_support('automatic-feed-links');

/* Set content width */
if ( ! isset( $content_width ) ) {
	$content_width = 560;
}


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
add_theme_support('post-thumbnails');

add_image_size('medium-featured', 560, 350, true);
add_image_size('medium-square', 480, 480, true);

if ($Imagefilter) {
	imagefilter_add_image_size('large-landscape', 480, 180, true, true);
} else {
	add_image_size('large-landscape', 480, 180, true);
}

	/* ==========================================================================
	   Navigation
	   ========================================================================== */

/* register all menus */
add_action( 'init', 'oblivion_register_my_menus' );
function oblivion_register_my_menus() {
	register_nav_menus(
		array(
			'header' => __('Header','oblivion'),
			'footer' => __('Footer','oblivion')
		)
	);
}

function oblivion_fallback_menu() {
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

add_action( 'widgets_init', 'oblivion_register_sidebars' );
function oblivion_register_sidebars() {
	register_sidebar(
		array(
			'id'=>'footer-sidebar',
			'name'=>__('Footer-Sidebar','oblivion'),
			'description' => __('The default sidebar.','oblivion'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s" role="group"><div class="widget-inner">',
			'after_widget' => '</div></aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);
}

	/* ==========================================================================
	   Custom Header Image
	   ========================================================================== */

add_theme_support(
	'custom-header',
	array(
		'width'                  => 1440,
		'height'                 => 540,
		'header-text'            => false,
		'uploads'                => true
	)
);

function oblivion_header_image_style() {
	if (get_header_image()) {
		echo '<style type="text/css">';
		echo '.home .page-header-cover {background: url("';
		echo header_image();
		echo '") no-repeat scroll center center / cover transparent;}';
		echo '.home .page-header {background: #000 !important;}';
		echo '</style>';
	}
}
add_filter('wp_head', 'oblivion_header_image_style');

	/* ==========================================================================
	   Caption
	   ========================================================================== */

function oblivion_custom_caption($attr, $content = null) {
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

add_shortcode('wp_caption', 'oblivion_custom_caption');
add_shortcode('caption', 'oblivion_custom_caption');


	/* ==========================================================================
	   Trim Post Title
	   ========================================================================== */

function oblivion_short_title($after = '', $length) {
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


function oblivion_wp_trim_excerpt($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		global $post;
		$text = get_the_content('');
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text); 
		$allowed_tags = '<p>,<br>,<br />';
		$text = strip_tags($text, $allowed_tags); 
		$text = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $text);
		$excerpt_word_count = 54;
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
		$excerpt_end = ' <span class="post-cut">[...]</span>';
		$excerpt_cut = apply_filters('excerpt_more', ' ' . $excerpt_end);
		$excerpt_more = ' <a class="post-more" href="'. get_permalink($post->ID) . '">'. __("read more","oblivion") .'</a>';
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_cut . $excerpt_more;
		} else {
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		}
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'oblivion_wp_trim_excerpt');



function oblivion_custom_excerpt($excerpt_length = 55, $id = false, $echo = true) {
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
	$excerpt_cut = ' <span class="post-cut">[...]</span>';
	$excerpt_more = ' <a class="post-more" href="'. get_permalink($post->ID) . '">'. __("read more","oblivion") .'</a>';
	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_cut . $excerpt_more;
	} else {
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	}
	if($echo)
	echo apply_filters('the_content', $text);
	else
	return $text;
}


	/* ==========================================================================
	   Current Page
	   ========================================================================== */

function oblivion_current_paged( $var = '' ) {
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
    echo __('Page','oblivion') . ' ' . $page  . ' ' . __('of','oblivion')  . ' ' . $pages;
}


	/* ==========================================================================
	   Comments
	   ========================================================================== */

function oblivion_custom_comment($comment, $args, $depth) {
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
				<a class="comment-date" href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s','oblivion'), get_comment_date('d.m.Y')) ?></a>
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