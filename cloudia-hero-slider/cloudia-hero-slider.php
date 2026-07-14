<?php
/**
 * Plugin Name: Cloudia Hero Slider
 * Description: Reusable hero slider modules with a WordPress admin editor, inspired by layered WordPress slider workflows.
 * Version: 0.1.0
 * Author: Cloudia
 * Text Domain: cloudia-hero-slider
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CHS_VERSION', '0.1.0' );
define( 'CHS_PLUGIN_FILE', __FILE__ );
define( 'CHS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CHS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once CHS_PLUGIN_DIR . 'includes/class-chs-post-type.php';
require_once CHS_PLUGIN_DIR . 'includes/class-chs-admin.php';
require_once CHS_PLUGIN_DIR . 'includes/class-chs-renderer.php';
require_once CHS_PLUGIN_DIR . 'includes/class-chs-seeder.php';

final class Cloudia_Hero_Slider {
	/**
	 * @var Cloudia_Hero_Slider|null
	 */
	private static $instance = null;

	/**
	 * @var CHS_Renderer
	 */
	private $renderer;

	public static function instance(): Cloudia_Hero_Slider {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		new CHS_Post_Type();
		$this->renderer = new CHS_Renderer();
		new CHS_Seeder();

		if ( is_admin() ) {
			new CHS_Admin();
		}

		add_shortcode( 'cloudia_hero_slider', array( $this, 'shortcode' ) );
	}

	public function shortcode( array $atts ): string {
		$atts = shortcode_atts(
			array(
				'id'    => 0,
				'alias' => '',
				'class' => '',
			),
			$atts,
			'cloudia_hero_slider'
		);

		return $this->renderer->render(
			array(
				'id'    => absint( $atts['id'] ),
				'alias' => sanitize_title( $atts['alias'] ),
				'class' => sanitize_html_class( $atts['class'] ),
			),
			false
		);
	}

	public function renderer(): CHS_Renderer {
		return $this->renderer;
	}
}

register_activation_hook( CHS_PLUGIN_FILE, array( 'CHS_Seeder', 'mark_for_seed' ) );

Cloudia_Hero_Slider::instance();

function cloudia_hero_slider_render( array $args = array(), bool $echo = true ) {
	return Cloudia_Hero_Slider::instance()->renderer()->render( $args, $echo );
}
