<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define('ACABADOS_ID', apply_filters( 'wpml_object_id', 246, 'page' ));
define('APERTURAS_ID', apply_filters( 'wpml_object_id', 902, 'page' ) );
define('ESTRUCTURAS_ID', apply_filters( 'wpml_object_id', 2278, 'page' ) );
define('PRODUCTOS_ID', apply_filters( 'wpml_object_id', 59, 'page' ) );
define('COLECCIONES_ID', apply_filters( 'wpml_object_id', 61, 'page' ) );
define('SPACES_SOLUTIONS_ID', apply_filters( 'wpml_object_id', 65, 'page' ) );
define('INTEGRATED_SPACES_ID', apply_filters( 'wpml_object_id', 67, 'page' ) );
define('CONTACTO_ID', apply_filters( 'wpml_object_id', 17, 'page' ) );
// define('INSPIRACION_ID', apply_filters( 'wpml_object_id', 21004, 'page' ) );
define('INSPIRACION_ID', false );
define('ID_FORMULARIO_DESCARGA', 1274 );
define('CATEGORIA_CATALOGOS', 82 );
define('AREA_PROFESIONAL', apply_filters( 'wpml_object_id', 11, 'page' ) );
define('MI_PERFIL', apply_filters( 'wpml_object_id', 253, 'page' ) );
define('KYRYA_PRO_URL', 'https://pro.kyryagroup.com/' . kyrya_get_language_code() );
define('REDES_SOCIALES_ID', 68645);


// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
    // '/smn-dummy-content.php',
    '/smn-seo.php',
    '/smn-widgets.php',
    '/smn-post-types.php',
    '/smn-setup.php',
    '/smn-hooks.php',
    '/smn-customizer.php',
    '/smn-template-tags.php',
    '/smn-shortcodes.php',
    '/smn-blocks.php',
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
    $understrap_includes[] = '/smn-woocommerce.php';
}

if ( class_exists('ACF')) {
    $understrap_includes[] = '/smn-acf.php';
}

if ( class_exists('FacetWP') ) {
    $understrap_includes[] = '/smn-facetwp.php';
}

if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
    $understrap_includes[] = '/smn-moove-gdpr-cookies.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
    require_once get_theme_file_path( $understrap_inc_dir . $file );
}


/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.css' );
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/js/slick/slick-theme.css' );

	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";
	
	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_styles );

	wp_enqueue_style( 'kyrya', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version );
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.min.js', null, null, true );

	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_scripts );
	
    wp_enqueue_script( 'viewport-checker', get_stylesheet_directory_uri() . '/js/jquery.viewportchecker.min.js', array('jquery') , '1.8.8', true );
	wp_enqueue_script( 'kyrya', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function wpdocs_dequeue_script() {
    wp_dequeue_script( 'uacf7-country-select-script' );
}
add_action( 'wp_print_scripts', 'wpdocs_dequeue_script', 100 );


/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
    load_child_theme_textdomain( 'smn', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );

function kyrya_get_language_code() {
    $code = apply_filters( 'wpml_current_language', NULL );
    if ( 'es' == $code ) return '';

    return $code;
}

add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');
add_filter('acf/settings/remove_wp_meta_box', '__return_false');
add_action( 'gdpr_force_reload', '__return_true' );

function wpb_remove_schedule_delete() {
    remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
}
add_action( 'init', 'wpb_remove_schedule_delete' );

add_action('wp_head', 'inyectar_scripts_y_styles_personalizados');
function inyectar_scripts_y_styles_personalizados() {
    if (is_singular()) {
        global $post;
        $scripts = get_post_meta( $post->ID, 'scripts_estilos', true );
        if ($scripts && '' != $scripts ) {
            echo $scripts;
        }
    }
}

function load_custom_wp_admin_style(){
    wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/css/admin.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

function redes_sociales_shortcode(  ) {
    $args = array(
            'post_type'         => 'red_social',
            'posts_per_page'    => -1,
        );
    
    $r = '';
    $q = new WP_Query($args);
    if ($q->have_posts()) {
        $r .= '<span class="redes-sociales">';

        while ($q->have_posts()) { $q->the_post();
            $r .= '<a href="'.get_the_excerpt().'" target="_blank" title="'.get_the_title().'"><img src="'.get_the_post_thumbnail_url().'" alt="'.get_the_title().'" /></a>';
        }
        $r .= '</span>';
    }

    wp_reset_postdata();

    return $r;
}
add_shortcode( 'redes_sociales', 'redes_sociales_shortcode' );


function kyrya_get_post_types_by_taxonomy( $tax = 'category' )
{
    global $wp_taxonomies;
    return ( isset( $wp_taxonomies[$tax] ) ) ? $wp_taxonomies[$tax]->object_type : array();
}

function ordenar_alfabeticamente( $query ) {
    if (is_admin()) return;
    
    $pt = false;
    if (is_tax()) {
        $qobj = get_queried_object();
        if ($qobj) {
            $pt = kyrya_get_post_types_by_taxonomy($qobj->taxonomy);
        }
        // echo '<pre>'; print_r($pt); echo '</pre>';
    } elseif (is_page_template( $template = 'page-templates/template-archivo.php' )) {
        $pt = get_post_meta( get_the_ID(), 'archivo', true );
    }

    if ($pt) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }

}
add_action( 'pre_get_posts', 'ordenar_alfabeticamente' );

function mostrar_solo_mobiliaro_en_categorias_producto( $query ) {

    if ( is_admin() || !$query->is_main_query() ) return;
    if ( !is_tax( 'categoria_producto' ) ) return;

    $query->set( 'post_type', ['producto']);

}
add_action( 'pre_get_posts', 'mostrar_solo_mobiliaro_en_categorias_producto' );


function kyrya_placeholder_url() {
	return get_stylesheet_directory_uri() . '/img/kyrya-placeholder.jpg';
}

function flecha_animada( $color = '#fff', $direccion = 'derecha' ) {
	if ($direccion != 'derecha') {
		$direccion == 'izquierda';
	}
	$r = '<svg class="arrow-icon '.$direccion.'" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
						      <g fill="none" stroke="'.$color.'" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
						        <circle class="arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>';
	if ($direccion == 'derecha')
		$r .= '<path transform="rotate(-180 16.562461853027344,15.63349151611328) " stroke="'.$color.'" id="svg_6" d="m16.484828,8.062496l-7.609849,7.53216l7.60983,7.60983l-7.454528,-7.454528l15.219661,-0.155303" opacity="1" stroke-width="1.5" fill="none"/>';
	else
		$r .= '<path stroke="'.$color.'" id="svg_6" d="m16.484828,8.062496l-7.609849,7.53216l7.60983,7.60983l-7.454528,-7.454528l15.219661,-0.155303" opacity="1" stroke-width="1.5" fill="none"/>';

	$r .= '</g>
			</svg>';

	return $r;
}

remove_action( 'the_content', 'wrap_content' );

function kyrya_contacto() {
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/template-contacto.php'
    ));
    if (!empty($pages)) {
        $page = $pages[0];
        $contacto = get_field('informacion_de_contacto', $page->ID);
        return '<p><i class="fa fa-map-marker fa-3x"></i></p>' . $contacto;
    }
    return false;
}
add_shortcode( 'contacto', 'kyrya_contacto' );

