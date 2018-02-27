<?php

class WC_Payture extends WC_Payment_Gateway
{
    /**
     * Current WooCommerce version
     *
     * @var
     */
    public $wc_version;

    /**
     * Current currency
     *
     * @var string
     */
    public $currency;

    /**
     * All support currency
     *
     * @var array
     */
    public $currency_all = array('RUB');

    /**
     * Merchant host
     *
     * @var string
     */
    public $merchant_host;

    /**
     * Merchant key
     *
     * @var string
     */
    public $merchant_key;

    /**
     * Merchant pass
     *
     * @var string
     */
    public $merchant_pass = '';

    /**
     * Unique gateway id
     *
     * @var string
     */
    public $id = 'payture';

    /**
     * User language
     *
     * @var string
     */
    public $language = 'ru';

    /**
     * @var mixed
     */
    public $test = 'no';

    /**
     * Test merchant host
     *
     * @var string
     */
    public $test_merchant_host = '';

    /**
     * Test merchant key
     *
     * @var string
     */
    public $test_merchant_key = '';

    /**
     * Test merchant pass
     *
     * @var string
     */
    public $test_merchant_pass = '';

    /**
     * Logger
     *
     * @var WC_Payture_Logger
     */
    public $logger;

    /**
     * Client IP
     */
    public $client_ip;

    /**
     * Logger path
     *
     * array
     * (
     *  'dir' => 'C:\path\to\wordpress\wp-content\uploads\logname.log',
     *  'url' => 'http://example.com/wp-content/uploads/logname.log'
     * )
     *
     * @var array
     */
    public $logger_path;

    /**
     * WC_Payture constructor
     */
    public function __construct()
    {
        /**
         * Logger?
         */
        $wp_dir = wp_upload_dir();
        $this->logger_path = array
        (
            'dir' => $wp_dir['basedir'] . '/wc-payture.txt',
            'url' => $wp_dir['baseurl'] . '/wc-payture.txt'
        );

        $this->logger = new WC_Payture_Logger($this->logger_path['dir'], $this->get_option('logger'));

        /**
         * Get currency
         */
        $this->currency = get_woocommerce_currency();

        /**
         * Logger debug
         */
        $this->logger->addDebug('Current currency: '.$this->currency);

        /**
         * Set WooCommerce version
         */
        $this->wc_version = woocommerce_payture_get_version();

        /**
         * Logger debug
         */
        $this->logger->addDebug('WooCommerce version: '.$this->wc_version);

        /**
         * Set client IP
         */
        $this->client_ip = $this->get_client_ip();

        /**
         * Set unique id
         */
        $this->id = 'payture';

        /**
         * What?
         */
        $this->has_fields = false;

        /**
         * Load settings
         */
        $this->init_form_fields();
        $this->init_settings();

        /**
         * Gateway enabled?
         */
        if($this->get_option('enabled') !== 'yes')
        {
            $this->enabled = false;

            /**
             * Logger notice
             */
            $this->logger->addNotice('Gateway is NOT enabled.');
        }

        /**
         * Title for user interface
         */
        $this->title = $this->get_option('title');

        /**
         * Testing?
         */
        if($this->get_option('test') !== '')
        {
            $this->test = $this->get_option('test');
        }

        /**
         * Default language for Payture interface
         */
        $this->language = $this->get_option('language');

        /**
         * Automatic language
         */
        if($this->get_option('language_auto') === 'yes')
        {
            /**
             * Logger notice
             */
            $this->logger->addNotice('Language auto is enable.');

            $lang = get_locale();
            switch($lang)
            {
                case 'en_EN':
                    $this->language = 'en';
                    break;
                case 'ru_RU':
                    $this->language = 'ru';
                    break;
                default:
                    $this->language = 'ru';
                    break;
            }
        }

        /**
         * Logger debug
         */
        $this->logger->addDebug('Language: ' . $this->language);

        /**
         * Set description
         */
        $this->description = $this->get_option('description');

        /**
         * Set order button text
         */
        $this->order_button_text = $this->get_option('order_button_text');

        /**
         * Set merchant host
         */
        if($this->get_option('merchant_host') !== '')
        {
            $this->merchant_host = $this->get_option('merchant_host');
        }

        /**
         * Load merchant key
         */
        if($this->get_option('merchant_key') !== '')
        {
            $this->merchant_key = $this->get_option('merchant_key');
        }

        /**
         * Set merchant pass
         */
        if($this->get_option('merchant_pass') !== '')
        {
            $this->merchant_pass = $this->get_option('merchant_pass');
        }


        /**
         * Set merchant key for testing
         */
        if($this->get_option('test_merchant_key') !== '')
        {
            $this->test_merchant_key = $this->get_option('test_merchant_key');
        }

        /**
         * Set merchant host for testing
         */
        if($this->get_option('test_merchant_host') !== '')
        {
            $this->test_merchant_host = $this->get_option('test_merchant_host');
            $this->logger->addDebug('Merchant test host: '.$this->test_merchant_host);
        }

        /**
         * Set merchant pass for testing
         */
        if($this->get_option('test_merchant_pass') !== '')
        {
            $this->test_merchant_pass = $this->get_option('test_merchant_pass');
        }

        /**
         * Set icon
         */
        if($this->get_option('enable_icon') === 'yes')
        {
            $this->icon = apply_filters('woocommerce_payture_icon', WC_PAYTURE_URL . '/assets/img/payture.png');
        }

        /**
         * Save admin options
         */
        if(current_user_can( 'manage_options' ))
        {
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

            /**
             * Logger notice
             */
            $this->logger->addDebug('Manage options is allow.');
        }

        /**
         * Receipt page
         */
        add_action('woocommerce_receipt_' . $this->id, array($this, 'receipt_page'));

        /**
         * Payment listener/API hook
         */
        add_action('woocommerce_api_wc_' . $this->id, array($this, 'check_ipn'));

        /**
         * Gate allow?
         */
        if ($this->is_valid_for_use())
        {
            /**
             * Logger notice
             */
            $this->logger->addInfo('Is valid for use.');
        }
        else
        {
            $this->enabled = false;

            /**
             * Logger notice
             */
            $this->logger->addInfo('Is NOT valid for use.');
        }
    }

