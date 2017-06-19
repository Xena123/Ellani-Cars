<?php
/**
 * @version 1.0
 * @package  Showing Bank Trasfer info.
 * @category Payment Gateway for Booking Calendar 
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-08-04
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly
                                                                                
if ( ! defined( 'WPBC_BANK_TRANSFER_GATEWAY_ID' ) )        define( 'WPBC_BANK_TRANSFER_GATEWAY_ID', 'bank_transfer' );    


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Gateway API " >

/** API  for  Payment Gateway  */
class WPBC_Gateway_API_BANK_TRANSFER extends WPBC_Gateway_API  {                     
    
    
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
        // Payment Options 
        //////////////////////////////////////////////////////////////////////// 
        
        // Accounts
        $bank_transfer_account_name_title   =  get_bk_option( 'booking_bank_transfer_account_name_title' );
        $bank_transfer_account_number_title =  get_bk_option( 'booking_bank_transfer_account_number_title' );
        $bank_transfer_bank_name_title      =  get_bk_option( 'booking_bank_transfer_bank_name_title' );
        $bank_transfer_sort_code_title      =  get_bk_option( 'booking_bank_transfer_sort_code_title' );
        $bank_transfer_iban_title           =  get_bk_option( 'booking_bank_transfer_iban_title' );
        $bank_transfer_bic_title            =  get_bk_option( 'booking_bank_transfer_bic_title' );        


        $booking_bank_transfer_accounts  = get_bk_option( 'booking_bank_transfer_accounts' );
        if ( is_serialized( $booking_bank_transfer_accounts ) )   
            $booking_bank_transfer_accounts = unserialize( $booking_bank_transfer_accounts );

        if ( empty( $booking_bank_transfer_accounts ) ) {
            $booking_bank_transfer_accounts = array( $bank_transfer_account_fields );   // Default values
        }
        list( $account_name, $account_number, $bank_name, $sort_code, $iban, $bic ) = array('','','','','','');
        $bank_transfer_accounts = 
            '<table class="wpbc_bank_transfer_accounts" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>' . esc_js( $bank_transfer_bank_name_title ) . '</th>
                    <th>' . esc_js( $bank_transfer_account_number_title ) . '</th>
                    <th>' . esc_js( $bank_transfer_sort_code_title ) . '</th>
                    <th>' . esc_js( $bank_transfer_iban_title ) . '</th>
                    <th>' . esc_js( $bank_transfer_bic_title ) . '</th>
                </tr>
            </thead>
            <tbody class="accounts">';
            $i = -1;
            if ( isset( $booking_bank_transfer_accounts ) ) {

                foreach ( $booking_bank_transfer_accounts as $account ) {                                            
                    $i++;

                    $bank_transfer_accounts .=  
                    '<tr class="account">
                            <td>' . esc_attr( wp_unslash( $account['bank_transfer_bank_name'] ) ) . '</td>
                            <td>' . esc_attr( $account['bank_transfer_account_number'] ) . '</td>
                            <td>' . esc_attr( $account['bank_transfer_sort_code'] ) . '</td>
                            <td>' . esc_attr( $account['bank_transfer_iban'] ) . '</td>
                            <td>' . esc_attr( $account['bank_transfer_bic'] ) . '</td>
                    </tr>';
                    if ( empty( $account_number ) )
                        list( $account_name, $account_number, $bank_name, $sort_code, $iban, $bic ) = array_values( $account );
                }
            }

        $bank_transfer_accounts .= '</tbody></table>';

        $bank_transfer_accounts = esc_js( $bank_transfer_accounts );  
        $bank_transfer_accounts = html_entity_decode( $bank_transfer_accounts );
        $bank_transfer_accounts = str_replace( "\\n", '', $bank_transfer_accounts );

        ////////////////////////////////////////////////////////////////////
        

        $bank_transfer_description = get_bk_option( 'booking_bank_transfer_description' );

        $bank_transfer_description = apply_bk_filter('wpdev_check_for_active_language', $bank_transfer_description );
//debuge($params);            
        // Add addtional parameters to  replace 
        $params[ 'account_details' ] = $bank_transfer_accounts;