function link_contacto($obj = null) {
    $url = get_permalink( CONTACTO_ID );
    if ( is_a($obj, 'WP_Term') ) {
        $tax_obj = get_taxonomy( $obj->taxonomy );
        $url = add_query_arg( array(
                'kt'     => $tax_obj->labels->singular_name,
                'kid'    => $obj->term_id,
                'kn'     => $obj->name,
            ), $url);
    } elseif ( is_a($obj, 'WP_Post') ) {
        $pt_obj = get_post_type_object( $obj->post_type );
        $url = add_query_arg( array(
                'kt'     => $pt_obj->labels->singular_name,
                'kid'    => $obj->ID,
                'kn'     => $obj->post_title,
            ), $url);
    }
    $r = '<div class="link-contacto"><a class="btn btn-secondary mb-1 me-1" href="'.$url.'" target="_blank">'.__( 'Solicitar información', 'kyrya' ).'</a></div>';
    echo $r;
}

function opciones_de_producto( $opciones = array() ) {
    $r = '';

    if ( $opciones && !is_array( $opciones ) ) {
        $opciones = array( $opciones );
    }   
    
    if (!empty($opciones)) {

        $placeholder_url = get_stylesheet_directory_uri() . '/img/favicon-kyrya.png';

        $r .= '<div class="opciones-producto">';

        foreach ( $opciones as $original_opcion_id ) {

            $opcion_id = apply_filters( 'wpml_object_id', $original_opcion_id, 'opcion_producto', TRUE, ICL_LANGUAGE_CODE );

            $r .= '<div class="opcion-producto">';
                if (has_post_thumbnail($original_opcion_id)) {
                    $r .= get_the_post_thumbnail( $original_opcion_id, 'post-thumbnail', array( 'title' => get_the_title( $opcion_id ) ) );
                } else {
                    // $placeholder_id = 30;
                    // $r .= wp_get_attachment_image( $placeholder_id, 'thumbnail', false, array( 'title' => get_the_title( $opcion_id ) ) );
                    $r .= '<img class="opacity-25" src="'.$placeholder_url.'" alt="'.get_the_title( $opcion_id ).'" title="'.get_the_title( $opcion_id ).'">';
                }

                $r .= '<div class="titulo-opcion">'.get_the_title( $opcion_id ).'</div>';
            
            $r .= '</div>';
        }
    
        $r .= '</div>';
   }

    echo $r;
}

function es_composicion( $pt = '' ) {
    if ( 'composicion' == $pt || 'integrated_space' == $pt || 'solution_space' == $pt ) return true;
    return false;
}
function es_producto( $pt = '' ) {
    if ( 'producto' == $pt || 'acabado' == $pt || 'apertura' == $pt || 'opcion_producto' == $pt ) return true;
    return false;
}
function acabados($ids, $post_id = 0) {
    $r = '';

    if ($ids) {

        $texto_acabados = __( 'Acabados', 'kyrya' );

        $terms = get_the_terms($post_id, 'categoria_producto');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $texto_acabados_term = get_field( 'texto_acabados', $term );
                if ($texto_acabados_term) {
                    $texto_acabados = $texto_acabados_term;
                    break;
                }
            }
        }

        $r .= '<hr>';
        $r .= '<h6>' . $texto_acabados . ':</h6>';
        $r .= '<div class="acabados">';

        foreach ($ids as $id ) {
            // $item_pt = get_post_type($id);
            $titulo = '';
            $descripcion = '';
            $titulo = get_the_title($id);

            $r .= '<div class="acabado-li">';
                
                $r .= get_the_post_thumbnail( $id, 'thumbnail', array('class' => 'thumb-acabado') );
                
                $r .= '<p class="acabado-title">';

                    if ( has_post_thumbnail( $id ) ) {
                        $r .= $titulo;
                    } else {
                        $r .= '<span class="d-block p-2 border border-dark">'.$titulo.'</span>';
                    }

                $r .= '</p>';

                if ( $descripcion ) {
                    $r .= '<br><span class="small">'.$descripcion.'</span>';
                }

            $r .= '</div>';
        }

        $r .= '</div>';
    }

    echo $r;
}


