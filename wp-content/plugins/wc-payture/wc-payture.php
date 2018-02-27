<?php

/**
Plugin Name: WooCommerce - Payture Payment Gateway
Description: Allows you to use Payture payment gateway with the WooCommerce plugin.
Version: 0.1.1.1
Author: Payture
Text Domain: wc-payture
Domain Path: /languages
*/

if(!defined('ABSPATH'))
{
    exit;
}

add_action('plugins_loaded', 'woocommerce_payture_init', 0);

function woocommerce_payture_init()
{
    /**
     * Main check
     */
    if (!class_exists('WC_Payment_Gateway'))
    {
        return;
    }

    /**
     * Gate exists?
     */
    if(class_exists('WC_Payture'))
    {
        return;
    }

    /**
     * Wc_Payture_Logger class load
     */
    include_once dirname(__FILE__) . '/class-wc-payture-logger.php';

    /**
     * Define plugin url
     */
    define('WC_PAYTURE_URL', plugin_dir_url(__FILE__));

    /**
     * Load language
     */
    load_plugin_textdomain( 'wc-payture',  false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

    /**
     * Check status
     */
    if( class_exists('WooCommerce_Payment_Status') )
    {
        add_filter( 'woocommerce_valid_order_statuses_for_payment', array( 'WC_Payture', 'valid_order_statuses_for_payment' ), 52, 2 );
    }

    /**
     * Gateway class load
     */
    include_once dirname(__FILE__) . '/class-wc-payture.php';

    /**
     * Add the gateway to WooCommerce
     **/
    function woocommerce_add_payture_gateway($methods)
    {
        $methods[] = 'WC_Payture';

        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'woocommerce_add_payture_gateway');
}

/**
 * Get WooCommerce version
 *
 * @return mixed
 */
function woocommerce_payture_get_version()
{
    if ( ! function_exists( 'get_plugins' ) )
    {
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    $plugin_folder = get_plugins( '/' . 'woocommerce' );
    $plugin_file = 'woocommerce.php';

    if(isset( $plugin_folder[$plugin_file]['Version'] ))
    {
        return $plugin_folder[$plugin_file]['Version'];
    }

    return null;
}