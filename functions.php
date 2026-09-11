<?php
/** 
 * Functions for theme newstime
 * Sets up theme defaults and registers support for various WordPress features.
 * 
 * @package    ClassicPress
 * @subpackage Hello Theme
 * @since      1.0.1
 *
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( !defined ( 'NEWSTIME_VER' ) ) { define ( 'NEWSTIME_VER', '1.0.0' ); }

/** 
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own newstime_child_setup() function to override in a child theme.
 * 
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * @since Hello Theme 1.0
 */
if ( ! function_exists( 'newstime_theme_setup' ) ) :

function newstime_theme_setup() {
    /**
     * Not used in ClassicPress > 2.0 
     * to output valid HTML5.
     */ 
if ( version_compare( function_exists( 'classicpress_version' ) 
    ? classicpress_version() : '0', '2', '<=' ) ) {
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )); 
    }
           
    /**
	* Make theme available for translation.
	* Translations can be added to the /languages/ directory.
	*/
    load_theme_textdomain( 'newstime', get_template_directory_uri() . '/languages' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Main Menu', 'newstime' ),
        )
    );

    /*
		 * Let ClassicPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		
		add_theme_support( 'post-thumbnails', array( 'post', 'page') );
		// register new phone-landscape featured image size. @width, @height, and @crop
		add_image_size( 'newstime-featured', 520, 300, false);

        /*
		 * Enable support for custom logo.
		 *
		 *  @since Classic Sixteen 1.2
		 */
		add_theme_support( 'custom-logo', array(
            'height'      => 145,
            'width'       => 145,
            'flex-height' => true,
            'flex-width'  => true,
            //'header-text' => array( 'site-title', 'site-description' ),
        ) );

		//page background image and color support
		add_theme_support( 'custom-background', 
			array( 
		   'default-color'      => '#fcfcfc',
		   'default-image'       => '',
		   'wp-head-callback'     => '_custom_background_cb',
		   'admin-head-callback'   => '',
		   'admin-preview-callback' => ''
		) );
}

add_action( 'after_setup_theme', 'newstime_theme_setup' );
endif;


/**
 * `wp_body_open` Tag may or may not be needed but accommodate for it.
 * 
 * @since 1.0
 */
if ( ! function_exists( 'wp_body_open' ) ) :
    /**
    * Add backwards compatibility support for wp_body_open function.
    */
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
endif;

/** 
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since 1.0
 */
function newstime_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters( 'newstime_content_width', 680 );
}

add_action( 'after_setup_theme',        'newstime_theme_content_width', 0 ); 

/** 
 * Enqueues scripts and styles.
 *
 * @since 1.0.0 
 */
function newstime_enqueue_styles() {
	wp_enqueue_style( 
		'newstime-style', 
		get_stylesheet_directory_uri() .'/style.css',
		array(),
		NEWSTIME_VER
	);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 
			'comment-reply' 
		);
	}
}
add_action( 'wp_enqueue_scripts',       'newstime_enqueue_styles' );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since 1.0
 */
