<?php
///[velocity-paket-slideshow]
add_shortcode('velocity-paket-slideshow', 'velocity_paket_slideshow');
function velocity_paket_slideshow($atts){    
    ob_start();
    
    global $post;
    $atribut = shortcode_atts(array(
        'post_id' => $post->ID,
    ), $atts);
    $nodeid     = uniqid();
    $post_id    = $atribut['post_id'];
    $nodeid     = 'vd'.uniqid();
    $gallery    = get_post_meta($post_id,'galeri',true);

    $images     = [];
    if (has_post_thumbnail($post_id)) {
        $images[] = get_the_post_thumbnail_url($post_id, 'full');
    }
    if($gallery){
        $images = array_merge($images,$gallery);
    }

    if($images && count($images) > 1):
        ?>
        <div class="velocity-paket-slideshow <?php echo $nodeid; ?>">

            <div class="slideshow-big">
                <?php foreach( $images as $k => $img): ?>
                    <div class="item-slideshow">
                        <div class="ratio ratio-4x3 bg-light">
                            <img src="<?php echo $img; ?>" alt=""> 
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="slideshow-nav">
                <?php foreach( $images as $k => $img): ?>
                    <button type="button" class="item-slideshow btn btn-link py-0 px-1">
                        <div class="ratio ratio-16x9 bg-light">
                            <img src="<?php echo $img; ?>" alt=""> 
                        </div>
                    </button>
                <?php endforeach; ?>
            </div>

            <script>
                    jQuery(function($) {
                        $(document).ready(function(){                        
                            $('.<?php echo $nodeid; ?> .slideshow-big').slick({
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                fade: true,
                                asNavFor: '.<?php echo $nodeid; ?> .slideshow-nav'
                            });
                            $('.<?php echo $nodeid; ?> .slideshow-nav').slick({
                                slidesToShow: 4,
                                slidesToScroll: 1,
                                asNavFor: '.<?php echo $nodeid; ?> .slideshow-big',
                                dots: true,
                                centerMode: true,
                                focusOnSelect: true,
                                vertical: false,
                                responsive: [
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 3,
                                        }
                                    },
                                    {
                                        breakpoint: 480,
                                        settings: {
                                            slidesToShow: 2,
                                        }
                                    }
                                ]
                            });
                        });
                    });
            </script>
        </div>
        <?php
    elseif($images && count($images) == 1):
        ?>
         <div class="item-slideshow">
            <div class="ratio ratio-4x3 bg-light">
                <img src="<?php echo $images[0]; ?>" alt=""> 
            </div>
        </div>
        <?php
    endif;
    return ob_get_clean();
}