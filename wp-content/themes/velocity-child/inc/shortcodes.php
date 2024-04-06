<?php
/**
 * Kumpulan shortcode yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
//[resize-thumbnail width="300" height="150" linked="true" class="w-100"]
add_shortcode('resize-thumbnail', 'resize_thumbnail');
function resize_thumbnail($atts) {
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'output'	=> 'image', /// image or url
        'width'    	=> '300', ///width image
        'height'    => '150', ///height image
        'crop'      => 'false',
        'upscale'   	=> 'true',
        'linked'   	=> 'true', ///return link to post	
        'class'   	=> 'w-100', ///return class name to img	
        'attachment' 	=> 'true',
        'post_id' 	=> $post->ID
    ), $atts );

    $post_id		= $atribut['post_id'];
    $output			= $atribut['output'];
    $attach         = $atribut['attachment'];
    $width          = $atribut['width'];
    $height         = $atribut['height'];
    $crop           = $atribut['crop'];
    $upscale        = $atribut['upscale'];
    $linked        	= $atribut['linked'];
    $class        	= $atribut['class']?'class="'.$atribut['class'].'"':'';
	$urlimg			= get_the_post_thumbnail_url($post_id,'full');
	
	if(empty($urlimg) && $attach == 'true'){
          $attachments = get_posts( array(
            'post_type' 		=> 'attachment',
            'posts_per_page' 	=> 1,
            'post_parent' 		=> $post_id,
        	'orderby'          => 'date',
        	'order'            => 'DESC',
          ) );
          if ( $attachments ) {
				$urlimg = wp_get_attachment_url( $attachments[0]->ID, 'full' );
          }
    }

	if($urlimg):
		$urlresize      = aq_resize( $urlimg, $width, $height, $crop, true, $upscale );
		if($output=='image'):
			if($linked=='true'):
				echo '<a href="'.get_the_permalink($post_id).'" title="'.get_the_title($post_id).'">';
			endif;
			echo '<img src="'.$urlresize.'" width="'.$width.'" height="'.$height.'" loading="lazy" '.$class.'>';
			if($linked=='true'):
				echo '</a>';
			endif;
		else:
			echo $urlresize;
		endif;

	else:
		if($linked=='true'):
			echo '<a href="'.get_the_permalink($post_id).'" title="'.get_the_title($post_id).'">';
		endif;
		echo '<svg style="background-color: #ececec;width: 100%;height: auto;" width="'.$width.'" height="'.$height.'"></svg>';
		if($linked=='true'):
			echo '</a>';
		endif;
	endif;

	return ob_get_clean();
}

//[excerpt count="150"]
add_shortcode('excerpt', 'vd_getexcerpt');
function vd_getexcerpt($atts){
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'count'	=> '150', /// count character
    ), $atts );

    $count		= $atribut['count'];
    $excerpt	= get_the_content();
    $excerpt 	= strip_tags($excerpt);
    $excerpt 	= substr($excerpt, 0, $count);
    $excerpt 	= substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt 	= ''.$excerpt.'...';

    echo $excerpt;

	return ob_get_clean();
}

// [vd-breadcrumbs]
add_shortcode('vd-breadcrumbs','vd_breadcrumbs');
function vd_breadcrumbs() {
    ob_start();
    echo justg_breadcrumb();
    return ob_get_clean();
}

//[ratio-thumbnail size="medium" ratio="16:9"]
add_shortcode('ratio-thumbnail', 'ratio_thumbnail');
function ratio_thumbnail($atts) {
    ob_start();
	global $post;

    $atribut = shortcode_atts( array(
        'size'      => 'medium', // thumbnail, medium, large, full
        'ratio'     => '16:9', // 16:9, 8:5, 4:3, 3:2, 1:1
    ), $atts );

    $size       = $atribut['size'];
    $ratio      = $atribut['ratio'];
    $ratio      = $ratio?str_replace(":","-",$ratio):'';
	$urlimg     = get_the_post_thumbnail_url($post->ID,$size);

    echo '<div class="ratio-thumbnail">';
        echo '<a class="ratio-thumbnail-link" href="'.get_the_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
            echo '<div class="ratio-thumbnail-box ratio-thumbnail-'.$ratio.'" style="background-image: url('.$urlimg.');">';
                echo '<img src="'.$urlimg.'" loading="lazy" class="ratio-thumbnail-image"/>';
            echo '</div>';
        echo '</a>';
    echo '</div>';

	return ob_get_clean();
}



// [velocity-download]
add_shortcode('velocity-download', function($atts) {
	global $post;
    $atribut = shortcode_atts( array(
        'post_id' 	=> $post->ID
    ), $atts );
    $post_id = $atribut['post_id'];	
    $url = get_post_meta($post_id, 'download_url', true );
	$html = '';
    if($url && is_user_logged_in()) {
		$html .= '<a class="btn btn-info" href="'.$url.'" target="_blank">Download</a>';
    }
    return $html;
});


// [velocity-kategori]
add_shortcode('velocity-kategori', function($atts) {
	global $post;
    $atribut = shortcode_atts( array(
        'taxonomy' => ''
    ), $atts );
    $taxonomy = $atribut['taxonomy'];	
    $object = get_queried_object();
	$html = '';
    $slug = '';
    if($taxonomy){
        $tax = $taxonomy;
    } elseif(is_post_type_archive()){
        $post_type = $object->name; 
        $tax = 'kategori-'.$post_type;
    } elseif(is_tax()) {
        $tax = $object->taxonomy; 
        $slug = $object->slug;
    } else {
        $tax = 'category';
        $slug = $object->slug;
    }
    $terms = get_terms(array(
        'taxonomy' => $tax,
        'hide_empty' => false, // Menampilkan term yang kosong juga
    ));
    if (!empty($terms)) {
        $jml = count($terms);
        $class = $jml <= 6 ? 'col-md px-0' : 'col-md-2 col-6 px-0';
        $html .= '<div class="row mx-0 bg-dark text-center align-items-end velocity-kategori">';
        foreach ($terms as $term) {
            $img_cat = velocityimgcat_taxonomy_image_url($term->term_id,'full');
            $active = $slug == $term->slug ? 'bg-primary ' : '';
            $html .= '<div class="'.$class.'">';
                $html .= '<a class="'.$active.'d-block py-3 text-white" href="' . get_term_link($term) . '">';
                    if($img_cat){
                        $img = $img_cat;
                    } else {
                        $img = get_stylesheet_directory_uri().'/img/earth.png';
                    }
                    $html .= '<img class="mb-1 white-image" src="'.$img.'" height="50" />';
                    $html .= '<div class="p-0">' . $term->name . '</div>';
                $html .= '</a>';
            $html .= '</div>';
        }
        $html .= '</div>';
    }
    return $html;
});