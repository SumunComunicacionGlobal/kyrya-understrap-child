<?php
/**
 * Template name: Contacto
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

				<?php while ( have_posts() ) : the_post();

				$post_meta = get_fields();

				?>
				<article <?php post_class('row'); ?> id="post-<?php the_ID(); ?>">
					<div class="col-lg-4 col-md-6">

						<?php echo get_the_post_thumbnail( $post->ID, 'large', array('class' => 'mb-4') ); ?>
						<?php if (isset($post_meta['mapa_contacto'])) {
							echo '<div class="mapa-contacto">'.$post_meta['mapa_contacto'].'</div>';
						} 
						echo '<div class="informacion-contacto">'.do_shortcode( '[contacto]' ).'</div>';

						?>



					</div>
					<div class="col-lg-8 col-md-6">
						<header class="entry-header">

							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

						</header><!-- .entry-header -->

						<div class="entry-content">

							<?php the_content(); ?>

							<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
								'after'  => '</div>',
							) );
							?>

						</div><!-- .entry-content -->

						<footer class="entry-footer">

							<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

						</footer><!-- .entry-footer -->
					</div>

				</article><!-- #post-## -->

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
