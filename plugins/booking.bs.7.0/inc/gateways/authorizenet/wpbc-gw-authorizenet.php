<?php
/**
 * @version 1.0
 * @package  Authorize.Net Server Integration Method(SIM).
 * @category Payment Gateway for Booking Calendar 
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-07-29
 * Integration  was done on July of 2013
 * Based on guide: http://www.authorize.net/support/SIM_guide.pdf of May 2013
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly
                                                                                
if ( ! defined( 'WPBC_AUTHORIZENET_GATEWAY_ID' ) )        define( 'WPBC_AUTHORIZENET_GATEWAY_ID', 'authorizenet' );    


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Gateway API " >

/** API  for  Payment Gateway  */
class WPBC_Gateway_API_AUTHORIZENET extends WPBC_Gateway_API  {                         
    
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
        $payment_options[ 'subject' ]               = get_bk_option( 'booking_authorizenet_subject' );                  // 'Payment for booking %s on these day(s): %s'
            $payment_options[ 'subject' ] = apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'subject' ] );
            $payment_options[ 'subject' ] = wpbc_replace_booking_shortcodes( $payment_options[ 'subject' ], $params );
        $payment_options[ 'test' ]                  = get_bk_option( 'booking_authorizenet_test' );                     // 'TEST'        
        $payment_options[ 'payment_button_title' ]  = get_bk_option( 'booking_authorizenet_payment_button_title' );     // 'Pay via Authorize.Net'        
            $payment_options[ 'payment_button_title' ]  =  apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'payment_button_title' ] );            
        $payment_options[ 'api_login_id' ]          = get_bk_option( 'booking_authorizenet_api_login_id' );             // '29bzABJRJB7B'
        $payment_options[ 'transaction_key' ]       = get_bk_option( 'booking_authorizenet_transaction_key' );          // '97NMkURkn84v6J46'                
        $payment_options[ 'curency' ]               = get_bk_option( 'booking_authorizenet_curency' );                  // 'EUR'    
        $payment_options[ 'transaction_type' ]      = get_bk_option( 'booking_authorizenet_transaction_type' );         // 'PAYMENT'    
        
        ////////////////////////////////////////////////////////////////////////
        // Check about not correct configuration  of settings: 
        ////////////////////////////////////////////////////////////////////////
        if ( empty( $payment_options[ 'api_login_id' ] ) )          return 'Wrong configuration in gateway settings.' . '<em>Empty: "API Login ID" option</em>';
        if ( empty( $payment_options[ 'transaction_key' ] ) )       return 'Wrong configuration in gateway settings.' . '<em>Empty: "Transaction Key" option</em>';
        if ( empty( $payment_options[ 'curency' ] ) )               return 'Wrong configuration in gateway settings.' . '<em>Empty: "Currency" option</em>';
        if ( empty( $payment_options[ 'transaction_type' ] ) )      return 'Wrong configuration in gateway settings.' . '<em>Empty: "Transaction type" option</em>';

        
        ////////////////////////////////////////////////////////////////////////
        // Prepare Parameters for payment form
        ////////////////////////////////////////////////////////////////////////
            
        if ($payment_options[ 'test' ] == 'SANDBOX')
            $post_URL = 'https://test.authorize.net/gateway/transact.dll';
        else
            $post_URL = 'https://secure.authorize.net/gateway/transact.dll';
            
        $fp_timestamp = time();
        $fp_sequence = $params['booking_id'] . time();                                // Enter an invoice or other unique number.
        $fingerprint = getFingerPrintForAuthorizenet( $payment_options['api_login_id']
                                                    , $payment_options['transaction_key']
                                                    , $params['cost_in_gateway']
                                                    , $fp_sequence
                                                    , $fp_timestamp
                                                    , $payment_options['curency'] );
        
        ////////////////////////////////////////////////////////////////////////
        // Payment Form 
        ////////////////////////////////////////////////////////////////////////
        ob_start();
        
        ?><div style="width:100%;clear:both;margin-top:20px;"></div><?php 
        ?><div class="authorizenet_div wpbc-payment-form" style="text-align:left;clear:both;"><?php 

        /** We need to open payment form in separate window, if this booking was made togather with other 
         *  in booking form  was used several  calendars from  different booking resources. 
         *  So we are having several  payment forms for each  booked resource. 
         *  System transfer this parameter $params['payment_form_target'] = ' target="_blank" ';
         *  otherwise $params['payment_form_target'] = '';
         */     
   
        ?><form action="<?php echo $post_URL; ?>" <?php echo $params['payment_form_target']; ?> method="POST" id="authorizenetPayForm" name="authorizenetPayForm" style="text-align:left;" class="booking_authorizenetPayForm"><?php 
        echo "<strong>" . $params['gateway_hint'] . ': ' . $params[ 'cost_in_gateway_hint' ] . "</strong><br />";
        
        
        ?><input type="hidden" name="x_login" value="<?php echo $payment_options[ 'api_login_id' ]; ?>" /><?php     // Merchant        
        ?><input type="hidden" name="x_fp_hash" value="<?php echo $fingerprint; ?>" /><?php                         // Fingerprint
        ?><input type="hidden" name="x_fp_sequence" value="<?php echo $fp_sequence; ?>" /><?php
        ?><input type="hidden" name="x_fp_timestamp" value="<?php echo $fp_timestamp; ?>" /><?php        
        ?><input type="hidden" name="x_type" value="<?php echo $payment_options[ 'transaction_type' ]; ?>" /><?php  // Transaction        
        ?><input type="hidden" name="x_amount" value="<?php echo $params['cost_in_gateway']; ?>" /><?php            // Payment        
        ?><input type="hidden" name="x_show_form" value="payment_form" /><?php                                      // Payment Form Configuration        
        ?><input type="hidden" name="x_version" value="3.1" /><?php                                                 // Best Practice Fields
        ?><input type="hidden" name="x_method" value="cc" /><?php                                                   // Format: CC or ECHECK   - Notes: The method of payment for the transaction, CC (credit card) or ECHECK (electronic check). If left blank, this value defaults to CC.         
        if ( $payment_options[ 'test' ] == 'TEST' ) {                                                               // SANDBOX Environment is not require this parameter in the payment form.
            ?><input type="hidden" name="x_test_request" value="true" /><?php
        }
        if ( $payment_options[ 'test' ] == 'LIVE' ) { 
            ?><input type="hidden" name="x_test_request" value="false" /><?php
        }
        ?><input type="hidden" name="x_currency_code" value="<?php echo $payment_options[ 'curency' ]; ?>" /><?php
        ?><input type="hidden" name="x_description" value="<?php echo substr( $payment_options[ 'subject' ] ,0,255); ?>" /><?php
        ?><input type="hidden" name="x_invoice_num" value="<?php echo 'booking'.$params[ 'booking_id' ]; ?>" /><?php            
        ?><input type="hidden" name="x_po_num" value="<?php echo 'order'.$params[ '__nonce' ]; ?>" /><?php
        
        //                                                                              <editor-fold   defaultstate="collapsed"   desc=" BILLING INFORMATION " >    
        
        // Required only when using a European Payment Processor                

        // Email
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_customer_email' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_email" value="<?php echo substr( $params[ $billing_field_name ], 0, 255 ); ?>" /><?php
        }
        // First Name
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_firstnames' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {        
            ?><input type="hidden" name="x_first_name" value="<?php echo substr( $params[ $billing_field_name ], 0, 50 ); ?>" /><?php
        }
        // Last Name
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_surname' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_last_name" value="<?php echo substr( $params[ $billing_field_name ], 0, 50 ); ?>" /><?php
        }        
        // Address
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_address1' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_address" value="<?php echo substr( $params[ $billing_field_name ], 0, 60 ); ?>" /><?php
        }
        // City
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_city' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_city" value="<?php echo substr( $params[ $billing_field_name ], 0, 40 ); ?>" /><?php
        }
        // Country
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_country' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_country" value="<?php echo substr( $params[ $billing_field_name ], 0, 60 ); ?>" /><?php
        }
        // ZIP Code
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_post_code' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_zip" value="<?php echo substr( $params[ $billing_field_name ], 0, 20 ); ?>" /><?php
        }
        // State
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_state' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_state" value="<?php echo substr( $params[ $billing_field_name ], 0, 40 ); ?>" /><?php
        }
        // Phone
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_phone' ) ); 
        if ( isset( $params[ $billing_field_name ] ) ) {
            ?><input type="hidden" name="x_phone" value="<?php echo substr( $params[ $billing_field_name ], 0, 25 ); ?>" /><?php
        }
        //                                                                              </editor-fold>
               
        if ( get_bk_option( 'booking_authorizenet_relay_response_is_active' ) == 'On') {                            // Relay Response Configuration
            
            $authorizenet_relay_response_URL  =  WPBC_PLUGIN_URL . '/inc/gateways/wpbc-response.php?pay_sys=' . $this->get_id() ;      
            
            ?><input type="hidden" name="x_relay_response" value="true" /><?php
            ?><input type="hidden" name="x_relay_always" value="true" /><?php
            ?><input type="hidden" name="x_relay_url" value="<?php echo $authorizenet_relay_response_URL; ?>" /><?php
        }   
        
        ?><input type="submit" value="<?php echo $payment_options[ 'payment_button_title' ]; ?>" class="btn" /><?php 

        ?></form></div><?php 
        
        $payment_form = ob_get_clean();
        
        // Auto redirect to the AuthorizeNet website, after visitor clicked on "Send" button.  We do not need to return this Script, instead of that just write it here
        /*
        ?><script type='text/javascript'> 
            setTimeout(function() { 
               jQuery("#gateway_payment_forms<?php echo $params['resource_id']; ?> .authorizenet_div.wpbc-payment-form form").submit(); 
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
        // API LOGIN ID
        $this->fields['api_login_id'] = array(   
                                      'type'        => 'text'
                                    , 'default'     => ( wpbc_is_this_demo() ? '29bzABJRJB7B' : '' )
                                    //, 'placeholder' => ''
                                    , 'title'       => __('API Login ID', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . sprintf( __('The merchant API Login ID is provided in the Merchant Interface of %s' ,'booking'), 'Authorize.Net' )
                                                       . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                    , 'description_tag' => 'span'
                                    , 'css'         => ''//'width:100%'
                                    , 'group'       => 'general'
                                    , 'tr_class'    => 'wpbc_sub_settings_grayed'
                                    //, 'validate_as' => array( 'required' )
                            );
        // Transaction Key
        $this->fields['transaction_key'] = array(   
                                      'type'        => 'text'
                                    , 'default'     => ( wpbc_is_this_demo() ? '97NMkURkn84v6J46' : '' )
                                    //, 'placeholder' => ''
                                    , 'title'       => __('Transaction Key', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . sprintf( __( 'This parameter have to assigned to you by %s' ,'booking'), 'Authorize.Net' )
                                                       . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                    , 'description_tag' => 'span'
                                    , 'css'         => ''//'width:100%'
                                    , 'group'       => 'general'
                                    , 'tr_class'    => 'wpbc_sub_settings_grayed'
                                    //, 'validate_as' => array( 'required' )
                            );
        // Payment mode        
        $this->fields['test'] = array(   
                                    'type' => 'select'
                                    , 'default' => 'SANDBOX'
                                    , 'title' => __('Chose payment mode' ,'booking')
                                    , 'description' => sprintf(__('Select "Live test" or "Live" environment for using Merchant account or "Developer Test" for using Developer account.' ,'booking'),'<b>','</b>')
                                                    . '<div class="wpbc-settings-notice notice-info" style="text-align:left;"><strong>' 
                                                        . __('Note:' ,'booking') . '</strong> '
                                                        . sprintf(__('Transactions posted against live merchant accounts using either of the above testing methods are not submitted to financial institutions for authorization and are not stored in the Merchant Interface.' ,'booking'),'<b>','</b>')
                                                    . '</div>'
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => array(   'SANDBOX' => __('Developer Test', 'booking')  
                                                          , 'TEST' => __('Live Test', 'booking')  
                                                          , 'LIVE' => __('Live', 'booking')                                                                                                                          
                                                    )      
                                    , 'group' => 'general'
                            );
        // Transaction Type       
        $this->fields['transaction_type'] = array(   
                                    'type' => 'select'
                                    , 'default' => 'AUTH_CAPTURE'
                                    , 'title' => __('Transaction type', 'booking')
                                    , 'description' => sprintf( __('Select transaction type, which supported by the payment gateway.' ,'booking'),'<b>','</b>')
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => array(   'AUTH_CAPTURE'  => __('Authorization and Capture', 'booking')  
                                                          , 'AUTH_ONLY'     => __('Authorization Only', 'booking')                                                              
                                                        )      
                                    , 'group' => 'general'
                            );        
        // Currency        
        $currency_list = array(
                                  "USD" => __('U.S. Dollars' ,'booking')
                                , "GBP" => __('Pounds Sterling' ,'booking')
                                , "EUR" => __('Euros' ,'booking')
                                , "CAD" => __('Canadian Dollars' ,'booking')
                            );
        $this->fields['curency'] = array(   
                                    'type' => 'select'
                                    , 'default' => 'USD'
                                    , 'title' => __('Accepted Currency', 'booking')
                                    , 'description' => __('The currency code that gateway will process the payment in.', 'booking')  
                                                    . '<div class="wpbc-settings-notice notice-warning" style="text-align:left;"><strong>' 
                                                        . __('Note:' ,'booking') . '</strong> '
                                                        . __('Setting the currency that is not supported by the payment processor will result in an error.' ,'booking')
                                                    . '</div>'
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => $currency_list
                                    , 'group' => 'general'
                            );
        // Payment Button Title        
        $this->fields['payment_button_title'] = array(   
                                'type'          => 'text'
                                , 'default'     => __('Pay via' ,'booking') .' Authorize.Net'
                                , 'placeholder' => __('Pay via' ,'booking') .' Authorize.Net'
                                , 'title'       => __('Payment button title' ,'booking')
                                , 'description' => __('Enter the title of the payment button' ,'booking')
                                ,'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'group'       => 'general'
                                , 'tr_class'    => 'wpbc_sub_settings_payment_button_title wpbc_sub_settings_grayed'
                        );      
        //$this->fields['description_hr'] = array( 'type' => 'hr' );   
        
        // Additional settings /////////////////////////////////////////////////        
        $this->fields['subject'] = array(   
                                'type'          => 'textarea'
                                , 'default'     => sprintf(__('Payment for booking %s on these day(s): %s'  ,'booking'),'[resource_title]','[dates]')
                                , 'placeholder' => sprintf(__('Payment for booking %s on these day(s): %s'  ,'booking'),'[resource_title]','[dates]')
                                , 'title'       => __('Payment description at gateway website' ,'booking')
                                , 'description' => sprintf(__('Enter the service name or the reason for the payment here.' ,'booking'),'<br/>','</b>')            
                                                    . '<br/>' .  __('You can use any shortcodes, which you have used in content of booking fields data form.' ,'booking')            
                                                    . '<div class="wpbc-settings-notice notice-info" style="text-align:left;"><strong>' 
                                                        . __('Note:' ,'booking') . '</strong> '
                                                        . sprintf( __('This field support only up to %s characters by payment system.' ,'booking'), '255' ) 
                                                    . '</div>'
                                ,'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'rows' => 2
                                , 'group'       => 'general'
                                , 'tr_class'    => 'wpbc_sub_settings_is_description_show wpbc_sub_settings_grayedNO'
                        );
        
        
        ////////////////////////////////////////////////////////////////////
        // Return URL    &   Auto approve | decline
        ////////////////////////////////////////////////////////////////////

        // Activate Relay Response 
        $this->fields['relay_response_is_active'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => 'Off'            
                                , 'title'       => __('Activate Relay Response', 'booking')
                                , 'label'       => sprintf( __( 'Indicate to the payment gateway that you would like to receive the transaction response to your site.', 'booking' ) )
                                , 'description' => '<div class="wpbc-settings-notice notice-warning" style="text-align:left;"><strong>' 
                                                                    . __('Important!' ,'booking') . '</strong> '
                                                                    . sprintf( __( 'You should leave empty the Relay Response URL and Receipt Link URL/Text in the Merchant Interface, if a Relay Response is activated here.', 'booking' ) )
                                                                    . '</div>'
                                ,'description_tag' => 'p'
                                , 'group'       => 'auto_approve_cancel'
            );             
        // MD5 Hash value
        $this->fields['md5_hash_value'] = array(   
                                'type'          => 'text'
                                , 'default'     => ( wpbc_is_this_demo() ? 'myhashvalue' : '' )
                                , 'placeholder' => ''
                                , 'title'       => __('MD5 Hash value' ,'booking')
                                , 'description' =>  sprintf(__('Please enter the MD5 Hash value, which you configured in the settings of Merchant Interface.' ,'booking'),'Authorize.Net')
                                                    . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                                    . '<br/><strong>' . __('To configure MD5 Hash value in Relay Response for your transactions' ,'booking') . ':</strong>'
                                                    . '<br/>1. ' . __('Log on to the Merchant Interface' ,'booking')
                                                    . '<br/>2. ' . __('Click Settings under Account in the main menu on the left' ,'booking')
                                                    . '<br/>3. ' . __('Click MD5-Hash in the Security Settings section' ,'booking')
                                                    . '<br/>4. ' . __('Enter this value' ,'booking')
                                                    . '<br/>5. ' . __('Click Submit' ,'booking')
                                                    . '<br/>' . sprintf( __( 'For more information about configuring Relay Response in the Merchant Interface, please see the %sMerchant Integration Guide%s', 'booking' ), '<a href="http://www.authorize.net/support/merchant/"  target="_blank">', '</a>' )
            
                                ,'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'group'       => 'auto_approve_cancel'
                                , 'tr_class'    => 'relay_response_sub_class wpbc_sub_settings_grayed'
                        );
        
        //  Success URL
        $this->fields['order_successful_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'     
                                , 'html'        => '<tr valign="top" class="wpbc_tr_authorizenet_order_successful">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'authorizenet_order_successful'
                                                                , array(   'title'=> __('Return URL after Successful order' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>' . '<code style="font-size:14px;">' .  get_option('siteurl') . '</code>'
                                , 'tr_class'    => 'relay_response_sub_class'            
                        );                
        $this->fields['order_successful'] = array(   
                                'type'          => 'text'
                                , 'default'     => '/successful'
                                , 'placeholder' => '/successful'
                                , 'css'         => 'width:75%'
                                , 'group'       => 'auto_approve_cancel'
                                , 'only_field'  => true   
                                , 'tr_class'    => 'relay_response_sub_class'            
                        );
        $this->fields['order_successful_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">' 
                                                        . __('The URL where visitor will be redirected after completing payment.' ,'booking') 
                                                        . '<br/>' . sprintf( __('For example, a URL to your site that displays a %s"Thank you for the payment"%s.' ,'booking'),'<b>','</b>')
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'       
                                , 'tr_class'    => 'relay_response_sub_class'            
                        );        

        //  Failed URL
        $this->fields['order_failed_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'     
                                , 'html'        => '<tr valign="top" class="wpbc_tr_authorizenet_order_failed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'authorizenet_order_failed'
                                                                , array(   'title'=> __('Return URL after Failed order' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>' . '<code style="font-size:14px;">' .  get_option('siteurl') . '</code>'
                                , 'tr_class'    => 'relay_response_sub_class'            
                        );                
        $this->fields['order_failed'] = array(   
                                'type'          => 'text'
                                , 'default'     => '/failed'
                                , 'placeholder' => '/failed'
                                , 'css'         => 'width:75%'
                                , 'group'       => 'auto_approve_cancel'
                                , 'only_field'  => true           
                                , 'tr_class'    => 'relay_response_sub_class'            
                        );
        $this->fields['order_failed_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">' 
                                                        . __('The URL where the visitor will be redirected after completing payment.' ,'booking') 
                                                        . '<br/>' . sprintf( __('For example, the URL to your website that displays a %s"Payment Canceled"%s page.' ,'booking'),'<b>','</b>' )
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                                , 'tr_class'    => 'relay_response_sub_class'            
                        );                      
        // Auto Approve
        $this->fields['is_auto_approve_booking'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'Off'            
                                    , 'title'       => __( 'Automatically approve booking', 'booking' )
                                    , 'label'       => __('Check this box to automatically approve booking, when visitor makes a successful payment.' ,'booking')
                                    , 'description' =>  '<div class="wpbc-settings-notice notice-warning" style="text-align:left;">'
                                                            . '<strong>' . __('Warning' ,'booking') . '!</strong> ' . __('This will not work, if the visitor leaves the payment page.' ,'booking')
                                                        . '</div>'
                                    , 'description_tag' => 'p'
                                    , 'group'       => 'auto_approve_cancel'
                                    , 'tr_class'    => 'relay_response_sub_class'            
                                );
    }

    
    // Support /////////////////////////////////////////////////////////////////        
    
    /** Return info about Gateway
     * 
     * @return array        Example: array(
                                            'id'      => 'authorizenet
                                          , 'title'   => 'Authorize.Net'
                                          , 'currency'   => 'USD'
                                          , 'enabled' => true
                                        );        
     */
    public function get_gateway_info() {

        $gateway_info = array(
                      'id'       => $this->get_id()
                    , 'title'    => 'Authorize.Net (SIM)'
                    , 'currency' => get_bk_option(  'booking_' . $this->get_id() . '_' . 'curency' )
                    , 'enabled'  => $this->is_gateway_on()
        );                
        return $gateway_info;
    }

    
    /** Get payment Statuses of gateway
     * 
     * @return array
     */
    public function get_payment_status_array() {
        
        return array(
                        'ok'        => array(  'Authorize.Net:Approved'  )
                        , 'pending' => array(  'Authorize.Net:Held for Review' )
                        , 'unknown' => array(  'Authorize.Net:Unknown' )
                        , 'error'   => array( 'Authorize.Net:Error'
                                            , 'Authorize.Net:Declined' 
                                            )
                    ); 
    }

    
    //  R E S P O N S E  ///////////////////////////////////////////////////////
 
    /** (Overrrides) Update Payment Status after  Response from specific Payment system website.
     *  relative to  this - add_filter( 'wpbc_check_response_status_with_crypted_paramaters', array( $this, 'update_payment_status_with_crypted_paramaters' ), 10, 5); // Update Payment status whensending with  crypted parameter - for exmaple in authorize.net payment system
     *
     * @param type $response_status     - reponse status (by default its FALSE)
     * @param type $pay_system          - ID of gateway
     * @param type $status              - by default is ''
     * @param type $booking_id          - by default is ''
     * @param type $wp_nonce            - by default is ''
     * 
     * @return array - $response_status -  array( 
     *                                            'pay_system' => $pay_system   - ID of gateway
                                                , 'status' => $status           - Updates STATUS of payment
                                                , 'booking_id' => $booking_id   - ID of booking 
                                                , 'wp_nonce' => $wp_nonce       - getted nonce field from DB
                                            );
     */  
    public function update_payment_status_with_crypted_paramaters( $response_status, $pay_system, $status, $booking_id, $wp_nonce ) {    
         
        if ( $pay_system == WPBC_AUTHORIZENET_GATEWAY_ID ) { 
            
            // Authorize.Net ///////////////////////////////////////////////////

            $response = array();
            foreach ( $_POST as $key => $value ) {
                $name = substr( $key, 2 );
                $response[$name] = $value;
            }

            //Authenticate response from the Authorize.Net system here.                
            if (
                    isset( $response['MD5_Hash'] ) &&
                    isset( $response['trans_id'] ) &&
                    isset( $response['amount'] )
            ) {
                if ( ! wpbc_response_isAuthorizeNet( $response['MD5_Hash'], $response['trans_id'], $response['amount'] ) ) {
                    debuge( 'Authorize.Net response NOT Authenticated' );
                    die;
                }
            } else {
                debuge( 'Some parameters is not set for the Authorize.Net Authentication !!!' );
                die;
            }

            // Get parametrs about the booking
            if ( isset( $response['invoice_num'] ) )
                $booking_id = trim( str_replace( 'booking', '', $response['invoice_num'] ) );

            if ( isset( $response['po_num'] ) )
                $wp_nonce = trim( str_replace( 'order', '', $response['po_num'] ) );

            if ( isset( $response['response_code'] ) ) {
                $status = trim( $response['response_code'] );
                if ( $status == 1 )
                    $status = 'Authorize.Net:Approved';
                else if ( $status == 2 )
                    $status = 'Authorize.Net:Declined';
                else if ( $status == 3 )
                    $status = 'Authorize.Net:Error';
                else if ( $status == 4 )
                    $status = 'Authorize.Net:Held for Review';
                else
                    $status = 'Authorize.Net:Unknown';
            }
            if ( ($booking_id == '') || ($wp_nonce == '') ) {
                debuge( 'Can not detect the booking of this response' );
                die;
            }
            //////////////////////////////////////////////////////////////////


            return array( 'pay_system' => $pay_system
                , 'status' => $status
                , 'booking_id' => $booking_id
                , 'wp_nonce' => $wp_nonce
            );
        }              
        
        return $response_status;                
    }

               
    /** If activated "Auto approve|decline" and then Redirect to  "Success" or "Failed" payment page.
     * 
     * @param string $pay_system - name of gateway
     * @param string $status     - status of payment   
     * @param type $booking_id
     */
    public function auto_approve_or_cancell_and_redirect( $pay_system, $status, $booking_id ) {

        if ( $pay_system == WPBC_AUTHORIZENET_GATEWAY_ID ) {

            $auto_approve = get_bk_option( 'booking_authorizenet_is_auto_approve_booking' );

            $payment_status = $this->get_payment_status_array();
            
            if (        in_array( $status,  $payment_status['ok'] ) 
                    ||  in_array( $status,  $payment_status['pending'] )  
            ) {
                if ( $auto_approve == 'On' )
                    wpbc_auto_approve_booking( $booking_id );
                wpbc_redirect( get_bk_option( 'booking_authorizenet_order_successful' ) );
            } else {
                if ( $auto_approve == 'On' )
                    wpbc_auto_cancel_booking( $booking_id );
                wpbc_redirect( get_bk_option( 'booking_authorizenet_order_failed' ) );
            }
        }
        
    }

}

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Settings  Page " >

