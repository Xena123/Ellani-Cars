<?php
/**
 * @version 1.0
 * @package  Sage Pay
 * @category Payment Gateway for Booking Calendar 
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-07-26
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly
                                                                                
if ( ! defined( 'WPBC_SAGE_GATEWAY_ID' ) )        define( 'WPBC_SAGE_GATEWAY_ID', 'sage' );    


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Gateway API " >

/** API  for  Payment Gateway  */
class WPBC_Gateway_API_SAGE extends WPBC_Gateway_API  {                     
    

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
        $payment_options[ 'is_active' ]             = get_bk_option( 'booking_sage_is_active' );                // 'On' | 'Off'   
        $payment_options[ 'subject' ]               = get_bk_option( 'booking_sage_subject' );                  // 'Payment for booking %s on these day(s): %s'
            $payment_options[ 'subject' ] = apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'subject' ] );
            $payment_options[ 'subject' ] = wpbc_replace_booking_shortcodes( $payment_options[ 'subject' ], $params );
        $payment_options[ 'test' ]                  = get_bk_option( 'booking_sage_test' );                     // 'TEST'
        $payment_options[ 'order_successful' ]      = get_bk_option( 'booking_sage_order_successful' );         // '/successful'
        $payment_options[ 'order_failed' ]          = get_bk_option( 'booking_sage_order_failed' );             // '/failed'
        $payment_options[ 'payment_button_title' ]  = get_bk_option( 'booking_sage_payment_button_title' );     // 'Pay via Sage Pay'        
            $payment_options[ 'payment_button_title' ]  =  apply_bk_filter('wpdev_check_for_active_language', $payment_options[ 'payment_button_title' ] );
        $payment_options[ 'vendor_name' ]           = get_bk_option( 'booking_sage_vendor_name' );              // 'wpdevelop'
        $payment_options[ 'encryption_password' ]   = get_bk_option( 'booking_sage_encryption_password' );      // 'FfCDQjLiM524VtE7'        
        $payment_options[ 'curency' ]               = get_bk_option( 'booking_sage_curency' );                  // 'EUR'    
        $payment_options[ 'transaction_type' ]      = get_bk_option( 'booking_sage_transaction_type' );         // 'PAYMENT'    
        $payment_options[ 'is_auto_approve_cancell_booking' ] = get_bk_option( 'booking_sage_is_auto_approve_cancell_booking' );      // 'On' | 'Off'   

        
        ////////////////////////////////////////////////////////////////////////
        // Check about not correct configuration  of settings: 
        ////////////////////////////////////////////////////////////////////////
        if ( empty( $payment_options[ 'test' ] ) )                  return 'Wrong configuration in gateway settings.' . '<em>Empty: "Payment Mode" option</em>';
        if ( empty( $payment_options[ 'vendor_name' ] ) )           return 'Wrong configuration in gateway settings.' . '<em>Empty: "Vendor Name" option</em>';
        if ( empty( $payment_options[ 'encryption_password' ] ) )   return 'Wrong configuration in gateway settings.' . '<em>Empty: "XOR Encryption password" option</em>';
        if ( empty( $payment_options[ 'curency' ] ) )               return 'Wrong configuration in gateway settings.' . '<em>Empty: "Currency" option</em>';
        if ( empty( $payment_options[ 'transaction_type' ] ) )      return 'Wrong configuration in gateway settings.' . '<em>Empty: "Transaction type" option</em>';
        
        
        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_customer_email' ) ); 
        if ( isset( $params[ $billing_field_name ] ) === false ) 
            return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Email" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        else 
            $sage_billing_customer_email = $params[ $billing_field_name ];

        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_firstnames' ) ); 
        if ( isset( $params[ $billing_field_name ] ) === false ) 
            return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "First Name" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        else 
            $sage_billing_firstnames = $params[ $billing_field_name ];

        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_surname' ) ); 
        if ( isset( $params[ $billing_field_name ] ) === false ) 
            return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Last name" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        else 
            $sage_billing_surname = $params[ $billing_field_name ];

        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_address1' ) ); 
        if ( isset( $params[ $billing_field_name ] ) === false ) 
            return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Billing Address" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        else 
            $sage_billing_address1 = $params[ $billing_field_name ];

        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_city' ) ); 
        if ( isset( $params[ $billing_field_name ] ) === false ) 
            return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Billing City" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        else 
            $sage_billing_city = $params[ $billing_field_name ];

        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_country' ) ); 
        if ( isset( $params[ $billing_field_name ] ) === false ) 
            return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Country" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        else 
            $sage_billing_country = $params[ $billing_field_name ];

        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_post_code' ) ); 
        if ( isset( $params[ $billing_field_name ] ) === false ) 
            return 'Wrong configuration in gateway settings.' . '<em>Have not assigned: "Post Code" option in "Billing form fields" section at Settings &gt; Payments &gt; General page</em>';
        else 
            $sage_billing_post_code = $params[ $billing_field_name ];

        $billing_field_name = (string) trim( get_bk_option( 'booking_billing_post_code' ) );
        if ( ( $sage_billing_country == 'US') &&  ( ! empty( $params[ $billing_field_name ] ) ) )
            $sage_billing_state = $params[ $billing_field_name ];
        else
            $sage_billing_state = '';
        
        
        ////////////////////////////////////////////////////////////////////////
        // Prepare Parameters for payment form
        ////////////////////////////////////////////////////////////////////////
        $sage_order_successful  =  WPBC_PLUGIN_URL . '/inc/gateways/wpbc-response.php?payed_booking=' . $params[ 'booking_id' ] .'&wp_nonce=' . $params[ '__nonce' ] . '&pay_sys=sage&stats=OK' ;        //get_bk_option( 'booking_sage_order_successful' );
        $sage_order_failed      =  WPBC_PLUGIN_URL . '/inc/gateways/wpbc-response.php?payed_booking=' . $params[ 'booking_id' ] .'&wp_nonce=' . $params[ '__nonce' ] . '&pay_sys=sage&stats=FAILED' ;    //get_bk_option( 'booking_sage_order_failed' );
        
        $strConnectTo    = $payment_options[ 'test' ];                          //Set to SIMULATOR for the Simulator expert system, TEST for the Test Server and LIVE in the live environment                
        $strYourSiteFQDN = site_url() . '/';                                    // "http://server.com/";  // IMPORTANT.  Set the strYourSiteFQDN value to the Fully Qualified Domain Name of your server. **** This should start http:// or https:// and should be the name by which our servers can call back to yours **** i.e. it MUST be resolvable externally, and have access granted to the Sage Pay servers **** examples would be https://www.mysite.com or http://212.111.32.22/ **** NOTE: You should leave the final / in place.
        $strVendorName   = $payment_options[ 'vendor_name' ];                   // Set this value to the Vendor Name assigned to you by Sage Pay or chosen when you applied **/
        $strEncryptionPassword = $payment_options[ 'encryption_password' ];     // Set this value to the XOR Encryption password assigned to you by Sage Pay **/
        $strCurrency     = $payment_options[ 'curency' ];                       // Set this to indicate the currency in which you wish to trade. You will need a merchant number in this currency **/
        $strTransactionType = $payment_options[ 'transaction_type' ];           // This can be DEFERRED or AUTHENTICATED if your Sage Pay account supports those payment types **/
        $strPartnerID    = '';                                                  // Optional setting. If you are a Sage Pay Partner and wish to flag the transactions with your unique partner id set it here. **/
        $bSendEMail      = 0;                                                   // Optional setting. ** 0 = Do not send either customer or vendor e-mails, ** 1 = Send customer and vendor e-mails if address(es) are provided(DEFAULT). ** 2 = Send Vendor Email but not Customer Email. If you do not supply this field, 1 is assumed and e-mails are sent if addresses are provided.
        $strVendorEMail  = '';                                                  // Optional setting. Set this to the mail address which will receive order confirmations and failures
        
        $strProtocol     = '3.00';                                              //FixIn: 5.4.2

        //FixIn: 5.4.2 - Protocol 3.00 does not support simulator - $strPurchaseURL="https://test.sagepay.com/simulator/vspformgateway.asp";
        if ( $strConnectTo=="LIVE" )      $strPurchaseURL="https://live.sagepay.com/gateway/service/vspform-register.vsp";          // 'LIVE'
        else                              $strPurchaseURL="https://test.sagepay.com/gateway/service/vspform-register.vsp";          // 'TEST'
                                                                    

        $strCustomerEMail      = $sage_billing_customer_email;
        $strBillingFirstnames  = $sage_billing_firstnames;
        $strBillingSurname     = $sage_billing_surname;
        $strBillingAddress1    = $sage_billing_address1;
        $strBillingAddress2    = '';
        $strBillingCity        = $sage_billing_city;
        $strBillingPostCode    = $sage_billing_post_code;
        $strBillingCountry     = $sage_billing_country;
        $strBillingState       = $sage_billing_state;        
        $strBillingPhone       = '';

        $bIsDeliverySame       = true;                                          //$_SESSION["bIsDeliverySame"];
        if ( $bIsDeliverySame == true ) {
            $strDeliveryFirstnames = $strBillingFirstnames;
            $strDeliverySurname    = $strBillingSurname;
            $strDeliveryAddress1   = $strBillingAddress1;
            $strDeliveryAddress2   = $strBillingAddress2;
            $strDeliveryCity       = $strBillingCity;
            $strDeliveryPostCode   = $strBillingPostCode;
            $strDeliveryCountry    = $strBillingCountry;
            $strDeliveryState      = $strBillingState;
            $strDeliveryPhone      = $strBillingPhone;
        } else {
            $strDeliveryFirstnames = '';                                        //$_SESSION["strDeliveryFirstnames"];
            $strDeliverySurname    = '';                                        //$_SESSION["strDeliverySurname"];
            $strDeliveryAddress1   = '';                                        //$_SESSION["strDeliveryAddress1"];
            $strDeliveryAddress2   = '';                                        //$_SESSION["strDeliveryAddress2"];
            $strDeliveryCity       = '';                                        //$_SESSION["strDeliveryCity"];
            $strDeliveryPostCode   = '';                                        //$_SESSION["strDeliveryPostCode"];
            $strDeliveryCountry    = '';                                        //$_SESSION["strDeliveryCountry"];
            $strDeliveryState      = '';                                        //$_SESSION["strDeliveryState"];
            $strDeliveryPhone      = '';                                        //$_SESSION["strDeliveryPhone"];
        }
    
        $intRandNum = rand(0,32000)*rand(0,32000);                              // Okay, build the crypt field for Form using the information in our session ** First we need to generate a unique VendorTxCode for this transaction **  We're using VendorName, time stamp and a random element.  You can use different methods if you wish *  but the VendorTxCode MUST be unique for each transaction you send to Server
        $strVendorTxCode=$strVendorName . $intRandNum;

        $subject_payment = str_replace( ':', '.' , $payment_options[ 'subject' ] );
    
        $summ = str_replace( ',', '.', $params['cost_in_gateway'] );
        
        $strBasket = '1:'.$subject_payment.':::::'.$summ;

        ////////////////////////////////////////////////////////////////////////
        
        $strPost="VendorTxCode=" . $strVendorTxCode;                            // Now to build the Form crypt field.  For more details see the Form Protocol 2.23 As generated above
        if (strlen($strPartnerID) > 0) 
            $strPost=$strPost . "&ReferrerID=" . $strPartnerID;                 // Optional: If you are a Sage Pay Partner and wish to flag the transactions with your unique partner id, it should be passed here
        $strPost=$strPost . "&Amount=" . number_format($summ,2);                // Formatted to 2 decimal places with leading digit
        
        $strPost=$strPost . "&Currency=" . $strCurrency;
        $strPost=$strPost . "&Description=" . substr($subject_payment,0,100);   // Up to 100 chars of free format description
        $strPost=$strPost . "&SuccessURL=" . $sage_order_successful;            // The SuccessURL is the page to which Form returns the customer if the transaction is successful. You can change this for each transaction, perhaps passing a session ID or state flag if you wish
        $strPost=$strPost . "&FailureURL=" . $sage_order_failed;                // The FailureURL is the page to which Form returns the customer if the transaction is unsuccessful You can change this for each transaction, perhaps passing a session ID or state flag if you wish
        $strPost=$strPost . "&CustomerName=" . $strBillingFirstnames . " " . $strBillingSurname;        // This is an Optional setting. Here we are just using the Billing names given.
        $strPost=$strPost . "&SendEMail=1";
                                                                                /** Email settings:
                                                                                * Flag 'SendEMail' is an Optional setting.
                                                                                * 0 = Do not send either customer or vendor e-mails,
                                                                                * 1 = Send customer and vendor e-mails if address(es) are provided(DEFAULT).
                                                                                * 2 = Send Vendor Email but not Customer Email. If you do not supply this field, 1 is assumed and e-mails are sent if addresses are provided. **
                                                                                */
        $strPost=$strPost . "&CustomerEMail=".$strCustomerEMail;
        
        ////////////////////////////////////////////////////////////////////////
        $email_data = get_bk_option( WPBC_EMAIL_NEW_ADMIN_PREFIX . WPBC_EMAIL_NEW_ADMIN_ID );
        if ( ! empty( $email_data ) ) {                                         // Email from 'New email "To"  admin template'
            $email_data = maybe_unserialize( $email_data );
            if ( isset( $email_data['to'] ) )
                $email_data = $email_data['to'];
            else 
                $email_data = '';
        }
        if ( empty( $email_data ) ) {                                           // Import old data
            $old_data = wpbc_import6_get_old_email_new_admin_data();
            if ( ! empty( $old_data ) )
            // Make transform - emails    
            $email_data   = wpbc_get_email_parts( $old_data['to'] );            
        }
        if ( empty( $email_data ) )                                             // From PayPal
            $email_data = get_bk_option( 'booking_paypal_emeil' );
        $strPost=$strPost . "&VendorEMail=".$email_data;
        ////////////////////////////////////////////////////////////////////////


        $strPost=$strPost . "&BillingFirstnames=" . $strBillingFirstnames;      // Billing Details:
        $strPost=$strPost . "&BillingSurname=" . $strBillingSurname;
        $strPost=$strPost . "&BillingAddress1=" . $strBillingAddress1;
        if ( strlen( $strBillingAddress2 ) > 0 ) $strPost=$strPost . "&BillingAddress2=" . $strBillingAddress2;
        $strPost=$strPost . "&BillingCity=" . $strBillingCity;
        $strPost=$strPost . "&BillingPostCode=" . $strBillingPostCode;
        $strPost=$strPost . "&BillingCountry=" . $strBillingCountry;
        if (strlen($strBillingState) > 0) $strPost=$strPost . "&BillingState=" . $strBillingState;
        if (strlen($strBillingPhone) > 0) $strPost=$strPost . "&BillingPhone=" . $strBillingPhone;

        $strPost=$strPost . "&DeliveryFirstnames=" . $strDeliveryFirstnames;    // Delivery Details:
        $strPost=$strPost . "&DeliverySurname=" . $strDeliverySurname;
        $strPost=$strPost . "&DeliveryAddress1=" . $strDeliveryAddress1;
        if (strlen($strDeliveryAddress2) > 0) $strPost=$strPost . "&DeliveryAddress2=" . $strDeliveryAddress2;
        $strPost=$strPost . "&DeliveryCity=" . $strDeliveryCity;
        $strPost=$strPost . "&DeliveryPostCode=" . $strDeliveryPostCode;
        $strPost=$strPost . "&DeliveryCountry=" . $strDeliveryCountry;
        if (strlen($strDeliveryState) > 0) $strPost=$strPost . "&DeliveryState=" . $strDeliveryState;
        if (strlen($strDeliveryPhone) > 0) $strPost=$strPost . "&DeliveryPhone=" . $strDeliveryPhone;


        $strPost=$strPost . "&Basket=" . $strBasket;                            // As created above
        $strPost=$strPost . "&AllowGiftAid=0";                                  // For charities registered for Gift Aid, set to 1 to display the Gift Aid check box on the payment pages
        if ($strTransactionType!=="AUTHENTICATE") 
            $strPost=$strPost . "&ApplyAVSCV2=0";                               // Allow fine control over AVS/CV2 checks and rules by changing this value. 0 is Default. It can be changed dynamically, per transaction, if you wish.  See the Server Protocol document
        $strPost=$strPost . "&Apply3DSecure=0";                                 // Allow fine control over 3D-Secure checks and rules by changing this value. 0 is Default. It can be changed dynamically, per transaction, if you wish.  See the Form Protocol document