    /**
     * Check if this gateway is enabled and available in the user's country
     */
    public function is_valid_for_use()
    {
        $return = true;

        /**
         * Check allow currency
         */
        if (!in_array($this->currency, $this->currency_all, false))
        {
            $return = false;

            /**
             * Logger notice
             */
            $this->logger->addDebug('Currency not support:'.$this->currency);
        }

        /**
         * Check test mode and admin rights
         */
        if ($this->test === 'yes' && !current_user_can( 'manage_options' ))
        {
            $return = false;

            /**
             * Logger notice
             */
            $this->logger->addNotice('Test mode only admins.');
        }

        return $return;
    }

    /**
     * Admin Panel Options
     **/
    public function admin_options()
    {
        ?>
        <h1><?php _e('Payture', 'wc-payture'); ?></h1><?php $this->get_icon(); ?>
        <p><?php _e('Setting receiving payments through Payture Merchant. If the gateway is not working, you can turn error level DEBUG and send the report to the developer.', 'wc-payture'); ?></p>
        <hr>
        <?php if ( $this->is_valid_for_use() ) : ?>

        <table class="form-table">
            <?php $this->generate_settings_html(); ?>
        </table>

    <?php else : ?>
        <div class="inline error"><p><strong><?php _e('Gateway offline', 'wc-payture'); ?></strong>: <?php _e('Payture does not support the currency your store.', 'wc-payture' ); ?></p></div>
        <?php
    endif;
    }

