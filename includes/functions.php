<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// register new post_type and taxonomy
add_action('init', 'velocity_tour_travel_admin_init');
function velocity_tour_travel_admin_init() {
    register_post_type('paket-tour', array(
        'labels' => array(
            'name' => 'Paket Tour',
            'singular_name' => 'paket-tour',
            'add_new' => 'Tambah Paket Tour',
            'add_new_item' => 'Tambah Paket Tour',
            'edit_item' => 'Edit Paket Tour',
            'view_item' => 'Lihat Paket Tour',
            'search_items' => 'Cari Paket Tour',
            'not_found' => 'Tidak ditemukan',
            'not_found_in_trash' => 'Tidak ada paket tour di kotak sampah'
        ),
        'menu_icon' => 'dashicons-screenoptions',
        'public' => true,
        'has_archive' => true,
		//'show_in_rest' => true, // Use Gutenberg
        'taxonomies' => array('kategori-paket'),
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),
    ));
	register_taxonomy(
	'kategori-paket',
	'paket-tour',
	array(
		'label' => __( 'Kategori Paket' ),
		'hierarchical' => true,
		'show_admin_column' => true,
		//'show_in_rest' => true, // Use Gutenberg
	));

	// mengatur ulang permalink wordpress
    if (!get_option('vtt_activated')) {
        global $wp_rewrite;
        $structure = get_option('permalink_structure');
        $wp_rewrite->set_permalink_structure($structure);
        $wp_rewrite->flush_rules();
        update_option('vtt_activated', true);
    }
}



// tambah menu pengaturan
add_action('admin_menu', 'velocity_tour_custom_submenu');
function velocity_tour_custom_submenu() {
    add_submenu_page('edit.php?post_type=paket-tour', 'Pengaturan', 'Pengaturan', 'manage_options', 'pengaturan-paket', 'velocity_tour_admin');
}

// isi menu pengaturan
function velocity_tour_admin(){
    echo '<div class="wrap">';
        echo '<h2>Pengaturan</h2>';
        require_once VELOCITY_TOUR_TRAVEL_DIR . 'includes/admin.php';
    echo '</div>';
}


// custom template
function velocity_tour_travel_templates( $template ) {
    // Memeriksa apakah sedang menampilkan single post type 'paket-tour'
    if ( is_singular( 'paket-tour' ) ) {
        // Menentukan lokasi dan nama file template custom untuk single post
        $new_template = VELOCITY_TOUR_TRAVEL_DIR . 'templates/single-paket-tour.php';

        // Memeriksa apakah file template custom tersebut ada
        if ( file_exists( $new_template ) ) {
            return $new_template;
        }
    }
    // Memeriksa apakah sedang menampilkan post type archive 'paket-tour' atau taksonomi 'kategori-paket'
    elseif ( is_post_type_archive( 'paket-tour' ) || is_tax( 'kategori-paket' ) ) {
        // Menentukan lokasi dan nama file template custom untuk archive
        $new_template = VELOCITY_TOUR_TRAVEL_DIR . 'templates/archive-paket-tour.php';

        // Memeriksa apakah file template custom tersebut ada
        if ( file_exists( $new_template ) ) {
            return $new_template;
        }
    }

    // Mengembalikan template bawaan jika tidak ada template custom yang cocok
    return $template;
}

// Menambahkan filter untuk menentukan template
add_filter( 'template_include', 'velocity_tour_travel_templates', 99 );


// menampilkan info paket
function velocity_info_paket($post_id = null){
	$post_id = $post_id ? $post_id : get_the_ID();
	$durasi = get_post_meta( $post_id, 'durasi', true );
	$waktu = get_post_meta( $post_id, 'waktu', true );
	$lokasi = get_post_meta( $post_id, 'lokasi', true );
    $kategori_paket = get_the_terms($post_id, 'kategori-paket');
	echo '<div class="list-group list-group-flush">';
	if($durasi){
		$icon_durasi = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-2 bi bi-clock" viewBox="0 0 16 16"> <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/> <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/> </svg>';
		echo '<div class="list-group-item px-0">'.$icon_durasi.$durasi.'</div>';
	} if($waktu){
		$icon_waktu = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-2 bi bi-calendar-week" viewBox="0 0 16 16"> <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/> </svg>';
		echo '<div class="list-group-item px-0">'.$icon_waktu.$waktu.'</div>';
	} if($lokasi){
		$icon_lokasi = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-2 bi bi-pin-map" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8z"/> <path fill-rule="evenodd" d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z"/> </svg>';
		echo '<div class="list-group-item px-0">'.$icon_lokasi.$lokasi.'</div>';
	} if($kategori_paket){
		$icon_kategori = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-2 bi bi-tag" viewBox="0 0 16 16"> <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0"/> <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z"/> </svg>';
		echo '<div class="list-group-item px-0">'.$icon_kategori.do_shortcode('[velocity-kategori-paket]').'</div>';
    }
	echo '</div>';
}


// menghilangkan tulisan 'Archive' pada judul
add_filter('get_the_archive_title', 'vtt_archive_title');
function vtt_archive_title($title) {
    if (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
}


// [velocity-harga-paket]
function velocity_harga_paket($atts){
    global $post;
    $atribut = shortcode_atts( array(
        'post_id'   => $post->ID,
    ), $atts );
	$post_id = $atribut['post_id'];
    $price = get_post_meta($post_id,'harga',true);
    $html = '';
    if($price){
        $harga = preg_replace('/[^0-9]/', '', $price);
        $html .= 'Rp '.number_format( $harga ,0 , ',','.' );
    }
    return $html;
}
add_shortcode('velocity-harga-paket', 'velocity_harga_paket');


// [velocity-kategori-paket]
function velocity_kategori_paket($atts) {
    global $post;
    $atribut = shortcode_atts( array(
        'post_id'   => $post->ID,
    ), $atts );
	$post_id = $atribut['post_id'];
    // Mengambil semua kategori dari taksonomi 'kategori-paket'
    $kategori_paket = get_the_terms($post_id, 'kategori-paket');

    // Memeriksa apakah ada kategori
    if ($kategori_paket && !is_wp_error($kategori_paket)) {
        $output = '';
        $kategori_names = array();

        // Mengambil nama-nama kategori
        foreach ($kategori_paket as $kategori) {
            $kategori_names[] = '<a href="' . get_term_link($kategori) . '">' . $kategori->name . '</a>';
        }

        // Menggabungkan nama-nama kategori dengan tanda koma
        $output .= implode(', ', $kategori_names);

        return $output;
    }

    return '';
}
add_shortcode('velocity-kategori-paket', 'velocity_kategori_paket');


// 
function velocity_tombol_pemesanan($post_id = null) {
	global $post;
    $pid = $post_id ? $post_id : $post->ID;	
    $wa = get_option('no_pemesanan');
    $text = 'Pesan Sekarang';
	$html = '';    
	// replace all except numbers
    $whatsapp_number = $wa ? preg_replace('/[^0-9]/', '', $wa) : $wa;	
    // replace 0 with 62 if first digit is 0
    if (substr($whatsapp_number, 0, 1) == 0) {
        $whatsapp_number    = substr_replace($whatsapp_number, '62', 0, 1);
    }	
	// if whatsapp_number exist
    if($wa) {
		$html .= '<a class="btn btn-primary btn-sm py-2 px-3 px-sm-4 text-white" href="https://wa.me/'.$whatsapp_number.'?text=Saya ingin memesan '.get_the_title($pid).'" target="_blank">'.$text.'</a>';
    }
    return $html;
}