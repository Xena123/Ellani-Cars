<?php /**
 * @version 1.0
 * @package Booking Calendar 
 * @category JavaScript files and varibales
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 19.10.2015
 */

class WPBC_JS extends WPBC_JS_CSS {
    
    public function define() {
        
        $this->setType('js');
        
        /*
        $this->add( array(
                            'handle' => 'wpbc-datepick',
                            'src' => wpbc_plugin_url( '/js/datepick/jquery.datepick.js'), 
                            'deps' => array( 'wpbc-global-vars' ),
                            'version' => '1.1',
                            'where_to_load' => array( 'admin', 'client' ),                //Usage: array( 'admin', 'client' )
                            'condition' => false    
                  ) );        
        */
    }

    /** Enqueue Files and Varibales. 
     *  Useful in case, if we use get_options and current user functions...
     * 
     * @param type $where_to_load
     */
    public function enqueue( $where_to_load ) {
        
        wpbc_js_load_vars(  $where_to_load );
        
        // Define JavaScript varibales in all other files
        do_action( 'wpbc_define_js_vars', $where_to_load );                         

        wpbc_js_load_libs(  $where_to_load );
        wpbc_js_load_files( $where_to_load );
        
        if ( wpbc_is_new_booking_page() )   
            $where_to_load = 'both';
        
        // Load JavaScript files in all other versions
        do_action( 'wpbc_enqueue_js_files', $where_to_load );                     
    }

    /** Deregister  some conflict  scripts from  other plugins.
     * 
     * @param type $where_to_load
     */
    public function remove_conflicts( $where_to_load ) {
        
        if ( wpbc_is_bookings_page() ) {
            if (function_exists('wp_dequeue_script')) {
                
                //wp_dequeue_script( 'jquery.cookie' );
                //wp_dequeue_script( 'jquery-interdependencies' );
                wp_dequeue_script( 'chosen' );
                wp_dequeue_script( 'cs-framework' );
                wp_dequeue_script( 'cgmp-jquery-tools-tooltip' );                               // Remove this script jquery.tools.tooltip.min.js, which is load by the "Comprehensive Google Map Plugin"
            }
        }        
                        
    }
}



