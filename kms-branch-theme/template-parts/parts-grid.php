<?php
/**
 * Parts category grid.
 *
 * The last cell is deliberately not a category: it is the prompt to ask,
 * which is what we actually want people to do. It inverts to dark so it
 * reads as an instruction rather than an eighth product tile.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$branch = isset( $args['branch'] ) ? $args['branch'] : null;
?>
<div class="parts">
	<?php foreach ( kms_part_categories() as $cat ) : ?>
		<article class="part reveal">
			<div class="part__media">
				<img
					src="<?php echo esc_url( kms_img( 'cat-' . $cat['slug'] . '.webp' ) ); ?>"
					srcset="<?php echo esc_url( kms_img( 'cat-' . $cat['slug'] . '.webp' ) ); ?> 420w, <?php echo esc_url( kms_img( 'cat-' . $cat['slug'] . '@840.webp' ) ); ?> 840w"
					sizes="(min-width: 68em) 17rem, (min-width: 44em) 22vw, 45vw"
					alt=""
					width="420"
					height="315"
					loading="lazy"
					decoding="async"
				>
			</div>
			<div class="part__body">
				<h3 class="part__name"><?php echo esc_html( $cat['label'] ); ?></h3>
				<p class="part__blurb"><?php echo esc_html( $cat['blurb'] ); ?></p>
			</div>
		</article>
	<?php endforeach; ?>

	<article class="part part--ask reveal">
		<div class="part__body">
			<h3 class="part__name"><?php esc_html_e( 'Not listed?', 'kms-branch' ); ?></h3>
			<p class="part__blurb">
				<?php esc_html_e( 'The shelves hold far more than this. Send the year, model and part, and we will check.', 'kms-branch' ); ?>
			</p>
			<?php if ( $branch ) : ?>
				<a class="btn btn--wa" href="<?php echo esc_url( kms_whatsapp_url( $branch ) ); ?>" rel="noopener" target="_blank">
					<?php kms_icon( 'whatsapp', array( 'size' => 18 ) ); ?>
					<?php esc_html_e( 'Ask us', 'kms-branch' ); ?>
				</a>
			<?php else : ?>
				<a class="btn btn--wa" href="#branches">
					<?php kms_icon( 'whatsapp', array( 'size' => 18 ) ); ?>
					<?php esc_html_e( 'Ask a branch', 'kms-branch' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</article>
</div>
