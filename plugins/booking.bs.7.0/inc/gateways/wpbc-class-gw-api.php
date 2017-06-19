<?php
/**
 * @version 1.0
 * @package Payment Gateway API Class
 * @category Payment Gateway
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-07-02
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

//                                                                              <editor-fold   defaultstate="collapsed"   desc=" Gateway API " >

/** API  for  Payment Gateway  */
abstract class WPBC_Gateway_API extends WPBC_Settings_API  {                     



    /** Settings API Constructor
     *  During creation,  system try to load values from DB, if exist.
     * 
     * @param type $id - "Pure Name"
     */
    public function __construct( $id,  $init_fields_values = array(), $options = array() ) {

        
        $default_options = array( 
                        'db_prefix_option' => 'booking_' 
                      , 'db_saving_type'   => 'separate_prefix'                 // { 'togather' (Default), 'separate', 'separate_prefix' } 
                      , 'is_automatic_activation_deactivation' => false
            );                 
                                                                                // separate_prefix: update_bk_option( $this->options['db_prefix_option'] . $settings_id . '_' . $field_name , $value );
        $options = wp_parse_args( $options, $default_options );
        
        // HOOKS for definition  statuses of specific payment Gateway
        add_filter( 'wpbc_add_payment_status_ok',       array( $this, 'add_payment_status_ok' ) );
        add_filter( 'wpbc_add_payment_status_pending',  array( $this, 'add_payment_status_pending' ) ); 
        add_filter( 'wpbc_add_payment_status_unknown',  array( $this, 'add_payment_status_unknown' ) ); 
        add_filter( 'wpbc_add_payment_status_error',    array( $this, 'add_payment_status_error' ) ); 

        if ( $options['is_automatic_activation_deactivation'] ) {
            
            // Activate
            add_bk_action( 'wpbc_other_versions_activation',   array( $this, 'activate'   ) );

            // Deactivate
            add_bk_action( 'wpbc_other_versions_deactivation', array( $this, 'deactivate' ) );
        }
    
        /** These 2 hooks from  the wpbc-response file
        *  Executed to Update payment status field in DataBase,
        *  and Then approve or decline specific booking if this feature activated
        *  depend from  the status od payment. And redirect  to Success or Failed payment page.
        */                
        
        add_filter( 'wpbc_check_response_status', array( $this, 'update_payment_status__after_response' ), 10, 5 );                                  // Update payment status with gateways specific status
                                                                                                                                                    // or 
        add_filter( 'wpbc_check_response_status_with_crypted_paramaters', array( $this, 'update_payment_status_with_crypted_paramaters' ), 10, 5); // Update Payment status whensending with  crypted parameter - for exmaple in authorize.net payment system
        
        add_bk_action(  'wpbc_auto_approve_or_cancell_and_redirect', array( $this, 'auto_approve_or_cancell_and_redirect' ) );

        
        add_filter( 'wpbc_is_all_gateways_on', array( $this, 'wpbc_is_all_gateways_on' ) );
        add_filter( 'wpbc_get_all_gateways_info', array( $this, 'wpbc_get_all_gateways_info' ) );

        parent::__construct( $id, $options, $init_fields_values );              // Define ID of Setting page and options                
    }

    
    ////////////////////////////////////////////////////////////////////////////
    //  A b s t r a c t
    ////////////////////////////////////////////////////////////////////////////
    
