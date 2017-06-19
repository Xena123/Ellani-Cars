<?php
/**
 * @version 1.0
 * @package PayPal
 * @category Payment Gateway for Booking Calendar 
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-06-26
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly
                                                                                
if ( ! defined( 'WPBC_PAYPAL_PAY_BUTTON_URL' ) )    define( 'WPBC_PAYPAL_PAY_BUTTON_URL',  'https://www.paypalobjects.com/webstatic/en_US/btn/btn_pponly_142x27.png' ); // https://developer.paypal.com/docs/classic/api/buttons/
if ( ! defined( 'WPBC_PAYPAL_URL' ) )               define( 'WPBC_PAYPAL_URL',  'https://www.paypal.com' );    
if ( ! defined( 'WPBC_PAYPAL_GATEWAY_ID' ) )        define( 'WPBC_PAYPAL_GATEWAY_ID', 'paypal' );    


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Gateway API " >

/** API  for  Payment Gateway  */
class WPBC_Gateway_API_PAYPAL extends WPBC_Gateway_API  {                     

    
    /** Get payment Form
     * @param string $output    - other active payment forms
     * @param array $params     - input params                          array (
                                                                                [booking_id] => 112
                                                                                [id] => 112
                                                                                [days_input_format] => 22.07.2016
                                                                                [days_only_sql] => 2016-07-22
                                                                                [dates_sql] => 2016-07-22 12:00:01, 2016-07-22 14:00:02
                                                                                [check_in_date_sql] => 2016-07-22 12:00:01
                                                                                [check_out_date_sql] =>  2016-07-22 14:00:02
                                                                                [dates] => July 22, 2016 12:00 - July 22, 2016 14:00
                                                                                [check_in_date] => July 22, 2016 12:00
                                                                                [check_out_date] => July 22, 2016 14:00
                                                                                [check_out_plus1day] => July 23, 2016 14:00
                                                                                [dates_count] => 1
                                                                                [days_count] => 1
                                                                                [nights_count] => 1
                                                                                [cost] => 15000.00
                                                                                [cost_format] => 15 000,0
                                                                                [siteurl] => http://beta
                                                                                [resource_title] => Apartment#3
                                                                                [bookingtype] => Apartment#3
                                                                                [remote_ip] => 127.0.0.1
                                                                                [user_agent] => Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0
                                                                                [request_url] => http://beta/resource-3-id4/
                                                                                [current_date] => July 7, 2016
                                                                                [current_time] => 14:00
                                                                                [selected_short_timedates_hint] => July 22, 2016 12:00 - July 22, 2016 14:00
                                                                                [nights_number_hint] => 1
                                                                                [cost_hint] => 15 000,0
                                                                                [rangetime] => 12:00 - 14:00
                                                                                [name] => John
                                                                                [secondname] => Smith
                                                                                [email] => smith@email-server.com
                                                                                [phone] => 123-456-789
                                                                                [address] => Baker str.
                                                                                [city] => London
                                                                                [postcode] => 232432
                                                                                [country] => GB
                                                                                [visitors] => 1
                                                                                [children] => 0
                                                                                [details] => Test booking 
                                                                                [term_and_condition] => I Accept term and conditions
                                                                                [booking_resource_id] => 4
                                                                                [resource_id] => 4
                                                                                [type_id] => 4
                                                                                [type] => 4
                                                                                [resource] => 4
                                                                                [content] => 'Content of booking fields data .... '
                                                                                [moderatelink] => http://link?page=wpbc&view_mode=vm_listing&tab=actions&wh_booking_id=112
                                                                                [visitorbookingediturl] => http://link?booking_hash=a42f9aaa580f11dbe1a928651220e2d0
                                                                                [visitorbookingcancelurl] => http://link?booking_hash=a42f9aaa580f11dbe1a928651220e2d0&booking_cancel=1
                                                                                [visitorbookingpayurl] => http://link?booking_hash=a42f9aaa580f11dbe1a928651220e2d0&booking_pay=1
                                                                                [bookinghash] => a42f9aaa580f11dbe1a928651220e2d0
                                                                                [__booking_id] => 112
                                                                                [__cost] => 3750
                                                                                [__resource_id] => 4
                                                                                [__form] => text^selected_short_timedates_hint4^July 22, 2016 12:00 - July 22, 2016 14:00~text^nights_number_hint4^1~text^cost_hint4^15 000,0~select-one^rangetime4^12:00 - 14:00~text^name4^John~text^secondname4^Smith~email^email4^smith@wpbookingcalendar.com~text^phone4^123-456-789~text^address4^Baker str.~text^city4^London~text^postcode4^232432~select-one^country4^GB~select-one^visitors4^1~select-one^children4^0~textarea^details4^Test booking ~checkbox^term_and_condition4[]^I Accept term and conditions
                                                                                [__nonce] => 33979
                                                                                [__is_deposit] => 1
                                                                                [__additional_calendars] => array()
                                                                                [__payment_type] => payment_form
                                                                                [__cost_format] => 3 750,0
                                                                                [cost_in_gateway] => 3750
                                                                                [cost_in_gateway_hint] => 3 750,0
                                                                                [is_deposit] => 1
                                                                            )
     * @return string        - you must  return  in format: return $output . $your_payment_form_content
     */
    public function get_payment_form( $output, $params, $gateway_id = '' ) {

        
        // Check  if currently  is showing this Gateway
        if (    
                   (  ( ! empty( $gateway_id ) ) && ( $gateway_id !== $this->get_id() )  )      // Does we need to show this Gateway
                || ( ! $this->is_gateway_on() )                                                 // Payment Gateway does NOT active
           ) return $output ; 

//debuge( '$params', $params ); return '';

        ////////////////////////////////////////////////////////////////////////
        // Payment Options /////////////////////////////////////////////////////
        $payment_options = array();        
        $payment_options[ 'is_active' ] = get_bk_option( 'booking_paypal_is_active' );        
        $payment_options[ 'pro_hosted_solution' ] = get_bk_option( 'booking_paypal_pro_hosted_solution' );
        $payment_options[ 'emeil' ] = get_bk_option( 'booking_paypal_emeil' );
        $payment_options[ 'secure_merchant_id' ] = get_bk_option( 'booking_paypal_secure_merchant_id' );
        $payment_options[ 'paymentaction' ] = get_bk_option( 'booking_paypal_paymentaction' );
        $payment_options[ 'is_sandbox' ] = get_bk_option( 'booking_paypal_is_sandbox' );
        $payment_options[ 'curency' ] = get_bk_option( 'booking_paypal_curency' );
        $payment_options[ 'button_type' ] = get_bk_option( 'booking_paypal_button_type' );
        $payment_options[ 'payment_button_title' ] = get_bk_option( 'booking_paypal_payment_button_title' );
        $payment_options[ 'payment_button_title' ] = apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'payment_button_title' ] );
        
        // $payment_options[ 'is_description_show' ] = get_bk_option( 'booking_paypal_is_description_show' );
        $payment_options[ 'subject' ] = get_bk_option( 'booking_paypal_subject' );
        $payment_options[ 'subject' ] =  apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'subject' ] );
        $payment_options[ 'subject' ] =  wpbc_replace_booking_shortcodes( $payment_options[ 'subject' ], $params );
        
        $payment_options[ 'is_reference_box' ] = get_bk_option( 'booking_paypal_is_reference_box' );
        $payment_options[ 'reference_title_box' ] = get_bk_option( 'booking_paypal_reference_title_box' );

        $payment_options[ 'return_url' ] = get_bk_option( 'booking_paypal_return_url' );
        $payment_options[ 'cancel_return_url' ] = get_bk_option( 'booking_paypal_cancel_return_url' );
        $payment_options[ 'is_auto_approve_cancell_booking' ] = get_bk_option( 'booking_paypal_is_auto_approve_cancell_booking' );
        
        $payment_options[ 'ipn_is_send_verified_email' ] = get_bk_option( 'booking_paypal_ipn_is_send_verified_email' );
        $payment_options[ 'ipn_verified_email' ] = get_bk_option( 'booking_paypal_ipn_verified_email' );
        $payment_options[ 'ipn_is_send_invalid_email' ] = get_bk_option( 'booking_paypal_ipn_is_send_invalid_email' );
        $payment_options[ 'ipn_invalid_email' ] = get_bk_option( 'booking_paypal_ipn_invalid_email' );
        $payment_options[ 'ipn_is_send_error_email' ] = get_bk_option( 'booking_paypal_ipn_is_send_error_email' );
        $payment_options[ 'ipn_error_email' ] = get_bk_option( 'booking_paypal_ipn_error_email' );
        $payment_options[ 'ipn_use_ssl' ] = get_bk_option( 'booking_paypal_ipn_use_ssl' );
        $payment_options[ 'ipn_use_curl' ] = get_bk_option( 'booking_paypal_ipn_use_curl' );
        
        
        ////////////////////////////////////////////////////////////////////////
        // Payment Form ////////////////////////////////////////////////////////
        ob_start();
        
        ?><div style="width:100%;clear:both;margin-top:20px;"></div><?php 
        ?><div class="paypal_div wpbc-payment-form" style="text-align:left;clear:both;"><?php 
        
        
        /** We need to open payment form in separate window, if this booking was made togather with other 
         *  in booking form  was used several  calndars from  different booking resources. 
         *  So we are having several  payment forms for each  booked resource. 
         *  System transfer this parameter $params['payment_form_target'] = ' target="_blank" ';
         *  otherwise $params['payment_form_target'] = '';
         */        
                
        if ( $payment_options[ 'pro_hosted_solution' ] != 'On' ) {              // PayPal Standard
            
            if ( $payment_options[ 'is_sandbox' ] != 'On' ) {                   // Live
                
                ?><form action="https://www.paypal.com/cgi-bin/webscr" <?php echo $params['payment_form_target']; ?> method="post"><?php 
                ?><input type="hidden" name="rm" value="2" /><?php 

            } else {                                                            // Sandbox
                ?><form action="https://www.sandbox.paypal.com/cgi-bin/webscr" <?php echo $params['payment_form_target']; ?> method="post"><?php  
                ?><input type="hidden" name="rm" value="1" /><?php 
            }
            ?><input type="hidden" name="cmd" value="_xclick" /> <?php 
            ?><input type="hidden" name="amount" size="10" title="Cost" value="<?php echo $params['cost_in_gateway']; ?>" /><?php 
            ?><input type="hidden" name="business" value="<?php echo $payment_options[ 'emeil' ]; ?>" /><?php 
            ?><input type="hidden" name="no_shipping" value="1" /><?php 
            ?><input type="hidden" name="no_note" value="1" /><?php 

        } else {                                                                // Paypal Pro Hosted Solution

            if ( $payment_options[ 'is_sandbox' ] != 'On' ) {                   // Live
                ?><form action="https://securepayments.paypal.com/acquiringweb?cmd=_hosted-payment" <?php echo $params['payment_form_target']; ?> method="post"><?php 
                
            } else {                                                            // Sandbox
                ?><form action="https://securepayments.sandbox.paypal.com/acquiringweb?cmd=_hosted-payment" <?php echo $params['payment_form_target']; ?> method="post"><?php 
            }
            
            ?><input type="hidden" name="cmd" value="_hosted-payment" /><?php 
            ?><input type="hidden" name="subtotal" value="<?php echo $params['cost_in_gateway']; ?>" /><?php 
            ?><input type="hidden" name="business" value="<?php echo $payment_options[ 'secure_merchant_id' ]; ?>" /><?php 
        }

        
        ?><input type="hidden" name="paymentaction" value="<?php echo $payment_options[ 'paymentaction' ]; ?>" /><?php 

        
        $locale = wpbc_get_booking_locale();                                   //$locale = 'fr_FR';          
        if (   ( ! empty( $locale ) ) 
            && ( substr( $locale, 0, 2 ) !== 'en')  ) {
            ?><input type="hidden" name="lc" value="<?php echo substr( $locale, 0, 2 ); ?>" /><?php                //FixIn:6.1.1.1
        }
         
        if ( strlen( WPBC_PLUGIN_URL .'/inc/gateways/paypal/ipn.php' ) < 255 ) {                        // Check for the PayPal 255 symbol restriction
            ?><input type="hidden" name="notify_url" value="<?php echo WPBC_PLUGIN_URL .'/inc/gateways/paypal/ipn.php'; ?>" /><?php 
        }
        if ( ! empty( $params[ 'bookinghash' ] ) ) {
            ?><input type="hidden" name="custom" value="<?php echo $params[ 'bookinghash' ]; ?>" /><?php  
        }
        
        if ($payment_options[ 'pro_hosted_solution' ] != 'On') {
            ?><input type="hidden" name="item_number" value="<?php echo $params[ 'booking_id' ]; ?>" /><?php 
        }

        
        echo "<strong>" . $params['gateway_hint'] . ': ' . $params[ 'cost_in_gateway_hint' ] . "</strong><br />";
                                                                                /*
                                                                                 if ( $params[ 'is_deposit' ] ) {
                                                                                     $today_day = date('m.d.Y')  ;
                                                                                     $cost_summ_with_title .= ' ('  . $today_day .')';
                                                                                     make_bk_action('wpdev_make_update_of_remark' , $params[ 'booking_id' ] , $cost_summ_with_title , true );
                                                                                 }/**/
        ////////////////////////////////////////////////////////////////////////
        // Auto Assign  Billing Form  Fields ///////////////////////////////////
        if ( 
               ( $payment_options['pro_hosted_solution'] != 'On' )
            && ( get_bk_option( 'booking_billing_customer_email' ) !== false ) 
        ) {
            $billing_customer_email = (string) trim( get_bk_option( 'booking_billing_customer_email' ) ); 

            if ( isset( $params[ $billing_customer_email ] ) !== false ) {

                $email = substr( $params[ $billing_customer_email ], 0, 127 );

                ?><input type="hidden" name="email" value="<?php echo $email; ?>" /><?php 
            }
        }
            
        if ( $payment_options['pro_hosted_solution'] != 'On' )  $billing_prefix = '';
        else                                                    $billing_prefix = 'billing_';
                
        if ( get_bk_option( 'booking_billing_firstnames' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_firstnames' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 32 );
                ?><input type="hidden" name="<?php echo $billing_prefix; ?>first_name" value="<?php echo $field_value; ?>" /><?php 
            }
        }
        if ( get_bk_option( 'booking_billing_surname' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_surname' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 64 );
                ?><input type="hidden" name="<?php echo $billing_prefix; ?>last_name" value="<?php echo $field_value; ?>" /><?php 
            }
        }
        if ( get_bk_option( 'booking_billing_address1' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_address1' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 100 );
                ?><input type="hidden" name="<?php echo $billing_prefix; ?>address1" value="<?php echo $field_value; ?>" /><?php 
            }
        }
        if ( get_bk_option( 'booking_billing_city' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_city' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 40 );
                ?><input type="hidden" name="<?php echo $billing_prefix; ?>city" value="<?php echo $field_value; ?>" /><?php 
            }
        }
        if ( get_bk_option( 'booking_billing_country' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_country' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 2 );
                ?><input type="hidden" name="<?php echo $billing_prefix; ?>country" value="<?php echo $field_value; ?>" /><?php 
            }
        }
        if ( get_bk_option( 'booking_billing_post_code' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_post_code' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 32 );
                ?><input type="hidden" name="<?php echo $billing_prefix; ?>zip" value="<?php echo $field_value; ?>" /><?php 
            }
        }
        ////////////////////////////////////////////////////////////////////////
         
        ?><input type="hidden" name="item_name"     value="<?php echo substr( $payment_options[ 'subject' ], 0, 127 ); ?>" /><?php  
        ?><input type="hidden" name="currency_code" value="<?php echo $payment_options[ 'curency' ]; ?>" /><?php  
         
        // Show the reference text box
        if ( $payment_options[ 'is_reference_box' ] == 'On') {
            echo "<br/><strong> ". $payment_options[ 'reference_title_box' ] ." :</strong>";
            ?><input type="hidden"  name="on0" value="Reference" /><?php  
            ?><input type="text"    name="os0" maxlength="60" /><br/><br/><?php  
        }

        $return_link = WPBC_PLUGIN_URL . '/inc/gateways/wpbc-response.php'
                        . '?payed_booking=' . $params[ 'booking_id' ] 
                        . '&wp_nonce=' . $params[ '__nonce' ] 
                        . '&pay_sys=paypal'; 
        
        ?><input type="hidden" name="return"        value="<?php echo $return_link . '&stats=OK' ; ?>" /><?php
        ?><input type="hidden" name="cancel_return" value="<?php echo $return_link . '&stats=FAILED' ; ?>" /><?php  

        
        if ( $payment_options[ 'button_type' ] == 'custom' ) {
            ?><input type="submit" class="btn" name="submit"  value="<?php echo $payment_options[ 'payment_button_title' ]; ?>" /><?php 
        } else {
            ?><input type="image" src="<?php echo WPBC_PAYPAL_PAY_BUTTON_URL; ?>" name="submit" style="border:none;width:auto;" alt="<?php _e('Make payments with payPal - its fast, free and secure!' ,'booking'); ?>" /><?php 
        }
        
        ?></form></div><?php 
        
        $payment_form = ob_get_clean();
        
        // Auto redirect to the PayPal website, after visitor clicked on "Send" button.  We do not need to return this Script, instead of that just write it here
        /*
        ?><script type='text/javascript'> 
            setTimeout(function() { 
               jQuery("#gateway_payment_forms<?php echo $params['resource_id']; ?> .paypal_div.wpbc-payment-form form").submit(); 
            }, 500);                        
        </script><?php /**/        
        
        return $output . $payment_form; 
    }
    
    
    /** Define settings Fields  */
    public function init_settings_fields() {

        
        $this->fields = array();

        // On | Off
        
        $this->fields['is_active'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'On'            
                                    , 'title'       => __( 'Enable / Disable', 'booking' )
                                    , 'label'       => __( 'Enable this payment gateway', 'booking')   
                                    , 'description' => ''
                                    , 'group'       => 'general'

                                );
        
        // Account Type
        $field_options = array(
                                'Off' => array(  'title' => __('Paypal Standard', 'booking')
                                                            , 'attr' => array( 'id' => 'paypal_type_standard' )                                                             
                                                            //, 'html' => '<br/>'
                                                            )
                              , 'On' => array(  'title' => __('Paypal Pro Hosted Solution' ,'booking')
                                                            , 'attr' => array( 'id' => 'paypal_type_pro_hosted_solution' ) )

                            ); 
        $this->fields['pro_hosted_solution'] = array(   
                                    'type'          => 'radio'
                                    , 'default'     => 'Off'
                                    , 'title'       => __('Account Type' ,'booking')
                                    , 'description' => ''
                                    , 'options'     => $field_options
                                    , 'group'       => 'general'
                            );
        
        
        //PayPal Email    
        $this->fields['emeil'] = array(   
                                      'type'        => 'email'
                                    , 'default'     => ( wpbc_is_this_demo() ) ? 'Seller_1335004986_biz@wpdevelop.com' : get_option( 'admin_email' )
                                    //, 'placeholder' => ''
                                    , 'title'       => __('Paypal Email address to receive payments', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . sprintf(__('This is the Paypal Email address where payments will be sent' ,'booking'),'<b>','</b>') 
                                                       . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                    , 'description_tag' => 'span'
                                    , 'css'         => ''//'width:100%'
                                    , 'group'       => 'general'
                                    , 'tr_class'    => 'wpbc_sub_settings_paypal_account_type wpbc_sub_settings_paypal_standard wpbc_sub_settings_grayed'
                                    //, 'validate_as' => array( 'required' )
                            );

        //Secure Merchant ID - required for "Paypal Pro Hosted Solution" account.
        $this->fields['secure_merchant_id'] = array(   
                                      'type'        => 'text'
                                    , 'default'     => ''
                                    //, 'placeholder' => ''
                                    , 'title'       => __('Secure Merchant ID', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . sprintf(__('This is the Secure Merchant ID, which can be found on the profile page' ,'booking'),'<b>','</b>')
                                                       . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                    , 'description_tag' => 'span'
                                    , 'css'         => ''//'width:100%'
                                    , 'group'       => 'general'
                                    , 'tr_class'    => 'wpbc_sub_settings_paypal_account_type wpbc_sub_settings_paypal_pro_hosted wpbc_sub_settings_grayed'
                                    //, 'validate_as' => array( 'required' )
                            );

        //Payment type
        
        $this->fields['paymentaction'] = array(   
                                    'type' => 'select'
                                    , 'default' => 'sale'
                                    , 'title' => __('Transaction type', 'booking')
                                    , 'description' => __(' Indicates whether the transaction is payment on a final sale or an authorization for a final sale, to be captured later. ', 'booking')  
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => array(
                                                            'sale'          => __('Sale', 'booking')  
                                                          , 'authorization' => __('Authorization', 'booking')                                                              
                                                    )      
                                    , 'group' => 'general'
                            );

        //Sandbox 
        
        $this->fields['is_sandbox'] = array(   
                                    'type' => 'select'
                                    , 'default' => ( wpbc_is_this_demo() ? 'On' : 'Off' )
                                    , 'title' => __('Chose payment mode', 'booking')
                                    , 'description' => __(' Select using test (Sandbox Test Environment) or live PayPal payment.', 'booking')  
//                                                       . '<br/>' . sprintf( __('PayPal sandbox can be used to test payments. Sign up for a developer account %shere%s.', 'booking'), '<a href="https://developer.paypal.com/" targe="_blank">', '</a>' )
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => array(
                                                            'Off' => __('Live', 'booking')  
                                                          , 'On'  => __('Sandbox', 'booking')                                                              
                                                    )      
                                    , 'group' => 'general'
                            );

        // Currency
        
        $currency_list = array(
                                  "USD" => __('U.S. Dollars' ,'booking')
                                , "EUR" => __('Euros' ,'booking')
                                , "GBP" => __('British Pound' ,'booking')
                                , "JPY" => __('Japanese Yen' ,'booking')
                                , "AUD" => __('Australian Dollars' ,'booking')
                                , "CAD" => __('Canadian Dollars' ,'booking')
                                , "NZD" => __('New Zealand Dollar' ,'booking')
                                , "CHF" => __('Swiss Franc' ,'booking')
                                , "HKD" => __('Hong Kong Dollar' ,'booking')
                                , "SGD" => __('Singapore Dollar' ,'booking')
                                , "SEK" => __('Swedish Krona' ,'booking')
                                , "DKK" => __('Danish Krone' ,'booking')
                                , "PLN" => __('Polish Zloty' ,'booking')
                                , "NOK" => __('Norwegian Krone' ,'booking')
                                , "HUF" => __('Hungarian Forint' ,'booking')
                                , "CZK" => __('Czech Koruna' ,'booking')
                                , "ILS" => __('Israeli New Shekel' ,'booking')
                                , "MXN" => __('Mexican Peso' ,'booking')
                                , "BRL" => __('Brazilian Real (only for Brazilian users)' ,'booking')
                                , "MYR" => __('Malaysian Ringgits (only for Malaysian users)' ,'booking')
                                , "PHP" => __('Philippine Pesos' ,'booking')
                                , "TWD" => __('Taiwan New Dollars' ,'booking')
                                , "THB" => __('Thai Baht' ,'booking')
                                , "TRY" => __('Turkish Lira (only for Turkish members)' ,'booking')
        );
        $this->fields['curency'] = array(   
                                    'type' => 'select'
                                    , 'default' => 'USD'
                                    , 'title' => __('Accepted Currency', 'booking')
                                    , 'description' => __('The currency code that gateway will process the payment in.', 'booking')  
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => $currency_list
                                    , 'group' => 'general'
                            );

        
        // Payment Button        
        $field_options = array(
                                'btn_standard_img' => array(  'title' => '<img src="'. WPBC_PAYPAL_PAY_BUTTON_URL .'" style="margin: 0;"/>'
                                                            , 'attr' => array( 'id' => 'paypal_button_type_1' )                                                             
                                                            , 'html' => '<br/>')
                              , 'custom' => array(  'title' => __('Custom button title' ,'booking')
                                                            , 'attr' => array( 'id' => 'paypal_button_type_4' ) )

                            ); 
        $this->fields['button_type'] = array(   
                                    'type'          => 'radio'
                                    , 'default'     => 'btn_standard_img'
                                    , 'title'       => __('Payment Button type' ,'booking')
                                    , 'description' => ''
                                    , 'options'     => $field_options
                                    , 'group'       => 'general'
                            );
        
        $this->fields['payment_button_title'] = array(   
                                'type'          => 'text'
                                , 'default'     => __('Pay via' ,'booking') .' PayPal'
                                , 'placeholder' => __('Pay via' ,'booking') .' PayPal'
                                , 'title'       => __('Payment button title' ,'booking')
                                , 'description' => __('Enter the title of the payment button' ,'booking')
                                ,'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'group'       => 'general'
                                , 'tr_class'    => 'wpbc_sub_settings_payment_button_title wpbc_sub_settings_grayed'
                        );

        
        $this->fields['description_hr'] = array( 'type' => 'hr' );   

        
        // Additional settings /////////////////////////////////////////////////
        
//        $this->fields['is_description_show'] = array(   
//                                'type'          => 'checkbox'
//                                , 'default'     => 'Off'            
//                                , 'title'       => __('Show Payment description', 'booking')
//                                , 'label'       => __('Check this box to show payment description in payment form' ,'booking')
//                                , 'description' => '' 
//                                , 'group'       => 'general'
//            );             

        
        $this->fields['subject'] = array(   
                                'type'          => 'textarea'
                                , 'default'     => sprintf(__('Payment for booking %s on these day(s): %s'  ,'booking'),'[resource_title]','[dates]')
                                , 'placeholder' => sprintf(__('Payment for booking %s on these day(s): %s'  ,'booking'),'[resource_title]','[dates]')
                                , 'title'       => __('Payment description at gateway website' ,'booking')
                                , 'description' => sprintf(__('Enter the service name or the reason for the payment here.' ,'booking'),'<br/>','</b>')            
                                                    . '<br/>' .  __('You can use any shortcodes, which you have used in content of booking fields data form.' ,'booking')            
                                                    . '<div class="wpbc-settings-notice notice-info" style="text-align:left;"><strong>' 
                                                        . __('Note:' ,'booking') . '</strong> '
                                                        . sprintf( __('This field support only up to %s characters by payment system.' ,'booking'), '70' ) 
                                                    . '</div>'
                                ,'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'rows' => 2
                                , 'group'       => 'general'
                                , 'tr_class'    => 'wpbc_sub_settings_is_description_show wpbc_sub_settings_grayedNO'
                        );
        
        $this->fields['is_reference_box'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => 'Off'            
                                , 'title'       => __('Show Reference Text Box', 'booking')
                                , 'label'       => __('Check this box to show Reference Text Box' ,'booking')
                                , 'description' => '' 
                                , 'group'       => 'general'
            );             

        
        $this->fields['reference_title_box'] = array(   
                                'type'          => 'textarea'
                                , 'default'     => __('Enter your phone number'  ,'booking')
                                , 'placeholder' => __('Enter your phone number'  ,'booking')
                                , 'title'       => __('Reference Text Box Title' ,'booking')
                                , 'description' => sprintf( __('Enter a title for the Reference text box (i.e. Your email address). Visitors will see this text.' ,'booking'), '<b>', '</b>' )
                                , 'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'rows' => 2
                                , 'group'       => 'general'
                                , 'tr_class'    => 'wpbc_sub_settings_is_reference_box wpbc_sub_settings_grayed'
                        );

        
        
        ////////////////////////////////////////////////////////////////////
        // Return URL    &   Auto approve | decline
        ////////////////////////////////////////////////////////////////////
        
        //  Success URL
        $this->fields['return_url_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'     
                                , 'html'        => '<tr valign="top" class="wpbc_tr_paypal_return_url">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'paypal_return_url'
                                                                , array(   'title'=> __('Return URL from PayPal' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>' . '<code style="font-size:14px;">' .  get_option('siteurl') . '</code>'
                        );                
        $this->fields['return_url'] = array(   
                                'type'          => 'text'
                                , 'default'     => '/successful'
                                , 'placeholder' => '/successful'
                                , 'css'         => 'width:75%'
                                , 'group'       => 'auto_approve_cancel'
                                , 'only_field'  => true           
                        );
        $this->fields['return_url_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">' 
                                                        . __('The URL where visitor will be redirected after completing payment.' ,'booking') 
                                                        . '<br/>' . sprintf( __('For example, a URL to your site that displays a %s"Thank you for the payment"%s.' ,'booking'),'<b>','</b>')
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                        );        

        //  Failed URL
        $this->fields['cancel_return_url_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'     
                                , 'html'        => '<tr valign="top" class="wpbc_tr_paypal_cancel_return_url">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'paypal_cancel_return_url'
                                                                , array(   'title'=> __('Cancel Return URL from PayPal' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>' . '<code style="font-size:14px;">' .  get_option('siteurl') . '</code>'
                        );                
        $this->fields['cancel_return_url'] = array(   
                                'type'          => 'text'
                                , 'default'     => '/failed'
                                , 'placeholder' => '/failed'
                                , 'css'         => 'width:75%'
                                , 'group'       => 'auto_approve_cancel'
                                , 'only_field'  => true           
                        );
        $this->fields['cancel_return_url_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">' 
                                                        . __('The URL where the visitor will be redirected after completing payment.' ,'booking') 
                                                        . '<br/>' . sprintf( __('For example, the URL to your website that displays a %s"Payment Canceled"%s page.' ,'booking'),'<b>','</b>' )
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                        );        
        
        $this->fields['return_url_hr'] = array( 'type' => 'hr', 'group' => 'auto_approve_cancel' ); 

        //Auto Approve | Cancel
        
        $this->fields['is_auto_approve_cancell_booking'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'Off'            
                                    , 'title'       => __( 'Automatically approve/cancel booking', 'booking' )
                                    , 'label'       => __('Check this box to automatically approve bookings, when visitor makes a successful payment, or automatically cancel the booking, when visitor makes a payment cancellation.' ,'booking')
                                    , 'description' =>  '<div class="wpbc-settings-notice notice-warning" style="text-align:left;">'
                                                            . '<strong>' . __('Warning' ,'booking') . '!</strong> ' . __('This will not work, if the visitor leaves the payment page.' ,'booking')
                                                        . '</div>'
                                    , 'description_tag' => 'p'
                                    , 'group'       => 'auto_approve_cancel'
                                );
        
        ////////////////////////////////////////////////////////////////////
        // Help
        ////////////////////////////////////////////////////////////////////
        
        $this->fields['return_url_help'] = array(   
                                    'type' => 'help'                                        
                                    , 'value' => array()
                                    , 'cols' => 2
                                    , 'group' => 'auto_approve_cancel_help'
                            );

        $this->fields['return_url_help']['value'][] = '<strong>' . sprintf(__('To use this feature you %smust activate auto-return link%s at your Paypal account.' ,'booking'),'<b>','</b>') 
                                                    . '<br/>' . __('Follow these steps to configure it:' ,'booking')
                                                    . '</strong>';        
        $this->fields['return_url_help']['value'][] = '1. ' . __('Log in to your PayPal account.' ,'booking');
        $this->fields['return_url_help']['value'][] = '2. ' . __('Click the Profile subtab.' ,'booking');
        $this->fields['return_url_help']['value'][] = '3. ' . __('Click Website Payment Preferences in the Seller Preferences column.' ,'booking');
        $this->fields['return_url_help']['value'][] = '4. ' . __('Under Auto Return for Website Payments, click the On radio button.' ,'booking');
        $this->fields['return_url_help']['value'][] = '5. ' . __('For the Return URL, enter the Return URL from PayPal on your site for successfull payment.' ,'booking');

        
        ////////////////////////////////////////////////////////////////////
        // IPN
        ////////////////////////////////////////////////////////////////////
        
        $this->fields['ipn_description_help'] = array(   
                                    'type' => 'help'                                        
                                    , 'value' => array( __('Instant Payment Notification (IPN) is a message service that notifies you of events related to PayPal transactions' ,'booking') )
                                    , 'cols' => 2
                                    , 'group' => 'ipn'
                            );
        
        $this->fields['ipn_is_send_verified_email'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'On'            
                                    , 'title'       => __( 'Enable / Disable', 'booking' )
                                    , 'label'       => __( 'Sending email for verified transaction', 'booking')   
                                    , 'description' => ''
                                    , 'group'       => 'ipn'
                                );

        $this->fields['ipn_verified_email'] = array(   
                                'type'          => 'email'
                                , 'default'     => get_option('admin_email')
                                , 'placeholder' => get_option('admin_email')
                                , 'title'       => __('Email Address', 'booking')
                                , 'description' => sprintf(__('Email for getting report for %sverified%s transactions.' ,'booking'),'<b>','</b>')
                                , 'description_tag' => ''
                                , 'css'         => ''
                                , 'tr_class'    => ''
                                //, 'validate_as' => array( 'required' )
                                , 'tr_class'    => 'wpbc_sub_settings_is_send_verified_email wpbc_sub_settings_grayed'
                                , 'group'       => 'ipn'
                        );
        
        $this->fields['ipn_is_send_invalid_email'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'On'            
                                    , 'title'       => __( 'Enable / Disable', 'booking' )
                                    , 'label'       => __( 'Sending email for invalid transaction', 'booking')   
                                    , 'description' => ''
                                    , 'group'       => 'ipn'
                                );

        $this->fields['ipn_invalid_email'] = array(   
                                'type'          => 'email'
                                , 'default'     => get_option('admin_email')
                                , 'placeholder' => get_option('admin_email')
                                , 'title'       => __('Email Address', 'booking')
                                , 'description' => sprintf(__('Email for getting report for %sinvalid%s transactions.' ,'booking'),'<b>','</b>')
                                , 'description_tag' => ''
                                , 'css'         => ''
                                , 'tr_class'    => ''
                                //, 'validate_as' => array( 'required' )
                                , 'tr_class'    => 'wpbc_sub_settings_ipn_is_send_invalid_email wpbc_sub_settings_grayed'
                                , 'group'       => 'ipn'
                        );
        
        $this->fields['ipn_is_send_error_email'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'Off'            
                                    , 'title'       => __( 'Enable / Disable', 'booking' )
                                    , 'label'       => __( 'Sending email if error occur during verification', 'booking')   
                                    , 'description' => ''
                                    , 'group'       => 'ipn'
                                );

        $this->fields['ipn_error_email'] = array(   
                                'type'          => 'email'
                                , 'default'     => get_option('admin_email')
                                , 'placeholder' => get_option('admin_email')
                                , 'title'       => __('Email Address', 'booking')
                                , 'description' => sprintf(__('Email for getting report for %ssome errors in  verification process%s.' ,'booking'),'<b>','</b>')
                                , 'description_tag' => ''
                                , 'css'         => ''
                                , 'tr_class'    => ''
                                //, 'validate_as' => array( 'required' )
                                , 'tr_class'    => 'wpbc_sub_settings_ipn_is_send_error_email wpbc_sub_settings_grayed'
                                , 'group'       => 'ipn'
                        );
        
        $this->fields['ipn_use_ssl'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'On'            
                                    , 'title'       => __( 'Use SSL connection', 'booking' )
                                    , 'label'       => __('Use the SSL connection for posting data, instead of standard HTTP connection' ,'booking')
                                    , 'description' => ''
                                    , 'group'       => 'ipn'
                                );
        $this->fields['ipn_use_curl'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'Off'            
                                    , 'title'       => __('Use cURL posting' ,'booking')
                                    , 'label'       => __('Use the cURL for posting data, instead of fsockopen() function' ,'booking')
                                    , 'description' => ''
                                    , 'group'       => 'ipn'
                                );

        ////////////////////////////////////////////////////////////////////
        // Help
        ////////////////////////////////////////////////////////////////////
        
        $this->fields['ipn_help'] = array(   
                                    'type' => 'help'                                        
                                    , 'value' => array()
                                    , 'cols' => 2
                                    , 'group' => 'ipn_help'
                            );

        $this->fields['ipn_help']['value'][] = '<strong>' . __(' Follow these instructions to set up your listener at your PayPal account:' ,'booking') . '</strong>';
        
        $this->fields['ipn_help']['value'][] = '1. ' . __('Click Profile on the My Account tab.' ,'booking');
        $this->fields['ipn_help']['value'][] = '2. ' . __('Click Instant Payment Notification Preferences in the Selling Preferences column.' ,'booking');
        $this->fields['ipn_help']['value'][] = '3. ' . __('Click Choose IPN Settings to specify your listeners URL and activate the listener.' ,'booking');
        $this->fields['ipn_help']['value'][] = '4. ' . __('Specify the URL for your listener in the Notification URL field as:' ,'booking') 
                                               . '<br /><code>' . WPBC_PLUGIN_URL . '/inc/gateways/paypal/ipn.php' . '</code>';
        $this->fields['ipn_help']['value'][] = '5. ' . __('Click Receive IPN messages (Enabled) to enable your listener.' ,'booking');
        $this->fields['ipn_help']['value'][] = '6. ' . __('Click Save.' ,'booking');
        $this->fields['ipn_help']['value'][] = '7. ' . __('Click Back to Profile Summary to return to the Profile after activating your listener.' ,'booking');        
    }
       
    
    // Support /////////////////////////////////////////////////////////////////
    
    /** Get payment Statuses of gateway
     * 
     * @return array
     */
    public function get_payment_status_array() {
        
        return array(
                        'ok'        => array(  'PayPal:OK'  )
                        , 'pending' => array()
                        , 'unknown' => array()
                        , 'error'   => array(  'PayPal:Failed'  )
                    ); 
    }
    
    
    /** Return info about Gateway
     * 
     * @return array        Example: array(
                                            'id'      => 'paypal
                                          , 'title'   => 'Paypal Standard'
                                          , 'currency'   => 'USD'
                                          , 'enabled' => true
                                        );        
     */
    public function get_gateway_info() {
        
        $type = get_bk_option(  'booking_' . $this->get_id() . '_' . 'pro_hosted_solution' );
                
        $gateway_info = array(
                      'id'       => $this->get_id()
                    , 'title'    => ( $type != 'On') ? __('Paypal Standard', 'booking') : __('Paypal Pro Hosted Solution' ,'booking')
                    , 'currency' => get_bk_option(  'booking_' . $this->get_id() . '_' . 'curency' )
                    , 'enabled'  => $this->is_gateway_on()
        );        
        return $gateway_info;
    }
    
    
    //  R E S P O N S E  ///////////////////////////////////////////////////////
    
    /** Update Payment Status after  Response from specific Payment system website.
     *
     * @param type $response_status
     * @param type $pay_system
     * @param type $status
     * @param type $booking_id
     * @param type $wp_nonce
     * 
     * @return string - $response_status
     */  
    public function update_payment_status__after_response( $response_status, $pay_system, $status, $booking_id, $wp_nonce ) {    
      
        if ( $pay_system == WPBC_PAYPAL_GATEWAY_ID ) { 
            $status = 'PayPal:' . $status; 
            return $status;
        }  
            
        return $response_status;        
    }

    
    /** If activated "Auto approve|decline" and then Redirect to  "Success" or "Failed" payment page.
     * 
     * @param string $pay_system
     * @param string $status
     * @param type $booking_id
     */
    public function auto_approve_or_cancell_and_redirect( $pay_system, $status, $booking_id ) {

        if ( $pay_system == WPBC_PAYPAL_GATEWAY_ID ) {

            $auto_approve = get_bk_option( 'booking_paypal_is_auto_approve_cancell_booking' );

            if ( $status == 'PayPal:OK' ) {
                if ( $auto_approve == 'On' )
                    wpbc_auto_approve_booking( $booking_id );
                wpbc_redirect( get_bk_option( 'booking_paypal_return_url' ) );
            } else {
                if ( $auto_approve == 'On' )
                    wpbc_auto_cancel_booking( $booking_id );
                wpbc_redirect( get_bk_option( 'booking_paypal_cancel_return_url' ) );
            }
        }        
    }
}

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Settings  Page " >

/** Settings  Page  */
class WPBC_Settings_Page_Gateway_PAYPAL extends WPBC_Page_Structure {

    public $gateway_api = false;
    
    /** Define interface for  Gateway  API
     * 
     * @param string $selected_email_name - name of Email template
     * @param array $init_fields_values - array of init form  fields data - this array  can  ovveride "default" fields and loaded data.
     * @return object Email API
     */
    public function get_api( $init_fields_values = array() ){
        
        if ( $this->gateway_api === false ) {
            $this->gateway_api = new WPBC_Gateway_API_PAYPAL( WPBC_PAYPAL_GATEWAY_ID , $init_fields_values );    
        }
        
        return $this->gateway_api;
    }
    
    
    /** Check Compatibility with  data of previos versions */
    private function check_compatibility_with_older_7_ver() {

        /**
         * Currently  we are using only  1 syandard IMAGE button  from PayPal, previously was several. 
         * So  if its does not standar  button,  then  set 'btn_standard_img' value for definition PayPal Img Button.
         * The link to  this button  defined at the CONSTANT at  top  of this file
         */
        
        $field_value = get_bk_option( 'booking_paypal_button_type' );
        
        if (  ( $field_value != 'custom' ) && (  $field_value != 'btn_standard_img' )  ){
            update_bk_option( 'booking_paypal_button_type', 'btn_standard_img' );
        }
    }

    
    public function in_page() {                                                 // P a g e    t a g
        return 'wpbc-settings';
    }
    
    
    public function tabs() {                                                    // T a b s      A r r a y
        
        $tabs = array();
        
        $subtabs = array();

        // Checkbox Icon, for showing in toolbar panel does this payment system active 
        $is_data_exist = get_bk_option( 'booking_'. WPBC_PAYPAL_GATEWAY_ID .'_is_active' );
        if (  ( ! empty( $is_data_exist ) ) && ( $is_data_exist == 'On' )  )
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-check"></i> &nbsp; ';
        else 
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-unchecked"></i> &nbsp; ';
        
        
        $subtabs[ WPBC_PAYPAL_GATEWAY_ID ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' =>  $icon . __('PayPal' ,'booking')       // Title of TAB    
                            , 'page_title' => sprintf( __('%s Settings', 'booking'), 'PayPal' )     // Title of Page   
                            , 'hint' => __('Integration of Paypal payment system' ,'booking')       // Hint    
                            , 'link' => ''                                      // link
                            , 'position' => ''                                  // 'left'  ||  'right'  ||  ''
                            , 'css_classes' => ''                               // CSS class(es)
                            //, 'icon' => 'http://.../icon.png'                 // Icon - link to the real PNG img
                            //, 'font_icon' => 'glyphicon glyphicon-envelope'   // CSS definition of Font Icon
                            , 'default' =>  false                                // Is this sub tab activated by default or not: true || false. 
                            , 'disabled' => false                               // Is this sub tab deactivated: true || false. 
                            , 'checkbox'  => false                              // or definition array  for specific checkbox: array( 'checked' => true, 'name' => 'feature1_active_status' )   //, 'checkbox'  => array( 'checked' => $is_checked, 'name' => 'enabled_active_status' )
                            , 'content' => 'content'                            // Function to load as conten of this TAB
                        );
        
        $tabs[ 'payment' ]['subtabs'] = $subtabs;
                        
        return $tabs;
    }
    

    /** Show Content of Settings page */
    public function content() {

        $this->css();
        
        ////////////////////////////////////////////////////////////////////////
        // Checking 
        ////////////////////////////////////////////////////////////////////////
        
        do_action( 'wpbc_hook_settings_page_header', 'gateway_settings');       // Define Notices Section and show some static messages, if needed
        do_action( 'wpbc_hook_settings_page_header', 'gateway_settings_' . WPBC_PAYPAL_GATEWAY_ID );
        
        if ( ! wpbc_is_mu_user_can_be_here('activated_user') ) return false;    // Check if MU user activated, otherwise show Warning message.
   
        // if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;  // User is not Super admin, so exit.  Basically its was already checked at the bottom of the PHP file, just in case.

        
        ////////////////////////////////////////////////////////////////////////
        // Load Data 
        ////////////////////////////////////////////////////////////////////////
        
        $this->check_compatibility_with_older_7_ver();
        
        $init_fields_values = array();               
        
        $this->get_api( $init_fields_values );
        
        
        ////////////////////////////////////////////////////////////////////////
        //  S u b m i t   Main Form  
        ////////////////////////////////////////////////////////////////////////
        
        $submit_form_name = 'wpbc_gateway_' . WPBC_PAYPAL_GATEWAY_ID;               // Define form name
        
        $this->get_api()->validated_form_id = $submit_form_name;                // Define ID of Form for ability to  validate fields (like required field) before submit.
        
        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name );  // Its stop show anything on submiting, if its not refear to the original page

            // Save Changes 
            $this->update();
        }                
        
        
        ////////////////////////////////////////////////////////////////////////
        // JavaScript: Tooltips, Popover, Datepick (js & css) 
        ////////////////////////////////////////////////////////////////////////
        
        echo '<span class="wpdevelop">';
        
        wpbc_js_for_bookings_page();                                        
        
        echo '</span>';

        
        ////////////////////////////////////////////////////////////////////////
        // Content
        ////////////////////////////////////////////////////////////////////////
        ?>         
        <div class="clear" style="margin-bottom:10px;"></div>                        
                
        <span class="metabox-holder">            
            <form  name="<?php echo $submit_form_name; ?>" id="<?php echo $submit_form_name; ?>" action="" method="post" autocomplete="off">
                <?php 
                   // N o n c e   field, and key for checking   S u b m i t 
                   wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo $submit_form_name; ?>" id="is_form_sbmitted_<?php echo $submit_form_name; ?>" value="1" />


                <div class="clear"></div>    
                <div class="metabox-holder">

                    <div class="wpbc_settings_row wpbc_settings_row_left_NO" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'general', sprintf( __('%s Settings', 'booking'), 'PayPal' ) );
                            $this->get_api()->show( 'general' );                             
                        wpbc_close_meta_box_section(); 
                    ?>    
                    </div>
                    <div class="clear"></div>
                    

                    <div class="wpbc_settings_row wpbc_settings_row_left" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'auto_approve_cancel', __('Advanced', 'booking')   );                            
                            $this->get_api()->show( 'auto_approve_cancel' );                             
                        wpbc_close_meta_box_section(); 
                    ?>    
                    </div>
                    <div class="wpbc_settings_row wpbc_settings_row_right">
                    <?php 
                        wpbc_open_meta_box_section( $submit_form_name . 'auto_approve_cancel_help', __('Help', 'booking')   );                            
                            $this->get_api()->show( 'auto_approve_cancel_help' );                             
                        wpbc_close_meta_box_section(); 
                    ?>
                    </div>                  
                    <div class="clear"></div>
                    

                    <div class="wpbc_settings_row wpbc_settings_row_left" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'ipn', __('PayPal IPN', 'booking') );                            
                            $this->get_api()->show( 'ipn' );                             
                        wpbc_close_meta_box_section(); 
                    ?>    
                    </div>
                    <div class="wpbc_settings_row wpbc_settings_row_right">
                    <?php 
                        wpbc_open_meta_box_section( $submit_form_name . 'ipn_help', __('Help', 'booking')   );                            
                            $this->get_api()->show( 'ipn_help' );                             
                        wpbc_close_meta_box_section(); 
                    ?>
                    </div>                  
                    <div class="clear"></div>

                </div>
                
                <input type="submit" value="<?php _e('Save Changes', 'booking'); ?>" class="button button-primary" />  
            </form>
        </span>
        <?php
        
        $this->enqueue_js();
    }
    
    
    /** Update Email template to DB */
    public function update() {

        // Get Validated Email fields
        $validated_fields = $this->get_api()->validate_post();
        
        $validated_fields = apply_filters( 'wpbc_gateway_paypal_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.
        
//debuge($validated_fields);        
        
        $this->get_api()->save_to_db( $validated_fields );
                
        wpbc_show_message ( __('Settings saved.', 'booking'), 5 );              // Show Save message
    }

    
    // <editor-fold     defaultstate="collapsed"                        desc=" CSS & JS  "  >
    
    /** CSS for this page */
    private function css() {
        ?>
        <style type="text/css">  
            #paypal_button_type_1 {
                vertical-align: text-top;
            }
            .wpbc-help-message {
                border:none;
                margin:0 !important;
                padding:0 !important;
            }
            
            @media (max-width: 399px) {
            }
        </style>
        <?php
    }
    

    /**     Add Custon JavaScript - for some specific settings options
     *      Executed After post content, after initial definition of settings,  and possible definition after POST request.
     * 
     * @param type $menu_slug
     */
    private function enqueue_js(){                                                        
        
        // JavaScript //////////////////////////////////////////////////////////////
        
        $js_script = '';
        

        //Show|Hide grayed section      
        $js_script .= " 
                        if ( ! jQuery('#paypal_type_standard').is(':checked') ) {   
                            jQuery('.wpbc_sub_settings_paypal_standard').addClass('hidden_items'); 
                        }
                        if ( ! jQuery('#paypal_type_pro_hosted_solution').is(':checked') ) {   
                            jQuery('.wpbc_sub_settings_paypal_pro_hosted').addClass('hidden_items'); 
                        }
                      ";             
        // Hide|Show  on Click      Radion
        $js_script .= " jQuery('input[name=\"paypal_pro_hosted_solution\"]').on( 'change', function(){    
                                jQuery('.wpbc_sub_settings_paypal_account_type').addClass('hidden_items'); 
                                if ( jQuery('#paypal_type_standard').is(':checked') ) {   
                                    jQuery('.wpbc_sub_settings_paypal_standard').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_sub_settings_paypal_pro_hosted').removeClass('hidden_items');
                                }
                            } ); ";        
        
        ////////////////////////////////////////////////////////////////////////
        
        //Show|Hide grayed section      
        $js_script .= " 
                        if ( ! jQuery('#paypal_button_type_4').is(':checked') ) {   
                            jQuery('.wpbc_tr_paypal_payment_button_title').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Radion
        $js_script .= " jQuery('input[name=\"paypal_button_type\"]').on( 'change', function(){    
                                if ( jQuery('#paypal_button_type_4').is(':checked') ) {   
                                    jQuery('.wpbc_tr_paypal_payment_button_title').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_paypal_payment_button_title').addClass('hidden_items');
                                }
                            } ); ";        
        
        ////////////////////////////////////////////////////////////////////////
        
        //Show|Hide grayed section   
