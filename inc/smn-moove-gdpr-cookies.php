<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Fuerza la recarga de la página cuando guardas ajustes.
add_action( 'gdpr_force_reload', '__return_true' );

// Actualiza la capa de datos cuando se guardan ajustes de GDPR Cookie Compliance
// Configurar el plugin renombrando los tipos de cookies así:
// Cookies de terceros => Cookies de analítica
// Cookies adicionales => Cookies de marketing
add_action( 'wp_enqueue_scripts', 'smn_set_consent_status' );
function smn_set_consent_status() {

  if ( !function_exists( 'gdpr_cookie_is_accepted' ) ) return false;

  $strict_consent 					= 'denied';
  $thirdparty_consent 			= 'denied';
  $advanced_consent 			  = 'denied';

  ob_start(); ?>

    // Define dataLayer and the gtag function.
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}

    // Default ad_storage and analytics_storage to 'denied'.
    gtag('consent', 'default', {
      'ad_storage': 'denied',
      'analytics_storage': 'denied',
    });

  <?php $default_consent = ob_get_clean();

  wp_register_script( 'gdpr-consent-default', '' );
  wp_enqueue_script( 'gdpr-consent-default' );
  wp_add_inline_script( 'gdpr-consent-default', $default_consent );

  if ( gdpr_cookie_is_accepted( 'strict' ) ) :
    $strict_consent = 'granted';
  endif;

  if ( gdpr_cookie_is_accepted( 'thirdparty' ) ) :
    $thirdparty_consent = 'granted';
  endif;

  if ( gdpr_cookie_is_accepted( 'advanced' ) ) :
    $advanced_consent = 'granted';
  endif;

  wp_register_script( 'gdpr-consent-update', '' );
  wp_enqueue_script( 'gdpr-consent-update' );
  wp_add_inline_script( 'gdpr-consent-update', "gtag('consent', 'update', {'analytics_storage': '".$thirdparty_consent."'});gtag('consent', 'update', {'ad_storage': '".$advanced_consent."'});gtag('consent', 'update', {'functionality_storage': '".$strict_consent."'});gtag('consent', 'update', {'security_storage': '".$strict_consent."'});gtag('consent', 'update', {'personalization_storage': '".$strict_consent."'});" );

}

add_filter( 'wp_nav_menu_items', 'smn_add_menu_item', 10, 2 );
function smn_add_menu_item ( $items, $args ) {

  if( $args->theme_location == 'legal' ) {
    $items .=  '<li class="menu-item" id="menu-itemmoove-gdpr menu-item nav-item">';
      $items .= '<a href="#gdpr_cookie_modal" class="nav-link">'.__('Ajustes de cookies', 'smn').'</a>';
    $items .= '</li>';
  } 
  return $items;
}

add_filter('gdpr_cookie_script_cache','gdpr_prevent_script_cache');
function gdpr_prevent_script_cache() {
    return array();
}

add_action('moove_gdpr_third_party_header_assets','moove_gdpr_third_party_header_assets');
function moove_gdpr_third_party_header_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-head-anulados");</script>';     
    }
  return $scripts;
}
add_action('moove_gdpr_third_party_body_assets','moove_gdpr_third_party_body_assets');
function moove_gdpr_third_party_body_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-body-anulados");</script>';     
    }
  return $scripts;
}
add_action('moove_gdpr_third_party_footer_assets','moove_gdpr_third_party_footer_assets');
function moove_gdpr_third_party_footer_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-footer-anulados");</script>';     
    }
  return $scripts;
}

add_filter( 'render_block', 'video_block_wrapper', 10, 2 );
function video_block_wrapper( $block_content, $block ) {
    if ( $block['blockName'] === 'core/embed' ) {

      if ( !gdpr_cookie_is_accepted( 'thirdparty' ) ) {

        $replacement = '<a href="#gdpr_cookie_modal" class="iframe-replacement btn btn-primary d-block">'. __( 'Por favor, acepta el uso de cookies de terceros para ver este contenido externo. Pulsa aquí.', 'smn' ) . '</a>';
        return $replacement;

      }
    }

    return $block_content;
}

add_filter( 'the_content', 'filtrar_contenido_para_evitar_cookies', 1000, 1);
function filtrar_contenido_para_evitar_cookies( $content ) {

    if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {

      $content = str_replace( 'youtube.com/embed', 'youtube-nocookie.com/embed', $content );

      /* supported types: 'strict', 'thirdparty', 'advanced' */
      if ( !gdpr_cookie_is_accepted( 'thirdparty' ) ) {

        $replacement = '<a href="#gdpr_cookie_modal" class="iframe-replacement btn btn-primary d-block">'. __( 'Por favor, acepta el uso de cookies de terceros para ver este contenido externo. Pulsa aquí.', 'smn' ) . '</a>';

        $content = preg_replace( '#<iframe[^>]+>.*?</iframe>#is', $replacement, $content );

      }

    }

    return $content;
}

// Custom Scripts based on front-end language
add_action('comments_open', function( $comments_open ){
  if ( function_exists( 'gdpr_cookie_is_accepted' ) ) :
  // supported types: 'strict', 'thirdparty', 'advanced' 
  if ( gdpr_cookie_is_accepted( 'thirdparty' ) ) :
  return $comments_open;
  else :
  return false;
  endif;
  endif;
  return $comments_open;
});