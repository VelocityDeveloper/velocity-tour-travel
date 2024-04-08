<?php

/**
 * The template for displaying all single posts
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>

<div class="wrapper" id="single-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<main class="site-main" id="main">

				<?php

				while (have_posts()) {
					the_post(); ?>
                    <article <?php post_class('block-primary'); ?> id="post-<?php the_ID(); ?>">

                    <header class="entry-header">

                        <?php

                        do_action('justg_before_title');

                        the_title('<h1 class="entry-title">', '</h1>');
                        ?>

                        <div class="entry-meta mb-2">

                            Harga Mulai <span class="fs-6 fw-bold"><?php echo do_shortcode('[velocity-harga-paket]'); ?></span>

                        </div><!-- .entry-meta -->

                    </header><!-- .entry-header -->

                    <?php
                    $galeri = get_post_meta(get_the_ID(),'galeri',true);
                    if (has_post_thumbnail()) {
                        $img_gallery[] = get_the_post_thumbnail_url(get_the_ID(),'full');
                    } if($galeri){
                        foreach($galeri as $img){
                            $img_gallery[] = $img;
                        }
                    } if($img_gallery){
                        echo '<div id="paket-'.get_the_ID().'" class="carousel slide" data-bs-ride="carousel">';
                            echo '<div class="carousel-inner">';
                                $i = 0;
                                foreach($img_gallery as $img){
                                    $no = ++$i;
                                    $class = $no == '1' ? ' active' : '';
                                    echo '<div class="carousel-item'.$class .'">';
                                        echo '<img src="'.$img.'" />';
                                    echo '</div>';
                                }
                            echo '</div>';
                            echo '<button class="carousel-control-prev" type="button" data-bs-target="#paket-'.get_the_ID().'" data-bs-slide="prev">';
                                echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                                echo '<span class="visually-hidden">Previous</span>';
                            echo '</button>';
                            echo '<button class="carousel-control-next" type="button" data-bs-target="#paket-'.get_the_ID().'" data-bs-slide="next">';
                                echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                                echo '<span class="visually-hidden">Next</span>';
                            echo '</button>';
                        echo '</div>';
                    }
                    echo velocity_info_paket();
                    ?>

                    <div class="entry-content mt-2">

                        <?php the_content(); ?>

                        <?php
                        $fasilitas = get_post_meta(get_the_ID(),'fasilitas',true);
                        $itinerary = get_post_meta(get_the_ID(),'itinerary',true);
                        if($fasilitas){
                            echo '<hr>';
                            echo '<div class="mb-2">';
                                echo '<h5 class="fs-6 mb-3"><strong>Fasilitas</strong></h5>';
                                echo $fasilitas;
                            echo '</div>';
                        } if($itinerary){
                            echo '<hr>';
                            echo '<div class="mb-2">';
                                echo '<h5 class="fs-6 mb-3"><strong>Itinerary</strong></h5>';
                                echo $itinerary;
                            echo '</div>';
                        }

                        ?>

                        <?php
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . __('Pages:', 'justg'),
                                'after'  => '</div>',
                            )
                        );
                        ?>

                    </div><!-- .entry-content -->

                    <footer class="entry-footer">

                        <?php justg_entry_footer(); ?>

                    </footer><!-- .entry-footer -->

                    </article><!-- #post-## -->
                    <?php
					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) {

						do_action('justg_before_comments');
						comments_template();
						do_action('justg_after_comments');
					}
				}
				?>

			</main><!-- #main -->

			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
