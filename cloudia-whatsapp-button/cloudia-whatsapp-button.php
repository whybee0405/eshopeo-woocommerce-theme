<?php
/**
 * Plugin Name: Cloudia WhatsApp Button
 * Description: Reusable WhatsApp button with admin controls, audience targeting, and business insight reporting.
 * Version: 0.1.0
 * Author: Cloudia
 * Text Domain: cloudia-whatsapp-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CWB_VERSION', '0.1.0' );
define( 'CWB_PLUGIN_FILE', __FILE__ );
define( 'CWB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CWB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

final class Cloudia_WhatsApp_Button {
	private const OPTION_KEY = 'cwb_settings';
	private const SESSION_COOKIE = 'cwb_session_id';

	/**
	 * @var Cloudia_WhatsApp_Button|null
	 */
	private static $instance = null;

	public static function instance(): Cloudia_WhatsApp_Button {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'bootstrap_session' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'wp_footer', array( $this, 'render_floating_button' ) );
		add_action( 'wp_ajax_cwb_track', array( $this, 'ajax_track' ) );
		add_action( 'wp_ajax_nopriv_cwb_track', array( $this, 'ajax_track' ) );
		add_action( 'admin_post_cwb_export_events', array( $this, 'export_events_csv' ) );
		add_shortcode( 'cloudia_whatsapp_button', array( $this, 'shortcode' ) );
	}

	public static function activate(): void {
		self::create_events_table();
		if ( ! get_option( self::OPTION_KEY ) ) {
			add_option( self::OPTION_KEY, self::default_settings() );
		}
	}

	private static function create_events_table(): void {
		global $wpdb;

		$table_name      = self::table_name();
		$charset_collate = $wpdb->get_charset_collate();

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$sql = "CREATE TABLE {$table_name} (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
			event_type VARCHAR(20) NOT NULL,
			occurred_at DATETIME NOT NULL,
			page_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
			page_title VARCHAR(255) NOT NULL DEFAULT '',
			page_url TEXT NOT NULL,
			page_path VARCHAR(255) NOT NULL DEFAULT '',
			post_type VARCHAR(64) NOT NULL DEFAULT '',
			template_slug VARCHAR(128) NOT NULL DEFAULT '',
			referrer_url TEXT NOT NULL,
			utm_source VARCHAR(128) NOT NULL DEFAULT '',
			utm_medium VARCHAR(128) NOT NULL DEFAULT '',
			utm_campaign VARCHAR(128) NOT NULL DEFAULT '',
			utm_content VARCHAR(128) NOT NULL DEFAULT '',
			utm_term VARCHAR(128) NOT NULL DEFAULT '',
			device_type VARCHAR(32) NOT NULL DEFAULT '',
			os_name VARCHAR(64) NOT NULL DEFAULT '',
			browser_name VARCHAR(64) NOT NULL DEFAULT '',
			language_code VARCHAR(32) NOT NULL DEFAULT '',
			timezone_label VARCHAR(64) NOT NULL DEFAULT '',
			screen_width SMALLINT UNSIGNED NOT NULL DEFAULT 0,
			screen_height SMALLINT UNSIGNED NOT NULL DEFAULT 0,
			viewport_width SMALLINT UNSIGNED NOT NULL DEFAULT 0,
			viewport_height SMALLINT UNSIGNED NOT NULL DEFAULT 0,
			button_position VARCHAR(32) NOT NULL DEFAULT '',
			click_target VARCHAR(32) NOT NULL DEFAULT '',
			phone_number VARCHAR(64) NOT NULL DEFAULT '',
			message_text TEXT NOT NULL,
			session_id VARCHAR(64) NOT NULL DEFAULT '',
			visitor_hash VARCHAR(128) NOT NULL DEFAULT '',
			PRIMARY KEY  (id),
			KEY event_type (event_type),
			KEY occurred_at (occurred_at),
			KEY page_id (page_id),
			KEY session_id (session_id),
			KEY utm_campaign (utm_campaign(64))
		) {$charset_collate};";

		dbDelta( $sql );
	}

	private static function table_name(): string {
		global $wpdb;
		return $wpdb->prefix . 'cloudia_whatsapp_events';
	}

	private static function default_settings(): array {
		return array(
			'enabled'             => 1,
			'phone_number'        => '',
			'button_label'        => __( 'Chat on WhatsApp', 'cloudia-whatsapp-button' ),
			'default_message'     => __( 'Hello, I would like assistance from your team.', 'cloudia-whatsapp-button' ),
			'position'            => 'bottom-right',
			'theme'               => 'brand',
			'show_on_desktop'     => 1,
			'show_on_mobile'      => 1,
			'show_on_front_page'  => 1,
			'show_on_pages'       => 1,
			'show_on_posts'       => 1,
			'show_on_products'    => 1,
			'show_on_archives'    => 1,
			'include_paths'       => '',
			'exclude_paths'       => '',
			'header_text'         => __( 'Need help? Start a WhatsApp chat.', 'cloudia-whatsapp-button' ),
			'subtext'             => __( 'Fast support for enquiries, pricing, and directions.', 'cloudia-whatsapp-button' ),
		);
	}

	public function bootstrap_session(): void {
		if ( headers_sent() ) {
			return;
		}

		if ( empty( $_COOKIE[ self::SESSION_COOKIE ] ) ) {
			$session_id = wp_generate_uuid4();
			setcookie( self::SESSION_COOKIE, $session_id, time() + MONTH_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), false );
			$_COOKIE[ self::SESSION_COOKIE ] = $session_id;
		}
	}

	public function register_settings(): void {
		register_setting(
			'cwb_settings_group',
			self::OPTION_KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_settings' ),
				'default'           => self::default_settings(),
			)
		);
	}

	public function sanitize_settings( $input ): array {
		$input    = is_array( $input ) ? $input : array();
		$defaults = self::default_settings();

		return array(
			'enabled'             => ! empty( $input['enabled'] ) ? 1 : 0,
			'phone_number'        => sanitize_text_field( $input['phone_number'] ?? $defaults['phone_number'] ),
			'button_label'        => sanitize_text_field( $input['button_label'] ?? $defaults['button_label'] ),
			'default_message'     => sanitize_textarea_field( $input['default_message'] ?? $defaults['default_message'] ),
			'position'            => in_array( $input['position'] ?? '', array( 'bottom-right', 'bottom-left' ), true ) ? $input['position'] : $defaults['position'],
			'theme'               => in_array( $input['theme'] ?? '', array( 'brand', 'dark', 'light' ), true ) ? $input['theme'] : $defaults['theme'],
			'show_on_desktop'     => ! empty( $input['show_on_desktop'] ) ? 1 : 0,
			'show_on_mobile'      => ! empty( $input['show_on_mobile'] ) ? 1 : 0,
			'show_on_front_page'  => ! empty( $input['show_on_front_page'] ) ? 1 : 0,
			'show_on_pages'       => ! empty( $input['show_on_pages'] ) ? 1 : 0,
			'show_on_posts'       => ! empty( $input['show_on_posts'] ) ? 1 : 0,
			'show_on_products'    => ! empty( $input['show_on_products'] ) ? 1 : 0,
			'show_on_archives'    => ! empty( $input['show_on_archives'] ) ? 1 : 0,
			'include_paths'       => sanitize_textarea_field( $input['include_paths'] ?? '' ),
			'exclude_paths'       => sanitize_textarea_field( $input['exclude_paths'] ?? '' ),
			'header_text'         => sanitize_text_field( $input['header_text'] ?? $defaults['header_text'] ),
			'subtext'             => sanitize_text_field( $input['subtext'] ?? $defaults['subtext'] ),
		);
	}

	private function settings(): array {
		return wp_parse_args( (array) get_option( self::OPTION_KEY, array() ), self::default_settings() );
	}

	public function register_admin_menu(): void {
		add_menu_page(
			__( 'Cloudia WhatsApp', 'cloudia-whatsapp-button' ),
			__( 'Cloudia WhatsApp', 'cloudia-whatsapp-button' ),
			'manage_options',
			'cloudia-whatsapp-button',
			array( $this, 'render_dashboard_page' ),
			'dashicons-format-chat',
			58
		);

		add_submenu_page(
			'cloudia-whatsapp-button',
			__( 'Dashboard', 'cloudia-whatsapp-button' ),
			__( 'Dashboard', 'cloudia-whatsapp-button' ),
			'manage_options',
			'cloudia-whatsapp-button',
			array( $this, 'render_dashboard_page' )
		);

		add_submenu_page(
			'cloudia-whatsapp-button',
			__( 'Events', 'cloudia-whatsapp-button' ),
			__( 'Events', 'cloudia-whatsapp-button' ),
			'manage_options',
			'cloudia-whatsapp-events',
			array( $this, 'render_events_page' )
		);

		add_submenu_page(
			'cloudia-whatsapp-button',
			__( 'Settings', 'cloudia-whatsapp-button' ),
			__( 'Settings', 'cloudia-whatsapp-button' ),
			'manage_options',
			'cloudia-whatsapp-settings',
			array( $this, 'render_settings_page' )
		);
	}

	public function enqueue_admin_assets( string $hook ): void {
		if ( false === strpos( $hook, 'cloudia-whatsapp' ) ) {
			return;
		}

		wp_enqueue_style( 'cwb-admin', CWB_PLUGIN_URL . 'assets/admin.css', array(), CWB_VERSION );
		wp_enqueue_script( 'cwb-admin', CWB_PLUGIN_URL . 'assets/admin.js', array(), CWB_VERSION, true );
	}

	public function enqueue_frontend_assets(): void {
		if ( is_admin() || ! $this->should_render_button() ) {
			return;
		}

		$settings = $this->settings();

		wp_enqueue_style( 'cwb-frontend', CWB_PLUGIN_URL . 'assets/frontend.css', array(), CWB_VERSION );
		wp_enqueue_script( 'cwb-frontend', CWB_PLUGIN_URL . 'assets/frontend.js', array(), CWB_VERSION, true );
		wp_localize_script(
			'cwb-frontend',
			'cloudiaWhatsAppButton',
			array(
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'nonce'        => wp_create_nonce( 'cwb_track' ),
				'phone'        => $settings['phone_number'],
				'message'      => $settings['default_message'],
				'position'     => $settings['position'],
				'currentUrl'   => home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) ),
				'pageId'       => get_queried_object_id(),
				'pageTitle'    => wp_get_document_title(),
				'postType'     => is_singular() ? (string) get_post_type() : '',
				'templateSlug' => is_singular() ? (string) get_page_template_slug( get_queried_object_id() ) : '',
				'referrer'     => isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '',
				'utm'          => array(
					'source'   => sanitize_text_field( wp_unslash( $_GET['utm_source'] ?? '' ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					'medium'   => sanitize_text_field( wp_unslash( $_GET['utm_medium'] ?? '' ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					'campaign' => sanitize_text_field( wp_unslash( $_GET['utm_campaign'] ?? '' ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					'content'  => sanitize_text_field( wp_unslash( $_GET['utm_content'] ?? '' ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					'term'     => sanitize_text_field( wp_unslash( $_GET['utm_term'] ?? '' ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				),
				'i18n'         => array(
					'open' => __( 'Open WhatsApp chat', 'cloudia-whatsapp-button' ),
				),
			)
		);
	}

	public function shortcode( array $atts ): string {
		if ( ! $this->should_render_button() ) {
			return '';
		}

		$atts = shortcode_atts(
			array(
				'label'   => '',
				'message' => '',
			),
			$atts,
			'cloudia_whatsapp_button'
		);

		return $this->button_markup(
			array(
				'custom_label'   => sanitize_text_field( $atts['label'] ),
				'custom_message' => sanitize_text_field( $atts['message'] ),
				'inline'         => true,
			)
		);
	}

	public function render_floating_button(): void {
		if ( ! $this->should_render_button() ) {
			return;
		}

		echo $this->button_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	private function button_markup( array $args = array() ): string {
		$settings = $this->settings();
		$phone    = preg_replace( '/[^0-9]/', '', $settings['phone_number'] );
		if ( '' === $phone ) {
			return '';
		}

		$label   = ! empty( $args['custom_label'] ) ? $args['custom_label'] : $settings['button_label'];
		$message = ! empty( $args['custom_message'] ) ? $args['custom_message'] : $settings['default_message'];
		$url     = 'https://wa.me/' . rawurlencode( $phone ) . '?text=' . rawurlencode( $message );
		$inline  = ! empty( $args['inline'] );

		ob_start();
		?>
		<div class="cwb-wrap cwb-wrap--<?php echo esc_attr( $settings['position'] ); ?> cwb-wrap--<?php echo esc_attr( $settings['theme'] ); ?><?php echo $inline ? ' cwb-wrap--inline' : ''; ?>" data-cwb-root data-cwb-position="<?php echo esc_attr( $settings['position'] ); ?>">
			<div class="cwb-card" data-cwb-card>
				<div class="cwb-copy">
					<strong><?php echo esc_html( $settings['header_text'] ); ?></strong>
					<span><?php echo esc_html( $settings['subtext'] ); ?></span>
				</div>
				<a
					class="cwb-button"
					href="<?php echo esc_url( $url ); ?>"
					target="_blank"
					rel="noopener"
					aria-label="<?php esc_attr_e( 'Open WhatsApp chat', 'cloudia-whatsapp-button' ); ?>"
					data-cwb-button
					data-cwb-phone="<?php echo esc_attr( $phone ); ?>"
					data-cwb-message="<?php echo esc_attr( $message ); ?>"
				>
					<span class="cwb-button__icon" aria-hidden="true">
						<svg viewBox="0 0 32 32" fill="currentColor" role="presentation"><path d="M19.11 17.44c-.29-.15-1.7-.84-1.96-.94-.26-.09-.45-.14-.64.15-.19.29-.74.94-.9 1.14-.17.2-.33.22-.62.07-.29-.15-1.22-.45-2.32-1.44-.86-.76-1.43-1.71-1.6-2-.17-.29-.02-.44.13-.58.13-.13.29-.33.43-.49.14-.17.19-.29.29-.49.09-.2.05-.37-.02-.52-.08-.15-.64-1.54-.88-2.12-.23-.55-.47-.48-.64-.49h-.54c-.19 0-.49.07-.74.37-.25.29-.97.94-.97 2.29 0 1.34.99 2.64 1.12 2.82.14.19 1.94 2.96 4.71 4.15.66.29 1.18.46 1.58.59.66.21 1.26.18 1.74.11.53-.08 1.7-.69 1.94-1.36.24-.68.24-1.26.17-1.38-.07-.11-.26-.18-.55-.33Z"/><path d="M16.03 3.01c-7.18 0-13.01 5.82-13.01 13 0 2.29.6 4.53 1.74 6.5L3 29l6.68-1.74a13 13 0 0 0 6.35 1.63h.01c7.17 0 12.99-5.82 12.99-13 0-3.48-1.36-6.75-3.82-9.21a12.93 12.93 0 0 0-9.18-3.67Zm0 23.68h-.01c-1.94 0-3.85-.52-5.52-1.5l-.4-.24-3.97 1.03 1.06-3.87-.26-.4a10.71 10.71 0 0 1-1.65-5.71c0-5.93 4.82-10.75 10.76-10.75 2.87 0 5.56 1.12 7.58 3.14a10.67 10.67 0 0 1 3.16 7.61c0 5.93-4.82 10.75-10.75 10.75Z"/></svg>
					</span>
					<span class="cwb-button__label"><?php echo esc_html( $label ); ?></span>
				</a>
			</div>
		</div>
		<?php
		return (string) ob_get_clean();
	}

	private function should_render_button(): bool {
		$settings = $this->settings();
		if ( empty( $settings['enabled'] ) ) {
			return false;
		}

		$path = '/' . ltrim( wp_parse_url( home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) ), PHP_URL_PATH ), '/' );

		if ( $this->path_matches_rules( $settings['exclude_paths'], $path ) ) {
			return false;
		}

		if ( trim( (string) $settings['include_paths'] ) && ! $this->path_matches_rules( $settings['include_paths'], $path ) ) {
			return false;
		}

		if ( is_front_page() ) {
			return ! empty( $settings['show_on_front_page'] );
		}

		if ( function_exists( 'is_product' ) && is_product() ) {
			return ! empty( $settings['show_on_products'] );
		}

		if ( is_page() ) {
			return ! empty( $settings['show_on_pages'] );
		}

		if ( is_single() ) {
			return ! empty( $settings['show_on_posts'] );
		}

		if ( is_archive() || is_home() || is_search() || is_404() ) {
			return ! empty( $settings['show_on_archives'] );
		}

		return true;
	}

	private function path_matches_rules( string $rules, string $path ): bool {
		$lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $rules ) ) );
		foreach ( $lines as $line ) {
			if ( '' === $line ) {
				continue;
			}

			if ( 0 === strpos( $path, $line ) || fnmatch( $line, $path ) ) {
				return true;
			}
		}

		return false;
	}

	public function ajax_track(): void {
		check_ajax_referer( 'cwb_track', 'nonce' );

		$event_type = sanitize_key( wp_unslash( $_POST['event_type'] ?? '' ) );
		if ( ! in_array( $event_type, array( 'impression', 'click' ), true ) ) {
			wp_send_json_error( array( 'message' => 'Invalid event type.' ), 400 );
		}

		global $wpdb;

		$phone        = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
		$message      = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
		$page_url     = esc_url_raw( wp_unslash( $_POST['page_url'] ?? '' ) );
		$page_path    = sanitize_text_field( wp_unslash( $_POST['page_path'] ?? '' ) );
		$referrer     = esc_url_raw( wp_unslash( $_POST['referrer_url'] ?? '' ) );
		$page_title   = sanitize_text_field( wp_unslash( $_POST['page_title'] ?? '' ) );
		$post_type    = sanitize_key( wp_unslash( $_POST['post_type'] ?? '' ) );
		$template     = sanitize_text_field( wp_unslash( $_POST['template_slug'] ?? '' ) );
		$device_type  = sanitize_key( wp_unslash( $_POST['device_type'] ?? '' ) );
		$os_name      = sanitize_text_field( wp_unslash( $_POST['os_name'] ?? '' ) );
		$browser_name = sanitize_text_field( wp_unslash( $_POST['browser_name'] ?? '' ) );
		$language     = sanitize_text_field( wp_unslash( $_POST['language_code'] ?? '' ) );
		$timezone     = sanitize_text_field( wp_unslash( $_POST['timezone_label'] ?? '' ) );
		$button_pos   = sanitize_key( wp_unslash( $_POST['button_position'] ?? '' ) );
		$click_target = sanitize_key( wp_unslash( $_POST['click_target'] ?? '' ) );
		$page_id      = absint( $_POST['page_id'] ?? 0 );
		$screen_w     = absint( $_POST['screen_width'] ?? 0 );
		$screen_h     = absint( $_POST['screen_height'] ?? 0 );
		$viewport_w   = absint( $_POST['viewport_width'] ?? 0 );
		$viewport_h   = absint( $_POST['viewport_height'] ?? 0 );
		$session_id   = sanitize_text_field( $_COOKIE[ self::SESSION_COOKIE ] ?? '' );
		$utm_source   = sanitize_text_field( wp_unslash( $_POST['utm_source'] ?? '' ) );
		$utm_medium   = sanitize_text_field( wp_unslash( $_POST['utm_medium'] ?? '' ) );
		$utm_campaign = sanitize_text_field( wp_unslash( $_POST['utm_campaign'] ?? '' ) );
		$utm_content  = sanitize_text_field( wp_unslash( $_POST['utm_content'] ?? '' ) );
		$utm_term     = sanitize_text_field( wp_unslash( $_POST['utm_term'] ?? '' ) );

		$remote_addr  = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
		$visitor_hash = hash( 'sha256', $remote_addr . '|' . $session_id . '|' . wp_salt( 'auth' ) );

		$wpdb->insert(
			self::table_name(),
			array(
				'event_type'      => $event_type,
				'occurred_at'     => current_time( 'mysql' ),
				'page_id'         => $page_id,
				'page_title'      => $page_title,
				'page_url'        => $page_url,
				'page_path'       => $page_path,
				'post_type'       => $post_type,
				'template_slug'   => $template,
				'referrer_url'    => $referrer,
				'utm_source'      => $utm_source,
				'utm_medium'      => $utm_medium,
				'utm_campaign'    => $utm_campaign,
				'utm_content'     => $utm_content,
				'utm_term'        => $utm_term,
				'device_type'     => $device_type,
				'os_name'         => $os_name,
				'browser_name'    => $browser_name,
				'language_code'   => $language,
				'timezone_label'  => $timezone,
				'screen_width'    => $screen_w,
				'screen_height'   => $screen_h,
				'viewport_width'  => $viewport_w,
				'viewport_height' => $viewport_h,
				'button_position' => $button_pos,
				'click_target'    => $click_target,
				'phone_number'    => $phone,
				'message_text'    => $message,
				'session_id'      => $session_id,
				'visitor_hash'    => $visitor_hash,
			),
			array(
				'%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s',
				'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
				'%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s',
			)
		);

		wp_send_json_success( array( 'stored' => (bool) $wpdb->insert_id ) );
	}

	private function summary_stats(): array {
		global $wpdb;
		$table = self::table_name();

		$impressions     = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE event_type = 'impression'" );
		$clicks          = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE event_type = 'click'" );
		$unique_visitors = (int) $wpdb->get_var( "SELECT COUNT(DISTINCT visitor_hash) FROM {$table}" );
		$top_pages       = $wpdb->get_results( "SELECT page_title, page_url, SUM(event_type='impression') AS impressions, SUM(event_type='click') AS clicks FROM {$table} GROUP BY page_url, page_title ORDER BY clicks DESC, impressions DESC LIMIT 8", ARRAY_A );
		$top_campaigns   = $wpdb->get_results( "SELECT utm_campaign, COUNT(*) AS events FROM {$table} WHERE utm_campaign <> '' GROUP BY utm_campaign ORDER BY events DESC LIMIT 8", ARRAY_A );
		$devices         = $wpdb->get_results( "SELECT device_type, COUNT(*) AS events FROM {$table} GROUP BY device_type ORDER BY events DESC", ARRAY_A );
		$recent_events   = $wpdb->get_results( "SELECT event_type, page_title, page_url, device_type, utm_campaign, occurred_at FROM {$table} ORDER BY occurred_at DESC LIMIT 12", ARRAY_A );

		return array(
			'impressions'     => $impressions,
			'clicks'          => $clicks,
			'ctr'             => $impressions > 0 ? round( ( $clicks / $impressions ) * 100, 2 ) : 0,
			'unique_visitors' => $unique_visitors,
			'top_pages'       => is_array( $top_pages ) ? $top_pages : array(),
			'top_campaigns'   => is_array( $top_campaigns ) ? $top_campaigns : array(),
			'devices'         => is_array( $devices ) ? $devices : array(),
			'recent_events'   => is_array( $recent_events ) ? $recent_events : array(),
		);
	}

	public function render_dashboard_page(): void {
		$stats    = $this->summary_stats();
		$settings = $this->settings();
		?>
		<div class="wrap cwb-admin">
			<h1><?php esc_html_e( 'Cloudia WhatsApp Dashboard', 'cloudia-whatsapp-button' ); ?></h1>
			<p class="description"><?php esc_html_e( 'Track how visitors discover and use the WhatsApp entry point across your website.', 'cloudia-whatsapp-button' ); ?></p>

			<div class="cwb-kpis">
				<div class="cwb-kpi"><span><?php esc_html_e( 'Impressions', 'cloudia-whatsapp-button' ); ?></span><strong><?php echo esc_html( number_format_i18n( $stats['impressions'] ) ); ?></strong></div>
				<div class="cwb-kpi"><span><?php esc_html_e( 'Clicks', 'cloudia-whatsapp-button' ); ?></span><strong><?php echo esc_html( number_format_i18n( $stats['clicks'] ) ); ?></strong></div>
				<div class="cwb-kpi"><span><?php esc_html_e( 'CTR', 'cloudia-whatsapp-button' ); ?></span><strong><?php echo esc_html( $stats['ctr'] ); ?>%</strong></div>
				<div class="cwb-kpi"><span><?php esc_html_e( 'Unique visitors', 'cloudia-whatsapp-button' ); ?></span><strong><?php echo esc_html( number_format_i18n( $stats['unique_visitors'] ) ); ?></strong></div>
			</div>

			<div class="cwb-panels">
				<section class="cwb-panel">
					<h2><?php esc_html_e( 'Live button status', 'cloudia-whatsapp-button' ); ?></h2>
					<ul class="cwb-definition-list">
						<li><strong><?php esc_html_e( 'Enabled', 'cloudia-whatsapp-button' ); ?></strong><span><?php echo ! empty( $settings['enabled'] ) ? esc_html__( 'Yes', 'cloudia-whatsapp-button' ) : esc_html__( 'No', 'cloudia-whatsapp-button' ); ?></span></li>
						<li><strong><?php esc_html_e( 'Phone number', 'cloudia-whatsapp-button' ); ?></strong><span><?php echo esc_html( $settings['phone_number'] ? $settings['phone_number'] : __( 'Not set', 'cloudia-whatsapp-button' ) ); ?></span></li>
						<li><strong><?php esc_html_e( 'Position', 'cloudia-whatsapp-button' ); ?></strong><span><?php echo esc_html( $settings['position'] ); ?></span></li>
						<li><strong><?php esc_html_e( 'Theme', 'cloudia-whatsapp-button' ); ?></strong><span><?php echo esc_html( $settings['theme'] ); ?></span></li>
					</ul>
				</section>

				<section class="cwb-panel">
					<h2><?php esc_html_e( 'Top pages', 'cloudia-whatsapp-button' ); ?></h2>
					<table class="widefat striped">
						<thead><tr><th><?php esc_html_e( 'Page', 'cloudia-whatsapp-button' ); ?></th><th><?php esc_html_e( 'Impressions', 'cloudia-whatsapp-button' ); ?></th><th><?php esc_html_e( 'Clicks', 'cloudia-whatsapp-button' ); ?></th></tr></thead>
						<tbody>
						<?php if ( empty( $stats['top_pages'] ) ) : ?>
							<tr><td colspan="3"><?php esc_html_e( 'No events recorded yet.', 'cloudia-whatsapp-button' ); ?></td></tr>
						<?php else : ?>
							<?php foreach ( $stats['top_pages'] as $row ) : ?>
								<tr>
									<td><a href="<?php echo esc_url( $row['page_url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $row['page_title'] ? $row['page_title'] : $row['page_url'] ); ?></a></td>
									<td><?php echo esc_html( number_format_i18n( (int) $row['impressions'] ) ); ?></td>
									<td><?php echo esc_html( number_format_i18n( (int) $row['clicks'] ) ); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
				</section>

				<section class="cwb-panel">
					<h2><?php esc_html_e( 'Campaign signals', 'cloudia-whatsapp-button' ); ?></h2>
					<table class="widefat striped">
						<thead><tr><th><?php esc_html_e( 'Campaign', 'cloudia-whatsapp-button' ); ?></th><th><?php esc_html_e( 'Events', 'cloudia-whatsapp-button' ); ?></th></tr></thead>
						<tbody>
						<?php if ( empty( $stats['top_campaigns'] ) ) : ?>
							<tr><td colspan="2"><?php esc_html_e( 'No UTM campaign data recorded yet.', 'cloudia-whatsapp-button' ); ?></td></tr>
						<?php else : ?>
							<?php foreach ( $stats['top_campaigns'] as $row ) : ?>
								<tr><td><?php echo esc_html( $row['utm_campaign'] ); ?></td><td><?php echo esc_html( number_format_i18n( (int) $row['events'] ) ); ?></td></tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
				</section>

				<section class="cwb-panel">
					<h2><?php esc_html_e( 'Device split', 'cloudia-whatsapp-button' ); ?></h2>
					<div class="cwb-device-list">
						<?php if ( empty( $stats['devices'] ) ) : ?>
							<p><?php esc_html_e( 'No device data recorded yet.', 'cloudia-whatsapp-button' ); ?></p>
						<?php else : ?>
							<?php foreach ( $stats['devices'] as $row ) : ?>
								<div class="cwb-device-item">
									<strong><?php echo esc_html( ucfirst( (string) $row['device_type'] ) ); ?></strong>
									<span><?php echo esc_html( number_format_i18n( (int) $row['events'] ) ); ?></span>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</section>
			</div>

			<section class="cwb-panel cwb-panel--full">
				<div class="cwb-panel__head">
					<h2><?php esc_html_e( 'Recent events', 'cloudia-whatsapp-button' ); ?></h2>
					<a class="button button-secondary" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=cwb_export_events' ), 'cwb_export_events' ) ); ?>"><?php esc_html_e( 'Export CSV', 'cloudia-whatsapp-button' ); ?></a>
				</div>
				<table class="widefat striped">
					<thead><tr><th><?php esc_html_e( 'Time', 'cloudia-whatsapp-button' ); ?></th><th><?php esc_html_e( 'Event', 'cloudia-whatsapp-button' ); ?></th><th><?php esc_html_e( 'Page', 'cloudia-whatsapp-button' ); ?></th><th><?php esc_html_e( 'Device', 'cloudia-whatsapp-button' ); ?></th><th><?php esc_html_e( 'Campaign', 'cloudia-whatsapp-button' ); ?></th></tr></thead>
					<tbody>
					<?php if ( empty( $stats['recent_events'] ) ) : ?>
						<tr><td colspan="5"><?php esc_html_e( 'No events recorded yet.', 'cloudia-whatsapp-button' ); ?></td></tr>
					<?php else : ?>
						<?php foreach ( $stats['recent_events'] as $row ) : ?>
							<tr>
								<td><?php echo esc_html( $row['occurred_at'] ); ?></td>
								<td><?php echo esc_html( ucfirst( (string) $row['event_type'] ) ); ?></td>
								<td><a href="<?php echo esc_url( $row['page_url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $row['page_title'] ? $row['page_title'] : $row['page_url'] ); ?></a></td>
								<td><?php echo esc_html( $row['device_type'] ? $row['device_type'] : __( 'Unknown', 'cloudia-whatsapp-button' ) ); ?></td>
								<td><?php echo esc_html( $row['utm_campaign'] ? $row['utm_campaign'] : '—' ); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					</tbody>
				</table>
			</section>
		</div>
		<?php
	}

	public function render_events_page(): void {
		global $wpdb;
		$table  = self::table_name();
		$events = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY occurred_at DESC LIMIT 250", ARRAY_A );
		?>
		<div class="wrap cwb-admin">
			<h1><?php esc_html_e( 'Cloudia WhatsApp Events', 'cloudia-whatsapp-button' ); ?></h1>
			<p class="description"><?php esc_html_e( 'A raw event log for impressions and clicks, including page, campaign, and device context.', 'cloudia-whatsapp-button' ); ?></p>
			<table class="widefat striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Time', 'cloudia-whatsapp-button' ); ?></th>
						<th><?php esc_html_e( 'Type', 'cloudia-whatsapp-button' ); ?></th>
						<th><?php esc_html_e( 'Page', 'cloudia-whatsapp-button' ); ?></th>
						<th><?php esc_html_e( 'Path', 'cloudia-whatsapp-button' ); ?></th>
						<th><?php esc_html_e( 'Campaign', 'cloudia-whatsapp-button' ); ?></th>
						<th><?php esc_html_e( 'Device', 'cloudia-whatsapp-button' ); ?></th>
						<th><?php esc_html_e( 'Referrer', 'cloudia-whatsapp-button' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if ( empty( $events ) ) : ?>
					<tr><td colspan="7"><?php esc_html_e( 'No events recorded yet.', 'cloudia-whatsapp-button' ); ?></td></tr>
				<?php else : ?>
					<?php foreach ( $events as $event ) : ?>
						<tr>
							<td><?php echo esc_html( $event['occurred_at'] ); ?></td>
							<td><?php echo esc_html( ucfirst( (string) $event['event_type'] ) ); ?></td>
							<td><a href="<?php echo esc_url( $event['page_url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $event['page_title'] ? $event['page_title'] : $event['page_url'] ); ?></a></td>
							<td><?php echo esc_html( $event['page_path'] ); ?></td>
							<td><?php echo esc_html( $event['utm_campaign'] ? $event['utm_campaign'] : '—' ); ?></td>
							<td><?php echo esc_html( trim( $event['device_type'] . ' / ' . $event['browser_name'] ) ); ?></td>
							<td><?php echo esc_html( $event['referrer_url'] ? $event['referrer_url'] : '—' ); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	public function render_settings_page(): void {
		$settings = $this->settings();
		?>
		<div class="wrap cwb-admin">
			<h1><?php esc_html_e( 'Cloudia WhatsApp Settings', 'cloudia-whatsapp-button' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'cwb_settings_group' ); ?>
				<div class="cwb-settings-grid">
					<section class="cwb-panel">
						<h2><?php esc_html_e( 'Core setup', 'cloudia-whatsapp-button' ); ?></h2>
						<table class="form-table" role="presentation">
							<tr><th scope="row"><?php esc_html_e( 'Enable button', 'cloudia-whatsapp-button' ); ?></th><td><label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[enabled]" value="1" <?php checked( ! empty( $settings['enabled'] ) ); ?>> <?php esc_html_e( 'Show the WhatsApp button on the frontend', 'cloudia-whatsapp-button' ); ?></label></td></tr>
							<tr><th scope="row"><label for="cwb-phone"><?php esc_html_e( 'WhatsApp number', 'cloudia-whatsapp-button' ); ?></label></th><td><input class="regular-text" id="cwb-phone" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[phone_number]" value="<?php echo esc_attr( $settings['phone_number'] ); ?>" placeholder="27821234567"></td></tr>
							<tr><th scope="row"><label for="cwb-label"><?php esc_html_e( 'Button label', 'cloudia-whatsapp-button' ); ?></label></th><td><input class="regular-text" id="cwb-label" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[button_label]" value="<?php echo esc_attr( $settings['button_label'] ); ?>"></td></tr>
							<tr><th scope="row"><label for="cwb-message"><?php esc_html_e( 'Default message', 'cloudia-whatsapp-button' ); ?></label></th><td><textarea class="large-text" rows="4" id="cwb-message" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[default_message]"><?php echo esc_textarea( $settings['default_message'] ); ?></textarea></td></tr>
							<tr><th scope="row"><label for="cwb-header"><?php esc_html_e( 'Header text', 'cloudia-whatsapp-button' ); ?></label></th><td><input class="regular-text" id="cwb-header" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[header_text]" value="<?php echo esc_attr( $settings['header_text'] ); ?>"></td></tr>
							<tr><th scope="row"><label for="cwb-subtext"><?php esc_html_e( 'Support text', 'cloudia-whatsapp-button' ); ?></label></th><td><input class="regular-text" id="cwb-subtext" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[subtext]" value="<?php echo esc_attr( $settings['subtext'] ); ?>"></td></tr>
						</table>
					</section>

					<section class="cwb-panel">
						<h2><?php esc_html_e( 'Appearance and targeting', 'cloudia-whatsapp-button' ); ?></h2>
						<table class="form-table" role="presentation">
							<tr><th scope="row"><?php esc_html_e( 'Position', 'cloudia-whatsapp-button' ); ?></th><td><select name="<?php echo esc_attr( self::OPTION_KEY ); ?>[position]"><option value="bottom-right" <?php selected( $settings['position'], 'bottom-right' ); ?>><?php esc_html_e( 'Bottom right', 'cloudia-whatsapp-button' ); ?></option><option value="bottom-left" <?php selected( $settings['position'], 'bottom-left' ); ?>><?php esc_html_e( 'Bottom left', 'cloudia-whatsapp-button' ); ?></option></select></td></tr>
							<tr><th scope="row"><?php esc_html_e( 'Theme', 'cloudia-whatsapp-button' ); ?></th><td><select name="<?php echo esc_attr( self::OPTION_KEY ); ?>[theme]"><option value="brand" <?php selected( $settings['theme'], 'brand' ); ?>><?php esc_html_e( 'Brand green', 'cloudia-whatsapp-button' ); ?></option><option value="dark" <?php selected( $settings['theme'], 'dark' ); ?>><?php esc_html_e( 'Dark', 'cloudia-whatsapp-button' ); ?></option><option value="light" <?php selected( $settings['theme'], 'light' ); ?>><?php esc_html_e( 'Light', 'cloudia-whatsapp-button' ); ?></option></select></td></tr>
							<tr><th scope="row"><?php esc_html_e( 'Devices', 'cloudia-whatsapp-button' ); ?></th><td><label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_on_desktop]" value="1" <?php checked( ! empty( $settings['show_on_desktop'] ) ); ?>> <?php esc_html_e( 'Desktop', 'cloudia-whatsapp-button' ); ?></label><br><label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_on_mobile]" value="1" <?php checked( ! empty( $settings['show_on_mobile'] ) ); ?>> <?php esc_html_e( 'Mobile', 'cloudia-whatsapp-button' ); ?></label></td></tr>
							<tr><th scope="row"><?php esc_html_e( 'Content types', 'cloudia-whatsapp-button' ); ?></th><td>
								<label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_on_front_page]" value="1" <?php checked( ! empty( $settings['show_on_front_page'] ) ); ?>> <?php esc_html_e( 'Front page', 'cloudia-whatsapp-button' ); ?></label><br>
								<label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_on_pages]" value="1" <?php checked( ! empty( $settings['show_on_pages'] ) ); ?>> <?php esc_html_e( 'Pages', 'cloudia-whatsapp-button' ); ?></label><br>
								<label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_on_posts]" value="1" <?php checked( ! empty( $settings['show_on_posts'] ) ); ?>> <?php esc_html_e( 'Posts', 'cloudia-whatsapp-button' ); ?></label><br>
								<label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_on_products]" value="1" <?php checked( ! empty( $settings['show_on_products'] ) ); ?>> <?php esc_html_e( 'Products', 'cloudia-whatsapp-button' ); ?></label><br>
								<label><input type="checkbox" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[show_on_archives]" value="1" <?php checked( ! empty( $settings['show_on_archives'] ) ); ?>> <?php esc_html_e( 'Archives / search / 404', 'cloudia-whatsapp-button' ); ?></label>
							</td></tr>
							<tr><th scope="row"><label for="cwb-include"><?php esc_html_e( 'Only include paths', 'cloudia-whatsapp-button' ); ?></label></th><td><textarea class="large-text code" rows="4" id="cwb-include" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[include_paths]"><?php echo esc_textarea( $settings['include_paths'] ); ?></textarea><p class="description"><?php esc_html_e( 'One path per line. Example: /find-a-branch or /branches/*', 'cloudia-whatsapp-button' ); ?></p></td></tr>
							<tr><th scope="row"><label for="cwb-exclude"><?php esc_html_e( 'Exclude paths', 'cloudia-whatsapp-button' ); ?></label></th><td><textarea class="large-text code" rows="4" id="cwb-exclude" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[exclude_paths]"><?php echo esc_textarea( $settings['exclude_paths'] ); ?></textarea></td></tr>
						</table>
					</section>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	public function export_events_csv(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to export events.', 'cloudia-whatsapp-button' ) );
		}

		check_admin_referer( 'cwb_export_events' );

		global $wpdb;
		$table  = self::table_name();
		$events = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY occurred_at DESC", ARRAY_A );

		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=cloudia-whatsapp-events.csv' );

		$output = fopen( 'php://output', 'w' );
		if ( false === $output ) {
			exit;
		}

		if ( ! empty( $events ) ) {
			fputcsv( $output, array_keys( $events[0] ) );
			foreach ( $events as $event ) {
				fputcsv( $output, $event );
			}
		}

		fclose( $output );
		exit;
	}
}

register_activation_hook( CWB_PLUGIN_FILE, array( 'Cloudia_WhatsApp_Button', 'activate' ) );
Cloudia_WhatsApp_Button::instance();
