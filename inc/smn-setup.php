<?php
/**
 * Theme basic setup.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 960; /* pixels */
}

add_action( 'after_setup_theme', 'smn_setup' );
function smn_setup() {

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'understrap' ),
		// 'secondary' => __( 'Secondary Menu', 'understrap' ),
        'legal' => __( 'Páginas legales', 'smn-admin' ),
        // 'account'  => __( 'Páginas de usuario', 'smn-admin' ),
        // 'movil'  => __( 'Menú móvil', 'smn-admin' ),
	) );

}

function understrap_all_excerpts_get_more_link( $post_excerpt ) {
	if ( ! is_admin() && $post_excerpt ) {
		$post_excerpt = $post_excerpt . ' [...]';
	}
	return $post_excerpt;
}

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
     return 30;
}

add_filter( 'get_the_archive_title', 'prefix_category_title' );
function prefix_category_title( $title ) {
    if ( is_tax() || is_category() || is_tag() ) {
        $title = single_term_title( '', false );
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    }
    return $title;
}

add_action( 'pre_get_posts', 'smn_pre_get_posts' );
function smn_pre_get_posts($query) {
if (!$query->is_main_query() || is_admin() ) return;

    if (is_search()) {
        $query->set('posts_per_page', 24);
    } elseif( is_home() || 'post' == $query->get('post_type') ) {
        $query->set('posts_per_page', 12);
	} else {
        $query->set( 'posts_per_page', -1 );
        return;
    }
}



