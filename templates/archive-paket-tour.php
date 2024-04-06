<?php

/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>

<div class="wrapper" id="archive-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php do_action('justg_before_content'); ?>

			<main class="site-main" id="main">

				<?php

				if (have_posts()) {
				?>
					<header class="page-header block-primary">
						<?php
						do_action('justg_before_title');

						the_archive_title('<h1 class="page-title">', '</h1>');
						the_archive_description('<div class="taxonomy-description">', '</div>');

						do_action('justg_after_title');
						?>
					</header><!-- .page-header -->
				<?php
					// Start the loop.
                    echo '<div class="row">';
					while (have_posts()) {
						the_post(); 
                        $post_id = get_the_ID();
                        ?>
                        <article <?php post_class('col-md-6 block-primary mb-4'); ?> id="post-<?php the_ID(); ?>">

                            <div class="h-100">
                                <div class="mb-2">
                                    <a class="d-block position-relative" href="<?php echo get_the_permalink(); ?>">
                                        <?php $harga = get_post_meta( $post_id, 'harga', true );
                                        if($harga){
                                            echo '<div class="velocity-harga-paket">'.do_shortcode('[velocity-harga-paket]').'</div>';
                                        } ?>
                                        <div class="ratio ratio-4x3 bg-light overflow-hidden">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                echo get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'w-100', 'loading' => 'lazy'));
                                            } else {
                                                $attachments = get_posts( array(
                                                    'post_type'         => 'attachment',
                                                    'posts_per_page'    => 1,
                                                    'post_parent'       => get_the_ID(),
                                                ));
                                                if($attachments && isset($attachments[0]->ID)){
                                                    echo wp_get_attachment_image( $attachments[0]->ID, 'medium', "", array('class' => 'w-100', 'loading' => 'lazy') );
                                                } else {
                                                        echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 60 60" style="padding: 2rem;background-color: #ececec;width: 100%;height: 100%;enable-background:new 0 0 60 60;" xml:space="preserve" width="600" height="300"><g><g><path d="M55.201,15.5h-8.524l-4-10H17.323l-4,10H12v-5H6v5H4.799C2.152,15.5,0,17.652,0,20.299v29.368   C0,52.332,2.168,54.5,4.833,54.5h50.334c2.665,0,4.833-2.168,4.833-4.833V20.299C60,17.652,57.848,15.5,55.201,15.5z M8,12.5h2v3H8   V12.5z M58,49.667c0,1.563-1.271,2.833-2.833,2.833H4.833C3.271,52.5,2,51.229,2,49.667V20.299C2,18.756,3.256,17.5,4.799,17.5H6h6   h2.677l4-10h22.646l4,10h9.878c1.543,0,2.799,1.256,2.799,2.799V49.667z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/><path d="M30,14.5c-9.925,0-18,8.075-18,18s8.075,18,18,18s18-8.075,18-18S39.925,14.5,30,14.5z M30,48.5c-8.822,0-16-7.178-16-16   s7.178-16,16-16s16,7.178,16,16S38.822,48.5,30,48.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/><path d="M30,20.5c-6.617,0-12,5.383-12,12s5.383,12,12,12s12-5.383,12-12S36.617,20.5,30,20.5z M30,42.5c-5.514,0-10-4.486-10-10   s4.486-10,10-10s10,4.486,10,10S35.514,42.5,30,42.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/><path d="M52,19.5c-2.206,0-4,1.794-4,4s1.794,4,4,4s4-1.794,4-4S54.206,19.5,52,19.5z M52,25.5c-1.103,0-2-0.897-2-2s0.897-2,2-2   s2,0.897,2,2S53.103,25.5,52,25.5z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#5F7D95"/></g></g> </svg>';
                                                }
                                                
                                            } ?>
                                        </div>
                                    </a>
                                </div>
                                <div class="entry-content">
                                    <header class="entry-header">
                                        <?php
                                        the_title(
                                            sprintf('<h2 class="content-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                                            '</a></h2>'
                                        );
                                        ?>
                                    </header><!-- .entry-header -->
                                    <?php echo velocity_info_paket(); ?>
                                </div>
                            </div>

                        </article><!-- #post-## -->
                    <?php
					}
                    echo '</div>';
				} else {
					get_template_part('loop-templates/content', 'none');
				}
				?>
				<!-- Display the pagination component. -->
				<?php 
                if( function_exists('justg_pagination')) {
                    justg_pagination();
                } else { ?>
                    <nav class="pagination" role="navigation">
                        <div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'justg' ) ); ?></div>
                        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'justg' ) ); ?></div>
                    </nav>                
                <?php } ?>
			</main><!-- #main -->

			<!-- Do the right sidebar check. -->
			<?php do_action('justg_after_content'); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();
