<?php
///[velocity-paket-form-cari]
add_shortcode('velocity-paket-form-cari', 'velocity_paket_formcari');
function velocity_paket_formcari($atts){    
    ob_start();
    
    global $post;
    $atribut = shortcode_atts(array(
        'layout' => 'column',
    ), $atts);
    $layout = $atribut['layout'];

    echo '<form action="'.get_site_url().'/paket-tour/" method="GET" class="velocity-paket-form-cari">';
        
        echo $layout=='inline'?'<div class="row g-0 text-dark form-inline">':'<div class="row g-0 text-dark form-column">';

            echo $layout=='inline'?'<div class="col-md-3 mb-md-0 mb-3">':'<div class="col-12 mb-3">';
                $taxonomy   = 'destinasi-paket';
                $gettaxonomy = get_categories(array('taxonomy' => $taxonomy, 'parent'  => 0, 'hide_empty' => 0));
                echo '<div class="position-relative border bg-white ps-4 rounded overflow-hidden">';
                    echo '<label for="sdestinasi" class="position-absolute p-2 start-0 top-0 bottom-0"><i class="fa fa-map-marker"></i></label>';
                    echo '<select id="sdestinasi" name="sdestinasi" class="form-select bg-white border-0">';
                        echo '<option value="">Destinasi Wisata</option>';
                        foreach ($gettaxonomy as $k => $tax) {
                            echo '<option value="'.$tax->term_id.'">'.$tax->name.'</option>';
                        }
                    echo '</select>';
                echo '</div>';
            echo '</div>';

            echo $layout=='inline'?'<div class="col-md-3 mb-md-0 mb-3">':'<div class="col-12 mb-3">';
                $taxonomy   = 'durasi-paket';  
                $gettaxonomy = get_categories(array('taxonomy' => $taxonomy, 'parent'  => 0, 'hide_empty' => 0));
                echo '<div class="select-durasi-paket position-relative border bg-white ps-4 rounded overflow-hidden">';
                    echo '<label for="sdurasi" class="position-absolute p-2 start-0 top-0 bottom-0"><i class="fa fa-clock"></i></label>';
                    echo '<select id="sdurasi" name="sdurasi" class="form-select bg-white border-0">';
                        echo '<option value="">Durasi Wisata</option>';
                        foreach ($gettaxonomy as $k => $tax) {
                            echo '<option value="'.$tax->term_id.'">'.$tax->name.'</option>';
                        }
                    echo '</select>';
                echo '</div>';
            echo '</div>';

            echo $layout=='inline'?'<div class="col-md-3 mb-md-0 mb-3">':'<div class="col-12 mb-3">';
                $taxonomy   = 'kategori-paket';  
                $gettaxonomy = get_categories(array('taxonomy' => $taxonomy, 'parent'  => 0, 'hide_empty' => 0));
                echo '<div class="position-relative border bg-white ps-4 rounded overflow-hidden">';
                    echo '<label for="skategoripaket" class="position-absolute p-2 start-0 top-0 bottom-0"><i class="fa fa-users"></i></label>';
                    echo '<select id="skategoripaket" name="skategoripaket" class="form-select bg-white border-0">';
                        echo '<option value="">Kategori Wisata</option>';
                        foreach ($gettaxonomy as $k => $tax) {
                            echo '<option value="'.$tax->term_id.'">'.$tax->name.'</option>';
                        }
                    echo '</select>';
                echo '</div>';
            echo '</div>';

            echo $layout=='inline'?'<div class="col-md-3">':'<div class="col-12">';
                echo '<button type="submit" class="btn btn-warning rounded-pill w-100">';
                echo 'Cari Paket Wisata';
                echo '</button>';
            echo '</div>';

        echo '</div>';
    echo '</form>';

    return ob_get_clean();
}