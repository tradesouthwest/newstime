<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package Newstime
 * @since   1.0.0
 */

get_header(); ?>
  
<div class="breadcrumbs-nav">
        <?php 
            if ( function_exists( 'newstime_breadcrumbs_nav' ) ) {
                echo wp_kses_post( force_balance_tags( newstime_breadcrumbs_nav() ) ); } ?>
        </div>
        
<main id="primary" class="site-main newstime-single-page">

        <section id="sitecontent" class="index-page-body">
    
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="article-heading">
                    <h2><?php the_title(); ?></h2>
                
                    <?php if ( has_post_thumbnail() ) { ?>
                        
                    <figure class="linked-attachment-container-sm">
                        <div class="inner-featured-image">
                            
                            <?php 
                            the_post_thumbnail( 'newstime-featured', array( 
                                'itemprop' => 'image', 
                                'class'  => 'newstime-featured',
                                'alt'  => get_the_title()
                                ) 
                            ); ?>

                        </div>
                    </figure>

                    <?php 
                    } else { 
                        ?>
                        </div class="no-thumbnail"></div>
                        <?php 
                    } ?>

                </header>
                
                <div class="inner_content">

                    <?php 
                        the_content( ); ?>
                    
                    <p><?php wp_link_pages(	array(
                    'before' => '<div class="page-link"><span>' . __( 'Pages:', 'newstime' ) . '</span>',
                    'after'  => '</div>', 
                    ) ); ?></p>

                </div>
                    <div class="after-content">
                        <p class="after-cats"><span><small><?php esc_html_e('By: ', 'newstime'); ?></span> <em><?php the_author(); ?></em></small>
                        | <span><small><?php esc_html_e('Categorized as: ', 'newstime'); ?></span> <em><?php the_category( ' &bull; ' ); ?></em></small>
                        | <span><small><?php esc_html_e('Keys: ', 'newstime'); ?></span> <em><?php the_tags( ' ' ); ?></em></small>
                        | <span><small><?php esc_html_e('Added on: ', 'newstime'); ?></span> <em><?php the_date(); ?></em></small></p>
                    </div>
                
                <?php 
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                } ?>

            <?php 
            endwhile; ?>
        </section>
        
            <section class="section-sidebar">

                <?php get_sidebar(); ?>

            </section>

</main>

<?php get_footer(); ?>