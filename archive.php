<?php
/**
 * The template for displaying archive pages
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$pt = get_post_type();
$pto = get_post_type_object( $pt );
$mostrar_productos = true;

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="main">

				<header class="page-header">

					<?php
					echo '<h1 class="page-title">' . get_the_archive_title() . '</h1>';
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>

				</header>

				<?php 

				if ( 'producto' == $pt ) {
				
					foreach ($pto->taxonomies as $tax) {
						$terms_args = array(
								'hide_empty'			=> true,
								'taxonomy'				=> $tax,
								'parent'				=> 0,
							);
						$terms = get_terms($terms_args);
						if (!empty($terms)) {
							$mostrar_productos = false;

							$col_class = 'col-md-3';
							switch (count($terms)) {
								case 1:
									$col_class = 'col-md-12';
									break;
								case 2:
									$col_class = 'col-md-6';
									break;
								case 3:
								case 6:
								case 9:
									$col_class = 'col-md-4';
									break;

								default:
									$col_class = 'col-md-3';
									break;
							}
							$col_class .= ' col-sm-12';



							echo '<div class="row no-gutters g-2 mt-3 mb-10 bloques">';

								foreach ($terms as $term) {
									include( locate_template ( 'loop-templates/content-term.php' ) );
								}
							echo '</div>';
						}


					} 
				
				}
				
				?>

				<?php if ($mostrar_productos) :

					if ( have_posts() ) : ?>


						<div class="row no-gutters g-2 mb-5 pb-5 bloques">
							
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>

								<?php

								/*
								* Include the Post-Format-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Format name) and that will be used instead.
								*/
								if ('post' == get_post_type()) {
									get_template_part( 'loop-templates/content', 'single-loop' );
								} else {
									get_template_part( 'loop-templates/content', get_post_format() );
								}
								?>

							<?php endwhile; ?>
						</div>

					<?php else : ?>

						<?php get_template_part( 'loop-templates/content', 'none' ); ?>

					<?php endif; ?>
				<?php endif; ?>

			</main><!-- #main -->

			<?php
			// Display the pagination component.
			understrap_pagination();

			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();
