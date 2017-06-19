<?php
/**
 * @version     1.0
 * @package     Booking Calendar
 * @category    Default Form Templates
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


////////////////////////////////////////////////////////////////////////////////
// Booking Form Templates
////////////////////////////////////////////////////////////////////////////////            

/** Get Default Booking Form during activation of plugin or get  this data for init creation of custom booking form
 * 
 * @return string
 */
function wpbc_get_default_booking_form() {    
    
    $is_demo = wpbc_is_this_demo();
     
    $booking_form = '[calendar] \n\
<div class="standard-form"> \n\
 <p>'.__('First Name (required)' ,'booking').':<br />[text* name] </p> \n\
 <p>'.__('Last Name (required)' ,'booking').':<br />[text* secondname] </p> \n\
 <p>'.__('Email (required)' ,'booking').':<br />[email* email] </p> \n\
 <p>'.__('Phone' ,'booking').':<br />[text phone] </p> \n\
 <p>'.__('Adults' ,'booking').':  [select visitors class:col-md-1 "1" "2" "3" "4"] '.__('Children' ,'booking').': [select children class:col-md-1 "0" "1" "2" "3"]</p> \n\
 <p>'.__('Details' ,'booking').':<br /> [textarea details] </p> \n\
 <p>[checkbox* term_and_condition use_label_element "'.__('I Accept term and conditions' ,'booking').'"] </p> \n\
 <p>[captcha]</p> \n\
 <p>[submit class:btn "'.__('Send' ,'booking').'"]</p> \n\
</div>';                       
    
    if ( class_exists( 'wpdev_bk_biz_s' ) ) 
        $booking_form = '[calendar] \n\
<div class="payment-form"> \n\
 <p>'.__('Select Times' ,'booking').':<br />[select rangetime "10:00 AM - 12:00 PM@@10:00 - 12:00" "12:00 PM - 02:00 PM@@12:00 - 14:00" "02:00 PM - 04:00 PM@@14:00 - 16:00" "04:00 PM - 06:00 PM@@16:00 - 18:00" "06:00 PM - 08:00 PM@@18:00 - 20:00"]</p>\n\
 <p>'.__('First Name (required)' ,'booking').':<br />[text* name] </p> \n\
 <p>'.__('Last Name (required)' ,'booking').':<br />[text* secondname] </p> \n\
 <p>'.__('Email (required)' ,'booking').':<br />[email* email] </p> \n\
 <p>'.__('Phone' ,'booking').':<br />[text phone] </p> \n\
 <p>'.__('Address (required)' ,'booking').':<br />  [text* address] </p> \n\  
 <p>'.__('City (required)' ,'booking').':<br />  [text* city] </p> \n\
 <p>'.__('Post code (required)' ,'booking').':<br />  [text* postcode] </p> \n\  
 <p>'.__('Country (required)' ,'booking').':<br />  [country] </p> \n\
 <p>'.__('Adults' ,'booking').':  [select visitors class:col-md-1 "1" "2" "3" "4"] '.__('Children' ,'booking').': [select children class:col-md-1 "0" "1" "2" "3"]</p> \n\
 <p>'.__('Details' ,'booking').':<br /> [textarea details] </p> \n\
 <p>[checkbox* term_and_condition use_label_element "'.__('I Accept term and conditions' ,'booking').'"] </p> \n\
 <p>[captcha]</p> \n\
 <p>[submit class:btn "'.__('Send' ,'booking').'"]</p> \n\
</div>';
        
    
    if ( ( class_exists( 'wpdev_bk_biz_s' ) ) && ( $is_demo ) ) 
        $booking_form = '[calendar] \n\
<div class="payment-form"> \n\
 <p>'.__('Select Times' ,'booking').':<br />[select rangetime multiple "10:00 AM - 12:00 PM@@10:00 - 12:00" "12:00 PM - 02:00 PM@@12:00 - 14:00" "02:00 PM - 04:00 PM@@14:00 - 16:00" "04:00 PM - 06:00 PM@@16:00 - 18:00" "06:00 PM - 08:00 PM@@18:00 - 20:00"]</p>\n\
 <p>'.__('First Name (required)' ,'booking').':<br />[text* name] </p> \n\
 <p>'.__('Last Name (required)' ,'booking').':<br />[text* secondname] </p> \n\
 <p>'.__('Email (required)' ,'booking').':<br />[email* email] </p> \n\
 <p>'.__('Phone' ,'booking').':<br />[text phone] </p> \n\
 <p>'.__('Address (required)' ,'booking').':<br />  [text* address] </p> \n\  
 <p>'.__('City (required)' ,'booking').':<br />  [text* city] </p> \n\
 <p>'.__('Post code (required)' ,'booking').':<br />  [text* postcode] </p> \n\  
 <p>'.__('Country (required)' ,'booking').':<br />  [country] </p> \n\
 <p>'.__('Adults' ,'booking').':  [select visitors class:col-md-1 "1" "2" "3" "4"] '.__('Children' ,'booking').': [select children class:col-md-1 "0" "1" "2" "3"]</p> \n\
 <p>'.__('Details' ,'booking').':<br /> [textarea details] </p> \n\
 <p>[checkbox* term_and_condition use_label_element "'.__('I Accept term and conditions' ,'booking').'"] </p> \n\
 <p>[captcha]</p> \n\
 <p>[submit class:btn "'.__('Send' ,'booking').'"]</p> \n\
</div>';
        
    
    if ( ( class_exists( 'wpdev_bk_biz_m' ) ) && ( $is_demo ) )
        $booking_form = '[calendar] \n\
<div class="payment-form"> \n\
 <div class="form-hints"> \n\ 
      '.__('Dates' ,'booking').': [selected_short_timedates_hint]  ([nights_number_hint] - '.__('night(s)' ,'booking').')<br><br> \n\ 
      '.__('Full cost of the booking' ,'booking').': [cost_hint] <br> \n\ 
 </div><hr/> \n\ 
 <p>'.__('First Name (required)' ,'booking').':<br />[text* name] </p> \n\
 <p>'.__('Last Name (required)' ,'booking').':<br />[text* secondname] </p> \n\
 <p>'.__('Email (required)' ,'booking').':<br />[email* email] </p> \n\
 <p>'.__('Phone' ,'booking').':<br />[text phone] </p> \n\
 <p>'.__('Address (required)' ,'booking').':<br />  [text* address] </p> \n\  
 <p>'.__('City (required)' ,'booking').':<br />  [text* city] </p> \n\
 <p>'.__('Post code (required)' ,'booking').':<br />  [text* postcode] </p> \n\  
 <p>'.__('Country (required)' ,'booking').':<br />  [country] </p> \n\
 <p>'.__('Adults' ,'booking').':  [select visitors class:col-md-1 "1" "2" "3" "4"] '.__('Children' ,'booking').': [select children class:col-md-1 "0" "1" "2" "3"]</p> \n\
 <p>'.__('Details' ,'booking').':<br /> [textarea details] </p> \n\
 <p>[checkbox* term_and_condition use_label_element "'.__('I Accept term and conditions' ,'booking').'"] </p> \n\
 <p>[captcha]</p> \n\
 <p>[submit class:btn "'.__('Send' ,'booking').'"]</p> \n\
</div>'; 
    
    if ( ( class_exists( 'wpdev_bk_biz_l' ) ) && ( $is_demo ) )
        $booking_form = '[calendar] \n\
<div class="payment-form"><br /> \n\
 <div class="form-hints"> \n\
      '. __('Dates' ,'booking').': [selected_short_timedates_hint]<br><br> \n\
      '. __('Full cost of the booking' ,'booking').': [cost_hint] <br> \n\
 </div><hr/> \n\
 <p>'. __('First Name (required)' ,'booking').':<br />[text* name] </p> \n\
 <p>'. __('Last Name (required)' ,'booking').':<br />[text* secondname] </p> \n\
 <p>'. __('Email (required)' ,'booking').':<br />[email* email] </p> \n\
 <p>'. __('Phone' ,'booking').':<br />[text phone] </p> \n\
 <p>'. __('Address (required)' ,'booking').':<br />  [text* address] </p> \n\
 <p>'. __('City (required)' ,'booking').':<br />  [text* city] </p> \n\
 <p>'. __('Post code (required)' ,'booking').':<br />  [text* postcode] </p> \n\
 <p>'. __('Country (required)' ,'booking').':<br />  [country] </p> \n\
 <p>'. __('Visitors' ,'booking').':<br />  [select visitors "1" "2" "3" "4"] </p> \n\
 <p>'. __('Details' ,'booking').':<br /> [textarea details] </p> \n\
 <p>'. __('Coupon' ,'booking').':<br /> [coupon coupon] </p> \n\
 <p>[checkbox* term_and_condition use_label_element "'. __('I Accept term and conditions' ,'booking').'"] </p> \n\
 <p>[captcha]</p> \n\
 <p>[submit class:btn "'. __('Send' ,'booking').'"]</p> \n\
</div>';     
    
    return $booking_form;    
}
          

