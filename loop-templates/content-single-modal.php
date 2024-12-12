<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

$post_type = $post->post_type;

$tax = false;
if ( 'composicion' == $post_type ) {
	$tax = 'coleccion';
}
$excerpt = ( '' != $post->post_excerpt ) ? do_shortcode($post->post_excerpt) . ' - ' : '';
$titulo = '<h1 class="entry-title">' . $excerpt . get_the_title() . '</h1>';
$descripcion = apply_filters( 'the_content', $post->post_content );
if ($post_type == 'acabado') {
	// $titulo = '<h1 class="entry-title">' . get_post_field( 'post_excerpt', get_the_ID() ) . '</h1>';
    $default_lang = apply_filters('wpml_default_language', NULL );
    $id = apply_filters( 'wpml_object_id', $id, 'acabado', FALSE, $default_lang );
    $titulo = get_the_title( $id );

	$titulo = '<h1 class="entry-title">' . $titulo . '</h1>';
	$descripcion = '';
}

$post_meta = get_post_meta($post->ID, '');

/*
$plano = (isset($post_meta['plano'])) ? $post_meta['plano'] : false;
$medidas = (isset($post_meta['medidas'])) ? $post_meta['medidas'] : false;
$diametro = (isset($post_meta['diametro'])) ? $post_meta['diametro'] : false;
$opciones_productos = (isset($post_meta['opciones_de_producto'])) ? $post_meta['opciones_de_producto'] : false;
$acabados = (isset($post_meta['acabados_aperturas'])) ? $post_meta['acabados_aperturas'] : false;
$descargas_asociadas = (isset($post_meta['descargas'])) ? $post_meta['descargas'] : false;
*/

$plano = postmeta_variable($post_meta, 'plano');
$referencia = postmeta_variable($post_meta, 'referencia');
$medidas = postmeta_variable($post_meta, 'medidas');
$diametro = postmeta_variable($post_meta, 'diametro');
$ancho = postmeta_variable($post_meta, 'ancho');
$alto = postmeta_variable($post_meta, 'alto');
$fondo = postmeta_variable($post_meta, 'fondo');
$ancho_hasta = postmeta_variable($post_meta, 'ancho_hasta');
$alto_hasta = postmeta_variable($post_meta, 'alto_hasta');
$fondo_hasta = postmeta_variable($post_meta, 'fondo_hasta');
$opciones_productos = postmeta_variable($post_meta, 'opciones_de_producto');
$acabados = postmeta_variable($post_meta, 'acabados_aperturas');
if ( !$acabados ) {
	$acabados = array();
}
$acabados_terms = postmeta_variable($post_meta, 'acabados_aperturas_term');
if ($acabados_terms) {
	$acabados_terms_posts = get_posts(array(
		'post_type' => 'any',
		'tax_query' => array(
			array(
				'taxonomy' => 'categoria_producto',
				'field' => 'term_id',
				'terms' => $acabados_terms,
				'operator' => 'IN',
			),
		),
		'posts_per_page' => -1,
	));

	foreach ($acabados_terms_posts as $a) {
		$acabados[] = $a->ID;
	}
}

if ( current_user_can( 'manage_options' ) ) :
	echo '<pre>test1';
		print_r ( $acabados );
		print_r ( $acabados_terms );
		print_r ( $acabados_terms_posts );
	echo '</pre>';
endif;

if ( $acabados ) {
	$acabados = array_unique($acabados);
}

$url_simulador = postmeta_variable($post_meta, 'url_simulador');


$images = array();
if (has_post_thumbnail()) $images[] = get_post_thumbnail_id();
if ($post_meta) {
	foreach ( $post_meta as $key => $value ) {
		if ( substr( $key, 0, 7 ) === "imagen_" && isset($value[0]) && '' != $value[0] ) {
			$images[] = $value[0];
		}
	}
}

$galeria = postmeta_variable($post_meta, 'galeria');
if ($galeria) {
	$images = array_unique(array_merge($images, $galeria));
}


