<?php
/**
 * Template name: Archivo
 */

get_header();

$post_type = 'producto';
$post_type_meta = get_post_meta($post->ID, 'archivo', true);
if ($post_type_meta && '' != $post_type_meta) $post_type = $post_type_meta;

$pto = get_post_type_object( $post_type );
$mostrar_productos = true;
$es_carrusel = false;
// $botones = '';

$taxonomies = $pto->taxonomies;
if ( 'composicion' == $post_type ) {
	$taxonomies = array('coleccion');
}

$container   = get_theme_mod( 'understrap_container_type' );

if (es_composicion($post_type) && COLECCIONES_ID != $post->ID && ESTRUCTURAS_ID != 	$post->ID ) echo slider_destacados($post_type, false);
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php 
				the_title(
					'<header class="entry-header"><h1 class="entry-title">',
					'</h1></header><!-- .entry-header -->'
				);
				?>

				<?php the_content(); ?>

			<?php endwhile; // end of the loop. ?>

				<?php foreach ($taxonomies as $tax) {
					$columnas = ($tax == 'coleccion') ? 5 : 4;
					$terms_args = array(
							'hide_empty'			=> false,
							'taxonomy'				=> $tax,
							'parent'				=> 0,
						);

					if (isset($_GET['ac'])) {
						$terms_args['include'] = $_GET['ac'];
					}

					$terms = get_terms($terms_args);
					if (!empty($terms)) {
						// if (count($terms) > $columnas) $es_carrusel = true;
						$es_carrusel = false;
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

						/*if ($es_carrusel) echo '<div class="mt-3 mb-10 bloques">';
						else */echo '<div class="row no-gutters g-2 mt-3 mb-10 bloques columnas-'.$columnas.'">';

							$i = 0; // contador parcial
							$j = 0; // contador total
							if ($es_carrusel) {
								echo '<div id="terms-carousel" class="carousel slide w-100 ms-auto me-auto '.$tax.'" data-bs-ride="carousel" data-bs-interval="3000" data-bs-type="multi">';
								echo '<div class="carousel-inner w-100" role="listbox">';
								// $indicators = '<div class="carousel-indicators">';
							}

							foreach ($terms as $term) {

								$active = '';
								if ($es_carrusel) {
									if ($j == 0) $active = ' active';
									echo '<div class="carousel-item'.$active.'">';
									// $indicators .= '<li data-bs-target="#terms-carousel" data-bs-slide-to="'.$j.'" class="'.$active.'"></li>';
								}

								if ('producto' == $post_type || 'acabado' == $post_type) {
									include( locate_template ( 'loop-templates/content-subterm.php' ) );
								} elseif('apertura' == $post_type) {
									include( locate_template ( 'loop-templates/content-term-half.php' ) );
								} else {
									include( locate_template ( 'loop-templates/content-term.php' ) );
								}
								if ($es_carrusel) {
									echo '</div>';
								}

								// $botones .= '<a class="btn btn-secondary me-1 mb-1" href="'.get_term_link( $term ).'" title="'.$term->name.'">'.$term->name.'</a>';

								$i++;
								$j++;
							}

							if ( $es_carrusel ) {
								// $indicators .= '</ol>';
								// echo $indicators;
								echo '<div class="carousel-item"><article class="box col-md-3 col-sm-12 term clone"><span class="h3 rotado text-primary">'.$pto->labels->name.'</span></article></div>';

								echo '</div>';
								echo '<a class="carousel-control-prev link link--arrowed" href="#terms-carousel" data-bs-slide="prev">' . flecha_animada('#666', 'izquierda') . '</a>';
								echo '<a class="carousel-control-next link link--arrowed" href="#terms-carousel" data-bs-slide="next">' . flecha_animada('#666', 'derecha') . '</a>';

								echo '</div>'; ?>
								
								<script type="text/javascript">

									jQuery(document).ready(function($) {

										var breakpoint = 768;

										function iniciar_carrusel() {
											if ($(window).width() < breakpoint ) {
												$('.carousel[data-bs-type="multi"]').carousel('pause');
											} else {
												$('.carousel[data-bs-type="multi"]').carousel('cycle');
											}
										}


										$('.carousel[data-bs-type="multi"] .carousel-item').each(function(){
										    var next = $(this).next();
										    if (!next.length) {
										    	next = $(this).siblings(':first');
										    }
										    next.children(':first-child').clone().appendTo($(this)).addClass('clone');
										    
										    for (var i=0;i<2;i++) {
										        next=next.next();
										        if (!next.length) {
										        	next = $(this).siblings(':first');
										      	}
										        
										        next.children(':first-child').clone().appendTo($(this)).addClass('clone');
										      }
										});

										// iniciar_carrusel();

										$(window).on("resize load", function() {
											iniciar_carrusel();
										});
									});
								</script>
							<?php }

						echo '</div>';
					}
				}

				// if ( '' != $botones ) echo '<div class="botones-terms mb-10">' . $botones . '</div>';

				if ($mostrar_productos) {
					$posts_args = array(
							'post_type'			=> $post_type,
							'posts_per_page'	=> -1,
						);
					$posts_query = new WP_Query($posts_args);

					if ($posts_query->have_posts()) { ?>

						<div class="row no-gutters g-2 mt-3 mb-10 bloques">

						<?php while ($posts_query->have_posts()) { $posts_query->the_post();
							get_template_part( 'loop-templates/content', get_post_format() );
						} ?>

						</div>
					<?php }

					wp_reset_postdata();
				}

				?>

			</main><!-- #main -->

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
