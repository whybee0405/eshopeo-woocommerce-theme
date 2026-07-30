<?php
/**
 * Open / closed pill.
 *
 * Rendered server-side so it is correct without JavaScript, then refreshed
 * by main.js in case the HTML came out of a full-page cache.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$branch = isset( $args['branch'] ) ? $args['branch'] : null;

if ( ! $branch ) {
	return;
}

$state = kms_branch_status( $branch );
?>
<span
	class="status <?php echo $state['open'] ? 'status--open' : 'status--closed'; ?>"
	data-branch-status="<?php echo esc_attr( $branch['slug'] ); ?>"
>
	<span class="status__dot" aria-hidden="true"></span>
	<span data-status-label><?php echo esc_html( $state['label'] ); ?></span>
	<?php if ( '' !== $state['detail'] ) : ?>
		<span class="status__detail" data-status-detail><?php echo esc_html( $state['detail'] ); ?></span>
	<?php endif; ?>
</span>
