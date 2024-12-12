<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_post_type_support( 'page', 'excerpt' );
// add_action( 'init', 'smn_settings', 1000 );
// function smn_settings() {  
    // register_taxonomy_for_object_type('category', 'page');  
// }



if ( ! function_exists('custom_post_type_slide') ) {

	// Register Custom Post Type
	function custom_post_type_slide() {
	
		$labels = array(
			'name'                  => _x( 'Slides', 'Post Type General Name', 'kyrya' ),
			'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'kyrya' ),
			'menu_name'             => __( 'Slides', 'kyrya-admin' ),
			'name_admin_bar'        => __( 'Slide', 'kyrya-admin' ),
			'add_new'               => __( 'Añadir nueva', 'kyrya-admin' ),
			'add_new_item'          => __( 'Añadir nueva Slide', 'kyrya-admin' ),
			'new_item'              => __( 'Nueva Slide', 'kyrya-admin' ),
			'edit_item'             => __( 'Editar Slide', 'kyrya-admin' ),
			'update_item'           => __( 'Actualizar Slide', 'kyrya-admin' ),
			'view_item'             => __( 'Ver Slide', 'kyrya-admin' ),
			'view_items'            => __( 'Ver Slide', 'kyrya-admin' ),
		);
		$args = array(
			'label'                 => __( 'Slides', 'kyrya' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-slides',
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'taxonomies'			=> array('cat_slide'),
			'show_in_rest'          => true,
		);
		register_post_type( 'slide', $args );
	
	}
	add_action( 'init', 'custom_post_type_slide', 0 );
	
} 

if ( ! function_exists('custom_post_type_composicion') ) {

// Register Custom Post Type
function custom_post_type_composicion() {

	$labels = array(
		'name'                  => _x( 'Kyrya Spaces', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Kyrya Space', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Kyrya Spaces', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Kyrya Space', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo', 'kyrya-admin' ),
		'add_new_item'          => __( 'Añadir nuevo Kyrya Space', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Kyrya Space', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Kyrya Space', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Kyrya Space', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Kyrya Space', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Kyrya Spaces', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Kyrya Spaces', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-images-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => __('kyrya-spaces', 'kyrya'),
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('coleccion', 'categoria_producto'),

	);
	register_post_type( 'composicion', $args );

}
add_action( 'init', 'custom_post_type_composicion', 0 );

}


if ( ! function_exists('custom_post_type_productos') ) {

// Register Custom Post Type
function custom_post_type_productos() {

	$labels = array(
		'name'                  => _x( 'Productos', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Producto', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Productos', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Producto', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo', 'kyrya-admin' ),
		'add_new_item'          => __( 'Añadir nuevo Producto', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Producto', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Producto', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Producto', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Producto', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Productos', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Producto', 'kyrya' ),
		'description'           => __( 'Nuestro catálogo', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-screenoptions',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('categoria_producto'),
	);
	register_post_type( 'producto', $args );

}
add_action( 'init', 'custom_post_type_productos', 0 );

}

if ( ! function_exists('custom_post_type_opcion_productos') ) {

// Register Custom Post Type
function custom_post_type_opcion_productos() {

	$labels = array(
		'name'                  => _x( 'Opciones de producto', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Opción de producto', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Opciones de producto', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Opción de producto', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nueva ', 'kyrya-admin' ),
		'add_new_item'          => __( 'Añadir nueva Opción de producto', 'kyrya-admin' ),
		'new_item'              => __( 'Nueva Opción de producto', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Opción de producto', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Opción de producto', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Opción de producto', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Opciones de producto', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Opción de producto', 'kyrya' ),
		// 'description'           => __( 'Nuestro catálogo', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-image-filter',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		// 'taxonomies'			=> array('categoria_producto'),
	);
	register_post_type( 'opcion_producto', $args );

}
add_action( 'init', 'custom_post_type_opcion_productos', 0 );

}


if ( ! function_exists('custom_post_type_integrated_spaces') ) {

// Register Custom Post Type
function custom_post_type_integrated_spaces() {

	$labels = array(
		'name'                  => _x( 'Integrated Spaces', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Integrated Space', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Integrated Spaces', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Integrated Space', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo', 'kyrya-admin' ),
		'add_new_item'          => __( 'Añadir nuevo Integrated Space', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Integrated Space', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Integrated Space', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Integrated Space', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Integrated Space', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Integrated Space', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Integrated Space', 'kyrya' ),
		'description'           => __( 'Solución integral', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-home',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('categoria_producto'),
	);
	register_post_type( 'integrated_space', $args );

}
// add_action( 'init', 'custom_post_type_integrated_spaces', 0 );

}

// if ( ! function_exists('custom_post_type_solution_spaces') ) {

// // Register Custom Post Type
// function custom_post_type_solution_spaces() {

// 	$labels = array(
// 		'name'                  => _x( 'Solution Spaces', 'Post Type General Name', 'kyrya' ),
// 		'singular_name'         => _x( 'Solution Space', 'Post Type Singular Name', 'kyrya' ),
// 		'menu_name'             => __( 'Solution Spaces', 'kyrya-admin' ),
// 		'name_admin_bar'        => __( 'Solution Space', 'kyrya-admin' ),
// 		'add_new'               => __( 'Añadir nuevo', 'kyrya-admin' ),
// 		'add_new_item'          => __( 'Añadir nuevo Solution Space', 'kyrya-admin' ),
// 		'new_item'              => __( 'Nuevo Solution Space', 'kyrya-admin' ),
// 		'edit_item'             => __( 'Editar Solution Space', 'kyrya-admin' ),
// 		'update_item'           => __( 'Actualizar Solution Space', 'kyrya-admin' ),
// 		'view_item'             => __( 'Ver Solution Space', 'kyrya-admin' ),
// 		'view_items'            => __( 'Ver Solution Space', 'kyrya-admin' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Integrated Space', 'kyrya' ),
// 		'description'           => __( 'Mobiliario a medida', 'kyrya' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 5,
// 		'menu_icon'             => 'dashicons-admin-home',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => true,
// 		'can_export'            => true,
// 		'has_archive'           => true,
// 		'exclude_from_search'   => false,
// 		'publicly_queryable'    => true,
// 		'capability_type'       => 'page',
// 		'taxonomies'			=> array('categoria_producto'),
// 	);
// 	register_post_type( 'solution_space', $args );

// }
// add_action( 'init', 'custom_post_type_solution_spaces', 0 );

// }


// if ( ! function_exists('custom_post_type_estructuras') ) {

// // Register Custom Post Type
// function custom_post_type_estructuras() {

// 	$labels = array(
// 		'name'                  => _x( 'Estructuras', 'Post Type General Name', 'kyrya' ),
// 		'singular_name'         => _x( 'Estructura', 'Post Type Singular Name', 'kyrya' ),
// 		'menu_name'             => __( 'Estructuras', 'kyrya-admin' ),
// 		'name_admin_bar'        => __( 'Estructura', 'kyrya-admin' ),
// 		'add_new'               => __( 'Añadir nueva', 'kyrya-admin' ),
// 		'add_new_item'          => __( 'Añadir nueva Estructura', 'kyrya-admin' ),
// 		'new_item'              => __( 'Nueva Estructura', 'kyrya-admin' ),
// 		'edit_item'             => __( 'Editar Estructura', 'kyrya-admin' ),
// 		'update_item'           => __( 'Actualizar Estructura', 'kyrya-admin' ),
// 		'view_item'             => __( 'Ver Estructura', 'kyrya-admin' ),
// 		'view_items'            => __( 'Ver Estructuras', 'kyrya-admin' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Estructura', 'kyrya' ),
// 		// 'description'           => __( 'Todas las posibilidades', 'kyrya' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 5,
// 		'menu_icon'             => 'dashicons-admin-appearance',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => true,
// 		'can_export'            => true,
// 		'has_archive'           => true,
// 		'exclude_from_search'   => false,
// 		'publicly_queryable'    => true,
// 		'capability_type'       => 'page',
// 		'taxonomies'			=> array('coleccion'),
// 	);
// 	register_post_type( 'estructura', $args );

// }
// add_action( 'init', 'custom_post_type_estructuras', 0 );

// }

if ( ! function_exists('custom_post_type_acabados') ) {

// Register Custom Post Type
function custom_post_type_acabados() {

	$labels = array(
		'name'                  => _x( 'Acabados', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Acabado', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Acabados', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Acabado', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo', 'kyrya-admin' ),
		'add_new_item'          => __( 'Añadir nuevo Acabado', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Acabado', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Acabado', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Acabado', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Acabado', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Acabados', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Acabado', 'kyrya' ),
		'description'           => __( 'Todas las posibilidades', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-appearance',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('categoria_acabado'),
	);
	register_post_type( 'acabado', $args );

}
add_action( 'init', 'custom_post_type_acabados', 0 );

}


// if ( ! function_exists('custom_post_type_aperturas') ) {

// // Register Custom Post Type
// function custom_post_type_aperturas() {

// 	$labels = array(
// 		'name'                  => _x( 'Aperturas', 'Post Type General Name', 'kyrya' ),
// 		'singular_name'         => _x( 'Apertura', 'Post Type Singular Name', 'kyrya' ),
// 		'menu_name'             => __( 'Aperturas', 'kyrya-admin' ),
// 		'name_admin_bar'        => __( 'Apertura', 'kyrya-admin' ),
// 		'add_new'               => __( 'Añadir nueva', 'kyrya-admin' ),
// 		'add_new_item'          => __( 'Añadir nueva Apertura', 'kyrya-admin' ),
// 		'new_item'              => __( 'Nueva Apertura', 'kyrya-admin' ),
// 		'edit_item'             => __( 'Editar Apertura', 'kyrya-admin' ),
// 		'update_item'           => __( 'Actualizar Apertura', 'kyrya-admin' ),
// 		'view_item'             => __( 'Ver Apertura', 'kyrya-admin' ),
// 		'view_items'            => __( 'Ver Aperturas', 'kyrya-admin' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Apertura', 'kyrya' ),
// 		'description'           => __( '', 'kyrya' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 5,
// 		'menu_icon'             => 'dashicons-editor-expand',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => true,
// 		'can_export'            => true,
// 		'has_archive'           => true,
// 		'exclude_from_search'   => false,
// 		'publicly_queryable'    => true,
// 		'capability_type'       => 'page',
// 		'taxonomies'			=> array('tipo_apertura'),
// 	);
// 	register_post_type( 'apertura', $args );

// }
// add_action( 'init', 'custom_post_type_aperturas', 0 );

// }




if ( ! function_exists('cat_slide_function') ) {

// Register Custom Taxonomy
function cat_slide_function() {

	$labels = array(
		'name'                       => _x( 'Categorías de Slides', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Categoría de Slide', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Categorías de Slides', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'cat_slide', array( 'slide' ), $args );

}
add_action( 'init', 'cat_slide_function', 0 );

}

if ( ! function_exists('categoria_producto_function') ) {

// Register Custom Taxonomy
function categoria_producto_function() {

	$labels = array(
		'name'                       => _x( 'Categorías de producto', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Categoría de producto', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Categorías de producto', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'categoria_producto', array( 'producto', 'composicion', 'integrated_space', 'solution_space' ), $args );

}
add_action( 'init', 'categoria_producto_function', 0 );

}

if ( ! function_exists('coleccion_tax_function') ) {

// Register Custom Taxonomy
function coleccion_tax_function() {

	$labels = array(
		'name'                       => _x( 'Colecciones', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Coleccion', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Colecciones', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'coleccion', array( 'composicion' ), $args );

}
add_action( 'init', 'coleccion_tax_function', 0 );

}

// if ( ! function_exists('categoria_acabado_tax_function') ) {

// // Register Custom Taxonomy
// function categoria_acabado_tax_function() {

// 	$labels = array(
// 		'name'                       => _x( 'Categorías de acabados', 'Taxonomy General Name', 'kyrya' ),
// 		'singular_name'              => _x( 'Categoría de acabados', 'Taxonomy Singular Name', 'kyrya' ),
// 		'menu_name'                  => __( 'Categorías de acabados', 'kyrya-admin' ),
// 	);
// 	$args = array(
// 		'labels'                     => $labels,
// 		'hierarchical'               => true,
// 		'public'                     => true,
// 		'show_ui'                    => true,
// 		'show_admin_column'          => true,
// 		'show_in_nav_menus'          => true,
// 		'show_tagcloud'              => false,
// 	);
// 	register_taxonomy( 'categoria_acabado', array( 'acabado' ), $args );

// }
// add_action( 'init', 'categoria_acabado_tax_function', 0 );

// }

if ( ! function_exists('tipo_apertura_tax_function') ) {

// Register Custom Taxonomy
function tipo_apertura_tax_function() {

	$labels = array(
		'name'                       => _x( 'Tipos de Apertura', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Tipo de Apertura', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Tipos de Apertura', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'tipo_apertura', array( 'apertura' ), $args );

}
add_action( 'init', 'tipo_apertura_tax_function', 0 );

}


function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'portfolio_page' == $screen->post_type ) {
          $title = 'Título del proyecto';
     } elseif  ( 'slide' == $screen->post_type ) {
          $title = 'Título de la slide';
     } elseif  ( 'team' == $screen->post_type ) {
          $title = 'Nombre y apellidos';
     } elseif  ( 'product' == $screen->post_type ) {
          $title = 'Nombre del producto';
     }
  
     return $title;
}
add_filter( 'enter_title_here', 'wpb_change_title_text' );


?>