/** Define JavaScript Varibales */
function wpbc_js_load_vars( $where_to_load ) {
    
    ////////////////////////////////////////////////////////////////////////////
    // JavaScripts Variables               
    ////////////////////////////////////////////////////////////////////////////
      
    wp_enqueue_script( 'wpbc-global-vars', wpbc_plugin_url( '/js/wpbc_vars.js' ), array( 'jquery' ), '1.1' );        // Blank JS File 
        
    wp_localize_script( 'wpbc-global-vars'
                      , 'wpbc_global1', array(
          'wpbc_ajaxurl'                        => admin_url( 'admin-ajax.php' )
        , 'wpdev_bk_plugin_url'                 => plugins_url( '' , WPBC_FILE )                                                     
        , 'wpdev_bk_today'       => '['     . intval(date_i18n('Y'))            //FixIn:6.1
                                        .','. intval(date_i18n('m')) 
                                        .','. intval(date_i18n('d'))
                                        .','. intval(date_i18n('H'))
                                        .','. intval(date_i18n('i'))
                                    .']'
        , 'visible_booking_id_on_page'          => '[]'
        , 'booking_max_monthes_in_calendar'     => get_bk_option( 'booking_max_monthes_in_calendar')
        , 'user_unavilable_days'                => '['. ( ( get_bk_option( 'booking_unavailable_day0') == 'On' ) ? '0,' : '' )
                                                    . ( ( get_bk_option( 'booking_unavailable_day1') == 'On' ) ? '1,' : '' )
                                                    . ( ( get_bk_option( 'booking_unavailable_day2') == 'On' ) ? '2,' : '' )
                                                    . ( ( get_bk_option( 'booking_unavailable_day3') == 'On' ) ? '3,' : '' )
                                                    . ( ( get_bk_option( 'booking_unavailable_day4') == 'On' ) ? '4,' : '' )
                                                    . ( ( get_bk_option( 'booking_unavailable_day5') == 'On' ) ? '5,' : '' )
                                                    . ( ( get_bk_option( 'booking_unavailable_day6') == 'On' ) ? '6,' : '' )
                                                    .'999]' // 999 - blank day, which will not impact  to the checking of the week days. Required for correct creation of this array.
        , 'wpdev_bk_edit_id_hash'               => ( ( isset( $_GET['booking_hash'] ) ) ? $_GET['booking_hash'] : '' )
        , 'wpdev_bk_plugin_filename'            => WPBC_PLUGIN_FILENAME 
        , 'bk_days_selection_mode'              => ( ( get_bk_option('booking_type_of_day_selections') == 'range' ) ? get_bk_option('booking_range_selection_type') : get_bk_option( 'booking_type_of_day_selections') )     /* {'single', 'multiple', 'fixed', 'dynamic'} */
        , 'wpdev_bk_personal'                   => ( ( class_exists('wpdev_bk_personal') ) ? '1' : '0' )
        , 'block_some_dates_from_today'         => get_bk_option('booking_unavailable_days_num_from_today') 
        , 'message_verif_requred'               => esc_js(__('This field is required' ,'booking'))
        , 'message_verif_requred_for_check_box' => esc_js(__('This checkbox must be checked' ,'booking'))
        , 'message_verif_requred_for_radio_box' => esc_js(__('At least one option must be selected' ,'booking'))
        , 'message_verif_emeil'                 => esc_js(__('Incorrect email field' ,'booking'))
        , 'message_verif_same_emeil'            => esc_js(__('Your emails do not match' ,'booking'))          // Email Addresses Do Not Match
        , 'message_verif_selectdts'             =>  esc_js(__('Please, select booking date(s) at Calendar.' ,'booking'))
        , 'parent_booking_resources'            => '[]'
        , 'new_booking_title'                   => esc_js( apply_bk_filter('wpdev_check_for_active_language', get_bk_option( 'booking_title_after_reservation' ) ) )
        , 'new_booking_title_time'              => get_bk_option('booking_title_after_reservation_time')
        , 'type_of_thank_you_message'           => esc_js( get_bk_option( 'booking_type_of_thank_you_message' ) )        
        , 'thank_you_page_URL'                  => wpbc_make_link_absolute( apply_bk_filter('wpdev_check_for_active_language', get_bk_option( 'booking_thank_you_page_URL' ) ) )        
        , 'is_am_pm_inside_time'                => ( ( (strpos(get_bk_option('booking_time_format'), 'a')!== false) || (strpos(get_bk_option('booking_time_format'), 'A')!== false) ) ?  'true': 'false' )
        , 'is_booking_used_check_in_out_time'   => 'false'
        , 'wpbc_active_locale'                  => wpbc_get_booking_locale()  
        , 'wpbc_message_processing'             => esc_js( __('Processing' ,'booking') )
        , 'wpbc_message_deleting'               => esc_js( __('Deleting' ,'booking') )
        , 'wpbc_message_updating'               => esc_js( __('Updating' ,'booking') )
        , 'wpbc_message_saving'                 => esc_js( __('Saving' ,'booking') )
    ));
        
}


