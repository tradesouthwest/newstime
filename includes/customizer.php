<?php 
/**
 * Register Primary Accent Color in the existing Colors section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function newstime_customize_colors( $wp_customize ) {

	// Add Primary Accent Color Setting
	$wp_customize->add_setting(
		'primary_accent_color',
		array(
			'default'           => '#e50914', // Default NewsTime red
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);

	// Add Control to existing 'colors' section
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_accent_color',
			array(
				'label'    => __( 'Primary Accent Color', 'newstime' ),
				'section'  => 'colors', // Attaches to built-in Colors section
				'settings' => 'primary_accent_color',
			)
		)
	);
}
add_action( 'customize_register', 'newstime_customize_colors' );

/**
 * Add Newstime Instructions and Plugin Recommendation to the WordPress/ClassicPress Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function newstime_customize_register_instructions( $wp_customize ) {

    // 1. Add the "Newstime Instructions" Panel/Section
    $wp_customize->add_section( 'newstime_instructions_section', array(
        'title'       => __( 'Newstime Instructions', 'newstime' ),
        'priority'    => 20, // Positions near the top of the Customizer menu
        'description' => __( 'Tips and recommended plugins for getting the most out of the Newstime theme.', 'newstime' ),
    ) );

    // 2. Add a dummy setting required by the Customizer API for output control
    $wp_customize->add_setting( 'newstime_plugin_promo_notice', array(
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    // 3. Define HTML content to present the plugin recommendation
    $promo_html  = '<div style="background: #fff; border-left: 4px solid #0073aa; padding: 10px 12px; margin-bottom: 12px; box-shadow: 0 1px 1px rgba(0,0,0,0.04);">';
    $promo_html .= '<h4 style="margin: 0 0 8px; font-size: 14px;">' . __( 'Recommended Plugin', 'newstime' ) . '</h4>';
    $promo_html .= '<p style="margin: 0 0 10px; font-size: 13px; line-height: 1.4;">' . __( 'Enhance your front-page layout and custom post queries with the official <strong>Newstime Display Posts</strong> plugin.', 'newstime' ) . '</p>';
    $promo_html .= '<p style="margin: 0 0 6px;"><a href="https://directory.classicpress.net/plugins/newstime-display-posts/" target="_blank" rel="noopener noreferrer" class="button button-primary">' . __( 'Get Newstime Display Posts', 'newstime' ) . ' &rarr;</a></p>';
    $promo_html .= '</div>';

    // 4. Inject static HTML content using WP_Customize_Control
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'newstime_plugin_promo_notice_control',
        array(
            'section'     => 'newstime_instructions_section',
            'settings'    => 'newstime_plugin_promo_notice',
            'type'        => 'hidden',
            'description' => $promo_html,
        )
    ) );

    // 5. Shortcode Reference List
    $wp_customize->add_setting( 'newstime_shortcode_guide_notice', array(
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $guide_html  = '<div style="margin-top: 15px;">';
    $guide_html .= '<h4 style="margin: 0 0 6px; font-size: 13px;">' . __( 'Quick Shortcode Usage', 'newstime' ) . '</h4>';
    $guide_html .= '<p style="font-size: 12px; color: #666; margin-0 0 6px;">' . __( 'Once activated, display post grids anywhere using:', 'newstime' ) . '</p>';
    $guide_html .= '<code style="display: block; padding: 6px; background: #f0f0f1; font-size: 11px;">[newstime_display_posts posts_per_page="6"]</code>';
    $guide_html .= '</div>';

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'newstime_shortcode_guide_control',
        array(
            'section'     => 'newstime_instructions_section',
            'settings'    => 'newstime_shortcode_guide_notice',
            'type'        => 'hidden',
            'description' => $guide_html,
        )
    ) );
}
add_action( 'customize_register', 'newstime_customize_register_instructions' );