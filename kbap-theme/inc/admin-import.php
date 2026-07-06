<?php
/**
 * Admin importer.
 *
 * @package KBAP
 */

defined( 'ABSPATH' ) || exit;

function kbap_admin_import_menu() {
	add_theme_page(
		__( 'Import K-BAP demo products', 'kbap' ),
		__( 'K-BAP Demo Import', 'kbap' ),
		'manage_options',
		'kbap-demo-import',
		'kbap_admin_import_page'
	);
}
add_action( 'admin_menu', 'kbap_admin_import_menu' );

function kbap_admin_import_page() {
	if ( isset( $_POST['kbap_import'] ) && check_admin_referer( 'kbap_import_demo' ) ) {
		require_once get_theme_file_path( 'dummy-products.php' );
		$result = kbap_run_import();
		if ( is_wp_error( $result ) ) {
			echo '<div class="notice notice-error"><p>' . esc_html( $result->get_error_message() ) . '</p></div>';
		} else {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'K-BAP demo products imported.', 'kbap' ) . '</p></div>';
		}
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'K-BAP Demo Import', 'kbap' ); ?></h1>
		<p><?php esc_html_e( 'Imports sample products for kimchi, meal kits, catering packs and menu favourites.', 'kbap' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'kbap_import_demo' ); ?>
			<?php submit_button( __( 'Import demo products', 'kbap' ), 'primary', 'kbap_import' ); ?>
		</form>
	</div>
	<?php
}
