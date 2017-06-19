<?php
/**
 * @version 1.0
 * @package  Show Pay in Cash info
 * @category Payment Gateway for Booking Calendar 
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-08-04
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly
                                                                                
if ( ! defined( 'WPBC_PAY_CASH_GATEWAY_ID' ) )        define( 'WPBC_PAY_CASH_GATEWAY_ID', 'pay_cash' );    


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Gateway API " >

/** API  for  Payment Gateway  */
class WPBC_Gateway_API_PAY_CASH extends WPBC_Gateway_API  {                     
        
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

        $pay_cash_description = get_bk_option( 'booking_pay_cash_description' );

        $pay_cash_description = apply_bk_filter('wpdev_check_for_active_language', $pay_cash_description );
//debuge($params);            
        // Add addtional parameters to  replace 
        $params[ 'cost' ]           = $params[ 'payment_cost_hint' ];
        
        $pay_cash_description = wpbc_replace_booking_shortcodes( $pay_cash_description, $params );
        $pay_cash_description = str_replace( '"', '', $pay_cash_description );

        ////////////////////////////////////////////////////////////////////////
        // Payment Form 
        ////////////////////////////////////////////////////////////////////////
        ob_start();
        
        ?><div style="width:100%;clear:both;margin-top:20px;"></div><?php 
        ?><div class="pay_cash_div wpbc-payment-form" style="text-align:left;clear:both;"><?php 
        
            echo $pay_cash_description;
        
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
        
        $this->fields['payment_description_help'] = array(   
                                        'type' => 'help'                                        
                                        , 'value' => array()
                                        , 'cols' => 2
                                        , 'group' => 'payment_description_help'
                                );
        $this->fields['payment_description_help']['value'] = wpbc_get_help_shortcodes_for_payment_gateways();
        
        $option_to_insert = array( '<code>[cost]</code> - <strong>' . __('show amount to pay', 'booking') . '</strong>,' );
        
