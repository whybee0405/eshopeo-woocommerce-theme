<?php
/**
 * Search form partial.
 *
 * Scoped to products only via hidden post_type field.
 *
 * @package COVE
 */
defined( 'ABSPATH' ) || exit;
$unique_id = uniqid( 'search-form-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="sr-only" for="<?php echo esc_attr( $unique_id ); ?>">
		<?php esc_html_e( 'Search appliances', 'cove' ); ?>
	</label>
	<div class="cluster" style="gap:var(--s-2)">
		<input
			class="input"
			type="search"
			id="<?php echo esc_attr( $unique_id ); ?>"
			name="s"
			placeholder="<?php esc_attr_e( 'Search appliances&hellip;', 'cove' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			autocomplete="off"
		>
		<input type="hidden" name="post_type" value="product">
		<button class="btn btn--primary" type="submit" aria-label="<?php esc_attr_e( 'Search', 'cove' ); ?>">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			<span class="sr-only"><?php esc_html_e( 'Search', 'cove' ); ?></span>
		</button>
	</div>
</form>
