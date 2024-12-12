<?php
/**
 * Understrap Theme Customizer
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
* Crear panel de opciones en el customizador
*/
function smn_new_customizer_settings($wp_customize) {
    $web_title = get_bloginfo( 'name' );
    // create settings section
    $wp_customize->add_panel('smn_opciones', array(
        'title'         => $web_title . ': ' . __( 'Opciones de configuración', 'smn-admin' ),
        'description'   => __( 'Opciones para este sitio web', 'smn-admin' ),
        'priority'      => 1,
    ));
    $wp_customize->add_section('smn_redes_sociales', array(
        'title'         => __( 'Redes sociales', 'smn-admin' ),
        'priority'      => 20,
        'panel'         => 'smn_opciones',
    ));
    $wp_customize->add_section('smn_ajustes', array(
        'title'         => __( 'Otros ajustes', 'smn-admin' ),
        'priority'      => 20,
        'panel'         => 'smn_opciones',
    ));



    $redes_sociales = array(
        'email',
        'whatsapp',
        'linkedin',
        'twitter',
        'facebook',
        'instagram',
        'youtube',
        'skype',
        'pinterest',
        'flickr',
        'blog',
    );

    foreach ($redes_sociales as $red) {
        // add a setting
        $wp_customize->add_setting($red);
        
        // Add a control
        $wp_customize->add_control( $red,   array(
            'type'      => 'text',
            'label'     => 'URL ' . $red,
            'section'   => 'smn_redes_sociales',
        ) );
    }

}
add_action('customize_register', 'smn_new_customizer_settings');