/** Default JavaScripts Libraries */
function wpbc_js_load_libs( $where_to_load ) {
    
    // jQuery  
    wp_enqueue_script( 'jquery' );

    $version = wpbc_get_registered_jquery_version();

    if ( $version !== false ) {
        
        if ( version_compare( $version, '1.7.1', '<' ) ) {                      // load jQuery 1.7.1, if "Theme" load older jQuery
            wp_deregister_script('jquery');
            wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.7.1.min.js', false, '1.7.1' );   
            // wp_register_script('jquery', 'http://code.jquery.com/jquery-latest.min.js', false, false);                
            wp_enqueue_script('jquery');
        }

        ////////////////////////////////////////////////////////////////////////
        // jQuery Migrate 
        if ( version_compare( $version, '1.9', '>=' ) ) {                       // if the jQuery newer then 1.9
            wp_register_script('jquery-migrate', 'http://code.jquery.com/jquery-migrate-1.0.0.js', false, '1.0.0' );
            wp_enqueue_script( 'jquery-migrate' );
        }
    }
    
    
    // Default Admin Libs 
    if (     ( $where_to_load == 'admin' ) 
         // || (  is_admin() && ( defined( 'DOING_AJAX' ) ) && ( DOING_AJAX )  )
        ) {
        
        wp_enqueue_style(  'wp-color-picker' );                                 // Color Picker
        wp_enqueue_script( 'wp-color-picker' ); 
        wp_enqueue_script( 'jquery-ui-sortable' );                              // UI Sortable
//        if ( wpbc_is_bookings_page()  )
//            wp_enqueue_script( 'jquery-ui-dialog' );                            // UI Dialog -  for payment request dialog                                     
    }   
    
}


/** Load JavaScript Files */
function wpbc_js_load_files( $where_to_load ) {
    
    // Bootstrap 
    if (     (  (   is_admin() ) && ( get_bk_option( 'booking_is_not_load_bs_script_in_admin' )  !== 'On')  ) 
         ||  (  ( ! is_admin() ) && ( get_bk_option( 'booking_is_not_load_bs_script_in_client' ) !== 'On' )  )
       ) {
        wp_enqueue_script( 'wpdevelop-bootstrap', wpbc_plugin_url( '/assets/libs/bootstrap/js/bootstrap.js' ), array( 'wpbc-global-vars' ), '3.3.5.1');
    }
     
    // Datepicker    
    wp_enqueue_script( 'wpbc-datepick', wpbc_plugin_url( '/js/datepick/jquery.datepick.js'), array( 'wpbc-global-vars' ), '1.1');

    // Localization
    $calendar_localization_url = wpbc_get_calendar_localization_url();
    if ( ! empty( $calendar_localization_url ) )
        wp_enqueue_script( 'wpbc-datepick-localize', $calendar_localization_url, array( 'wpbc-datepick' ), '1.1');
    //wpbc_load_calendar_localization_file();
                
    if (  ( $where_to_load == 'client' ) || ( wpbc_is_new_booking_page()  )   ) {
        
        // Client
        wp_enqueue_script( 'wpbc-main-client', wpbc_plugin_url( '/js/client.js'), array( 'wpbc-datepick' ), '1.1');
    }
    
    if ( $where_to_load == 'admin' ) {
        
        // Admin
        wp_enqueue_script( 'wpbc-admin-main',    wpbc_plugin_url( '/js/admin.js'), array( 'wpbc-global-vars' ), '1.1');
        wp_enqueue_script( 'wpbc-admin-support', wpbc_plugin_url( '/core/any/js/admin-support.js'), array( 'wpbc-global-vars' ), '1.1');
    
        // Chosen Library    
        wp_enqueue_script( 'wpbc-chosen', wpbc_plugin_url( '/assets/libs/chosen/chosen.jquery.min.js'), array( 'wpbc-global-vars' ), '1.1' );    
    }    
        
}



////////////////////////////////////////////////////////////////////////////////
//  Support JavaScript functions
////////////////////////////////////////////////////////////////////////////////

/** Load Datepicker Localization JS File */
/*
function wpbc_load_calendar_localization_file() {
    
    // Datepicker Localization - translation for calendar.                      Example:    $locale = 'fr_FR';   
    $locale = wpbc_get_booking_locale();                                              
    if ( ! empty( $locale ) ) {

        $locale_lang    = substr( $locale, 0, 2 ); 
        $locale_country = substr( $locale, 3 );

        if (   ( $locale_lang !== 'en') && ( wpbc_is_file_exist( '/js/datepick/jquery.datepick-' . $locale_lang . '.js' ) )   ) { 
            
                wp_enqueue_script( 'wpbc-datepick-localize', wpbc_plugin_url( '/js/datepick/jquery.datepick-'. $locale_lang . '.js' ), array( 'wpbc-datepick' ), '1.1');

        } else if (   ( ! in_array( $locale, array( 'en_US', 'en_CA', 'en_GB', 'en_AU' ) )   )                                      // English Exceptions 
                   && ( wpbc_is_file_exist( '/js/datepick/jquery.datepick-'. $locale_country . '.js' ) ) 
        ) { 

                wp_enqueue_script( 'wpbc-datepick-localize', wpbc_plugin_url( '/js/datepick/jquery.datepick-'. $locale_country . '.js' ), array( 'wpbc-datepick' ), '1.1');                
        }          
    }
}*/


