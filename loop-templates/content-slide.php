<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div>

	<div <?php post_class( 'wp-block-cover px-5 alignfull' ); ?> id="post-<?php the_ID(); ?>">

		<span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-30 has-background-dim"></span>

		<?php the_post_thumbnail( 'full', array( 'class' => 'wp-block-cover__image-background' ) ); ?>

		<div class="wp-block-cover__inner-container">

			<div class="entry-content">

				<?php the_title( '<p class="h2"><em>', '</em></p>' ); ?>

				<?php the_content(); ?>

			</div>

			<footer class="entry-footer">

				<?php understrap_edit_post_link(); ?>

			</footer><!-- .entry-footer -->

		</div>


	</div><!-- #post-## -->

</div>