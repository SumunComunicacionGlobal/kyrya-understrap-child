<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function understrap_posted_on() {

    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    }
    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );
    echo $time_string; // WPCS: XSS OK.

}



/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function understrap_entry_footer() {
	// Hide category and tag text for pages.
	if ( is_singular( 'post' ) ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'understrap' ) );
		if ( $categories_list && understrap_categorized_blog() ) {
			/* translators: %s: Categories of current post */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'understrap' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'understrap' ) );
		if ( $tags_list ) {
			/* translators: %s: Tags of current post */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %s', 'understrap' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
	// if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
	// 	echo '<span class="comments-link">';
	// 	comments_popup_link( esc_html__( 'Leave a comment', 'understrap' ), esc_html__( '1 Comment', 'understrap' ), esc_html__( '% Comments', 'understrap' ) );
	// 	echo '</span>';
	// }
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'understrap' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

function smn_breadcrumb() {

	if ( is_front_page() ) return false;

	$r = '';

	ob_start();

	if(function_exists('bcn_display')) {
		echo '<div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">';
			echo '<div class="breadcrumb-inner">';
				bcn_display();
			echo '</div>';
		echo '</div>';
	} elseif ( function_exists( 'rank_math_the_breadcrumbs') ) {
		echo '<div class="breadcrumb">';
			echo '<div class="breadcrumb-inner">';
				rank_math_the_breadcrumbs(); 
			echo '</div>';
		echo '</div>';
	} elseif ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumb"><div class="breadcrumb-inner">','</div></div>' );
	}

	$r = ob_get_clean();

	if ( $r ) {
		echo '<div class="container">';
			echo $r;
		echo '</div>';
	}


}

function understrap_post_nav() {
	return false;
}

function smn_subterm_buttons( $subterms = array(), $term = null ) {

	$r = '';

	if (!empty($subterms)) { 
		$r .= '<span class="btn btn-secondary mb-1 me-1">' . $term->name . '</span>';
		foreach ($subterms as $subterm) {
			$r .= '<a class="btn btn-light mb-1 me-1" href="'.get_term_link( $subterm ).'">' . $subterm->name . '</a>';
		}
	} else {

		if ( $term->parent == 0 ) {
			return false;
		}
	
		// $q_obj = kyrya_default_language_term($q_obj_trans);

		$args_sibling_terms = array(
			'taxonomy'		=> $term->taxonomy,
			'parent'		=> $term->parent,
			'hide_empty'	=> true,
			// 'exclude' 		=> array($term->term_id),
		);

		$sibling_terms = get_terms( $args_sibling_terms);

		if (count($sibling_terms) == 1 && $sibling_terms[0]->term_id == $term->term_id) {
			$sibling_terms[] = get_term($term->parent);
		}

		if (!empty($sibling_terms)) {

			foreach ($sibling_terms as $subterm) {
				if ( $subterm->term_id == $term->term_id ) {
					$r .= '<span class="btn btn-secondary mb-1 me-1">' . $subterm->name . '</span>';
				} else {
					$r .= '<a class="btn btn-light mb-1 me-1" href="'.get_term_link( $subterm ).'">' . $subterm->name . '</a>';
				}
			}

		}

	}

	if ( $r ) {
		echo '<div class="subterms-buttons">';
			echo $r;
		echo '</div>';
	}

}

function smn_boton_contacto() {
	if(!is_page( CONTACTO_ID )) { ?>
		<a class="btn btn-primary btn-contacto" href="<?php echo get_the_permalink( CONTACTO_ID ); ?>"><i class="fa fa-envelope me-2"></i> <?php echo get_the_title( CONTACTO_ID ); ?></a>
	<?php }
}