function get_tax_navigation( $taxonomy = 'category', $direction = '' ) {
    // Make sure we are on a taxonomy term/category/tag archive page, if not, bail
    if ( 'category' === $taxonomy ) {
        if ( !is_category() )
            return false;
    } elseif ( 'post_tag' === $taxonomy ) {
        if ( !is_tag() )
            return false;
    } else {
        if ( !is_tax( $taxonomy ) )
            return false;
    }

    // Make sure the taxonomy is valid and sanitize the taxonomy
    if (    'category' !== $taxonomy 
         || 'post_tag' !== $taxonomy
    ) {
        $taxonomy = filter_var( $taxonomy, FILTER_SANITIZE_STRING );
        if ( !$taxonomy )
            return false;

        if ( !taxonomy_exists( $taxonomy ) )
            return false;
    }

    // Get the current term object
    $current_term = get_term( $GLOBALS['wp_the_query']->get_queried_object() );

    // Get all the terms ordered by slug 
    $terms = get_terms( $taxonomy, ['parent' => $current_term->parent /*'orderby' => 'slug'*/] );

    // Make sure we have terms before we continue
    if ( !$terms ) 
        return false;

    // Because empty terms stuffs around with array keys, lets reset them
    $terms = array_values( $terms );

    // Lets get all the term id's from the array of term objects
    $term_ids = wp_list_pluck( $terms, 'term_id' );

    /**
     * We now need to locate the position of the current term amongs the $term_ids array. \
     * This way, we can now know which terms are adjacent to the current one
     */
    $current_term_position = array_search( $current_term->term_id, $term_ids );

    // Set default variables to hold the next and previous terms
    $previous_term = '';
    $next_term     = '';

    // Get the previous term
    if (    'previous' === $direction 
         || !$direction
    ) {
        if ( 0 === $current_term_position ) {
            // $previous_term = $terms[intval( count( $term_ids ) - 1 )];
        } elseif ($current_term_position > 0) {
            $previous_term = $terms[$current_term_position - 1];
        }
    }

    // Get the next term
    if (    'next' === $direction
         || !$direction
    ) {
        if ( intval( count( $term_ids ) - 1 ) === $current_term_position ) {
            // $next_term = $terms[0];
        } else {
            if (isset($terms[$current_term_position + 1])) {
                $next_term = $terms[$current_term_position + 1];
            }
        }
    }

    $link = [];
    // Build the links
    if ( $previous_term ) 
        $link[] = '<a class="btn btn-secondary" href="' . esc_url( get_term_link( $previous_term ) ) . '">< ' . $previous_term->name . '</a>';

    if ( $next_term ) 
        $link[] = '<a class="btn btn-secondary" href="' . esc_url( get_term_link( $next_term ) ) . '">' . $next_term->name . ' ></a>';

    return '<div class="tax-navigation text-center mt-2 mb-1">' . implode( ' ', $link ) . '</div>';
}

// SELECTOR DE IDIOMA
function kyrya_language_selector(){
    $languages = icl_get_languages('skip_missing=0');
    if(count($languages) > 1 ){
        echo '<nav class="navbar navbar-dark navbar-expand py-0 text-uppercase small">';
		echo '<ul class="navbar-nav">';
        foreach($languages as $l){
            $active_class = ( $l['active'] ) ? 'wpml-ls-item-active' : '';
			$bootstrap_active_class = ( $l['active'] ) ? 'active' : '';

            echo '<li class="nav-item wpml-ls-slot-footer wpml-ls-item '.$active_class.'">';
            	if(!$l['active']) {
					echo '<a class="nav-link" href="'.$l['url'].'">';
				} else {
					echo '<span class="nav-link active">';
				}
		            echo substr( $l['language_code'], 0, 2);
            	
				if(!$l['active']) {
					echo '</a>';
				} else {
					echo '</span>';
				}
            echo '</li>';
        }
        echo '</ul></nav>';
    }
}


add_filter('post-types-order_save-ajax-order', 'sincronizar_menu_order_wpml', 10, 3);
function sincronizar_menu_order_wpml($data, $key, $id) {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    global $wpdb;

    if ( !empty( $languages ) ) {
        foreach( $languages as $l ) {
            $post = get_post($id);
            $id =  apply_filters( 'wpml_object_id', $id, $post->post_type, FALSE, $l['language_code'] );
            $wpdb->update( $wpdb->posts, $data, array('ID' => $id) );
  
        }
    }

    return $data;
}