/** Get Default Form to SHOW during activation of plugin or get  this data for init creation of custom booking form
 * 
 * @return string
 */
function wpbc_get_default_booking_form_show() {
    
    $is_demo = wpbc_is_this_demo();
    
    $booking_form = '<div class="standard-content-form"> \n\
<strong>'. __('First Name' ,'booking').'</strong>:<span class="fieldvalue">[name]</span><br/> \n\
<strong>'. __('Last Name' ,'booking').'</strong>:<span class="fieldvalue">[secondname]</span><br/> \n\
<strong>'. __('Email' ,'booking').'</strong>:<span class="fieldvalue">[email]</span><br/> \n\
<strong>'. __('Phone' ,'booking').'</strong>:<span class="fieldvalue">[phone]</span><br/> \n\
<strong>'. __('Adults' ,'booking').'</strong>:<span class="fieldvalue"> [visitors]</span><br/> \n\
<strong>'. __('Children' ,'booking').'</strong>:<span class="fieldvalue"> [children]</span><br/> \n\
<strong>'. __('Details' ,'booking').'</strong>:<br /><span class="fieldvalue"> [details]</span> \n\
</div>';
                
    if ( class_exists( 'wpdev_bk_biz_s' ) ) 
        $booking_form = '<div class="payment-content-form"> \n\
<strong>'. __('Times' ,'booking').'</strong>:<span class="fieldvalue">[rangetime]</span><br/> \n\
<strong>'. __('First Name' ,'booking').'</strong>:<span class="fieldvalue">[name]</span><br/> \n\
<strong>'. __('Last Name' ,'booking').'</strong>:<span class="fieldvalue">[secondname]</span><br/> \n\
<strong>'. __('Email' ,'booking').'</strong>:<span class="fieldvalue">[email]</span><br/> \n\
<strong>'. __('Phone' ,'booking').'</strong>:<span class="fieldvalue">[phone]</span><br/> \n\
<strong>'. __('Address' ,'booking').'</strong>:<span class="fieldvalue">[address]</span><br/> \n\
<strong>'. __('City' ,'booking').'</strong>:<span class="fieldvalue">[city]</span><br/> \n\
<strong>'. __('Post code' ,'booking').'</strong>:<span class="fieldvalue">[postcode]</span><br/> \n\
<strong>'. __('Country' ,'booking').'</strong>:<span class="fieldvalue">[country]</span><br/> \n\
<strong>'. __('Adults' ,'booking').'</strong>:<span class="fieldvalue"> [visitors]</span><br/> \n\
<strong>'. __('Children' ,'booking').'</strong>:<span class="fieldvalue"> [children]</span><br/> \n\
<strong>'. __('Details' ,'booking').'</strong>:<br /><span class="fieldvalue"> [details]</span> \n\
</div>';
    
    if ( ( class_exists( 'wpdev_bk_biz_m' ) ) && ( $is_demo ) )   
        $booking_form = '<div class="payment-content-form"> \n\
<strong>'. __('First Name' ,'booking').'</strong>:<span class="fieldvalue">[name]</span><br/> \n\
<strong>'. __('Last Name' ,'booking').'</strong>:<span class="fieldvalue">[secondname]</span><br/> \n\
<strong>'. __('Email' ,'booking').'</strong>:<span class="fieldvalue">[email]</span><br/> \n\
<strong>'. __('Phone' ,'booking').'</strong>:<span class="fieldvalue">[phone]</span><br/> \n\
<strong>'. __('Address' ,'booking').'</strong>:<span class="fieldvalue">[address]</span><br/> \n\
<strong>'. __('City' ,'booking').'</strong>:<span class="fieldvalue">[city]</span><br/> \n\
<strong>'. __('Post code' ,'booking').'</strong>:<span class="fieldvalue">[postcode]</span><br/> \n\
<strong>'. __('Country' ,'booking').'</strong>:<span class="fieldvalue">[country]</span><br/> \n\
<strong>'. __('Adults' ,'booking').'</strong>:<span class="fieldvalue"> [visitors]</span><br/> \n\
<strong>'. __('Children' ,'booking').'</strong>:<span class="fieldvalue"> [children]</span><br/> \n\
<strong>'. __('Details' ,'booking').'</strong>:<br /><span class="fieldvalue"> [details]</span> \n\
</div>';
    
    if ( ( class_exists( 'wpdev_bk_biz_l' ) ) && ( $is_demo ) )   
        $booking_form = '<div class="payment-content-form"> \n\
<strong>'. __('First Name' ,'booking').'</strong>:<span class="fieldvalue">[name]</span><br/> \n\
<strong>'. __('Last Name' ,'booking').'</strong>:<span class="fieldvalue">[secondname]</span><br/> \n\
<strong>'. __('Email' ,'booking').'</strong>:<span class="fieldvalue">[email]</span><br/> \n\
<strong>'. __('Phone' ,'booking').'</strong>:<span class="fieldvalue">[phone]</span><br/> \n\
<strong>'. __('Address' ,'booking').'</strong>:<span class="fieldvalue">[address]</span><br/> \n\
<strong>'. __('City' ,'booking').'</strong>:<span class="fieldvalue">[city]</span><br/> \n\
<strong>'. __('Post code' ,'booking').'</strong>:<span class="fieldvalue">[postcode]</span><br/> \n\
<strong>'. __('Country' ,'booking').'</strong>:<span class="fieldvalue">[country]</span><br/> \n\
<strong>'. __('Visitors' ,'booking').'</strong>:<span class="fieldvalue"> [visitors]</span><br/> \n\
<strong>'. __('Details' ,'booking').'</strong>:<br /><span class="fieldvalue"> [details]</span> \n\
<strong>'. __('Coupon' ,'booking').'</strong>:<span class="fieldvalue"> [coupon]</span><br/> \n\
</div>';
        
    return $booking_form;
}


