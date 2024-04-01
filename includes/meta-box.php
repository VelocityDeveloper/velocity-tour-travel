<?php
/**
 * Register meta boxes for post paket tour.
 * meta box using cmb2
 * @package Velocity Tour Travel
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'cmb2_admin_init', 'velocity_tour_travel_metaboxes' );
function velocity_tour_travel_metaboxes() {
    $text_domain = 'velocity-tour-travel';
	$cmb = new_cmb2_box( array(
		'id'            => 'velocity_metabox',
		'title'         => __( 'Detail', $text_domain ),
		'object_types'  => array('paket-tour'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$cmb->add_field( array(
		'name'       => __( 'Harga', $text_domain ),
		'desc'       => __( 'Isi dengan angka saja tanpa karakter khusus, contoh: 2500000', $text_domain ),
		'id'         => 'harga',
		'type' => 'text',
		'before_field' => 'Rp',
		'attributes' => array(
			'type' => 'number',
			'required' => 'required',
		),
	) );
    $cmb->add_field( array(
        'name' => __( 'Galeri Foto', $text_domain ),
        'desc' => '',
        'id'   => 'galeri',
        'type' => 'file_list',
        'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
        // Optional, override default text strings
        'text' => array(
            'add_upload_files_text' => 'Add or Upload Images', // default: "Add or Upload Files"
            'remove_image_text' => 'Remove Image', // default: "Remove Image"
            'file_text' => 'File:', // default: "File:"
            'file_download_text' => 'Download', // default: "Download"
            'remove_text' => 'Remove', // default: "Remove"
        ),
    ) );
    $cmb->add_field( array(
        'name'    => __( 'Itinerary', $text_domain ),
        'id'      => 'itinerary',
        'type'    => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ) );
    $cmb->add_field( array(
        'name'    => __( 'Fasilitas', $text_domain ),
        'id'      => 'fasilitas',
        'type'    => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ) );
}