add_action('tto/update-order', 'sincronizar_term_order_wpml', 20);
function sincronizar_term_order_wpml() {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    global $wpdb;

    if ( !empty( $languages ) ) {

        $data               = stripslashes($_POST['order']);
        $unserialised_data  = json_decode($data, TRUE);

        foreach( $languages as $l ) {

            if (is_array($unserialised_data))
            foreach($unserialised_data as $key => $values ) {
                //$key_parent = str_replace("item_", "", $key);
                $items = explode("&", $values);
                unset($item);
                foreach ($items as $item_key => $item_)
                    {
                        $items[$item_key] = trim(str_replace("item[]=", "",$item_));
                    }
                
                if (is_array($items) && count($items) > 0)
                foreach( $items as $item_key => $term_id ) 
                    {
                        $term = get_term($term_id);
                        $term_id =  apply_filters( 'wpml_object_id', $term_id, $term->taxonomy, FALSE, $l['language_code'] );
                        $wpdb->update( $wpdb->terms, array('term_order' => ($item_key + 1)), array('term_id' => $term_id) );
                    } 
            }
  
        }
    }

}


function kyrya_default_language_term($term) {
    global $icl_adjust_id_url_filter_off;
    $orig_flag_value = $icl_adjust_id_url_filter_off;
    $icl_adjust_id_url_filter_off = true;
    $default_lang = apply_filters('wpml_default_language', NULL );
    if (is_a($term, 'WP_Term')) {
        $default_term_id =  apply_filters( 'wpml_object_id', $term->term_id, $term->taxonomy, FALSE, $default_lang );
        $default_term = get_term( $default_term_id );
        $icl_adjust_id_url_filter_off = $orig_flag_value;

        return $default_term;
    }
    return false;

}

// add_action( 'wp_head', 'traducir' );
function traducir() {
    $args = array(
            'post_type'         => 'producto',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );


    $strings_es = array(
            // '1 puerta',
            // '2 puertas',
            // '3 puertas',
            // '4 puertas',
            // 'Puerta',
            // '1 cajón',
            // '2 cajones',
            // '3 cajones',
            // '4 cajones',
            // '1 decorativo',
            // '2 decorativos',
            // '2 decorativo',
            // 'decorativo',
            'fondo mínimo',
            'fondo hasta',
            // 'Bancada',
            // '3 huecos',
            // '2 huecos',
            // '4 huecos',
            // '8 huecos',
            // 'Ejemplo',
            // 'Extrafino',
        );

    $strings_en = array(
            // '1 door',
            // '2 doors',
            // '3 doors',
            // '4 doors',
            // 'Door',
            // '1 drawer',
            // '2 drawers',
            // '3 drawers',
            // '4 drawers',
            // '1 decorative element',
            // '2 decorative elements',
            // '2 decorative elements',
            // 'decorative element',
            'min. depth',
            'depth: up to',
            // 'Bench',
            // '3 gaps',
            // '2 gaps',
            // '4 gaps',
            // '8 gaps',
            // 'Example',
            // 'Extra thin',
        );

    $strings_fr = array(
            // '1 porte',
            // '2 portes',
            // '3 portes',
            // '4 portes',
            // 'Porte',
            // '1 tiroir',
            // '2 tiroirs',
            // '3 tiroirs',
            // '4 tiroirs',
            // '1 niche',
            // '2 niches',
            // '2 niches',
            // 'niche',
            'prof. minimum',
            'profondeur jusqu\'à',
            // 'Module bas',
            // '3 niches',
            // '2 niches',
            // '4 niches',
            // '8 niches',
            // 'Exemple',
            // 'Extrafin',
        );

    $strings_it = array(
            // '1 anta',
            // '2 ante',
            // '3 ante',
            // '4 ante',
            // 'Ante',
            // '1 cassetto',
            // '2 cassetti',
            // '3 cassetti',
            // '4 cassetti',
            // '1 decorativo',
            // '2 decorativos',
            // '2 decorativos',
            // 'decorativo',
            'fondo minimo',
            'fondo fino a',
            // 'Mobile basso',
            // '3 vani',
            // '2 vani',
            // '4 vani',
            // '8 vani',
            // 'Esempio',
            // 'Extrasottile',
        );

    $strings_pt = array(
            // '1 porta',
            // '2 portas',
            // '3 portas',
            // '4 portas',
            // 'Porta',
            // '1 gaveta',
            // '2 gavetas',
            // '3 gavetas',
            // '4 gavetas',
            // '1 espaço',
            // '2 espaços',
            // '2 espaços',
            // 'espaço',
            'fundo minimo',
            'fundo até',
            // 'Móvel',
            // '3 espaços',
            // '2 espaços',
            // '4 espaços',
            // '8 espaços',
            // 'Exemplo',
            // 'Extrafino',
        );

    foreach ($posts as $post) {
        $excerpt = $post->post_content;
        $excerpt_traducido = $excerpt;

        if ('' != $excerpt) {
            switch (ICL_LANGUAGE_CODE) {
                case 'en':
                $strings_traducidas = $strings_en;
                    break;

                case 'fr':
                $strings_traducidas = $strings_fr;
                    break;

                case 'it':
                $strings_traducidas = $strings_it;
                    break;

                case 'pt-pt':
                $strings_traducidas = $strings_pt;
                    break;
                
                default:
                    $strings_traducidas = $strings_es;
                    break;
            }

            for ($i=0; $i < count($strings_es); $i++) { 
                if ( strpos($excerpt_traducido, $strings_es[$i]) !== false ) {
                    // echo $strings_es[$i] . '/' . $strings_traducidas[$i] . '/' . $excerpt_traducido . '<br>';
                    $excerpt_traducido = str_replace($strings_es[$i], $strings_traducidas[$i], $excerpt_traducido);
                    // echo $strings_es[$i] . '/' . $strings_traducidas[$i] . '/' . $excerpt_traducido . '<br>';
                }
            }



            if ($excerpt != $excerpt_traducido) {
                // Actualizar post
                echo $post->post_title . ': ' . $excerpt_traducido . '</br>';
                $updated_post = array(
                        'ID' => $post->ID,
                        'post_content' => $excerpt_traducido,
                    );
                wp_update_post( $updated_post );
            }
        }

    }



    // echo count($posts) . '<br>';
    // echo '<pre>'; print_r($posts); echo '</pre>';
}

