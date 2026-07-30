<?php
/**
 * 404.
 *
 * Paid traffic lands on odd URLs when a campaign is misconfigured, so this
 * page still offers both branches rather than a dead end.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="section is-ink">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Page not found', 'kms-branch' ); ?></p>
		<h1 class="h2 closer__title"><?php esc_html_e( 'That page has moved off the shelf', 'kms-branch' ); ?></h1>
		<p class="lede" style="margin-bottom:2rem;">
			<?php esc_html_e( 'Pick a branch and we will help you from there.', 'kms-branch' ); ?>
		</p>
		<div class="closer__actions">
			<?php foreach ( kms_branch() as $branch ) : ?>
				<a class="btn btn--lg" href="<?php echo esc_url( kms_branch_url( $branch['slug'] ) ); ?>">
					<?php echo esc_html( $branch['name'] ); ?>
					<?php kms_icon( 'arrow', array( 'size' => 18 ) ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