////////////////////////////////////////////////////////////////////////////////
// Search Form Templates
////////////////////////////////////////////////////////////////////////////////            

/** Default Search Form templates 
 * 
 * @param string $search_form_type
 * @return string
 */
function wpbc_get_default_search_form_template( $search_form_type = '' ){     //FixIn:6.1.0.1

  switch ( $search_form_type ) {

      case 'inline':
          return   '<div class="wpdevelop">' . '\n\r'
                 . '    <div class="form-inline well">' . '\n\r'
                 . '        <label>'.__('Check in' ,'booking').':</label> [search_check_in]' . '\n\r'
                 . '        <label>'.__('Check out' ,'booking').':</label> [search_check_out]' . '\n\r'
                 . '        <label>'.__('Guests' ,'booking').':</label> [search_visitors]' . '\n\r'
                 . '        [search_button]' . '\n\r'
                 . '    </div>' . '\n\r'
                 . '</div>';

      case 'horizontal':
          return   '<div class="wpdevelop">' . '\n\r'
                 . '    <div class="form-horizontal well">' . '\n\r'
                 . '        <label>'.__('Check in' ,'booking').':</label> [search_check_in]' . '\n\r'
                 . '        <label>'.__('Check out' ,'booking').':</label> [search_check_out]' . '\n\r'
                 . '        <label>'.__('Guests' ,'booking').':</label> [search_visitors]' . '\n\r'
                 . '        <hr/>\n\        [search_button]' . '\n\r'
                 . '    </div>' . '\n\r'
                 . '</div>';

      case 'advanced':                                            
          return   '<div class="wpdevelop">' . '\n\r'
                 . '    <div class="form-inline well">' . '\n\r'
                 . '        <label>'.__('Check in' ,'booking').':</label> [search_check_in]' . '\n\r'
                 . '        <label>'.__('Check out' ,'booking').':</label> [search_check_out]' . '\n\r'
                 . '        <label>'.__('Guests' ,'booking').':</label> [search_visitors]' . '\n\r'
                 . '        [search_button]' . '\n\r'
                 . '        <br/><label>[additional_search "3"] +/- 2 '.__('days' ,'booking').'</label>' . '\n\r'
                 . '    </div>' . '\n\r'
                 . '</div>';
      default:
          return 

                   ' <label>'.__('Check in' ,'booking').':</label> [search_check_in]' . '\n\r'
                 . ' <label>'.__('Check out' ,'booking').':</label> [search_check_out]' . '\n\r'
                 . ' <label>'.__('Guests' ,'booking').':</label> [search_visitors]' . '\n\r'
                 . ' [search_button] ';                        
  }

}


