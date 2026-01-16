<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Envía un lead a Zoho Campaigns cuando se envía el formulario con post_id 57056 o sus traducciones (WPML), usando OAuth 2.0 (auth code).
 */
add_action('wpcf7_mail_sent', 'smn_send_lead_to_zoho_campaigns');
function smn_send_lead_to_zoho_campaigns($contact_form) {
	$target_form_id = 57056;
	// Obtener todas las traducciones del formulario con WPML
	if (function_exists('wpml_object_id_filter')) {
		$form_ids = array();
		$languages = apply_filters('wpml_active_languages', NULL, array());
		foreach ($languages as $lang) {
			$form_ids[] = apply_filters('wpml_object_id', $target_form_id, 'wpcf7_contact_form', false, $lang['language_code']);
		}
	} else {
		$form_ids = array($target_form_id);
	}

	$current_form_id = $contact_form->id();
	if (!in_array($current_form_id, $form_ids)) {
		return;
	}

	$submission = WPCF7_Submission::get_instance();
	if (!$submission) {
		return;
	}
	$data = $submission->get_posted_data();

	$first_name = isset($data['your-name']) ? $data['your-name'] : '';
	$email = isset($data['your-email']) ? $data['your-email'] : '';
	$country = isset($data['your-country-subscription-form']) ? $data['your-country-subscription-form'] : '';

	$api_url = 'https://campaigns.zoho.eu/api/v1.1/json/listsubscribe';
	$list_key = get_field('zoho_campaigns_list_key', 'option');

	// OAuth 2.0: obtener access token usando auth code (debes guardar el refresh_token, client_id y client_secret en las opciones del tema)
	$client_id = get_field('zoho_campaigns_client_id', 'option');
	$client_secret = get_field('zoho_campaigns_client_secret', 'option');
	$refresh_token = get_field('zoho_campaigns_refresh_token', 'option');
	$access_token = smn_zoho_get_access_token($client_id, $client_secret, $refresh_token);
	if (!$access_token) {
		error_log('Zoho: No se pudo obtener access token');
		return;
	}

	$payload = array(
		'listkey' => $list_key,
		'contactinfo' => json_encode(array(
			'First Name' => $first_name,
			'Email' => $email,
			'Country' => $country
		)),
		'resfmt' => 'JSON'
	);

	$args = array(
		'body' => $payload,
		'headers' => array(
			// 'Content-Type' => 'application/x-www-form-urlencoded',
            // No pongas Content-Type, WP lo pone automáticamente para form-data
			'Authorization' => 'Zoho-oauthtoken ' . $access_token
		),
		'timeout' => 15
	);

	$response = wp_remote_post($api_url, $args);
	error_log('Zoho response: ' . print_r($response, true));
	$body = wp_remote_retrieve_body($response);
	error_log('Zoho body: ' . $body);
}

/**
 * Obtiene un access token de Zoho usando refresh token. Cachea el token en transients.
 */
function smn_zoho_get_access_token($client_id, $client_secret, $refresh_token) {
	$transient_key = 'zoho_campaigns_access_token';
	$access_token = get_transient($transient_key);
	if ($access_token) {
		return $access_token;
	}
	$token_url = 'https://accounts.zoho.eu/oauth/v2/token';
	$params = array(
		'refresh_token' => $refresh_token,
		'client_id' => $client_id,
		'client_secret' => $client_secret,
		'grant_type' => 'refresh_token',
	);
	$response = wp_remote_post($token_url, array(
		'body' => $params,
		'timeout' => 15,
	));
	if (is_wp_error($response)) {
		error_log('Zoho token error: ' . $response->get_error_message());
		return false;
	}
	$body = json_decode(wp_remote_retrieve_body($response), true);
	if (isset($body['access_token'])) {
		set_transient($transient_key, $body['access_token'], 3300); // 55 min
		return $body['access_token'];
	}
	error_log('Zoho token response: ' . print_r($body, true));
	return false;
}
