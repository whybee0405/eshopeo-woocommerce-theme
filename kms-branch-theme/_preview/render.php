<?php
/**
 * Static preview harness.
 *
 * Renders the theme templates to flat HTML with a thin set of WordPress
 * stubs, so the design can be reviewed and screenshotted in a browser
 * without standing up a WordPress install.
 *
 * Usage:  php _preview/render.php
 *
 * This directory is a development tool. It is excluded from the packaged
 * theme by build/package.sh and is safe to delete.
 */

define( 'ABSPATH', dirname( __DIR__ ) . '/' );
define( 'KMS_PREVIEW', true );

$theme_dir = dirname( __DIR__ );
$out_dir   = __DIR__;

/* -------------------------------------------------------------------------
   WordPress stubs
   ------------------------------------------------------------------------- */

function get_theme_file_path( $file = '' ) {
	return dirname( __DIR__ ) . '/' . ltrim( $file, '/' );
}

function get_template_directory() {
	return dirname( __DIR__ );
}

function get_theme_file_uri( $file = '' ) {
	return '../' . ltrim( $file, '/' );
}

/**
 * Map WordPress-style paths onto the flat files this harness writes, so
 * kms_branch_url() resolves correctly without being stubbed out.
 */
function home_url( $path = '/' ) {
	$slug = trim( (string) $path, '/' );
	return '' === $slug ? 'index.html' : $slug . '.html';
}

function get_permalink( $post = null ) {
	return 'index.html';
}

function get_page_by_path( $slug ) {
	return null;
}

function get_theme_mod( $name, $default = '' ) {
	return $default;
}

function wp_timezone() {
	return new DateTimeZone( 'Africa/Johannesburg' );
}

function wp_timezone_string() {
	return 'Africa/Johannesburg';
}

function wp_parse_args( $args, $defaults = array() ) {
	return array_merge( $defaults, (array) $args );
}

function esc_html( $t ) {
	return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8' );
}

function esc_attr( $t ) {
	return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8' );
}

function esc_url( $t ) {
	return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8' );
}

function esc_textarea( $t ) {
	return esc_html( $t );
}

function __( $t, $d = '' ) {
	return $t;
}

function esc_html__( $t, $d = '' ) {
	return esc_html( $t );
}

function esc_attr__( $t, $d = '' ) {
	return esc_attr( $t );
}

function esc_html_e( $t, $d = '' ) {
	echo esc_html( $t );
}

function esc_attr_e( $t, $d = '' ) {
	echo esc_attr( $t );
}

function _e( $t, $d = '' ) {
	echo $t;
}

function _x( $t, $c = '', $d = '' ) {
	return $t;
}

function sanitize_text_field( $t ) {
	return trim( strip_tags( (string) $t ) );
}

function wp_json_encode( $data, $flags = 0 ) {
	return json_encode( $data, $flags );
}

function add_action() {}
function add_filter() {}
function remove_action() {}
function remove_post_type_support() {}
function add_theme_support() {}
function register_nav_menus() {}
function load_theme_textdomain() {}
function wp_enqueue_style() {}
function wp_enqueue_script() {}
function wp_dequeue_style() {}
function wp_localize_script() {}
function wp_body_open() {}
function have_posts() {
	return false;
}
function the_post() {}
function the_title() {}
function the_permalink() {}
function the_content() {}
function wp_get_document_title() {
	return 'Korean Motor Spares';
}

function language_attributes() {
	echo 'lang="en-ZA"';
}

function bloginfo( $what ) {
	if ( 'charset' === $what ) {
		echo 'UTF-8';
	}
}

function body_class( $extra = '' ) {
	global $kms_preview_page;
	$classes = array( 'kms', $extra );
	if ( 'index' === $kms_preview_page ) {
		$classes[] = 'is-landing';
	} else {
		$classes[] = 'is-branch';
		$classes[] = 'is-branch-' . $kms_preview_page;
	}
	echo 'class="' . esc_attr( implode( ' ', array_filter( $classes ) ) ) . '"';
}

function wp_head() {
	echo '<title>' . esc_html( kms_preview_title() ) . "</title>\n";
	printf(
		'<link rel="stylesheet" href="%s">' . "\n",
		esc_url( get_theme_file_uri( 'assets/css/main.css' ) )
	);
	kms_preload_assets();
	kms_print_schema();
}