        array_splice( $this->fields['payment_description_help']['value'], 10, 0, $option_to_insert );            // Insert  new item in at position 12 of original array
        
    }

    
    // Support /////////////////////////////////////////////////////////////////    

    /** Return info about Gateway
     * 
     * @return array        Example: array(
                                            'id'      => 'pay_cash
                                          , 'title'   => 'Pay in Cash'
                                          , 'currency'   => 'USD'
                                          , 'enabled' => true
                                        );        
     */
    public function get_gateway_info() {

        $gateway_info = array(
                      'id'       => $this->get_id()
                    , 'title'    => __( 'Pay in Cash', 'booking' )
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
class WPBC_Settings_Page_Gateway_PAY_CASH extends WPBC_Page_Structure {
     
    public $gateway_api = false;
    
    /** Define interface for  Gateway  API
     * 
     * @param string $selected_email_name - name of Email template
     * @param array $init_fields_values - array of init form  fields data - this array  can  ovveride "default" fields and loaded data.
     * @return object Email API
     */
    public function get_api( $init_fields_values = array() ){
        
        if ( $this->gateway_api === false ) {
            $this->gateway_api = new WPBC_Gateway_API_PAY_CASH( WPBC_PAY_CASH_GATEWAY_ID , $init_fields_values );    
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
        $is_data_exist = get_bk_option( 'booking_'. WPBC_PAY_CASH_GATEWAY_ID .'_is_active' );
        if (  ( ! empty( $is_data_exist ) ) && ( $is_data_exist == 'On' )  )
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-check"></i> &nbsp; ';
        else 
            $icon = '<i class="menu_icon icon-1x glyphicon glyphicon-unchecked"></i> &nbsp; ';
        
        
        $subtabs[ WPBC_PAY_CASH_GATEWAY_ID ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' =>  $icon .  __('Pay in Cash', 'booking')                     // Title of TAB    
                            , 'page_title' => sprintf( __('%s Settings', 'booking'), __('Pay in Cash', 'booking') )  // Title of Page   
                            , 'hint' => __('Integration of Pay in Cash payment system' ,'booking')   // Hint    
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
        do_action( 'wpbc_hook_settings_page_header', 'gateway_settings_' . WPBC_PAY_CASH_GATEWAY_ID );
        
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
        
        $submit_form_name = 'wpbc_gateway_' . WPBC_PAY_CASH_GATEWAY_ID;               // Define form name
        
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
        
        ?>
        <div class="clear" style="height:20px;"></div>
        <div class="wpbc-settings-notice notice-info" style="text-align:left;">
            <strong><?php _e('Note!' ,'booking'); ?></strong> <?php 
                    printf( __( 'If you accept %scash payment%s, you can write details about it here' ,'booking'), '<b>', '</b>' );
                    echo '. <strong>';                                  //_e('Important!' ,'booking'); 
                    printf( __('Its only show fixed payment details.' ,'booking'), '<b>', '</b>' );
                    echo '</strong> ';
            ?>
        </div>        
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
                        wpbc_open_meta_box_section( $submit_form_name . 'general', sprintf( __('%s Settings', 'booking'), 'Pay in Cash' )   );                            
                            $this->get_api()->show( 'general' );                             
                        wpbc_close_meta_box_section(); 
                ?></div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                        wpbc_open_meta_box_section( $submit_form_name . 'general_help',  __('Help', 'booking') );
                                                                        
                        $this->get_api()->show( 'payment_description_help' );
                        
                        wpbc_close_meta_box_section(); 
                ?></div>
                <div class="clear"></div>
                
                
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
        
        $validated_fields = apply_filters( 'wpbc_gateway_pay_cash_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.
        
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
                        if ( ! jQuery('#pay_cash_ipn_is_send_error_email').is(':checked') ) {   
                            jQuery('.wpbc_tr_pay_cash_ipn_error_email').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#pay_cash_ipn_is_send_error_email').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_pay_cash_ipn_error_email').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_pay_cash_ipn_error_email').addClass('hidden_items');
                                }
                            } ); ";        
        
        
        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );  
        */
    }
    
    // </editor-fold>    
}
add_action('wpbc_menu_created',  array( new WPBC_Settings_Page_Gateway_PAY_CASH() , '__construct') );    // Executed after creation of Menu


/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Check "Return URLs" and "PAY_CASH Email"m, etc...
 * 
 * @param array $validated_fields
 */
function wpbc_gateway_pay_cash_validate_fields_before_saving__all( $validated_fields ) {
                                                    
//    $validated_fields['return_url']         = wpbc_make_link_relative( $validated_fields['return_url'] );
//    $validated_fields['cancel_return_url']  = wpbc_make_link_relative( $validated_fields['cancel_return_url'] );
    
    if ( wpbc_is_this_demo() ) {
        
//        $validated_fields['merchant_code'] = '';
//        $validated_fields['merchant_key']  = '';
    } 
    
    return $validated_fields;
}
add_filter( 'wpbc_gateway_pay_cash_validate_fields_before_saving', 'wpbc_gateway_pay_cash_validate_fields_before_saving__all', 10, 1 );   // Hook for validated fields.

//                                                                              </editor-fold>



//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Activate | Deactivate " >    

////////////////////////////////////////////////////////////////////////////////
// Activate | Deactivate
////////////////////////////////////////////////////////////////////////////////

/** A c t i v a t e */
function wpbc_booking_activate_PAY_CASH() {
    
    $op_prefix = 'booking_' . WPBC_PAY_CASH_GATEWAY_ID . '_';

    add_bk_option( $op_prefix . 'is_active', 'Off' );
        
    add_bk_option( $op_prefix . 'description', 
                        sprintf( __( 'Dear %sPay in cash %s for your booking %s on check in %sFor reference your booking ID: %s' ,'booking'),  
                                '[name]<br/>' ,
                                '<strong>[cost]</strong>',
                                '<strong>[resource_title]</strong>',
                                '<strong>[check_in_date]</strong>.<br/>', 
                                '<strong>[id]</strong>'
                                )
                     );    
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_PAY_CASH'   );
                

/** D e a c t i v a t e */
function wpbc_booking_deactivate_PAY_CASH() {
    
    $op_prefix = 'booking_' . WPBC_PAY_CASH_GATEWAY_ID . '_';
    
    delete_bk_option( $op_prefix . 'is_active' );
    delete_bk_option( $op_prefix . 'description' );
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_PAY_CASH' );

//                                                                              </editor-fold>


// Hook for getting gateway payment form to  show it after  booking process,  or for "payment request" after  clicking on link in email.
// Note,  here we generate new Object for correctly getting payment fields data of specific WP User  in WPBC MU version. 
add_filter( 'wpbc_get_gateway_payment_form', array( new WPBC_Gateway_API_PAY_CASH( WPBC_PAY_CASH_GATEWAY_ID ), 'get_payment_form' ), 10, 3 );
