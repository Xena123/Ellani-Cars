<?php
/**
 * @version     1.0
 * @package     General Payment Settings page: Booking > Settings > Payment page
 * @category    Payment Gateways API
 * @author      wpdevelop
 *
 * @web-site    http://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-04-15
 * 
 * This is COMMERCIAL SCRIPT
 * We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" API CLASS" >    

//////////////////////////////////////////////////////////////////////////////////
// API 
////////////////////////////////////////////////////////////////////////////////

/** Payment Gateways Settings 
 * 
 */
class  WPBC_Gateways_API extends WPBC_Settings_API {
    
    /**  Override Settings API Constructor
     *   During creation,  system try to load values from DB, if exist.
     * 
     *  @param type $id - of Settings
     */
    public function __construct( $id = '' ){
          
        $options = array( 
                        'db_prefix_option' => ''                                //'booking_' 
                      , 'db_saving_type'   => 'separate' 
                      , 'id'               => 'gateways'
            ); 
        
        $id = empty($id) ? $options['id'] : $id;
                
        parent::__construct( $id, $options );                                   // Define ID of Setting page and options
                
        //add_action( 'wpbc_after_settings_content', array($this, 'enqueue_js'), 10, 3 );
    }

    
    public function init_settings_fields() {
        
        
        $default_options_values = wpbc_get_default_options_gw();
        
        $this->fields = array();
        
        ////////////////////////////////////////////////////////////////////////
        // Costs 
        ////////////////////////////////////////////////////////////////////////
    
        $field_options = array(                                                 // Cost / 1 { day| night | hour | fixed }  - General  Settings for setting Cost per specific period
                'day'   => __('for 1 day' ,'booking')
              , 'night' => __('for 1 night' ,'booking')
              , 'fixed' => __('fixed sum' ,'booking')
              , 'hour'  => __('for 1 hour' ,'booking')        
        );
        $this->fields['booking_paypal_price_period'] = array(   
                                  'type'        => 'select'
                                , 'default'     => $default_options_values['booking_paypal_price_period']      // 'day'            
                                , 'title'       => __('Set the cost', 'booking')
                                , 'description' => __(' Select your cost configuration.' ,'booking')
                                , 'options'     => $field_options
                                , 'group'       => 'costs'
                        );
    
        $this->fields['booking_is_time_apply_to_cost'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_time_apply_to_cost']      // 'Off'            
                                , 'title'       =>  __('Time impact to cost' ,'booking')
                                , 'label'       => sprintf(__('Check this box if you want the %stime selection%s on the booking form %sapplied to the cost calculation%s.' ,'booking'),'<strong>','</strong>','<strong>','</strong>')
                                , 'description' => ''
                                , 'group'       => 'costs'
            );       

        if ( class_exists( 'wpdev_bk_biz_m' ) ) {
            $this->fields['booking_advanced_costs_calc_fixed_cost_with_procents'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_advanced_costs_calc_fixed_cost_with_procents']      // 'Off'            
                                , 'title'       =>  __('Advanced Cost' ,'booking')
                                , 'label'       => __( 'Check this box if you want that specific additional cost, which configured as percentage for some option, apply to other additional fixed costs and not only to original booking cost.' ,'booking')
                                , 'description' => ''
                                , 'group'       => 'costs'
                );       
        }
        $this->fields['hr_currency'] = array( 'type' => 'hr', 'group' => 'costs' );

        ////////////////////////////////////////////////////////////////////////
        // Currency Symbol
        ////////////////////////////////////////////////////////////////////////
        
        $currency_code_options = wpbc_get_currency_list();

        foreach ( $currency_code_options as $code => $name ) {
                $currency_code_options[ $code ] = $name . ' (' . wpbc_get_currency_symbol( $code ) . ')';
        }
        $this->fields['booking_currency'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_currency']      //'USD'            
                                , 'title'       => __('Currency' ,'booking')
            
                                , 'description' =>  '<div class="wpbc-settings-notice notice-info" style="text-align:left;">'
                                                        . '<strong>' . __('Note' ,'booking') . '!</strong> ' . __('This is default currency that showing at your website. Specific payment gateway(s) can support or does not suport it.' ,'booking')
                                                    . '</div>'
                                                    . '<div class="wpbc-settings-notice notice-warning" style="text-align:left;">'
                                                        . '<strong>' . __('Important' ,'booking') . '!</strong> ' . __('Check and configure currency at each activated payment gateway.' ,'booking')
                                                    . '</div>'
                                , 'options'     => $currency_code_options
                                , 'group'       => 'costs'
                        );
        
        $subtotal = '1000.00';
        $this->fields['booking_currency_pos'] = array( 
                                  'type'        => 'select'
                                , 'default'     => $default_options_values['booking_currency_pos']      //'left'            
                                , 'title'       => __('Currency Position' ,'booking')
                                , 'description' => __( 'Set position of the currency symbol.', 'booking' )
                                , 'description_tag'   => 'p'
                                , 'options'     => array(
                                                            'left'        => __( 'Left', 'booking' ) . ' (' 
                                                                                . wpbc_cost_show( $subtotal, array(  'currency' => wpbc_get_currency()
                                                                                                                     , 'cost_format' => wpbc_get_cost_format( 'left' )
                                                                                                   ) ) . ')'                                    
                                                            , 'right'      => __( 'Right', 'booking' ) . ' (' 
                                                                                . wpbc_cost_show( $subtotal, array(  'currency' => wpbc_get_currency()
                                                                                                                     , 'cost_format' => wpbc_get_cost_format( 'right' )
                                                                                                   ) ) . ')'                                    
                                                            , 'left_space'      => __( 'Left with space', 'booking' ) . ' (' 
                                                                                . wpbc_cost_show( $subtotal, array(  'currency' => wpbc_get_currency()
                                                                                                                     , 'cost_format' => wpbc_get_cost_format( 'left_space' )
                                                                                                   ) ) . ')'                                    
                                                            , 'right_space'      => __( 'Right with space', 'booking' ) . ' (' 
                                                                                . wpbc_cost_show( $subtotal, array(  'currency' => wpbc_get_currency()
                                                                                                                     , 'cost_format' => wpbc_get_cost_format( 'right_space' )
                                                                                                   ) ) . ')'                                    
                                                    )
                                , 'css'         => 'min-width:335px;'
                                , 'group'       => 'costs'

                        );
                
        ////////////////////////////////////////////////////////////////////////
        //  Currency Format 
        ////////////////////////////////////////////////////////////////////////

        // Number of decimal points
        $field_options = array( 0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4 );
        $this->fields['booking_cost_currency_format_decimal_number'] = array(   
                                'type'        => 'select'
                              , 'default'     => $default_options_values['booking_cost_currency_format_decimal_number']      //'2'            
                              , 'title' =>__('Currency format' ,'booking')
                              , 'description'       => __('Number of decimal points', 'booking')
                              , 'options'     => $field_options
                              , 'group'       => 'costs'
                              , 'tr_class'    => 'wpbc_sub_settings_grayed'
                      );
        // Separator for the decimal point
        $field_options = array(
                  ''  => __('No separator' ,'booking')
                , ' ' => __('Space' ,'booking')
                , '.' => __('Dot' ,'booking')
                , ',' => __('Comma' ,'booking') 
        );
        $this->fields['booking_cost_currency_format_decimal_separator'] = array(   
                                  'type'        => 'select'
                                , 'default'     => $default_options_values['booking_cost_currency_format_decimal_separator']      //'.'            
                                , 'description'       => __('Separator for the decimal point', 'booking')
                                , 'options'     => $field_options
                                , 'group'       => 'costs'
                                , 'tr_class'    => 'wpbc_sub_settings_grayed'
                        );
        // Thousands separator
        $field_options = array(
                  ''  => __('No separator' ,'booking')
                , 'space' => __('Space' ,'booking')
                , '.' => __('Dot' ,'booking')
                , ',' => __('Comma' ,'booking') 
        );
        $this->fields['booking_cost_currency_format_thousands_separator'] = array(   
                                  'type'        => 'select'
                                , 'default'     => $default_options_values['booking_cost_currency_format_thousands_separator']      //''            
                                , 'description'       => __('Thousands separator', 'booking')
                                , 'options'     => $field_options
                                , 'group'       => 'costs'
                                , 'tr_class'    => 'wpbc_sub_settings_grayed'
                        );
        
        
        ////////////////////////////////////////////////////////////////////////
        // Biiling form Fields assignment
        ////////////////////////////////////////////////////////////////////////

        $fields = wpbc_get_fields_from_booking_form();

        $field_options = array('' => __('Please select', 'booking') );
        
        if (  ( ! empty($fields) ) && ( isset($fields[1]) )  &&  ( isset($fields[1][2]) )  ){
            
            foreach ( $fields[1][2] as $field_name ) {
                $field_name = trim($field_name);
                $field_options[ $field_name ] = $field_name;
            }            
        }
        $this->fields['help_billing_fields'] = array(   
                           'type'              => 'help'
                         , 'value'             => __('Please select a field from your booking form. This field will be automatically assigned to the current field in the billing form.' ,'booking')
                         , 'class'             => ''
                         , 'css'               => 'margin:0;padding:0;border:0;'
                         , 'description'       => ''
                         , 'cols'              => 2 
                         , 'group'             => 'billing_fields'
                         , 'tr_class'          => ''
                         , 'description_tag'   => 'p'
                 );         
        $this->fields['booking_billing_customer_email'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_customer_email']      //'email'            
                                , 'title'       => __('Customer Email' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );        
        $this->fields['booking_billing_firstnames'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_firstnames']      //'name'            
                                , 'title'       => __('First Name(s)' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
        $this->fields['booking_billing_surname'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_surname']      //'secondname'            
                                , 'title'       => __('Last name' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
        $this->fields['booking_billing_phone'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_phone']      //'phone'            
                                , 'title'       => __('Phone' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
        $this->fields['booking_billing_address1'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_address1']      //'address'            
                                , 'title'       => __('Billing Address' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
        $this->fields['booking_billing_city'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_city']      //'city'            
                                , 'title'       => __('Billing City' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
        $this->fields['booking_billing_country'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_country']      //'country'            
                                , 'title'       => __('Country' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
        
        $this->fields['booking_billing_post_code'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_post_code']      //'postcode'            
                                , 'title'       => __('Post Code' ,'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
        $this->fields['booking_billing_state'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_billing_state']      //'state'            
                                , 'title'       => __('State' ,'booking')
                                , 'description' => ucfirst( __('optional' ,'booking') )
                                , 'options'     => $field_options
                                , 'group'       => 'billing_fields'
                        );
                              
        ////////////////////////////////////////////////////////////////////////
        // Show Payment Details Summary
        ////////////////////////////////////////////////////////////////////////
        $this->fields['booking_is_show_booking_summary_in_payment_form'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_show_booking_summary_in_payment_form']      //'Off'            
                                , 'title'       =>  __('Show booking details in payment form' ,'booking')
                                , 'label'       => sprintf(__(' Check this checkbox if you want to show the %sbooking details summary%s  above the payment form' ,'booking'),'<strong>','</strong>','<strong>','</strong>')
                                , 'description' => ''
                                , 'group'       => 'payment_description'
            );               
        $this->fields['booking_payment_description'] = array( 
                                  'type'              => 'wp_textarea'
                                , 'default'           => $default_options_values['booking_payment_description']     
                                , 'title'             => ''
                                , 'class'             => ''
                                , 'css'               => ''
                                , 'placeholder'       => ''
                                , 'description'       => __('Configure booking details summary above the payment form', 'booking')
                                , 'attr'              => array()
                                , 'rows'              => 20
                                , 'cols'              => 20
                                    , 'teeny'             => true
                                    , 'show_visual_tabs'  => true
                                    //, 'default_editor'    => 'html'           // 'tinymce' | 'html'      // 'html' is used for the "Text" editor tab.
                                , 'show_in_2_cols'    => true
                                , 'tr_class'          => ''
                                , 'description_tag'   => 'p'
                                , 'group'             => 'payment_description'
                      );        
        
        
        
        $this->fields['payment_description_help'] = array(   
                                        'type' => 'help'                                        
                                        , 'value' => array()
                                        , 'cols' => 2
                                        , 'group' => 'payment_description_help'
                                );
        $this->fields['payment_description_help']['value'] = wpbc_get_help_shortcodes_for_payment_gateways();
        
    }
}

//                                                                              </editor-fold>


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Settings Page CLASS " >    

////////////////////////////////////////////////////////////////////////////////
// Settings Page 
////////////////////////////////////////////////////////////////////////////////

/** Show Content
 *  Update Content
 *  Define Slug
 *  Define where to show
 */
class WPBC_Page_SettingsGateways extends WPBC_Page_Structure {
    
    
    private $settings_api = false;
    
    /** Get Settings API class - define, show, update "Fields".
     * 
     * @return object Settings API
     */    
    public function settings_api(){
        
        if ( $this->settings_api === false )             
             $this->settings_api = new WPBC_Gateways_API(); 
        
        return $this->settings_api;
    }
    
    
    public function in_page() {
        return 'wpbc-settings';
    }
    
    
    public function tabs() {
        
        $tabs = array();
        $tabs[ 'payment' ] = array(
                              'title'       => __('Payments','booking')                     // Title of TAB    
                            , 'hint'        => __('Customizaton of Payment', 'booking')     // Hint    
                            , 'page_title'  => __('Payment Gateways', 'booking')            // Title of Page    
                            , 'link' => ''                                      // Can be skiped,  then generated link based on Page and Tab tags. Or can  be extenral link
                            , 'position' => ''                                  // 'left'  ||  'right'  ||  ''
                            , 'css_classes' => ''                               // CSS class(es)
                            , 'icon' => ''                                      // Icon - link to the real PNG img
                            , 'font_icon'   => 'glyphicon glyphicon-credit-card'                  // CSS definition  of forn Icon
                            , 'default' => false                                // Is this tab activated by default or not: true || false. 
                            , 'subtabs' => array()
            
        );
        
        $subtabs = array();
        
        $subtabs['gateways'] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title'       => __('General' ,'booking')        // Title of TAB    
                            , 'page_title'  => __('Payment Settings', 'booking')  // Title of Page   
                            , 'hint'        => __('Payment Gateways - General Settings' ,'booking')   // Hint    
                            , 'link' => ''                                      // link
                            , 'position' => ''                                  // 'left'  ||  'right'  ||  ''
                            , 'css_classes' => ''                               // CSS class(es)
                            //, 'icon' => 'http://.../icon.png'                 // Icon - link to the real PNG img
                            //, 'font_icon' => 'icon-1x glyphicon glyphicon-cog'   // CSS definition of Font Icon
                            , 'default' =>  true                                // Is this sub tab activated by default or not: true || false. 
                            , 'disabled' => false                               // Is this sub tab deactivated: true || false. 
                            , 'checkbox'  => false                              // or definition array  for specific checkbox: array( 'checked' => true, 'name' => 'feature1_active_status' )   //, 'checkbox'  => array( 'checked' => $is_checked, 'name' => 'enabled_active_status' )
                            , 'content' => 'content'                            // Function to load as conten of this TAB
                        );
        
        $tabs[ 'payment' ][ 'subtabs' ] = $subtabs;
        
        return $tabs;
    }

    
    public function content() {
        
        $this->css();

        ////////////////////////////////////////////////////////////////////////
        // Checking ////////////////////////////////////////////////////////////
        
        do_action( 'wpbc_hook_settings_page_header', 'gateways_settings');       // Define Notices Section and show some static messages, if needed
        
        if ( ! wpbc_is_mu_user_can_be_here('activated_user') ) return false;    // Check if MU user activated, otherwise show Warning message.
   
        // if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;  // User is not Super admin, so exit.  Basically its was already checked at the bottom of the PHP file, just in case.

        $this->check_compatibility_with_older_7_ver();
        
        // Init Settings API & Get Data from DB ////////////////////////////////
        $this->settings_api();                                                  // Define all fields and get values from DB

        //////////////////////////////////////////////////////////////////////// 
        // Submit  /////////////////////////////////////////////////////////////

        $submit_form_name = 'wpbc_payment_gateways';                            // Define form name

        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name  );  // Its stop show anything on submiting, if its not refear to the original page

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
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_settings_payment_gateways_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php _e('Active Payment Gateways' , 'booking' ); ?></span></a>
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_settings_payment_billing_fields_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php _e('Billing form fields' , 'booking' ); ?></span></a>
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_settings_payment_general_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php _e('Payment Settings' , 'booking' ); ?></span></a>
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_settings_payment_description_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php _e('Payment Description' , 'booking' ); ?></span></a>
        </span></div>
        <?php
        
        ////////////////////////////////////////////////////////////////////////
        // Content  ////////////////////////////////////////////////////////////
        ?>
        <div class="clear" style="margin-bottom:10px;"></div>
        <span class="metabox-holder">
            <form  name="<?php echo $submit_form_name; ?>" id="<?php echo $submit_form_name; ?>" action="" method="post">
                <?php 
                   // N o n c e   field, and key for checking   S u b m i t 
                   wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo $submit_form_name; ?>" id="is_form_sbmitted_<?php echo $submit_form_name; ?>" value="1" /><?php 
                
                ?><input type="hidden" name="reset_to_default_form" id="reset_to_default_form" value="" /><?php 
                     
                ?><div class="wpbc_settings_row wpbc_settings_row_left"><?php
                
                
                    wpbc_open_meta_box_section( 'wpbc_settings_payment_gateways', __('Active Payment Gateways', 'booking') );
                        $this->show_active_payment_gateways();                    
                    wpbc_close_meta_box_section();
                    
                    
                    wpbc_open_meta_box_section( 'wpbc_settings_payment_general', __('Payment Settings', 'booking') );
                        
                        $this->settings_api()->show( 'costs' ); 
                    
                    wpbc_close_meta_box_section();
                ?>
                </div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                    /*
                        wpbc_open_meta_box_section( 'wpbc_settings_payment_actions', __('Actions', 'booking') ); 
                                
                            ?><input type="submit" value="<?php _e('Save Changes', 'booking'); ?>" class="button button-primary" style="margin:0 0 5px 5px;" /><?php 
                            ?><div class="clear"></div><?php   
                        
                        wpbc_close_meta_box_section(); 
                    /**/
                    wpbc_open_meta_box_section( 'wpbc_settings_payment_billing_fields', __('Billing form fields' ,'booking') );
                        $this->settings_api()->show( 'billing_fields' );              
                    wpbc_close_meta_box_section();
                
                    ?>
                </div>
                <div class="clear"></div><?php 
                
                ?><div class="wpbc_settings_row wpbc_settings_row_left"><?php
                
                    wpbc_open_meta_box_section( 'wpbc_settings_payment_description', __('Payment Description', 'booking') );
                        
                        $this->settings_api()->show( 'payment_description' ); 
                    
                    wpbc_close_meta_box_section();
                
                ?></div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                
                    wpbc_open_meta_box_section( 'wpbc_settings_payment_description_help', __('Help', 'booking') );
                        
                        $this->settings_api()->show( 'payment_description_help' );                            
                        
                    wpbc_close_meta_box_section();                
                
                ?></div>
                <div class="clear"></div>
                
                
                
                <input type="submit" value="<?php _e('Save Changes','booking'); ?>" class="button button-primary wpbc_submit_button" />  
            </form>
        </span>
        <?php       
    
        do_action( 'wpbc_hook_settings_page_footer', 'gateways_settings' );
    }

    
    /** Save Chanages */  
    public function update() {

        // Save order of Gateways
        if(  ( isset( $_POST['gateways'] ) ) && ( is_array( $_POST['gateways'] ) )  ){
                
            $gateways_order = array_values( $_POST[ 'gateways' ] );
            $gateways_order = implode( ',', $gateways_order );                
            $gateways_order = wp_kses_post( trim( stripslashes( $gateways_order ) ) );

            update_bk_option( 'booking_gateways_order', $gateways_order );      // O L D   W A Y:   Saving Fields Data
        }


        $validated_fields = $this->settings_api()->validate_post();             // Get Validated Settings fields in $_POST request.
        
        $validated_fields = apply_filters( 'wpbc_gw_settings_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.        
        

        // Skip saving specific option, for example in Demo mode.
        // unset($validated_fields['start_day_weeek']);

        $this->settings_api()->save_to_db( $validated_fields );                 // Save fields to DB
        
        wpbc_show_changes_saved_message();
        
                         
        /*    
        // O L D   W A Y:   Saving Fields Data
              update_bk_option( 'booking_is_delete_if_deactive'
                               , WPBC_Settings_API::validate_checkbox_post('booking_is_delete_if_deactive') );  
              ( (isset( $_POST['booking_is_delete_if_deactive'] ))?'On':'Off') );
         */
        
// debuge( basename(__FILE__), 'UPDATE',  $_POST, $validated_fields ); 
    }


    /** Check Compatibility with  data of previos versions */
    private function check_compatibility_with_older_7_ver() {

        $fields_names = array(
                              'booking_billing_customer_email'  
                            , 'booking_billing_firstnames'
                            , 'booking_billing_surname'
                            , 'booking_billing_phone'
                            , 'booking_billing_address1'
                            , 'booking_billing_city'
                            , 'booking_billing_country'
                            , 'booking_billing_post_code'
                            , 'booking_billing_state'         
            );

            // Trim  values of these fields. In previos version, there was one empty  space at the begining of field.
            foreach ( $fields_names as $field_name) {
                $field_value = get_bk_option( $field_name );
                if ( ! empty( $field_value ) ) {
                    $field_value = trim( $field_value );
                    update_bk_option( $field_name, $field_value );
                }
            }
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
            /* toolbar fix */
            .wpdevelop .visibility_container .control-group {
                margin: 0 8px 5px 0;
            }
            /* Selectbox element in toolbar */
            .visibility_container select optgroup{                            
                color:#999;
                vertical-align: middle;
                font-style: italic;
                font-weight: 400;
            }
            .visibility_container select option {
                padding:5px;
                font-weight: 600;
            }
            .visibility_container select optgroup option{
                padding: 5px 20px;       
                color:#555;
                font-weight: 600;
            }
            #wpbc_create_new_custom_form_name_fields {
                width: 360px;
                display:none;
            }
            .wpbc_input_table.sortable td.sort {
                padding:3px 8px;
            }
            @media (max-width: 399px) {
                #wpbc_create_new_custom_form_name_fields {
                    width: 100%;
                }                
            }
        </style>
        <?php
    }
    
    // </editor-fold>
    
    
    // <editor-fold     defaultstate="collapsed"                        desc=" Payment Gateways Sort Table"  >

    /** Show Active Payment Gateways. Sort/Activate/Deadtivate */
    private function show_active_payment_gateways() {
        
        ////////////////////////////////////////////////////////////////////////
        // Get Sorted Registred Gateways
        ////////////////////////////////////////////////////////////////////////
         
        // Get info of ALL registred payment Gateways
        $all_gateways_info = apply_filters( 'wpbc_get_all_gateways_info', array() );    
        
        // Unsorted list of Registered Gateways
        $gateways_unsorted = array();                
        foreach ( $all_gateways_info as $gateway_id => $gateway_info ) {
            
            $gateways_unsorted[$gateway_id] = array( 
                                                    'title'     => $gateway_info['title']
                                                    ,'currency' => $gateway_info['currency']
                                                    ,'enabled'  => $gateway_info['enabled'] ? 'On' : 'Off' );
        /*
            $gateways_unsorted[ 'paypal' ]           = array( 'PayPal Standard'                                  , 'USD', 'On' );
            $gateways_unsorted[ 'paypal_hosted' ]    = array( 'PayPal Pro Hosted Solution'                       , 'USD', 'Off' );
            $gateways_unsorted[ 'authorizenet' ] = array( 'Authorize.Net - Server Integration Method (SIM)'  , 'USD', 'Off' );
            $gateways_unsorted[ 'bank_transfer' ]    = array( __( 'Bank Transfer' ,'booking')                    , 'EUR', 'Off' );
            $gateways_unsorted[ 'pay_cash' ]         = array( __( 'Pay in Cash' ,'booking')                      , 'USD', 'Off' );
            $gateways_unsorted[ 'ipay88' ]           = array( 'iPay88'                                           , 'USD', 'Off' );
            $gateways_unsorted[ 'sage' ]             = array( 'Sage Pay'                                         , 'GBP', 'Off' );
        */
        }
                        
        // Get Order of Gateways 
        $booking_gateways_order = get_bk_option( 'booking_gateways_order' );
        $booking_gateways_order = explode( ',', $booking_gateways_order );
        
        // Set sorted list of only Registred Gateways
        $gateways = array();        
        foreach ( $booking_gateways_order as $gw_order_id ) {
            if (  ( ! empty( $gw_order_id ) ) && ( ! empty( $gateways_unsorted[ $gw_order_id ] ) )   )
                $gateways[ $gw_order_id ] =   $gateways_unsorted[ $gw_order_id ];        
        }        

        // Append NEW gateways,  that does not exist  in Order list
        foreach ( $gateways_unsorted as $gw_unsorted_id => $gateways_unsorted_value ) {
            if ( empty( $gateways[ $gw_unsorted_id ] ) ) 
                $gateways[ $gw_unsorted_id ] = $gateways_unsorted_value;
        }        
        ////////////////////////////////////////////////////////////////////////
    
        $booking_currency = get_bk_option( 'booking_currency' );

        $is_some_currency_different_than_main = false;
        ?>
        <div class="wpbc_sortable_table wpdevelop" >
            <table class="widefat wpbc_input_table sortable table table-striped" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="sort">&nbsp;</th>
                        <th><?php _e('Gateway', 'booking') ?></th>
                        <th><?php _e('ID', 'booking') ?></th>
                        <th style="text-align:center;"><?php _e('Currency', 'booking') ?></th>
                        <th style="text-align:center;"><?php _e('Enabled', 'booking') ?></th>
                    </tr>
                </thead>
                <tbody class="accounts">
                    <?php
                    $i = -1;
                    if ( ! empty( $gateways ) ) {
                        $gateways = maybe_unserialize($gateways);    
                        foreach ( $gateways as $gw_id => $gw ) {                                            
                            $i++;

                            /** Check if some currencis in the payment gatewys are different 
                             *  from  currency in the main settings at  this page.
                             */
                            if (  ( esc_js( $gw['currency'] ) == $booking_currency ) || empty( $gw['currency'] )  )
                                $currency_style = 'font-weight:600;';
                            else { 
                                $currency_style = 'font-weight:600;color:#fff;background:#f90;padding:2px 5px;';
                                $is_some_currency_different_than_main = true;
                            }
                            
                            echo '<tr class="account" id="'. $gw_id .'">
                                    <td class="sort"><input type="hidden" value="' . esc_attr( wp_unslash( $gw_id ) ) . '" name="gateways[' . $i . ']" /></td>
                                    <td><strong><a href="' . wpbc_get_settings_url(). '&tab=payment&subtab=' . $gw_id . '">' . esc_js( $gw['title'] ) . '</a></strong></td>
                                    <td>' . esc_js( $gw_id ) . '</td>
                                    <td style="text-align:center;"><a  style="'. $currency_style .'" href="' . wpbc_get_settings_url(). '&tab=payment&subtab=' . $gw_id . '#'. $gw_id .'_curency">' . esc_js( $gw['currency'] ) . '</a></td>
                                    <td style="text-align:center;">' . ( ( $gw['enabled'] == 'On') ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>' ) . '</td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
<?php /* ?>                
                <tfoot>
                    <tr>
                        <th colspan="7"><a href="#" class="add button"><?php _e( '+ Add Account' ,'booking'); ?></a> <a href="#" class="remove_rows button"><?php _e( 'Remove selected account(s)' ,'booking'); ?></a></th>
                    </tr>
                </tfoot>
<?php /**/ ?>            
            </table>
            <?php if ( $is_some_currency_different_than_main ) { 
                
                    $currency_code_options = wpbc_get_currency_list();
                    $booking_currency_title = $currency_code_options[ $booking_currency ] . ' (' . wpbc_get_currency_symbol( $booking_currency ) . ') - [' . $booking_currency . ']';
            ?>
            <div class="wpbc-settings-notice notice-warning" style="text-align:left;">
                <strong><?php _e('Warning' ,'booking') ?>!</strong> <?php printf( __('Some currencies at payment gateways are different from main currency %s' ,'booking')
                        , '<strong>"' . $booking_currency_title . '"</strong>' ); ?>
            </div>
            <div class="wpbc-settings-notice notice-error" style="text-align:left;margin-top:10px;">
                <strong><?php _e('Important' ,'booking') ?>!</strong> <?php  printf( __('Interface of plugin is using %s currency. Specific payment gateway will use own currency in payment form without currency exchange! Its can be reason of wrong cost.' ,'booking'), $booking_currency ); ?>
            </div>
            <?php } ?>
            <script type="text/javascript">
                ( function( $ ){
<?php /* ?>                    
                    jQuery('.wpbc_sortable_table').on( 'click', 'a.add', function(){

                        var size = jQuery('.wpbc_sortable_table tbody .account').size();

                        jQuery('<tr class="account">\
                                    <td class="sort"></td>\
                                    <td><legend class="wpbc_mobile_legend"><?php echo esc_js( $bank_transfer_account_name_title ); ?>:</legend><input type="text" name="bank_transfer_account_name[' + size + ']" /></td>\
                                    <td><legend class="wpbc_mobile_legend"><?php echo esc_js( $bank_transfer_account_number_title ); ?>:</legend><input type="text" name="bank_transfer_account_number[' + size + ']" /></td>\
                                    <td><legend class="wpbc_mobile_legend"><?php echo esc_js( $bank_transfer_bank_name_title ); ?>:</legend><input type="text" name="bank_transfer_bank_name[' + size + ']" /></td>\
                                    <td><legend class="wpbc_mobile_legend"><?php echo esc_js( $bank_transfer_sort_code_title ); ?>:</legend><input type="text" name="bank_transfer_sort_code[' + size + ']" /></td>\
                                </tr>').appendTo('.wpbc_sortable_table table tbody');

                        jQuery('.wpbc_input_table tbody th, .wpbc_sortable_table tbody td').css('cursor','move');
                        return false;
                    });
<?php /**/ ?>
                    $( document ).ready(function(){

                        $('.wpbc_input_table tbody th, .wpbc_sortable_table tbody td').css('cursor','move');

                        $('.wpbc_input_table tbody td.sort').css('cursor','move');

                        $('.wpbc_input_table.sortable tbody').sortable({
                                items:'tr',
                                cursor:'move',
                                axis:'y',
                                scrollSensitivity:40,
                                forcePlaceholderSize: true,
                                helper: 'clone',
                                opacity: 0.65,
                                placeholder: '.wpbc_sortable_table .sort',
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
        </div>
        <?php
    }
           
    // </editor-fold>
    
}
add_action('wpbc_menu_created', array( new WPBC_Page_SettingsGateways() , '__construct') );    // Executed after creation of Menu


/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Range_start_day_dynamic0-6 and range_start_day0-6 does not exist in the DB
 * they  exist  only in settings page, so  need to  get  values from these options
 * and ovverride values to the "range_start_day" and "range_start_day_dynamic" if its required.
 * 
 * @param array $validated_fields
 */
function wpbc_settings_validate_fields_before_saving__gw( $validated_fields ) {

    // Need to  convert this settings relative to "&nbsp;" (space) saving.
    $validated_fields['booking_cost_currency_format_decimal_separator']   = htmlentities( $_POST['gateways_booking_cost_currency_format_decimal_separator'] );
    $validated_fields['booking_cost_currency_format_thousands_separator'] = htmlentities( $_POST['gateways_booking_cost_currency_format_thousands_separator'] );
    
    return $validated_fields;
}
add_filter( 'wpbc_gw_settings_validate_fields_before_saving', 'wpbc_settings_validate_fields_before_saving__gw', 10, 1 );   // Hook for validated fields.


function wpbc_get_help_shortcodes_for_payment_gateways() {
    
    $help_shortcodes = array();
    
    $help_shortcodes[] = '<strong>' . __('Use these shortcodes for customization: ' ,'booking') . '</strong>';
    $help_shortcodes[] = sprintf(__('%s - inserting data info about the booking, which you configured in the content form at Settings Fields page' ,'booking'),'<code>[content]</code>') . ',';
    $help_shortcodes[] = sprintf(__('%s - inserting data from fields of booking form' ,'booking'),'<code>[field_name]</code>') . ',';        
    $help_shortcodes[] = '<hr/><code>[booking_id]</code> - ' . __('ID of booking', 'booking') . ',';
    $help_shortcodes[] = '<code>[resource_id]</code> - ' . __('ID of booking resources', 'booking') . ',';
    $help_shortcodes[] = '<code>[resource_title]</code> - ' . __('title of booking resource', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[siteurl]</code> - ' . __('website URL', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[remote_ip]</code> - ' . __('IP of user', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[user_agent]</code> - ' . __('browser user agent of user', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[request_url]</code> - ' . __('request URL', 'booking') . ',';
    $help_shortcodes[] = '<code>[current_date]</code> - ' . __('current date', 'booking') . ',';
    $help_shortcodes[] = '<code>[current_time]</code> - ' . __('current time', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[moderatelink]</code> - ' . __('URL to manage this booking', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[visitorbookingediturl]</code> - ' . __('URL to edit this booking', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[visitorbookingcancelurl]</code> - ' . __('URL to cancel this booking', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[visitorbookingpayurl]</code> - ' . __('URL of payment request of booking', 'booking') . ',';
    //        $help_shortcodes[] = '<code>[bookinghash]</code> - ' . __('HASH of this booking', 'booking') . ',';        
    $help_shortcodes[] = '<code>[content]</code> - ' . __('content data of this booking', 'booking');        
    $help_shortcodes[] = '<hr/><code>[payment_cost_hint]</code> - ' . __('show amount to pay', 'booking') . ',';
    if ( class_exists( 'wpdev_bk_biz_m' ) ) {
        $help_shortcodes[] = '<code>[calc_cost_hint]</code> - ' . __('total booking cost', 'booking') . ',';
        $help_shortcodes[] = '<code>[calc_deposit_hint]</code> - ' . __('deposit cost', 'booking') . ',';
        $help_shortcodes[] = '<code>[calc_balance_hint]</code> - ' . __('balance cost', 'booking') . ',';
        $help_shortcodes[] = '<code>[calc_original_cost_hint]</code> - ' . __('original booking cost', 'booking') . ',';
        $help_shortcodes[] = '<code>[calc_additional_cost_hint]</code> - ' . __('additional booking cost', 'booking') . ',';
    }        
    $help_shortcodes[] = '<hr><code>'.'[check_in_date_hint]'.'</code> - ' 
                                                                    . __('Selected Check In date.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'11/25/2013'.'</strong>';                                    
    $help_shortcodes[] = '<code>'.'[check_out_date_hint]'.'</code> - ' 
                                                                    . __('Selected Check Out date.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'11/27/2013'.'</strong>';                                    
    $help_shortcodes[] = '<hr><code>'.'[start_time_hint]'.'</code> - ' 
                                                                    . __('Selected Start Time.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'10:00'.'</strong>';                                    
    $help_shortcodes[] = '<code>'.'[end_time_hint]'.'</code> - ' 
                                                                    . __('Selected End Time.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'12:00'.'</strong>';                                    
    $help_shortcodes[] = '<hr><code>'.'[selected_dates_hint]'.'</code> - ' 
                                                                    . __('All selected dates.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'11/25/2013, 11/26/2013, 11/27/2013'.'</strong>';                                    
    $help_shortcodes[] = '<code>'.'[selected_timedates_hint]'.'</code> - ' 
                                                                    . __('All selected dates with times.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'11/25/2013 10:00, 11/26/2013, 11/27/2013 12:00'.'</strong>';                                    
    $help_shortcodes[] = '<code>'.'[selected_short_dates_hint]'.'</code> - ' 
                                                                    . __('All selected dates in "short" format.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'11/25/2013 - 11/27/2013'.'</strong>';                                    
    $help_shortcodes[] = '<code>'.'[selected_short_timedates_hint]'.'</code> - ' 
                                                                    . __('All selected dates with times in "short" format..' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'11/25/2013 10:00 - 11/27/2013 12:00'.'</strong>';                                    
    $help_shortcodes[] = '<hr><code>'.'[days_number_hint]'.'</code> - ' 
                                                                    . __('Number of selected days.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'3'.'</strong>';                                    
    $help_shortcodes[] = '<code>'.'[nights_number_hint]'.'</code> - ' 
                                                                    . __('Number of selected nights.' ,'booking') . ' '
                                                                    . __('Example:' ,'booking').'<strong>'.'2'.'</strong>';                
    $help_shortcodes[] = '<hr/><strong>' . __('HTML' ,'booking') . '.</strong> '
                                  . sprintf(__('You can use any %sHTML tags%s in the booking form. Please use the HTML tags carefully. Be sure, that all "open" tags (like %s) are closed (like this %s).' ,'booking')
                                       ,'<strong>','</strong>'
                                       ,'<code>&lt;div&gt;</code>'
                                       ,'<code>&lt;/div&gt;</code>'
                                    );   
    
    return $help_shortcodes;    
}

//                                                                              </editor-fold>


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Activate | Deactivate " >    

////////////////////////////////////////////////////////////////////////////////
// Activate | Deactivate
////////////////////////////////////////////////////////////////////////////////

/** Get default options for activation | deactivation
 * 
 * @return array
 */
function wpbc_get_default_options_gw() {
    
    $default_options = array();  
    
    ////////////////////////////////////////////////////////////////////////////
    $booking_form   = get_bk_option( 'booking_form' );        
    
    $booking_fields = wpbc_get_fields_from_booking_form( $booking_form );    
    if ($booking_fields !== false) {        
        $fields_matches = $booking_fields[1][2] ;                               // $fields_count   = $booking_fields[0] ;
    } else { 
        $fields_matches = array();         
    }    
    $fields_matches = array_map( 'trim', $fields_matches );                     // Get all available names of booking form fields in Standart Form
    ////////////////////////////////////////////////////////////////////////////
    $default_options[ 'booking_billing_customer_email' ] = ( in_array( 'email',  $fields_matches ) ? 'email' : '' );
    $default_options[ 'booking_billing_firstnames'     ] = ( in_array( 'name',  $fields_matches ) ? 'name' : '' );
    $default_options[ 'booking_billing_surname'        ] = ( in_array( 'secondname',  $fields_matches ) ? 'secondname' : '' );
    $default_options[ 'booking_billing_address1'       ] = ( in_array( 'address',  $fields_matches ) ? 'address' : '' );
    $default_options[ 'booking_billing_city'           ] = ( in_array( 'city',  $fields_matches ) ? 'city' : '' );
    $default_options[ 'booking_billing_country'        ] = ( in_array( 'country',  $fields_matches ) ? 'country' : '' );
    $default_options[ 'booking_billing_state'          ] = ( in_array( 'state',  $fields_matches ) ? 'state' : '' );
    $default_options[ 'booking_billing_post_code'      ] = ( in_array( 'postcode',  $fields_matches ) ? 'postcode' : '' );
    $default_options[ 'booking_billing_phone'          ] = ( in_array( 'phone',  $fields_matches ) ? 'phone' : '' );    
    
    ////////////////////////////////////////////////////////////////////////////
    
    $default_options[ 'booking_is_time_apply_to_cost' ] = 'Off';
    $default_options[ 'booking_paypal_price_period' ] = 'day';                    // This option does not belong only to the PayPal but for all payment systems, that's  why  its here    
    $default_options[ 'booking_cost_currency_format_decimal_number' ]      = 2;
    $default_options[ 'booking_cost_currency_format_decimal_separator' ]   = '.';
    $default_options[ 'booking_cost_currency_format_thousands_separator' ] = 'space';
        
    $default_options[ 'booking_is_show_booking_summary_in_payment_form'] = 'Off';    

    // New //                                                       
    $default_options[ 'booking_payment_description'] = '<p>Dear [name]<br />Please make payment for your booking <strong>[resource_title]</strong> on <strong>[selected_short_dates_hint]</strong>. <br />For reference your booking ID: <strong>[booking_id]</strong></p><p><strong>Booking Details:</strong>[content]</p>';        
    $default_options[ 'booking_currency' ]       = 'USD';
    $default_options[ 'booking_currency_pos' ]   = 'left';
    
    $default_options[ 'booking_gateways_order' ] = 'paypal,authorizenet,sage,bank_transfer,pay_cash,ipay88';
    
    if ( class_exists( 'wpdev_bk_biz_m' ) ) 
        $default_options['booking_advanced_costs_calc_fixed_cost_with_procents'] = 'Off';
    
    return $default_options;
}


/** Activate */
function wpbc_booking_activate_gw() {
    
    $default_options_to_add = wpbc_get_default_options_gw();
    
    foreach ( $default_options_to_add as $default_option_name => $default_option_value ) {
        
        add_bk_option( $default_option_name, $default_option_value );
    }

}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_gw'   );


/** Deactivate */
function wpbc_booking_deactivate_gw() {

    $default_options_to_add = wpbc_get_default_options_gw();
    foreach ( $default_options_to_add as $default_option_name => $default_option_value) {
        
        delete_bk_option( $default_option_name );
    }       
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_gw' );

//                                                                              </editor-fold>


////////////////////////////////////////////////////////////////////////////////
// P A Y M E N T   F O R M
////////////////////////////////////////////////////////////////////////////////

/** Get all Active Payment forms and show them.
 * 
 * @param string $blank - empty  temporary var.
 * @param array $params - , array (
                                              'booking_id'  => $booking_id                      // 9      
                                            , 'cost'        => $summ
                                            , 'resource_id' => $booking_type                    // 4                                          
                                            , 'form'        => $bkform                          // select-one^rangetime4^10:00 - 12:00~text^name4^Jo~text^secondname4^Smith~email^email4^smith@wpbookingcalendar.com~text^phone4^378934753489~text^address4^Baker street 7~text^city4^London~text^postcode4^798787~select-one^country4^GB~select-one^visitors4^1~select-one^children4^0~textarea^details4^test booking ~checkbox^term_and_condition4[]^I Accept term and conditions
                                            , 'nonce'       => $wp_nonce                        // 33962
                                                , 'is_deposit' => $is_deposit                               // Normal Form - true | false
                                                , 'additional_calendars' => $additional_calendars           // Normal Form
                                        )        
 * @return string - payment forms.
 */
function wpbc_get_gateway_forms( $blank, $params ) {
 
    $output = '';


    ////////////////////////////////////////////////////////////////////////////
    // Input Params 
    ////////////////////////////////////////////////////////////////////////////
    $default_param = array (
            'booking_id' => 1                                                   // 9        
            , 'cost' => '0.00'                                                  // 75
            , 'resource_id' => 1                                                // 4                                          
            , 'form' => ''                                                      // select-one^rangetime4^10:00 - 12:00~text^name4^Jo~text^secondname4^Smith~email^email4^smith@wpbookingcalendar.com~text^phone4^378934753489~text^address4^Baker street 7~text^city4^London~text^postcode4^798787~select-one^country4^GB~select-one^visitors4^1~select-one^children4^0~textarea^details4^test booking ~checkbox^term_and_condition4[]^I Accept term and conditions
            , 'nonce' => ''                                                     // 33962
            , 'payment_type' => 'payment_form'                                  // 'payment_request' | 'payment_form'
                , 'is_deposit' => false                                         // false    // exist only for 'payment_form'    ( NOT for the 'payment_request' )
                , 'additional_calendars' => array()                             // array() | array(4=>'03.08.2016, 04.08.2016', [booking resource ID]=>days_input_format,...)- only for 'payment_form'    ( NOT for the 'payment_request' )  
            , 'booking_form_type' => ''                                                                    // 
        );        
    $params = wp_parse_args( $params, $default_param );
    

    make_bk_action('check_multiuser_params_for_client_side', $params['resource_id'] );      // MU
    
    ////////////////////////////////////////////////////////////////////////////
    // Replace Params 
    ////////////////////////////////////////////////////////////////////////////    
//debuge($params);    
    $replace_params = wpbc_get_booking_params( $params['booking_id'], $params['form'], $params['resource_id'] );            // array ( [booking_id] => 9, [dates] => July 3, 2016 14:00 - July 4, 2016 16:00, [check_in_date] => July 3, 2016 14:00,  [check_out_date] => July 4, 2016 16:00,  [dates_count] => 2,  [cost] => 20000.00,  [cost_format] => 20 000,0, ....        
//debuge($replace_params);
                                                                                /** Input parameters adding to the main replace array
                                                                                    Here several important params for Payment forms :        
                                                                                    [__form] => text^selected_short_timedates_hint4^December 30, 2016 10:00 - January 1, 2017 12:00~text^nights_number_hint4^2~text^cost_hint4^515.00~text^deposit_hint4^51.50~text^balance_hint4^463.50~text^original_cost_hint4^500.00~text^additional_cost_hint4^15.00~select-one^rangetime4^10:00 - 12:00~text^name4^John~text^secondname4^Smith~email^email4^smith@wpbookingcalendar.com~text^phone4^123-45-67-8~text^address4^Baker str., 10~text^city4^London~text^postcode4^12345~select-one^country4^GB~select-one^visitors4^1~select-one^children4^0~textarea^details4^Test  booking~checkbox^term_and_condition4[]^I Accept term and conditions
                                                                                    [__nonce] => 33989
                                                                                    [__payment_type] => payment_request
                                                                                    [__is_deposit] => false
                                                                                    [__additional_calendars] => array()            
                                                                                 */
    foreach ( $params as $params_key => $params_value ) {
                
        if ( ! in_array( $params_key, array('cost', 'booking_id', 'resource_id') ) )    //Skip some input parameters, becase they already  exist.
            $replace_params[ '__' . $params_key ] = $params_value;        
    }
 
    
    ////////////////////////////////////////////////////////////////////////////
    // Get Booking Costs
    ////////////////////////////////////////////////////////////////////////////  
   
//debuge($replace_params);    
    // Check for "custom booking form" if we have here default empty  value,  otherwise,  use custom form  name,  that we transfer from biz_s.php file
    if ( empty( $replace_params['__booking_form_type'] ) ){
       $replace_params['__booking_form_type'] =  apply_bk_filter( 'wpbc_get_default_custom_form', 'standard', $replace_params['resource_id'] );
    }
    
    
    if ( class_exists( 'wpdev_bk_biz_m' ) ) {

        $total_cost_of_booking = wpbc_calc_cost_of_booking( 
                                                            array(
                                                                      'form' => $replace_params['__form']
                                                                    , 'days_input_format' => $replace_params['days_input_format']           // 'string' => "30.02.2014, 31.02.2014, 01.03.2014" 
                                                                    , 'resource_id' => $replace_params['resource_id']
                                                                    , 'booking_form_type' => $replace_params['__booking_form_type']
                                                                    , 'payment_cost' => $params['cost']
                                                                    , 'is_check_additional_calendars' => false  // We do  not check  about additional  calendars, 
                                                                                                                // just  calculate cost for specific 1 calendar
                                                                                                                // Because,  we are showing payment forms for each  such  
                                                                                                                // specific calendar separately
                                                                ) 
                                                        );
//debuge( '$total_cost_of_booking', $total_cost_of_booking );   
    } else {                                                                    // Blank data for othere versions.
        
        $total_cost_of_booking = array();
        $total_cost_of_booking['payment_cost']      = $params['cost'];
        $total_cost_of_booking['payment_cost_hint'] = wpbc_cost_show( $params['cost'], array(  'currency' => 'CURRENCY_SYMBOL' ) );      

        $total_cost_of_booking['total_cost']        = $params['cost'];
        $total_cost_of_booking['total_cost_hint']   = $total_cost_of_booking['payment_cost_hint'];
        $total_cost_of_booking['deposit_cost']      = $params['cost'];
        $total_cost_of_booking['deposit_cost_hint'] = $total_cost_of_booking['payment_cost_hint'];
        $total_cost_of_booking['balance_cost']      = 0;
        $total_cost_of_booking['balance_cost_hint'] = wpbc_cost_show( $total_cost_of_booking['balance_cost'], array(  'currency' => 'CURRENCY_SYMBOL' ) );      

        $total_cost_of_booking['original_cost']     = $params['cost'];
        $total_cost_of_booking['original_cost_hint']= $total_cost_of_booking['payment_cost_hint'];
        $total_cost_of_booking['additional_cost']   = 0;
        $total_cost_of_booking['additional_cost_hint'] = wpbc_cost_show( $total_cost_of_booking['additional_cost'], array(  'currency' => 'CURRENCY_SYMBOL' ) );      
    }  
  
                                                                                /** Costs array:
                                                                                        [booking_payment_cost]      => 9
                                                                                        [booking_payment_cost_hint] => 9.00
                                                                                        [booking_total_cost]        => 90
                                                                                        [booking_total_cost_hint]   => 90.00
                                                                                        [booking_deposit_cost]      => 9
                                                                                        [booking_deposit_cost_hint] => 9.00
                                                                                        [booking_balance_cost]      => 81
                                                                                        [booking_balance_cost_hint] => 81.00
                                                                                        [booking_original_cost]         => 75
                                                                                        [booking_original_cost_hint]    => 75.00
                                                                                        [booking_additional_cost]       => 15
                                                                                        [booking_additional_cost_hint]  => 15.00
                                                                                 */
    foreach ( $total_cost_of_booking as $params_key => $params_value ) {
                
        if ( in_array( $params_key, array( 'payment_cost', 'payment_cost_hint', 'additional_description' ) ) ) 
            $replace_params[ $params_key ] = $params_value;
        else
            $replace_params[ 'calc_' . $params_key ] = $params_value;
        
    }
    
    
    ////////////////////////////////////////////////////////////////////////////    
    /** If we are having additional  calendars in the booking form. 
     *  So  here we need to  show cost,  that calculated for single calendar and 
     *  not for all calendars like it set in $replace_params['payment_cost'];
     */
    if ( ! empty( $replace_params['__additional_calendars'] ) ) {
        
        /** We need to open payment form in separate window, is this booking was made togather with other 
         *  in booking form  was used several  calndars from  different booking resources. 
         *  So we are having several  payment forms for each  booked resource. 
         */        
        $replace_params['payment_form_target'] = ' target="_blank" ';
        
        if ( $replace_params['__is_deposit'] ) {
            $replace_params['payment_cost'] = $replace_params['calc_deposit_cost'];
            $replace_params['payment_cost_hint'] = wpbc_cost_show( $replace_params['calc_deposit_cost'], array(  'currency' => 'CURRENCY_SYMBOL' ) );
        } else {
            $replace_params['payment_cost'] = $replace_params['calc_total_cost'];
            $replace_params['payment_cost_hint'] = wpbc_cost_show( $replace_params['calc_total_cost'], array(  'currency' => 'CURRENCY_SYMBOL' ) );
        }
    } else {
     
        $replace_params['payment_form_target'] = '';   
    }    
    
    
    //Replace currensy symbol to CURRENCY_SYMBOL
    $cur_sym = wpbc_get_currency_symbol();
    foreach ( $replace_params as $replace_params_key => $replace_params_value ) {
        $replace_params[ $replace_params_key ] = str_replace( $cur_sym, 'CURRENCY_SYMBOL', $replace_params_value );
    }
    
    ////////////////////////////////////////////////////////////////////////////
    
    $payment_varriants = array(); 
    
    if (   ( class_exists( 'wpdev_bk_biz_m' ) ) && ( WP_BK_SHOW_DEPOSIT_AND_TOTAL_PAYMENT ) && ( $replace_params[ '__is_deposit' ] )   ){

        /*  TODO: need to improve here!
        Show both deposit and total cost payment forms, after visitor submit booking. 
        Important! Please note, in this case at admin panel for booking will be saved deposit cost and notes about deposit, 
        do not depend from the visitor choise of this payment. So you need to check each such payment manually.
        */
        
        // Total cost
        $payment_varriants[] = $replace_params;
        
        $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'cost_in_gateway' ]        = $replace_params['calc_total_cost'];
        $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'cost_in_gateway_hint' ]   = $replace_params['calc_total_cost_hint'];
        $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'is_deposit' ]             = false;
        $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'gateway_hint' ]           = __('Total' , 'booking');
    } ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Deposit or Total or Balance
    $payment_varriants[] = $replace_params;
    $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'cost_in_gateway' ]         = $replace_params['payment_cost'];
    $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'cost_in_gateway_hint' ]    = $replace_params['payment_cost_hint'];
    $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'is_deposit' ]              = $replace_params['__is_deposit'];
    
    
    ////////////////////////////////////////////////////////////////////////////
    // Title  - for gateway BTN
    ////////////////////////////////////////////////////////////////////////////
    if ( $replace_params['__payment_type'] == 'payment_form' ) {                // Payment   F o r m
        
        if ( $replace_params['__is_deposit'] )  
            $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'gateway_hint' ] = __('Deposit' , 'booking');
        else                                    
            $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'gateway_hint' ] = __('Total' , 'booking');
        
    } else {                                                                    // Payment   R e q u e s t                 $replace_params['__payment_type'] == 'payment_request'        
        $payment_varriants[ ( count( $payment_varriants ) - 1 ) ][ 'gateway_hint' ] = __('Amount to pay' , 'booking');
    }
    
    
    // Get correct  order of gateways
    $gateways_order = get_bk_option( 'booking_gateways_order' );
    $gateways_order = explode( ',', $gateways_order );

//debuge( '$payment_varriants', $payment_varriants );  
    ////////////////////////////////////////////////////////////////////////////
    // Show payment forms for TOTAL cost and maybe for DESPOSIT 
    ////////////////////////////////////////////////////////////////////////////    
    foreach ( $payment_varriants as $payment_varriant ) {                       // Despoit or Total ...
            
        foreach ( $gateways_order as $gateway_id) {                                                 // Order of Gateways ...
            $output .= apply_filters( 'wpbc_get_gateway_payment_form', '', $payment_varriant, $gateway_id );
        }        
    }       
    
    // We need to  replace ' symbols because in usual payment form, we assign this output to  JavaScript string: ....innerHTML = '<div class=\"wpdevelop\" style=\"height:auto;margin:20px 0px;\" >?php echo $output; ?</div>';
    $output = str_replace("'",'"',$output);
    $output = str_replace('\"','"',$output);


     
    $is_show_booking_summary_in_payment_form = get_bk_option( 'booking_is_show_booking_summary_in_payment_form'  );

    if ( $is_show_booking_summary_in_payment_form == 'On' ) {
        
        if (  ( ! empty( $replace_params['__additional_calendars'] ) ) && ( isset( $replace_params['__additional_calendars'][ $replace_params['resource_id'] ] ) )  ) {
            /** Payment description  that  is showing above payment form of additional calendars (booking resources), like [calendar id=4]
             * This payment descriptin is showing above payment form
             */
            $payment_description = sprintf( __('Please make payment for your booking %s on %s For reference your booking ID: %s', 'booking')
                                            , '<strong>[resource_title]</strong>', '<strong>[selected_short_dates_hint]</strong>.<br/>', '<strong>[booking_id]</strong>' );
            $payment_description .= '<div class="clear"></div>';
        } else {        
            $payment_description = get_bk_option( 'booking_payment_description' );        
        }
        
        
        $payment_description = apply_bk_filter('wpdev_check_for_active_language',  $payment_description );   
//debuge($payment_description, $replace_params);        
        $payment_description_show = wpbc_replace_booking_shortcodes( $payment_description, $replace_params );
//debuge($payment_description_show);    

        if ( floatval( $params['cost'] ) > 0 )
            $output = $payment_description_show . $output ;
        else 
            $output = $payment_description_show ;
    }

//debuge($output);    
//debuge($replace_params);    
    make_bk_action('finish_check_multiuser_params_for_client_side', $params['resource_id'] );       // MU
    
    return $output;    
}
add_bk_filter( 'wpbc_get_gateway_forms', 'wpbc_get_gateway_forms' );


/** Check if All payment Gateways Off,  or some gateways are active
 * 
 * @param boolean $blank - initial value = true
 * @return boolean
 * 
 * Example:
 * $is_turned_off = apply_bk_filter('is_all_payment_forms_off', true);
 */
function wpbc_is_all_payment_forms_off( $blank ) {

    $gateways_states = apply_filters( 'wpbc_is_all_gateways_on', '' );    
    
    $gateways_states = str_replace( 'Off', '', $gateways_states );
    
    if ( $gateways_states == '' ) 
        return true;
    else
        return false;

}
add_bk_filter('is_all_payment_forms_off', 'wpbc_is_all_payment_forms_off');


//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Load Gateways Files " >    

////////////////////////////////////////////////////////////////////////////////
// Gateways Loading
////////////////////////////////////////////////////////////////////////////////

/** Load Registered Gateways */
function wpbc_load_payment_gateways_files() {
    
    
    $booking_gateways_original = 'paypal,authorizenet,sage,bank_transfer,pay_cash,ipay88';     // Default Original Payment Gateways
    
    $booking_gateways_original = apply_filters( 'wpbc_gateways_original_id_list', $booking_gateways_original ); // For ability to ADD new custom gateway  and load it
    //
    //API for Adding new gateways:  function add_my_gateway( $gateway ){ return $gateway . ',gateway_ID'; } add_filters( 'wpbc_gateways_original_id_list', 'add_my_gateway' ); 
    
    $booking_gateways_order = get_bk_option( 'booking_gateways_order' );
    
//debuge($booking_gateways_order  );    

    if ( empty( $booking_gateways_order ) )
        $booking_gateways_order = $booking_gateways_original;
    $booking_gateways_order = explode( ',', $booking_gateways_order );

    // Check  if some Original Booking Calendar Gateway was not loaded,  so  load it.
    $booking_gateways_original = explode( ',', $booking_gateways_original );
    foreach ( $booking_gateways_original as $original_gateway ) {
        if ( ! in_array( $original_gateway, $booking_gateways_order ) )
            $booking_gateways_order[] = $original_gateway;
    }
    
    
    foreach ( $booking_gateways_order as $gw_id ) {
        if ( ! empty($gw_id ) ) {
            $gw_id = wp_kses_post( trim( stripslashes( $gw_id ) ) );
            if ( file_exists( WPBC_PLUGIN_DIR . '/inc/gateways/'. $gw_id . '/wpbc-gw-' . $gw_id .'.php' )  )
                require_once( WPBC_PLUGIN_DIR . '/inc/gateways/'. $gw_id . '/wpbc-gw-' . $gw_id .'.php' ); 
        }
    }       
}

//                                                                              </editor-fold>
//wpbc_load_payment_gateways_files();

/** We load gateways files after "plugins_loaded" hook, because
 * its required for ability to load file with "wp_get_current_user" function  for getting info  about current user
 * and ability to load correctly options get_bk_option( 'booking_gateways_order' ) relative to  specific 
 * user  in   Booking Calendar MultiUser version version.
 * 
 * Basically its just for ability to work  with  get_bk_option( ...
 */
add_action( 'plugins_loaded', 'wpbc_load_payment_gateways_files' );             

add_bk_action( 'wpbc_before_activation' , 'wpbc_load_payment_gateways_files' );

//debuge( ' (' . wpbc_cost_show( '99.99', array( 'cost_format' => wpbc_get_cost_format( 'left' ) , 'currency' => wpbc_get_currency() )  ) . ')' );


// TODO: Show warning messages near Gateways currences,  if its different from  the main  currency  settings.

// TODO: Set  target="_blank" to the payment form  if we are showing payment forms for several  additional  calendars