function filter_productos_by_taxonomies( $post_type, $which ) {

	// Apply this only on a specific post type
	// if ( 'car' !== $post_type )
	// 	return;


	// A list of taxonomy slugs to filter by
	// $taxonomies = array( 'manufacturer', 'model', 'transmission', 'doors', 'color' );
	$taxonomies = get_object_taxonomies( $post_type );
	if (($key = array_search('acabado', $taxonomies)) !== false) {
	    unset($taxonomies[$key]);
	}

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( array(
			'taxonomy'	=> $taxonomy_slug,
			'orderby' 	=> 'name',
			'hide_empty'	=> true,
		) );

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Todos los %s' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}
add_action( 'restrict_manage_posts', 'filter_productos_by_taxonomies' , 10, 2);



add_filter('manage_posts_columns', 'kyrya_columns_head');
add_action('manage_posts_custom_column', 'kyrya_columns_content', 10, 2);


// ADD NEW COLUMN
function kyrya_columns_head($defaults) {
	// $defaults = array('featured_image' => 'Imagen') + $defaults;
    // $defaults['featured_image'] = 'Imagen';
    // $defaults['referencia'] = 'Referencia';
    // $defaults['slug'] = 'Slug';
    // $defaults['excerpt-content'] = 'Contenido';
    // $defaults['medidas'] = 'Medidas';
    // $defaults['texto_destacado'] = 'Destacado';
    $defaults['croquis'] = 'Croquis';

	$defaults['metadata'] = 'Metadata';

    return $defaults;
}
 
// SHOW THE COLUMNS CONTENT
function kyrya_columns_content($column_name, $post_ID) {
    // if ($column_name == 'featured_image') {
    // 	echo get_the_post_thumbnail( $post_ID, array(80,80) );
    // }
    // if ($column_name == 'excerpt') {
    // 	echo get_the_excerpt( $post_ID );
    // }
    switch ($column_name) {
		case 'metadata':
			$medidas = get_field('medidas', $post_ID);
            $diametro = get_field('diametro', $post_ID);
            echo '<span style="color:lightgray;"><b>Medidas: </b></span>' . $medidas . '<br>';
            echo '<span style="color:lightgray;"><b>Ø: </b></span>' . $diametro . '<br>';

            echo '<span style="color:lightgray;"><b>Texto destacado: </b></span>' . get_field('texto_destacado', $post_ID) . '<br>';
            echo '<span style="color:lightgray;"><b>Referencia: </b></span>' . get_field('referencia', $post_ID) . '<br>';

        	$post = get_post($post_ID);
        	echo '<b style="color:lightgray;">Extracto:</b><br>';
        	echo $post->post_excerpt;
        	echo '<hr>';
        	echo '<b style="color:lightgray;">Contenido:</b><br>';
    		echo $post->post_content;
			break;

        case 'featured_image':
            echo '<img src="'.get_the_post_thumbnail_url( $post_ID, 'medium' ).'" height="100" style="max-width:120px;" />';
            break;
        
        case 'croquis':
            $img = get_post_meta( $post_ID, 'plano' );
            echo '<img src="' . wp_get_attachment_image_url( $img, 'medium' ) . '" height="100" style="max-width:120px;" />';
            break;
        
        case 'slug':
            echo get_post_field( 'post_name', $post_ID, 'raw' );
            break;
        
        case 'excerpt-content':
        	$post = get_post($post_ID);
        	echo '<b style="color:lightgray;">Extracto:</b><br>';
        	echo $post->post_excerpt;
        	echo '<hr>';
        	echo '<b style="color:lightgray;">Contenido:</b><br>';
    		echo $post->post_content;
            break;

        case 'medidas':
            $medidas = get_field('medidas', $post_ID);
            $diametro = get_field('diametro', $post_ID);
            echo '<span style="color:lightgray;"><b>Medidas: </b></span>' . $medidas . '<br>';
            echo '<span style="color:lightgray;"><b>Ø: </b></span>' . $diametro . '<br>';
            break;
        
        case 'texto_destacado':
            the_field('texto_destacado', $post_ID);
            break;
        
        case 'referencia':
            the_field('referencia', $post_ID);
            break;
        
        default:
            # code...
            break;
    }
}


// Admin columnas personalizadas downloads
add_filter('manage_edit-dlm_download_columns', 'columnas_personalizadas_descargas');
function columnas_personalizadas_descargas($columns) {
    $columns['traduccion_titulo'] = __( 'Traducciones', 'kyrya' );
    return $columns;
}
// Render the custom columns for the "DOWNLOADS" post type
add_action('manage_dlm_download_posts_custom_column', 'render_columnas_personalizadas_descargas', 10, 2);
function render_columnas_personalizadas_descargas($column_name) {
    global $post;
    switch ($column_name) {
         case 'traduccion_titulo':
         $traducciones = get_post_meta( $post->ID, $column_name, true );
         if( $traducciones) {
            echo $traducciones;
            // echo(sprintf( '<span class="acf-field %s">%s</span>', $column_name, $traducciones ) );
        }
        break;
    }
}


// COLUMNAS EN TABLAS DE USUARIOS
function kyrya_modify_user_table( $column ) {
    // $column['telefono'] = 'Teléfono';
    $column['registrado'] = 'Registrado el';
    // $column['descargas'] = 'Descargas';
    // $column['activado'] = 'Activado';
    return $column;
}
add_filter( 'manage_users_columns', 'kyrya_modify_user_table' );

function kyrya_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'telefono' :
        	$telefono = get_the_author_meta( 'phone1', $user_id );
        	$telefono_link = 'tel:' . str_replace(' ', '', $telefono);
            return '<b><a href="'.$telefono_link.'"><span class="dashicons dashicons-phone"></span> ' . $telefono . '</a></b><br><small>' . get_the_author_meta( 'perfil', $user_id ) . ' (' . get_the_author_meta( 'city', $user_id ) . ')</small>';
            break;
        case 'activado' :
        	$r = '<a href="'.get_edit_user_link( $user_id ).'#activate_user" title="';
	        	if ('1' == get_the_author_meta( 'active', $user_id ) ) {
	        		$r .= __( 'Desactivar', 'kyrya-admin' ) . '">';
	        	    $r .= '<span style="color:lightblue;">' . __( 'Sí', 'kyrya-admin' );
	        	} else {
	        		$r .= __( 'Activar', 'kyrya-admin' ) . '">';
	        		$r .= '<span style="color:red;">' . __( 'No', 'kyrya-admin' );
	        	}

	        	$r .= ' <span class="dashicons dashicons-arrow-right-alt" style=""></span></span>';
	        $r .= '</a>';

        	return $r;

            break;
        case 'registrado' :
        	$user_data = get_userdata( $user_id );
        	$registered = $user_data->user_registered;
        	// return $registered;
        	return date_i18n( get_option('date_format'), strtotime( $registered ) );
        	break;

        case 'descargas' :
        	global $wpdb;
        	$r = '';
        	$descargas = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}download_log WHERE user_id = {$user_id}", OBJECT );
        	if (!empty($descargas)) {
        		$r .= '<p style="border-bottom:1px solid lightgray;"><strong>'.__( 'Total', 'kyrya-admin' ).': '.count($descargas).'</strong></p>';
        		$r .= '<ul style="line-height:1.2; overflow:hidden;" class="colapsar">';
	        	foreach ($descargas as $descarga) {
		        	$r .= '<li><small>' . get_the_title( $descarga->download_id ) . ' <span style="color:lightgray;">(' . date_i18n( get_option('date_format'), strtotime( $descarga->download_date ) )  . ')</span></small></li>';
		        	// $r .= '<li>' . get_the_title( $descarga->download_id ) . '</li>';
	        	}
	        	$r .= '</ul>';
		    }



	        return $r;
        	break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'kyrya_modify_user_table_row', 10, 3 );