        $params[ 'account_name' ]   = $account_name;
        $params[ 'account_number' ] = $account_number; 
        $params[ 'bank_name' ]      = $bank_name;
        $params[ 'sort_code' ]      = $sort_code; 
        $params[ 'iban' ]           = $iban;
        $params[ 'bic' ]            = $bic;

        $params[ 'cost' ]           = $params[ 'payment_cost_hint' ];
        
        $bank_transfer_description = wpbc_replace_booking_shortcodes( $bank_transfer_description, $params );
        $bank_transfer_description = str_replace( '"', '', $bank_transfer_description );


            
        
        ////////////////////////////////////////////////////////////////////////
        // Payment Form 
        ////////////////////////////////////////////////////////////////////////
        ob_start();
        
        ?><div style="width:100%;clear:both;margin-top:20px;"></div><?php 
        ?><div class="bank_transfer_div wpbc-payment-form" style="text-align:left;clear:both;"><?php 
        
            echo $bank_transfer_description;
        
        ?></div><?php 
        
        $payment_form = ob_get_clean();
        
        return $output . $payment_form; 
    }
    

    
    /** Define settings Fields  */
    public function init_settings_fields() {
        
        $this->fields = array();

        
        // On | Off        
        $this->fields['is_active'] = array(   
                                      'type'        => 'checkbox'
                                    , 'default'     => 'Off'            
                                    , 'title'       => __( 'Enable / Disable', 'booking' )
                                    , 'label'       => __( 'Enable this payment gateway', 'booking')   
                                    , 'description' => ''
                                    , 'group'       => 'general'

                                );
        
        // Description
        $this->fields['description'] = array(   
                                      'type'        => 'wp_textarea'
                                    , 'default'     => ''
                                    , 'placeholder' => ''
                                    , 'title'       => __('Description', 'booking')
                                    , 'description' => __( 'Payment method description that the customer will see on your payment page.' ,'booking')
                                    , 'description_tag' => ''
                                    , 'css'         => ''
                                    , 'group'       => 'general'
                                    , 'tr_class'    => ''
                                    , 'rows'        => 10
                                    , 'show_in_2_cols' => true            
                                    // Default options:    
                                    , 'teeny'             => true
                                    , 'show_visual_tabs'  => true
                                    , 'default_editor' => 'tinymce'                              // 'tinymce' | 'html'       // 'html' is used for the "Text" editor tab.
                                    , 'drag_drop_upload'  => false 
                            );
    }

    
    // Support /////////////////////////////////////////////////////////////////    


    /** Return info about Gateway
     * 
     * @return array        Example: array(
                                            'id'      => 'bank_transfer
                                          , 'title'   => 'Bank Transfer'
                                          , 'currency'   => 'USD'
                                          , 'enabled' => true
                                        );        
     */
    public function get_gateway_info() {

        $gateway_info = array(
                      'id'       => $this->get_id()
                    , 'title'    => __( 'Bank Transfer', 'booking' )
                    , 'currency' => ''                                          //Default currency  here  //get_bk_option(  'booking_' . $this->get_id() . '_' . 'curency' )
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
                        'ok'        => array()
                        , 'pending' => array()
                        , 'unknown' => array()
                        , 'error'   => array()
                    ); 
    }

    
    //  R E S P O N S E  ///////////////////////////////////////////////////////
    
    // None
}

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Settings  Page " >

/** Settings  Page  */
class WPBC_Settings_Page_Gateway_BANK_TRANSFER extends WPBC_Page_Structure {
     
    public $gateway_api = false;
    
