<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
$navbar_type       = get_theme_mod( 'understrap_navbar_type', 'collapse' );

$is_landing = false;
$navbar_position_class = 'sticky-top';
if ( is_front_page() ) {
	$navbar_position_class = 'fixed-top';
}
if (is_page_template( 'page-templates/landing.php' )) {
	$is_landing = true;
}


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<?php if (!$is_landing ) { ?>

		<!-- ******************* The Navbar Area ******************* -->
		<header id="wrapper-navbar" class="<?php echo $navbar_position_class; ?>">

			<a class="skip-link <?php echo understrap_get_screen_reader_class( true ); ?>" href="#content">
				<?php esc_html_e( 'Skip to content', 'understrap' ); ?>
			</a>

			<div id="top-bar" class="container-fluid bg-dark">
				<?php kyrya_language_selector(); ?>
			</div>

			<?php get_template_part( 'global-templates/navbar', $navbar_type . '-' . $bootstrap_version ); ?>

		</header><!-- #wrapper-navbar -->

		<?php smn_breadcrumb(); ?>

	<?php } ?>