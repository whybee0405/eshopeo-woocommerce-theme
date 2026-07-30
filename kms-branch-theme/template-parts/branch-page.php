<?php
/**
 * Shared branch page body.
 *
 * Both branch pages render this. The only difference between them is the
 * record passed in, which is what keeps Lenasia and Vereeniging from drifting
 * apart over time.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$branch = isset( $args['branch'] ) ? $args['branch'] : kms_current_branch();

if ( ! $branch ) {
	return;
}

$other = null;
foreach ( kms_branch() as $candidate ) {
	if ( $candidate['slug'] !== $branch['slug'] ) {
		$other = $candidate;
		break;
	}
}
?>

<section class="bhero">
	<div class="wrap bhero__grid">
		<div>
			<h1 class="bhero__title">
				<span><?php esc_html_e( 'Korean Motor Spares', 'kms-branch' ); ?></span>
				<?php echo esc_html( $branch['name'] ); ?>
			</h1>

			<p class="lede bhero__lede"><?php echo esc_html( $branch['lede'] ); ?></p>

			<?php get_template_part( 'template-parts/status', null, array( 'branch' => $branch ) ); ?>

			<div class="bhero__actions" data-actionbar-anchor>
				<a class="btn btn--wa btn--lg" href="<?php echo esc_url( kms_whatsapp_url( $branch ) ); ?>" rel="noopener" target="_blank">
					<?php kms_icon( 'whatsapp', array( 'size' => 20 ) ); ?>
					<?php esc_html_e( 'WhatsApp us', 'kms-branch' ); ?>
				</a>
				<a class="btn btn--ghost btn--lg tnum" href="<?php echo esc_url( kms_tel_url( $branch ) ); ?>">
					<?php kms_icon( 'phone', array( 'size' => 18 ) ); ?>
					<?php echo esc_html( $branch['phone'] ); ?>
				</a>
			</div>
		</div>

		<figure class="bhero__photo reveal">
			<img
				src="<?php echo esc_url( kms_img( 'shopfront.webp' ) ); ?>"
				srcset="<?php echo esc_url( kms_img( 'shopfront.webp' ) ); ?> 600w, <?php echo esc_url( kms_img( 'shopfront@1200.webp' ) ); ?> 765w"
				sizes="(min-width: 58em) 32rem, 92vw"
				alt="<?php esc_attr_e( 'A Korean Motor Spares shopfront: a wide yellow board with the name in blue lettering above the entrance', 'kms-branch' ); ?>"
				width="600"
				height="800"
				loading="lazy"
				decoding="async"
			>
			<figcaption>
				<?php esc_html_e( 'Look for the yellow board. Every Korean Motor Spares counter carries it.', 'kms-branch' ); ?>
			</figcaption>
		</figure>
	</div>
</section>

<div class="wrap">
	<ul class="makes reveal">
		<li class="makes__label"><?php esc_html_e( 'We carry', 'kms-branch' ); ?></li>
		<?php foreach ( kms_makes() as $i => $make ) : ?>
			<?php if ( $i > 0 ) : ?>
				<li class="makes__sep" aria-hidden="true"></li>
			<?php endif; ?>
			<li class="makes__item"><?php echo esc_html( $make ); ?></li>
		<?php endforeach; ?>
		<li class="makes__note"><?php esc_html_e( 'Every model', 'kms-branch' ); ?></li>
	</ul>
</div>

<section class="section">
	<div class="wrap">
		<div class="detail">
			<div class="detail__panel reveal">
				<p class="eyebrow"><?php esc_html_e( 'Find us', 'kms-branch' ); ?></p>

				<h2 class="h3" style="margin-bottom:1rem;"><?php echo esc_html( $branch['street'] ); ?></h2>
				<p class="muted" style="margin-bottom:1.5rem;">
					<?php echo esc_html( $branch['suburb'] . ', ' . $branch['city'] . ', ' . $branch['postcode'] ); ?>
				</p>

				<a class="btn btn--ghost" href="<?php echo esc_url( kms_branch_directions_url( $branch ) ); ?>" rel="noopener" target="_blank" style="margin-bottom:2.5rem;">
					<?php kms_icon( 'directions', array( 'size' => 20 ) ); ?>
					<?php esc_html_e( 'Get directions', 'kms-branch' ); ?>
				</a>

				<p class="eyebrow"><?php esc_html_e( 'Trading hours', 'kms-branch' ); ?></p>
				<table class="hours">
					<caption class="visually-hidden">
						<?php
						/* translators: %s: branch name */
						printf( esc_html__( 'Trading hours for the %s branch', 'kms-branch' ), esc_html( $branch['name'] ) );
						?>
					</caption>
					<tbody>
						<?php foreach ( kms_branch_hours_rows( $branch ) as $row ) : ?>
							<tr data-today="<?php echo $row['today'] ? '1' : '0'; ?>">
								<th scope="row"><?php echo esc_html( $row['days'] ); ?></th>
								<td><?php echo esc_html( $row['hours'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<p class="eyebrow"><?php esc_html_e( 'Customers come to us from', 'kms-branch' ); ?></p>
				<ul class="areas">
					<?php foreach ( $branch['area_serves'] as $area ) : ?>
						<li><?php echo esc_html( $area ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="detail__map reveal">
				<iframe
					src="<?php echo esc_url( kms_map_embed( $branch ) ); ?>"
					title="<?php
						/* translators: %s: branch name */
						printf( esc_attr__( 'Map showing the Korean Motor Spares %s branch', 'kms-branch' ), esc_attr( $branch['name'] ) );
					?>"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					allowfullscreen
				></iframe>
			</div>
		</div>
	</div>
</section>

<section class="section is-surface">
	<div class="wrap">
		<div class="sectionhead sectionhead--split reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'On the shelf', 'kms-branch' ); ?></p>
				<h2 class="h2 sectionhead__title">
					<?php
					/* translators: %s: branch name */
					printf( esc_html__( 'What %s stocks', 'kms-branch' ), esc_html( $branch['name'] ) );
					?>
				</h2>
			</div>
			<p class="muted">
				<?php esc_html_e( 'Service and repair parts across all four makes. Anything not held here can usually be pulled from another branch within a day.', 'kms-branch' ); ?>
			</p>
		</div>

		<?php get_template_part( 'template-parts/parts-grid', null, array( 'branch' => $branch ) ); ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="ask">
			<div class="reveal">
				<p class="eyebrow"><?php esc_html_e( 'Before you drive out', 'kms-branch' ); ?></p>
				<h2 class="h2 sectionhead__title" style="margin-bottom:2rem;">
					<?php esc_html_e( 'Check it is in stock first', 'kms-branch' ); ?>
				</h2>

				<ol class="ask__steps">
					<li class="ask__step">
						<p>
							<strong><?php esc_html_e( 'Send the car details.', 'kms-branch' ); ?></strong>
							<?php esc_html_e( 'Make, model and year. If you have the VIN, even better.', 'kms-branch' ); ?>
						</p>
					</li>
					<li class="ask__step">
						<p>
							<strong><?php esc_html_e( 'Send a photo of the old part.', 'kms-branch' ); ?></strong>
							<?php esc_html_e( 'Half the job is identifying it correctly. A picture settles it faster than a description.', 'kms-branch' ); ?>
						</p>
					</li>
					<li class="ask__step">
						<p>
							<strong><?php esc_html_e( 'We confirm and price it.', 'kms-branch' ); ?></strong>
							<?php esc_html_e( 'Then it is put aside for you and you make one trip instead of two.', 'kms-branch' ); ?>
						</p>
					</li>
				</ol>

				<a class="btn btn--wa btn--lg" href="<?php echo esc_url( kms_whatsapp_url( $branch ) ); ?>" rel="noopener" target="_blank">
					<?php kms_icon( 'whatsapp', array( 'size' => 22 ) ); ?>
					<?php
					/* translators: %s: branch name */
					printf( esc_html__( 'WhatsApp %s', 'kms-branch' ), esc_html( $branch['name'] ) );
					?>
				</a>
			</div>

			<figure class="ask__photo ask__photo--wide reveal">
				<img
					src="<?php echo esc_url( kms_img( 'counter-hands.webp' ) ); ?>"
					srcset="<?php echo esc_url( kms_img( 'counter-hands.webp' ) ); ?> 800w, <?php echo esc_url( kms_img( 'counter-hands@1600.webp' ) ); ?> 1600w"
					sizes="(min-width: 58em) 34rem, 92vw"
					alt="<?php esc_attr_e( 'A water pump and gasket held over a counter beside an oil filter, air filter and spark plugs', 'kms-branch' ); ?>"
					width="800"
					height="533"
					loading="lazy"
					decoding="async"
				>
			</figure>
		</div>
	</div>
</section>

<?php if ( $other ) : ?>
	<section class="section--tight">
		<div class="wrap">
			<div class="crosslink reveal">
				<div class="crosslink__text">
					<h2 class="h4" style="margin-bottom:0.5rem;">
						<?php
						/* translators: %s: other branch name */
						printf( esc_html__( 'Closer to %s?', 'kms-branch' ), esc_html( $other['name'] ) );
						?>
					</h2>
					<p class="small muted"><?php echo esc_html( kms_branch_address( $other ) ); ?></p>
				</div>
				<a class="btn btn--ghost" href="<?php echo esc_url( kms_branch_url( $other['slug'] ) ); ?>">
					<?php
					/* translators: %s: other branch name */
					printf( esc_html__( 'Go to %s', 'kms-branch' ), esc_html( $other['name'] ) );
					?>
					<?php kms_icon( 'arrow', array( 'size' => 18 ) ); ?>
				</a>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section is-ink closer">
	<div class="wrap reveal">
		<h2 class="h2 closer__title">
			<?php
			/* translators: %s: branch name */
			printf( esc_html__( 'Ask %s', 'kms-branch' ), esc_html( $branch['name'] ) );
			?>
		</h2>
		<p class="lede" style="margin-bottom:2rem;">
			<?php esc_html_e( 'Message or call during trading hours and you will speak to someone standing at the counter.', 'kms-branch' ); ?>
		</p>
		<div class="closer__actions">
			<a class="btn btn--wa btn--lg" href="<?php echo esc_url( kms_whatsapp_url( $branch ) ); ?>" rel="noopener" target="_blank">
				<?php kms_icon( 'whatsapp', array( 'size' => 22 ) ); ?>
				<?php esc_html_e( 'WhatsApp', 'kms-branch' ); ?>
			</a>
			<a class="btn btn--ghost btn--lg tnum" href="<?php echo esc_url( kms_tel_url( $branch ) ); ?>">
				<?php kms_icon( 'phone', array( 'size' => 20 ) ); ?>
				<?php echo esc_html( $branch['phone'] ); ?>
			</a>
		</div>
	</div>
</section>
