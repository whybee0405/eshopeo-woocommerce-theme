<?php
/**
 * Plugin Name: Cloudia Store Locator
 * Description: Reusable branch and store locator with nearest-location sorting, browser geolocation, and optional Google Maps support.
 * Version: 0.1.0
 * Author: Cloudia
 * Text Domain: cloudia-store-locator
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CSL_VERSION', '0.1.0' );
define( 'CSL_PLUGIN_FILE', __FILE__ );
define( 'CSL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CSL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

final class Cloudia_Store_Locator {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'settings_page' ) );
		add_shortcode( 'cloudia_store_locator', array( $this, 'shortcode' ) );
	}

	public function register_settings(): void {
		register_setting(
			'csl_settings',
			'csl_google_maps_api_key',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '',
			)
		);
	}

	public function settings_page(): void {
		add_options_page(
			__( 'Cloudia Store Locator', 'cloudia-store-locator' ),
			__( 'Cloudia Store Locator', 'cloudia-store-locator' ),
			'manage_options',
			'cloudia-store-locator',
			array( $this, 'render_settings_page' )
		);
	}

	public function render_settings_page(): void {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Cloudia Store Locator', 'cloudia-store-locator' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'csl_settings' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="csl_google_maps_api_key"><?php esc_html_e( 'Google Maps API Key', 'cloudia-store-locator' ); ?></label></th>
						<td>
							<input type="text" class="regular-text" id="csl_google_maps_api_key" name="csl_google_maps_api_key" value="<?php echo esc_attr( (string) get_option( 'csl_google_maps_api_key', '' ) ); ?>">
							<p class="description"><?php esc_html_e( 'Optional. If empty, the locator falls back to OpenStreetMap tiles while keeping Google Maps direction links.', 'cloudia-store-locator' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	public function shortcode( array $atts ): string {
		$atts = shortcode_atts(
			array(
				'title' => __( 'Find your nearest branch', 'cloudia-store-locator' ),
			),
			$atts,
			'cloudia_store_locator'
		);

		return $this->render(
			array(
				'title' => sanitize_text_field( $atts['title'] ),
			),
			false
		);
	}

	public function render( array $args = array(), bool $echo = true ): string {
		$locations = apply_filters( 'cloudia_store_locator_locations', array(), $args );
		$locations = is_array( $locations ) ? array_values( array_filter( array_map( array( $this, 'normalize_location' ), $locations ) ) ) : array();

		if ( empty( $locations ) ) {
			return '';
		}

		$this->enqueue_assets( $locations );

		ob_start();
		?>
		<section class="csl-locator" data-csl-root>
			<div class="csl-toolbar">
				<div class="csl-toolbar__copy">
					<p class="csl-eyebrow"><?php esc_html_e( 'Store locator', 'cloudia-store-locator' ); ?></p>
					<h2 class="csl-title"><?php echo esc_html( ! empty( $args['title'] ) ? $args['title'] : __( 'Find your nearest branch', 'cloudia-store-locator' ) ); ?></h2>
				</div>
				<div class="csl-toolbar__controls">
					<input type="search" class="csl-search" data-csl-search placeholder="<?php esc_attr_e( 'Search branch, city, suburb, province, or country', 'cloudia-store-locator' ); ?>">
					<button type="button" class="csl-button csl-button--secondary" data-csl-locate><?php esc_html_e( 'Use my location', 'cloudia-store-locator' ); ?></button>
					<button type="button" class="csl-button csl-button--ghost" data-csl-reset><?php esc_html_e( 'Reset', 'cloudia-store-locator' ); ?></button>
				</div>
			</div>
			<div class="csl-status" data-csl-status><?php esc_html_e( 'Showing all branches.', 'cloudia-store-locator' ); ?></div>
			<div class="csl-layout">
				<div class="csl-map-panel">
					<div class="csl-map" data-csl-map aria-label="<?php esc_attr_e( 'Store locator map', 'cloudia-store-locator' ); ?>"></div>
				</div>
				<div class="csl-results-panel">
					<div class="csl-featured" data-csl-featured hidden>
						<p class="csl-eyebrow"><?php esc_html_e( 'Nearest branch', 'cloudia-store-locator' ); ?></p>
						<h3 class="csl-featured__name" data-csl-featured-name></h3>
						<p class="csl-featured__meta" data-csl-featured-meta></p>
						<div class="csl-featured__actions">
							<a class="csl-button" data-csl-featured-branch href="#"><?php esc_html_e( 'Open branch page', 'cloudia-store-locator' ); ?></a>
							<a class="csl-button csl-button--secondary" data-csl-featured-call href="#"><?php esc_html_e( 'Call', 'cloudia-store-locator' ); ?></a>
							<a class="csl-button csl-button--secondary" data-csl-featured-whatsapp href="#" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp', 'cloudia-store-locator' ); ?></a>
							<a class="csl-button csl-button--secondary" data-csl-featured-directions href="#" target="_blank" rel="noopener"><?php esc_html_e( 'Directions', 'cloudia-store-locator' ); ?></a>
						</div>
					</div>
					<div class="csl-results" data-csl-results></div>
				</div>
			</div>
		</section>
		<?php
		$html = ob_get_clean();
		if ( $echo ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		return $html;
	}

	private function normalize_location( $location ): array {
		if ( ! is_array( $location ) ) {
			return array();
		}

		$lat = isset( $location['lat'] ) ? (float) $location['lat'] : 0.0;
		$lng = isset( $location['lng'] ) ? (float) $location['lng'] : 0.0;
		if ( ! $lat || ! $lng ) {
			return array();
		}

		return array(
			'slug'       => sanitize_title( isset( $location['slug'] ) ? (string) $location['slug'] : '' ),
			'name'       => sanitize_text_field( isset( $location['name'] ) ? (string) $location['name'] : '' ),
			'province'   => sanitize_text_field( isset( $location['province'] ) ? (string) $location['province'] : '' ),
			'country'    => sanitize_text_field( isset( $location['country'] ) ? (string) $location['country'] : '' ),
			'address'    => sanitize_text_field( isset( $location['address'] ) ? (string) $location['address'] : '' ),
			'phone'      => sanitize_text_field( isset( $location['phone'] ) ? (string) $location['phone'] : '' ),
			'email'      => sanitize_email( isset( $location['email'] ) ? (string) $location['email'] : '' ),
			'url'        => esc_url_raw( isset( $location['url'] ) ? (string) $location['url'] : '' ),
			'directions' => esc_url_raw( isset( $location['directions'] ) ? (string) $location['directions'] : '' ),
			'whatsapp'   => esc_url_raw( isset( $location['whatsapp'] ) ? (string) $location['whatsapp'] : '' ),
			'lat'        => $lat,
			'lng'        => $lng,
		);
	}

	private function enqueue_assets( array $locations ): void {
		$api_key = (string) get_option( 'csl_google_maps_api_key', '' );

		wp_enqueue_style( 'csl-frontend', CSL_PLUGIN_URL . 'assets/frontend.css', array(), CSL_VERSION );

		if ( '' === $api_key ) {
			wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
			wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
			$deps = array( 'leaflet' );
		} else {
			wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . rawurlencode( $api_key ), array(), null, true );
			$deps = array( 'google-maps' );
		}

		wp_enqueue_script( 'csl-frontend', CSL_PLUGIN_URL . 'assets/frontend.js', $deps, CSL_VERSION, true );
		wp_add_inline_script(
			'csl-frontend',
			'window.cloudiaStoreLocator = ' . wp_json_encode(
				array(
					'provider'  => '' === $api_key ? 'leaflet' : 'google',
					'locations' => $locations,
					'i18n'      => array(
						'showingAll'   => __( 'Showing all branches.', 'cloudia-store-locator' ),
						'locating'     => __( 'Checking your location…', 'cloudia-store-locator' ),
						'nearest'      => __( 'Nearest branches to your current location.', 'cloudia-store-locator' ),
						'noGeo'        => __( 'Location access was unavailable. Showing all branches instead.', 'cloudia-store-locator' ),
						'noMatches'    => __( 'No matching branches found.', 'cloudia-store-locator' ),
						'distanceAway' => __( 'away', 'cloudia-store-locator' ),
					),
				)
			),
			'before'
		);
	}
}

function cloudia_store_locator() {
	static $instance = null;
	if ( null === $instance ) {
		$instance = new Cloudia_Store_Locator();
	}
	return $instance;
}
cloudia_store_locator();

function cloudia_store_locator_render( array $args = array(), bool $echo = true ): string {
	return cloudia_store_locator()->render( $args, $echo );
}
