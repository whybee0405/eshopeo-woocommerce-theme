<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHS_Seeder {
	public function __construct() {
		add_action( 'init', array( $this, 'maybe_seed' ), 30 );
	}

	public static function mark_for_seed(): void {
		update_option( '_chs_seed_pending', 1, false );
	}

	public function maybe_seed(): void {
		if ( ! get_option( '_chs_seed_pending' ) ) {
			return;
		}

		$data = apply_filters( 'cloudia_hero_slider_seed_data', null );
		if ( empty( $data ) || ! is_array( $data ) ) {
			delete_option( '_chs_seed_pending' );
			return;
		}

		$alias = ! empty( $data['alias'] ) ? sanitize_title( $data['alias'] ) : 'homepage-hero';
		$found = get_posts(
			array(
				'post_type'      => 'cloudia_slider',
				'name'           => $alias,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( ! empty( $found ) ) {
			delete_option( '_chs_seed_pending' );
			return;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'   => 'cloudia_slider',
				'post_status' => 'publish',
				'post_title'  => ! empty( $data['title'] ) ? sanitize_text_field( $data['title'] ) : 'Homepage Hero',
				'post_name'   => $alias,
			),
			true
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			return;
		}

		$slides = array();
		if ( ! empty( $data['slides'] ) && is_array( $data['slides'] ) ) {
			foreach ( $data['slides'] as $slide ) {
				if ( ! is_array( $slide ) ) {
					continue;
				}
				$slides[] = array(
					'badge_label'     => sanitize_text_field( isset( $slide['badge_label'] ) ? $slide['badge_label'] : '' ),
					'eyebrow'         => sanitize_text_field( isset( $slide['eyebrow'] ) ? $slide['eyebrow'] : '' ),
					'heading'         => sanitize_text_field( isset( $slide['heading'] ) ? $slide['heading'] : '' ),
					'body'            => sanitize_textarea_field( isset( $slide['body'] ) ? $slide['body'] : '' ),
					'cta_label'       => sanitize_text_field( isset( $slide['cta_label'] ) ? $slide['cta_label'] : '' ),
					'cta_url'         => esc_url_raw( isset( $slide['cta_url'] ) ? $slide['cta_url'] : '' ),
					'secondary_cta_label' => sanitize_text_field( isset( $slide['secondary_cta_label'] ) ? $slide['secondary_cta_label'] : '' ),
					'secondary_cta_url' => esc_url_raw( isset( $slide['secondary_cta_url'] ) ? $slide['secondary_cta_url'] : '' ),
					'text_align'      => in_array( isset( $slide['text_align'] ) ? $slide['text_align'] : 'inherit', array( 'inherit', 'left', 'center' ), true ) ? $slide['text_align'] : 'inherit',
					'image_id'        => $this->resolve_attachment_id( $slide, 'image' ),
					'mobile_image_id' => $this->resolve_attachment_id( $slide, 'mobile_image' ),
					'is_active'       => isset( $slide['is_active'] ) ? ( ! empty( $slide['is_active'] ) ? 1 : 0 ) : 1,
				);
			}
		}

		$settings = wp_parse_args(
			isset( $data['settings'] ) && is_array( $data['settings'] ) ? $data['settings'] : array(),
			CHS_Renderer::default_settings()
		);

		update_post_meta( $post_id, '_chs_slides', $slides );
		update_post_meta( $post_id, '_chs_settings', $settings );
		delete_option( '_chs_seed_pending' );
	}

	private function resolve_attachment_id( array $slide, string $key ): int {
		$id_key = $key . '_id';
		if ( ! empty( $slide[ $id_key ] ) ) {
			return absint( $slide[ $id_key ] );
		}

		$path_key = $key . '_path';
		if ( empty( $slide[ $path_key ] ) ) {
			return 0;
		}

		$path = wp_normalize_path( (string) $slide[ $path_key ] );
		if ( ! file_exists( $path ) ) {
			return 0;
		}

		$uploads = wp_upload_dir();
		$filename = wp_unique_filename( $uploads['path'], wp_basename( $path ) );
		$target = trailingslashit( $uploads['path'] ) . $filename;

		if ( ! copy( $path, $target ) ) {
			return 0;
		}

		$filetype = wp_check_filetype( $filename, null );
		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => $filetype['type'],
				'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
				'post_status'    => 'inherit',
			),
			$target
		);

		if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
			return 0;
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';
		$metadata = wp_generate_attachment_metadata( $attachment_id, $target );
		if ( ! empty( $metadata ) ) {
			wp_update_attachment_metadata( $attachment_id, $metadata );
		}

		return (int) $attachment_id;
	}
}
