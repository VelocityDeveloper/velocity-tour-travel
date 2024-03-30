<?php

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
