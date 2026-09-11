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