<?php
/**
 * Parts-Mall branch importer.
 *
 * Storage choice:
 * - Branches are kept in one option named `partsmall_branch_directory`.
 * - The array is grouped by province, with `Pan-Africa` holding country entries.
 * - Each item carries a stable `slug`, so re-runs update by slug without duplication.
 *
 * Run with:
 * wp eval-file wp-content/themes/parts-mall-theme/dummy-branches.php
 */

if ( ! function_exists( 'update_option' ) ) {
	echo "Parts-Mall branch importer requires WordPress.\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

if ( ! function_exists( 'partsmall_seed_log' ) ) {
	function partsmall_seed_log( string $message ): void {
		if ( defined( 'WP_CLI' ) && WP_CLI && class_exists( '\WP_CLI' ) ) {
			\WP_CLI::log( $message );
		} else {
			echo $message . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

$branches = function_exists( 'partsmall_branch_seed_data' ) ? partsmall_branch_seed_data() : array();
$stored   = get_option( 'partsmall_branch_directory', array() );
$merged   = array();

foreach ( $branches as $province => $items ) {
	$existing = array();
	if ( isset( $stored[ $province ] ) && is_array( $stored[ $province ] ) ) {
		foreach ( $stored[ $province ] as $branch ) {
			if ( ! empty( $branch['slug'] ) ) {
				$existing[ $branch['slug'] ] = $branch;
			}
		}
	}

	foreach ( $items as $branch ) {
		$existing[ $branch['slug'] ] = array_merge( isset( $existing[ $branch['slug'] ] ) ? $existing[ $branch['slug'] ] : array(), $branch );
		partsmall_seed_log( sprintf( 'Prepared %s / %s', $province, $branch['name'] ) );
	}

	$merged[ $province ] = array_values( $existing );
}

update_option( 'partsmall_branch_directory', $merged );
partsmall_seed_log( 'Parts-Mall branches updated.' );