    /** Define interface for  Gateway  API
     * 
     * @param string $selected_email_name - name of Email template
     * @param array $init_fields_values - array of init form  fields data - this array  can  ovveride "default" fields and loaded data.
     * @return object Email API
     */
    public function get_api( $init_fields_values = array() ){
        
        if ( $this->gateway_api === false ) {
            $this->gateway_api = new WPBC_Gateway_API_BANK_TRANSFER( WPBC_BANK_TRANSFER_GATEWAY_ID , $init_fields_values );    
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
        $is_data_exist = get_bk_option( 'booking_'. WPBC_BANK_TRANSFER_GATEWAY_ID .'_is_active' );
        if (  ( ! empty( $is_data_exist ) ) && ( $is_data_exist == 'On' )  )
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-check"></i> &nbsp; ';
        else 
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-unchecked"></i> &nbsp; ';
        
        
        $subtabs[ WPBC_BANK_TRANSFER_GATEWAY_ID ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' =>  $icon .  __('Bank Transfer', 'booking')                     // Title of TAB    
                            , 'page_title' => sprintf( __('%s Settings', 'booking'), __('Bank Transfer', 'booking') )  // Title of Page   
                            , 'hint' => __('Integration of Bank Transfer payment system' ,'booking')   // Hint    
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
        do_action( 'wpbc_hook_settings_page_header', 'gateway_settings_' . WPBC_BANK_TRANSFER_GATEWAY_ID );
        
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
        
        $submit_form_name = 'wpbc_gateway_' . WPBC_BANK_TRANSFER_GATEWAY_ID;               // Define form name
        
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

        ?><div class="clear" style="margin-bottom:0px;"></div><?php

        
        // Scroll links ////////////////////////////////////////////////////////
        ?>
        <div class="wpdvlp-sub-tabs" style="background:none;border:none;box-shadow: none;padding:0;"><span class="nav-tabs" style="text-align:right;">
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_gateway_bank_transfergeneral_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php printf( __('%s Settings', 'booking'), __('Bank Transfer', 'booking') ); ?></span></a>
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_gateway_bank_transferaccounts_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php _e('Account details' ,'booking'); ?></span></a>
        </span></div>
        <?php
        
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

                
                <div class="clear"></div><?php 
                
                ?><div class="wpbc_settings_row wpbc_settings_row_left"><?php
                        wpbc_open_meta_box_section( $submit_form_name . 'general', sprintf( __('%s Settings', 'booking'), 'Bank Transfer' )   );                            
                            $this->get_api()->show( 'general' );                             
                        wpbc_close_meta_box_section(); 
                ?></div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                        wpbc_open_meta_box_section( $submit_form_name . 'general_help',  __('Help', 'booking') );
                                                
                        wpbc_bank_transfer_help_section();                      //    $this->get_api()->show( 'general_help' );
                        
                        wpbc_close_meta_box_section(); 
                ?></div>
                <div class="clear"></div>
                
                    
                
                <div class="metabox-holder">

                    <div class="wpbc_settings_row wpbc_settings_row_left_NO" >
                    <?php                             
                        wpbc_open_meta_box_section( $submit_form_name . 'accounts', __('Account details' ,'booking') );
                                                     
                        wpbc_show_bank_transfer_accounts_table();
                        
                        wpbc_close_meta_box_section(); 
                    ?>    
                    </div>
                    <div class="clear"></div>

                </div>
                
                <div class="clear"></div>
                <div class="wpbc-settings-notice notice-info" style="text-align:left;">
                    <strong><?php _e('Note!' ,'booking'); ?></strong> <?php 
                            printf( __('Allow payments by %sdirect bank / wire transfer%s' ,'booking'), '', '' );
                            echo '. <strong>';                                  //_e('Important!' ,'booking'); 
                            printf( __('Its only show fixed payment details.' ,'booking'), '<b>', '</b>' );
                            echo '</strong> ';
                    ?>
                </div>
                <div class="clear" style="height:20px;"></div>
                    
                
                <input type="submit" value="<?php _e('Save Changes', 'booking'); ?>" class="button button-primary" />  
            </form>
        </span>
        <?php
        
        $this->enqueue_js();
    }
    
    
    /** Update Email template to DB */
    public function update() {

        // O L D   W A Y:   Saving Data - Order ////////////////////////////////
        $bank_transfer_account_fields = array( 'bank_transfer_account_name' => '', 
                                               'bank_transfer_account_number' => '', 
                                               'bank_transfer_bank_name' => '', 
                                               'bank_transfer_sort_code' => '', 
                                               'bank_transfer_iban' => '', 
                                               'bank_transfer_bic' => '' 
                                             );        
        $accounts_number = 0;
        // Reset sort order of "Bank Accounts" - to have correct keys of array.            
        foreach ( $bank_transfer_account_fields as $account_field => $field_value) {
            if ( isset( $_POST[ $account_field ] ) ) {
                $_POST[ $account_field ] = array_values( $_POST[ $account_field ] );
                $accounts_number = count( $_POST[ $account_field ] );
            }
        }
        $booking_bank_transfer_accounts = array( );
        for ( $i = 0; $i < $accounts_number; $i++ ) {
            $booking_bank_transfer_accounts[$i] = array();
            foreach ( $bank_transfer_account_fields as $account_field => $field_value) {
                if (  ( isset( $_POST[ $account_field ] ) ) && ( isset( $_POST[ $account_field ][$i] ) )  ){     
                    
                    // $checked_value = implode( '^', $_POST[ $account_field ][$i] );                              
                    // $checked_value = wp_kses_post( trim( stripslashes( $checked_value ) ) );
                    // $checked_value = explode( '^', $checked_value );
                    
                    $checked_value = wp_kses_post( trim( stripslashes( $_POST[ $account_field ][$i] ) ) );      // Clean value       
                    
                    $booking_bank_transfer_accounts[$i][ $account_field ] = $checked_value;
                }
            }                
        }
        update_bk_option( 'booking_bank_transfer_accounts', serialize( $booking_bank_transfer_accounts ) );
        
        
        // Titles  /////////////////////////////////////////////////////////////
        
        update_bk_option(                                   'booking_bank_transfer_account_name_title' 
                        , wp_kses_post( trim( stripslashes( $_POST[ 'bank_transfer_account_name_title' ] ) ) )  );
        update_bk_option(                                   'booking_bank_transfer_account_number_title' 
                        , wp_kses_post( trim( stripslashes( $_POST[ 'bank_transfer_account_number_title' ] ) ) )  );        
        update_bk_option(                                   'booking_bank_transfer_bank_name_title' 
                        , wp_kses_post( trim( stripslashes( $_POST[ 'bank_transfer_bank_name_title' ] ) ) )  );        
        update_bk_option(                                   'booking_bank_transfer_sort_code_title' 
                        , wp_kses_post( trim( stripslashes( $_POST[ 'bank_transfer_sort_code_title' ] ) ) )  );
        update_bk_option(                                   'booking_bank_transfer_iban_title' 
                        , wp_kses_post( trim( stripslashes( $_POST[ 'bank_transfer_iban_title' ] ) ) )  );
        update_bk_option(                                   'booking_bank_transfer_bic_title' 
                        , wp_kses_post( trim( stripslashes( $_POST[ 'bank_transfer_bic_title' ] ) ) )  );        
        ////////////////////////////////////////////////////////////////////////
        
        
        // Get Validated Email fields
        $validated_fields = $this->get_api()->validate_post();
        
        $validated_fields = apply_filters( 'wpbc_gateway_bank_transfer_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.
        
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
            /*******************************************************************/
            #wpbc_bank_transfer_accounts thead th {
                background-color: #f3f3f3;    
                border-bottom: none;    
                padding: 10px 0;
            }
            #wpbc_bank_transfer_accounts tfoot th {
                padding:10px;
            }
            #wpbc_bank_transfer_accounts .widefat th.sort,
            #wpbc_bank_transfer_accounts .widefat td.sort {
                width:30px;
            }
            #wpbc_bank_transfer_accounts .widefat td.sort::before{
                color: #aaa;
                content: "\f333";    
                display: inline-block;
                font-family: dashicons;
                font-size: 20px;
                font-style: normal;
                font-weight: 400;
                height: 20px;
                line-height: 1.2em;
                text-align: center;
                text-decoration-color: inherit;
                text-decoration-line: inherit;
                text-decoration-style: inherit;
                vertical-align: top;
                width: 20px;
                padding:5px 0 0 5px;
            }
            #wpbc_bank_transfer_accounts .widefat td {
                padding:0;
            }
            #wpbc_bank_transfer_accounts .widefat th input[type=text],
            #wpbc_bank_transfer_accounts .widefat td input[type=text]{
                width:100%;
                margin:0;
                padding-left:5px;
                font-size:1em;
                line-height: 2em;
                box-shadow: none;
            }
            #wpbc_bank_transfer_accounts .widefat td input[type=text]{
                border-top:none;
                border-bottom: none;
            }            
            #wpbc_bank_transfer_accounts .widefat th input[type=text] {
                width:96%;
                margin:0 2%;
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
                        if ( ! jQuery('#bank_transfer_ipn_is_send_error_email').is(':checked') ) {   
                            jQuery('.wpbc_tr_bank_transfer_ipn_error_email').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#bank_transfer_ipn_is_send_error_email').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_bank_transfer_ipn_error_email').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_bank_transfer_ipn_error_email').addClass('hidden_items');
                                }
                            } ); ";        
        
        
        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );  
        */
    }
    
    // </editor-fold>    
}
add_action('wpbc_menu_created',  array( new WPBC_Settings_Page_Gateway_BANK_TRANSFER() , '__construct') );    // Executed after creation of Menu