// add_action( 'wp_head', 'cambiar_textos_acabados' );
function cambiar_textos_acabados() {
    $args = array(
            'post_type'         => 'acabado',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );



    foreach ($posts as $post) {
        $excerpt = $post->post_excerpt;
        $titulo = $post->post_title;

        if ('' != $excerpt && strlen($excerpt) == 6 && strlen($titulo) != 6) {
            // Actualizar post
            echo $titulo . ': ' . $excerpt . '</br>';
            $updated_post = array(
                    'ID' => $post->ID,
                    'post_title' => $excerpt,
                    'post_excerpt' => $titulo,
                );
            wp_update_post( $updated_post );
        }

    }



    // echo count($posts) . '<br>';
    // echo '<pre>'; print_r($posts); echo '</pre>';
}

// add_action( 'wp_head', 'insertar_postmeta' );
function insertar_postmeta() {
    $args = array(
            'post_type'         => 'producto',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );



    foreach ($posts as $post) {
        $titulo = $post->post_title;
        // update_post_meta( $post->ID, '_wpml_media_featured', 1 );
        $wpml_media_featured = get_post_meta( $post->ID, '_wpml_media_featured', true );
        echo $post->post_type . ' - ' . $titulo . ': ' . $wpml_media_featured . '<br>';
    }
}

// add_action( 'wp_head', 'quitar_imagenes_destacadas' );
function quitar_imagenes_destacadas() {

    $args = array(
            'post_type'         => 'producto',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );



    foreach ($posts as $post) {
        if ( ICL_LANGUAGE_CODE != 'es' ) {
            $lang_info = wpml_get_language_information($post->ID);
            $lang = $lang_info['locale'];
            $is_translated = apply_filters( 'wpml_element_has_translations', NULL, $post->ID, $post->post_type );

            $titulo = $post->post_title;
            if ($is_translated) {
                echo $lang . ' - ' . $post->post_type . ' - ' . $is_translated . ' - ' . $titulo . ': '. get_post_thumbnail_id( $post ) . '<br>';
                delete_post_meta( $post->ID, '_thumbnail_id' );
            }
        }
    }
}

function get_primera_imagen_fondo_fallback($term) {
    remove_action( 'pre_get_posts', 'ordenar_alfabeticamente' );
    $primer_el = get_posts( array(
        'posts_per_page'    => 1,
        'post_type'         => 'any',
        'tax_query'         => array(array(
                                'taxonomy'      => $term->taxonomy,
                                'field'         => 'term_id',
                                'terms'         => $term->term_id,
            )),
        ) );
    add_action( 'pre_get_posts', 'ordenar_alfabeticamente' );
    if (!empty($primer_el)) {
        $thumb_url = get_the_post_thumbnail_url( $primer_el[0], 'medium_large' );
        return $thumb_url;
    }
    return false;
}

// add_action( 'wp_footer', 'script_seleccionar_lista_newsletter' );
function script_seleccionar_lista_newsletter() { ?>
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            function comprobar_checks() {
                if ( $(".js-cm-form input[type='checkbox']:checked").length == 0) {
                    $(".js-cm-form button[type='submit']").prop("disabled", true);
                } else {
                    $(".js-cm-form button[type='submit']").prop("disabled", false);
                }
            }

            comprobar_checks();

            $(".js-cm-form input[type='checkbox']").click(function() {
                comprobar_checks();
            });

        });
    </script>
<?php }

add_action( 'wp_footer', 'script_prerrellenar_asunto_formulario' );
function script_prerrellenar_asunto_formulario() { 
    if ( is_front_page() || !is_singular() ) return;

    global $post;

    ?>

    <script type="text/javascript">
        jQuery( 'input[name="your-subject"' ).each(function( index ) {
            jQuery(this).val("<?php echo $post->post_title; ?>");
        });
    </script>
<?php }

// add to yoast breadcrumb an item after home page. Link this item to page with id CONTACTO_ID (constant)
add_filter( 'wpseo_breadcrumb_links', 'smn_add_breadcrumb_links' );
function smn_add_breadcrumb_links( $links ) {

    foreach ($links as $key => $link) {
        if ( isset( $link['ptarchive'] ) ) {

            if ( $link['ptarchive'] == 'producto' ) {
                $links[$key]['url'] = get_permalink( PRODUCTOS_ID );
                $links[$key]['text'] = get_the_title( PRODUCTOS_ID );
            }

        }
    }

    return $links;

}