    /**
     * Initialise Gateway Settings Form Fields
     *
     * @access public
     * @return void
     */
    public function init_form_fields()
    {
        $this->form_fields = array
        (
            'enabled' => array
            (
                'title' => __('Online/Offline gateway', 'wc-payture'),
                'type' => 'checkbox',
                'label' => __('Online', 'wc-payture'),
                'default' => 'yes'
            ),
            'interface' => array(
                'title'       => __( 'Interface', 'wc-payture' ),
                'type'        => 'title',
                'description' => '',
            ),
            'enable_icon' => array
            (
                'title' => __('Show gateway icon?', 'wc-payture'),
                'type' => 'checkbox',
                'label' => __('Show', 'wc-payture'),
                'default' => 'yes'
            ),
            'language' => array
            (
                'title' => __( 'Language interface', 'wc-payture' ),
                'type' => 'select',
                'options' => array
                (
                    'ru' => __('Russian', 'wc-payture'),
                    'en' => __('English', 'wc-payture')
                ),
                'description' => __( 'What language interface displayed for the customer on Payture?', 'wc-payture' ),
                'default' => 'ru'
            ),
            'language_auto' => array
            (
                'title' => __( 'Language based on the locale?', 'wc-payture' ),
                'type' => 'select',
                'options' => array
                (
                    'yes' => __('Yes', 'wc-payture'),
                    'no' => __('No', 'wc-payture')
                ),
                'description' => __( 'Trying to get the language based on the locale?', 'wc-payture' ),
                'default' => 'ru'
            ),
            'title' => array
            (
                'title' => __('Title', 'wc-payture'),
                'type' => 'text',
                'description' => __( 'This is the name that the user sees during the payment.', 'wc-payture' ),
                'default' => __('Payture', 'wc-payture')
            ),
            'order_button_text' => array
            (
                'title' => __('Order button text', 'wc-payture'),
                'type' => 'text',
                'description' => __( 'This is the button text that the user sees during the payment.', 'wc-payture' ),
                'default' => __('Pay', 'wc-payture')
            ),
            'description' => array
            (
                'title' => __( 'Description', 'wc-payture' ),
                'type' => 'textarea',
                'description' => __( 'Description of the method of payment that the customer will see on our website.', 'wc-payture' ),
                'default' => __( 'Payment by Payture.', 'wc-payture' )
            ),
            'technical' => array(
                'title'       => __( 'Technical details', 'wc-payture' ),
                'type'        => 'title',
                'description' => '',
            ),
            'merchant_host' => array
            (
                'title' => __('Merchant host', 'wc-payture'),
                'type' => 'text',
                'description' => __( 'https://{Host}.payture.com', 'wc-payture' ),
                'default' => ''
            ),
            'merchant_key' => array
            (
                'title' => __('Merchant key', 'wc-payture'),
                'type' => 'text',
                'description' => __( 'Unique identification for merchant (key).', 'wc-payture' ),
                'default' => ''
            ),
            'merchant_pass' => array
            (
                'title' => __('Merchant password', 'wc-payture'),
                'type' => 'text',
                'description' => __( 'Please write Merchant password.', 'wc-payture' ),
                'default' => ''
            ),
            'logger' => array
            (
                'title' => __( 'Enable logging?', 'wc-payture' ),
                'type'        => 'select',
                'description'	=>  __( 'You can enable gateway logging, specify the level of error that you want to benefit from logging. You can send reports to developer manually by pressing the button. All sensitive data in the report are deleted.
By default, the error rate should not be less than ERROR.', 'wc-payture' ),
                'default'	=> '400',
                'options'     => array
                (
                    '' => __( 'Off', 'wc-payture' ),
                    '100' => 'DEBUG',
                    '200' => 'INFO',
                    '250' => 'NOTICE',
                    '300' => 'WARNING',
                    '400' => 'ERROR',
                    '500' => 'CRITICAL',
                    '550' => 'ALERT',
                    '600' => 'EMERGENCY'
                )
            ),
            'test_payments' => array(
                'title'       => __( 'Settings for test payments', 'wc-payture' ),
                'type'        => 'title',
                'description' => '',
            ),
            'test' => array
            (
                'title' => __( 'Test mode', 'wc-payture' ),
                'type'        => 'select',
                'description'	=>  __( 'Activate testing mode for admins.', 'wc-payture' ),
                'default'	=> 'no',
                'options'     => array
                (
                    'no' => __( 'Off', 'wc-payture' ),
                    'yes' => __( 'On', 'wc-payture' ),
                )
            ),
            'test_merchant_host' => array
            (
                'title' => __( 'Test merchant host', 'wc-payture' ),
                'type'        => 'select',
                'description'	=>  __( 'Server for testing payments', 'wc-payture' ),
                'default'	=> 'https://sandbox2.payture.com',
                'options'     => array
                (
                    'https://sandbox.payture.com' => __( 'sandbox.payture.com', 'wc-payture' ),
                    'https://sandbox2.payture.com' => __( 'sandbox2.payture.com', 'wc-payture' ),
                )
            ),
            'test_merchant_key' => array
            (
                'title' => __('Merchant key', 'wc-payture'),
                'type' => 'text',
                'description' => __( 'Unique identification for merchant (key) for testing payments.', 'wc-payture' ),
                'default' => 'MerchantPaytureTest'
            ),
            'test_merchant_pass' => array
            (
                'title' => __('Merchant password', 'wc-payture'),
                'type' => 'text',
                'description' => __( 'Please write Merchant password for testing payments.', 'wc-payture' ),
                'default' => '123'
            ),
        );
    }

    /**
     * There are no payment fields for sprypay, but we want to show the description if set.
     **/
    public function payment_fields()
    {
        if ($this->description)
        {
            echo wpautop(wptexturize($this->description));
        }
    }

    /**
     * @param $statuses
     * @param $order
     * @return mixed
     */
    public static function valid_order_statuses_for_payment($statuses, $order)
    {
        if($order->payment_method !== 'payture')
        {
            return $statuses;
        }

        $option_value = get_option( 'woocommerce_payment_status_action_pay_button_controller', array() );

        if(!is_array($option_value))
        {
            $option_value = array('pending', 'failed');
        }

        if( is_array($option_value) && !in_array('pending', $option_value, false) )
        {
            $pending = array('pending');
            $option_value = array_merge($option_value, $pending);
        }

        return $option_value;
    }

    /**
     * Generate payments form
     *
     * @param $order_id
     *
     * @return string Payment form
     **/
    public function generate_form($order_id)
    {
        /**
         * Create order object
         */
        $order = wc_get_order($order_id);

        /**
         * Sum
         */
        $out_sum = $order->order_total * 100;

        /**
         * Product description
         */
        $description = '';
        $items = $order->get_items();
        foreach ( $items as $item )
        {
            $description .= $item['name'];
        }
        if(count($description) > 99)
        {
            $description = __('Product number: ' . $order_id, 'wc-payture');
        }

        /**
         * Rewrite currency from order
         */
        $this->currency = $order->get_order_currency();

        /**
         * Return payment?
         */
        $sessionId = get_post_meta( $order_id, '_SessionId', true );
        $sessionId_sum = get_post_meta( $order_id, '_SessionId_sum', true );

        if(empty( $sessionId ))
        {
            /**
             * Logger notice
             */
            $this->logger->addNotice('SessionId empty. ' . $sessionId);

            /**
             * Init
             */
            $sessionId_array = $this->payture_init($order_id, $out_sum, 'Pay', $description, $order->order_total);

            if(is_array($sessionId_array) && $sessionId_array['success'] == true)
            {
                $sessionId = $sessionId_array['SessionId'];
                unset($sessionId_array);

                update_post_meta($order_id, '_SessionId', $sessionId);
                update_post_meta($order_id, '_SessionId_sum', $out_sum);

                $sessionId_sum = $out_sum;
            }
        }

        if($sessionId_sum != $out_sum)
        {
            wp_redirect( str_replace('&amp;', '&', $order->get_cancel_order_url() ) );
            die();
        }

        /**
         * Pay
         */
        if(!empty( $sessionId ))
        {
            $url = $this->payture_pay($sessionId);
            wp_redirect( $url );
            die();
        }

        /**
         * Redirect to cancel
         */
        wp_redirect( str_replace('&amp;', '&', $order->get_cancel_order_url() ) );
        die();
    }

    /**
     * Process the payment and return the result
     **/
    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);

