<?php
/**
 * Customizer controls.
 *
 * Everything the branch is likely to want changed without a developer:
 * phone numbers, WhatsApp numbers, trading hours.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register branch settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function kms_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'kms_branches',
		array(
			'title'       => __( 'Branch details', 'kms-branch' ),
			'description' => __( 'Phone numbers and trading hours for each branch. Leave a field blank to keep the built-in default.', 'kms-branch' ),
			'priority'    => 20,
		)
	);

	$days = array(
		1 => __( 'Monday', 'kms-branch' ),
		2 => __( 'Tuesday', 'kms-branch' ),
		3 => __( 'Wednesday', 'kms-branch' ),
		4 => __( 'Thursday', 'kms-branch' ),
		5 => __( 'Friday', 'kms-branch' ),
		6 => __( 'Saturday', 'kms-branch' ),
		7 => __( 'Sunday', 'kms-branch' ),
	);

	foreach ( kms_branches_raw() as $slug => $branch ) {
		$section = 'kms_branch_' . $slug;

		$wp_customize->add_section(
			$section,
			array(
				'title' => $branch['name'],
				'panel' => 'kms_branches',
			)
		);

		$wp_customize->add_setting(
			"kms_{$slug}_phone",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"kms_{$slug}_phone",
			array(
				'label'       => __( 'Phone number', 'kms-branch' ),
				'section'     => $section,
				'type'        => 'text',
				/* translators: %s: default phone number */
				'description' => sprintf( __( 'Default: %s', 'kms-branch' ), $branch['phone'] ),
			)
		);

		$wp_customize->add_setting(
			"kms_{$slug}_whatsapp",
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"kms_{$slug}_whatsapp",
			array(
				'label'       => __( 'WhatsApp number', 'kms-branch' ),
				'section'     => $section,
				'type'        => 'text',
				/* translators: %s: default WhatsApp number in international format */
				'description' => sprintf( __( 'International format, digits only. Default: %s', 'kms-branch' ), $branch['whatsapp'] ),
			)
		);

		foreach ( $days as $day => $label ) {
			$slot    = $branch['hours'][ $day ];
			$default = is_array( $slot ) ? $slot[0] . '-' . $slot[1] : 'Closed';

			$wp_customize->add_setting(
				"kms_{$slug}_hours_{$day}",
				array(
					'default'           => '',
					'sanitize_callback' => 'kms_sanitize_hours',
					'transport'         => 'refresh',
				)
			);
			$wp_customize->add_control(
				"kms_{$slug}_hours_{$day}",
				array(
					'label'       => $label,
					'section'     => $section,
					'type'        => 'text',
					/* translators: %s: default hours string, e.g. 08:00-17:00 */
					'description' => sprintf( __( '"08:00-17:00" or "Closed". Default: %s', 'kms-branch' ), $default ),
				)
			);
		}
	}
}
add_action( 'customize_register', 'kms_customize_register' );

/**
 * Accept only "HH:MM-HH:MM", "Closed", or empty.
 *
 * @param string $value Raw input.
 * @return string
 */
function kms_sanitize_hours( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value || 0 === strcasecmp( $value, 'closed' ) ) {
		return $value;
	}

	if ( preg_match( '/^\s*\d{1,2}:\d{2}\s*[-\x{2013}]\s*\d{1,2}:\d{2}\s*$/u', $value ) ) {
		return $value;
	}

	return '';
}
