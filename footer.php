<?php
/**
 * The template for displaying the footer
 *
 * Contains two widgets
 *
 * @package newstime
 * @since   1.0
 */
?>

<footer class="page-footer">
    <section class="footer-widgets">
        <?php if ( is_active_sidebar( 'left-newstime-footer' ) ) { ?>
        <div class="section-half">
            <div class="footer-block">
            
                <?php dynamic_sidebar( 'left-newstime-footer' ); ?>

            </div>
        </div>
        <?php } ?>
        <?php if ( is_active_sidebar( 'right-newstime-footer' ) ) { ?>
        <div class="section-half">
            <div class="footer-block">
            
                <?php dynamic_sidebar( 'right-newstime-footer' ); ?>

            </div>
        </div>
        <?php } ?>
    </section>

        <div class="site-copyright">
            <small><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="bookmark">
                <?php 
                printf( '<small>%s &copy; %s</small>',
                    bloginfo( 'name' ),
                    esc_html( gmdate( 'Y' ) ) 
                ); ?></a>

                <span class="newstime-poweredby"> | <?php esc_html_e( 'Powered by', 'newstime' ); ?>
                    <em><?php esc_html_e( 'ClassicPress', 'newstime' );?></em> </span>
            </small>
        </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>