/** Settings  Page  */
class WPBC_Settings_Page_Gateway_AUTHORIZENET extends WPBC_Page_Structure {

    public $gateway_api = false;
    
    /** Define interface for  Gateway  API
     * 
     * @param string $selected_email_name - name of Email template
     * @param array $init_fields_values - array of init form  fields data - this array  can  ovveride "default" fields and loaded data.
     * @return object Email API
     */
    public function get_api( $init_fields_values = array() ){
        
        if ( $this->gateway_api === false ) {
            $this->gateway_api = new WPBC_Gateway_API_AUTHORIZENET( WPBC_AUTHORIZENET_GATEWAY_ID , $init_fields_values );    
        }
        
        return $this->gateway_api;
    }
    
        
    public function in_page() {                                                 // P a g e    t a g
        return 'wpbc-settings';
    }
    
    
    public function tabs() {                                                    // T a b s      A r r a y
        
        $tabs = array();
        
        $subtabs = array();

        // Checkbox Icon, for showing in toolbar panel does this payment system active 
        $is_data_exist = get_bk_option( 'booking_'. WPBC_AUTHORIZENET_GATEWAY_ID .'_is_active' );
        if (  ( ! empty( $is_data_exist ) ) && ( $is_data_exist == 'On' )  )
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-check"></i> &nbsp; ';
        else 
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-unchecked"></i> &nbsp; ';
        
        
        $subtabs[ WPBC_AUTHORIZENET_GATEWAY_ID ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' =>  $icon . 'Authorize.Net'       // Title of TAB    
                            , 'page_title' => sprintf( __('%s Settings', 'booking'), 'Authorize.Net' )  // Title of Page   
                            , 'hint' => __('Integration of authorizenet payment system' ,'booking')   // Hint    
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
        do_action( 'wpbc_hook_settings_page_header', 'gateway_settings_' . WPBC_AUTHORIZENET_GATEWAY_ID );
        
        if ( ! wpbc_is_mu_user_can_be_here('activated_user') ) return false;    // Check if MU user activated, otherwise show Warning message.
   
        // if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;  // User is not Super admin, so exit.  Basically its was already checked at the bottom of the PHP file, just in case.

        
        ////////////////////////////////////////////////////////////////////////
        // Load Data 
        ////////////////////////////////////////////////////////////////////////
        
        // $this->check_compatibility_with_older_7_ver();
        
        $init_fields_values = array();               
        
        $this->get_api( $init_fields_values );
        
        
        ////////////////////////////////////////////////////////////////////////
        //  S u b m i t   Main Form  
        ////////////////////////////////////////////////////////////////////////
        
        $submit_form_name = 'wpbc_gateway_' . WPBC_AUTHORIZENET_GATEWAY_ID;               // Define form name
        
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


                    <div class="clear" style="height:10px;"></div>
                    <div class="wpbc-settings-notice notice-info" style="text-align:left;">
                        <strong><?php _e('Note!' ,'booking'); ?></strong> <?php 
                                printf( __( 'If you have no account on this system, please sign up for a %sdeveloper test account%s to obtain an API Login ID and Transaction Key. These keys will authenticate requests to the payment gateway.', 'booking' )
                                        , '<a href="http://developer.authorize.net/testaccount/"  target="_blank">', '</a>' );
                        ?>
                    </div>
                    <div class="clear" style="height:5px;"></div>
                    <div class="wpbc-settings-notice notice-warning" style="text-align:left;">
                        <strong><?php _e('Important!' ,'booking'); ?></strong> <?php 
                                printf(__('Please configure all fields inside the Billing form fields tab at this page, when using a European payment processor' ,'booking') );                                
                        ?>
                    </div>

                    <div class="clear" style="height:5px;"></div>
                    <div class="wpbc-settings-notice notice-info" style="text-align:left;">
                        <strong><?php _e('Note!' ,'booking'); ?></strong> <?php 
                                printf(__('Be sure that the merchant server system clock is set to the proper time and time zone.' ,'booking') );
                        ?>
                    </div>
                    <div class="clear" style="height:10px;"></div>
                    
                <div class="clear"></div>  
                <div class="metabox-holder">

                    <div class="wpbc_settings_row wpbc_settings_row_left_NO" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'general', sprintf( __('%s - Server Integration Method (SIM)', 'booking'), 'Authorize.Net' )  );
                            $this->get_api()->show( 'general' );                             
                        wpbc_close_meta_box_section(); 
                    ?>    
                    </div>
                    <div class="clear"></div>
                    

                    <div class="wpbc_settings_row wpbc_settings_row_left_NO" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'auto_approve_cancel', __('Advanced', 'booking')   );                            
                            $this->get_api()->show( 'auto_approve_cancel' );                             
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
        
