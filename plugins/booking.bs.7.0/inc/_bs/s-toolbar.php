<?php /**
 * @version 1.0
 * @package Booking Calendar 
 * @category UI elements for Toolbar Booking Listing / Calendar Overview pages
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-01-15
 * 
 * This is COMMERCIAL SCRIPT
 * We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit, if accessed directly


    ////////////////////////////////////////////////////////////////////////////    
    //  B u t t o n s   
    ////////////////////////////////////////////////////////////////////////////  
                                
    /** Cost    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_cost_edit( $row_data = array() ) {

        ?><div class="cost-fields-group control-group"><?php 

            ?><div class="btn-toolbar"><?php

                // Currency
                $currency = wpbc_get_currency_symbol_for_user( $row_data['resource'] );
                
                ?><div class="btn-group field-currency"><?php echo $currency; ?></div><?php 

                ?><div class="input-group"><?php 

                    // Cost Field
                    ?><input type="text" 
                            placeholder='0.00'
                            id="booking_cost<?php echo $row_data['id']; ?>" 
                            name="booking_cost<?php echo $row_data['id']; ?>"
                            value="<?php echo $row_data['cost']; ?>" class="field-booking-cost form-control"
                            onkeydown="javascript:jQuery('#booking_save_cost<?php echo $row_data['id']; ?>').show();"
                      /><?php 

                ?></div><?php 

                // Cost Section
                make_bk_action( 'wpbc_booking_listing_section_cost_saving', $row_data );
                
                
                // Send Payment Request  
                ?><a    href="javascript:void(0)" 
                        onclick="javascript:payment_request_id = <?php echo $row_data['id']; ?>; jQuery('#payment_request_reason').val(''); jQuery('#wpbc_payment_request_modal').modal('show');" 
                        class="tooltip_top button-secondary button wpbc_send-payment-request-button" 
                        title="<?php _e('Send payment request to visitor' ,'booking'); ?>"
                        id="send_payment_request<?php echo $row_data['id']; ?>"
                 ><i class="glyphicon glyphicon-envelope"></i></a><?php  

            ?></div><?php 

        ?></div><?php

    }
    add_bk_action( 'wpbc_booking_listing_button_cost_edit', 'wpbc_booking_listing_button_cost_edit' );

    
    
    /** P a y m e n t    S t a t u s    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_payment_status( $row_data = array() ) {

       ?><a href="javascript:void(0)" 
            onclick='javascript:
                                if (document.getElementById(&quot;payment_status_row<?php echo $row_data['id'];?>&quot;).style.display==&quot;block&quot;) {
                                    document.getElementById(&quot;payment_status_row<?php echo $row_data['id'];?>&quot;).style.display=&quot;none&quot;; }
                                else { document.getElementById(&quot;payment_status_row<?php echo $row_data['id'];?>&quot;).style.display=&quot;block&quot;; }'
            class="tooltip_top payment_status_bk_link button-secondary button"
            title="<?php _e('Payment status' ,'booking'); ?>"
        ><i class="glyphicon glyphicon-tag"></i></a><?php             
    }
    add_bk_action( 'wpbc_booking_listing_button_payment_status', 'wpbc_booking_listing_button_payment_status' );
    
    
    /** P r i n t    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_print( $row_data = array() ) {
        
       ?><a href="javascript:void(0)" 
            onclick='javascript:wpbc_print_specific_booking(<?php echo $row_data['id']; ?>);'
            class="tooltip_top button-secondary button"
            title="<?php _e('Print' ,'booking'); ?>"
        ><i class="glyphicon glyphicon-print"></i></a><?php             
    }
    add_bk_action( 'wpbc_booking_listing_button_print', 'wpbc_booking_listing_button_print' );


    ////////////////////////////////////////////////////////////////////////////
    //  S e c t i o n s
    ////////////////////////////////////////////////////////////////////////////     
    
    /** C o s t    S a v i n g    Section for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_section_cost_saving( $row_data = array() ) {
            
        ?>
        <span class="booking_row_modification_element" 
             id="booking_save_cost<?php echo $row_data['id']; ?>" >
                <a  href="javascript:void(0)" 
                    class="button button-primary btn-save-cost" 
                    name="btn_booking_save_cost<?php echo $row_data['id']; ?>" 
                    id="btn_booking_save_cost<?php echo $row_data['id']; ?>"
                    onclick="javascript: document.getElementById('booking_save_cost<?php echo $row_data['id']; ?>').style.display='none';
                                         save_this_booking_cost(<?php echo $row_data['id']; ?>, document.getElementById('booking_cost<?php echo $row_data['id']; ?>').value, '<?php echo wpbc_get_booking_locale(); ?>' );"
                ><?php _e('Save cost' ,'booking'); ?></a>            
        </span><?php               
           
    }
    add_bk_action( 'wpbc_booking_listing_section_cost_saving', 'wpbc_booking_listing_section_cost_saving' );
    
    
    /** P a y m e n t   S t a t u s    Section for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_section_payment_status( $row_data = array() ) {
            
        $payment_status_titles = get_payment_status_titles();
        
        ?><div class="booking_row_modification_element_payment_status booking_row_modification_element " 
             id="payment_status_row<?php echo $row_data['id']; ?>" >
            <select id="select_payment_status_row<?php echo $row_data['id']; ?>" 
                    name="select_payment_status_row<?php echo $row_data['id']; ?>" >
                 <?php
                 $wpdevbk_selectors = $payment_status_titles ;
                 foreach ( $wpdevbk_selectors as $kk => $vv ) { ?>
                 <option <?php if ( ( $row_data['pay_status'] == $vv ) || ( (is_numeric($row_data['pay_status'])) && ($vv == '1') ) ) echo "selected='SELECTED'"; ?> value="<?php echo $vv; ?>"
                     ><?php echo $kk ; ?></option>
                 <?php } ?>
             </select>
             <a href="javascript:void(0)" 
                class="button button-primary btn-save-cost"  
                name="btn_booking_chnage_status<?php echo $row_data['id']; ?>" 
                id="btn_booking_chnage_status<?php echo $row_data['id']; ?>"
                onclick="javascript:
                           document.getElementById('payment_status_row<?php echo $row_data['id']; ?>').style.display='none';
                           change_booking_payment_status(<?php echo $row_data['id']; ?>,
                                document.getElementById('select_payment_status_row<?php echo $row_data['id']; ?>').value,
                                document.getElementById('select_payment_status_row<?php echo $row_data['id']; ?>').options[document.getElementById('select_payment_status_row<?php echo $row_data['id']; ?>').selectedIndex].text
                            );"
              ><?php _e('Change status' ,'booking'); ?></a>
              <div class="clear"></div>
        </div><?php 
        
    }
    add_bk_action( 'wpbc_booking_listing_section_payment_status', 'wpbc_booking_listing_section_payment_status' );
    
    
    ////////////////////////////////////////////////////////////////////////////    
    //  M o d a l s
    ////////////////////////////////////////////////////////////////////////////          

    /** Payment Request Loyout - Modal Window structure */    
    function wpbc_write_content_for_modal_payment_request() {
        
        $user = wp_get_current_user(); 
        $user_bk_id = $user->ID;                 //FixIn:5.4.5.6  
        
      ?><div id="wpbc_payment_request_modal" class="modal wpbc_popup_modal" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">   
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php _e('Send payment request to customer' ,'booking'); ?></h4>                    
                </div>
                <div class="modal-body">
                    <textarea cols="87" rows="5" id="payment_request_reason"  name="payment_request_reason"></textarea>
                    <label class="help-block"><?php printf(__('Type your %sreason for payment%s request' ,'booking'),'<b>',',</b>');?></label>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" 
                       class="button button-primary" 
                       onclick="javascript: sendPaymentRequestByEmail(payment_request_id , document.getElementById('payment_request_reason').value, <?php echo $user_bk_id; ?>, 
                                   '<?php echo wpbc_get_booking_locale(); ?>' );
                                   jQuery('#wpbc_payment_request_modal').modal('hide');"
                      ><?php _e('Send Request' ,'booking'); ?></a>
                    <a href="javascript:void(0)" class="button button-secondary" data-dismiss="modal"><?php _e('Close' ,'booking'); ?></a>
                </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php         
    }
    add_bk_action( 'wpbc_write_content_for_modals', 'wpbc_write_content_for_modal_payment_request');    

    
    ////////////////////////////////////////////////////////////////////////////    
    //  B u t t o n s   -  ADD NEW Booking page
    ////////////////////////////////////////////////////////////////////////////  

    /** Auto Fill booking form  Button*/
    function wpbc_toolbar_btn__auto_fill() {

        if ( isset( $_GET['booking_type'] ) )
             $bk_type = intval ( $_GET['booking_type'] );
        else $bk_type = 1;

        ?><a href="javascript:void(0)" onclick="javascript:wpbc_autofill_booking_form();" class="button-secondary button" style="margin-right: 15px;"><?php _e('Auto-fill form' , 'booking') ?></a><?php

        ?><script type="text/javascript">
            function wpbc_autofill_booking_form(){

                var my_element_value = 'admin';
                var form_elements = jQuery('.booking_form_div input');

                jQuery.each(form_elements, function(){

                    if (       ( this.type !== 'button' ) 
                            && ( this.type !== 'hidden' ) 
                            && ( this.name.search('starttime') == -1 ) 
                            && ( this.name.search('endtime') == -1 ) 
                       ) {        //FixIn:6.0.1.12    

                        if ( this.type == 'checkbox' ) {
                            jQuery( this ).prop('checked', true);
                        }
                        this.value = my_element_value;
                        if ( this.name.search('email') != -1 ) {
                            this.value = my_element_value + '@blank.com';
                        }
                        if ( this.name.search('starttime') != -1 ) { this.name = 'temp';  this.value=''; } // set name of time to someother name
                        if ( this.name.search('endtime')   != -1 ) { this.name = 'temp2'; this.value=''; }  // set name of time to someother name
                    }
                });

                mybooking_submit( 
                                    document.getElementById('booking_form<?php echo $bk_type; ?>' )
                                    , <?php echo $bk_type; ?>
                                    , '<?php echo wpbc_get_booking_locale(); ?>' 
                                );                    
            }
        </script><?php     
    }

    
