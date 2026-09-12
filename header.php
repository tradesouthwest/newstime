<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "main" tag.
 *
 * @package Newstime
 * @since   1.0.0
 */

?><!DOCTYPE html>
<html>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" aria-label="first content" 
        href="#sitecontent">
        <?php esc_html_e( 'Skip to content', 'startmeup' ); ?>
    </a>

        <header class="page-header">
            <!-- nav or top section can go here -->
            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'newstime' ); ?>">
			<!-- Mobile Toggle Switch -->
			<input type="checkbox" id="menu-toggle" class="menu-toggle-checkbox" aria-label="Toggle Navigation">
			<label for="menu-toggle" class="menu-toggle-label">
				<span class="hamburger"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'newstime' ); ?></span>
			</label>

			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary-menu',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'menu_class'     => 'nav-menu',
				'depth'          => 0, // Supports up to 3 levels
			) );
			?>
		</nav>


            <div class="site-logo inner-header">
            <?php 
            if( has_custom_logo() ) : ?>

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                   rel="bookmark"><?php echo wp_kses_post( force_balance_tags( newstime_theme_custom_logo() ) ); ?></a>
           
            <?php 
                endif; ?>

                <div class="page-header-inner">
                    <div class="hgroup-header">
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <div class="site-description">
                            
                            <?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?>
                    
                        </div>
                    </div>
                </div>
            </div>
        
        </header>