// add_action('admin_init', 'actualizar_term_count');
function actualizar_term_count() {
    $update_taxonomy = 'categoria_producto';
    $get_terms_args = array(
            'taxonomy' => $update_taxonomy,
            'fields' => 'ids',
            'hide_empty' => false,
            );

    $update_terms = get_terms($get_terms_args);
    echo '<pre>'; print_r($update_terms); echo '</pre>';
    wp_update_term_count_now($update_terms, $update_taxonomy);    
}

// Replaces the excerpt "Read More" text by a link
// function new_excerpt_more($more) {
//        // global $post;
//     return ' [...]';
// }
// add_filter('excerpt_more', 'new_excerpt_more');


function slider_destacados( $pt = 'composicion', $q_obj = false, $slider_class = '' ) {
    $args = array(
            'post_type'         => $pt,
            'posts_per_page'    => -1,
            'orderby'           => 'post_title',
            'order'             => 'ASC',
            'meta_key'          => 'destacada',
            'meta_value'        => 1,
        );

    if ($q_obj) {
        $args['tax_query'] = array(array(
                                        'taxonomy'      => $q_obj->taxonomy,
                                        'field'         => 'term_id',
                                        'terms'         => $q_obj->term_id,
                                        'include_children' => false,
                ));
    }

    $destacadas_query = new WP_Query($args);
    // print_r($destacadas_query);

    $r = '';

    if ($destacadas_query->have_posts()) {
        $slider_class .= ($q_obj) ? $q_obj->taxonomy : '';
        $r .= '<div class="slider '. $slider_class . '">';
            $r .= '<div id="slider-principal" class="carousel slide" data-bs-ride="carousel">';
                $r .= '<div class="carousel-inner" role="listbox">';
                $indicators = '';

                while($destacadas_query->have_posts()) {
                    $destacadas_query->the_post();
                    $active_class = ($destacadas_query->current_post == 0) ? ' active' : '';

                    $thumb_url = get_the_post_thumbnail_url( null, 'large' );
                    // $r .= '<div class="carousel-item bg-cover';
                    // $r .= ($destacadas_query->current_post == 0) ? ' active' : '';
                    // $r .= '" style="background-image:url(\'' . $thumb_url . '\')">';
                    //  $r .= '<div class="carousel-caption"><div class="h2"><a href="'. get_the_permalink() .'" title="' . get_the_title() . '" data-bs-toggle="modal" data-bs-target="#modal-ajax-post" class="no-underline modal-link">' . get_the_title() . '</a></div></div>';
                    // $r .= '</div>';
                    $r .= '<div class="carousel-item bg-secondary ' . $active_class . '">';

                    $r .= '<a href="'.get_the_permalink().'" class="modal-link">';
                        $r .= '<div class="carousel-img-container bg-cover"';
                        $r .= ' style="background-image:url(\'' . $thumb_url . '\')">';
                            // $r .= '<div class="carousel-caption"><div class="h2"><a href="'. get_the_permalink() .'" title="' . get_the_title() . '" data-bs-toggle="modal" data-bs-target="#modal-ajax-post" class="no-underline modal-link">' . get_the_title() . '</a></div></div>';
                        $r .= '</div>';
                    $r .= '</a>';
                    $r .= '</div>';

                    $indicators .= '<li data-bs-target="#slider-principal" data-bs-slide-to="'.$destacadas_query->current_post.'" class="'.$active_class.'"></li>';
                }

                $r .= '</div>';

                // $r .= '<!-- Left and right controls -->
                //   <a class="left carousel-control-prev" href="#slider-principal" data-bs-slide="prev">
                //     <span class="glyphicon glyphicon-chevron-left carousel-control-prev-icon"></span>
                //     <span class="sr-only">Previous</span>
                //   </a>
                //   <a class="right carousel-control-next" href="#slider-principal" data-bs-slide="next">
                //     <span class="glyphicon glyphicon-chevron-right carousel-control-next-icon"></span>
                //     <span class="sr-only">Next</span>
                //   </a>';

                  $r .= '<ol class="carousel-indicators">'.$indicators.'</ol>';

                  $r .= '<a class="carousel-control-prev link link--arrowed" href="#slider-principal" data-bs-slide="prev">' . flecha_animada('#fff', 'izquierda') . __( 'Prev', 'kyrya' ) . '</a>';
                  $r .= '<a class="carousel-control-next link link--arrowed" href="#slider-principal" data-bs-slide="next">' . __( 'Next', 'kyrya' ) . flecha_animada('#fff', 'derecha') . '</a>';

            $r .= '</div>';
        $r .= '</div>';

    }
    wp_reset_postdata();


    echo $r;

}

add_shortcode( 'slider_destacados', 'get_slider_destacados' );
function get_slider_destacados() {
    ob_start();
    slider_destacados('composicion', false, 'inspiracion');
    return ob_get_clean();
}