add_action( 'admin_footer', 'estilos_y_scripts_admin', 10 );
function estilos_y_scripts_admin() {
	global $pagenow;
	if ('users.php' == $pagenow) { ?>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
				  var maxheight=100;
				  var showText = "<?php _e('...<br>Ver más', 'kyrya-admin'); ?>";
				  var hideText = "[<?php _e('Cerrar', 'kyrya-admin'); ?>]";

				  $('.colapsar').each(function () {
				    var text = $(this);
				    if (text.height() > maxheight){
				        text.css('max-height', maxheight + 'px').addClass('oculto');

				        var link = $('<a class="leer-mas" href="#">' + showText + '</a>');
				        var linkDiv = $('<div></div>');
				        linkDiv.append(link);
				        $(this).after(linkDiv);

				        link.click(function (event) {
				          event.preventDefault();
				          if (text.height() > maxheight) {
				              $(this).html(showText);
				              text.css('max-height', maxheight + 'px').addClass('oculto');
				          } else {
				              $(this).html(hideText);
				              text.css('max-height', '10000px').removeClass('oculto');
				          }
				        });
				    }       
				  });
				});
			</script>
	<?php }
}

add_filter( 'manage_users_sortable_columns', 'kyrya_make_registered_column_sortable' );
function kyrya_make_registered_column_sortable( $columns ) {
	return wp_parse_args( array( 
		'registrado' => 'reg',
		// 'activado' => 'act',
		 ), $columns );
	// return wp_parse_args( array( 'activado' => 'act' ), $columns );
}


add_action( 'pre_user_query', 'kyrya_pre_user_query', 1 );
function kyrya_pre_user_query( $query ) {
    global $wpdb, $current_screen;

    // Only filter in the admin
    if ( ! is_admin() )
        return;

    // Only filter on the users screen
    if ( ! ( isset( $current_screen ) && 'users' == $current_screen->id ) )
        return;
  
   	// echo '<pre>'; print_r($query); echo '</pre>';


	if ( !isset( $_GET['orderby'] ) ) {
		$query->query_orderby = 'ORDER BY user_registered DESC';
		return;
	}

    // We need the order - default is ASC
    $order = isset( $query->query_vars ) && isset( $query->query_vars[ 'order' ] ) && strcasecmp( $query->query_vars[ 'order' ], 'asc' ) == 0 ? 'ASC' : 'DESC';


    // Only filter if orderby is set to 'art'
    if ( 'reg' == $query->query_vars[ 'orderby' ] ) {
        // Order the posts by product count
        // $query->query_orderby = "ORDER BY ( SELECT COUNT(*) FROM {$wpdb->posts} products WHERE products.post_type = 'product' AND products.post_status = 'publish' AND products.post_author = {$wpdb->users}.ID ) {$order}";
    	$query->query_orderby = 'ORDER BY user_registered ' . $order;
    } elseif ( 'act' == $query->query_vars[ 'orderby' ] ) {
    	// $query->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='active')";
    	$query->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='active')";
        $query->query_orderby = ' ORDER BY UPPER(m1.meta_value) '. $order;
    }

}