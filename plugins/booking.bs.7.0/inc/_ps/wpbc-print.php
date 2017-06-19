<?php /**
 * @version 1.0
 * @package Booking Calendar 
 * @category Print Loyout for Booking Listing
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-01-16
 * 
 * This is COMMERCIAL SCRIPT
 * We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit, if accessed directly

////////////////////////////////////////////////////////////////////////////////    
//  P r i n t    L o y o u t
////////////////////////////////////////////////////////////////////////////////  

/** Generate Print Loyout
 * 
 * @param array $print_data  - booking data fields  
 * Array
        (
            [0] => ID
            [1] => Labels
            [2] => Data
            [3] => Dates
            [4] => Cost
        ),
 *  ...
 */
function wpbc_print_loyout( $print_data ) {
    ?>
      <div style="display:none;">
          <div id="booking_print_loyout">
              <table style="width:100%;" >
                  <thead>
                      <tr class="booking-listing-header">
                          <th style="width:10%"><?php echo $print_data[0][0]; ?></th>
                          <th style="width:10%"><?php echo $print_data[0][1]; ?></th>
                          <th ><?php echo $print_data[0][2]; ?></th>
                          <th style="width:20%"><?php echo $print_data[0][3]; ?></th>
                          <th style="width:10%"><?php echo $print_data[0][4]; ?></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      for ($i = 1; $i < count($print_data); $i++) {
                              $print_item = $print_data[$i] ;
                              $is_alternative_color = $i % 2;
                      ?>
                      <tr id="wpbc_print_row<?php echo $print_item[0]; ?>" class="wpbc_print_rows booking-listing-row wpbc-listing-row <?php if ($is_alternative_color) echo ' row_alternative_color ';?>" >
                          <td class=" bktextcenter"><?php echo $print_item[0]; ?></td>
                          <td class=" bktextcenter"><?php echo '<span class="label label-default">'.$print_item[1][0] . '</span>, <span class="label label-default">' . $print_item[1][1] . '</span>, <span class="label label-default">' . $print_item[1][2] .'</span>'; ?></td>
                          <td class=" bktextcenter"><?php echo $print_item[2]; ?></td>
                          <td class=" bktextcenter"><?php echo strip_tags($print_item[3]); ?></td>
                          <td class=" bktextcenter"><span  class="label label-default"><?php echo $print_item[4][0] . ' ' . $print_item[4][1]; ?></span></td>
                      </tr>
                      <?php } ?>
                  </tbody>
              </table>
          </div>
      </div>
    <?php
}
add_bk_action( 'wpbc_print_loyout', 'wpbc_print_loyout' );


/** Get header array for Print Loyout
 * 
 * @param array $blank - array( array() ) 
 * @return array
 */
function wpbc_print_get_header($blank){
    return array(
                     array(
                            __('ID' ,'booking'),
                            __('Labels' ,'booking'),
                            __('Data' ,'booking'),
                            __('Dates' ,'booking'),
                            __('Cost' ,'booking'),
                           )
                    );
}
add_bk_filter('wpbc_print_get_header', 'wpbc_print_get_header');


/** Get Print Row
 * 
 * @param type $blank - array() 
 * @param type $booking_id - $row_data['id']
 * @param type $is_approved - $row_data['is_approved']
 * @param type $bk_form_show - $row_data['form_show']
 * @param type $bk_booking_type_name - $row_data['resource_name']
 * @param type $is_paid - $row_data['is_paid']
 * @param type $pay_print_status - $row_data['pay_print_status']
 * @param type $print_dates - '<div class="booking_dates_small">' . $row_data['short_dates_content'] . '</div>' || '<div class="booking_dates_full">' . $row_data['wide_dates_content'] . '</div>'
 * @param type $bk_cost - $row_data['cost']
 * @return array
 */
function wpbc_print_get_row($blank, $booking_id,
                                     $is_approved ,
                                     $bk_form_show,
                                     $bk_booking_type_name,
                                     $is_paid ,
                                     $pay_print_status ,
                                     $print_dates,
                                     $bk_cost
                                    , $resource_id
        ){

    if ($is_approved) $bk_print_status =  __('Approved' ,'booking');
    else              $bk_print_status =  __('Pending' ,'booking');

    //BS
    $currency = ''; 
    
    if ( class_exists( 'wpdev_bk_biz_s' ) ) {

        if ( ! empty( $resource_id ) )
            $previous_active_user = apply_bk_filter( 'wpbc_mu_set_environment_for_owner_of_resource', -1, $resource_id );               // MU

        $currency = wpbc_get_currency();

        if ( ! empty( $resource_id ) )
            make_bk_action( 'wpbc_mu_set_environment_for_user', $previous_active_user );                                                // MU    
    }    
    
    

    return array(  $booking_id,
                            array($bk_print_status, $bk_booking_type_name, $pay_print_status),
                            $bk_form_show,
                            $print_dates,
                            array($currency, $bk_cost)                                  //BS
                          );
}
add_bk_filter('wpbc_print_get_row', 'wpbc_print_get_row');
