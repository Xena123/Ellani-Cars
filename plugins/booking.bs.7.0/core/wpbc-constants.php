<?php
/**
 * @version 1.0
 * @package Booking Calendar 
 * @subpackage Define Constants
 * @category Bookings
 * 
 * @author wpdevelop
 * @link http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2014.05.17
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   USERS  CONFIGURABLE  CONSTANTS           //////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (!defined('WP_BK_SHOW_INFO_IN_FORM'))                define('WP_BK_SHOW_INFO_IN_FORM',  false );                 // This feature can impact to the performance
if (!defined('WP_BK_SHOW_BOOKING_NOTES'))               define('WP_BK_SHOW_BOOKING_NOTES', false );                 // Set notes of the specific booking visible by default.
if (!defined('WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS'))   define('WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS',  false );    // Only for MultiUser version 
if (!defined('WP_BK_SHOW_DEPOSIT_AND_TOTAL_PAYMENT'))   define('WP_BK_SHOW_DEPOSIT_AND_TOTAL_PAYMENT',  false );    // Show both deposit and total cost payment forms, after visitor submit booking. Important! Please note, in this case at admin panel for booking will be saved deposit cost and notes about deposit, do not depend from the visitor choise of this payment. So you need to check each such payment manually.
if (!defined('WP_BK_IS_SEND_EMAILS_ON_COST_CHANGE'))    define('WP_BK_IS_SEND_EMAILS_ON_COST_CHANGE',  false );     //FixIn: 6.0.1.7   // Is send modification email, if cost  was changed in admin panel
if (!defined('WP_BK_LAST_CHECKOUT_DAY_AVAILABLE'))      define('WP_BK_LAST_CHECKOUT_DAY_AVAILABLE',  false );       //FixIn: 6.2.3.6   // Its will remove last selected day  of booking during saving it as booking. 
if (!defined('WP_BK_PAYMENT_FORM_ONLY_IN_REQUEST'))     define('WP_BK_PAYMENT_FORM_ONLY_IN_REQUEST', false );       // Its will show payment form  only in payment request during sending from  Booking Listing page and do not show payment form  after  visitor made the booking.
if (!defined('WP_BK_AUTO_APPROVE_WHEN_ZERO_COST'))      define('WP_BK_AUTO_APPROVE_WHEN_ZERO_COST',  false );        // Auto  approve booking,  if the cost of booking == 0
if (!defined('WP_BK_CHECK_LESS_THAN_PARAM_IN_SEARCH'))  define('WP_BK_CHECK_LESS_THAN_PARAM_IN_SEARCH',  false );    // Check in search  results custom fields parameters relative to  less than  in search  form,  and not only equal.

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   SYSTEM  CONSTANTS                        //////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (!defined('WP_BK_VERSION_NUM'))      define('WP_BK_VERSION_NUM',     '7.0' );
if (!defined('WP_BK_MINOR_UPDATE'))     define('WP_BK_MINOR_UPDATE',    false );    
if (!defined('IS_USE_WPDEV_BK_CACHE'))  define('IS_USE_WPDEV_BK_CACHE', true );    
if (!defined('WP_BK_DEBUG_MODE'))       define('WP_BK_DEBUG_MODE',      false );
if (!defined('WP_BK_MIN'))              define('WP_BK_MIN',             false );//TODO: Finish  with  this contstant, right now its not working correctly with TRUE status
if (!defined('WP_BK_RESPONSE'))         define('WP_BK_RESPONSE',        false ); 