function wp_footer() {
	global $kms_preview_page;
	$data = array(
		'branches' => array_map(
			static function ( $b ) {
				return array(
					'slug'  => $b['slug'],
					'hours' => $b['hours'],
				);
			},
			kms_branch()
		),
		'strings'  => array(
			'openNow'  => 'Open now',
			'closed'   => 'Closed',
			'until'    => 'until %s',
			'opensAt'  => 'opens %s today',
			'opensDay' => 'opens %1$s %2$s',
			'tomorrow' => 'tomorrow',
		),
		'timezone' => 'Africa/Johannesburg',
	);
	echo '<script>window.kmsData = ' . wp_json_encode( $data ) . ";</script>\n";
	printf( '<script src="%s"></script>' . "\n", esc_url( get_theme_file_uri( 'assets/js/main.js' ) ) );
}

function is_front_page() {
	global $kms_preview_page;
	return 'index' === $kms_preview_page;
}

function is_page() {
	global $kms_preview_page;
	return 'index' !== $kms_preview_page;
}

function get_queried_object() {
	return null;
}

function get_header() {
	include dirname( __DIR__ ) . '/header.php';
}

function get_footer() {
	include dirname( __DIR__ ) . '/footer.php';
}

function get_template_part( $slug, $name = null, $args = array() ) {
	$file = dirname( __DIR__ ) . '/' . $slug . '.php';
	if ( file_exists( $file ) ) {
		include $file;
	}
}

/* -------------------------------------------------------------------------
   Theme code
   ------------------------------------------------------------------------- */

require_once $theme_dir . '/inc/branches.php';
require_once $theme_dir . '/inc/icons.php';
require_once $theme_dir . '/inc/schema.php';

function kms_current_branch() {
	global $kms_preview_page;
	if ( 'index' === $kms_preview_page ) {
		return null;
	}
	return kms_branch( $kms_preview_page );
}

function kms_img( $file ) {
	return '../assets/img/' . $file;
}

function kms_image( array $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'file'          => '',
			'alt'           => '',
			'width'         => 0,
			'height'        => 0,
			'class'         => '',
			'loading'       => 'lazy',
			'sizes'         => '100vw',
			'fetchpriority' => '',
		)
	);

	if ( '' === $args['file'] ) {
		return;
	}

	printf(
		'<img src="%1$s" alt="%2$s" width="%3$d" height="%4$d" class="%5$s" loading="%6$s" decoding="async" sizes="%7$s">',
		esc_url( kms_img( $args['file'] ) ),
		esc_attr( $args['alt'] ),
		(int) $args['width'],
		(int) $args['height'],
		esc_attr( $args['class'] ),
		esc_attr( $args['loading'] ),
		esc_attr( $args['sizes'] )
	);
}

function kms_preload_assets() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_theme_file_uri( 'assets/fonts/instrument-sans-var.woff2' ) )
	);

	if ( is_front_page() ) {
		printf(
			'<link rel="preload" as="image" href="%1$s" imagesrcset="%2$s 800w, %3$s 1600w" imagesizes="100vw" fetchpriority="high">' . "\n",
			esc_url( kms_img( 'hero-portrait.webp' ) ),
			esc_url( kms_img( 'hero-portrait.webp' ) ),
			esc_url( kms_img( 'hero-portrait@1600.webp' ) )
		);
	}
}

function kms_preview_title() {
	global $kms_preview_page;
	$titles = array(
		'index'       => 'Korean Motor Spares Lenasia & Vereeniging | Hyundai, Kia, Daewoo, SsangYong parts',
		'lenasia'     => 'Korean Motor Spares Lenasia | 117 Robin Ave | Korean car parts',
		'vereeniging' => 'Korean Motor Spares Vereeniging | 28 De Villiers Ave | Korean car parts',
	);
	return isset( $titles[ $kms_preview_page ] ) ? $titles[ $kms_preview_page ] : 'Korean Motor Spares';
}

/* -------------------------------------------------------------------------
   Render
   ------------------------------------------------------------------------- */

$pages = array(
	'index'       => $theme_dir . '/front-page.php',
	'lenasia'     => $theme_dir . '/page-lenasia.php',
	'vereeniging' => $theme_dir . '/page-vereeniging.php',
);

foreach ( $pages as $page => $template ) {
	$GLOBALS['kms_preview_page'] = $page;
	unset( $GLOBALS['kms_branch_slug'] );

	ob_start();
	include $template;
	$html = ob_get_clean();

	file_put_contents( $out_dir . '/' . $page . '.html', $html );
	printf( "  %-16s %6d bytes\n", $page . '.html', strlen( $html ) );
}

echo "Preview built. Open _preview/index.html\n";
