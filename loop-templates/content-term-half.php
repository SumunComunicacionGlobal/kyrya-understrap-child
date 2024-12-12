<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

$titulo = '';
$id = 0;
$subtitulo = '';
$subtitulo_numero = '';
$logo = '';
$fondo = '';
$clases = '';
$ocultar_titulo = false;
$aparecer = ' aparecer';

if ( is_a($term, 'WP_Term') ) {
	$post_meta = get_fields($term);
	$default_term = kyrya_default_language_term($term);
	$default_post_meta = get_fields( $default_term );
	$titulo = $term->name;
	$id = $term->term_id;
	
	// $logo = get_field('logo', $term);
	// $subtitulo = get_field('subtitulo', $term);
	// $fondo = get_field('fondo', $term);

	// $logo = $post_meta['logo'];
	$subtitulo = $post_meta['subtitulo'];
	$fondo = (isset($post_meta['fondo']) && '' != $post_meta['fondo']) ? $post_meta['fondo'] : $default_post_meta['fondo'];

	if ( $fondo) {
		$thumb_url = $fondo['sizes']['large'];
	} else {
		$thumb_url = get_primera_imagen_fondo_fallback($term);
	}

	$clases = $term->taxonomy;
	$link = get_term_link($term);
	$target = '';
} elseif ( is_a($term, 'WP_Post') ) {
	$titulo = $term->post_title;
	$id = $term->ID;
	$post_meta = get_fields($term);
	// if (isset($post_meta['logo_miniatura'])) $logo = $post_meta['logo_miniatura'];
	if (isset($post_meta['subtitulo'])) $subtitulo = $post_meta['subtitulo'];
	if (isset($post_meta['subtitulo_numero'])) {
		$subtitulo_numero = $post_meta['subtitulo_numero'];
		$titulo = $subtitulo_numero . '. ' . $titulo;
	}
	if (isset($post_meta['fondo'])) {
		$thumb_url = $post_meta['fondo']['sizes']['large'];
	} else {
		$thumb_url = get_the_post_thumbnail_url( $term, 'large' );
	}
	$clases = '';
	// if (isset($col_class)) $clases .= $col_class;

	if (isset($link_externo) && '' != $link_externo) {
		$link = $link_externo;
	} else {
		$link = get_the_permalink( $term->ID );
	}
	if (isset($target) && 1 == $target) {
		$target = 'target="_blank"';
	} else {
		$target = '';
	}
	if (isset($post_meta['ocultar_titulo']) && $post_meta['ocultar_titulo'] == 1) $ocultar_titulo = true;
}

?>

<article class="box col-md-6 term term-half <?php echo $clases . $aparecer; ?>" id="term-<?php echo $id; ?>">
		<a class="no-underline" href="<?php echo $link; ?>" <?php echo $target; ?> title="<?php echo $titulo; ?>">
			<div class="hover-zoom">
				<div class="miniatura bg-cover" style="background-image:url('<?php echo $thumb_url; ?>');"></div>
				<div class="box-content overlay overlay-full">
					<!-- <span class="subtitulo-term subtitulo-numero"><?php echo $subtitulo_numero; ?></span> -->
					<?php if (!$ocultar_titulo) {
						echo '<h2>'.$titulo.'</h2>';
					} 
					// if ('' != $logo) echo wp_get_attachment_image( $logo['id'], 'medium', false, array('class' => 'aligncenter logo-miniatura') );
					?>

					<span class="subtitulo-term"><?php echo $subtitulo; ?></span>
				</div>

			</div>
		</a>

</article>
