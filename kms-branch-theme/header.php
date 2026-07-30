<?php
/**
 * Document head and site header.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$kms_here     = kms_current_branch();
$kms_branches = kms_branch();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<script>document.documentElement.classList.remove('no-js');</script>
</head>

<body <?php body_class( 'has-actionbar' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'kms-branch' ); ?></a>

<header class="header">
	<div class="wrap header__bar">
		<a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Korean Motor Spares, home', 'kms-branch' ); ?>">
			<?php
			kms_image(
				array(
					'file'    => 'kms-logo.png',
					'alt'     => __( 'Korean Motor Spares', 'kms-branch' ),
					'width'   => 499,
					'height'  => 63,
					'loading' => 'eager',
					'sizes'   => '220px',
				)
			);
			?>
		</a>

		<nav class="header__links" aria-label="<?php esc_attr_e( 'Branches', 'kms-branch' ); ?>">
			<?php foreach ( $kms_branches as $kms_b ) : ?>
				<a
					class="header__link"
					href="<?php echo esc_url( kms_branch_url( $kms_b['slug'] ) ); ?>"
					<?php echo ( $kms_here && $kms_here['slug'] === $kms_b['slug'] ) ? 'aria-current="page"' : ''; ?>
				><?php echo esc_html( $kms_b['name'] ); ?></a>
			<?php endforeach; ?>
		</nav>

		<div class="header__actions">
			<?php if ( $kms_here ) : ?>
				<a class="btn btn--wa header__cta" href="<?php echo esc_url( kms_whatsapp_url( $kms_here ) ); ?>" rel="noopener" target="_blank">
					<?php kms_icon( 'whatsapp', array( 'size' => 20 ) ); ?>
					<span class="header__cta-label"><?php esc_html_e( 'WhatsApp', 'kms-branch' ); ?></span>
					<span class="visually-hidden">
						<?php
						/* translators: %s: branch name */
						printf( esc_html__( 'WhatsApp our %s branch, opens WhatsApp', 'kms-branch' ), esc_html( $kms_here['name'] ) );
						?>
					</span>
				</a>
			<?php else : ?>
				<a class="btn btn--wa header__cta" href="#branches">
					<?php kms_icon( 'whatsapp', array( 'size' => 20 ) ); ?>
					<span class="header__cta-label"><?php esc_html_e( 'WhatsApp a branch', 'kms-branch' ); ?></span>
					<span class="visually-hidden"><?php esc_html_e( 'Jump to the branch list', 'kms-branch' ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<nav class="branchtabs" aria-label="<?php esc_attr_e( 'Branches', 'kms-branch' ); ?>">
		<?php foreach ( $kms_branches as $kms_b ) : ?>
			<a
				class="branchtabs__item"
				href="<?php echo esc_url( kms_branch_url( $kms_b['slug'] ) ); ?>"
				<?php echo ( $kms_here && $kms_here['slug'] === $kms_b['slug'] ) ? 'aria-current="page"' : ''; ?>
			><?php echo esc_html( $kms_b['name'] ); ?></a>
		<?php endforeach; ?>
	</nav>
</header>

<main id="main">
