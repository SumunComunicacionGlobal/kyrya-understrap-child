<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( !isset($args['post_ids']) || !$args['post_ids'] ) return false;

$posts_ids = $args['post_ids'];

if ( $posts_ids ) {

	$args = array(
		'post_type'			=> 'content_fragment',
		'post__in'			=> $posts_ids,
		'orderby'			=> 'post__in',
		'order'				=> 'ASC',
	);


	$q = new WP_Query($args);

	if ( $q->have_posts() ) { ?>

		<div class="wrapper">

			<?php while ( $q->have_posts() ) { $q->the_post(); ?>

				<div class="col">

					<?php the_content(); ?>

				</div>

			<?php } ?>

		</div>

	<?php }

	wp_reset_postdata();
}