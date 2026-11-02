<?php
/**
 * Customizer settings for this theme
 *
 * @package hopewave
 */

/**
 * Register the Footer section under Appearance → Customize.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function hopewave_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'hopewave_footer',
		array(
			'title'    => __( 'Footer', 'hopewave' ),
			'priority' => 120,
		)
	);

	// "Subscribe Us" column: intro text and Gravity Form.
	$wp_customize->add_setting(
		'hopewave_subscribe_text',
		array(
			'default'           => __( 'Donations or support!', 'hopewave' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hopewave_subscribe_text',
		array(
			'label'   => __( 'Subscribe text', 'hopewave' ),
			'section' => 'hopewave_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hopewave_subscribe_form',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'hopewave_subscribe_form',
		array(
			'label'       => __( 'Subscribe form', 'hopewave' ),
			'description' => __( 'Gravity Form shown in the "Subscribe Us" column.', 'hopewave' ),
			'section'     => 'hopewave_footer',
			'type'        => 'select',
			'choices'     => hopewave_gravity_form_choices(),
		)
	);
}
add_action( 'customize_register', 'hopewave_customize_register' );

/**
 * List active Gravity Forms as select choices.
 *
 * @return array<int, string> Form titles keyed by form ID.
 */
function hopewave_gravity_form_choices() {
	$choices = array( 0 => __( '— None —', 'hopewave' ) );

	if ( class_exists( 'GFAPI' ) ) {
		foreach ( GFAPI::get_forms() as $form ) {
			$choices[ (int) $form['id'] ] = $form['title'];
		}
	}

	return $choices;
}
