<?php
/**
 * Template Name: Página de inicio
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

get_header();
$container = get_theme_mod( 'understrap_container_type' );

$video = get_field( 'video_portada' );
$mapa = get_field( 'mapa' );

if (!$video) $video = '<img src="'.get_stylesheet_directory_uri().'/img/foto-mano-agua.jpg" />';
if (!$mapa) $mapa = '<img src="'.get_stylesheet_directory_uri().'/img/mapa-kyrya.jpg" class="imagen-mapa" />';
?>

<div class="" id="full-width-page-wrapper">
	
	<?php // get_template_part( 'global-templates/slider-home', 'bootstrap' ); ?>

	<?php if( INSPIRACION_ID ) : ?>

	<section class="bg-dark py-5">
		<div class="<?php echo esc_attr( $container ); ?> text-center">
			<a class="aparecer btn btn-outline-light btn-lg" href="<?php esc_url( the_permalink( INSPIRACION_ID ) ); ?>" title="<?php echo get_the_title( INSPIRACION_ID ); ?>"><?php echo get_the_title( INSPIRACION_ID ); ?></a>
		</div>
	</section>

	<?php endif; ?>

	<?php get_template_part( 'global-templates/slider-home' ); ?>

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div id="primary">

			<main class="site-main" id="main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

		</div><!-- #primary -->

	</div>

</div><!-- Wrapper end -->

<?php get_footer(); ?>
