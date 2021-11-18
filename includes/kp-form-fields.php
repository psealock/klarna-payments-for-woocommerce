<?php
/**
 * Adds the form fields for the payment gateway.
 *
 * @package WC_Klarna_Payments/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Countries that have no special requirements, and can have their form section built automatically.
 *
 * @var array $kp_form_auto_countries
 */
$kp_form_auto_countries = array(
	'Australia'      => 'au',
	'Austria'        => 'at',
	'Belgium'        => 'be',
	'Canada'         => 'ca',
	'Denmark'        => 'dk',
	'Germany'        => 'de',
	'Finland'        => 'fi',
	'France'         => 'fr',
	'Ireland'        => 'ie',
	'Italy'          => 'it',
	'Netherlands'    => 'nl',
	'Norway'         => 'no',
	'New Zealand'    => 'nz',
	'Poland'         => 'pl',
	'Portugal'       => 'pt',
	'Spain'          => 'es',
	'Sweden'         => 'se',
	'Switzerland'    => 'ch',
	'United Kingdom' => 'gb',
	'United States'  => 'us',
);

/**
 * Standardized form building for easier maintenance.
 * This builds the title part of a settings section.
 *
 * @param string $country_name The full name of the country as it should appear on the settings page.
 * @param string $flag_path Path to the flag SVG to use, relative to the plugin root.
 * @return array Completed title setting.
 */
function kp_form_country_title( $country_name, $flag_path ) {
	return array(
		'type'  => 'title',
		'title' => '<img src="' . plugins_url( $flag_path, WC_KLARNA_PAYMENTS_MAIN_FILE ) . '" height="12" /> ' . $country_name,
	);
}

/**
 * Standard Production Username section.
 *
 * @var array
 */
$kp_form_production_username = array(
	'title'       => __( 'Production Klarna API username', 'klarna-payments-for-woocommerce' ),
	'type'        => 'text',
	'description' => __( 'Use the API username you downloaded in the Klarna Merchant Portal. Don’t use your email address.', 'klarna-payments-for-woocommerce' ),
	'default'     => '',
	'desc_tip'    => false,
);

/**
 * Standard Production Password section.
 *
 * @var array $kp_form_production_password
 */
$kp_form_production_password = array(
	'title'       => __( 'Production Klarna API password', 'klarna-payments-for-woocommerce' ),
	'type'        => 'text',
	'description' => __( 'Use the API password you downloaded in the Klarna Merchant Portal. Don’t use your email address.', 'klarna-payments-for-woocommerce' ),
	'default'     => '',
	'desc_tip'    => false,
);

/**
 * Standard Test Username section.
 *
 * @var array
 */
$kp_form_test_username = array(
	'title'       => __( 'Test Klarna API username', 'klarna-payments-for-woocommerce' ),
	'type'        => 'text',
	'description' => __( 'Use the API username you downloaded in the Klarna Merchant Portal. Don’t use your email address.', 'klarna-payments-for-woocommerce' ),
	'default'     => '',
	'desc_tip'    => false,
);

/**
 * Standard Test password section.
 *
 * @var array
 */
$kp_form_test_password = array(
	'title'       => __( 'Test Klarna API password', 'klarna-payments-for-woocommerce' ),
	'type'        => 'text',
	'description' => __( 'Use the API password you downloaded in the Klarna Merchant Portal. Don’t use your email address.', 'klarna-payments-for-woocommerce' ),
	'default'     => '',
	'desc_tip'    => false,
);

/**
 * Build a completed form section from country name and ISO 3166-1 alpha-2.
 *
 * @param string $country_name Full name of the country, in English, as it should appear on the page.
 * @param string $country_code ISO 3166-1 alpha-2 country code of the country, like "SE" or "NO".
 *
 * @return array The completed section for the given country.
 */
function kp_form_country_section( $country_name, $country_code ) {

	global $kp_form_production_username;
	global $kp_form_production_password;
	global $kp_form_test_username;
	global $kp_form_test_password;

	$country_code = strtolower( $country_code );

	$section = array();

	$section[ 'credentials_' . $country_code ]        = kp_form_country_title( $country_name, 'assets/img/flags/' . $country_code . '.svg' );
	$section[ 'merchant_id_' . $country_code ]        = $kp_form_production_username;
	$section[ 'shared_secret_' . $country_code ]      = $kp_form_production_password;
	$section[ 'test_merchant_id_' . $country_code ]   = $kp_form_test_username;
	$section[ 'test_shared_secret_' . $country_code ] = $kp_form_test_password;

	return $section;

}

/**
 * Builds and returns the settings form structure.
 *
 * @return array The completed settings form structure
 */