/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Check "Return URLs" and "BANK_TRANSFER Email"m, etc...
 * 
 * @param array $validated_fields
 */
function wpbc_gateway_bank_transfer_validate_fields_before_saving__all( $validated_fields ) {
                                                    
//    $validated_fields['return_url']         = wpbc_make_link_relative( $validated_fields['return_url'] );
//    $validated_fields['cancel_return_url']  = wpbc_make_link_relative( $validated_fields['cancel_return_url'] );
    
    if ( wpbc_is_this_demo() ) {
        
//        $validated_fields['merchant_code'] = '';
//        $validated_fields['merchant_key']  = '';
    } 
    
    return $validated_fields;
}
add_filter( 'wpbc_gateway_bank_transfer_validate_fields_before_saving', 'wpbc_gateway_bank_transfer_validate_fields_before_saving__all', 10, 1 );   // Hook for validated fields.

//                                                                              </editor-fold>




//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Activate | Deactivate " >    

////////////////////////////////////////////////////////////////////////////////
// Activate | Deactivate
////////////////////////////////////////////////////////////////////////////////

/** A c t i v a t e */
function wpbc_booking_activate_BANK_TRANSFER() {

    $locale = apply_filters( 'plugin_locale',  get_locale() ,'booking');
    if ( strpos( $locale, '_' ) !== false ) {
        $locale = substr($locale, ( strpos( $locale, '_' ) + 1 ) );
    }
    $sort_code = wpbc_get_sort_code_label();
    if ( isset( $sort_code[$locale] ) )
        $sort_code = $sort_code[$locale];
    else 
        $sort_code = __('Sort Code' ,'booking');

    
    $op_prefix = 'booking_' . WPBC_BANK_TRANSFER_GATEWAY_ID . '_';

    add_bk_option( $op_prefix . 'is_active', 'Off' );
        
    add_bk_option( $op_prefix . 'description', 
                        sprintf( __( 'Dear %sMake your payment %s directly into our bank account. %sPlease use your Booking ID %s as the payment reference! %s %s: %s %s: %s %s: %s %s: %s' ,'booking'),
                                '[name]<br/>' ,
                                '<strong>[cost]</strong>',
                                '<br/>',
                                '<strong>[id]</strong>',
                                '<br/><br/><strong>[bank_name]</strong><br/>',
                                __('Account Number' ,'booking'), '<strong>[account_number]</strong><br/>', 
                                $sort_code, '<strong>[sort_code]</strong><br/>',
                                __('IBAN' ,'booking'), '<strong>[iban]</strong><br/>', 
                                __('BIC / Swift' ,'booking'), '<strong>[bic]</strong><br/><br/>'
                                )
                     );    
    add_bk_option( $op_prefix . 'account_name_title'   , __('Account Name' ,'booking')  );
    add_bk_option( $op_prefix . 'account_number_title' , __('Account Number' ,'booking')  );
    add_bk_option( $op_prefix . 'bank_name_title'      , __('Bank Name' ,'booking')  );
    add_bk_option( $op_prefix . 'sort_code_title'      , $sort_code  );
    add_bk_option( $op_prefix . 'iban_title'           , __('IBAN' ,'booking')  );
    add_bk_option( $op_prefix . 'bic_title'            , __('BIC / Swift' ,'booking')  );
    add_bk_option( $op_prefix . 'accounts'             , serialize( array() ) );        
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_BANK_TRANSFER'   );
                

/** D e a c t i v a t e */
function wpbc_booking_deactivate_BANK_TRANSFER() {
    
    $op_prefix = 'booking_' . WPBC_BANK_TRANSFER_GATEWAY_ID . '_';
    
    delete_bk_option( $op_prefix . 'is_active' );
    delete_bk_option( $op_prefix . 'description' );
    delete_bk_option( $op_prefix . 'account_name_title' );
    delete_bk_option( $op_prefix . 'account_number_title' );
    delete_bk_option( $op_prefix . 'bank_name_title' );
    delete_bk_option( $op_prefix . 'sort_code_title' );
    delete_bk_option( $op_prefix . 'iban_title' );
    delete_bk_option( $op_prefix . 'bic_title' );
    delete_bk_option( $op_prefix . 'accounts' );    
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_BANK_TRANSFER' );

//                                                                              </editor-fold>


// Hook for getting gateway payment form to  show it after  booking process,  or for "payment request" after  clicking on link in email.
// Note,  here we generate new Object for correctly getting payment fields data of specific WP User  in WPBC MU version. 
add_filter( 'wpbc_get_gateway_payment_form', array( new WPBC_Gateway_API_BANK_TRANSFER( WPBC_BANK_TRANSFER_GATEWAY_ID ), 'get_payment_form' ), 10, 3 );



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Bank Transfer    S u p p o r t   F u n c t i o n s " >    
//////////////////////////////////////////////////////////////////////////////////////////////
//  S u p p o r t   F u n c t i o n s      ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

/** Get Sort Code Titles 
 * 
 * @return array
 */
function wpbc_get_sort_code_label() {

return array(
    'AU' => __( 'BSB', 'booking' ),
    'CA' => __( 'Bank Transit Number', 'booking' ),
    'IN' => __( 'IFSC', 'booking' ),
    'IT' => __( 'Branch Sort', 'booking' ),
    'NZ' => __( 'Bank Code', 'booking' ),
    'SE' => __( 'Bank Code', 'booking' ),
    'US' => __( 'Routing Number', 'booking' ),
    'ZA' => __( 'Branch Code', 'booking' )
);
}


/** Show Help description about possible usage of shortcodes in bank trasnfer descrition. */
function wpbc_bank_transfer_help_section() {
    ?>
    <div class="wpbc-help-message" style="margin-top:10px;">
        <p class="description"><strong><?php printf( __( 'You can use following shortcodes in content of this template', 'booking' ) ); ?></strong>: </p>
            <p class="description"><?php printf( __( '%s - inserting all bank accounts details', 'booking' ), '<code>[account_details]</code>' ); ?>, </p>
            <p class="description"><?php printf( __( '%s - inserting account name', 'booking' ), '<code>[account_name]</code>' ); ?>, </p>
            <p class="description"><?php printf( __( '%s - inserting account number', 'booking' ), '<code>[account_number]</code>' ); ?>, </p>
            <p class="description"><?php printf( __( '%s - inserting bank name ', 'booking' ), '<code>[bank_name]</code>' ); ?>, </p>
            <p class="description"><?php printf( __( '%s - inserting sort code ', 'booking' ), '<code>[sort_code]</code>' ); ?>, </p>
            <p class="description"><?php printf( __( '%s - inserting IBAN ', 'booking' ), '<code>[iban]</code>' ); ?>, </p>
            <p class="description"><?php printf( __( '%s - inserting BIC ', 'booking' ), '<code>[bic]</code>' ); ?>, </p><hr/>
            <p class="description"><?php printf( __( '%s - inserting the cost of  booking ', 'booking' ), '<code>[cost]</code>' ); ?>, </p>
            
            <div class="wpbc-settings-notice notice-info" style="text-align:left;margin-top:20px;">
                <strong><?php _e('Note!' ,'booking'); ?></strong> <?php 
                printf( __( 'You can use any shortcodes, that you can use in payment description form at Settings Payment General page', 'booking' ) );
                ?>
            </div>         
    </div>
    <?php
}


/** Show sortable Bank transfer Table for Settings Page */
function wpbc_show_bank_transfer_accounts_table() {
    
        $bank_transfer_account_fields = array( 'bank_transfer_account_name' => '', 
                                               'bank_transfer_account_number' => '', 
                                               'bank_transfer_bank_name' => '', 
                                               'bank_transfer_sort_code' => '', 
                                               'bank_transfer_iban' => '', 
                                               'bank_transfer_bic' => '' 
                                             );
        $bank_transfer_is_active    =  get_bk_option( 'booking_bank_transfer_is_active' );
        $bank_transfer_description  =  get_bk_option( 'booking_bank_transfer_description' );
                                                                                // Replace <br> to  <br> with  new line
        $bank_transfer_description = preg_replace( array( "@(&lt;|<)br/?(&gt;|>)(\r\n)?@" )
                                                        , array( "<br/>" )
                                                        , $bank_transfer_description );
        
        $bank_transfer_account_name_title   =  get_bk_option( 'booking_bank_transfer_account_name_title' );
        $bank_transfer_account_number_title =  get_bk_option( 'booking_bank_transfer_account_number_title' );
        $bank_transfer_bank_name_title      =  get_bk_option( 'booking_bank_transfer_bank_name_title' );
        $bank_transfer_sort_code_title      =  get_bk_option( 'booking_bank_transfer_sort_code_title' );
        $bank_transfer_iban_title           =  get_bk_option( 'booking_bank_transfer_iban_title' );
        $bank_transfer_bic_title            =  get_bk_option( 'booking_bank_transfer_bic_title' );        
        
        $booking_bank_transfer_accounts = get_bk_option( 'booking_bank_transfer_accounts' );
        $booking_bank_transfer_accounts = maybe_unserialize( $booking_bank_transfer_accounts );

        if ( empty( $booking_bank_transfer_accounts ) ) {
            $booking_bank_transfer_accounts = array( $bank_transfer_account_fields );   // Default values
        }
    
        ?>
        <div  id="wpbc_bank_transfer_accounts" class="wpbc_sortable_table wpdevelop" >
            <table class="widefat wpbc_input_table sortable table table-striped" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="sort">&nbsp;</th>
                        <th><input type="text" value="<?php echo esc_js( $bank_transfer_account_name_title ); ?>" name="bank_transfer_account_name_title" /></th>
                        <th><input type="text" value="<?php echo esc_js( $bank_transfer_account_number_title ); ?>" name="bank_transfer_account_number_title" /></th>
                        <th><input type="text" value="<?php echo esc_js( $bank_transfer_bank_name_title ); ?>" name="bank_transfer_bank_name_title" /></th>
                        <th><input type="text" value="<?php echo esc_js( $bank_transfer_sort_code_title ); ?>" name="bank_transfer_sort_code_title" /></th>
                        <th><input type="text" value="<?php echo esc_js( $bank_transfer_iban_title ); ?>" name="bank_transfer_iban_title" /></th>
                        <th><input type="text" value="<?php echo esc_js( $bank_transfer_bic_title ); ?>" name="bank_transfer_bic_title" /></th>
                    </tr>
                </thead>
                <tbody class="accounts">
                <?php
                $i = -1;
                foreach ( $booking_bank_transfer_accounts as $account ) {                                            
                    $i++;

                   echo '<tr class="account">
                            <td class="sort"></td>
                            <td><input type="text" value="' . esc_attr( wp_unslash( $account['bank_transfer_account_name'] ) ) . '" name="bank_transfer_account_name[' . $i . ']" /></td>
                            <td><input type="text" value="' . esc_attr( $account['bank_transfer_account_number'] ) . '" name="bank_transfer_account_number[' . $i . ']" /></td>
                            <td><input type="text" value="' . esc_attr( wp_unslash( $account['bank_transfer_bank_name'] ) ) . '" name="bank_transfer_bank_name[' . $i . ']" /></td>
                            <td><input type="text" value="' . esc_attr( $account['bank_transfer_sort_code'] ) . '" name="bank_transfer_sort_code[' . $i . ']" /></td>
                            <td><input type="text" value="' . esc_attr( $account['bank_transfer_iban'] ) . '" name="bank_transfer_iban[' . $i . ']" /></td>
                            <td><input type="text" value="' . esc_attr( $account['bank_transfer_bic'] ) . '" name="bank_transfer_bic[' . $i . ']" /></td>
                        </tr>';
                }                                    
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7"><a href="#" class="add button"><?php _e( '+ Add Account' ,'booking'); ?></a> <a href="#" class="remove_rows button"><?php _e( 'Remove selected account(s)' ,'booking'); ?></a></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <script type="text/javascript">
            ( function( $ ){
                jQuery('#wpbc_bank_transfer_accounts').on( 'click', 'a.add', function(){

                    var size = jQuery('#wpbc_bank_transfer_accounts tbody .account').size();

                    jQuery('<tr class="account">\
                                <td class="sort"></td>\
                                <td><input type="text" name="bank_transfer_account_name[' + size + ']" /></td>\
                                <td><input type="text" name="bank_transfer_account_number[' + size + ']" /></td>\
                                <td><input type="text" name="bank_transfer_bank_name[' + size + ']" /></td>\
                                <td><input type="text" name="bank_transfer_sort_code[' + size + ']" /></td>\
                                <td><input type="text" name="bank_transfer_iban[' + size + ']" /></td>\
                                <td><input type="text" name="bank_transfer_bic[' + size + ']" /></td>\
                            </tr>').appendTo('#wpbc_bank_transfer_accounts table tbody');

                    jQuery('.wpbc_input_table tbody th, #wpbc_bank_transfer_accounts tbody td').css('cursor','move');
                    return false;
                });

                $( document ).ready(function(){

                    $('.wpbc_input_table tbody th, #wpbc_bank_transfer_accounts tbody td').css('cursor','move');

                    $('.wpbc_input_table tbody td.sort').css('cursor','move');

                    $('.wpbc_input_table.sortable tbody').sortable({
                            items:'tr',
                            cursor:'move',
                            axis:'y',
                            scrollSensitivity:40,
                            forcePlaceholderSize: true,
                            helper: 'clone',
                            opacity: 0.65,
                            placeholder: '#wpbc_bank_transfer_accounts .sort',
                            start:function(event,ui){
                                    ui.item.css('background-color','#f6f6f6');
                            },
                            stop:function(event,ui){
                                    ui.item.removeAttr('style');
                            }
                    });
                });

                $('.wpbc_input_table .remove_rows').click(function() {
                        var $tbody = $(this).closest('.wpbc_input_table').find('tbody');
                        if ( $tbody.find('tr.current').size() > 0 ) {
                                $current = $tbody.find('tr.current');

                                $current.each(function(){
                                        $(this).remove();
                                });
                        }
                        return false;
                });

                var controlled = false;
                var shifted = false;
                var hasFocus = false;

                $(document).bind('keyup keydown', function(e){ shifted = e.shiftKey; controlled = e.ctrlKey || e.metaKey } );

                $('.wpbc_input_table').on( 'focus click', 'input', function( e ) {

                        $this_table = $(this).closest('table');
                        $this_row   = $(this).closest('tr');

                        if ( ( e.type == 'focus' && hasFocus != $this_row.index() ) || ( e.type == 'click' && $(this).is(':focus') ) ) {

                                hasFocus = $this_row.index();

                                if ( ! shifted && ! controlled ) {
                                        $('tr', $this_table).removeClass('current').removeClass('last_selected');
                                        $this_row.addClass('current').addClass('last_selected');
                                } else if ( shifted ) {
                                        $('tr', $this_table).removeClass('current');
                                        $this_row.addClass('selected_now').addClass('current');

                                        if ( $('tr.last_selected', $this_table).size() > 0 ) {
                                                if ( $this_row.index() > $('tr.last_selected, $this_table').index() ) {
                                                        $('tr', $this_table).slice( $('tr.last_selected', $this_table).index(), $this_row.index() ).addClass('current');
                                                } else {
                                                        $('tr', $this_table).slice( $this_row.index(), $('tr.last_selected', $this_table).index() + 1 ).addClass('current');
                                                }
                                        }

                                        $('tr', $this_table).removeClass('last_selected');
                                        $this_row.addClass('last_selected');
                                } else {
                                        $('tr', $this_table).removeClass('last_selected');
                                        if ( controlled && $(this).closest('tr').is('.current') ) {
                                                $this_row.removeClass('current');
                                        } else {
                                                $this_row.addClass('current').addClass('last_selected');
                                        }
                                }

                                $('tr', $this_table).removeClass('selected_now');

                        }
                }).on( 'blur', 'input', function( e ) {
                        hasFocus = false;
                });


            }( jQuery ) );
        </script>
    <?php
    
}
//                                                                              </editor-fold>