<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

$titulo = '';
$id = 0;
$subtitulo = '';
// $logo = '';
$fondo = '';
$clases = '';
$esquema = false;
$bgx = 'center';
$aparecer = ' aparecer';

if (isset($j)) $num_slide = $j + 1;
if (isset($col_class)) $col_classes = $col_class; else $col_classes = 'col-md-3 col-sm-12';

if ( is_a($term, 'WP_Term') ) {
	$post_meta = get_fields($term);
	$default_term = kyrya_default_language_term($term);
	$default_post_meta = get_fields( $default_term );
	// echo '<pre>'; print_r($post_meta); echo '</pre>';
	$titulo = $term->name;
	$id = $term->term_id;
	// $logo = (isset($post_meta['logo'])) ? $post_meta['logo'] : $default_post_meta['logo'];
	$subtitulo = (isset($post_meta['subtitulo'])) ? $post_meta['subtitulo'] : $default_post_meta['subtitulo'];
	$fondo = (isset($post_meta['fondo'])) ? $post_meta['fondo'] : $default_post_meta['fondo'];
	if ( $fondo) {
		$thumb_url = $fondo['sizes']['large'];
	} else {
		$thumb_url = get_primera_imagen_fondo_fallback($term);
	}
	$clases = $term->taxonomy;
	if (isset($num_slide)) {
		if (1 == $num_slide) {
			$clases .= ' ' . 'primera-slide';
		} elseif($num_slide == count($terms)) {
			$clases .= ' ' . 'ultima-slide';
		}
	}
	$link = get_term_link($term);

	$esquema = false;
	if (isset($post_meta['esquema_alt']) && '' != $post_meta['esquema_alt'] ) {
		$esquema = $post_meta['esquema_alt'];
	} elseif (isset($default_post_meta['esquema_alt']) && '' != $default_post_meta['esquema_alt'] ) {
		$esquema = $default_post_meta['esquema_alt'];
	} elseif (isset($post_meta['esquema']) && '' != $post_meta['esquema'] ) {
		$esquema = $post_meta['esquema'];
	} elseif (isset($default_post_meta['esquema']) && '' != $default_post_meta['esquema'] ) {
		$esquema = $default_post_meta['esquema'];
	}

	if (isset($post_meta['background_position_x'])) {
		$bgx = $post_meta['background_position_x'];
	} elseif (isset($default_post_meta['background_position_x'])) {
		$bgx = $default_post_meta['background_position_x'];
	}


} elseif ( is_a($term, 'WP_Post') ) {
	$titulo = $term->post_title;
	$id = $term->ID;
	$post_meta = get_fields($term);
	// if (isset($post_meta['logo'])) $logo = $post_meta['logo'];
	if (isset($post_meta['subtitulo'])) $subtitulo = $post_meta['subtitulo'];
	if (isset($post_meta['fondo'])) {
		$thumb_url = $post_meta['fondo']['sizes']['large'];
	} else {
		$thumb_url = get_the_post_thumbnail_url( $term, 'large' );
	}
	$clases = '';
	$link = get_the_permalink( $term->ID );
}

?>

<article class="box <?php echo $col_classes; ?> term <?php echo $clases . $aparecer; ?>" id="term-<?php echo $id; ?>">
		<a class="no-underline" href="<?php echo $link; ?>" title="<?php echo $titulo; ?>">
			<div class="hover-zoom">
				<div class="miniatura bg-cover" style="background-image:url('<?php echo $thumb_url; ?>'); background-position-x:<?php echo $bgx;?>;"></div>
				<div class="box-content overlay">
					<?php // if (isset($num_slide)) echo '<span class="numero-slide">'.$num_slide.'</span>'; ?>
					<h2><?php echo $titulo; ?></h2>
					<span class="subtitulo-term"><?php echo $subtitulo; ?></span>
					<?php 
					// if ($esquema) {
					// 	echo '<img class="esquema-carrusel" src="' . $esquema['sizes']['thumbnail'] . '" />';
					// } 
					?>
				</div>

			</div>
		</a>

</article>