/** Default Search Results templates
 * 
 * @param string $search_form_type
 * @return string
 */
function wpbc_get_default_search_results_template( $search_form_type = '' ){     //FixIn:6.1.0.1

    switch ($search_form_type) {                    

      case 'advanced':                                           
          return   '<div class="wpdevelop">' . '\n\r'
                 . '  ' . '<div style="float:right;"><div>Cost: <strong>[cost_hint]</strong></div>' . '\n\r'
                 . '  ' . '[link_to_booking_resource "Book now"]</div>' . '\n\r'
                 . '  ' . '<a href="[book_now_link]" class="wpbc_book_now_link">' . '\n\r'
                 . '  ' . '    ' .'[booking_resource_title]' . '\n\r'
                 . '  ' . '</a>' . '\n\r'
                 . '  ' . '[booking_featured_image]' . '\n\r'
                 . '  ' . '[booking_info]' . '\n\r'
                 . '  ' . '<div>' . '\n\r'
                 . '  ' . '  ' . __('Availability' ,'booking').': [num_available_resources] item(s).' . '\n\r'
                 . '  ' . '  ' . __('Max. persons' ,'booking').': [max_visitors]' . '\n\r'
                 . '  ' . '  ' . 'Check in/out: <strong>[search_check_in]</strong> - ' . '\n\r'
                 . '  ' . '                ' . '<strong>[search_check_out]</strong>' . '\n\r'
                 . '  ' . '</div>' . '\n\r'
                 . '</div>';

      default:
          return   '<div class="wpdevelop">' . '\n\r'
                 . '    <div style="float:right;">' . '\n\r'
                 . '        ' . '<div>From [standard_cost]</div>' . '\n\r'
                 . '        ' . '[link_to_booking_resource "Book now"]' . '\n\r'
                 . '    </div>' . '\n\r'
                 . '    [booking_resource_title]' . '\n\r'
                 . '    [booking_featured_image]' . '\n\r'
                 . '    [booking_info]' . '\n\r'
                 . '    <div>' . '\n\r'
                 . '        ' . __('Availability' ,'booking').': [num_available_resources] item(s).' . '\n\r'
                 . '        ' . __('Max. persons' ,'booking').': [max_visitors]' . '\n\r'
                 . '    </div>' . '\n\r'                            
                 . '</div>';
    }                      
}
