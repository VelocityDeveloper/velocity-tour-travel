<?php

function velocitytourtravel_paket_custom_query( $query ) {
    
    if ( is_archive() && is_post_type_archive( 'paket-tour' )  && $query->is_main_query() ) {
        
         //taxonomy query
         $taxquery = array();
         
         //taxonomy kategory-paket 
         $skategoripaket = isset($_GET['skategoripaket'])? $_GET['skategoripaket'] :'';
         if($skategoripaket && !empty($skategoripaket[0])) {
             $taxquery[] = array(
                 'taxonomy' => 'kategori-paket',
                 'field'    => 'term_id',
                 'terms'    => $skategoripaket,
             );
         }

         //taxonomy destinasi-paket 
         $sdestinasi = isset($_GET['sdestinasi'])? $_GET['sdestinasi'] :'';
         if($sdestinasi && !empty($sdestinasi[0])) {
             $taxquery[] = array(
                 'taxonomy' => 'destinasi-paket',
                 'field'    => 'term_id',
                 'terms'    => $sdestinasi,
             );
         }
 
         //taxonomy durasi-paket 
         $sdurasi = isset($_GET['sdurasi'])? $_GET['sdurasi'] :'';
         if($sdurasi && !empty($sdurasi[0])) {
             $taxquery[] = array(
                 'taxonomy' => 'durasi-paket',
                 'field'    => 'term_id',
                 'terms'    => $sdurasi,
             );
         }
 
        //if count taxquery more than 1, then set taxquery
        if(count($taxquery)>1){
            $taxquery['relation'] = 'AND';
        }

        if($taxquery) {
            $query->set( 'tax_query', $taxquery);
        }
    }

}
add_filter( 'pre_get_posts', 'velocitytourtravel_paket_custom_query' );