// Uncomment this for debuging - show line for "Crypting" in payemnt form.        
//return $strPost;

        $strCrypt = WPBC_SagepayUtil::encryptAes( $strPost,$strEncryptionPassword );            //FixIn: 5.4.2     

           
        ////////////////////////////////////////////////////////////////////////
        // Payment Form 
        ////////////////////////////////////////////////////////////////////////
        ob_start();
        
        ?><div style="width:100%;clear:both;margin-top:20px;"></div><?php 
        ?><div class="sage_div wpbc-payment-form" style="text-align:left;clear:both;"><?php 

        /** We need to open payment form in separate window, if this booking was made togather with other 
         *  in booking form  was used several  calendars from  different booking resources. 
         *  So we are having several  payment forms for each  booked resource. 
         *  System transfer this parameter $params['payment_form_target'] = ' target="_blank" ';
         *  otherwise $params['payment_form_target'] = '';
         */     
        
        ?><form action="<?php echo $strPurchaseURL; ?>" <?php echo $params['payment_form_target']; ?> method="POST" id="SagePayForm" name="SagePayForm" style="text-align:left;" class="booking_SagePayForm"><?php 
        
        ?><input type="hidden" name="navigate" value="" /><?php
        ?><input type="hidden" name="VPSProtocol" value="<?php echo $strProtocol; ?>" /><?php
        ?><input type="hidden" name="TxType" value="<?php echo $strTransactionType; ?>" /><?php
        ?><input type="hidden" name="Vendor" value="<?php echo $strVendorName; ?>" /><?php
        ?><input type="hidden" name="Crypt" value="<?php echo $strCrypt; ?>" /><?php

        
        echo "<strong>" . $params['gateway_hint'] . ': ' . $params[ 'cost_in_gateway_hint' ] . "</strong><br />";
        
        ?><input type="submit" name="submitsagebutton" value="<?php echo $payment_options[ 'payment_button_title' ]; ?>" class="btn" /><?php 
        
        ?><br/><span style="font-size:11px;"><?php printf( __( 'Pay using %s payment service' ,'booking'), '<a href="http://www.sagepay.com/" target="_blank">Sage Pay</a>' ); ?></span><?php 
        
        // $output .= '<a href=\"javascript:SagePayForm.submit();\" title=\"Proceed to Form registration\"><img src=\"images/proceed.gif\" alt=\"Proceed to Form registration\" border=\"0\"></a>';
        
        ?></form></div><?php 
        
        $payment_form = ob_get_clean();
        
        // Auto redirect to the Sage website, after visitor clicked on "Send" button.  We do not need to return this Script, instead of that just write it here
        /*
        ?><script type='text/javascript'> 
            setTimeout(function() { 
               jQuery("#gateway_payment_forms<?php echo $params['resource_id']; ?> .sage_div.wpbc-payment-form form").submit(); 
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
        // Vendor Name
        $this->fields['vendor_name'] = array(   
                                      'type'        => 'text'
                                    , 'default'     => ''
                                    //, 'placeholder' => ''
                                    , 'title'       => __('Vendor Name', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . __('Set this value to the Vendor Name assigned to you by Sage Pay or chosen when you applied.' ,'booking')
                                                       . ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() : '' )
                                    , 'description_tag' => 'span'
                                    , 'css'         => ''//'width:100%'
                                    , 'group'       => 'general'
                                    , 'tr_class'    => 'wpbc_sub_settings_grayed'
                                    //, 'validate_as' => array( 'required' )
                            );
        // XOR Encryption Password
        $this->fields['encryption_password'] = array(   
                                      'type'        => 'text'
                                    , 'default'     => ''
                                    //, 'placeholder' => ''
                                    , 'title'       => __('XOR Encryption password', 'booking')
                                    , 'description' => __('Required', 'booking') . '.<br/>'
                                                       . __('Set this value to the XOR Encryption password assigned to you by Sage Pay' ,'booking')
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
                                    , 'default' => 'TEST'
                                    , 'title' => __('Chose payment mode' ,'booking')
                                    , 'description' => __('Select TEST for the Test Server and LIVE in the live environment' ,'booking')
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => array(   // 'SIMULATOR' => __('SIMULATOR', 'booking')  // Does not support in actual api
                                                            'TEST' => __('TEST', 'booking')  
                                                          , 'LIVE' => __('LIVE', 'booking')                                                              
                                                    )      
                                    , 'group' => 'general'
                            );
        // Transaction Type       
        $this->fields['transaction_type'] = array(   
                                    'type' => 'select'
                                    , 'default' => 'PAYMENT'
                                    , 'title' => __('Transaction type', 'booking')
                                    , 'description' => __('This can be DEFERRED or AUTHENTICATED if your Sage Pay account supports those payment types' ,'booking')
                                    , 'description_tag' => 'span'
                                    , 'css' => ''
                                    , 'options' => array(
                                                            'PAYMENT'       => __('PAYMENT', 'booking')  
                                                          , 'DEFERRED'      => __('DEFERRED', 'booking')                                                              
                                                          , 'AUTHENTICATE'  => __('AUTHENTICATE', 'booking')                                                              
                                                    )      
                                    , 'group' => 'general'
                            );
        // Currency        
        $currency_list = array(
                                  "GBP" => __('Pounds Sterling' ,'booking')
                                , "EUR" => __('Euros' ,'booking')
                                , "USD" => __('U.S. Dollars' ,'booking')
                                , "JPY" => __('Yen' ,'booking')
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
                                , "ILS" => __('Israeli Shekel' ,'booking')
                                , "MXN" => __('Mexican Peso' ,'booking')
                                , "BRL" => __('Brazilian Real (only for Brazilian users)' ,'booking')
                                , "MYR" => __('Malaysian Ringgits (only for Malaysian users)' ,'booking')
                                , "PHP" => __('Philippine Pesos' ,'booking')
                                , "TWD" => __('Taiwan New Dollars' ,'booking')
                                , "THB" => __('Thai Baht' ,'booking')
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
                                , 'default'     => __('Pay via' ,'booking') .' Sage Pay'
                                , 'placeholder' => __('Pay via' ,'booking') .' Sage Pay'
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
        $this->fields['order_successful_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'     
                                , 'html'        => '<tr valign="top" class="wpbc_tr_sage_order_successful">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'sage_order_successful'
                                                                , array(   'title'=> __('Return URL after Successful order' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>' . '<code style="font-size:14px;">' .  get_option('siteurl') . '</code>'
                        );                
        $this->fields['order_successful'] = array(   
                                'type'          => 'text'
                                , 'default'     => '/successful'
                                , 'placeholder' => '/successful'
                                , 'css'         => 'width:75%'
                                , 'group'       => 'auto_approve_cancel'
                                , 'only_field'  => true           
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
                        );        

        //  Failed URL
        $this->fields['order_failed_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'auto_approve_cancel'     
                                , 'html'        => '<tr valign="top" class="wpbc_tr_sage_order_failed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'sage_order_failed'
                                                                , array(   'title'=> __('Return URL after Failed order' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>' . '<code style="font-size:14px;">' .  get_option('siteurl') . '</code>'
                        );                
        $this->fields['order_failed'] = array(   
                                'type'          => 'text'
                                , 'default'     => '/failed'
                                , 'placeholder' => '/failed'
                                , 'css'         => 'width:75%'
                                , 'group'       => 'auto_approve_cancel'
                                , 'only_field'  => true           
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
                                            'id'      => 'sage
                                          , 'title'   => 'Sage Standard'
                                          , 'currency'   => 'USD'
                                          , 'enabled' => true
                                        );        
     */
    public function get_gateway_info() {

        $gateway_info = array(
                      'id'       => $this->get_id()
                    , 'title'    => 'Sage Pay'
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
                        'ok'        => array(  'Sage:OK'  )
                        , 'pending' => array()
                        , 'unknown' => array()
                        , 'error'   => array( 'Sage:Failed'
                                            , 'Sage:REJECTED' 
                                            , 'Sage:NOTAUTHED'
                                            , 'Sage:MALFORMED'
                                            , 'Sage:INVALID'
                                            , 'Sage:ABORT'
                                            , 'Sage:ERROR'
                                            )
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
        
        if ( $pay_system == WPBC_SAGE_GATEWAY_ID ) { 
            
            if  ( isset( $_REQUEST["crypt"] ) )   {
            
                $strCrypt = $_REQUEST["crypt"];
                $strEncryptionPassword =  get_bk_option( 'booking_sage_encryption_password' );
                
                                                                                //FixIn: 5.4.2
                $strDecoded = WPBC_SagepayUtil::decryptAes( $strCrypt, $strEncryptionPassword );                
                $values = WPBC_SagepayUtil::queryStringToArray( $strDecoded );
                if ( !$strDecoded || empty($values) ) {
                    throw new WPBC_SagepayApiException( 'Invalid crypt input' );
                }
                
                $status = 'Sage:' . $values['Status'];
                
            } else {
                $status = 'Sage:Failed';
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

        if ( $pay_system == WPBC_SAGE_GATEWAY_ID ) {

            $auto_approve = get_bk_option( 'booking_sage_is_auto_approve_cancell_booking' );

            $payment_status_OK = $this->get_payment_status_array();
            
            $payment_status_OK = $payment_status_OK['ok'];
            
            if ( in_array( $status,  $payment_status_OK ) ) {
                if ( $auto_approve == 'On' )
                    wpbc_auto_approve_booking( $booking_id );
                wpbc_redirect( get_bk_option( 'booking_sage_order_successful' ) );
            } else {
                if ( $auto_approve == 'On' )
                    wpbc_auto_cancel_booking( $booking_id );
                wpbc_redirect( get_bk_option( 'booking_sage_order_failed' ) );
            }
        }
        
    }

}

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Settings  Page " >

/** Settings  Page  */
class WPBC_Settings_Page_Gateway_SAGE extends WPBC_Page_Structure {

    public $gateway_api = false;
    
    /** Define interface for  Gateway  API
     * 
     * @param string $selected_email_name - name of Email template
     * @param array $init_fields_values - array of init form  fields data - this array  can  ovveride "default" fields and loaded data.
     * @return object Email API
     */
    public function get_api( $init_fields_values = array() ){
        
        if ( $this->gateway_api === false ) {
            $this->gateway_api = new WPBC_Gateway_API_SAGE( WPBC_SAGE_GATEWAY_ID , $init_fields_values );    
        }
        
        return $this->gateway_api;
    }
    
    
    /** Check Compatibility with  data of previos versions */
    private function check_compatibility_with_older_7_ver() {
        
        $field_value = get_bk_option( 'booking_sage_test' );
        
        if ( $field_value == 'SIMULATOR' ) {
            update_bk_option( 'booking_sage_test', 'TEST' );
        }
    }

    
    public function in_page() {                                                 // P a g e    t a g
        return 'wpbc-settings';
    }
    
    
    public function tabs() {                                                    // T a b s      A r r a y
        
        $tabs = array();
        
        $subtabs = array();

        // Checkbox Icon, for showing in toolbar panel does this payment system active 
        $is_data_exist = get_bk_option( 'booking_'. WPBC_SAGE_GATEWAY_ID .'_is_active' );
        if (  ( ! empty( $is_data_exist ) ) && ( $is_data_exist == 'On' )  )
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-check"></i> &nbsp; ';
        else 
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-unchecked"></i> &nbsp; ';
        
        
        $subtabs[ WPBC_SAGE_GATEWAY_ID ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' =>  $icon . __('Sage' ,'booking')       // Title of TAB    
                            , 'page_title' => sprintf( __('%s Settings', 'booking'), 'Sage' )  // Title of Page   
                            , 'hint' => __('Integration of Sage payment system' ,'booking')   // Hint    
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
        do_action( 'wpbc_hook_settings_page_header', 'gateway_settings_' . WPBC_SAGE_GATEWAY_ID );
        
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
        
        $submit_form_name = 'wpbc_gateway_' . WPBC_SAGE_GATEWAY_ID;               // Define form name
        
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
                                printf( __('If you have no account on this system, please visit %s to create one.' ,'booking')
                                        , '<a href="https://test.sagepay.com/mysagepay/login.msp"  target="_blank" style="text-decoration:none;">sagepay.com</a>');
                        ?>
                    </div>
                    <div class="clear" style="height:5px;"></div>
                    <div class="wpbc-settings-notice notice-warning" style="text-align:left;">
                        <strong><?php _e('Important!' ,'booking'); ?></strong> <?php 
                                printf( __('Please configure all fields inside the %sBilling form fields%s section at %sPayments General%s tab.' ,'booking')
                                        , '<strong>', '</strong>', '<strong>', '</strong>' );
                        ?>
                    </div>
                    <div class="clear" style="height:10px;"></div>
                    
                <div class="clear"></div>  
                <div class="metabox-holder">

                    <div class="wpbc_settings_row wpbc_settings_row_left_NO" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'general', sprintf( __('%s Settings', 'booking'), 'Sage' )  );
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
        
        $validated_fields = apply_filters( 'wpbc_gateway_sage_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.
        
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
                        if ( ! jQuery('#sage_ipn_is_send_error_email').is(':checked') ) {   
                            jQuery('.wpbc_tr_sage_ipn_error_email').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#sage_ipn_is_send_error_email').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_sage_ipn_error_email').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_sage_ipn_error_email').addClass('hidden_items');
                                }
                            } ); ";        
        
        
        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );  
        */
    }
    
    // </editor-fold>    
}
add_action('wpbc_menu_created',  array( new WPBC_Settings_Page_Gateway_SAGE() , '__construct') );    // Executed after creation of Menu