//        $js_script .= " 
//                        if ( ! jQuery('#paypal_is_description_show').is(':checked') ) {   
//                            jQuery('.wpbc_tr_paypal_subject').addClass('hidden_items'); 
//                        }
//                      ";        
//        // Hide|Show  on Click      Checkbox
//        $js_script .= " jQuery('#paypal_is_description_show').on( 'change', function(){    
//                                if ( this.checked ) { 
//                                    jQuery('.wpbc_tr_paypal_subject').removeClass('hidden_items');
//                                } else {
//                                    jQuery('.wpbc_tr_paypal_subject').addClass('hidden_items');
//                                }
//                            } ); ";        
                
        ////////////////////////////////////////////////////////////////////////
        
        //Show|Hide grayed section   
        $js_script .= " 
                        if ( ! jQuery('#paypal_is_reference_box').is(':checked') ) {   
                            jQuery('.wpbc_tr_paypal_reference_title_box').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#paypal_is_reference_box').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_paypal_reference_title_box').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_paypal_reference_title_box').addClass('hidden_items');
                                }
                            } ); ";        
                
        ////////////////////////////////////////////////////////////////////////
        
        //Show|Hide grayed section   
        $js_script .= " 
                        if ( ! jQuery('#paypal_is_send_verified_email').is(':checked') ) {   
                            jQuery('.wpbc_tr_paypal_ipn_verified_email').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#paypal_is_send_verified_email').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_paypal_ipn_verified_email').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_paypal_ipn_verified_email').addClass('hidden_items');
                                }
                            } ); ";        
                
        ////////////////////////////////////////////////////////////////////////
        
        //Show|Hide grayed section   
        $js_script .= " 
                        if ( ! jQuery('#paypal_ipn_is_send_invalid_email').is(':checked') ) {   
                            jQuery('.wpbc_tr_paypal_ipn_invalid_email').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#paypal_ipn_is_send_invalid_email').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_paypal_ipn_invalid_email').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_paypal_ipn_invalid_email').addClass('hidden_items');
                                }
                            } ); ";        
                
        ////////////////////////////////////////////////////////////////////////
        
        //Show|Hide grayed section   
        $js_script .= " 
                        if ( ! jQuery('#paypal_ipn_is_send_error_email').is(':checked') ) {   
                            jQuery('.wpbc_tr_paypal_ipn_error_email').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#paypal_ipn_is_send_error_email').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_paypal_ipn_error_email').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_paypal_ipn_error_email').addClass('hidden_items');
                                }
                            } ); ";        
        
        
        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );                
    }

    
    // </editor-fold>    
}
add_action('wpbc_menu_created',  array( new WPBC_Settings_Page_Gateway_PAYPAL() , '__construct') );    // Executed after creation of Menu