        $validated_fields = apply_filters( 'wpbc_gateway_authorizenet_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.
        
//debuge($validated_fields);        
        
        $this->get_api()->save_to_db( $validated_fields );
                
        wpbc_show_message ( __('Settings saved.', 'booking'), 5 );              // Show Save message
    }

    
    // <editor-fold     defaultstate="collapsed"                        desc=" CSS & JS  "  >
    
    /** CSS for this page */
    private function css() {
        ?>
        <style type="text/css">  
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
                
        $js_script = '';
        
        //Show|Hide grayed section   
        $js_script .= " 
                        if ( ! jQuery('#authorizenet_relay_response_is_active').is(':checked') ) {   
                            jQuery('.relay_response_sub_class,.wpbc_tr_authorizenet_order_successful,.wpbc_tr_authorizenet_order_failed').addClass('hidden_items'); 
                            
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#authorizenet_relay_response_is_active').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.relay_response_sub_class,.wpbc_tr_authorizenet_order_successful,.wpbc_tr_authorizenet_order_failed').removeClass('hidden_items');
                                } else {
                                    jQuery('.relay_response_sub_class,.wpbc_tr_authorizenet_order_successful,.wpbc_tr_authorizenet_order_failed').addClass('hidden_items');
                                }
                            } ); ";        
                        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );          
    }
    
    // </editor-fold>    
}
add_action('wpbc_menu_created',  array( new WPBC_Settings_Page_Gateway_AUTHORIZENET() , '__construct') );    // Executed after creation of Menu