    /** Get Payment Form
     * @param string $output    - other active payment forms
     * @param array $params     - Array of input params     //  $param = array (
                                                                                'booking_id' => 1                 // 9        
                                                                                    , 'cost' => '0.00'            // 75
                                                                                    , 'title' => ''               // stdClass Object ( [title] => Apartment#3 [cost] => 25 )
                                                                                    , 'days' => ''                // 21.07.2016, 22.07.2016, 20.07.2016
                                                                                , 'resource_id' => 1              // 4                                          
                                                                                , 'form' => ''                    // select-one^rangetime4^10:00 - 12:00~text^name4^Jo~text^secondname4^Smith~email^email4^smith@wpbookingcalendar.com~text^phone4^378934753489~text^address4^Baker street 7~text^city4^London~text^postcode4^798787~select-one^country4^GB~select-one^visitors4^1~select-one^children4^0~textarea^details4^test booking ~checkbox^term_and_condition4[]^I Accept term and conditions
                                                                                , 'nonce' => ''                   // 33962
                                                                                , 'is_deposit' => false           // false
                                                                );
     * @param string $gateway_id - ID of gateway,  that  must  show right now. if its not actaul gateway,  then  skip it.
     * @param string $output - other active payment forms
     * @return string        - you must  return  in format: return $output . $your_payment_form_content
     */
    abstract public function get_payment_form( $output, $params, $gateway_id = '' ); 
    
    
    /** Get List  of Payment statuses for this specific payment system
     * 
     *  Example:
                return array(
                                'ok'        => array(  'PayPal:OK'  )
                                , 'pending' => array()
                                , 'unknown' => array()
                                , 'error'   => array(  'PayPal:Failed'  )
                            ); 
     */    
    abstract public function get_payment_status_array();

    
    /** Return info about Gateway
     * 
     * @return array        Example: array(
                                            'id'      => 'paypal
                                          , 'title'   => 'Paypal Standard'
                                          , 'currency'   => 'USD'
                                          , 'enabled' => true
                                        );        
     */    
    abstract public function get_gateway_info();
    

