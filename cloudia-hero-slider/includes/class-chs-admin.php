<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHS_Admin {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ) );
		add_action( 'save_post_cloudia_slider', array( $this, 'save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		add_filter( 'enter_title_here', array( $this, 'title_placeholder' ), 10, 2 );
		add_filter( 'wp_insert_post_data', array( $this, 'sync_alias' ), 10, 2 );
	}

	public function title_placeholder( string $text, WP_Post $post ): string {
		if ( 'cloudia_slider' === $post->post_type ) {
			return __( 'Slider module name', 'cloudia-hero-slider' );
		}

		return $text;
	}

	public function assets( string $hook ): void {
		$screen = get_current_screen();
		if ( ! $screen || 'cloudia_slider' !== $screen->post_type ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_style( 'chs-admin', CHS_PLUGIN_URL . 'assets/admin.css', array(), CHS_VERSION );
		wp_enqueue_script( 'chs-admin', CHS_PLUGIN_URL . 'assets/admin.js', array( 'jquery', 'jquery-ui-sortable' ), CHS_VERSION, true );
	}

	public function meta_boxes(): void {
		add_meta_box(
			'chs_slides',
			__( 'Slides', 'cloudia-hero-slider' ),
			array( $this, 'slides_box' ),
			'cloudia_slider',
			'normal',
			'high'
		);

		add_meta_box(
			'chs_settings',
			__( 'Module Settings', 'cloudia-hero-slider' ),
			array( $this, 'settings_box' ),
			'cloudia_slider',
			'normal',
			'default'
		);

		add_meta_box(
			'chs_embed',
			__( 'Embed', 'cloudia-hero-slider' ),
			array( $this, 'embed_box' ),
			'cloudia_slider',
			'side',
			'default'
		);

		add_meta_box(
			'chs_module_identity',
			__( 'Module Identity', 'cloudia-hero-slider' ),
			array( $this, 'identity_box' ),
			'cloudia_slider',
			'side',
			'high'
		);
	}

	public function slides_box( WP_Post $post ): void {
		$slides = get_post_meta( $post->ID, '_chs_slides', true );
		$slides = is_array( $slides ) ? array_values( $slides ) : array();
		wp_nonce_field( 'chs_save_slider', 'chs_nonce' );
		?>
		<div class="chs-editor" data-chs-editor>
			<div class="chs-editor__sidebar">
				<div class="chs-editor__sidebar-head">
					<strong><?php esc_html_e( 'Slide List', 'cloudia-hero-slider' ); ?></strong>
					<div class="chs-editor__sidebar-actions">
						<button type="button" class="button" data-chs-open-presets><?php esc_html_e( 'Presets', 'cloudia-hero-slider' ); ?></button>
						<button type="button" class="button button-primary" data-chs-add-slide><?php esc_html_e( 'Add Slide', 'cloudia-hero-slider' ); ?></button>
					</div>
				</div>
				<div class="chs-preset-bar" data-chs-preset-bar hidden>
					<button type="button" class="button" data-chs-preset="branch"><?php esc_html_e( 'Branch CTA', 'cloudia-hero-slider' ); ?></button>
					<button type="button" class="button" data-chs-preset="wholesale"><?php esc_html_e( 'Wholesale', 'cloudia-hero-slider' ); ?></button>
					<button type="button" class="button" data-chs-preset="campaign"><?php esc_html_e( 'Campaign', 'cloudia-hero-slider' ); ?></button>
				</div>
				<ul class="chs-slide-list" data-chs-slide-list>
					<?php foreach ( $slides as $index => $slide ) : ?>
						<li class="chs-slide-list__item" data-chs-slide-tab="<?php echo esc_attr( (string) $index ); ?>">
							<span class="dashicons dashicons-menu"></span>
							<span class="chs-slide-list__label"><?php echo esc_html( ! empty( $slide['heading'] ) ? $slide['heading'] : sprintf( __( 'Slide %d', 'cloudia-hero-slider' ), $index + 1 ) ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="chs-editor__main" data-chs-slide-panels>
				<?php
				if ( empty( $slides ) ) {
					$slides[] = array();
				}
				foreach ( $slides as $index => $slide ) :
					$this->slide_panel( $index, $slide );
				endforeach;
				?>
			</div>
		</div>

		<script type="text/template" id="chs-slide-template">
			<?php
			ob_start();
			$this->slide_panel( '__index__', array() );
			echo str_replace( array( "\r", "\n" ), '', ob_get_clean() );
			?>
		</script>
		<?php
	}

	private function slide_panel( $index, array $slide ): void {
		$badge_label         = isset( $slide['badge_label'] ) ? $slide['badge_label'] : '';
		$eyebrow             = isset( $slide['eyebrow'] ) ? $slide['eyebrow'] : '';
		$heading             = isset( $slide['heading'] ) ? $slide['heading'] : '';
		$body                = isset( $slide['body'] ) ? $slide['body'] : '';
		$cta_label           = isset( $slide['cta_label'] ) ? $slide['cta_label'] : '';
		$cta_url             = isset( $slide['cta_url'] ) ? $slide['cta_url'] : '';
		$secondary_cta_label = isset( $slide['secondary_cta_label'] ) ? $slide['secondary_cta_label'] : '';
		$secondary_cta_url   = isset( $slide['secondary_cta_url'] ) ? $slide['secondary_cta_url'] : '';
		$text_align          = isset( $slide['text_align'] ) ? $slide['text_align'] : 'inherit';
		$image_id            = isset( $slide['image_id'] ) ? absint( $slide['image_id'] ) : 0;
		$mobile_image_id     = isset( $slide['mobile_image_id'] ) ? absint( $slide['mobile_image_id'] ) : 0;
		$is_active           = ! isset( $slide['is_active'] ) || ! empty( $slide['is_active'] );
		$image_url           = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
		$mobile_url          = $mobile_image_id ? wp_get_attachment_image_url( $mobile_image_id, 'medium' ) : '';
		?>
		<div class="chs-slide-panel" data-chs-slide-panel data-index="<?php echo esc_attr( (string) $index ); ?>">
			<div class="chs-slide-panel__head">
				<strong><?php esc_html_e( 'Slide Content', 'cloudia-hero-slider' ); ?></strong>
				<button type="button" class="button" data-chs-duplicate-slide><?php esc_html_e( 'Duplicate Slide', 'cloudia-hero-slider' ); ?></button>
				<button type="button" class="button-link-delete" data-chs-remove-slide><?php esc_html_e( 'Remove', 'cloudia-hero-slider' ); ?></button>
			</div>
			<div class="chs-slide-preview" data-chs-slide-preview>
				<div class="chs-slide-preview__media" data-chs-preview-media>
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" alt="">
					<?php else : ?>
						<span><?php esc_html_e( 'No desktop image selected', 'cloudia-hero-slider' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="chs-slide-preview__body" data-chs-preview-align="<?php echo esc_attr( $text_align ); ?>">
					<div class="chs-slide-preview__meta">
						<?php if ( $badge_label ) : ?>
							<span class="chs-slide-preview__badge" data-chs-preview-badge><?php echo esc_html( $badge_label ); ?></span>
						<?php endif; ?>
						<span class="chs-slide-preview__status<?php echo $is_active ? ' is-active' : ''; ?>" data-chs-preview-status>
							<?php echo $is_active ? esc_html__( 'Active', 'cloudia-hero-slider' ) : esc_html__( 'Inactive', 'cloudia-hero-slider' ); ?>
						</span>
					</div>
					<p class="chs-slide-preview__eyebrow" data-chs-preview-eyebrow><?php echo esc_html( $eyebrow ? $eyebrow : __( 'Eyebrow text', 'cloudia-hero-slider' ) ); ?></p>
					<h3 class="chs-slide-preview__heading" data-chs-preview-heading><?php echo esc_html( $heading ? $heading : __( 'Slide heading', 'cloudia-hero-slider' ) ); ?></h3>
					<p class="chs-slide-preview__copy" data-chs-preview-body><?php echo esc_html( $body ? $body : __( 'Short supporting copy appears here.', 'cloudia-hero-slider' ) ); ?></p>
					<div class="chs-slide-preview__actions">
						<span class="chs-slide-preview__button" data-chs-preview-primary><?php echo esc_html( $cta_label ? $cta_label : __( 'Primary CTA', 'cloudia-hero-slider' ) ); ?></span>
						<span class="chs-slide-preview__button is-secondary" data-chs-preview-secondary><?php echo esc_html( $secondary_cta_label ? $secondary_cta_label : __( 'Secondary CTA', 'cloudia-hero-slider' ) ); ?></span>
					</div>
				</div>
			</div>
			<div class="chs-field-grid">
				<p>
					<label><?php esc_html_e( 'Badge Label', 'cloudia-hero-slider' ); ?></label>
					<input type="text" class="widefat" data-chs-slide-badge name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][badge_label]" value="<?php echo esc_attr( $badge_label ); ?>">
				</p>
				<p>
					<label><?php esc_html_e( 'Eyebrow', 'cloudia-hero-slider' ); ?></label>
					<input type="text" class="widefat" data-chs-slide-eyebrow name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][eyebrow]" value="<?php echo esc_attr( $eyebrow ); ?>">
				</p>
				<p>
					<label><?php esc_html_e( 'Heading', 'cloudia-hero-slider' ); ?></label>
					<input type="text" class="widefat" data-chs-slide-heading name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][heading]" value="<?php echo esc_attr( $heading ); ?>">
				</p>
				<p>
					<label><?php esc_html_e( 'Text Alignment', 'cloudia-hero-slider' ); ?></label>
					<select class="widefat" data-chs-slide-align name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][text_align]">
						<option value="inherit" <?php selected( $text_align, 'inherit' ); ?>><?php esc_html_e( 'Inherit module setting', 'cloudia-hero-slider' ); ?></option>
						<option value="left" <?php selected( $text_align, 'left' ); ?>><?php esc_html_e( 'Left', 'cloudia-hero-slider' ); ?></option>
						<option value="center" <?php selected( $text_align, 'center' ); ?>><?php esc_html_e( 'Center', 'cloudia-hero-slider' ); ?></option>
					</select>
				</p>
				<p class="chs-field-grid__full">
					<label><?php esc_html_e( 'Short Text', 'cloudia-hero-slider' ); ?></label>
					<textarea class="widefat" rows="4" data-chs-slide-body name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][body]"><?php echo esc_textarea( $body ); ?></textarea>
				</p>
				<div class="chs-fieldset">
					<div class="chs-fieldset__head">
						<strong><?php esc_html_e( 'Primary CTA', 'cloudia-hero-slider' ); ?></strong>
						<span><?php esc_html_e( 'Main action button', 'cloudia-hero-slider' ); ?></span>
					</div>
					<div class="chs-fieldset__grid">
						<p>
							<label><?php esc_html_e( 'Label', 'cloudia-hero-slider' ); ?></label>
							<input type="text" class="widefat" data-chs-slide-primary-label name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][cta_label]" value="<?php echo esc_attr( $cta_label ); ?>">
						</p>
						<p>
							<label><?php esc_html_e( 'URL', 'cloudia-hero-slider' ); ?></label>
							<input type="url" class="widefat" name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][cta_url]" value="<?php echo esc_attr( $cta_url ); ?>">
						</p>
					</div>
				</div>
				<div class="chs-fieldset">
					<div class="chs-fieldset__head">
						<strong><?php esc_html_e( 'Secondary CTA', 'cloudia-hero-slider' ); ?></strong>
						<span><?php esc_html_e( 'Optional outline button', 'cloudia-hero-slider' ); ?></span>
					</div>
					<div class="chs-fieldset__grid">
						<p>
							<label><?php esc_html_e( 'Label', 'cloudia-hero-slider' ); ?></label>
							<input type="text" class="widefat" data-chs-slide-secondary-label name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][secondary_cta_label]" value="<?php echo esc_attr( $secondary_cta_label ); ?>">
						</p>
						<p>
							<label><?php esc_html_e( 'URL', 'cloudia-hero-slider' ); ?></label>
							<input type="url" class="widefat" name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][secondary_cta_url]" value="<?php echo esc_attr( $secondary_cta_url ); ?>">
						</p>
					</div>
				</div>
				<div class="chs-media-field" data-chs-media-role="desktop">
					<label><?php esc_html_e( 'Desktop Image', 'cloudia-hero-slider' ); ?></label>
					<input type="hidden" name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][image_id]" value="<?php echo esc_attr( (string) $image_id ); ?>" data-chs-media-id>
					<div class="chs-media-preview" data-chs-media-preview>
						<?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" alt=""><?php endif; ?>
					</div>
					<div class="chs-media-actions">
						<button type="button" class="button" data-chs-media-open><?php esc_html_e( 'Choose Image', 'cloudia-hero-slider' ); ?></button>
						<button type="button" class="button-link-delete" data-chs-media-clear><?php esc_html_e( 'Clear', 'cloudia-hero-slider' ); ?></button>
					</div>
				</div>
				<div class="chs-media-field" data-chs-media-role="mobile">
					<label><?php esc_html_e( 'Mobile Image', 'cloudia-hero-slider' ); ?></label>
					<input type="hidden" name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][mobile_image_id]" value="<?php echo esc_attr( (string) $mobile_image_id ); ?>" data-chs-media-id>
					<div class="chs-media-preview" data-chs-media-preview>
						<?php if ( $mobile_url ) : ?><img src="<?php echo esc_url( $mobile_url ); ?>" alt=""><?php endif; ?>
					</div>
					<div class="chs-media-actions">
						<button type="button" class="button" data-chs-media-open><?php esc_html_e( 'Choose Image', 'cloudia-hero-slider' ); ?></button>
						<button type="button" class="button-link-delete" data-chs-media-clear><?php esc_html_e( 'Clear', 'cloudia-hero-slider' ); ?></button>
					</div>
				</div>
				<p class="chs-field-grid__full">
					<label><input type="checkbox" data-chs-slide-active name="chs_slides[<?php echo esc_attr( (string) $index ); ?>][is_active]" value="1" <?php checked( $is_active ); ?>> <?php esc_html_e( 'Slide active', 'cloudia-hero-slider' ); ?></label>
				</p>
			</div>
		</div>
		<?php
	}

	public function settings_box( WP_Post $post ): void {
		$defaults = CHS_Renderer::default_settings();
		$settings = get_post_meta( $post->ID, '_chs_settings', true );
		$settings = wp_parse_args( is_array( $settings ) ? $settings : array(), $defaults );
		?>
		<div class="chs-settings-grid">
			<div class="chs-settings-group">
				<h3><?php esc_html_e( 'Module', 'cloudia-hero-slider' ); ?></h3>
				<p>
					<label><?php esc_html_e( 'Module Type', 'cloudia-hero-slider' ); ?></label>
					<select class="widefat" name="chs_settings[module_type]">
						<option value="hero" <?php selected( $settings['module_type'], 'hero' ); ?>><?php esc_html_e( 'Hero', 'cloudia-hero-slider' ); ?></option>
						<option value="slider" <?php selected( $settings['module_type'], 'slider' ); ?>><?php esc_html_e( 'Slider', 'cloudia-hero-slider' ); ?></option>
					</select>
				</p>
				<p>
					<label><?php esc_html_e( 'Content Alignment', 'cloudia-hero-slider' ); ?></label>
					<select class="widefat" name="chs_settings[content_align]">
						<option value="left" <?php selected( $settings['content_align'], 'left' ); ?>><?php esc_html_e( 'Left', 'cloudia-hero-slider' ); ?></option>
						<option value="center" <?php selected( $settings['content_align'], 'center' ); ?>><?php esc_html_e( 'Center', 'cloudia-hero-slider' ); ?></option>
					</select>
				</p>
				<p>
					<label><?php esc_html_e( 'Autoplay Delay (ms)', 'cloudia-hero-slider' ); ?></label>
					<input type="number" class="widefat" min="2000" step="500" name="chs_settings[delay]" value="<?php echo esc_attr( (string) $settings['delay'] ); ?>">
				</p>
				<p>
					<label><?php esc_html_e( 'Overlay Opacity (0-90)', 'cloudia-hero-slider' ); ?></label>
					<input type="number" class="widefat" min="0" max="90" name="chs_settings[overlay_opacity]" value="<?php echo esc_attr( (string) $settings['overlay_opacity'] ); ?>">
				</p>
				<p><label><input type="checkbox" name="chs_settings[autoplay]" value="1" <?php checked( ! empty( $settings['autoplay'] ) ); ?>> <?php esc_html_e( 'Autoplay', 'cloudia-hero-slider' ); ?></label></p>
				<p><label><input type="checkbox" name="chs_settings[show_arrows]" value="1" <?php checked( ! empty( $settings['show_arrows'] ) ); ?>> <?php esc_html_e( 'Show Arrows', 'cloudia-hero-slider' ); ?></label></p>
				<p><label><input type="checkbox" name="chs_settings[show_dots]" value="1" <?php checked( ! empty( $settings['show_dots'] ) ); ?>> <?php esc_html_e( 'Show Dots', 'cloudia-hero-slider' ); ?></label></p>
			</div>
			<div class="chs-settings-group">
				<h3><?php esc_html_e( 'Responsive Breakpoints', 'cloudia-hero-slider' ); ?></h3>
				<div class="chs-settings-columns">
					<p>
						<label><?php esc_html_e( 'Wide Screen From (px)', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="1240" max="2800" name="chs_settings[breakpoint_wide]" value="<?php echo esc_attr( (string) $settings['breakpoint_wide'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Desktop From (px)', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="960" max="1639" name="chs_settings[breakpoint_desktop]" value="<?php echo esc_attr( (string) $settings['breakpoint_desktop'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Notebook From (px)', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="778" max="1239" name="chs_settings[breakpoint_notebook]" value="<?php echo esc_attr( (string) $settings['breakpoint_notebook'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Tablet From (px)', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="640" max="1023" name="chs_settings[breakpoint_tablet]" value="<?php echo esc_attr( (string) $settings['breakpoint_tablet'] ); ?>">
					</p>
				</div>
			</div>
			<div class="chs-settings-group">
				<h3><?php esc_html_e( 'Viewport Heights', 'cloudia-hero-slider' ); ?></h3>
				<div class="chs-settings-columns">
					<p>
						<label><?php esc_html_e( 'Wide Screen Height', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="360" max="1400" name="chs_settings[height_wide]" value="<?php echo esc_attr( (string) $settings['height_wide'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Desktop Height', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="320" max="1200" name="chs_settings[height_desktop]" value="<?php echo esc_attr( (string) $settings['height_desktop'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Notebook Height', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="300" max="1000" name="chs_settings[height_notebook]" value="<?php echo esc_attr( (string) $settings['height_notebook'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Tablet Height', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="280" max="900" name="chs_settings[height_tablet]" value="<?php echo esc_attr( (string) $settings['height_tablet'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Mobile Height', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="240" max="800" name="chs_settings[height_mobile]" value="<?php echo esc_attr( (string) $settings['height_mobile'] ); ?>">
					</p>
				</div>
			</div>
			<div class="chs-settings-group">
				<h3><?php esc_html_e( 'Content Widths', 'cloudia-hero-slider' ); ?></h3>
				<div class="chs-settings-columns">
					<p>
						<label><?php esc_html_e( 'Wide Screen Width', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="960" max="1800" name="chs_settings[content_width_wide]" value="<?php echo esc_attr( (string) $settings['content_width_wide'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Desktop Width', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="860" max="1500" name="chs_settings[content_width_desktop]" value="<?php echo esc_attr( (string) $settings['content_width_desktop'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Notebook Width', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="720" max="1200" name="chs_settings[content_width_notebook]" value="<?php echo esc_attr( (string) $settings['content_width_notebook'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Tablet Width', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="560" max="900" name="chs_settings[content_width_tablet]" value="<?php echo esc_attr( (string) $settings['content_width_tablet'] ); ?>">
					</p>
					<p>
						<label><?php esc_html_e( 'Mobile Width', 'cloudia-hero-slider' ); ?></label>
						<input type="number" class="widefat" min="280" max="680" name="chs_settings[content_width_mobile]" value="<?php echo esc_attr( (string) $settings['content_width_mobile'] ); ?>">
					</p>
				</div>
			</div>
		</div>
		<?php
	}

	public function embed_box( WP_Post $post ): void {
		$alias = $post->post_name ? $post->post_name : sanitize_title( $post->post_title );
		?>
		<p><strong><?php esc_html_e( 'Shortcode', 'cloudia-hero-slider' ); ?></strong></p>
		<code>[cloudia_hero_slider id="<?php echo esc_attr( (string) $post->ID ); ?>"]</code>
		<p><code>[cloudia_hero_slider alias="<?php echo esc_attr( $alias ); ?>"]</code></p>
		<p><strong><?php esc_html_e( 'PHP', 'cloudia-hero-slider' ); ?></strong></p>
		<code>&lt;?php cloudia_hero_slider_render( array( 'alias' =&gt; '<?php echo esc_html( $alias ); ?>' ) ); ?&gt;</code>
		<?php
	}

	public function identity_box( WP_Post $post ): void {
		$alias = $post->post_name ? $post->post_name : sanitize_title( $post->post_title );
		?>
		<p>
			<label for="chs_alias"><strong><?php esc_html_e( 'Alias', 'cloudia-hero-slider' ); ?></strong></label>
			<input type="text" id="chs_alias" class="widefat" name="chs_alias" value="<?php echo esc_attr( $alias ); ?>" pattern="[a-z0-9\-]+" spellcheck="false">
		</p>
		<p class="description"><?php esc_html_e( 'Use lowercase letters, numbers, and hyphens for shortcode and PHP embeds.', 'cloudia-hero-slider' ); ?></p>
		<?php
	}

	public function save( int $post_id ): void {
		if ( ! isset( $_POST['chs_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['chs_nonce'] ) ), 'chs_save_slider' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$slides = isset( $_POST['chs_slides'] ) && is_array( $_POST['chs_slides'] ) ? wp_unslash( $_POST['chs_slides'] ) : array();
		$clean  = array();
		foreach ( $slides as $slide ) {
			if ( ! is_array( $slide ) ) {
				continue;
			}
			$clean[] = array(
				'badge_label'     => sanitize_text_field( isset( $slide['badge_label'] ) ? $slide['badge_label'] : '' ),
				'eyebrow'         => sanitize_text_field( isset( $slide['eyebrow'] ) ? $slide['eyebrow'] : '' ),
				'heading'         => sanitize_text_field( isset( $slide['heading'] ) ? $slide['heading'] : '' ),
				'body'            => sanitize_textarea_field( isset( $slide['body'] ) ? $slide['body'] : '' ),
				'cta_label'       => sanitize_text_field( isset( $slide['cta_label'] ) ? $slide['cta_label'] : '' ),
				'cta_url'         => esc_url_raw( isset( $slide['cta_url'] ) ? $slide['cta_url'] : '' ),
				'secondary_cta_label' => sanitize_text_field( isset( $slide['secondary_cta_label'] ) ? $slide['secondary_cta_label'] : '' ),
				'secondary_cta_url' => esc_url_raw( isset( $slide['secondary_cta_url'] ) ? $slide['secondary_cta_url'] : '' ),
				'text_align'      => in_array( isset( $slide['text_align'] ) ? $slide['text_align'] : 'inherit', array( 'inherit', 'left', 'center' ), true ) ? $slide['text_align'] : 'inherit',
				'image_id'        => absint( isset( $slide['image_id'] ) ? $slide['image_id'] : 0 ),
				'mobile_image_id' => absint( isset( $slide['mobile_image_id'] ) ? $slide['mobile_image_id'] : 0 ),
				'is_active'       => ! empty( $slide['is_active'] ) ? 1 : 0,
			);
		}
		update_post_meta( $post_id, '_chs_slides', $clean );

		$defaults = CHS_Renderer::default_settings();
		$raw      = isset( $_POST['chs_settings'] ) && is_array( $_POST['chs_settings'] ) ? wp_unslash( $_POST['chs_settings'] ) : array();
		$settings = array(
			'module_type'    => in_array( isset( $raw['module_type'] ) ? $raw['module_type'] : 'hero', array( 'hero', 'slider' ), true ) ? $raw['module_type'] : 'hero',
			'breakpoint_wide' => max( 1240, min( 2800, absint( isset( $raw['breakpoint_wide'] ) ? $raw['breakpoint_wide'] : $defaults['breakpoint_wide'] ) ) ),
			'breakpoint_desktop' => max( 960, min( 1639, absint( isset( $raw['breakpoint_desktop'] ) ? $raw['breakpoint_desktop'] : $defaults['breakpoint_desktop'] ) ) ),
			'breakpoint_notebook' => max( 778, min( 1239, absint( isset( $raw['breakpoint_notebook'] ) ? $raw['breakpoint_notebook'] : $defaults['breakpoint_notebook'] ) ) ),
			'breakpoint_tablet' => max( 640, min( 1023, absint( isset( $raw['breakpoint_tablet'] ) ? $raw['breakpoint_tablet'] : $defaults['breakpoint_tablet'] ) ) ),
			'height_wide'    => max( 360, min( 1400, absint( isset( $raw['height_wide'] ) ? $raw['height_wide'] : $defaults['height_wide'] ) ) ),
			'height_desktop' => max( 320, min( 1200, absint( isset( $raw['height_desktop'] ) ? $raw['height_desktop'] : $defaults['height_desktop'] ) ) ),
			'height_notebook' => max( 300, min( 1000, absint( isset( $raw['height_notebook'] ) ? $raw['height_notebook'] : $defaults['height_notebook'] ) ) ),
			'height_tablet'  => max( 280, min( 900, absint( isset( $raw['height_tablet'] ) ? $raw['height_tablet'] : $defaults['height_tablet'] ) ) ),
			'height_mobile'  => max( 240, min( 800, absint( isset( $raw['height_mobile'] ) ? $raw['height_mobile'] : $defaults['height_mobile'] ) ) ),
			'content_width_wide' => max( 960, min( 1800, absint( isset( $raw['content_width_wide'] ) ? $raw['content_width_wide'] : $defaults['content_width_wide'] ) ) ),
			'content_width_desktop' => max( 860, min( 1500, absint( isset( $raw['content_width_desktop'] ) ? $raw['content_width_desktop'] : $defaults['content_width_desktop'] ) ) ),
			'content_width_notebook' => max( 720, min( 1200, absint( isset( $raw['content_width_notebook'] ) ? $raw['content_width_notebook'] : $defaults['content_width_notebook'] ) ) ),
			'content_width_tablet' => max( 560, min( 900, absint( isset( $raw['content_width_tablet'] ) ? $raw['content_width_tablet'] : $defaults['content_width_tablet'] ) ) ),
			'content_width_mobile' => max( 280, min( 680, absint( isset( $raw['content_width_mobile'] ) ? $raw['content_width_mobile'] : $defaults['content_width_mobile'] ) ) ),
			'delay'          => max( 2000, absint( isset( $raw['delay'] ) ? $raw['delay'] : $defaults['delay'] ) ),
			'overlay_opacity'=> max( 0, min( 90, absint( isset( $raw['overlay_opacity'] ) ? $raw['overlay_opacity'] : $defaults['overlay_opacity'] ) ) ),
			'content_align'  => in_array( isset( $raw['content_align'] ) ? $raw['content_align'] : 'left', array( 'left', 'center' ), true ) ? $raw['content_align'] : 'left',
			'autoplay'       => ! empty( $raw['autoplay'] ) ? 1 : 0,
			'show_arrows'    => ! empty( $raw['show_arrows'] ) ? 1 : 0,
			'show_dots'      => ! empty( $raw['show_dots'] ) ? 1 : 0,
		);
		$settings['breakpoint_desktop'] = min( $settings['breakpoint_desktop'], $settings['breakpoint_wide'] - 1 );
		$settings['breakpoint_notebook'] = min( $settings['breakpoint_notebook'], $settings['breakpoint_desktop'] - 1 );
		$settings['breakpoint_tablet'] = min( $settings['breakpoint_tablet'], $settings['breakpoint_notebook'] - 1 );
		update_post_meta( $post_id, '_chs_settings', $settings );
	}

	public function sync_alias( array $data, array $postarr ): array {
		if ( empty( $data['post_type'] ) || 'cloudia_slider' !== $data['post_type'] ) {
			return $data;
		}

		if ( isset( $_POST['chs_alias'] ) ) {
			$alias = sanitize_title( wp_unslash( $_POST['chs_alias'] ) );
			if ( '' !== $alias ) {
				$data['post_name'] = $alias;
			}
		}

		return $data;
	}
}