/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Check "Return URLs" and "SAGE Email"m, etc...
 * 
 * @param array $validated_fields
 */
function wpbc_gateway_sage_validate_fields_before_saving__all( $validated_fields ) {
                                                    
    $validated_fields['order_successful'] = wpbc_make_link_relative( $validated_fields['order_successful'] );
    $validated_fields['order_failed']     = wpbc_make_link_relative( $validated_fields['order_failed'] );
    
    if ( wpbc_is_this_demo() ) {
        $validated_fields['test']                = 'TEST';
        $validated_fields['vendor_name']         = '';                          // Previously for test purpose: 'wpdevelop'          //FixIn: 5.4.2
        $validated_fields['encryption_password'] = '';                          // Previously for test purpose: 'FfCDQjLiM524VtE7'   //FixIn: 5.4.2        
    } 
    
    /** Check  depsricted value and update it */ 
    if ( $validated_fields['test'] == 'SIMULATOR' ) {
        $validated_fields['test'] = 'TEST';
    }
    
    return $validated_fields;
}
add_filter( 'wpbc_gateway_sage_validate_fields_before_saving', 'wpbc_gateway_sage_validate_fields_before_saving__all', 10, 1 );   // Hook for validated fields.

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Activate | Deactivate " >    

////////////////////////////////////////////////////////////////////////////////
// Activate | Deactivate
////////////////////////////////////////////////////////////////////////////////