/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Check "Return URLs" and "PAYPAL Email"m, etc...
 * 
 * @param array $validated_fields
 */
function wpbc_gateway_paypal_validate_fields_before_saving__all( $validated_fields ) {

    $validated_fields['return_url']         = wpbc_make_link_relative( $validated_fields['return_url'] );
    $validated_fields['cancel_return_url']  = wpbc_make_link_relative( $validated_fields['cancel_return_url'] );
    
    if ( wpbc_is_this_demo() ) {
        $validated_fields['pro_hosted_solution'] = 'Off';
        $validated_fields['emeil']              = 'Seller_1335004986_biz@wpdevelop.com';
        $validated_fields['secure_merchant_id'] = '';
        $validated_fields['is_sandbox'] = 'On';
    }
    
    return $validated_fields;
}
add_filter( 'wpbc_gateway_paypal_validate_fields_before_saving', 'wpbc_gateway_paypal_validate_fields_before_saving__all', 10, 1 );   // Hook for validated fields.

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Activate | Deactivate " >    

////////////////////////////////////////////////////////////////////////////////
// Activate | Deactivate
////////////////////////////////////////////////////////////////////////////////

/** A c t i v a t e */
function wpbc_booking_activate_PAYPAL() {

    $op_prefix = 'booking_' . WPBC_PAYPAL_GATEWAY_ID . '_';
    
    add_bk_option( $op_prefix . 'is_active', 'On' );        
    add_bk_option( $op_prefix . 'pro_hosted_solution', 'Off' );
    add_bk_option( $op_prefix . 'emeil', ( wpbc_is_this_demo() ) ? 'Seller_1335004986_biz@wpdevelop.com' : get_option( 'admin_email' ) );
    add_bk_option( $op_prefix . 'secure_merchant_id', '' );
    add_bk_option( $op_prefix . 'paymentaction', 'sale' );
    add_bk_option( $op_prefix . 'is_sandbox', ( wpbc_is_this_demo() ? 'On' : 'Off' ) );
    add_bk_option( $op_prefix . 'curency', 'USD' );
    add_bk_option( $op_prefix . 'button_type', 'btn_standard_img' );
    add_bk_option( $op_prefix . 'payment_button_title', __('Pay via' ,'booking') .' PayPal' );
//    add_bk_option( $op_prefix . 'is_description_show', 'Off' );             
    add_bk_option( $op_prefix . 'subject', sprintf(__('Payment for booking %s on these day(s): %s'  ,'booking'),'[resource_title]','[dates]') );
    add_bk_option( $op_prefix . 'is_reference_box', 'Off' );             
    add_bk_option( $op_prefix . 'reference_title_box', __('Enter your phone number'  ,'booking') );
    add_bk_option( $op_prefix . 'return_url', '/successful' );
    add_bk_option( $op_prefix . 'cancel_return_url', '/failed' );
    add_bk_option( $op_prefix . 'is_auto_approve_cancell_booking', 'Off' );
    add_bk_option( $op_prefix . 'ipn_is_send_verified_email', 'On' );
    add_bk_option( $op_prefix . 'ipn_verified_email', get_option('admin_email') );
    add_bk_option( $op_prefix . 'ipn_is_send_invalid_email', 'On' );
    add_bk_option( $op_prefix . 'ipn_invalid_email', get_option('admin_email') );
    add_bk_option( $op_prefix . 'ipn_is_send_error_email', 'Off' );
    add_bk_option( $op_prefix . 'ipn_error_email', get_option('admin_email') );
    add_bk_option( $op_prefix . 'ipn_use_ssl', 'On' );
    add_bk_option( $op_prefix . 'ipn_use_curl', 'Off' );        
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_PAYPAL'   );
                
/** D e a c t i v a t e */
function wpbc_booking_deactivate_PAYPAL() {
    
    $op_prefix = 'booking_' . WPBC_PAYPAL_GATEWAY_ID . '_';
    
    delete_bk_option( $op_prefix . 'is_active' );
    delete_bk_option( $op_prefix . 'pro_hosted_solution' );
    delete_bk_option( $op_prefix . 'emeil' );
    delete_bk_option( $op_prefix . 'secure_merchant_id' );
    delete_bk_option( $op_prefix . 'paymentaction' );
    delete_bk_option( $op_prefix . 'is_sandbox' );
    delete_bk_option( $op_prefix . 'curency' );
    delete_bk_option( $op_prefix . 'button_type' );
    delete_bk_option( $op_prefix . 'payment_button_title' );
    delete_bk_option( $op_prefix . 'is_description_show' );
    delete_bk_option( $op_prefix . 'subject' );
    delete_bk_option( $op_prefix . 'is_reference_box' );
    delete_bk_option( $op_prefix . 'reference_title_box' );
    delete_bk_option( $op_prefix . 'return_url' );
    delete_bk_option( $op_prefix . 'cancel_return_url' );
    delete_bk_option( $op_prefix . 'is_auto_approve_cancell_booking' );
    delete_bk_option( $op_prefix . 'ipn_is_send_verified_email' );
    delete_bk_option( $op_prefix . 'ipn_verified_email' );
    delete_bk_option( $op_prefix . 'ipn_is_send_invalid_email' );
    delete_bk_option( $op_prefix . 'ipn_invalid_email' );
    delete_bk_option( $op_prefix . 'ipn_is_send_error_email' );
    delete_bk_option( $op_prefix . 'ipn_error_email' );
    delete_bk_option( $op_prefix . 'ipn_use_ssl' );
    delete_bk_option( $op_prefix . 'ipn_use_curl' );   
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_PAYPAL' );

//                                                                              </editor-fold>


// Hook for getting gateway payment form to  show it after  booking process,  or for "payment request" after  clicking on link in email.
// Note,  here we generate new Object for correctly getting payment fields data of specific WP User  in WPBC MU version. 
add_filter( 'wpbc_get_gateway_payment_form', array( new WPBC_Gateway_API_PAYPAL( WPBC_PAYPAL_GATEWAY_ID ), 'get_payment_form' ), 10, 3 );