/** Get URL Datepicker Localization JS File 
 * 
 * @return string - URL to  calendar skin
 */
function wpbc_get_calendar_localization_url() {
    // Datepicker Localization - translation for calendar.                      Example:    $locale = 'fr_FR';   
    $locale = wpbc_get_booking_locale();                                              
    
    $calendar_localization_url = false;
    
    if ( ! empty( $locale ) ) {

        $locale_lang    = substr( $locale, 0, 2 ); 
        $locale_country = substr( $locale, 3 );

        if (   ( $locale_lang !== 'en') && ( wpbc_is_file_exist( '/js/datepick/jquery.datepick-' . $locale_lang . '.js' ) )   ) { 
            
                $calendar_localization_url = wpbc_plugin_url( '/js/datepick/jquery.datepick-'. $locale_lang . '.js' );

        } else if (   ( ! in_array( $locale, array( 'en_US', 'en_CA', 'en_GB', 'en_AU' ) )   )                                      // English Exceptions 
                   && ( wpbc_is_file_exist( '/js/datepick/jquery.datepick-'. $locale_country . '.js' ) ) 
        ) { 

                $calendar_localization_url = wpbc_plugin_url( '/js/datepick/jquery.datepick-'. $locale_country . '.js' );                
        }          
    } 
    
    return $calendar_localization_url;
}


/** Get Registred jQuery version
 * 
 * @global type $wp_scripts
 * @return string - jQuery version
 */
function wpbc_get_registered_jquery_version() {
    global $wp_scripts;
    
    $version = false;
    
    if (  is_a( $wp_scripts, 'WP_Scripts' ) ) 
        if (isset( $wp_scripts->registered['jquery'] )) 
            $version = $wp_scripts->registered['jquery']->ver;
    return $version;
}


/** Check if we activated loading of JS/CSS only on specific pages and then load or no it
 * 
 * @param boolean $is_load_scripts  - Default: true
 * @return boolean                  - true | false
 */
function wpbc_is_load_css_js_on_client_page( $is_load_scripts ) {
    
    if ( ! is_admin() ) {           // Check  on Client side only
        
        $booking_is_load_js_css_on_specific_pages = get_bk_option( 'booking_is_load_js_css_on_specific_pages'  );
        if ( $booking_is_load_js_css_on_specific_pages == 'On' ) {
            
            $booking_pages_for_load_js_css = get_bk_option( 'booking_pages_for_load_js_css' );

            $booking_pages_for_load_js_css = preg_split('/[\r\n]+/', $booking_pages_for_load_js_css, -1, PREG_SPLIT_NO_EMPTY);

            $request_uri = $_SERVER['REQUEST_URI'];                                 // FixIn:5.4.1
            if ( strpos( $request_uri, 'booking_hash=') !== false ) {
                $request_uri = parse_url($request_uri);
                if (  ( ! empty($request_uri ) ) && ( isset($request_uri['path'] ) )  ){
                    $request_uri = $request_uri['path'];
                } else {
                    $request_uri = $_SERVER['REQUEST_URI'];
                }
            }

            if (  ( ! empty($booking_pages_for_load_js_css ) ) && ( ! in_array( $request_uri, $booking_pages_for_load_js_css ) )  )
                    return false;
        }
    }
    return true;
}
add_filter( 'wpbc_is_load_script_on_this_page', 'wpbc_is_load_css_js_on_client_page' );
