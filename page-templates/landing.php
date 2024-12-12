<?php
/**
 * Template Name: Landing page
 */

get_header();
?>

<div id="full-width-page-wrapper">

	<div class="container" id="content">

			<div class="content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

							<?php the_content(); ?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