/** A c t i v a t e */
function wpbc_booking_activate_SAGE() {

    $op_prefix = 'booking_' . WPBC_SAGE_GATEWAY_ID . '_';

    add_bk_option( $op_prefix . 'is_active', 'Off' );
    add_bk_option( $op_prefix . 'subject', sprintf( __('Payment for booking %s on these day(s): %s'  ,'booking'), '[resource_title]','[dates]') );
    add_bk_option( $op_prefix . 'test', 'TEST' );                               //FixIn: 5.4.2   previous value:  'SIMULATOR' );
    add_bk_option( $op_prefix . 'order_successful', '/successful' );
    add_bk_option( $op_prefix . 'order_failed', '/failed' );
    add_bk_option( $op_prefix . 'payment_button_title' , __('Pay via' ,'booking') .' Sage Pay' );
    add_bk_option( $op_prefix . 'vendor_name', '' );                            //FixIn: 5.4.2   previous value in wpbc_is_this_demo() :  'wpdevelop' );
    add_bk_option( $op_prefix . 'encryption_password', '' );                    //FixIn: 5.4.2   previous value in wpbc_is_this_demo() :  'FfCDQjLiM524VtE7' );
    add_bk_option( $op_prefix . 'curency', 'USD' );                             // ''    
    add_bk_option( $op_prefix . 'transaction_type', 'PAYMENT' );                // ''       
    //add_bk_option( $op_prefix . 'is_description_show', 'Off' );
    add_bk_option( $op_prefix . 'is_auto_approve_cancell_booking' , 'Off' );    
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_SAGE'   );
                

/** D e a c t i v a t e */
function wpbc_booking_deactivate_SAGE() {
    
    $op_prefix = 'booking_' . WPBC_SAGE_GATEWAY_ID . '_';

    delete_bk_option( $op_prefix . 'is_active' );
    delete_bk_option( $op_prefix . 'subject' );
    delete_bk_option( $op_prefix . 'test' );
    delete_bk_option( $op_prefix . 'order_successful' );
    delete_bk_option( $op_prefix . 'order_failed' );
    delete_bk_option( $op_prefix . 'payment_button_title' );
    delete_bk_option( $op_prefix . 'vendor_name' );
    delete_bk_option( $op_prefix . 'encryption_password' );
    delete_bk_option( $op_prefix . 'curency' );
    delete_bk_option( $op_prefix . 'transaction_type' );        
    delete_bk_option( $op_prefix . 'is_description_show' );
    delete_bk_option( $op_prefix . 'is_auto_approve_cancell_booking' );
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_SAGE' );

//                                                                              </editor-fold>


// Hook for getting gateway payment form to  show it after  booking process,  or for "payment request" after  clicking on link in email.
// Note,  here we generate new Object for correctly getting payment fields data of specific WP User  in WPBC MU version. 
add_filter( 'wpbc_get_gateway_payment_form', array( new WPBC_Gateway_API_SAGE( WPBC_SAGE_GATEWAY_ID ), 'get_payment_form' ), 10, 3 );



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Sage Pay Support Classes " >    

    
define("WPBC_MASK_FOR_HIDDEN_FIELDS", "...");  


/** Common utilities shared by all Integration methods
 *
 * @category  Payment
 * @package   Sagepay

 * @copyright (c) 2013, Sage Pay Europe Ltd.
 */
class WPBC_SagepayUtil {

    /**
     * The associated array containing card types and values
     *
     * @return array Array of card codes.
     */
    static protected $cardNames = array(
        'visa' => 'Visa',
        'visaelectron' => 'Visa Electron',
        'mastercard' => 'Mastercard',
        'amex' => 'American Express',
        'delta' => 'Delta',
        'dc' => 'Diners Club',
        'jcb' => 'JCB',
        'laser' => 'Laser',
        'maestro' => 'Maestro',
    );

    /**
     * The card types that SagePay supports.
     *
     * @return array Array of card codes.
     */
    static public function cardTypes()
    {
        return array_keys(self::$cardNames);
    }

    /**
     * Populate the card names in to a usable array.
     *
     * @param array $availableCards Available card codes.
     *
     * @return array Array of card codes and names.
     */
    static public function availableCards(array $availableCards)
    {
        $cardArr = array();

        // Filter input card types
        foreach ($availableCards as $code)
        {
            $code = strtolower($code);
            if ((array_key_exists($code, self::$cardNames)))
            {
                $cardArr[$code] = self::$cardNames[$code];
            }
        }

        return $cardArr;
    }

    /**
     * PHP's mcrypt does not have built in PKCS5 Padding, so we use this.
     *
     * @param string $input The input string.
     *
     * @return string The string with padding.
     */
    static protected function addPKCS5Padding($input)
    {
        $blockSize = 16;
        $padd = "";

        // Pad input to an even block size boundary.
        $length = $blockSize - (strlen($input) % $blockSize);
        for ($i = 1; $i <= $length; $i++)
        {
            $padd .= chr($length);
        }

        return $input . $padd;
    }

    /**
     * Remove PKCS5 Padding from a string.
     *
     * @param string $input The decrypted string.
     *
     * @return string String without the padding.
     * @throws WPBC_SagepayApiException
     */
    static protected function removePKCS5Padding($input)
    {
        $blockSize = 16;
        $padChar = ord($input[strlen($input) - 1]);

        /* Check for PadChar is less then Block size */
        if ($padChar > $blockSize)
        {
            throw new WPBC_SagepayApiException('Invalid encryption string');
        }
        /* Check by padding by character mask */
        if (strspn($input, chr($padChar), strlen($input) - $padChar) != $padChar)
        {
            throw new WPBC_SagepayApiException('Invalid encryption string');
        }

        $unpadded = substr($input, 0, (-1) * $padChar);
        /* Chech result for printable characters */
        if (preg_match('/[[:^print:]]/', $unpadded))
        {
            throw new WPBC_SagepayApiException('Invalid encryption string');
        }
        return $unpadded;
    }

    /**
     * Encrypt a string ready to send to SagePay using encryption key.
     *
     * @param  string  $string  The unencrypyted string.
     * @param  string  $key     The encryption key.
     *
     * @return string The encrypted string.
     */
    static public function encryptAes($string, $key)
    {
        // AES encryption, CBC blocking with PKCS5 padding then HEX encoding.
        // Add PKCS5 padding to the text to be encypted.
        $string = self::addPKCS5Padding($string);

        // Perform encryption with PHP's MCRYPT module.
        $crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_CBC, $key);

        // Perform hex encoding and return.
        return "@" . strtoupper(bin2hex($crypt));
    }

    /**
     * Decode a returned string from SagePay.
     *
     * @param string $strIn         The encrypted String.
     * @param string $password      The encyption password used to encrypt the string.
     *
     * @return string The unecrypted string.
     * @throws WPBC_SagepayApiException
     */
    static public function decryptAes($strIn, $password)
    {
        // HEX decoding then AES decryption, CBC blocking with PKCS5 padding.
        // Use initialization vector (IV) set from $str_encryption_password.
        $strInitVector = $password;

        // Remove the first char which is @ to flag this is AES encrypted and HEX decoding.
        $hex = substr($strIn, 1);

        // Throw exception if string is malformed
        if (!preg_match('/^[0-9a-fA-F]+$/', $hex))
        {
            throw new WPBC_SagepayApiException('Invalid encryption string');
        }
        $strIn = pack('H*', $hex);

        // Perform decryption with PHP's MCRYPT module.
        $string = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $password, $strIn, MCRYPT_MODE_CBC, $strInitVector);
        return self::removePKCS5Padding($string);
    }

    /**
     * Convert a data array to a query string ready to post.
     *
     * @param  array   $data        The data array.
     * @param  string  $delimeter   Delimiter used in query string
     * @param  boolean $urlencoded  If true encode the final query string
     *
     * @return string The array as a string.
     */
    static public function arrayToQueryString(array $data, $delimiter = '&', $urlencoded = false)
    {
        $queryString = '';
        $delimiterLength = strlen($delimiter);

        // Parse each value pairs and concate to query string
        foreach ($data as $name => $value)
        {   
            // Apply urlencode if it is required
            if ($urlencoded)
            {
                $value = urlencode($value);
            }
            $queryString .= $name . '=' . $value . $delimiter;
        }

        // remove the last delimiter
        return substr($queryString, 0, -1 * $delimiterLength);
    }

    static public function arrayToQueryStringRemovingSensitiveData(array $data,array $nonSensitiveDataKey, $delimiter = '&', $urlencoded = false)
    {
        $queryString = '';
        $delimiterLength = strlen($delimiter);

        // Parse each value pairs and concate to query string
        foreach ($data as $name => $value)
        {
           if (!in_array($name, $nonSensitiveDataKey)){
                                $value=WPBC_MASK_FOR_HIDDEN_FIELDS;
                   }
                   else if ($urlencoded){
                                $value = urlencode($value);
                   }
                // Apply urlencode if it is required

           $queryString .= $name . '=' . $value . $delimiter;
        }

        // remove the last delimiter
        return substr($queryString, 0, -1 * $delimiterLength);
    }
    /**
     * Convert string to data array.
     *
     * @param string  $data       Query string
     * @param string  $delimeter  Delimiter used in query string
     *
     * @return array
     */
    static public function queryStringToArray($data, $delimeter = "&")
    {
        // Explode query by delimiter
        $pairs = explode($delimeter, $data);
        $queryArray = array();

        // Explode pairs by "="
        foreach ($pairs as $pair)
        {
            $keyValue = explode('=', $pair);

            // Use first value as key
            $key = array_shift($keyValue);

            // Implode others as value for $key
            $queryArray[$key] = implode('=', $keyValue);
        }
        return $queryArray;
    }

   static public function queryStringToArrayRemovingSensitiveData($data, $delimeter = "&", $nonSensitiveDataKey)
    {  
        // Explode query by delimiter
        $pairs = explode($delimeter, $data);
        $queryArray = array();

        // Explode pairs by "="
        foreach ($pairs as $pair)
        {
            $keyValue = explode('=', $pair);
            // Use first value as key
            $key = array_shift($keyValue);
            if (in_array($key, $nonSensitiveDataKey)){
                          $keyValue = explode('=', $pair);
                        }
                        else{
                          $keyValue = array(WPBC_MASK_FOR_HIDDEN_FIELDS);
                        }
                    // Implode others as value for $key
                        $queryArray[$key] = implode('=', $keyValue);

        }
        return $queryArray;
    }
    /**
     * Logging the debugging information to "debug.log"
     *
     * @param  string  $message
     * @return boolean
     */
    /*
    static public function log($message)
    {
        $settings = SagepaySettings::getInstance();
        if ($settings->getLogError())
        {
            $filename = SAGEPAY_SDK_PATH . '/debug.log';
            $line = '[' . date('Y-m-d H:i:s') . '] :: ' . $message;
            try
            {
                $file = fopen($filename, 'a+');
                fwrite($file, $line . PHP_EOL);
                fclose($file);
            } catch (Exception $ex)
            {
                return false;
            }
        }
        return true;
    }*/

    /**
     * Extract last 4 digits from card number;
     *
     * @param string $cardNr
     *
     * @return string
     */
    static public function getLast4Digits($cardNr)
    {
        // Apply RegExp to extract last 4 digits
        $matches = array();
        if (preg_match('/\d{4}$/', $cardNr, $matches))
        {
            return $matches[0];
        }
        return '';
    }

}


/** SagepayApi exceptions type
 *
 * @category  Payment
 * @package   Sagepay
 * @copyright (c) 2013, Sage Pay Europe Ltd.
 */
class WPBC_SagepayApiException extends Exception {

}

//                                                                              </editor-fold>