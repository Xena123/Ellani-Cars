<?php
/**
 * @version     1.0
 * @package     Booking Calendar
 * @category    A c t i v a t e    &    D e a c t i v a t e
 * @author      wpdevelop
 *
 * @web-site    http://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-02-28
 * 
 * This is COMMERCIAL SCRIPT
 * We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

 
/** A c t i v a t e */
function wpbc_booking_activate_s() {
    
    
    ////////////////////////////////////////////////////////////////////////////
    // DB Tables
    ////////////////////////////////////////////////////////////////////////////    
    if ( true ) {
        global $wpdb;
        if  (wpbc_is_field_in_table_exists('bookingtypes','cost') == 0){
            $simple_sql = "ALTER TABLE {$wpdb->prefix}bookingtypes ADD cost VARCHAR(100) NOT NULL DEFAULT '0'";
            $wpdb->query( $simple_sql );
            $wpdb->query( "UPDATE {$wpdb->prefix}bookingtypes SET cost = '25'" );
        }
        if  (wpbc_is_field_in_table_exists('booking','cost') == 0){ 
            $simple_sql = "ALTER TABLE {$wpdb->prefix}booking ADD cost FLOAT(15,2) NOT NULL DEFAULT 0.00";
            $wpdb->query( $simple_sql );
        }
        if  (wpbc_is_field_in_table_exists('booking','pay_status') == 0){ 
            $simple_sql = "ALTER TABLE {$wpdb->prefix}booking ADD pay_status VARCHAR(200) NOT NULL DEFAULT ''";
            $wpdb->query( $simple_sql );
        }
        if  (wpbc_is_field_in_table_exists('booking','pay_request') == 0){ 
            $simple_sql = "ALTER TABLE {$wpdb->prefix}booking ADD pay_request SMALLINT(3) NOT NULL DEFAULT 0";
            $wpdb->query( $simple_sql );
        }    
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    // Update already exist options 
    ////////////////////////////////////////////////////////////////////////////    
    update_bk_option( 'booking_skin',  '/inc/skins/premium-marine.css');

    ////////////////////////////////////////////////////////////////////////////
    // Demos
    ////////////////////////////////////////////////////////////////////////////
    if ( wpbc_is_this_demo() ) {
        update_bk_option( 'booking_form', str_replace('\\n\\','', wpbc_get_default_booking_form() ) );
        update_bk_option( 'booking_form_show', str_replace('\\n\\','', wpbc_get_default_booking_form_show() ) );        
        update_bk_option( 'booking_skin',  '/inc/skins/premium-steel.css');
        update_bk_option( 'booking_is_use_captcha' , 'Off' );
        update_bk_option( 'booking_is_show_legend' , 'On' );
        update_bk_option( 'booking_type_of_day_selections' , 'single' );
        update_bk_option( 'booking_billing_customer_email'  , 'email' );
        update_bk_option( 'booking_billing_firstnames'      , 'name' );
        update_bk_option( 'booking_billing_surname'         , 'secondname' );
        update_bk_option( 'booking_billing_address1'        , 'address' );
        update_bk_option( 'booking_billing_city'            , 'city' );
        update_bk_option( 'booking_billing_country'         , 'country' );
        update_bk_option( 'booking_billing_state'           , 'country' );
        update_bk_option( 'booking_billing_post_code'       , 'postcode' );
        update_bk_option( 'booking_billing_phone'           , 'phone' );        
        update_bk_option( 'booking_view_days_num','7');
        update_bk_option( 'booking_paypal_return_url', '/successful' );
        update_bk_option( 'booking_paypal_cancel_return_url',  '/failed' );
        update_bk_option( 'booking_sage_order_successful', '/successful' );
        update_bk_option( 'booking_sage_order_failed',  '/failed' );
        update_bk_option( 'booking_sage_is_auto_approve_cancell_booking' , 'On' );
        update_bk_option( 'booking_time_format' , 'g:i a' );                      
        /*
            update_bk_option( 'booking_sage_vendor_name', 'wpdevelop' );        //  FixIn: 5.4.2 
            update_bk_option( 'booking_sage_encryption_password', 'FfCDQjLiM524VtE7' );
            update_bk_option( 'booking_sage_curency', 'USD' );
            update_bk_option( 'booking_sage_transaction_type', 'PAYMENT' );
            update_bk_option( 'booking_sage_is_active', 'On' );
        */        
        
        
        $wpdb->query( "UPDATE {$wpdb->prefix}bookingtypes SET cost = '30' WHERE 	booking_type_id=1" );
        $wpdb->query( "UPDATE {$wpdb->prefix}bookingtypes SET cost = '35' WHERE 	booking_type_id=2" );
        $wpdb->query( "UPDATE {$wpdb->prefix}bookingtypes SET cost = '40' WHERE 	booking_type_id=3" );
        $wpdb->query( "UPDATE {$wpdb->prefix}bookingtypes SET cost = '50' WHERE 	booking_type_id=4" );
        $wp_queries = array();
        $wp_queries[] = $wpdb->prepare("UPDATE {$wpdb->prefix}bookingtypes SET title = %s WHERE title = %s ;", __('Resource #1' ,'booking'), __('Apartment#1' ,'booking') );
        $wp_queries[] = $wpdb->prepare("UPDATE {$wpdb->prefix}bookingtypes SET title = %s WHERE title = %s ;", __('Resource #2' ,'booking'), __('Apartment#2' ,'booking') );
        $wp_queries[] = $wpdb->prepare("UPDATE {$wpdb->prefix}bookingtypes SET title = %s WHERE title = %s ;", __('Resource #3' ,'booking'), __('Apartment#3' ,'booking') );
        foreach ($wp_queries as $wp_q) $wpdb->query( $wp_q );
    }
    
}
add_bk_action( 'wpbc_other_versions_activation',   'wpbc_booking_activate_s'   );



/** D e a c t i v a t e */
function wpbc_booking_deactivate_s() {
    
    ////////////////////////////////////////////////////////////////////////////
    // DB Tables
    ////////////////////////////////////////////////////////////////////////////
    // global $wpdb;
    
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_booking_deactivate_s' );