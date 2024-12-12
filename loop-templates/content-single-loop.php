<?php
/**
 * Loop Single post partial template.
 *
 * @package understrap
 */

 $col_classes = 'col-md-6 col-md-4 col-lg-3';

 if ( is_archive() || is_home() || is_search() ) {
	$col_classes = 'col-sm-6 col-md-4';
 }

?>
<article <?php post_class( $col_classes . ' mb-5 pb-4 position-relative'); ?> id="post-<?php the_ID(); ?>">

	<?php echo get_the_post_thumbnail( $post->ID, 'medium', array('class' => 'mb-3 has-aspect-ratio-4-3') ); ?>

	<header class="entry-header">

		<a class="stretched-link" href="<?php the_permalink(); ?>"><?php the_title( '<p class="entry-title h5">', '</p>' ); ?></a>

		<div class="entry-meta">

			<?php the_date(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->


	<div class="entry-content">

		<?php the_excerpt(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
