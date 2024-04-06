<?php
/**
 * Fuction yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'velocitychild_theme_setup', 9 );

function velocitychild_theme_setup() {
	
	
	if (class_exists('Kirki')):
		
		/**
		* Customizer control in child themes
		* Sample Panel
		* 
		*/ 
		Kirki::add_panel('panel_home', [
			'priority'    => 10,
			'title'       => esc_html__('Home', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		/**
		* Sample section
		* 
		*/ 
		Kirki::add_section('home_slider', [
			'panel'    => 'panel_home',
			'title'    => __('Slider', 'justg'),
			'priority' => 10,
		]);

		/**
		* Sample Field
		* 
		*/ 
		// Kirki::add_field( 'justg_config', [
		// 	'type'        => 'repeater',
		// 	'label'       => esc_html__( 'Slider Home', 'justg' ),
		// 	'section'     => 'home_slider',
		// 	'priority'    => 10,
		// 	'row_label' => [
		// 		'type'  => 'text',
		// 		'value' => esc_html__( 'Slide', 'justg' ),
		// 	],
		// 	'button_label' => esc_html__('Tambah Slide', 'justg' ),
		// 	'settings'     => 'home_slider_setting',
		// 	'fields' => [
		// 		'image' => [
		// 			'type'        => 'image',
		// 			'label'       => esc_html__( 'Gambar', 'justg' ),
		// 			'description' => esc_html__( 'gunakan gambar dengan ukuran sama', 'justg' ),
		// 			'default'     => '',
		// 		],
		// 		'link_url'  => [
		// 			'type'        => 'text',
		// 			'label'       => esc_html__( 'Url slide', 'justg' ),
		// 			'description' => esc_html__( 'link saat gambar di klik', 'justg' ),
		// 			'default'     => '',
		// 		],
		// 	]
		// ] );
		
	endif;
}


add_action('init', 'velocity_admin_init');
function velocity_admin_init() {
	$array = array(
		array(
			'slug' => 'produk',
			'name' => 'Produk',
		),
		array(
			'slug' => 'layanan',
			'name' => 'Layanan',
		),
		array(
			'slug' => 'industri',
			'name' => 'Industri',
		),
	);
	foreach ($array as $item) {
		$slug = $item['slug'];
		$name = $item['name'];
		register_post_type($slug, array(
			'labels' => array(
				'name' => $name,
				'singular_name' => $slug,
				'add_new' => 'Tambah '.$name.' Baru',
				'add_new_item' => 'Tambah '.$name.' Baru',
				'edit_item' => 'Edit '.$name,
				'view_item' => 'Lihat '.$name,
				'search_items' => 'Cari '.$name,
				'not_found' => 'Tidak ditemukan',
				'not_found_in_trash' => 'Tidak ada '.$name.' di kotak sampah'
			),
			'menu_icon' => 'dashicons-screenoptions',
			'public' => true,
			'has_archive' => true,
			//'show_in_rest' => true, // Use Gutenberg
			'taxonomies' => array('kategori-'.$slug),
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
			),
		));
		register_taxonomy(
			'kategori-'.$slug,
			$slug,
			array(
				'label' => __( 'Kategori '.$name ),
				'hierarchical' => true,
				'show_admin_column' => true,
				//'show_in_rest' => true, // Use Gutenberg
			)
		);
	}
}



add_action("admin_init", "admin_init");
function admin_init(){
	add_meta_box("download_url", "Download URL", "download_function",array("produk","page","layanan"), "side", "low");
}

function download_function(){
	global $post;
	$custom = get_post_custom($post->ID);
	$download_url = $custom["download_url"][0];
	echo '<table class="form-table" role="presentation">';
	echo '<tbody><tr>';
	echo '<th><label for="vel_media">';
	_e( 'Download URL', 'detaildownload' );
	echo '</label></th>';
	echo '<td><input type="text" name="download_url" value="'.$download_url.'" /></td>';
	echo '</tr>';
	echo '</tbody></table>';
}


add_action('save_post', 'save_details');
function save_details(){
	global $post;
	update_post_meta($post->ID, "download_url", $_POST["download_url"]);
}




/**
 * Add new profile tabs ultimate member
 */
function um_velocity_add_tab( $tabs ) {

	/* Download Tab */

	$tabs['vd_download'] = array(
		'name'            => 'Download',
		'icon'            => 'um-faicon-book',
		'custom'          => true
	);

	if ( !isset( UM()->options()->options['profile_tab_' . 'vd_download'] ) ) {
		UM()->options()->update( 'profile_tab_' . 'vd_download', true );
	}


	return $tabs;
}
add_filter( 'um_profile_tabs', 'um_velocity_add_tab', 1000 );


/**
 * Render the tab 'MY COURSES'
 * @param array $args
 */
function um_profile_content_vd_download( $args ) {
	require_once( get_stylesheet_directory().'/inc/ultimate-member-download-tab.php' );
}
add_action( 'um_profile_content_vd_download', 'um_profile_content_vd_download' );
