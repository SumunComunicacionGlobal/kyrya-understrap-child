<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

$the_theme = wp_get_theme();
$is_landing = false;
if (is_page_template( 'page-templates/landing.php' )) {
	$is_landing = true;
}

if ( ! $is_landing ) {
?>

	<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

	<div class="wrapper bg-dark text-light small" id="wrapper-footer">

		<div class="<?php echo esc_attr( $container ); ?>">

			<footer class="site-footer" id="colophon">

				<div class="site-info row">

					<div class="col-md-3 col-xl-2 text-left">
						<strong><?php _e( 'Kyrya', 'kyrya' ); ?></strong> ® Copyright <?php echo date("Y"); ?>
					</div>

					<div class="col-md-6 col-xl-8 text-center">
						<?php wp_nav_menu( array(
							'theme_location'  => 'legal',
							'container'       => 'nav',
							'container_class' => 'navbar navbar-expand',
							'menu_class'      => 'menu navbar-nav flex-wrap justify-content-center',
							'depth'           => 1,
							'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
						) );
						?>
					</div>

					<div class="col-md-3 col-xl-2 text-right">
						<?php dynamic_sidebar( 'footer-right'); ?>
					</div>

				</div><!-- .site-info -->

			</footer><!-- #colophon -->

			<?php kyrya_language_selector(); ?>

		</div><!-- .container(-fluid) -->

	</div><!-- #wrapper-footer -->

	<?php // Closing div#page from header.php. ?>
	</div><!-- #page -->

	<!-- Modal Ajax Post -->
	<div class="modal fade" id="modal-ajax-post">
	  <div class="modal-dialog modal-lg modal-dialog-centered">
	    <div class="modal-content">

	      <div class="modal-header">
			<p class="modal-title">
				<img src="<?php echo get_site_icon_url( 64 ); ?>" alt="Favicon" class="favicon">
			</p>
	        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
	      </div>

	      <div class="modal-body">
	        
	      </div>

	      <div class="modal-footer">
	        <!-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> -->
	      </div>

	    </div>
	  </div>
	</div>

<?php }

	wp_footer(); ?>

	</body>

	</html>