function info_basica_privacidad() {
    // global $post;
      $privacidad_page_id = apply_filters( 'wpml_object_id', 111, 'page' );
      $privacidad_page = get_post( $privacidad_page_id );
      // $contenido = apply_filters('the_content', $privacidad_page->post_content);
      $contenido = $privacidad_page->post_content;

        echo '<div class="modal fade modal-privacidad" tabindex="-1" role="dialog" id="modal-privacidad">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">'.$privacidad_page->post_title.'</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'.__( 'Cerrar', 'kyrya' ).'"></button>
              </div>
              <div class="modal-body">
                <div class="mw-800">
                    '.$contenido.'
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary aceptar-politica">'.__( 'Aceptar', 'kyrya' ).'</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'.__( 'Cancelar', 'kyrya' ).'</button>
              </div>
            </div>
          </div>
        </div>';

      // echo '<div id="contenido-info-basica-privacidad" style="display:none;"><br><br>' . $contenido . '<br><br></div>';

      ?>
        <script type="text/javascript">
          jQuery(document).ready(function($) {

            var casilla = $('.wpcf7-acceptance input[type="checkbox"][name="aceptacion"], input.wpcf7-acceptance, input[type="checkbox"]#tos');
            var formid = 'vacio';

            $('#wpmem_register input[type="submit"]').prop('disabled', true);
            $('#wpmem_register #tos').siblings('a').removeAttr('onclick').removeAttr('href');

            casilla.change(function() {
                if(this.checked) {
                    $(this).parents('form').find('input[type="submit"]').prop('disabled', true);
                    $(this).prop('checked', false);

                    if( $(this).hasClass('wpcf7-acceptance') || $(this).parents('.wpcf7-acceptance').length) {
                        // alert('es cf7');
                        formid = $(this).parents(".wpcf7").attr('id');
                    } else {
                        // alert('no es cf7');
                        formid = $(this).parents("form").attr('id');
                    }

                    // $('#modal-privacidad').attr('data-form-id', formid);
                    $('#modal-privacidad .aceptar-politica').attr('data-form-id', formid);
                    $('#modal-privacidad').modal('show');
                }
            });

            $('.aceptar-politica').click(function(event) {
                var destformid = $(this).attr('data-form-id');
                var form =  $('#' + destformid);
                if ( form.hasClass('wpcf7') ) {
                    $('#' + destformid + ' .wpcf7-acceptance input[type="checkbox"][name="aceptacion"]').prop('checked', true);
                } else {
                    $('#' + destformid + ' input[type="checkbox"]#tos').prop('checked', true);
                }
                $('#' + destformid + ' input[type="submit"]').prop('disabled', false);
                $('#modal-privacidad').modal('hide');
            });

            // var casilla = $('.wpcf7-acceptance input[type="checkbox"], input.wpcf7-acceptance');
            // var contenido = $('#contenido-info-basica-privacidad').html();
            // var estilos = 'border: 1px solid lightgray; padding: 2rem 4rem; margin: 2rem; background: #f1f1f1;';


            // casilla.parent().parent().append('<div class="info-basica-privacidad" style="display:none;'+estilos+'">'+contenido+'<p><strong><a href="#" class="aceptar-cerrar">[Aceptar y cerrar]</a></strong></p></div>');

            // casilla.change(function() {
            //     if(this.checked) {
            //       $(this).parents(".wpcf7").find(".info-basica-privacidad").show();
            //     } else {
            //       $(this).parents(".wpcf7").find(".info-basica-privacidad").hide();
            //     }
            // });

            // $('.aceptar-cerrar').click(function(event) {
            //   event.preventDefault();
            //   $('.info-basica-privacidad').hide();
            // });
          });
        </script>
      <?php
}
add_action ('wp_footer', 'info_basica_privacidad');

// wpml shortcodes --------------------
 
add_shortcode( 'lang', 'wpml_find_language');
/* ---------------------------------------------------------------------------
 
 * Shortcode [lang code="en"][/lang]
 
 * --------------------------------------------------------------------------- */
function wpml_find_language( $attr, $content = null ){
    extract(shortcode_atts(array(
        'code' => '',
    ), $attr));
     
    $current_language = ICL_LANGUAGE_CODE;
     
    if($current_language == $code){
        $output = do_shortcode($content);
    }else{
        $default_lang = apply_filters('wpml_default_language', NULL );
        $output = "";
    }
         
    return $output;
}

add_filter( 'single_post_title', 'traducir_solo_titulo', 10, 2 );
add_filter( 'the_title', 'traducir_solo_titulo', 10, 2 );
function traducir_solo_titulo( $title, $post ) {
    if (is_object($post)) {
        $post_id = $post->ID;
    } else {
        $post_id = $post;
    }

    $traducciones = get_post_meta( $post_id, 'traduccion_titulo', true );


    // if ( current_user_can('manage_options') ) {
    //     echo '<pre>'; 
    //     if (!$traducciones) echo 'false';
    //     print_r( $traducciones ); 
    //     echo '</pre>';
    // }
    
    if ($traducciones && '' != $traducciones ) {
        $traducciones_array = preg_split('/\r\n|[\r\n]/', $traducciones);
        $traducciones_codes_array = array();
        foreach ($traducciones_array as $trad_item) {
            $temp = explode(':', $trad_item);
            if (count($temp) > 1) {
                $code = trim( $temp[0] );
                if ( $code == 'pt') { $code = 'pt-pt'; }
                $traducciones_codes_array[$code] = trim( $temp[1] );
            }
        }
        if (isset($traducciones_codes_array[ICL_LANGUAGE_CODE])) {
            $title = $traducciones_codes_array[ICL_LANGUAGE_CODE];
        }
    }
    return $title;
}


