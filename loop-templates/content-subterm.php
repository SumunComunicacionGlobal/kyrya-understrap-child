<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */


//$post_meta = get_fields($term);
$post_meta = get_term_meta( $term->term_id );
//echo '<pre>pm1'; print_r($post_meta); echo '</pre>';
//echo '<pre>pm2'; print_r(get_term_meta( $term->term_id )); echo '</pre>';
$default_term = kyrya_default_language_term($term);
//$default_post_meta = get_fields( $default_term );
if ( $default_term && !is_wp_error($default_term) ) {

	$default_post_meta = get_term_meta( $default_term->term_id );
	$post_meta = array_merge($default_post_meta, $post_meta);

}

$aparecer = ' aparecer';

// $logo = (isset($post_meta['logo'])) ? $post_meta['logo'][0] : '';
$subtitulo = (isset($post_meta['subtitulo'])) ? $post_meta['subtitulo'][0] : '';
$fondo = (isset($default_post_meta['fondo']) && '' != $default_post_meta['fondo'][0]) ? $default_post_meta['fondo'][0] : '';
$esquema = false;
if (isset($post_meta['esquema_alt']) && '' != $post_meta['esquema_alt'][0] ) {
	$esquema = $post_meta['esquema_alt'][0];
} elseif (isset($post_meta['esquema']) && '' != $post_meta['esquema'][0] ) {
	$esquema = $post_meta['esquema'][0];
}

//if (!$esquema) { $esquema = $post_meta['esquema'][0]; }

if ( $fondo) {
	//$thumb_url = $fondo['sizes']['large'];
	$thumb_url = wp_get_attachment_image_url( $fondo, 'large' );
} else {
	$thumb_url = get_primera_imagen_fondo_fallback($term);
}


$col_class = 'col-smn-6 col-md-4 col-lg-3';
$ancestors = get_ancestors( $term->term_id, $term->taxonomy, 'taxonomy' );
// print_r($ancestors);
// echo $term->taxonomy;

// if ( count($ancestors) > 0 ) $col_class = 'col-md-3';

$link = get_term_link( $term );
$title = $term->name;
$modal_link = '';

if (is_a($term, 'WP_Term')) {

	$products = get_posts(array(
		'post_type' => 'producto',
		'tax_query' => array(
			array(
				'taxonomy' => $term->taxonomy,
				'field'    => 'term_id',
				'terms'    => $term->term_id,
			),
		),
	));

	if (count($products) == 1) {
		$link = get_permalink($products[0]->ID);
		$title = $products[0]->post_title;
		$modal_link = 'modal-link';
	}
	
}

?>

<article class="box <?php echo $col_class; ?> subterm <?php echo $term->taxonomy . $aparecer; ?>" id="term-<?php echo $term->term_id; ?>">
		<?php //if ($term->count > 0) : ?>
		<a class="no-underline <?php echo $modal_link; ?>" href="<?php echo $link; ?>" title="<?php echo $title; ?>">
		<?php //endif; ?>
			<div class="hover-zoom">
				<div class="miniatura bg-cover" style="background-image:url('<?php echo $thumb_url; ?>');"></div>
				<div class="box-content overlay">
					<h2 class="entry-title titulo-peq"><?php echo $term->name; ?></h2>
					<span class="subtitulo-term"><?php echo $subtitulo; ?></span>
					<?php 
					// if ($esquema)  {
					// 	echo '<img class="esquema-carrusel" src="'. wp_get_attachment_image_url( $esquema, 'thumbnail' ).'" />';
					// } 
					?>
				</div>

			</div>
		<?php //if ($term->count > 0) : ?>
		</a>
		<?php //endif; ?>

</article>
