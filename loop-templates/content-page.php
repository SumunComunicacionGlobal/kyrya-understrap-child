<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// $subtitulo = get_post_meta( $post->ID, 'subtitulo', true );

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php
		if ( ! is_page_template( 'page-templates/no-title.php' ) ) {
			the_title(
				'<header class="entry-header"><h1 class="entry-title">',
				'</h1></header><!-- .entry-header -->'
			);
		}
	?>
	
	<div class="entry-content">

		<?php 
		// if ($subtitulo) {
		// 	echo '<div class="subtitulo-pagina">'.$subtitulo.'</div>';
		// }
		?>

		<?php
		the_content();
		understrap_link_pages();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
