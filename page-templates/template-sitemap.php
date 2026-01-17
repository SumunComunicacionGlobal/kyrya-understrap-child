<?php
/**
 * Template name: Sitemap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>

				<?php endwhile; // end of the loop. ?>


				<?php 
					$array_post_types = get_post_types( array('exclude_from_search' => false), 'objects' );
					unset($array_post_types['attachment']);
					unset($array_post_types['dlm_download']);

					foreach( $array_post_types as $pt ) {

						$posts = get_posts(array(
								'post_type'	=> $pt->name,
								'posts_per_page'	=> 1
							));

						if (!empty($posts)) {
							echo '<div class="sitemap-group">';

							echo '<h3 class="is-style-lined" id="'.$pt->name.'">'.$pt->labels->name.'</h3>';
							echo '<ul class="mb-5">';


							if ( 1 == $pt->hierarchical ) {

								$exclude = get_posts( array(
										'post_type'		=> $pt->name,
										'posts_per_page'	=> -1,
										'fields'			=> 'ids',
										'meta_query' => array(
															array(
																'key'		=> 'sitemap',
																'value'		=> '0',
																'compare'	=> '=',
												)
											),

									) );


								wp_list_pages(array(
									'depth' => 4,
									'sort_column' => 'menu_order',
									'title_li' => '',
									'exclude'	=> implode(',', $exclude),
									));


							} else {

								$taxes = $pt->taxonomies;
								if (!empty($taxes)) {
									$tax = $taxes[0];

								    $terms = get_terms($tax);

									foreach ( $terms as $term ) {
										// Asegúrate de que $term es un objeto
										if ( is_object($term) && isset($term->term_id) ) {
											$q = new WP_Query( array(
												'post_type' 		=> $pt->name,
												'posts_per_page' 	=> -1,
												// 'orderby'			=> 'name',
												// 'order'				=> 'asc',
												'tax_query' => array(
													array(
														'taxonomy' => $tax,
														'field' => 'id',
														'terms' => array( $term->term_id ),
														'operator' => 'IN'
													)
												)
											) );

											if ( $q->have_posts() ) : 
												echo '<h6 id="'.$pt->name.'">'.$term->name.'</h6>';

												echo '<ul class="mb-4">';
												while ( $q->have_posts() ) : 
													$q->the_post();
													// if (is_user_logged_in()) {
													// 	echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a><br>'.$post->post_content.'<br>'.$post->post_excerpt.'<br><br>';
													// } else {
														echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';

													// }
												endwhile; 
												echo '</ul>';
											endif;
											$q = null;
											wp_reset_postdata();
										}
									}
								} else {
									$q = new WP_Query( array(
										'post_type' 		=> $pt->name,
										'posts_per_page' 	=> -1,
										// 'orderby'			=> 'name',
										// 'order'				=> 'asc',
									) );

									if ( $q->have_posts() ) : 

										while ( $q->have_posts() ) : 
											$q->the_post();
											// if (is_user_logged_in()) {
											// 	echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a><br>'.$post->post_content.'<br>'.$post->post_excerpt.'<br><br>';
											// } else {
												echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';

											// }
										endwhile; 
									endif;
									$q = null;
									wp_reset_postdata();
								}
							}

						echo '</ul>';
						echo '</div>';
					
		            	}
		            } ?>


			</main><!-- #main -->

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