function kp_form_build_settings() {

	global $kp_form_auto_countries;

	$settings = array(
		'enabled'              => array(
			'title'       => __( 'Enable/Disable', 'klarna-payments-for-woocommerce' ),
			'label'       => __( 'Enable Klarna Payments', 'klarna-payments-for-woocommerce' ),
			'type'        => 'checkbox',
			'description' => '',
			'default'     => 'no',
		),
		'title'                => array(
			'title'       => __( 'Title (not applicable to checkout)', 'klarna-payments-for-woocommerce' ),
			'type'        => 'text',
			'description' => __( 'Payment method title. Changes what the payment method is called on the order recieved page aswell as the email that is sent to the customer.', 'klarna-payments-for-woocommerce' ),
			'default'     => 'Klarna',
			'desc_tip'    => true,
		),
		'testmode'             => array(
			'title'       => __( 'Test mode', 'klarna-payments-for-woocommerce' ),
			'label'       => __( 'Enable Test Mode', 'klarna-payments-for-woocommerce' ),
			'type'        => 'checkbox',
			'description' => __( 'Place the payment gateway in test mode using test API keys.', 'klarna-payments-for-woocommerce' ),
			'default'     => 'yes',
			'desc_tip'    => true,
		),
		'logging'              => array(
			'title'       => __( 'Logging', 'klarna-payments-for-woocommerce' ),
			'label'       => __( 'Log debug messages', 'klarna-payments-for-woocommerce' ),
			'type'        => 'checkbox',
			'description' => __( 'Save debug messages to the WooCommerce System Status log.', 'klarna-payments-for-woocommerce' ),
			'default'     => 'no',
			'desc_tip'    => true,
		),
		'hide_what_is_klarna'  => array(
			'title'    => __( 'Hide What is Klarna? link', 'klarna-payments-for-woocommerce' ),
			'type'     => 'checkbox',
			'label'    => __( 'If checked, What is Klarna? will not be shown.', 'klarna-payments-for-woocommerce' ),
			'default'  => 'no',
			'desc_tip' => true,
		),
		'float_what_is_klarna' => array(
			'title'    => __( 'Float What is Klarna? link', 'klarna-payments-for-woocommerce' ),
			'type'     => 'checkbox',
			'label'    => __( 'If checked, What is Klarna? will be floated right.', 'klarna-payments-for-woocommerce' ),
			'default'  => 'yes',
			'desc_tip' => true,
		),
		'send_product_urls'    => array(
			'title'    => __( 'Product URLs', 'klarna-payments-for-woocommerce' ),
			'type'     => 'checkbox',
			'label'    => __( 'Send product and product image URLs to Klarna', 'klarna-payments-for-woocommerce' ),
			'default'  => 'yes',
			'desc_tip' => true,
		),
		'add_to_email'         => array(
			'title'    => __( 'Add Klarna Urls to order email', 'klarna-payments-for-woocommerce' ),
			'type'     => 'checkbox',
			'label'    => __( 'This will add Klarna urls to the order emails that are sent. You can read more about this here: ', 'klarna-payments-for-woocommerce' ) . '<a href="https://docs.klarna.com/guidelines/klarna-payments-best-practices/post-purchase-experience/order-confirmation/" target="_blank">Klarna URLs</a>',
			'default'  => 'no',
			'desc_tip' => true,
		),
		'customer_type'        => array(
			'title'       => __( 'Customer type', 'klarna-payments-for-woocommerce' ),
			'type'        => 'select',
			'label'       => __( 'Customer type', 'klarna-payments-for-woocommerce' ),
			'description' => __( 'Select the customer for the store.', 'klarna-payments-for-woocommerce' ),
			'options'     => array(
				'b2c' => __( 'B2C', 'klarna-payments-for-woocommerce' ),
				'b2b' => __( 'B2B', 'klarna-payments-for-woocommerce' ),
			),
			'default'     => 'b2c',
			'desc_tip'    => true,
		),
	);

	$countries = array();
	foreach ( $kp_form_auto_countries as $name => $alpha2 ) {
		$countries = array_merge( $countries, kp_form_country_section( $name, $alpha2 ) );
	}

	$settings = array_merge( $settings, $countries );

	$settings = array_merge(
		$settings,
		array(
			'iframe_options'        => array(
				'title' => 'Iframe settings',
				'type'  => 'title',
			),
			'color_border'          => array(
				'title'    => 'Border color',
				'type'     => 'color',
				'default'  => '',
				'desc_tip' => true,
			),
			'color_border_selected' => array(
				'title'    => 'Selected border color',
				'type'     => 'color',
				'default'  => '',
				'desc_tip' => true,
			),
			'color_text'            => array(
				'title'    => 'Text color',
				'type'     => 'color',
				'default'  => '',
				'desc_tip' => true,
			),
			'color_details'         => array(
				'title'    => 'Details color',
				'type'     => 'color',
				'default'  => '',
				'desc_tip' => true,
			),
			'color_text'            => array(
				'title'    => 'Text color',
				'type'     => 'color',
				'default'  => '',
				'desc_tip' => true,
			),
			'radius_border'         => array(
				'title'    => 'Border radius (px)',
				'type'     => 'number',
				'default'  => '',
				'desc_tip' => true,
			),
		)
	);

	return $settings;
}

return apply_filters( 'wc_gateway_klarna_payments_settings', kp_form_build_settings() );
