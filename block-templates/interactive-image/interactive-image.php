<?php

/**
 * Interactive image Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'interactive-image-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

$imagen = get_field( 'imagen' );
$titulo = get_field( 'titulo' );
?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">

	<?php if ( have_rows( 'puntos') ) { ?>

		<div class="imagen-interactiva__imagen">

			<?php echo wp_get_attachment_image( $imagen, 'full' ); ?>


			<?php if ( $titulo ) { ?>
				<div class="imagen-interactiva__titulo">
					<?php echo $titulo; ?>
				</div>
			<?php } ?>
		
			<?php while ( have_rows( 'puntos' ) ) { the_row();
			
				$term = get_sub_field( 'term' );
				$titulo_punto = get_sub_field( 'titulo_punto' );
				$descripcion_punto = get_sub_field( 'descripcion_punto' );
				$posicion_x = get_sub_field( 'posicion_x' );
				$posicion_y = get_sub_field( 'posicion_y' );
				$link = get_term_link( $term );

				if ( !$titulo_punto ) {
					$titulo_punto = $term->name;
				}

				if ( !$descripcion_punto ) {
					$descripcion_punto = $term->description;
				}

				if ( $link ) {
					$descripcion_punto .= '<a class="btn btn-sm btn-primary" href="' . $link . '">'. __( 'Ver ahora', 'kyrya' ) .'</a>';
				}
				?>

				<a 
					tabindex="0" 
					class="imagen-interactiva__punto btn btn-sm btn-light rounded-circle" 
					role="button" 
					style="left: <?php echo $posicion_x; ?>%; top: <?php echo $posicion_y; ?>%;" 
					data-bs-toggle="popover" 
					data-bs-trigger="focus" 
					data-bs-html="true" 
					data-bs-placement="auto" 
					data-bs-container="body" 
					title="<?php echo $titulo_punto; ?>" 
					data-bs-content="<?php echo esc_html( $descripcion_punto ); ?> "
				>
					<span class="imagen-interactiva__icono"></span>
				</a>

			<?php } ?>


		</div>

	<?php } ?>

</div>