// Quitar algunas páginas del buscador
add_action( 'pre_get_posts', 'sumun_search_filter' );
function sumun_search_filter( $query ) {
    if ( !is_admin() && $query->is_search && $query->is_main_query() ) {
        $query->set( 'post__not_in', array( 12694 ) );
    }
}


add_filter( 'parse_tax_query', function ( $query ) {
    if ( 
        $query->is_main_query()
        && $query->is_tax()
    ) {
        $query->tax_query->queries[0]['include_children'] = 0;
    }
});

function postmeta_variable( $post_meta = array(), $key = '' ) {
    if ( !isset($post_meta[$key]) || !$post_meta[$key] ) return false;
    if (is_serialized( $post_meta[$key][0] )) return unserialize($post_meta[$key][0]);
    return $post_meta[$key][0];
}

/** Incluir categorías en las búsquedas */
function atom_search_where($where){
  global $wpdb;

  if ( is_search() )
    $where .= "OR (t.name LIKE '%".get_search_query() . "%' AND {$wpdb->posts} . post_status = 'publish')";

  return $where;
}

function atom_search_join($join){
  global $wpdb;

  if ( is_search() )
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  return $join;
}

function atom_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts} . ID";
  if ( ! is_search() || strpos($groupby, $groupby_id) !== false )
    return $groupby;

  // groupby was empty, use ours
  if ( ! strlen( trim($groupby) ) )
    return $groupby_id;

  // wasn't empty, append ours
  return $groupby . ", " . $groupby_id;
}

add_filter('posts_where', 'atom_search_where');
add_filter('posts_join', 'atom_search_join');
add_filter('posts_groupby', 'atom_search_groupby');
/**/

/*
add_filter( 'cbqe_get_post_types_args', 'quick_edit_post_type_filter', 10 );
function quick_edit_post_type_filter( $args ) {

    $args['_builtin'] = false;
    return $args;
}
*/

/**
 * Change ACF field to be read-only.
 *
 * @param array $field Field attributes.
 *
 * @return array
 */
function dorzki_acf_read_only_field( $field ) {

	if( in_array( $field['name'], array(
	  'referencia',
	  'ancho',
	  'alto',
	  'fondo',
	  'ancho_hasta',
	  'alto_hasta',
	  'fondo_hasta',
	) ) ) {
	  $field['disabled'] = true;  
	}
  
	return $field;
  
}
// add_filter( 'acf/load_field', 'dorzki_acf_read_only_field' );
  
  function composiciones_ejemplo() {
  
	  if ( !is_tax( 'categoria_producto' ) && !is_tax( 'coleccion' ) ) return false;
      
	  $term = get_queried_object();
  
	  $args = array(
		  'post_type'         => 'composicion',
		  'posts_per_page'    => -1,
		  'tax_query'				=> array(
			  array(
				  'taxonomy'		=> $term->taxonomy,
				  'terms'			=> $term->term_id,
			  ),
		  ),
		  'posts_per_page'		=> -1,
		  'orderby'				=> 'title',
		  'oreder'				=> 'ASC',
	  );
  
	  $q = new WP_Query($args);
  
	  if ( $q->have_posts() ) : ?>
  
		  <h2 class="is-style-lined"><?php echo sprintf( __( 'Combinaciones %s', 'kyrya' ), $term->name ); ?></h2>
  
		  <div class="row no-gutters g-2 mb-5 pb-5 bloques">
  
			  <?php while ( $q->have_posts() ) : $q->the_post(); ?>
  
				  <?php get_template_part( 'loop-templates/content' ); ?>
  
			  <?php endwhile; ?>
  
		  </div>
  
	  <?php endif;
  
  }
  
  add_filter( 'term_link', 'modificar_destino_term_link', 10, 3 );
  function modificar_destino_term_link( $url, $term, $taxonomy ) {
  
	  if ( 'categoria_producto' === $taxonomy ) {
  
		  $pagina_id = get_field( 'redireccion', $term );
		  
		  if ( !empty( $pagina_id ) ) {
  
			  $nueva_url = get_permalink( $pagina_id );
			  if ( $nueva_url ) {
				  return $nueva_url; // Devuelve la nueva URL si es válida
			  }
		  }
	  }
	  
	  return $url;
  }
  
  function smn_back_button() {
	  
	    $q_obj_trans = get_queried_object();
  
	    $ancestors = get_ancestors( $q_obj_trans->term_id, $q_obj_trans->taxonomy, 'taxonomy' );
        $link = false;

        if (!empty($ancestors)) {
            $parent = get_term( $ancestors[0] );
            $link = get_term_link( $parent );
            $title = $parent->name;
        } else {
            if ( in_array( $q_obj_trans->taxonomy, array( 'categoria_producto', 'coleccion' ) ) ) {
                $link = get_the_permalink( PRODUCTOS_ID );
                $title = get_the_title( PRODUCTOS_ID );
            }
        }

        if ( $link ) {
            echo '<a href="'. $link .'" class="text-muted"><i class="fa fa-chevron-left me-2"></i> '.sprintf(__( 'Volver a %s', 'kyrya' ), $title ).'</a>';
        }
  
  }