function newstime_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'newstime' ),
			'id'            => 'sidebar-page',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'newstime' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
    register_sidebar(
		array(
			'name'          => __( 'Footer Left', 'newstime' ),
			'id'            => 'left-newstime-footer',
			'description'   => __( 'Add widgets here to appear in the left side of footer.', 'newstime' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
    register_sidebar(
		array(
			'name'          => __( 'Footer Right', 'newstime' ),
			'id'            => 'right-newstime-footer',
			'description'   => __( 'Add widgets here to appear in the right side of footer.', 'newstime' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init',             'newstime_widgets_init' );

/**
 * Custom single post pagination for ClassicPress.
 * 
 * Only displays on psts with `<!--nextpage-->`
 * @since 1.0
 */
function newstime_single_post_pagination() {
    $args = array(
        'before'           => '<nav class="post-nav-links" aria-label="' . esc_attr__( 'Post Pages', 'newstime' ) . '">
			<span class="post-nav-label">' . __( 'Read On:', 'newstime' ) . '</span>',
        'after'            => '</nav>',
        'link_before'      => '<span class="post-page-number">',
        'link_after'       => '</span>',
        'next_or_number'   => 'number', // Use 'next' if you prefer Next/Previous text
        'separator'        => ' ',
        'pagelink'         => '%',
        'echo'             => 1,
    );

    wp_link_pages( $args );

}

/**
 * Main blog archive & index pagination for ClassicPress.
 */
add_filter( 'navigation_markup_template', 'newstime_custom_pagination_template', 10, 2 );

function newstime_custom_pagination_template( $template, $class ) {
    // Custom wrapper template
    return '
    <nav class="navigation %1$s" aria-label="%4$s">
        <div class="pagination-wrapper">
            <h2 class="screen-reader-text">%2$s</h2>
            <div class="nav-links">%3$s</div>
        </div>
    </nav>';
}

/**
 * Prev Next links at bottom of single page.
 * 
 * @since 1.0
 */
function newstime_blog_pagination() {
    $pagination = get_the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __( '&laquo; Previous', 'newstime' ),
        'next_text' => __( 'Next &raquo;', 'newstime' ),
    ) );

    if ( $pagination ) {
        // Do any custom string manipulation or append extra HTML here
        $pagination .= '<!-- Pagination end -->';

        echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
add_action( 'newstime_excerpt_pagination', 'newstime_blog_pagination' );

/**
 * Support for logo upload, output. 
 *
 * @since 1.0.1 
 */
function newstime_theme_custom_logo() {
    $output = '';

    if ( function_exists( 'the_custom_logo' ) ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo           = wp_get_attachment_image_src( $custom_logo_id , 'full' );

        if ( has_custom_logo() ) {
            $output = '<div class="header-logo"><img src="'. esc_url( $logo[0] ) .'" 
            alt="'. get_bloginfo( 'name' ) .'"></div>'; 
        } else { 
            $output = ''; 
        }
    }

        // Output sanitized in header to assure all html displays.
        return $output;
}

/**
 * Display breadcrumbs navigation for newstime theme.
 */
function newstime_breadcrumbs_nav() {
	// Do not display on the front page
	if ( is_front_page() ) {
		return;
	}

	$delimiter   = ' &raquo; '; // Separator symbol
	$home_title  = __( 'Blog', 'newstime' );
	$before      = '<span class="breadcrumb-current">';
	$after       = '';

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'newstime' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' 
		. esc_html( $home_title ) . '</a>' . esc_attr( $delimiter );

	if ( is_category() ) {
		single_cat_title();
	} elseif ( is_single() ) {
		$category = get_the_category();
		if ( ! empty( $category ) ) {
			$last_category = end( $category );
			echo wp_kses_post( get_category_parents( $last_category->term_id, true, esc_html( $delimiter ) ) );
		}
		echo wp_kses_post( $before ) . esc_html( get_the_title() ) . esc_attr( $after );
	} elseif ( is_page() && ! is_blog() ) {
		global $post;
		if ( $post->post_parent ) {
			$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
			foreach ( $ancestors as $ancestor ) {
				echo '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>' . esc_html( $delimiter );
			}
		}
		echo wp_kses_post( $before ) . esc_html( get_the_title() ) . esc_attr( $after );
	} elseif ( is_archive() ) {
		echo wp_kses_post( $before ) . esc_html( get_the_archive_title() ) . esc_attr( $after );
	} elseif ( is_search() ) {
		echo wp_kses_post( $before ) . sprintf( esc_html__( 'Search Results for: %s', 'newstime' ), get_search_query() ) . esc_attr( $after );
	} elseif ( is_404() ) {
		echo wp_kses_post( $before ) . esc_html__( 'Page Not Found', 'newstime' ) . esc_attr( $after );
	}

	echo '</nav>';
}

/** 
 * Customizer
 * suport footer background & text color
 * header background & color
 * page background & color
 */

/* Adding files here to apply to the following functions below */
require get_template_directory() . '/includes/customizer.php';
/**
 * Inject customizer dynamic inline styles into wp_head.
 */
function newstime_customizer_css() {
	$accent_color = get_theme_mod( 'primary_accent_color', '#e50914' );

	// Don't print output if using default color
	if ( '#e50914' === $accent_color ) {
		return;
	}

	$sanitized_color = sanitize_hex_color( $accent_color );

	if ( ! empty( $sanitized_color ) ) :
		?>
		<style type="text/css" id="newstime-custom-colors">
			/* Ticker Section Background */
			.ticker-section {
				background-color: <?php echo esc_html( $sanitized_color ); ?>;
			}

			/* Sub-Menu Top Border & Mobile Flyout Border */
			.nav-menu .sub-menu {
				border-top-color: <?php echo esc_html( $sanitized_color ); ?>;
			}

			.nav-menu .sub-menu .sub-menu {
				border-left-color: <?php echo esc_html( $sanitized_color ); ?>;
			}

			/* Extra Accent Elements */
			.ticker-label {
				background-color: <?php echo esc_html( '#1a1a1a' ); ?>;
			}

            h1.site-title a, h1.site-title a:visited, 
			.featured-main-card .card-meta a,
			.featured-main-card .card-title a:hover,
			.sub-feature-card .card-title a:hover,
			.nav-menu a:hover {
				color: <?php echo esc_html( $sanitized_color ); ?>;
			}

            .featured-main-card, .sub-feature-card {
                border-color: <?php echo esc_html( $sanitized_color ); ?>;
            }

            .breadcrumbs-nav {
                border-bottom-color: <?php echo esc_html( $sanitized_color ); ?>;
                border-top-color: <?php echo esc_html( $sanitized_color ); ?>;
            }

		</style>
		<?php
	endif;
}
add_action( 'wp_head', 'newstime_customizer_css' );