?>
<div id="modal-ready">

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<div class="mb-5 row">
			<div class="col-md-6 col-lg-7">
					<?php if ( count( $images ) > 1 ) { ?>
						
						<div class="slick-product-slider">
								<?php
									foreach ( $images as $image_id ) {
										echo '<div class="slick-product-slide">';
											echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'mx-auto' ) );
										echo '</div>';
									}
								?>
						</div>

						<?php 
						} else {
							echo wp_get_attachment_image( $images[0], 'large', false, array( 'class' => 'mx-auto' ) );
						}
						?>

					<div class="imagen-plano">
						<?php if( $plano ) echo wp_get_attachment_image( $plano, 'medium_large' ); ?>
					</div>

			</div>
			<div class="col-md-6 col-lg-5">

				<header class="entry-header">

					<?php echo $titulo; ?>

				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php edit_post_link(); ?>
					<?php if (current_user_can( 'edit_posts' )) echo ' / <a href="'.get_the_permalink().'" target="_blank">Ver en nueva pestaña</a>'; ?>
					<p class="dimensiones">
						<?php 

						$medidas_class = 'medidas mb-1';
						$dimensiones_array = array(
							[
								'slug' 			=> 'medidas',
								'label'			=> __( 'Medidas', 'kyrya' ),
								'value'			=> $medidas,
								'class'			=> 'icono ruler me-3'
							],
							[
								'slug' 			=> 'diametro',
								'label'			=> __( 'Ø', 'kyrya' ),
								'value'			=> $diametro,
								'class'			=> ''
							],
							[
								'slug' 			=> 'ancho',
								'label'			=> __( 'Ancho', 'kyrya' ),
								'value'			=> $ancho,
								'class'			=> ''
							],
							[
								'slug' 			=> 'alto',
								'label'			=> __( 'Alto', 'kyrya' ),
								'value'			=> $alto,
								'class'			=> ''
							],
							[
								'slug' 			=> 'fondo',
								'label'			=> __( 'Fondo', 'kyrya' ),
								'value'			=> $fondo,
								'class'			=> ''
							],
							[
								'slug' 			=> 'ancho_hasta',
								'label'			=> __( 'Ancho hasta', 'kyrya' ),
								'value'			=> $ancho_hasta,
								'class'			=> ''
							],
							[
								'slug' 			=> 'alto_hasta',
								'label'			=> __( 'Alto hasta', 'kyrya' ),
								'value'			=> $alto_hasta,
								'class'			=> ''
							],
							[
								'slug' 			=> 'fondo_hasta',
								'label'			=> __( 'Fondo hasta', 'kyrya' ),
								'value'			=> $fondo_hasta,
								'class'			=> ''
							],
						);

						foreach ($dimensiones_array as $dimension) {
							if ($dimension['value']) {
								echo '<p class="'. $medidas_class . ' ' . $dimension['class'] .'"><span class="medidas-label fw-bold">'. $dimension['label'] . ': </span>' . $dimension['value'].'</p>';
							}
						}
						?>
					</p>

					<?php if ( $url_simulador ) {
						echo wpautop( '<a class="btn btn-secondary" href="'. $url_simulador .'" target="_blank" rel="noopener noreferrer">'. __( 'Ver simulador', 'kyrya' ) .'</a>' );
					} ?>

					<div class="mb-5"><?php echo $descripcion; ?></div>

					<?php opciones_de_producto($opciones_productos); ?>

					<?php acabados($acabados, get_the_ID()); ?>
					<?php link_contacto(get_queried_object()); ?>
					<?php // descargas_asociadas($descargas_asociadas, get_the_ID()); ?>


				</div><!-- .entry-content -->

			</div>
		</div>

	</article><!-- #post-## -->
	<?php /*if ($tax) { ?>
		<div class="post-navigation row mt-4">
			<?php 
			$prev = get_adjacent_post( true, '', true, $tax );
			$next = get_adjacent_post( true, '', false, $tax );
			echo '<div class="col-6 text-left">';
				if ($prev) echo '<a data-bs-toggle="modal" data-bs-target="#modal-ajax-post" class="h6 no-underline modal-link" href="'.get_permalink( $prev ).'" title="'.$prev->post_title.'">< '.$prev->post_title.'</a>';
			echo '</div>';
			echo '<div class="col-6 text-right">';
				if ($next) echo '<a data-bs-toggle="modal" data-bs-target="#modal-ajax-post" class="h6 right no-underline modal-link" href="'.get_permalink( $next ).'" title="'.$next->post_title.'">'.$next->post_title.' ></a>';
			echo '</div>';
			?>
		</div>
	<?php }*/ ?>

</div>
