<?php
/**
 * Inline SVG icon set.
 *
 * One family, one 24x24 grid, 1.75 stroke on the outline icons. WhatsApp is
 * the only filled glyph because it is a brand mark and has to stay recognisable.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return an icon's inner SVG markup.
 *
 * @param string $name Icon name.
 * @return string
 */
function kms_icon_path( $name ) {
	$icons = array(
		'whatsapp'  => '<path fill="currentColor" d="M12.02 2C6.6 2 2.2 6.4 2.2 11.82c0 1.9.53 3.68 1.46 5.2L2 22l5.12-1.62a9.77 9.77 0 0 0 4.9 1.31h.01c5.42 0 9.82-4.4 9.82-9.82S17.44 2 12.02 2Zm0 17.85h-.01a8.1 8.1 0 0 1-4.13-1.13l-.3-.18-3.04.96.97-2.96-.2-.31a8.05 8.05 0 0 1-1.24-4.3c0-4.48 3.65-8.13 8.14-8.13a8.13 8.13 0 0 1 .01 16.26Zm4.46-6.09c-.24-.12-1.45-.72-1.67-.8-.23-.08-.39-.12-.55.12-.16.25-.63.8-.78.97-.14.16-.29.18-.53.06a6.66 6.66 0 0 1-1.96-1.21 7.4 7.4 0 0 1-1.36-1.69c-.14-.24-.01-.37.11-.49.11-.11.24-.29.36-.43.12-.15.16-.25.24-.41.08-.17.04-.31-.02-.43-.06-.12-.55-1.33-.76-1.81-.2-.48-.4-.42-.55-.42l-.47-.01c-.16 0-.43.06-.65.3-.22.24-.86.84-.86 2.05s.88 2.38 1 2.54c.12.16 1.73 2.65 4.2 3.71.58.26 1.04.4 1.4.51.59.19 1.13.16 1.55.1.47-.07 1.45-.59 1.66-1.17.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28Z"/>',
		'phone'     => '<path d="M6.5 3.5h3l1.5 4-2 1.4a12.5 12.5 0 0 0 6.1 6.1l1.4-2 4 1.5v3a2 2 0 0 1-2.2 2A17.5 17.5 0 0 1 4.5 5.7 2 2 0 0 1 6.5 3.5Z"/>',
		'pin'       => '<path d="M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11Z"/><circle cx="12" cy="10" r="2.6"/>',
		'clock'     => '<circle cx="12" cy="12" r="8.75"/><path d="M12 7.2V12l3.2 2"/>',
		'arrow'     => '<path d="M4.5 12h14m0 0-5.5-5.5M18.5 12 13 17.5"/>',
		'directions' => '<path d="m12 2.8 9.2 9.2-9.2 9.2L2.8 12 12 2.8Z"/><path d="M9.4 14v-2.6a1.6 1.6 0 0 1 1.6-1.6h3.6m0 0-1.9-1.9m1.9 1.9-1.9 1.9"/>',
		'check'     => '<path d="m4.8 12.4 4.6 4.6 9.8-9.8"/>',
		'menu'      => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close'     => '<path d="M6 6l12 12M18 6 6 18"/>',
		'wrench'    => '<path d="M15.6 3.5a5.2 5.2 0 0 0-5.9 6.6L3.4 16.4a2 2 0 0 0 0 2.8l1.4 1.4a2 2 0 0 0 2.8 0l6.3-6.3a5.2 5.2 0 0 0 6.6-5.9l-3 3-2.9-.7-.7-2.9 3-3Z"/>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Echo an inline SVG icon.
 *
 * Decorative by default: icons sitting next to a text label are hidden from
 * assistive tech so the label is not announced twice. Pass a title to make
 * the icon meaningful instead.
 *
 * @param string $name  Icon name.
 * @param array  $args  Optional. size, class, title.
 */
function kms_icon( $name, array $args = array() ) {
	$path = kms_icon_path( $name );

	if ( '' === $path ) {
		return;
	}

	$args = wp_parse_args(
		$args,
		array(
			'size'  => 24,
			'class' => '',
			'title' => '',
		)
	);

	$filled = 'whatsapp' === $name;

	printf(
		'<svg class="icon %1$s" width="%2$d" height="%3$d" viewBox="0 0 24 24" %4$s aria-hidden="%5$s"%6$s>%7$s%8$s</svg>',
		esc_attr( $args['class'] ),
		(int) $args['size'],
		(int) $args['size'],
		$filled
			? 'fill="currentColor"'
			: 'fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"',
		$args['title'] ? 'false' : 'true',
		$args['title'] ? ' role="img"' : '',
		$args['title'] ? '<title>' . esc_html( $args['title'] ) . '</title>' : '',
		$path // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static markup defined above.
	);
}
