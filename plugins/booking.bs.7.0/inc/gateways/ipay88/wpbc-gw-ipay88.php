<?php
/**
 * @version 1.0
 * @package  iPay88
 * @category Payment Gateway for Booking Calendar 
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-07-26
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly
                                                                                
if ( ! defined( 'WPBC_IPAY88_GATEWAY_ID' ) )        define( 'WPBC_IPAY88_GATEWAY_ID', 'ipay88' );    


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Gateway API " >

/** API  for  Payment Gateway  */
class WPBC_Gateway_API_IPAY88 extends WPBC_Gateway_API  {                     
    

    
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
        $payment_options[ 'is_active' ]             = get_bk_option( 'booking_ipay88_is_active' );                // 'On' | 'Off'   
        $payment_options[ 'subject' ]               = get_bk_option( 'booking_ipay88_subject' );                  // 'Payment for booking %s on these day(s): %s'
            $payment_options[ 'subject' ] = apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'subject' ] );
            $payment_options[ 'subject' ] = wpbc_replace_booking_shortcodes( $payment_options[ 'subject' ], $params );
            $payment_options[ 'subject' ] = str_replace('"', '', $payment_options[ 'subject' ]);
            $payment_options[ 'subject' ] = substr($payment_options[ 'subject' ], 0, 100);                    
        $payment_options[ 'return_url' ]      = get_bk_option( 'booking_ipay88_return_url' );         // '/successful'
        $payment_options[ 'cancel_return_url' ]          = get_bk_option( 'booking_ipay88_cancel_return_url' );             // '/failed'
        $payment_options[ 'payment_button_title' ]  = get_bk_option( 'booking_ipay88_payment_button_title' );     // 'Pay via iPay88'        
            $payment_options[ 'payment_button_title' ]  =  apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'payment_button_title' ] );
        $payment_options[ 'merchant_code' ]           = get_bk_option( 'booking_ipay88_merchant_code' );              // ''
        $payment_options[ 'merchant_key' ]   = get_bk_option( 'booking_ipay88_merchant_key' );      // ''        
        $payment_options[ 'curency' ]               = get_bk_option( 'booking_ipay88_curency' );                  // 'USD'            
        $payment_options[ 'is_auto_approve_cancell_booking' ] = get_bk_option( 'booking_ipay88_is_auto_approve_cancell_booking' );      // 'On' | 'Off'   

        
        ////////////////////////////////////////////////////////////////////////
        // Check about not correct configuration  of settings: 
        ////////////////////////////////////////////////////////////////////////
        $field_value = '';
        if ( get_bk_option( 'booking_billing_customer_email' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_customer_email' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 100 );
            }
        }
        if ( empty( $field_value ) ) return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Email" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        $email = $field_value;
        
        $field_value = '';
        if ( get_bk_option( 'booking_billing_firstnames' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_firstnames' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 32 );
            }
        }
        if ( empty( $field_value ) ) return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "First Name" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        $first_name = $field_value;
        
        $field_value = '';
        if ( get_bk_option( 'booking_billing_surname' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_surname' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 64 );
            }
        }
        $last_name = $field_value;
        if ( empty( $field_value ) ) return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Last Name" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        $firstlast_name =  substr($first_name . ' ' . $last_name, 0, 100);
        
        $field_value = '';
        if ( get_bk_option( 'booking_billing_phone' ) !== false ) {
            $billing_field_name = (string) trim( get_bk_option( 'booking_billing_phone' ) ); 
            if ( isset( $params[ $billing_field_name ] ) !== false ) {
                $field_value = substr( $params[ $billing_field_name ], 0, 20 );
            }
        }
        if ( empty( $field_value ) ) return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Phone" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        $phone = $field_value;
        
        
        if ( empty( $payment_options['merchant_key'] ) )  return 'Wrong configuration in gateway settings.' . '<em>Empty: "Merchant Key"</em>';
        if ( empty( $payment_options['merchant_code'] ) ) return 'Wrong configuration in gateway settings.' . '<em>Empty: "Merchant Code"</em>';
        
        
        ////////////////////////////////////////////////////////////////////////
        // Prepare Parameters for payment form
        ////////////////////////////////////////////////////////////////////////        
        
        // This payment system  do  not use the "Failed" url parameter. We can  detect if this order success or not from the Success url page respose.
        $ipay88_order_Successful  =  WPBC_PLUGIN_URL . '/inc/gateways/wpbc-response.php?payed_booking='         . $params[ 'booking_id' ] .'&wp_nonce=' . $params[ '__nonce' ] . '&pay_sys=ipay88&stats=OK' ;
        $ipay88_BackendURL        =  WPBC_PLUGIN_URL . '/inc/gateways/ipay88/ipay88-backend.php?payed_booking=' . $params[ 'booking_id' ] .'&wp_nonce=' . $params[ '__nonce' ] . '&pay_sys=ipay88&stats=OK' ;
                                
        // Amount Currency Payment amount with two decimals and thousand symbols.  Example: 1,278.99  => Check  iPay88 Technical Spec v.1.6.1 on page #7
        $summ = number_format( $params['cost_in_gateway'], 2, '.', ',' );

        $ref_no = substr( 'A0' . $params['booking_id'], 0, 20 );
        $summ_sing = str_replace( '.', '', $summ );
        $summ_sing = str_replace( ',', '', $summ_sing );
        $signature = $payment_options['merchant_key'] . $payment_options['merchant_code'] . $ref_no . $summ_sing . $payment_options['curency'];
        $signature = iPay88_signature( $signature );
           
        
        ////////////////////////////////////////////////////////////////////////
        // Payment Form 
        ////////////////////////////////////////////////////////////////////////
        ob_start();
        
        ?><div style="width:100%;clear:both;margin-top:20px;"></div><?php 
        ?><div class="ipay88_div wpbc-payment-form" style="text-align:left;clear:both;"><?php 

        /** We need to open payment form in separate window, if this booking was made togather with other 
         *  in booking form  was used several  calendars from  different booking resources. 
         *  So we are having several  payment forms for each  booked resource. 
         *  System transfer this parameter $params['payment_form_target'] = ' target="_blank" ';
         *  otherwise $params['payment_form_target'] = '';
         */     
        
        ?><form action="https://www.mobile88.com/ePayment/entry.asp" <?php echo $params['payment_form_target']; ?> method="post" name="ePayment" ><?php 
        
            echo "<strong>" . $params['gateway_hint'] . ': ' . $params[ 'cost_in_gateway_hint' ] . "</strong><br />";

            ?><input type="hidden" name="MerchantCode"  value="<?php echo $payment_options['merchant_code']; ?>" /><?php 
            ?><input type="hidden" name="PaymentId" value="" /><?php                        // Payment Gateway get here default value - Payment ID is getted reffear to the Appendix 1 from ipay88 API 
            ?><input type="hidden" name="RefNo"  value="<?php echo $ref_no; ?>" /><?php 
            ?><input type="hidden" name="Amount"  value="<?php echo $summ; ?>" /><?php 
            ?><input type="hidden" name="Currency"  value="<?php echo $payment_options['curency']; ?>" /><?php 
            ?><input type="hidden" name="ProdDesc"  value="<?php echo $payment_options[ 'subject' ]; ?>" /><?php 
            ?><input type="hidden" name="UserName"  value="<?php echo $firstlast_name; ?>" /><?php 
            ?><input type="hidden" name="UserEmail"  value="<?php echo $email; ?>" /><?php 
            ?><input type="hidden" name="UserContact"  value="<?php echo $phone; ?>" /><?php 
            ?><input type="hidden" name="Remark"  value="" /><?php 
            ?><input type="hidden" name="Lang"   value="UTF-8" /><?php 
            ?><input type="hidden" name="Signature"  value="<?php echo $signature; ?>" /><?php 
            ?><input type="hidden" name="ResponseURL" value="<?php echo $ipay88_order_Successful; ?>" /><?php 
            ?><input type="hidden" name="BackendURL" value="<?php echo $ipay88_BackendURL; ?>" /><?php                                      //Fix: 5.3  New.
            ?><input class="btn" type="submit" name="Submit" value="<?php echo $payment_options[ 'payment_button_title' ]; ?>" /><?php 
        
        ?></form></div><?php 
        
        $payment_form = ob_get_clean();
        
        // Auto redirect to the iPay88 website, after visitor clicked on "Send" button.  We do not need to return this Script, instead of that just write it here
        /*
        ?><script type='text/javascript'> 
            setTimeout(function() { 
               jQuery("#gateway_payment_forms<?php echo $params['resource_id']; ?> .ipay88_div.wpbc-payment-form form").submit(); 
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
        // Merchant Code
        $this->fields['merchant_code'] = array(   
                                      'type'        => 'text'
                                    , 'default'     => ''
                                    //, 'placeholder' => ''
                                    , 'title'       => __('Merchant Code', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . __('Enter your iPay88 Merchant Code.' ,'booking')
                                                       . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                    , 'description_tag' => 'span'
                                    , 'css'         => ''//'width:100%'
                                    , 'group'       => 'general'
                                    , 'tr_class'    => 'wpbc_sub_settings_grayed'
                                    //, 'validate_as' => array( 'required' )
                            );
        // Merchant Key
        $this->fields['merchant_key'] = array(   
                                      'type'        => 'text'
                                    , 'default'     => ''
                                    //, 'placeholder' => ''
                                    , 'title'       => __('Merchant Key', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . __('Enter your iPay88 Merchant Key.' ,'booking')
                                                       . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                    , 'description_tag' => 'span'
                                    , 'css'         => ''//'width:100%'
                                    , 'group'       => 'general'
                                    , 'tr_class'    => 'wpbc_sub_settings_grayed'
                                    //, 'validate_as' => array( 'required' )
                            );
        // Currency        
        $currency_list = array(
                                  "MYR" => __('Malaysian Ringgit' ,'booking')
                                , "USD" => __('U.S. Dollars' ,'booking')
                                , "PHP" => __('Philippine Pesos' ,'booking')
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
        // Payment Button Title        
        $this->fields['payment_button_title'] = array(   
                                'type'          => 'text'
                                , 'default'     => __('Pay via' ,'booking') .' iPay88'
                                , 'placeholder' => __('Pay via' ,'booking') .' iPay88'
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
                                                        . sprintf( __('This field support only up to %s characters by payment system.' ,'booking'), '100' ) 
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
        
        //  Success URL
        $this->fields['return_url_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'     
                                , 'html'        => '<tr valign="top" class="wpbc_tr_ipay88_return_url">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'ipay88_return_url'
                                                                , array(   'title'=> __('Return URL after Successful order' ,'booking'), 'label_css' => '' ) )
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
                                , 'html'        => '<tr valign="top" class="wpbc_tr_ipay88_cancel_return_url">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'ipay88_cancel_return_url'
                                                                , array(   'title'=> __('Return URL after Failed order' ,'booking'), 'label_css' => '' ) )
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
    }

    
    // Support /////////////////////////////////////////////////////////////////    

    
    /** Return info about Gateway
     * 
     * @return array        Example: array(
                                            'id'      => 'ipay88
                                          , 'title'   => 'iPay88'
                                          , 'currency'   => 'USD'
                                          , 'enabled' => true
                                        );        
     */
    public function get_gateway_info() {

        $gateway_info = array(
                      'id'       => $this->get_id()
                    , 'title'    => 'iPay88'
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
                        'ok'        => array(  'ipay88:OK'  )
                        , 'pending' => array()
                        , 'unknown' => array()
                        , 'error'   => array( 'ipay88:Failed' )
                    ); 
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
        
        if ( $pay_system == WPBC_IPAY88_GATEWAY_ID ) { 
            
            if ( ( isset( $_REQUEST['Status'] ) ) && ($_REQUEST['Status'] == 1 ) ) {

                $MerchantCode = $_REQUEST['MerchantCode'];
                $RefNo  = $_REQUEST['RefNo'];                
                $Amount = $_REQUEST['Amount'];                                  // amount with two decimals and thousand symbols. Example: 1,278.99 :: Check  iPay88 Technical Spec v.1.6.1 on page #9
                $status = '';

                // Check the REFERER site
                if ( $status == '' )
                    if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
                        $pos1 = strpos( $_SERVER['HTTP_REFERER'], 'https://www.mobile88.com' );
                        $pos2 = strpos( $_SERVER['HTTP_REFERER'], 'http://www.mobile88.com/' );

                        if ( ( $pos1 === false) && ($pos2 === false) ) {
                            debuge( 'Respond not from correct payment site !' );
                            $status = 'ipay88:Failed';
                        }
                    }
                // Requery
                if ( $status == '' ) {
                    $result = iPay88_Requery( $MerchantCode, $RefNo, $Amount );
                    if ( $result === '00' ) {
                        $iPayStatusMessage = __( 'Successful payment', 'booking' );
                    } else {
                        if ( $result == 'Invalid parameters' )
                            $iPayStatusMessage = __( ' Parameters are incorrect,', 'booking' );
                        else if ( $result == 'Record not found' )
                            $iPayStatusMessage = __( 'Cannot find the record', 'booking' );
                        else if ( $result == 'Incorrect amount' )
                            $iPayStatusMessage = __( 'Amount different', 'booking' );
                        else if ( ($result == 'Payment fail') || ($result == 'Payment failed') )
                            $iPayStatusMessage = __( 'Payment failed', 'booking' );
                        else if ( $result == 'M88Admin' )
                            $iPayStatusMessage = __( 'Payment status updated by Mobile88 Admin(Fail)', 'booking' );
                        else if ( $result == 'Connection Error' )
                            $iPayStatusMessage = __( 'Connection Error', 'booking' );

                        $status = 'ipay88:Failed';
                        
                        debuge( $_REQUEST['ErrDesc'], $iPayStatusMessage );
                    }
                }
                
                // Check signature
                if ( $status == '' ) {

                    $summ_sing = str_replace( '.', '', $Amount );               /* $slct_sql_results[0]->cost */ 
                    $summ_sing = str_replace( ',', '', $summ_sing );
                    $ipay88_merchant_code   = get_bk_option( 'booking_ipay88_merchant_code' );
                    $ipay88_merchant_key    = get_bk_option( 'booking_ipay88_merchant_key' );
                    // $signature = $ipay88_merchant_key . $ipay88_merchant_code . $_REQUEST['RefNo'] . $summ_sing .  $_REQUEST['Currency'] ;
                    $signature = $ipay88_merchant_key . $ipay88_merchant_code . $_REQUEST['PaymentId'] . $_REQUEST['RefNo'] . $summ_sing . $_REQUEST['Currency'] . $_REQUEST['Status'];

                    $signature = iPay88_signature( $signature );

                    if ( $_REQUEST["Signature"] != $signature ) {
                        debuge( 'Signature is different from original !' );
                        $status = 'ipay88:Failed';
                    }
                }

                if ( $status == '' )
                    $status = 'ipay88:OK';
                
            } else {
                
                $status = 'ipay88:Failed';
                
                if ( isset( $_REQUEST['ErrDesc'] ) )
                    debuge( $_REQUEST['ErrDesc'] );
                                                                                /** Parameters in Respond
                                                                                    [payed_booking] => 44
                                                                                    [wp_nonce] => 30068
                                                                                    [pay_sys] => ipay88
                                                                                    [stats] => OK
                                                                                    [MerchantCode] => 1111111
                                                                                    [PaymentId] => 0
                                                                                    [RefNo] => A044
                                                                                    [Amount] => 240
                                                                                    [Currency] => PHP
                                                                                    [Remark] =>
                                                                                    [TransId] => T0203282500
                                                                                    [AuthCode] =>
                                                                                    [Status] => 0
                                                                                    [ErrDesc] => Invalid parameters(Currency Not Supported By Merchant Account)
                                                                                    [Signature] =>
                                                                                */
            }

            return $status;
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
        
        if ( $pay_system == WPBC_IPAY88_GATEWAY_ID ) {

            /** We can  auto approve or decline the booking based on respond at backend POST Feature
             * Here we just  open Success or Failed URL
             */
            // $auto_approve = get_bk_option( 'booking_ipay88_is_auto_approve_cancell_booking' );  // Fix: 5.3

            $payment_status_OK = $this->get_payment_status_array();
            
            $payment_status_OK = $payment_status_OK['ok'];
            
            if ( in_array( $status,  $payment_status_OK ) ) {
                // if ( $auto_approve == 'On' ) wpbc_auto_approve_booking( $booking_id );         // Fix: 5.3
                wpbc_redirect( get_bk_option( 'booking_ipay88_return_url' ) );
            } else {
                // if ( $auto_approve == 'On' ) wpbc_auto_cancel_booking( $booking_id );          // Fix: 5.3
                wpbc_redirect( get_bk_option( 'booking_ipay88_cancel_return_url' ) );
            }
        }
        
    }

}

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Settings  Page " >

