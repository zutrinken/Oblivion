<?php
/*
 * Plugin Name: Imagefilter
 * Author URI: http://zutrinken.com
 * Description: Automatically create thumbnails for a given image size with imagefilters
 * Author: Peter Amende
 * Version: 1.1
 
 Imagefilter is based on Grayscale (https://wordpress.org/plugins/grayscale) by Fabien Quatravaux (http://www.1nterval.com)
 
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
    along with Imagefilter.  If not, see <http://www.gnu.org/licenses/>
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
    load_plugin_textdomain('imagefilter', false, basename(dirname(__FILE__)));
}

// provide a new function to declare imagefilterd images
function imagefilter_add_image_size( $name, $width = 0, $height = 0, $crop = false, $imagefilter = false ) {
	global $_wp_additional_image_sizes;
	$_wp_additional_image_sizes[$name] = array( 'width' => absint( $width ), 'height' => absint( $height ), 'crop' => (bool) $crop, 'imagefilter' => (bool) $imagefilter );
}

require_once(ABSPATH . 'wp-includes/class-wp-image-editor.php');
require_once(ABSPATH . 'wp-includes/class-wp-image-editor-gd.php');

class imagefilter_Image_Editor extends WP_Image_Editor_GD {
    public function make_imagefilter(){
        // create a copy
        $dest = $this->image;
        unset($this->image);
        $this->load();
        if ( is_resource( $dest ) ) {
            // Apply imagefilter filter
            imagecopy($dest, $this->image, 0, 0, 0, 0, $this->size['width'], $this->size['height']);
            //imagegammacorrect($dest, 1.0, apply_filters('imagefilter_gamma_correction', 0.7));
		    for( $i=0; $i<4; $i++) {
				imagefilter($dest, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($dest, IMG_FILTER_SMOOTH, 0);
				imagefilter($dest, IMG_FILTER_GAUSSIAN_BLUR);
			}
            imagedestroy( $this->image );
            $this->image = $dest;
            return true;
        }
    }
}

// hook to call the image generation function if needed
add_filter('wp_generate_attachment_metadata', 'imagefilter_check_imagefilter_image', 10, 2);
function imagefilter_check_imagefilter_image($metadata, $attachment_id){
    global $_wp_additional_image_sizes;
    $attachment = get_post( $attachment_id );
    if ( preg_match('!image!', get_post_mime_type( $attachment )) ) {
        
        foreach($_wp_additional_image_sizes as $size => $size_data){
            if(isset($size_data['imagefilter']) && $size_data['imagefilter']) {
                if(is_array($metadata['sizes']) && isset($metadata['sizes'][$size])){
                    $file = pathinfo(get_attached_file($attachment_id));
                    $filename = $file['dirname'].'/'.$metadata['sizes'][$size]['file'];
                    $metadata['sizes'][$size.'-filter'] = $metadata['sizes'][$size];
                } else {
                    // this size has no image attached, probably because the original is too small
                    // create the imagefilter image from the original file
                    $file = wp_upload_dir();
                    $filename = $file['basedir'].'/'.$metadata['file'];
                    $metadata['sizes'][$size.'-filter'] = array(
                        'width' => $metadata['width'], 
                        'height' => $metadata['height'],
                    );
                }
                
                $image = new imagefilter_Image_Editor($filename);
                $image->load();
                $image->make_imagefilter();
                $result = $image->save($image->generate_filename('filter'));
                $metadata['sizes'][$size.'-filter']['file'] = $result['file'];
            }
        }
    }
    return $metadata;
}
?>