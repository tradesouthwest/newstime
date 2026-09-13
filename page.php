<?php
/**
 * Page template Mostly used for pages, post type.
 *
 * @package Newstime
 * @since   1.0.0
 */

get_header();

?>

<main id="primary" class="site-main">

        <section id="sitecontent" class="page-content">

            <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope 
                    itemtype="https://schema.org/Article">

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
                                    the_post_thumbnail( 'startmeup-featured', array( 
                                        'itemprop' => 'image', 
                                        'class'  => 'startmeup-featured',
                                        'alt'  => get_the_title()
                                        ) 
                                    ); ?>
                        
                                </div>
                            </figure>
                        <?php                       
                        } 
                        else { ?>

                        </div class="no-thumbnail"></div>
                        
                        <?php 
                        } ?>

                    </header>
                        
                        <div class="inner_content">

                            <?php the_content(); ?>

                        </div>

                </div>
            

            <?php 
            endwhile; ?>
                <?php else : ?>
                
                <div class="post-content">
                    
                    <?php echo esc_url( home_url('/') ); ?>
                
                </div>

                <?php 
                endif; ?>

            </article>
        </section>
            <aside class="blog-sidebar">
        
                <?php get_sidebar(); ?>

            </aside>
</main>
<?php get_footer(); ?>