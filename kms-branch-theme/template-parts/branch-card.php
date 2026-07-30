<?php
/**
 * Branch card used by the landing page router.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$branch = isset( $args['branch'] ) ? $args['branch'] : null;

if ( ! $branch ) {
	return;
}
?>
<article class="branchcard reveal">
	<div class="branchcard__head">
		<h3 class="branchcard__name"><?php echo esc_html( $branch['name'] ); ?></h3>
		<?php if ( ! empty( $branch['is_new'] ) ) : ?>
			<p class="branchcard__flag"><?php esc_html_e( 'Newly open', 'kms-branch' ); ?></p>
		<?php endif; ?>
	</div>

	<?php get_template_part( 'template-parts/status', null, array( 'branch' => $branch ) ); ?>

	<div class="branchcard__meta">
		<p class="branchcard__row">
			<?php kms_icon( 'pin', array( 'size' => 18 ) ); ?>
			<a href="<?php echo esc_url( kms_branch_maps_url( $branch ) ); ?>" rel="noopener" target="_blank">
				<?php echo esc_html( kms_branch_address( $branch ) ); ?>
			</a>
		</p>
		<p class="branchcard__row">
			<?php kms_icon( 'phone', array( 'size' => 18 ) ); ?>
			<a class="tnum" href="<?php echo esc_url( kms_tel_url( $branch ) ); ?>">
				<?php echo esc_html( $branch['phone'] ); ?>
			</a>
		</p>
	</div>

	<div class="branchcard__actions">
		<a class="btn btn--wa" href="<?php echo esc_url( kms_whatsapp_url( $branch ) ); ?>" rel="noopener" target="_blank">
			<?php kms_icon( 'whatsapp', array( 'size' => 18 ) ); ?>
			<?php
			/* translators: %s: branch name */
			printf( esc_html__( 'WhatsApp %s', 'kms-branch' ), esc_html( $branch['name'] ) );
			?>
		</a>
		<a class="tlink" href="<?php echo esc_url( kms_branch_url( $branch['slug'] ) ); ?>">
			<?php esc_html_e( 'Branch details', 'kms-branch' ); ?>
			<?php kms_icon( 'arrow', array( 'size' => 16 ) ); ?>
			<span class="visually-hidden">
				<?php
				/* translators: %s: branch name */
				printf( esc_html__( 'for %s', 'kms-branch' ), esc_html( $branch['name'] ) );
				?>
			</span>
		</a>
	</div>
</article>
