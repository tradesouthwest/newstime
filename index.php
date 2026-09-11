<?php
/**
 * Index template Mostly used for blog page.
 *
 * @package Startmeup
 */

get_header();
?>

<div class="breadcrumbs-nav">
        <?php 
            if ( function_exists( 'newstime_breadcrumbs_nav' ) ) {
                echo wp_kses_post( force_balance_tags( newstime_breadcrumbs_nav() ) ); } ?>
        </div>

<main id="primary" class="site-main newstime-index-body">
          <section id="sitecontent" class="index-page-body">
            <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                    itemtype="https://schema.org/Article">
                <?php 
                if ( is_home() || ( is_category() || is_archive() ) ) { ?>

                <div class="post-content">
                    <header class="excerpt-header">
                        
                        <?php the_title(
                            sprintf( '<h2 class="post-title h4"><a href="%s" rel="bookmark">', 
                                esc_attr( esc_url( get_permalink() ) ) 
                                ), '</a></h2>' ); ?>
                        
                        <?php 
                        if ( has_post_thumbnail() ) { ?>
                        
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
                        } // end if post thumbnail ?>

                    </header>
        
                            <div class="inner_content">

                                <?php 
                                the_excerpt(); ?>
                                
                                <div class="after-excrpt">
                        
                                    <p class="after-cats"><span><small><?php esc_html_e('Categorized as: ', 'startmeup'); ?></small></span> <small><em><?php the_category( ' &bull; ' ); ?></em></small>
                                    / <small><em class="excerpt_footer-date">
                                    <?php printf( esc_attr( get_the_date() ) ); ?></em></small></p>
                
                                </div>

                    <?php 
                    } else {  // display full content if not archive etc. 
                    ?>
                    
                        <?php the_content( '', true ); ?>
                    
                    <?php 
                    } // Ends is blog or archive 
                    ?>

                    </div>
                </div>

            </article>

            <?php 
            // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                } ?>
                
            <?php 
            endwhile; ?>

                <?php 
                // Blog posts pagination goes AFTER the loop ends
                if ( function_exists( 'newstime_blog_pagination' ) ) {
                    newstime_blog_pagination();
                } ?>

            <?php else : ?>
            <div class="post-content">
                
                <?php echo esc_url( home_url('/') ); ?>
            
            </div>

            <?php 
            endif; ?>

        </section>
            <aside class="blog-sidebar">
        
                <?php get_sidebar(); ?>

            </aside>
    
</main>
<?php get_footer(); ?>