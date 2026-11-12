<?php
/**
 * Contact Form 7 integration: the footer subscribe form and the Contact Us
 * form.
 *
 * @package hopewave
 */

/*
 * Contact Form 7 wraps each line of a form template in <p> and <br> tags.
 * Turn that off so the templates' own markup is what the theme styles.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Lets visitors who aren't logged in reach Contact Form 7's REST routes.
 *
 * Contact Form 7 submits and validates forms through the REST API, which the
 * Disable XML-RPC-API plugin's "Disable JSON REST API" option closes to
 * logged-out visitors. That option skips requests another filter has already
 * decided, so answering first for these routes alone keeps the rest of the
 * API closed. It doesn't log anyone in or grant any permissions.
 *
 * @param WP_Error|null|true $result Authentication result so far.
 * @return WP_Error|null|true
 */
function hopewave_allow_contact_form_rest_routes( $result ) {
	if ( null !== $result || empty( $GLOBALS['wp']->query_vars['rest_route'] ) ) {
		return $result;
	}

	$route = $GLOBALS['wp']->query_vars['rest_route'];

	if ( preg_match( '#^/contact-form-7/v1/contact-forms/\d+/(feedback(/schema)?|refill)/?$#', $route ) ) {
		return true;
	}

	return $result;
}
add_filter( 'rest_authentication_errors', 'hopewave_allow_contact_form_rest_routes', 5 );
