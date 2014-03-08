<?php
/*
 * Plugin Name: Imagefilter
 * Author URI: http://zutrinken.com
 * Description: Automatically create thumbnails for a given image size with imagefilters
 * Author: Peter Amende
 * Version: 1.0
 
  Copyright © 2014 Peter Amende
    
    Imagefilter is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Imagefilter is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Grayscale.  If not, see <http://www.gnu.org/licenses/>
*/

register_activation_hook(__FILE__, 'imagefilter_check'); 
function imagefilter_check() {
    if ( !extension_loaded('gd') ) {
        die(__('PHP GD is required.','imagefilter'));
    }
    if ( !function_exists('imagecopy') ){
        die(__('PHP IMAGECOPY is required.','imagefilter'));
    }
    if ( !function_exists('imagefilter') ){
        die(__('PHP GD is required.','imagefilter'));
    }
}

add_action('init', 'imagefilter_init');
function imagefilter_init() {
    load_plugin_textdomain(
    	'imagefilter',
    	false,
    	basename(dirname(__FILE__))
    );
}

function imagefilter_add_image_size( $name, $width = 0, $height = 0, $crop = false, $imagefilter = false ) {
	global $_wp_additional_image_sizes;
	$_wp_additional_image_sizes[$name] = array(
		'width' => absint( $width ),
		'height' => absint( $height ),
		'crop' => (bool) $crop,
		'imagefilter' => (bool) $imagefilter
	);
}

function imagefilter_make_imagefilter_image($resized_file){
    $image = wp_load_image( $resized_file );
    if ( !is_resource( $image ) )
	    return new WP_Error( 'error_loading_image', $image, $resized_file );
	    
    $size = @getimagesize( $resized_file );
    if ( !$size )
	    return new WP_Error('invalid_image', __('Could not read image size'), $resized_file);
    list($orig_w, $orig_h, $orig_type) = $size;
    
    $dest = wp_load_image( $resized_file );

	imagecopy($dest, $image, 0, 0, 0, 0, $orig_w, $orig_h, 0);

    for( $i=0; $i<4; $i++) {
		imagefilter($dest, IMG_FILTER_GAUSSIAN_BLUR);
		imagefilter($dest, IMG_FILTER_SMOOTH, 0);
		imagefilter($dest, IMG_FILTER_GAUSSIAN_BLUR);
	}

    $info = pathinfo($resized_file);
    $dir = $info['dirname'];
    $ext = $info['extension'];
    $name = wp_basename($resized_file, ".$ext");

    $destfilename = "{$dir}/{$name}-gray.{$ext}";

    if ( IMAGETYPE_GIF == $orig_type ) {
	    if ( !imagegif( $dest, $destfilename ) )
		    return new WP_Error('resize_path_invalid', __( 'Resize path invalid' ));
    } elseif ( IMAGETYPE_PNG == $orig_type ) {
	    if ( !imagepng( $dest, $destfilename ) )
		    return new WP_Error('resize_path_invalid', __( 'Resize path invalid' ));
    } else {
	    $destfilename = "{$dir}/{$name}-gray.jpg";
	    if ( !imagejpeg( $dest, $destfilename, apply_filters( 'jpeg_quality', 90, 'image_resize' ) ) )
		    return new WP_Error('resize_path_invalid', __( 'Resize path invalid' ));
    }

    imagedestroy( $image );
    imagedestroy( $dest );

    $stat = stat( dirname( $destfilename ));
    $perms = $stat['mode'] & 0000666;
    @ chmod( $destfilename, $perms );

    return wp_basename($destfilename);
}

add_filter('wp_generate_attachment_metadata', 'imagefilter_check_imagefilter_image', 10, 2);
function imagefilter_check_imagefilter_image($metadata, $attachment_id){
    global $_wp_additional_image_sizes;
    $attachment = get_post( $attachment_id );
    if ( preg_match('!image!', get_post_mime_type( $attachment )) ) {
        foreach($metadata['sizes'] as $size => $size_data){
            $file = pathinfo(get_attached_file($attachment_id));
            $metadata['sizes'][$size.'-filter'] = $metadata['sizes'][$size];
            $metadata['sizes'][$size.'-filter']['file'] = _wp_relative_upload_path(imagefilter_make_imagefilter_image($file['dirname'].'/'.$size_data['file']));
        }
    }
    return $metadata;
}

    
?>
