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

$container = get_theme_mod( 'understrap_container_type' );

$q_obj_trans = get_queried_object();
$q_obj = kyrya_default_language_term($q_obj_trans);
$pt = get_post_type();

$meta = get_fields($q_obj);

// $logo = $meta['logo'];
$logo = false;
$miniatura = $meta['miniatura'];
$esquema = $meta['esquema'];
$opciones_productos = isset($meta['opciones_de_producto']) ? $meta['opciones_de_producto'] : false;
$acabados = isset($meta['acabados']) ? $meta['acabados'] : false;

$columnas = array('titulo');
if ($miniatura) $columnas[] = $miniatura;
// if ($opciones_productos) $columnas[] = $opciones_productos;
if ($esquema) $columnas[] = $esquema;

$deep_subterms = isset($meta['deep_subterms']) ? $meta['deep_subterms'] : false;

switch ( count($columnas) ) {
	case 1:
		$col1_class = 'col-12';
		break;
	case 2:
		// if ( $opciones_productos ) {
		// 	$col1_class = 'col-sm-8';
		// 	$col2_class = 'col-sm-4';
		// } else {
			$col1_class = 'col-sm-4';
			$col2_class = 'col-sm-8';
			$col3_class = 'col-sm-8';
		// }
		break;
	case 3:
		$col1_class = 'col-sm-4';
		$col2_class = 'col-sm-4';
		$col3_class = 'col-sm-4';
		break;
	case 4:
		$col1_class = 'col-sm-3';
		$col2_class = 'col-sm-3';
		$col3_class = 'col-sm-3';
		$col4_class = 'col-sm-4';
		break;
	default: 
		$col1_class = 'col-12';
		$col2_class = 'col-sm-3';
		$col3_class = 'col-sm-3';
		$col4_class = 'col-sm-4';
		break;
}
$mostrar_productos = true;

?>

<?php if ( es_composicion($pt) )  echo slider_destacados( $pt, $q_obj ); ?>

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
					if ($logo) {
						echo wp_get_attachment_image( $logo['id'], 'medium' );
					} else {
						echo '<div class="row align-items-center">';
							echo '<div class="col-sm-6 col-md-8">';
								echo '<h1 class="page-title mb-0 me-3 '. $q_obj->taxonomy .'">' . single_term_title('', false) . '</h1>';
							echo '</div>';
							echo '<div class="col-sm-6 col-md-4 text-sm-end">';
								smn_back_button();
							echo '</div>';
						echo '</div>';
					}
					?>

					<?php opciones_de_producto($opciones_productos); ?>

				</header>

				<div class="row mt-3 mb-3 cabecera-term align-items-start">

					<div class="<?php echo $col1_class; ?> col1">
						

							<?php $description = get_the_archive_description();
							if ('' != $description) {

								$no_collapse = get_field( 'no_description_collapse', $q_obj_trans );
								if ( $no_collapse ) {
									echo do_shortcode ( '<div class="taxonomy-description">' . $description . '</div>' );
								} else {
									echo '<div class="collapse" id="collapse-description">';
									echo do_shortcode ( '<div class="taxonomy-description">' . $description . '</div>' );
									echo '</div>';

									echo '<p><a class="description-more-info" data-bs-toggle="collapse" href="#collapse-description" role="button" aria-expanded="false" aria-controls="collapse-description"><i class="fa fa-info-circle"></i> '.__( 'Más información', 'kyrya' ).' <i class="fa fa-chevron-down girar"></i></a><p>';
								}

							}
							?>

					</div>

					<?php if ($miniatura || $acabados) { ?>
						<div class="<?php echo $col2_class; ?> col2">
							<div class="imagen-term miniatura">
								<?php echo wp_get_attachment_image( $miniatura['id'], 'medium_large' ); ?>
							</div>
						</div>
					<?php }

					if ($esquema) { ?>
						<div class="<?php echo $col3_class; ?> col3">
							<div class="imagen-term esquema">
								<?php echo wp_get_attachment_image( $esquema['id'], 'medium_large' ); ?>
							</div>
						</div>
					<?php } ?>

				</div>

				<?php 
					$args_subterms = array(
							'taxonomy'		=> $q_obj->taxonomy,
							'parent'		=> $q_obj_trans->term_id,
							'hide_empty'	=> true,
							'exclude' => array($q_obj_trans->term_id),
						);
					$subterms = get_terms( $args_subterms);
					if ('composicion' == $pt && !empty($subterms) ) $mostrar_productos = false;

					$related_terms = get_field( 'related_terms', $q_obj_trans );

					if ( $related_terms ) {
						smn_subterm_buttons( $related_terms, $q_obj_trans );
					// } elseif( empty($subterms) ) {
					} else {
						if ( have_posts() && !$mostrar_productos ) {
							smn_subterm_buttons( $subterms, $q_obj_trans );
						}
					}
				?>

				<?php  ?>

				<?php if ( have_posts() && $mostrar_productos ) { ?>

					<div class="row no-gutters g-2 mb-5 pb-5 bloques" id="productos">
	
						<?php
						// Start the loop.
						while ( have_posts() ) {
							the_post();

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
						} ?>
					
					</div>

				<?php } ?>

				<?php 
						// $args_subterms = array(
						// 		'taxonomy'		=> $q_obj->taxonomy,
						// 		'parent'		=> $q_obj->term_id,
						// 		'hide_empty'	=> true,
						// 	);
						// $subterms = get_terms( $args_subterms);
						if (!empty($subterms)) {
							// array_unshift( $subterms, $q_obj);
							if (have_posts()) {
								// echo '<h4><a class="btn btn-secondary" href="#productos">' . __( 'Ver productos', 'kyrya' ) . '</a></h4>';
								echo '<h2 class="mt-5 pt-5">' . sprintf( __( 'Más en %s', 'smn'), $q_obj_trans->name ) . '</h2>';
							}
							// $mostrar_productos = false;
							echo '<div class="row no-gutters g-2 mb-3 bloques" id="subcategorias">';
							foreach ($subterms as $term) {

								if ( $deep_subterms ) {

									echo '<div class="col-12">';
										echo '<h3 class="mt-4 is-style-lined">' . $term->name . '</h3>';
									echo '</div>';

									$args_deep_subterms = array(
										'taxonomy'		=> $q_obj->taxonomy,
										'parent'		=> $term->term_id,
										'hide_empty'	=> true,
									);
									$deep_subterms = get_terms( $args_deep_subterms);

									foreach ($deep_subterms as $term) {
										include( locate_template ( 'loop-templates/content-subterm.php' ) );
									}

								} else {
									include( locate_template ( 'loop-templates/content-subterm.php' ) );
								}

							}
							echo '</div>';
						}
						

					?>

				<?php composiciones_ejemplo(); ?>

				<?php if ( have_posts() && $mostrar_productos ) {
					smn_back_button(); 
				} ?>

				<?php // echo get_tax_navigation( $q_obj->taxonomy ); ?>

			</main>

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
