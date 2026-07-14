<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHS_Post_Type {
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
		add_filter( 'manage_cloudia_slider_posts_columns', array( $this, 'columns' ) );
		add_action( 'manage_cloudia_slider_posts_custom_column', array( $this, 'render_column' ), 10, 2 );
		add_filter( 'post_row_actions', array( $this, 'row_actions' ), 10, 2 );
		add_filter( 'views_edit-cloudia_slider', array( $this, 'views' ) );
		add_action( 'admin_action_chs_duplicate_slider', array( $this, 'duplicate_slider' ) );
	}

	public function register(): void {
		$labels = array(
			'name'               => __( 'Hero Sliders', 'cloudia-hero-slider' ),
			'singular_name'      => __( 'Hero Slider', 'cloudia-hero-slider' ),
			'add_new'            => __( 'Add Slider', 'cloudia-hero-slider' ),
			'add_new_item'       => __( 'Add New Hero Slider', 'cloudia-hero-slider' ),
			'edit_item'          => __( 'Edit Hero Slider', 'cloudia-hero-slider' ),
			'new_item'           => __( 'New Hero Slider', 'cloudia-hero-slider' ),
			'view_item'          => __( 'View Hero Slider', 'cloudia-hero-slider' ),
			'search_items'       => __( 'Search Hero Sliders', 'cloudia-hero-slider' ),
			'not_found'          => __( 'No hero sliders found.', 'cloudia-hero-slider' ),
			'not_found_in_trash' => __( 'No hero sliders found in Trash.', 'cloudia-hero-slider' ),
			'menu_name'          => __( 'Cloudia Hero Slider', 'cloudia-hero-slider' ),
		);

		register_post_type(
			'cloudia_slider',
			array(
				'labels'              => $labels,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 59,
				'menu_icon'           => 'dashicons-images-alt2',
				'supports'            => array( 'title', 'revisions' ),
				'show_in_rest'        => false,
				'capability_type'     => 'post',
				'has_archive'         => false,
				'rewrite'             => false,
				'exclude_from_search' => true,
			)
		);
	}

	public function columns( array $columns ): array {
		unset( $columns['date'] );
		$columns['title']       = __( 'Module', 'cloudia-hero-slider' );
		$columns['alias']       = __( 'Alias', 'cloudia-hero-slider' );
		$columns['module_type'] = __( 'Type', 'cloudia-hero-slider' );
		$columns['slide_count'] = __( 'Slides', 'cloudia-hero-slider' );
		$columns['status']      = __( 'Status', 'cloudia-hero-slider' );
		$columns['updated']     = __( 'Updated', 'cloudia-hero-slider' );
		return $columns;
	}

	public function render_column( string $column, int $post_id ): void {
		if ( 'alias' === $column ) {
			$post = get_post( $post_id );
			if ( $post ) {
				echo '<code>' . esc_html( $post->post_name ) . '</code>';
			}
			return;
		}

		if ( 'module_type' === $column ) {
			$settings = get_post_meta( $post_id, '_chs_settings', true );
			$type     = is_array( $settings ) && ! empty( $settings['module_type'] ) ? $settings['module_type'] : 'hero';
			echo esc_html( ucfirst( $type ) );
			return;
		}

		if ( 'slide_count' === $column ) {
			$slides = get_post_meta( $post_id, '_chs_slides', true );
			$slides = is_array( $slides ) ? $slides : array();
			$count  = count( $slides );
			$active = $this->count_active_slides( $slides );
			echo esc_html( sprintf( __( '%1$d total / %2$d live', 'cloudia-hero-slider' ), $count, $active ) );
			return;
		}

		if ( 'status' === $column ) {
			$slides = get_post_meta( $post_id, '_chs_slides', true );
			$slides = is_array( $slides ) ? $slides : array();

			if ( 0 === $this->count_active_slides( $slides ) ) {
				echo '<span class="chs-admin-chip is-draft">' . esc_html__( 'No live slides', 'cloudia-hero-slider' ) . '</span>';
			} else {
				echo '<span class="chs-admin-chip is-live">' . esc_html__( 'Ready', 'cloudia-hero-slider' ) . '</span>';
			}
			return;
		}

		if ( 'updated' === $column ) {
			echo esc_html( get_the_modified_date( 'Y-m-d H:i', $post_id ) );
		}
	}

	public function row_actions( array $actions, WP_Post $post ): array {
		if ( 'cloudia_slider' !== $post->post_type || ! current_user_can( 'edit_post', $post->ID ) ) {
			return $actions;
		}

		$url = wp_nonce_url(
			admin_url( 'admin.php?action=chs_duplicate_slider&post=' . $post->ID ),
			'chs_duplicate_slider_' . $post->ID
		);

		$actions['chs_duplicate'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Duplicate', 'cloudia-hero-slider' ) . '</a>';
		return $actions;
	}

	public function views( array $views ): array {
		$all_posts = get_posts(
			array(
				'post_type'      => 'cloudia_slider',
				'post_status'    => array( 'publish', 'draft' ),
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		$total_modules = count( $all_posts );
		$total_slides  = 0;
		$total_live    = 0;

		foreach ( $all_posts as $post_id ) {
			$slides = get_post_meta( $post_id, '_chs_slides', true );
			$slides = is_array( $slides ) ? $slides : array();
			$total_slides += count( $slides );
			$total_live   += $this->count_active_slides( $slides );
		}

		$views['chs_summary'] = '<span class="chs-list-summary">' . esc_html( sprintf( __( '%1$d modules, %2$d slides, %3$d live', 'cloudia-hero-slider' ), $total_modules, $total_slides, $total_live ) ) . '</span>';
		return $views;
	}

	public function duplicate_slider(): void {
		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( esc_html__( 'You are not allowed to duplicate this slider.', 'cloudia-hero-slider' ) );
		}

		check_admin_referer( 'chs_duplicate_slider_' . $post_id );

		$post = get_post( $post_id );
		if ( ! $post instanceof WP_Post || 'cloudia_slider' !== $post->post_type ) {
			wp_die( esc_html__( 'Slider not found.', 'cloudia-hero-slider' ) );
		}

		$new_id = wp_insert_post(
			array(
				'post_type'   => 'cloudia_slider',
				'post_status' => 'draft',
				'post_title'  => $post->post_title . ' ' . __( '(Copy)', 'cloudia-hero-slider' ),
				'post_name'   => wp_unique_post_slug( sanitize_title( $post->post_name . '-copy' ), 0, 'draft', 'cloudia_slider', 0 ),
			),
			true
		);

		if ( is_wp_error( $new_id ) || ! $new_id ) {
			wp_die( esc_html__( 'Could not duplicate the slider.', 'cloudia-hero-slider' ) );
		}

		$slides   = get_post_meta( $post_id, '_chs_slides', true );
		$settings = get_post_meta( $post_id, '_chs_settings', true );
		update_post_meta( $new_id, '_chs_slides', is_array( $slides ) ? $slides : array() );
		update_post_meta( $new_id, '_chs_settings', is_array( $settings ) ? $settings : array() );

		wp_safe_redirect(
			add_query_arg(
				array(
					'post'   => $new_id,
					'action' => 'edit',
				),
				admin_url( 'post.php' )
			)
		);
		exit;
	}

	private function count_active_slides( array $slides ): int {
		return count(
			array_filter(
				$slides,
				static function ( $slide ) {
					return ! isset( $slide['is_active'] ) || ! empty( $slide['is_active'] );
				}
			)
		);
	}
}