    /** Check State of Gateway
     * 
     * @return bool
     */
    public function is_gateway_on() {
        
        $op_prefix = 'booking_' . $this->get_id() . '_';
        
        $is_active = get_bk_option( $op_prefix . 'is_active' );        
        
        if ( $is_active == 'On' )        
            return true;
        else
            return false;        
    }

    
    /** Check State of all Gateways
     * 
     * @param string $prefix_other_gw_states
     * @return string 'On' | 'Off'
     * 
     * In case if we are using filters hook,  so all payment gateways will  return  value like this 'OffOffOff' | 'OffOnOffOff' | 'OnOnOnOn',  etc...
     * 
     * Example of usage:
     * 
        $gateways_states = apply_filters( 'wpbc_is_all_gateways_on', '' );    

        $gateways_states = str_replace( 'Off', '', $gateways_states );

        if ( $gateways_states == '' ) 
     */
    public function wpbc_is_all_gateways_on( $prefix_other_gw_states = '' ) {

        $is_active = $this->is_gateway_on();

        if ( $is_active ) 
            $is_active = 'On';
        else
            $is_active = 'Off';
                
        
        return $prefix_other_gw_states . $is_active;        
        
    }
    
    
    /** Get info about ALL gateways
     * 
     * @return array        Example: array( 
     *                                      'paypal'=> array(
                                                            'id'      => 'paypal'
                                                          , 'title'   => 'Paypal Standard'
                                                          , 'currency'   => 'USD'
                                                          , 'enabled' => true
                                                        ),
                                            'sage' => ...
                                        );        
        Example of usage:
      
        $all_gateways_info = apply_filters( 'wpbc_get_all_gateways_info', array() );    
     */
    public function wpbc_get_all_gateways_info( $all_gateways_info = array() ) {

        $current_gateway_info = $this->get_gateway_info();
                
        if ( isset( $current_gateway_info['id'] ) )
            $all_gateways_info[ $current_gateway_info['id'] ] = $current_gateway_info;
        
        return $all_gateways_info;        
        
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    //   R E S P O N S E     
    ////////////////////////////////////////////////////////////////////////////
    
    /** (Sometimes must be Overriden in gateway file)  -- Update Payment Status after  Response from specific Payment system website,  when parameters is crypted.
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
     * 
      
        // Example if implemenation:

            // Get these parametes in return array  based on $_POST or $_REQUEST params from gateways and checking about it.
            
            return array( 'pay_system'   => $pay_system
                    , 'status'     => $status
                    , 'booking_id' => $booking_id
                    , 'wp_nonce'   => $wp_nonce 
                  );

     */
    public function update_payment_status_with_crypted_paramaters( $response_status, $pay_system, $status, $booking_id, $wp_nonce ) {    
        return $response_status;
    }
    
    
    /** (Usually  must be Overriden in gateway file) Update Payment Status after  Response from specific Payment system website.
     *
     * @param type $response_status
     * @param type $pay_system
     * @param type $status
     * @param type $booking_id
     * @param type $wp_nonce
     * 
     * @return string - $response_status

        // Example if implemenation:
      
        if ( $pay_system == WPBC_PAYPAL_GATEWAY_ID ) { 
            $status = 'PayPal:' . $status; 
            return $status;
        }  
            
        return $response_status;        
     */
    public function update_payment_status__after_response( $response_status, $pay_system, $status, $booking_id, $wp_nonce ) {
       return $response_status; 
    }
    
    
    /** If activated "Auto approve|decline" and then Redirect to  "Success" or "Failed" payment page.
     * 
     * @param string $pay_system
     * @param string $status
     * @param type $booking_id
      
        // Exmaple of implementation:
 
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

     */
    // abstract public function auto_approve_or_cancell_and_redirect( $pay_system, $status, $booking_id );    
    public function auto_approve_or_cancell_and_redirect( $pay_system, $status, $booking_id ) {

        if ( $pay_system == $this->get_id() ) {

            $auto_approve = get_bk_option( 'booking_' . $this->get_id() . '_is_auto_approve_cancell_booking' );
 
            $payment_status = $this->get_payment_status_array();
            
            if (  is_array( $payment_status ) && isset( $payment_status['ok'] ) && isset( $payment_status['pending'] )  ) {
            
                    if (        in_array( $status,  $payment_status['ok'] ) 
                            ||  in_array( $status,  $payment_status['pending'] )  
                    ) {
                        if ( $auto_approve == 'On' ) wpbc_auto_approve_booking( $booking_id );

                        $url = get_bk_option( 'booking_' . $this->get_id() . '_order_successful' );
                        if ( ! empty( $url ) )  wpbc_redirect( $url );
                        $url = get_bk_option( 'booking_' . $this->get_id() . '_return_url' );
                        if ( ! empty( $url ) )  wpbc_redirect( $url );

                    } else {
                        if ( $auto_approve == 'On' ) wpbc_auto_cancel_booking( $booking_id );

                        $url = get_bk_option( 'booking_' . $this->get_id() . '_order_failed' );
                        if ( ! empty( $url ) )  wpbc_redirect( $url );
                        $url = get_bk_option( 'booking_' . $this->get_id() . '_cancel_return_url' );
                        if ( ! empty( $url ) )  wpbc_redirect( $url );

                    }
            
            }
        }        
    }
    ////////////////////////////////////////////////////////////////////////////
    
    
    /** Add "OK" payment status(es) of this gateway to system
     * 
     * @param array $payment_status
     * @return array
     */
    public function add_payment_status_ok( $payment_status ) {        
        
        $gateway_statuses = $this->get_payment_status_array();

        $payment_status = array_merge( $payment_status, $gateway_statuses['ok'] );

        return  $payment_status;                
    }
       
    
    /** Add "PENDING" payment status(es) of this gateway to system
     * 
     * @param array $payment_status
     * @return array
     */
    public function add_payment_status_pending( $payment_status ) {

        $gateway_statuses = $this->get_payment_status_array();
       
        $payment_status = array_merge( $payment_status, $gateway_statuses['pending'] );
         
        return  $payment_status;                
    }
    
    
    /** Add "UNKNOWN" payment status(es) of this gateway to system
     * 
     * @param array $payment_status
     * @return array
     */
    public function add_payment_status_unknown( $payment_status ){
        
        $gateway_statuses = $this->get_payment_status_array();
       
        $payment_status = array_merge( $payment_status, $gateway_statuses['unknown'] );
         
        return  $payment_status;                
    }
    
    
    /** Add "ERROR" payment status(es) of this gateway to system
     * 
     * @param array $payment_status
     * @return array
     */
    public function add_payment_status_error( $payment_status ){
   
        $gateway_statuses = $this->get_payment_status_array();
       
        $payment_status = array_merge( $payment_status, $gateway_statuses['error'] );
         
        return  $payment_status;                
    }
    
}




////////////////////////////////////////////////////////////////////////////////
//  P a y m e n t    S T A T U S    Functions
////////////////////////////////////////////////////////////////////////////////

/** Get list of "OK" Payment status from different Gateways
 * 
 * @return string - payment status
 */
function wpbc_get_payment_status_ok() {
    $payment_status = array(
        'OK',
        'Completed',
        'success',
        'Paid OK'
    );
    $payment_status = apply_filters( 'wpbc_add_payment_status_ok', $payment_status );   //Link to  specific payment gateway
    return $payment_status;
}


/** Get list of "Pending" Payment status from different Gateways
 * 
 * @return string - payment status
 */
function wpbc_get_payment_status_pending() {
    $payment_status = array(
        'Not_Completed',
        'Not Completed',
        'Pending',
        'Processed',
        'In-Progress',
        'partially',
        'Partially paid'
    );
    $payment_status = apply_filters( 'wpbc_add_payment_status_pending', $payment_status );
    return $payment_status;
}


/** Get list of "Unknown" Payment status from different Gateways
 * 
 * @return string - payment status
 */
function wpbc_get_payment_status_unknown() {
    $payment_status = array(
        '1',
        'Canceled_Reversal',
        'Voided',
        'Created'
    );
    $payment_status = apply_filters( 'wpbc_add_payment_status_unknown', $payment_status );
    return $payment_status;
}


/** Get list of "Unknown" Payment status from different Gateways
 * 
 * @return string - payment status
 */
function wpbc_get_payment_status_error() {
    $payment_status = array(
        'Denied',
        'Expired',
        'Failed',
        'Reversed',
        'Partially_Refunded',
        'Refunded',
        'not-authed',
        'malformed',
        'invalid',
        'abort',
        'rejected',
        'fraud',
        'Cancelled',
        'error'
    );
    $payment_status = apply_filters( 'wpbc_add_payment_status_error', $payment_status );
    return $payment_status;
}


////////////////////////////////////////////////////////////////////////////////


/** Check  if Payment Status - SUCCESS
 * 
 * @param string $payment_status - payment status of specific gateway
 * @return boolean
 */
function wpbc_is_payment_status_ok( $payment_status ) {

    if ( wpbc_check_payment_status( $payment_status ) == 'success' )
        return true;
    else
        return false;
}


/** Check  if Payment Status - PENDING
 * 
 * @param string $payment_status - payment status of specific gateway
 * @return boolean
 */
function wpbc_is_payment_status_pending( $payment_status ) {

    if ( wpbc_check_payment_status( $payment_status ) == 'pending' )
        return true;
    else
        return false;
}


/** Check if Payment Status - UNKNOWN
 * 
 * @param string $payment_status - payment status of specific gateway
 * @return boolean
 */
function wpbc_is_payment_status_unknown( $payment_status ) {

    if ( wpbc_check_payment_status( $payment_status ) == 'unknown' )
        return true;
    else
        return false;
}


/** Check if Payment Status - ERROR
 * 
 * @param string $payment_status - payment status of specific gateway
 * @return boolean
 */
function wpbc_is_payment_status_error( $payment_status ) {

    if ( wpbc_check_payment_status( $payment_status ) == 'error' )
        return true;
    else
        return false;
}


/** Check specific Gateway Payment status relative to General type of payment status
 * 
 * @param string $payment_status - payment status of specific gateway
 * @return string - 'success' | 'pending' | 'unknown' | 'error'
 */
function wpbc_check_payment_status( $payment_status ) {

    $payment_type = 'unknown';                                                  // Default payment status type

    $payment_success = wpbc_get_payment_status_ok();
    $payment_pending = wpbc_get_payment_status_pending();
    $payment_unknown = wpbc_get_payment_status_unknown();
    $payment_error   = wpbc_get_payment_status_error();

    // Check  LOWERCASE for the any payemnt status
    if ( in_array( strtolower( $payment_status ), wpdev_bk_arraytolower( $payment_success ) ) !== false )   $payment_type = 'success';
    if ( in_array( strtolower( $payment_status ), wpdev_bk_arraytolower( $payment_pending ) ) !== false )   $payment_type = 'pending';
    if ( in_array( strtolower( $payment_status ), wpdev_bk_arraytolower( $payment_unknown ) ) !== false )   $payment_type = 'unknown';
    if ( in_array( strtolower( $payment_status ), wpdev_bk_arraytolower( $payment_error ) ) !== false )     $payment_type = 'error';

    return $payment_type;
}
