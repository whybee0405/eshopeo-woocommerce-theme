<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHS_Renderer {
	public static function default_settings(): array {
		return array(
			'module_type'     => 'hero',
			'breakpoint_wide' => 1240,
			'breakpoint_desktop' => 960,
			'breakpoint_notebook' => 778,
			'breakpoint_tablet' => 640,
			'height_wide'     => 720,
			'height_desktop'  => 620,
			'height_notebook' => 560,
			'height_tablet'   => 520,
			'height_mobile'   => 420,
			'content_width_wide' => 1320,
			'content_width_desktop' => 1180,
			'content_width_notebook' => 960,
			'content_width_tablet' => 720,
			'content_width_mobile' => 560,
			'delay'           => 5000,
			'overlay_opacity' => 56,
			'content_align'   => 'left',
			'autoplay'        => 1,
			'show_arrows'     => 1,
			'show_dots'       => 1,
		);
	}

	public function render( array $args = array(), bool $echo = true ) {
		$post = $this->resolve_slider( $args );
		if ( ! $post ) {
			return '';
		}

		$slides   = get_post_meta( $post->ID, '_chs_slides', true );
		$slides   = is_array( $slides ) ? array_values( array_filter( $slides, array( $this, 'slide_is_active' ) ) ) : array();
		$settings = get_post_meta( $post->ID, '_chs_settings', true );
		$settings = wp_parse_args( is_array( $settings ) ? $settings : array(), self::default_settings() );

		if ( empty( $slides ) ) {
			return '';
		}

		wp_enqueue_style( 'chs-frontend', CHS_PLUGIN_URL . 'assets/frontend.css', array(), CHS_VERSION );
		wp_enqueue_script( 'chs-frontend', CHS_PLUGIN_URL . 'assets/frontend.js', array(), CHS_VERSION, true );

		$class = ! empty( $args['class'] ) ? ' ' . sanitize_html_class( $args['class'] ) : '';
		$style = sprintf(
			'--chs-height-wide:%1$dpx;--chs-height-desktop:%2$dpx;--chs-height-notebook:%3$dpx;--chs-height-tablet:%4$dpx;--chs-height-mobile:%5$dpx;--chs-content-width-wide:%6$dpx;--chs-content-width-desktop:%7$dpx;--chs-content-width-notebook:%8$dpx;--chs-content-width-tablet:%9$dpx;--chs-content-width-mobile:%10$dpx;--chs-overlay-opacity:%11$.2f;',
			(int) $settings['height_wide'],
			(int) $settings['height_desktop'],
			(int) $settings['height_notebook'],
			(int) $settings['height_tablet'],
			(int) $settings['height_mobile'],
			(int) $settings['content_width_wide'],
			(int) $settings['content_width_desktop'],
			(int) $settings['content_width_notebook'],
			(int) $settings['content_width_tablet'],
			(int) $settings['content_width_mobile'],
			max( 0, min( 0.9, ( (int) $settings['overlay_opacity'] ) / 100 ) )
		);

		ob_start();
		?>
		<section class="cloudia-hero-slider<?php echo esc_attr( $class ); ?> chs-align-<?php echo esc_attr( $settings['content_align'] ); ?>" data-chs-slider data-chs-device="desktop" data-autoplay="<?php echo esc_attr( ! empty( $settings['autoplay'] ) ? 'true' : 'false' ); ?>" data-delay="<?php echo esc_attr( (string) (int) $settings['delay'] ); ?>" data-breakpoint-wide="<?php echo esc_attr( (string) (int) $settings['breakpoint_wide'] ); ?>" data-breakpoint-desktop="<?php echo esc_attr( (string) (int) $settings['breakpoint_desktop'] ); ?>" data-breakpoint-notebook="<?php echo esc_attr( (string) (int) $settings['breakpoint_notebook'] ); ?>" data-breakpoint-tablet="<?php echo esc_attr( (string) (int) $settings['breakpoint_tablet'] ); ?>" style="<?php echo esc_attr( $style ); ?>" aria-roledescription="<?php esc_attr_e( 'carousel', 'cloudia-hero-slider' ); ?>">
			<div class="cloudia-hero-slider__viewport">
				<?php foreach ( $slides as $index => $slide ) : ?>
					<?php
					$slide_align      = ! empty( $slide['text_align'] ) && in_array( $slide['text_align'], array( 'left', 'center' ), true ) ? $slide['text_align'] : $settings['content_align'];
					$image_id        = ! empty( $slide['image_id'] ) ? absint( $slide['image_id'] ) : 0;
					$mobile_image_id = ! empty( $slide['mobile_image_id'] ) ? absint( $slide['mobile_image_id'] ) : 0;
					$image_url       = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';
					$mobile_url      = $mobile_image_id ? wp_get_attachment_image_url( $mobile_image_id, 'full' ) : $image_url;
					?>
					<article class="cloudia-hero-slide<?php echo 0 === $index ? ' is-active' : ''; ?> chs-align-<?php echo esc_attr( $slide_align ); ?>" data-chs-slide>
						<div class="cloudia-hero-slide__media">
							<?php if ( $image_url ) : ?>
								<picture>
									<?php if ( $mobile_url ) : ?>
										<source media="(max-width: 767px)" srcset="<?php echo esc_url( $mobile_url ); ?>">
									<?php endif; ?>
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( ! empty( $slide['heading'] ) ? $slide['heading'] : get_the_title( $post ) ); ?>" loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>" decoding="async">
								</picture>
							<?php endif; ?>
							<div class="cloudia-hero-slide__overlay"></div>
						</div>
						<div class="cloudia-hero-slide__inner">
							<div class="cloudia-hero-slide__content">
								<?php if ( ! empty( $slide['badge_label'] ) ) : ?>
									<p class="cloudia-hero-slide__badge"><?php echo esc_html( $slide['badge_label'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $slide['eyebrow'] ) ) : ?>
									<p class="cloudia-hero-slide__eyebrow"><?php echo esc_html( $slide['eyebrow'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $slide['heading'] ) ) : ?>
									<?php if ( 0 === $index ) : ?>
										<h1 class="cloudia-hero-slide__heading"><?php echo esc_html( $slide['heading'] ); ?></h1>
									<?php else : ?>
										<h2 class="cloudia-hero-slide__heading"><?php echo esc_html( $slide['heading'] ); ?></h2>
									<?php endif; ?>
								<?php endif; ?>
								<?php if ( ! empty( $slide['body'] ) ) : ?>
									<p class="cloudia-hero-slide__body"><?php echo esc_html( $slide['body'] ); ?></p>
								<?php endif; ?>
								<?php if ( ( ! empty( $slide['cta_label'] ) && ! empty( $slide['cta_url'] ) ) || ( ! empty( $slide['secondary_cta_label'] ) && ! empty( $slide['secondary_cta_url'] ) ) ) : ?>
									<div class="cloudia-hero-slide__actions">
										<?php if ( ! empty( $slide['cta_label'] ) && ! empty( $slide['cta_url'] ) ) : ?>
											<a class="cloudia-hero-slide__button" href="<?php echo esc_url( $slide['cta_url'] ); ?>"><?php echo esc_html( $slide['cta_label'] ); ?></a>
										<?php endif; ?>
										<?php if ( ! empty( $slide['secondary_cta_label'] ) && ! empty( $slide['secondary_cta_url'] ) ) : ?>
											<a class="cloudia-hero-slide__button cloudia-hero-slide__button--secondary" href="<?php echo esc_url( $slide['secondary_cta_url'] ); ?>"><?php echo esc_html( $slide['secondary_cta_label'] ); ?></a>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<?php if ( ! empty( $settings['show_arrows'] ) && count( $slides ) > 1 ) : ?>
				<div class="cloudia-hero-slider__arrows">
					<button type="button" class="cloudia-hero-slider__arrow" data-chs-prev aria-label="<?php esc_attr_e( 'Previous slide', 'cloudia-hero-slider' ); ?>">&larr;</button>
					<button type="button" class="cloudia-hero-slider__arrow" data-chs-next aria-label="<?php esc_attr_e( 'Next slide', 'cloudia-hero-slider' ); ?>">&rarr;</button>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $settings['show_dots'] ) && count( $slides ) > 1 ) : ?>
				<div class="cloudia-hero-slider__dots" aria-label="<?php esc_attr_e( 'Hero slide navigation', 'cloudia-hero-slider' ); ?>">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<button type="button" class="cloudia-hero-slider__dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-chs-dot="<?php echo esc_attr( (string) $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'cloudia-hero-slider' ), $index + 1 ) ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $settings['autoplay'] ) && count( $slides ) > 1 ) : ?>
				<div class="cloudia-hero-slider__progress" aria-hidden="true">
					<span class="cloudia-hero-slider__progress-bar" data-chs-progress></span>
				</div>
			<?php endif; ?>
		</section>
		<?php
		$html = ob_get_clean();
		if ( $echo ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		return $html;
	}

	private function slide_is_active( array $slide ): bool {
		return ! isset( $slide['is_active'] ) || ! empty( $slide['is_active'] );
	}

	private function resolve_slider( array $args ) {
		if ( ! empty( $args['id'] ) ) {
			$post = get_post( absint( $args['id'] ) );
			if ( $post instanceof WP_Post && 'cloudia_slider' === $post->post_type && 'publish' === $post->post_status ) {
				return $post;
			}
		}

		if ( ! empty( $args['alias'] ) ) {
			$match = get_posts(
				array(
					'post_type'      => 'cloudia_slider',
					'name'           => sanitize_title( $args['alias'] ),
					'post_status'    => 'publish',
					'posts_per_page' => 1,
				)
			);
			if ( ! empty( $match ) ) {
				return $match[0];
			}
		}

		$fallback = get_posts(
			array(
				'post_type'      => 'cloudia_slider',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
			)
		);

		return ! empty( $fallback ) ? $fallback[0] : null;
	}
}
