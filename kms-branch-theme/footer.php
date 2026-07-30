<?php
/**
 * Site footer and the sticky mobile action bar.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$kms_here     = kms_current_branch();
$kms_branches = kms_branch();
?>
</main>

<footer class="footer">
	<div class="wrap">
		<div class="footer__grid">
			<div>
				<div class="footer__logo">
					<?php
					kms_image(
						array(
							'file'   => 'kms-logo.png',
							'alt'    => __( 'Korean Motor Spares', 'kms-branch' ),
							'width'  => 499,
							'height' => 63,
							'sizes'  => '200px',
						)
					);
					?>
				</div>
				<p class="small muted" style="margin-top:1rem;max-width:38ch;">
					<?php esc_html_e( 'Trusted spares distributors for Korean vehicles since 1996. Hyundai, Kia, Daewoo and SsangYong parts, held on the shelf and priced for the trade.', 'kms-branch' ); ?>
				</p>
			</div>

			<?php foreach ( $kms_branches as $kms_b ) : ?>
				<div>
					<h2 class="footer__heading"><?php echo esc_html( $kms_b['full_name'] ); ?></h2>
					<ul class="footer__list">
						<li>
							<a href="<?php echo esc_url( kms_branch_maps_url( $kms_b ) ); ?>" rel="noopener" target="_blank">
								<?php echo esc_html( kms_branch_address( $kms_b ) ); ?>
							</a>
						</li>
						<li>
							<a class="tnum" href="<?php echo esc_url( kms_tel_url( $kms_b ) ); ?>">
								<?php echo esc_html( $kms_b['phone'] ); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( kms_whatsapp_url( $kms_b ) ); ?>" rel="noopener" target="_blank">
								<?php esc_html_e( 'WhatsApp this branch', 'kms-branch' ); ?>
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( kms_branch_url( $kms_b['slug'] ) ); ?>">
								<?php
								/* translators: %s: branch name */
								printf( esc_html__( '%s branch page', 'kms-branch' ), esc_html( $kms_b['name'] ) );
								?>
							</a>
						</li>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="footer__legal">
			<?php
			printf(
				/* translators: 1: current year, 2: opening anchor tag, 3: closing anchor tag */
				esc_html__( '%1$s Korean Motor Spares. Powered by Auto Korea CC. Part of the national Korean Motor Spares group, %2$skoreanmotor.co.za%3$s.', 'kms-branch' ),
				'&copy; ' . esc_html( gmdate( 'Y' ) ),
				'<a href="https://www.koreanmotor.co.za/" rel="noopener" target="_blank">',
				'</a>'
			);
			?>
		</p>
	</div>
</footer>

<?php if ( $kms_here ) : ?>
	<div class="actionbar">
		<p class="actionbar__branch">
			<?php
			/* translators: %s: branch name */
			printf( esc_html__( '%s branch', 'kms-branch' ), esc_html( $kms_here['name'] ) );
			?>
		</p>
		<a class="btn btn--wa" href="<?php echo esc_url( kms_whatsapp_url( $kms_here ) ); ?>" rel="noopener" target="_blank">
			<?php kms_icon( 'whatsapp', array( 'size' => 20 ) ); ?>
			<?php esc_html_e( 'WhatsApp', 'kms-branch' ); ?>
		</a>
		<a class="btn" href="<?php echo esc_url( kms_tel_url( $kms_here ) ); ?>">
			<?php kms_icon( 'phone', array( 'size' => 20 ) ); ?>
			<?php esc_html_e( 'Call', 'kms-branch' ); ?>
		</a>
	</div>
<?php else : ?>
	<div class="actionbar actionbar--single">
		<a class="btn btn--wa" href="#branches">
			<?php kms_icon( 'whatsapp', array( 'size' => 20 ) ); ?>
			<?php esc_html_e( 'WhatsApp your nearest branch', 'kms-branch' ); ?>
		</a>
	</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