/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Check "Return URLs" and "AUTHORIZENET Email"m, etc...
 * 
 * @param array $validated_fields
 */
function wpbc_gateway_authorizenet_validate_fields_before_saving__all( $validated_fields ) {
                                                    
    $validated_fields['order_successful'] = wpbc_make_link_relative( $validated_fields['order_successful'] );
    $validated_fields['order_failed']     = wpbc_make_link_relative( $validated_fields['order_failed'] );
    
    if ( wpbc_is_this_demo() ) {
        $validated_fields['api_login_id']       = '29bzABJRJB7B';
        $validated_fields['transaction_key']    = '97NMkURkn84v6J46';
        $validated_fields['md5_hash_value']     = 'myhashvalue';
    } 
    
    return $validated_fields;
}
add_filter( 'wpbc_gateway_authorizenet_validate_fields_before_saving', 'wpbc_gateway_authorizenet_validate_fields_before_saving__all', 10, 1 );   // Hook for validated fields.

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Activate | Deactivate " >    

////////////////////////////////////////////////////////////////////////////////
// Activate | Deactivate
////////////////////////////////////////////////////////////////////////////////

/** A c t i v a t e */
function wpbc_booking_activate_AUTHORIZENET() {

    $op_prefix = 'booking_' . WPBC_AUTHORIZENET_GATEWAY_ID . '_';

    add_bk_option( $op_prefix . 'is_active',    ( wpbc_is_this_demo() ? 'On' : 'Off' )  );
    add_bk_option( $op_prefix . 'subject',      sprintf( __('Payment for booking %s on these day(s): %s'  ,'booking'), '[resource_title]','[dates]') );
    add_bk_option( $op_prefix . 'test',         'SANDBOX' );
    add_bk_option( $op_prefix . 'order_successful',     '/successful' );
    add_bk_option( $op_prefix . 'order_failed',         '/failed');
    add_bk_option( $op_prefix . 'payment_button_title' , __('Pay via' ,'booking') .' Authorize.Net');

    add_bk_option( $op_prefix . 'api_login_id',     ( wpbc_is_this_demo() ? '29bzABJRJB7B' : '' )  );
    add_bk_option( $op_prefix . 'transaction_key',  ( wpbc_is_this_demo() ? '97NMkURkn84v6J46' : '' )  );
    add_bk_option( $op_prefix . 'md5_hash_value',   ( wpbc_is_this_demo() ? 'myhashvalue' : '' )  );

    add_bk_option( $op_prefix . 'curency',          'USD' );
    add_bk_option( $op_prefix . 'transaction_type', 'AUTH_CAPTURE' );
    
    add_bk_option( $op_prefix . 'relay_response_is_active', 'Off' );
    add_bk_option( $op_prefix . 'is_auto_approve_booking' , 'Off' );    
    // add_bk_option( $op_prefix . 'is_description_show', 'Off' );
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_AUTHORIZENET'   );
                

/** D e a c t i v a t e */
function wpbc_booking_deactivate_AUTHORIZENET() {
    
    $op_prefix = 'booking_' . WPBC_AUTHORIZENET_GATEWAY_ID . '_';

    delete_bk_option( $op_prefix . 'is_active' );
    delete_bk_option( $op_prefix . 'subject' );
    delete_bk_option( $op_prefix . 'test' );
    delete_bk_option( $op_prefix . 'order_successful' );
    delete_bk_option( $op_prefix . 'order_failed' );
    delete_bk_option( $op_prefix . 'payment_button_title' );
    delete_bk_option( $op_prefix . 'api_login_id' );
    delete_bk_option( $op_prefix . 'transaction_key' );
    delete_bk_option( $op_prefix . 'md5_hash_value' );
    delete_bk_option( $op_prefix . 'curency' );
    delete_bk_option( $op_prefix . 'transaction_type' );
    delete_bk_option( $op_prefix . 'relay_response_is_active' );
    delete_bk_option( $op_prefix . 'is_auto_approve_booking' );
    delete_bk_option( $op_prefix . 'is_description_show' );
    
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_AUTHORIZENET' );

//                                                                              </editor-fold>


// Hook for getting gateway payment form to  show it after  booking process,  or for "payment request" after  clicking on link in email.
// Note,  here we generate new Object for correctly getting payment fields data of specific WP User  in WPBC MU version. 
add_filter( 'wpbc_get_gateway_payment_form', array( new WPBC_Gateway_API_AUTHORIZENET( WPBC_AUTHORIZENET_GATEWAY_ID ), 'get_payment_form' ), 10, 3 );



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Authorize.Net    S u p p o r t   F u n c t i o n s " >    
//////////////////////////////////////////////////////////////////////////////////////////////
//  S u p p o r t   F u n c t i o n s      ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

function wpbc_response_isAuthorizeNet( $md5_hash, $transaction_id, $amount ) {

    $api_login_id = get_bk_option( 'booking_authorizenet_api_login_id' );
    $md5_setting  = get_bk_option( 'booking_authorizenet_md5_hash_value' );

    return count( $_POST ) && $md5_hash && ( wpbc_response_generateHash( $api_login_id, $md5_setting, $transaction_id, $amount ) == $md5_hash );
}


function wpbc_response_generateHash( $api_login_id, $md5_setting, $transaction_id, $amount ) {

    if ( empty( $amount ) )
        $amount = "0.00";

    return strtoupper( md5( $md5_setting . $api_login_id . $transaction_id . $amount ) );
}


// Generates a fingerprint needed for a hosted order form
function getFingerPrintForAuthorizenet( $api_login_id, $transaction_key, $amount, $fp_sequence, $fp_timestamp, $fp_curency ) {
    //$api_login_id = ($api_login_id ? $api_login_id : (defined('AUTHORIZENET_API_LOGIN_ID') ? AUTHORIZENET_API_LOGIN_ID : ""));
    //$transaction_key = ($transaction_key ? $transaction_key : (defined('AUTHORIZENET_TRANSACTION_KEY') ? AUTHORIZENET_TRANSACTION_KEY : ""));
    if ( function_exists( 'hash_hmac' ) ) {
        return hash_hmac( "md5", $api_login_id . "^" . $fp_sequence . "^" . $fp_timestamp . "^" . $amount . "^" . $fp_curency, $transaction_key );
    }
    return bin2hex( mhash( MHASH_MD5, $api_login_id . "^" . $fp_sequence . "^" . $fp_timestamp . "^" . $amount . "^" . $fp_curency, $transaction_key ) );
}
//                                                                              </editor-fold>