<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package hello theme
 * @since   1.0
 */
?>

<footer class="page-footer">
    <hr><!-- for test only -->
     <div class="site-copyright">
        <small><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="bookmark">
        <?php 
        printf( '<small>%s &copy; %s</small>',
            bloginfo( 'name' ),
            esc_html( gmdate( 'Y' ) ) 
        ); ?></a><span class="myhero-poweredby"> | Powered by <em>ClassicPress</em> </span></small>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>