<?php
/**
 * Search results partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article class="stretch-linked-block position-relative" id="post-<?php the_ID(); ?>">

	<header class="entry-header d-flex align-items-center justify-content-between gap-3 py-2 border-bottom">

		<?php
		the_title(
			sprintf( '<p class="entry-title mb-0"><a class="stretched-link" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></p>'
		);
		?>

		<?php
		$post_type = get_post_type_object( get_post_type() );
		if ( $post_type ) {
			echo '<div class="post-type-name small text-muted">' . esc_html( $post_type->labels->singular_name ) . '</div>';
		}
		?>

	</header><!-- .entry-header -->

</article><!-- #post-## -->