/** Settings  Page  */
class WPBC_Settings_Page_Gateway_IPAY88 extends WPBC_Page_Structure {
     
    public $gateway_api = false;
    
    /** Define interface for  Gateway  API
     * 
     * @param string $selected_email_name - name of Email template
     * @param array $init_fields_values - array of init form  fields data - this array  can  ovveride "default" fields and loaded data.
     * @return object Email API
     */
    public function get_api( $init_fields_values = array() ){
        
        if ( $this->gateway_api === false ) {
            $this->gateway_api = new WPBC_Gateway_API_IPAY88( WPBC_IPAY88_GATEWAY_ID , $init_fields_values );    
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
        $is_data_exist = get_bk_option( 'booking_'. WPBC_IPAY88_GATEWAY_ID .'_is_active' );
        if (  ( ! empty( $is_data_exist ) ) && ( $is_data_exist == 'On' )  )
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-check"></i> &nbsp; ';
        else 
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-unchecked"></i> &nbsp; ';
        
        
        $subtabs[ WPBC_IPAY88_GATEWAY_ID ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' =>  $icon .  'iPay88'                     // Title of TAB    
                            , 'page_title' => sprintf( __('%s Settings', 'booking'), 'iPay88' )  // Title of Page   
                            , 'hint' => __('Integration of iPay88 payment system' ,'booking')   // Hint    
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
        do_action( 'wpbc_hook_settings_page_header', 'gateway_settings_' . WPBC_IPAY88_GATEWAY_ID );
        
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
        
        $submit_form_name = 'wpbc_gateway_' . WPBC_IPAY88_GATEWAY_ID;               // Define form name
        
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
                    <div class="wpbc-settings-notice notice-warning" style="text-align:left;">
                        <strong><?php _e('Important!' ,'booking'); ?></strong> <?php 
                                printf( __('Please configure all fields inside the %sBilling form fields%s section at %sPayments General%s tab.' ,'booking')
                                        , '<strong>', '</strong>', '<strong>', '</strong>' );
                                // Basically  need to  configure only  these fields:
                                // Customer Email, First Name(s), Last name, Phone
                        ?>
                    </div>
                    <div class="clear" style="height:10px;"></div>
                    
                <div class="clear"></div>  
                <div class="metabox-holder">

                    <div class="wpbc_settings_row wpbc_settings_row_left_NO" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'general', sprintf( __('%s Settings', 'booking'), 'iPay88' )   );                            
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
        
        $validated_fields = apply_filters( 'wpbc_gateway_ipay88_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.
        
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
        
        /*
        $js_script = '';
        
        //Show|Hide grayed section   
        $js_script .= " 
                        if ( ! jQuery('#ipay88_ipn_is_send_error_email').is(':checked') ) {   
                            jQuery('.wpbc_tr_ipay88_ipn_error_email').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#ipay88_ipn_is_send_error_email').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_ipay88_ipn_error_email').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_ipay88_ipn_error_email').addClass('hidden_items');
                                }
                            } ); ";        
        
        
        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );  
        */
    }
    
    // </editor-fold>    
}
add_action('wpbc_menu_created',  array( new WPBC_Settings_Page_Gateway_IPAY88() , '__construct') );    // Executed after creation of Menu


/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Check "Return URLs" and "IPAY88 Email"m, etc...
 * 
 * @param array $validated_fields
 */
function wpbc_gateway_ipay88_validate_fields_before_saving__all( $validated_fields ) {
                                                    
    $validated_fields['return_url']         = wpbc_make_link_relative( $validated_fields['return_url'] );
    $validated_fields['cancel_return_url']  = wpbc_make_link_relative( $validated_fields['cancel_return_url'] );
    
    if ( wpbc_is_this_demo() ) {
        
        $validated_fields['merchant_code'] = '';
        $validated_fields['merchant_key']  = '';
    } 
    
    return $validated_fields;
}
add_filter( 'wpbc_gateway_ipay88_validate_fields_before_saving', 'wpbc_gateway_ipay88_validate_fields_before_saving__all', 10, 1 );   // Hook for validated fields.

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Activate | Deactivate " >    

////////////////////////////////////////////////////////////////////////////////
// Activate | Deactivate
////////////////////////////////////////////////////////////////////////////////

/** A c t i v a t e */
function wpbc_booking_activate_IPAY88() {
    
    $op_prefix = 'booking_' . WPBC_IPAY88_GATEWAY_ID . '_';

    add_bk_option( $op_prefix . 'is_active', 'Off' );
    add_bk_option( $op_prefix . 'subject', sprintf( __('Payment for booking %s on these day(s): %s'  ,'booking'), '[resource_title]','[dates]') );
    add_bk_option( $op_prefix . 'return_url', '/successful' );
    add_bk_option( $op_prefix . 'cancel_return_url', '/failed' );    
    add_bk_option( $op_prefix . 'payment_button_title' , __('Pay via' ,'booking') .' iPay88' );
    add_bk_option( $op_prefix . 'merchant_code', '' );
    add_bk_option( $op_prefix . 'merchant_key', '' );
    add_bk_option( $op_prefix . 'curency', 'USD' );
    //add_bk_option( $op_prefix . 'is_description_show', 'Off' );
    add_bk_option( $op_prefix . 'is_auto_approve_cancell_booking' , 'Off' );    
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_IPAY88'   );
                

/** D e a c t i v a t e */
function wpbc_booking_deactivate_IPAY88() {
    
    $op_prefix = 'booking_' . WPBC_IPAY88_GATEWAY_ID . '_';
    
    delete_bk_option( $op_prefix . 'is_active' );
    delete_bk_option( $op_prefix . 'subject' );
    delete_bk_option( $op_prefix . 'return_url' );
    delete_bk_option( $op_prefix . 'cancel_return_url' );
    delete_bk_option( $op_prefix . 'payment_button_title' );
    delete_bk_option( $op_prefix . 'merchant_code' );
    delete_bk_option( $op_prefix . 'merchant_key' );
    delete_bk_option( $op_prefix . 'curency' );
    delete_bk_option( $op_prefix . 'is_description_show' );
    delete_bk_option( $op_prefix . 'is_auto_approve_cancell_booking' );
    
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_IPAY88' );

//                                                                              </editor-fold>


// Hook for getting gateway payment form to  show it after  booking process,  or for "payment request" after  clicking on link in email.
// Note,  here we generate new Object for correctly getting payment fields data of specific WP User  in WPBC MU version. 
add_filter( 'wpbc_get_gateway_payment_form', array( new WPBC_Gateway_API_IPAY88( WPBC_IPAY88_GATEWAY_ID ), 'get_payment_form' ), 10, 3 );


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" iPay88    S u p p o r t   F u n c t i o n s " >    
        
function iPay88_signature( $source ) {
    return base64_encode( iPay88_hex2bin( sha1( $source ) ) );
}


function iPay88_hex2bin( $hexSource ) {
    $bin = '';
    for ( $i = 0; $i < strlen( $hexSource ); $i = $i + 2 ) {
        $bin .= chr( hexdec( substr( $hexSource, $i, 2 ) ) );
    }
    return $bin;
}


function iPay88_Requery( $MerchantCode, $RefNo, $Amount ) {

    //$query="http://www.mobile88.com/epayment/enquiry.asp?MerchantCode=" . $MerchantCode . "&RefNo=" . $RefNo . "&Amount=" . $Amount;      // FixIn: 5.3    
    $query = "https://www.mobile88.com/epayment/enquiry.asp?MerchantCode=" . $MerchantCode . "&RefNo=" . str_replace( " ", "%20", $RefNo ) . "&Amount=" . $Amount;

    $url = parse_url( $query );
    $host = $url["host"];
    $path = $url["path"] . "?" . $url["query"];
    $timeout = 1;
    $fp = fsockopen( $host, 80, $errno, $errstr, $timeout );
    if ( $fp ) {
        fputs( $fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n" );
        while ( !feof( $fp ) ) {
            $buf .= fgets( $fp, 128 );
        }
        //$lines = split("\n", $buf);
        $lines = preg_split( "/\n/", $buf );                                    // FixIn: 5.3
        $Result = $lines[count( $lines ) - 1];
        fclose( $fp );
    } else {
        // enter error handing code here
        $Result = 'Connection Error';
    }
    return $Result;
}
//                                                                              </editor-fold>