        /**
         * Add order note
         */
        $order->add_order_note(__('The client started to pay.', 'wc-payture'));

        /**
         * Logger notice
         */
        $this->logger->addNotice('The client started to pay.');

        if ( !version_compare( $this->wc_version, '2.1.0', '<' ) )
        {
            return array
            (
                'result' => 'success',
                'redirect' => $order->get_checkout_payment_url( true )
            );
        }

        return array
        (
            'result' => 'success',
            'redirect'	=> add_query_arg('order-pay', $order->id, add_query_arg('key', $order->order_key, get_permalink(woocommerce_get_page_id('pay'))))
        );
    }

    /**
     * receipt_page
     **/
    public function receipt_page($order)
    {
        echo '<p>'.__('Thank you for your order, please press the button below to pay.', 'wc-payture').'</p>';

        echo $this->generate_form($order);
    }

    /**
     * Check instant payment notification
     **/
    public function check_ipn()
    {
        /**
         * Insert $_REQUEST into debug mode
         */
        $this->logger->addDebug(print_r($_REQUEST, true));

        /**
         * Hook wc_payture
         */
        if ($_GET['wc-api'] === 'wc_payture')
        {
            /**
             * Order ID
             */
            $order_id = 0;

            if ($_GET['action'] === 'success')
            {
                if(array_key_exists('orderid', $_GET))
                {
                    $order_id = $_GET['orderid'];
                }
            }
            else
            {
                if(array_key_exists('OrderId', $_POST))
                {
                    $order_id = $_POST['OrderId'];
                }
            }

            /**
             * Get order object
             */
            $order = wc_get_order($order_id);

            /**
             * Order not found
             */
            if($order === false)
            {
                /**
                 * Logger notice
                 */
                $this->logger->addNotice('Api RESULT request error. Order not found.');

                /**
                 * Send Service unavailable
                 */
                wp_die(__('Order not found.', 'wc-payture'), 'Payment error', array('response' => '503'));
            }

            /**
             * Logger info
             */
            $this->logger->addInfo('Payture request success.');

            /**
             * Result
             */
            if ($_GET['action'] === 'result')
            {
                /**
                 * Validated
                 */
                if($_POST['Notification'] == 'MerchantPay' && $_POST['Success'] == 'True' && !$order->has_status( apply_filters( 'woocommerce_order_is_paid_statuses', array( 'processing', 'completed' ) ) ))
                {
                    /**
                     * Logger info
                     */
                    $this->logger->addInfo('Result Validated success. (MerchantPay)');

                    /**
                     * Add order note
                     */
                    $order->add_order_note(__('Order successfully paid. (MerchantPay)', 'wc-payture'));

                    /**
                     * Logger notice
                     */
                    $this->logger->addNotice('Order successfully paid. (MerchantPay)');

                    /**
                     * Logger notice
                     */
                    $this->logger->addInfo('Payment complete (MerchantPay).');

                    /**
                     * Set status is payment
                     */
                    $order->payment_complete();
                    die('OK'.$order_id);
                }

                /**
                 * Logger notice
                 */
                $this->logger->addError('Result Validated error. Payment error, please pay other time.');

                /**
                 * Send Service unavailable
                 */
                wp_die(__('Payment error, please pay other time.', 'wc-payture'), 'Payment error', array('response' => '503'));
            }
            /**
             * Success
             */
            else if ($_GET['action'] === 'success')
            {
                $pay_status = false;

                /**
                 * Add order note
                 */
                $order->add_order_note(__('Client return to success page.', 'wc-payture'));

                /**
                 * Logger info
                 */
                $this->logger->addInfo('Client return to success page.');

                /**
                 * Check status pay
                 */
                $status_array = $this->payture_paystatus($order_id);

                /**
                 * Add to log
                 */
                $this->logger->addDebug('PayStatus: state - ' . $status_array['State'] . ' success - ' . $status_array['Success'] . ' errcode - ' . $status_array['ErrCode']);

                if(array_key_exists('Success', $status_array) )
                {
                    /**
                     * Money ok
                     */
                    if( $status_array['Success'] == 'True' && $status_array['State'] == 'Charged' && !$order->has_status( apply_filters( 'woocommerce_order_is_paid_statuses', array( 'processing', 'completed' ) ) ))
                    {
                        $pay_status = true;
                    }

                    if($status_array['State'] == 'Error' || $status_array['Success'] == 'False')
                    {
                        $pay_status = false;
                    }
                }

                /**
                 * Pay complete
                 */
                if($pay_status === true)
                {
                    /**
                     * Add order note
                     */
                    $order->add_order_note(__('Order successfully paid.', 'wc-payture'));

                    /**
                     * Logger notice
                     */
                    $this->logger->addNotice('Order successfully paid.');

                    /**
                     * Logger notice
                     */
                    $this->logger->addInfo('Payment complete.');

                    /**
                     * Set status is payment
                     */
                    $order->payment_complete();
                }
                else
                {
                    /**
                     * Add order note
                     */
                    $order->add_order_note(__('The order has not been paid.', 'wc-payture'));
                    /**
                     * Logger info
                     */
                    $this->logger->addInfo('The order has not been paid.');

                    /**
                     * Sen status is failed
                     */
                    // $order->update_status('failed');

                    /**
                     * Redirect to cancel
                     */
                    wp_redirect( str_replace('&amp;', '&', $order->get_cancel_order_url() ) );
                    die();
                }
                
                /**
                 * Empty cart
                 */
                WC()->cart->empty_cart();

                /**
                 * Redirect to success
                 */
                wp_redirect( $this->get_return_url( $order ) );
                die();
            }
        }

        /**
         * Logger notice
         */
        $this->logger->addNotice('Api request error. Action not found.');

        /**
         * Send Service unavailable
         */
        wp_die(__('Api request error. Action not found.', 'wc-payture'), 'Payment error', array('response' => '503'));
    }

    /**
     * Display the test notice
     **/
    public function test_notice()
    {
        ?>
        <div class="update-nag">
            <?php $link = '<a href="'. admin_url('admin.php?page=wc-settings&tab=checkout&section=wc_payture') .'">'.__('here', 'wc-payture').'</a>';
            echo sprintf( __( 'Payture test mode is enabled. Click %s -  to disable it when you want to start accepting live payment on your site.', 'wc-payture' ), $link ) ?>
        </div>
        <?php
    }

    /**
     * Display the debug notice
     **/
    public function debug_notice()
    {
        ?>
        <div class="update-nag">
            <?php $link = '<a href="'. admin_url('admin.php?page=wc-settings&tab=checkout&section=wc_payture') .'">'.__('here', 'wc-payture').'</a>';
            echo sprintf( __( 'Payture debug tool is enabled. Click %s -  to disable.', 'wc-payture' ), $link ) ?>
        </div>
        <?php
    }

    /**
     * Get client IP
     *
     * @return mixed
     */
    public function get_client_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Method Init
     */
    public function payture_init($orderId, $amount, $sessionType = 'Pay', $product = null, $total = null, $language = null, $templateTag = null)
    {
        if($this->test === 'yes')
        {
            $url = $this->test_merchant_host . '/apim/Init';
        }
        else
        {
            $url = $this->merchant_host . '/apim/Init';
        }

        $params = array();
        $params[] = 'SessionType='.$sessionType;
        $params[] = 'OrderId='.$orderId;
        $params[] = 'Amount='.$amount;
        $params[] = 'IP='.$this->client_ip;
        $params[] = 'Url='.get_site_url().'?wc-api=wc_payture&action=success&orderid={orderid}';

        if(!is_null($product))
        {
            $params[] = 'Product='.$product;
        }
        if(!is_null($language))
        {
            $params[] = 'Language='.$language;
        }
        if(!is_null($total))
        {
            $params[] = 'Total='.$total;
        }
        if(!is_null($templateTag))
        {
            $params[] = 'TemplateTag='.$templateTag;
        }

        if($this->test === 'yes')
        {
            $url.='?Key='.$this->test_merchant_key.'&Data='.$this->getRequestDataUrlString($params);
        }
        else
        {
            $url.='?Key='.$this->merchant_key.'&Data='.$this->getRequestDataUrlString($params);
        }

        $this->logger->addDebug($url);

        $responseXML = $this->getResponseXML($url);

        if(!$responseXML['success'])
        {
            return $responseXML;
        }

        $responseAttributes = $this->getXmlAttributesArray($responseXML['data']);
        $checkSessionId = $this->isResponseSucceed($responseAttributes);

        if(!$checkSessionId['success'])
        {
            return $checkSessionId;
        }

        $this->logger->addDebug('xml', $responseXML);

        return array
        (
            'success' => true,
            'SessionId' => $responseAttributes['SessionId']
        );

    }

    /**
     * Method Pay
     *
     * @param $sessionId
     * @return string
     */
    public function payture_pay($sessionId)
    {
        if($this->test === 'yes')
        {
            return $this->test_merchant_host . '/apim/Pay?SessionId='.$sessionId;
        }

        return $this->merchant_host . '/apim/Pay?SessionId='.$sessionId;
    }

    /**
     * Method PayStatus
     *
     * @param $sessionId
     *
     * @return array
     */
    public function payture_paystatus($sessionId)
    {
        if($this->test === 'yes')
        {
            $url = $this->test_merchant_host . '/apim/PayStatus';
        }
        else
        {
            $url = $this->merchant_host . '/apim/PayStatus';
        }

        if($this->test === 'yes')
        {
            $url.='?Key='.$this->test_merchant_key.'&OrderId='.$sessionId;
        }
        else
        {
            $url.='?Key='.$this->merchant_key.'&OrderId='.$sessionId;
        }

        $responseXML = $this->getResponseXML($url);

        if(!$responseXML['success'])
        {
            return $responseXML;
        }

        $responseAttributes = $this->getXmlAttributesArray($responseXML['data']);
        $checkSessionId = $this->isResponseSucceed($responseAttributes);

        if(!$checkSessionId['success'])
        {
            return $checkSessionId;
        }

        return $responseAttributes;
    }

    public function payture_refund()
    {

    }

    /**
     * @param $attributesArray
     * @return array
     */
    public function isResponseSucceed($attributesArray)
    {
        if($attributesArray['Success'] == 'False')
        {
            return array
            (
                'success'=>false,
                'error'=>$this->errors[$attributesArray['ErrCode']],
                'code'=>$attributesArray['ErrCode']
            );
        }

        return array
        (
            'success'=>true
        );
    }

    /**
     * @param $xmlNode
     * @return mixed
     */
    public function getXmlAttributesArray($xmlNode)
    {
        $attributes = (array) $xmlNode->attributes();

        return $attributes = $attributes[ '@attributes' ];
    }

    /**
     * @param $path
     * @return array
     */
    public function getResponseXML($path)
    {
        if (($responseXmlData = file_get_contents($path))===false)
        {
            return array (
                'success' =>false,
                'error'   =>'Error fetching XML'
            );
        }

        libxml_use_internal_errors(true);

        $data = simplexml_load_string($responseXmlData);

        if (!$data)
        {
            return array
            (
                'success' =>false,
                'error'   =>'Error fetching XML\n'.implode('\n',libxml_get_errors())
            );
        }

        return array
        (
            'success'=>true,
            'data' => $data
        );
    }

    /**
     * @param $params
     * @return string
     */
    public function getRequestDataUrlString($params)
    {
        return urlencode(implode(';',$params));
    }

}