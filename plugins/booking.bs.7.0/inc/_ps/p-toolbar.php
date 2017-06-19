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
    //  T o p     T o o l b a r
    ////////////////////////////////////////////////////////////////////////////  

    /** K e y w o r d   F i l t e r */
    function wpbc_filter_text_keyword(){

        $params = array(  
                          'label_for' => 'wh_keyword'                       // "For" parameter  of label element
                        , 'label' => ''                                     // Label above the input group
                        , 'style' => ''                                     // CSS Style of entire div element
                        , 'items' => array(
                                            array(      
                                                'type' => 'addon' 
                                                , 'element' => 'text'       // text | radio | checkbox
                                                , 'text' => __('Keyword', 'booking') . ':'
                                                , 'class' => ''                 // Any CSS class here
                                                , 'style' => 'font-weight:600;'                 // CSS Style of entire div element
                                            )  
                                            , array(    
                                                'type' => 'text'
                                                , 'id' => 'wh_keyword'            // HTML ID  of element                                                          
                                                , 'value' => ( isset( $_REQUEST[ 'wh_keyword' ] ) ) ? esc_attr( $_REQUEST[ 'wh_keyword' ] ) : ''    // Value of Text field
                                                , 'placeholder' => __('Enter Keyword here', 'booking')
                                                , 'style' => ''                 // CSS of select element
                                                , 'class' => ''                 // CSS Class of select element
                                                , 'attr' => array()             // Any  additional attributes, if this radio | checkbox element 

                                            ) 
                        )
                  );     
        ?><div class="control-group wpbc-no-padding"><?php 
                wpbc_bs_input_group( $params );                   
        ?></div><?php

    }    


    /** S a v e  |   D e l e t e     F i l t e r s     T e m p l a t e */
    function wpbc_filter_template_save_delete() {

        ?><span class="advanced_booking_filter" style="display:none;">                            
                <div class="control-group" style="float:right;margin-right:0;">
                    <div class="btn-toolbar" role="toolbar" aria-label="...">
                        <div class="btn-group" role="group" aria-label="...">

                            <a title="<?php _e('Save filter settings as default template (Please, click Apply filter button, before saving!)' ,'booking'); ?>" 
                               class="tooltip_top button button-primary" 
                               onclick="javascript: save_bk_listing_filter( '<?php echo get_bk_current_user_id(); ?>',  'default' , '<?php echo wpbc_get_params_in_url( wpbc_get_bookings_url( false ), array('page_num','wh_booking_type') ); ?>' );"
                                ><?php 
                                        _e('Save as Default' ,'booking'); 
                                 ?>  &nbsp; <i class="glyphicon glyphicon-save"></i></a><?php 

                            $saved_tamplate_option = get_user_option( 'booking_listing_filter_' . 'default', get_bk_current_user_id() );
                            if ( false != $saved_tamplate_option ) {
                                ?>    
                                <a title="<?php _e('Delete your previously saved default filer template!' ,'booking'); ?>" 
                                   class="tooltip_top button button-secondary" 
                                   onclick="javascript: delete_bk_listing_filter( '<?php echo get_bk_current_user_id(); ?>',  'default' );"
                                    ><?php 
                                        _e('Delete template' ,'booking'); 
                                    ?> &nbsp; <i class="glyphicon glyphicon-trash"></i></a><?php 
                            } 
                            ?>
                        </div>
                    </div>
                </div>
        </span><?php 
    }


    /** P r i n t    A c t i o n     B u t t o n */
    function wpbc_toolbar_action_print_button() {

        $params = array(  
                          'label_for' => 'actions_print'                              // "For" parameter  of button group element
                        , 'label' => '' //__('Actions:', 'booking')                  // Label above the button group
                        , 'style' => ''                                         // CSS Style of entire div element
                        , 'items' => array(
                                            array(                                                 
                                                  'type' => 'button' 
                                                , 'title' => __('Print', 'booking') . '&nbsp;&nbsp;'    // Title of the button
                                                , 'hint' => array( 'title' => __('Print bookings listing' ,'booking') , 'position' => 'top' ) // Hint
                                                , 'link' => 'javascript:void(0)'        // Direct link or skip  it
                                                , 'action' => "print_booking_listing();"                // Some JavaScript to execure, for example run  the function
                                                , 'class' => ''                        // button-secondary  | button-primary
                                                , 'icon' => ''
                                                , 'font_icon' => 'glyphicon glyphicon-print'
                                                , 'icon_position' => 'right'     // Position  of icon relative to Text: left | right
                                                , 'style' => ''                 // Any CSS class here
                                                , 'mobile_show_text' => true       // Show  or hide text,  when viewing on Mobile devices (small window size).
                                                , 'attr' => array()
                                            )
                                        )
        );             
        wpbc_bs_button_group( $params );            
    }


    /** E x p o r t     A c t i o n s     B u t t o n s */
    function wpbc_toolbar_action_export_print_buttons() {

        $params = array(  
                          'label_for' => 'actions_export'                              // "For" parameter  of button group element
                        , 'label' => '' //__('Actions:', 'booking')                  // Label above the button group
                        , 'style' => ''                                         // CSS Style of entire div element
                        , 'items' => array(
//                                            array(                                                 
//                                                  'type' => 'button' 
//                                                , 'title' => __('Print', 'booking') . '&nbsp;&nbsp;'    // Title of the button
//                                                , 'hint' => array( 'title' => __('Print bookings listing' ,'booking') , 'position' => 'top' ) // Hint
//                                                , 'link' => 'javascript:void(0)'        // Direct link or skip  it
//                                                , 'action' => "print_booking_listing();"                // Some JavaScript to execure, for example run  the function
//                                                , 'class' => ''                        // button-secondary  | button-primary
//                                                , 'icon' => ''
//                                                , 'font_icon' => 'glyphicon glyphicon-print'
//                                                , 'icon_position' => 'right'     // Position  of icon relative to Text: left | right
//                                                , 'style' => ''                 // Any CSS class here
//                                                , 'mobile_show_text' => true       // Show  or hide text,  when viewing on Mobile devices (small window size).
//                                                , 'attr' => array()
//                                            ), 
                                              array(                                                 
                                                  'type' => 'button' 
                                                , 'title' => __('Export', 'booking') . '&nbsp;&nbsp;'    // Title of the button
                                                , 'hint' => array( 'title' => __('Export only current page of bookings to CSV format' ,'booking') , 'position' => 'top' ) // Hint
                                                , 'link' => 'javascript:void(0)'        // Direct link or skip  it
                                                , 'action' => "export_booking_listing('page', '" . wpbc_get_booking_locale() ."' );"                // Some JavaScript to execure, for example run  the function
                                                , 'class' => ''                        // button-secondary  | button-primary
                                                , 'icon' => ''
                                                , 'font_icon' => 'glyphicon glyphicon-export'
                                                , 'icon_position' => 'right'     // Position  of icon relative to Text: left | right
                                                , 'style' => ''                 // Any CSS class here
                                                , 'mobile_show_text' => true       // Show  or hide text,  when viewing on Mobile devices (small window size).
                                                , 'attr' => array()
                                            )
                                            , array(                                                 
                                                  'type' => 'button' 
                                                , 'title' => __('Export All', 'booking') . '&nbsp;&nbsp;'    // Title of the button
                                                , 'hint' => array( 'title' => __('Export All bookings to CSV format' ,'booking') , 'position' => 'top' ) // Hint
                                                , 'link' => 'javascript:void(0)'        // Direct link or skip  it
                                                , 'action' => "export_booking_listing('all', '" . wpbc_get_booking_locale() . "' );"                // Some JavaScript to execure, for example run  the function
                                                , 'class' => ''                        // button-secondary  | button-primary
                                                , 'icon' => ''
                                                , 'font_icon' => 'glyphicon glyphicon-export'
                                                , 'icon_position' => 'right'     // Position  of icon relative to Text: left | right
                                                , 'style' => ''                 // Any CSS class here
                                                , 'mobile_show_text' => true       // Show  or hide text,  when viewing on Mobile devices (small window size).
                                                , 'attr' => array()
                                            )
                                        )
        );             
        wpbc_bs_button_group( $params );            
    }
    
    
    ////////////////////////////////////////////////////////////////////////////    
    //  B u t t o n s    in    L i s t i n g
    ////////////////////////////////////////////////////////////////////////////  

    /** Show booking resource Label
     * 
     * @param string $bk_booking_type_name  Resource Name
     * @param string $link_show_bookings_of_this_resource  -  Link to  show bookings for this booking resource
     */
    function wpbc_booking_listing_show_label_resource(  $bk_booking_type_name , $link_show_bookings_of_this_resource = ''){

       ?><span class="label label-default label-resource label-info"><?php 
       if (! empty($link_show_bookings_of_this_resource))
           echo "<a href='{$link_show_bookings_of_this_resource}'>" .  $bk_booking_type_name . "</a>";
       else    
            echo $bk_booking_type_name; 
       ?></span><?php
    }
    add_bk_action( 'wpbc_booking_listing_show_label_resource', 'wpbc_booking_listing_show_label_resource');
                                
                                
    /** E d i t    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_edit( $row_data = array() ) {

        // Edit Booking Button
       ?><a href="<?php echo $row_data['edit_booking_url']; ?>" 
            class="tooltip_top button-secondary button" 
            title="<?php _e('Edit Booking' ,'booking'); ?>"
        ><i class="glyphicon glyphicon-edit"></i></a><?php      
    }
    add_bk_action( 'wpbc_booking_listing_button_edit', 'wpbc_booking_listing_button_edit' );
        
    
    /** N o t e s    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_notes( $row_data = array() ) {
            
        // Notes Button
       ?><a href="javascript:void(0)" 
            onclick="javascript: jQuery('#remark_row<?php echo $row_data['id'];?>').toggle();" 
            class="tooltip_top button-secondary button remark_bk_link" 
            title="<?php if ( empty( $row_data['remark'] ) ) { 
                            _e('Edit Note' ,'booking');                             
                        } else { 
                            $my_remark = str_replace(array("\r\n", "\n", "\r"),' ',$row_data['remark']);
                            echo esc_js( substr( $my_remark, 0, 100 ) ); if ( strlen( $my_remark ) > 100 ) { echo '...'; }
                        } ?>"
        ><i class="glyphicon glyphicon-comment <?php if ( ! empty( $row_data['remark'] ) ) echo 'red_icon_color' ?>"></i></a><?php  

    }
    add_bk_action( 'wpbc_booking_listing_button_notes', 'wpbc_booking_listing_button_notes' );
        
    
    /** L o c a l e    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_locale( $row_data = array() ) {
            
        // Notes Button
       ?><a href="javascript:void(0)" 
            onclick="javascript: jQuery('#locale_for_booking<?php echo $row_data['id'];?>').toggle();jQuery(this).hide();" 
            id="button_locale_for_booking<?php echo $row_data[ 'id' ]; ?>" 
            class="tooltip_top button-secondary button" 
            title="<?php echo esc_js( __('Change Language' ,'booking') ); ?>"
        ><i class="glyphicon glyphicon-globe"></i></a><?php  
                
        ?><select   class="wpbc-select-locale"
                    id="locale_for_booking<?php echo $row_data[ 'id' ]; ?>" 
                    name="locale_for_booking<?php echo $row_data[ 'id' ]; ?>"
                    onchange="javascript:jQuery(this).hide();
                                         jQuery('#button_locale_for_booking<?php echo $row_data[ 'id' ]; ?>').show();
                                         jQuery('#button_locale_for_booking<?php echo $row_data[ 'id' ]; ?>').attr('data-original-title', jQuery('#locale_for_booking<?php echo $row_data[ 'id' ]; ?>  option:selected').text() );
                                         jQuery('#button_locale_for_booking<?php echo $row_data[ 'id' ]; ?> i.glyphicon').addClass('red_icon_color');
                                         "
                >
                    <option value=""><?php _e('Default Locale' ,'booking'); ?></option>
                    <option value="en_US" lang="en" data-installed="1">English (United States)</option>
                    <?php 
                    foreach ( $row_data[ 'availbale_locales' ] as $locale ) {
                            printf(
                                    '<option value="%s" lang="%s" data-installed="1">%s</option>',
                                    esc_attr( $locale ),
                                    esc_attr( substr( $locale, 0 , 2 ) ),			
                                    esc_html( $locale )
                            );
                    }
                    ?>
        </select><?php               
    }
    add_bk_action( 'wpbc_booking_listing_button_locale', 'wpbc_booking_listing_button_locale' );
        

    
    /** C h a n g e   r e s o u r c e    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_change_resource( $row_data = array() ) {
            
       ?><a href="javascript:void(0)" 
            onclick='javascript:
                     document.getElementById("new_booking_resource_booking_id").value = "<?php echo $row_data['id']; ?>";
                     setSelectBoxByValue("new_booking_resource", <?php echo $row_data['resource']; ?> );
                     var cbr;
                     cbr = jQuery("#change_booking_resource_controll_elements").detach();
                     cbr.appendTo(jQuery("#changing_bk_res_in_booking<?php echo $row_data['id']; ?>"));
                     cbr = null;
                     jQuery(".booking_row_modification_element_changing_resource").hide();
                     jQuery("#changing_bk_res_in_booking<?php echo $row_data['id']; ?>").show();' 
            class="tooltip_top button-secondary button" 
            title="<?php _e('Change Resource' ,'booking'); ?>"
        ><i class="glyphicon glyphicon-random"></i></a><?php  

    }
    add_bk_action( 'wpbc_booking_listing_button_change_resource', 'wpbc_booking_listing_button_change_resource' );
    

    /** D u p l i c a t e    b o o k i n g    Button for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_button_duplicate( $row_data = array() ) {
        
       ?><a href="javascript:void(0)" 
            onclick='javascript:
                                document.getElementById("duplicate_booking_resource_booking_id").value = "<?php echo $row_data['id']; ?>";
                                setSelectBoxByValue("duplicate_booking_resource", <?php echo $row_data['resource']; ?> );
                                var cbr;
                                cbr = jQuery("#duplicate_booking_resource_controll_elements").detach();
                                cbr.appendTo(jQuery("#changing_bk_res_in_booking<?php echo $row_data['id']; ?>"));
                                cbr = null;
                                jQuery(".booking_row_modification_element_changing_resource").hide();
                                jQuery("#changing_bk_res_in_booking<?php echo $row_data['id']; ?>").show();' 
            class="tooltip_top button-secondary button" 
            title="<?php _e('Duplicate Booking' ,'booking'); ?>"
        ><i class="glyphicon glyphicon-duplicate"></i></a><?php  

    }
    add_bk_action( 'wpbc_booking_listing_button_duplicate', 'wpbc_booking_listing_button_duplicate' );    
    
    
    ////////////////////////////////////////////////////////////////////////////    
    //  S e c t i o n s
    ////////////////////////////////////////////////////////////////////////////  
    
    /** N o t e s    Section for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_section_notes( $row_data = array() ) {
            
        ?><div  class="booking_row_modification_element booking_edit_note" 
                id="remark_row<?php echo $row_data['id']; ?>" <?php if ( WP_BK_SHOW_BOOKING_NOTES && (! empty($row_data['remark'])) ) { echo 'style="display:block;"'; } ?> >
            
            <textarea id="remark_text<?php echo $row_data['id']; ?>"  
                      name="remark_text<?php echo $row_data['id']; ?>" 
                      cols="2" rows="2" 
                      style="width:99%;margin:5px;"><?php 
                        echo $row_data['remark']; 
            ?></textarea>
            <a  class="button button-primary"
                href="javascript:void(0)" 
                onclick='javascript:wpdev_add_remark(<?php echo $row_data['id']; ?>, document.getElementById("remark_text<?php echo $row_data['id']; ?>").value);'
                ><?php _e('Save' ,'booking'); ?></a>
            <a  class="button button-secondary" 
                style="margin:0px 8px;"
                href="javascript:void(0)" 
                onclick='javascript:jQuery("#remark_row<?php echo $row_data['id']; ?>").hide();' 
                ><?php _e('Cancel' ,'booking'); ?></a>                    
        </div><?php               
    }
    add_bk_action( 'wpbc_booking_listing_section_notes', 'wpbc_booking_listing_section_notes' );
        
    
    /** C h a n g e   r e s o u r c e    Section for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_booking_listing_section_change_resource( $row_data = array() ) {
          
        ?><div id="changing_bk_res_in_booking<?php echo $row_data['id']; ?>" class="booking_row_modification_element_changing_resource booking_row_modification_element" ></div><?php 
    }
    add_bk_action( 'wpbc_booking_listing_section_change_resource', 'wpbc_booking_listing_section_change_resource' );
        

    /** Change & Duplicate Resources Real List   - Section for Booking Listing
     * 
     * @param array $row_data - Data Array
     */
    function wpbc_listing_show_change_booking_resources(  $booking_types ){

      ?>
      <div id="hided_boking_modifications_elements">
        <div id="change_booking_resource_controll_elements">
            <input type="hidden" value="" id="new_booking_resource_booking_id" />
            <select id="new_booking_resource" name="new_booking_resource" style="margin:3px 5px;">
                <?php
                foreach ($booking_types as $mm) { ?>
                <option value="<?php echo $mm->id; ?>"
                      style="<?php if  (isset($mm->parent)) if ($mm->parent == 0 ) { echo 'font-weight:600;'; } else { echo 'font-size:11px;padding-left:20px;'; } ?>"
                    ><?php echo $mm->title; ?></option>
                <?php } ?>
            </select>
            <a href="javascript:void(0)" class="button button-primary"   style="margin:3px 7px 7px 5px;"
                   onclick='javascript:wpdev_change_bk_resource(document.getElementById("new_booking_resource_booking_id").value, document.getElementById("new_booking_resource").value);
                     var cbrce;
                     cbrce = jQuery("#change_booking_resource_controll_elements").detach();
                     cbrce.appendTo(jQuery("#hided_boking_modifications_elements"));
                     cbrce = null;
                     jQuery(".booking_row_modification_element_changing_resource").hide();
                   ' ><?php _e('Change' ,'booking'); ?></a>
            <a href="javascript:void(0)" class="button button-secondary" style="margin:3px 7px 7px 2px;"
                   onclick='javascript:
                     var cbrce;
                     cbrce = jQuery("#change_booking_resource_controll_elements").detach();
                     cbrce.appendTo(jQuery("#hided_boking_modifications_elements"));
                     cbrce = null;
                     jQuery(".booking_row_modification_element_changing_resource").hide();
                 ' ><?php _e('Cancel' ,'booking'); ?></a>
            <div class="clear"></div>
        </div>
      </div>
      <?php
      //FixIn:5.4.5.1
      ?>
      <div id="hided_boking_duplication_elements" class="hided_boking_modifications_elements">
        <div id="duplicate_booking_resource_controll_elements">
            <input type="hidden" value="" id="duplicate_booking_resource_booking_id" />
            <select id="duplicate_booking_resource" name="duplicate_booking_resource" style="margin:3px 5px;">
                <?php
                foreach ($booking_types as $mm) { ?>
                <option value="<?php echo $mm->id; ?>"
                      style="<?php if  (isset($mm->parent)) if ($mm->parent == 0 ) { echo 'font-weight:600;'; } else { echo 'font-size:11px;padding-left:20px;'; } ?>"
                    ><?php echo $mm->title; ?></option>
                <?php } ?>
            </select>
            <a href="javascript:void(0)" class="button button-primary"   style="margin:3px 7px 7px 5px;"
                   onclick='javascript:wpbc_duplicate_booking_to_resource(document.getElementById("duplicate_booking_resource_booking_id").value, document.getElementById("duplicate_booking_resource").value);
                     var cbrce;
                     cbrce = jQuery("#duplicate_booking_resource_controll_elements").detach();
                     cbrce.appendTo(jQuery("#hided_boking_duplication_elements"));
                     cbrce = null;
                     jQuery(".booking_row_modification_element_changing_resource").hide();
                   ' ><?php _e('Duplicate Booking' ,'booking'); ?></a>
            <a href="javascript:void(0)" class="button button-secondary" style="margin:3px 7px 7px 2px;"
                   onclick='javascript:
                     var cbrce;
                     cbrce = jQuery("#duplicate_booking_resource_controll_elements").detach();
                     cbrce.appendTo(jQuery("#hided_boking_duplication_elements"));
                     cbrce = null;
                     jQuery(".booking_row_modification_element_changing_resource").hide();
                 ' ><?php _e('Cancel' ,'booking'); ?></a>
            <div class="clear"></div>
        </div>
      </div>     
      <?php           
    }
    add_bk_action( 'wpbc_listing_show_change_booking_resources', 'wpbc_listing_show_change_booking_resources');
    
    ////////////////////////////////////////////////////////////////////////////    
    //  M o d a l s
    ////////////////////////////////////////////////////////////////////////////  
        
    /** Print Loyout - Modal Window structure */    
    function wpbc_write_content_for_modal_print() {
              
      ?><div id="wpbc_print_modal" class="modal wpbc_popup_modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">   
                    <h4 class="modal-title"><?php _e('Print bookings' ,'booking'); ?>
                    <div style="float:right;">    
                        <a  href="javascript:void(0);"
                            onclick="javascript: jQuery( '#print_loyout_content_action' ).print();                                       
                                                 //jQuery('#wpbc_print_modal').modal('hide');       //FixIn:6.2.3.8 fix of not printning in Chrome
                                                 //jQuery('#print_loyout_content').html('');        //FixIn:6.2.3.8 fix of not printning in Chrome"       
                            class="button button-primary" ><?php _e('Print' ,'booking'); ?></a>
                        <a  href="javascript:void(0)" class="button" data-dismiss="modal"><?php _e('Close' ,'booking'); ?></a>
                        <?php /* <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> */ ?>
                        
                    </div></h4>                    
                </div>
                <div class="modal-body">
                    <div id="print_loyout_content_action" class="">
                        <div id="print_loyout_content" class="wpdevelop"> ------ </div>
                    </div>
                </div>
                <?php /* ?>
                <div class="modal-footer">
                    <button type="button" class="button button-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="button button-primary">Save changes</button>
                </div>
                <?php */ ?>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php         
    }
    add_bk_action( 'wpbc_write_content_for_modals', 'wpbc_write_content_for_modal_print');    

    
    /** Payment Request Loyout - Modal Window structure */    
    function wpbc_write_content_for_modal_export_csv( $filename, $bk_upload_dir ) {
        
      ?><div id="wpbc_export_csv_modal" class="modal wpbc_popup_modal" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">   
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php _e('Export bookings' ,'booking'); ?></h4>                    
                </div>
                <div class="modal-body">
                    <label class="help-block"><?php printf(__('Download the CSV file of exported booking data' ,'booking'),'<b>',',</b>');?></label>
                </div>
                <div class="modal-footer"  style="text-align:center;">
                    <?php 
                    if ( file_exists( dirname(__FILE__) . '/../../../uploads/' . $filename ) ) $csv_position = '';
                    else $csv_position = '?csv_dir=' . $bk_upload_dir ;                
                    ?>   
                    <a href="<?php echo WPBC_PLUGIN_URL . '/inc/_ps/wpdev-get-exported-csv.php' . $csv_position ; ?>" target="_blank" class="button button-primary"  style="float:none;" >
                        <?php _e('Download' ,'booking'); ?>
                    </a>
                    <a href="javascript:void(0)" class="button button-secondary" data-dismiss="modal"><?php _e('Close' ,'booking'); ?></a>
                </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script type="text/javascript"> 
            jQuery("#wpbc_content_for_modals").after( jQuery("#ajax_respond #wpbc_export_csv_modal") );
            jQuery("#wpbc_export_csv_modal").modal("show");
        </script>        
        <?php         
    }
    add_bk_action( 'wpbc_write_content_for_modal_export_csv', 'wpbc_write_content_for_modal_export_csv');
     
    
    ////////////////////////////////////////////////////////////////////////////
    // B O O K I N G    R e s o u r c e s   S E L E C T O R    [C H O O S E N]
    ////////////////////////////////////////////////////////////////////////////

    /** Check   &   Modify:    $_REQUEST['wh_booking_type'] 
     * 
            Timeline - GET           
                         null  - Empty   - OLD ALL view 
                         56    - Single  - One Res View
                         56,5  - SEVERAL - Matrix View
                        56,....55 - All resources - Matrix      -- PROBLEM that in the field is listied all resources and "All resource" item - Next clik twice this view
            Listing - POST  
                         NOT SET - load default resource.
                         Array(56 )   - SINGLE - 
                         Array(56, 5) - SEVERAL -
                         Array([0] => 56,1,5,6,7,8,9,13,24,25,26,4,3,2,10,11,12,55
                               [1] => 56
                               [2] => 1
                                  All resources - Matrix      -- PROBLEM that in the field is listied all resources and "All resource" item - Next clik twice this view       
                         Array([0] => 56
                                ...
                               [17] => 55 )
                                  All resources 
     */
    function wpbc_check_request_param__wh_booking_type() {

        //debuge($_REQUEST);        

        if ( isset($_REQUEST['wh_booking_type'])) {

            // Firstly we get ARRAY if we had the String            
            if (is_string($_REQUEST['wh_booking_type'])) {
                if  ( strpos($_REQUEST['wh_booking_type'], ',') !== false ) {
                    $_REQUEST['wh_booking_type'] = explode(',', $_REQUEST['wh_booking_type']);
                }
            }    

            // Now transform array  to  the String
            if ( is_array($_REQUEST['wh_booking_type'])) {
                $wh_booking_type_array = $_REQUEST['wh_booking_type'] ;                    
                foreach ($wh_booking_type_array as $key=>$value) {
                    if (empty($value)) 
                        unset($wh_booking_type_array[$key]);
                }
                // If we are had some array and in array element was like this [0] => 56,1,5,55 ; [1] => 56, so now we are have this: => 56,1,5,55,56
                $_REQUEST['wh_booking_type'] = implode(',', $wh_booking_type_array);
            }

            // Remove dupplicates -  Now trasform to Array again; Remove dubplicates and Get Array again, its because issue if we are have ALL Resources option.
            $_REQUEST['wh_booking_type'] = explode(',', $_REQUEST['wh_booking_type']);
            $_REQUEST['wh_booking_type'] = array_unique($_REQUEST['wh_booking_type']);
            $_REQUEST['wh_booking_type'] = implode(',', $_REQUEST['wh_booking_type']);

            // If No any selections, its mean that  we are received NULL, so  then we are set  the value to "" and we are show all bookings in old view mode.
            if  ($_REQUEST['wh_booking_type']=='null') {
                $_REQUEST['wh_booking_type'] = '';
            }

        } else {  // E M P T Y     -  Load default parameter

            $_REQUEST['wh_booking_type'] = get_bk_option( 'booking_default_booking_resource');

            // If default selection  is Empty so its mean load All resources.
            if (empty($_REQUEST['wh_booking_type'])) {
                $types_list = wpbc_get_br_as_objects();
                $types_list_id = array();
                foreach ($types_list as $tl) { 
                    $types_list_id[] = $tl->id;
                }
                $_REQUEST['wh_booking_type'] = implode(',',$types_list_id);
            }
        }
    }
    add_bk_action( 'wpbc_check_request_param__wh_booking_type', 'wpbc_check_request_param__wh_booking_type');
    
    
    /** Resources Selection for Listing */
    function wpbc_br_selection_for_listing(){
        
        ?><div class="clear"></div><?php
        
        wpbc_get_data_for_resource_selection();
        
        ?><script type="text/javascript">
                function reload_booking_calendar_oveview_page(){
                    booking_filters_form.submit();
                }
        </script><?php
    }
    add_bk_action( 'wpbc_br_selection_for_listing', 'wpbc_br_selection_for_listing');
    
        
    /** Resources Selection for Timeline */
    function wpbc_br_selection_for_timeline(){    
        
        ?><div class="clear"></div><?php

        wpbc_get_data_for_resource_selection();

        ?><script type="text/javascript">
            function reload_booking_calendar_oveview_page(){
                var resource_value = jQuery( '#wh_booking_type' ).val();
                if ( resource_value == null ) resource_value = jQuery("#wh_booking_type option:first").val();       // Assign  first value - all booking resources 
                if ( resource_value == null ) resource_value = '';                
                window.location.assign("<?php 
                                                 $bk_admin_url = wpbc_get_params_in_url( wpbc_get_bookings_url( false ), array('wh_booking_type') );
                                            echo $bk_admin_url . '&wh_booking_type='; ?>" +  resource_value );
            }        
        </script><?php
    }
    add_bk_action( 'wpbc_br_selection_for_timeline', 'wpbc_br_selection_for_timeline');

                
    /** Get data for Resource Selection elemnt - [C H O O S E N] */
    function wpbc_get_data_for_resource_selection(){

        $types_list = wpbc_get_br_as_objects();
        $wpdevbk_id = 'wh_booking_type';                                        //  {'', '1', '4,7,5', .... }
        $wpdevbk_selectors = array();
        $all_ids = array();
        foreach ($types_list as $bkr) {
            $all_ids[] = $bkr->id;
        }
        if (count($all_ids)>1)
        $wpdevbk_selectors['<strong>'.__('All resources' ,'booking').'</strong>']=implode(',',$all_ids);

        foreach ($types_list as $bkr) {
            $bkr_title = $bkr->title;
            if (isset($bkr->parent)) {
                if ($bkr->parent == 0)
                    $bkr_title = $bkr_title;
                else
                    $bkr_title = '&nbsp;&nbsp;&nbsp;' . $bkr_title ;
            }
            $wpdevbk_selectors[ $bkr_title  ] = $bkr->id;
        }

        $wpdevbk_control_label =   '';
        $wpdevbk_help_block =      __('Booking resources' ,'booking');

        wpbc_toolbar_filter_choosen( $wpdevbk_id, $wpdevbk_selectors, $wpdevbk_control_label, $wpdevbk_help_block );
    }
    

    /** B o o k i n g    R e s o u r c e s    S e l e c t o r    [C H O O S E N]
     * 
     * @param string $wpdevbk_id                - HTML ID of element
     * @param array $wpdevbk_selectors          - array( 'Title' => Value )
     * @param string $wpdevbk_control_label
     * @param string $wpdevbk_help_block
     */
    function wpbc_toolbar_filter_choosen( $wpdevbk_id, $wpdevbk_selectors, $wpdevbk_control_label, $wpdevbk_help_block){
        
        if ( isset( $_REQUEST[$wpdevbk_id] ) )      $wpdevbk_value = $_REQUEST[$wpdevbk_id];
        else                                        $wpdevbk_value = '';
        
        if ( strpos($wpdevbk_value,',') !== false ) $wpdevbk_value_array = explode (',', $wpdevbk_value);
        else                                        $wpdevbk_value_array = array();
        
        $wpdevbk_selector_default = array_search( $wpdevbk_value, $wpdevbk_selectors );
//debuge($_REQUEST,$wpdevbk_selector_default, $wpdevbk_value, $wpdevbk_selectors);        
        if ( $wpdevbk_selector_default === false ) 
            $wpdevbk_selector_default = current($wpdevbk_selectors);
        
        ?>
        <div class="control-group">
            <div class="btn-toolbar">
                <select multiple="multiple" class="chzn-select" style="float:left;"
                        id="<?php echo $wpdevbk_id; ?>" name="<?php echo $wpdevbk_id; ?>[]" data-placeholder="<?php echo $wpdevbk_help_block; ?>"                       
                         >
                  <?php
                  $is_all_resources_selected = false;
                  foreach ($wpdevbk_selectors as $key=>$value) {
                    if ($value != 'divider') {
                        $is_in_array = in_array($value, $wpdevbk_value_array);
                        ?><option <?php if ( ( ($wpdevbk_value == $value ) || ($is_in_array)  ) && (! $is_all_resources_selected) ) { echo ' selected="SELECTED" ';
                                        if ( strpos($value,',') !== false ) {
                                            $is_all_resources_selected = true;
                                        }
                                   } ?> 
                            <?php if (strpos($key , '&nbsp;') === false) echo ' style="font-weight:600;" '; ?>
                            value="<?php echo $value; ?>"><?php echo $key; ?></option><?php
                    } else {
                        ?><?php
                    }
                  } ?>
              </select>
              <div class="chzn-right-buttons btn-group">  
                    <input type="hidden" name="blank_field__this_field_only_for_formatting_buttons" value=""> 
                    <a  data-original-title="<?php _e('Clear booking resources selection' ,'booking'); ?>"  rel="tooltip" 
                        class="tooltip_top button button-secondary wpbc_stick_left wpbc_stick_right"
                        onclick="javascript:remove_all_options_from_choozen('#<?php echo $wpdevbk_id; ?>');"
                        ><i class="glyphicon glyphicon-remove icon"></i></a>
                    <a data-original-title="<?php _e('Apply booking resources selection' ,'booking'); ?>"  rel="tooltip" 
                       class="tooltip_top button button-primary wpbc_stick_left"
                       onclick="javascript:reload_booking_calendar_oveview_page();"
                       ><i class="glyphicon glyphicon-refresh glyphicon glyphicon-white"></i></a>                  
              </div>
            </div>                                
        </div>

        <script type="text/javascript">

            function remove_all_options_from_choozen( selectbox_id ){
              jQuery( selectbox_id +' option').removeAttr('selected');    // Disable selection in the real selectbox
              jQuery( selectbox_id ).trigger('liszt:updated');            // Remove all fields from the Choozen field              
            } 

            jQuery(document).ready( function(){

              jQuery("#<?php echo $wpdevbk_id; ?>").chosen({no_results_text: "No results matched"});

              // Catch any selections in the Choozen
              jQuery("#<?php echo $wpdevbk_id; ?>").chosen().change( function(va){ 

                  if( jQuery("#<?php echo $wpdevbk_id; ?>").val() != null ) {
                      //So we are having aready values
                      jQuery.each( jQuery("#<?php echo $wpdevbk_id; ?>").val() , function(index, value) {

                          if (value.indexOf(',')>0) { // Ok we are have array with  all booking resources ID
                              jQuery( '#<?php echo $wpdevbk_id; ?>' + ' option').removeAttr('selected');    // Disable selection in the real selectbox
                              jQuery( '#<?php echo $wpdevbk_id; ?>' + ' option:first-child').prop("selected", true);    // Disable selection in the real selectbox
                              jQuery( '#<?php echo $wpdevbk_id; ?>' ).trigger('liszt:updated');            // Update all fields from the Choozen field              
                              var my_message = '<?php echo html_entity_decode( esc_js( __('Please note, its not possible to add new resources, if "All resources" option is selected. Please clear the selection, then add new resources.' ,'booking') ),ENT_QUOTES) ; ?>';
                              wpbc_admin_show_message( my_message, 'warning', 10000 );
                          }
                      });
                  } 
              });
            });
        </script>
        <style type="text/css">   
              .chzn-right-buttons {
                  float:left;
                  margin:0 0 0 -100px;
              }
              .bookingpage .wpdevelop a.chzn-single {
                  height: 23px;
                  margin-top: 2px;
              }
              #<?php echo $wpdevbk_id; ?>, 
              .chzn-container-multi  {
                   float: left;
                  margin: 0 -5px 0 5px;
                  width: auto !important;
                  box-shadow:0 1px 0 #fff inset, 0 1px 0 rgba(0, 0, 0, 0.07);
                  border-color:#999;
              }
              .chzn-container .chzn-drop,
              #<?php echo $wpdevbk_id; ?>, 
              .chzn-container-multi {
                  min-width:150px;
              }
              /* LI options */
              .chzn-container-multi .chzn-choices {
                  height:auto !important;
                  -webkit-border-radius: 2px 0 0 2px;
                  -moz-border-radius: 2px 0 0 2px;
                  border-radius: 2px 0 0 2px;
              }
              /* Search  hidden button */
              .chzn-container-multi .chzn-choices  {
                  min-height: 28px;
              }
              .chzn-container-multi .chzn-choices .search-field input{
                  height: 26px;
                  line-height:14px;
                  font-size:12px;
                  margin:0;
                  padding: 0 0 0 10px;                        
              }
              .chzn-container-multi .chzn-choices .search-choice {   
                  white-space: nowrap;
                  background: #eee;    
                  margin: 4px 0 0px 5px;
                  padding: 2px 20px 0px 5px;                        
              }
              .chzn-container-multi .chzn-choices .search-choice a.search-choice-close{
                  background:none;
                  display: inline-block;
                  font-family: "Glyphicons Halflings";
                  font-style: normal;
                  font-weight: 400;
                  font-size:9px;
                  line-height: 1;
                  position: relative;
                  top: 1px;  
                  left:12px;
                  color:#555;
                  text-decoration: none;
              }
              .chzn-container-multi .chzn-choices .search-choice a.search-choice-close:hover{
                  text-decoration: none;
              }
              .chzn-container-multi .chzn-choices .search-choice a.search-choice-close:before {
                  content: "\e014";
              }

              .chzn-container {
                  font-size: 12px;
                  font-weight: 400;
              }
              .chzn-container-multi .chzn-choices {
                  border: 1px solid #bbb;
              }    
              .chzn-container .chzn-results .highlighted {
                  background:#08C;
              }
              @media (max-width: 782px) {
                  .chzn-container-multi .chzn-choices {
                      min-height: 34px;
                  }
                  .chzn-container-multi .chzn-choices .search-field input {
                      height: 30px !important;
                      margin:1px 0 !important;
                      line-height:30px !important;
                      font-size:13px;
                  }
                  .chzn-container-multi .chzn-choices .search-choice {
                      margin: 5px 0 1px 5px;
                      padding: 4px 20px 3px 5px;
                  }                        
              }
        </style>
        <?php
    }

    
    ////////////////////////////////////////////////////////////////////////////    
    //  B u t t o n s   -  ADD NEW Booking page
    ////////////////////////////////////////////////////////////////////////////  
    
    /** Selection of booking resources */
    function wpbc_toolbar_btn__resource_selection( $params = array() ) {

        
        $defaults = array( 
                              'on_change'   => false
                            , 'title'       => __('Booking resource', 'booking') . ':'
                            , 'resource_type'   => 'all'                            // single_parent
                            , 'resources' => array()
                        );
        $params = wp_parse_args( $params, $defaults );
        
        
        
        //$resource_objects = wpbc_get_br_as_objects();
    
        $resources_cache = wpbc_br_cache();                                     // Get booking resources from  cache        
        
        if ( $params['resource_type'] == 'single_parent' )
            $resource_objects = $resources_cache->get_single_parent_resources();
        else 
            $resource_objects = $resources_cache->get_resources();
            

       
        
        $resource_options = $params['resources'];

        foreach ( $resource_objects as $br) {

            $br_option = array();
            $br_option['title'] = apply_bk_filter('wpdev_check_for_active_language', $br['title'] );

            if ( (isset( $br['parent'] )) && ($br['parent'] == 0 ) && (isset( $br['count'] )) && ($br['count'] > 1 ) )
                $br_option['title'] .= ' [' . __('parent resource', 'booking') . ']';


            $br_option['class'] = 'wpbc_single_resource';
            if ( isset( $br['parent'] ) ) {
                if ( $br['parent'] == 0 ) {
                    if (  ( isset( $br['count'] ) ) && ( $br['count'] > 1 )  )
                        $br_option['class'] = 'wpbc_parent_resource';
                } else {
                    $br_option['class'] = 'wpbc_child_resource';
                }
            } 


            if (  ( isset( $_GET['booking_type'] ) ) && ( $_GET['booking_type'] == $br['id'] )  ) {
                $br_option['selected'] = true;
            }

            if (  ( isset( $br['parent'] ) ) && ( $br['parent'] == 0 ) && ( isset( $br['count'] ) ) && ( $br['count'] > 1 )  ) {
                 $sufix = '&parent_res=1';
                 if ( empty( $_GET['parent_res'] ) ){
                     $br_option['selected'] = false;
                 }
            } else $sufix = '';

            $resource_options[ $br['id'] . $sufix ] = $br_option;


            //Parent booking resource show as "child booking resource"
            if ( (isset( $br['parent'] )) && ( $br['parent'] == 0 ) && (isset( $br['count'] )) && ( $br['count'] > 1 ) ) {

                $br_option['title'] = substr( $br_option['title'], 0, -1 * strlen( ' (' . __('parent resource', 'booking') . ')' ) );

                $br_option['class'] = 'wpbc_child_resource';

                if ( isset( $_GET['booking_type'] ) && ( empty( $_GET['parent_res'] ) && ( $_GET['booking_type'] == $br['id'] ) ) )
                    $br_option['selected'] = true;
                else 
                    $br_option['selected'] = false;

                $resource_options[ $br['id'] ] = $br_option;
            }

            if ( $resource_options[ $br['id'] ]['class'] === 'wpbc_child_resource' ) {
                $resource_options[ $br['id'] ]['title'] = ' &nbsp;&nbsp;&nbsp; ' . $resource_options[ $br['id'] ]['title'];
            }

        }

        ////////////////////////////////////////////////////////////////////////////

        $parameter_name = 'booking_type';
        
//        if ( isset( $_GET[ $parameter_name ] ) )    $selected_value = intval ( $_GET[ $parameter_name ]  );
//        else                                        $selected_value = 0;
             
        if ( $params['on_change'] === false ) {
            
            $link_base = wpbc_get_new_booking_url__base( array( $parameter_name, 'booking_form', 'parent_res' ) ) . '&' . $parameter_name . '=' ;        
            
            $on_change = 'location.href=\'' . $link_base . '\' + this.value;';
            
        } else {
            $on_change = $params['on_change'];
        }
        
//        $on_change = 'location.href=\'' . wpbc_get_new_booking_url(true, false ) . '&booking_type=' . '\' + this.value;';

        $params = array(  
                          'label_for' => 'calendar_type'                        // "For" parameter  of label element
                        , 'label' => ''                                         // Label above the input group
                        , 'style' => ''                                         // CSS Style of entire div element
                        , 'items' => array(
                                        array(      
                                            'type' => 'addon' 
                                            , 'element' => 'text'               // text | radio | checkbox
                                            , 'text' => $params['title']
                                            , 'class' => ''                     // Any CSS class here
                                            , 'style' => 'font-weight:600;'     // CSS Style of entire div element
                                        )  
                                        , array(    
                                              'type' => 'select'  
                                            , 'id' => 'select_booking_resource'             // HTML ID  of element  - previously - calendar_type
                                            , 'name' => 'select_booking_resource'           // HTML ID  of element
                                            , 'options' => $resource_options                // Associated array  of titles and values 
                                            //, 'disabled_options' => array( 'any' )        // If some options disbaled,  then its must list  here
                                            //, 'default' => 'specific'         // Some Value from optins array that selected by default                                      
                                            , 'style' => ''                     // CSS of select element
                                            , 'class' => ''                     // CSS Class of select element
                                            , 'attr' => array()                 // Any  additional attributes, if this radio | checkbox element 
                                            , 'onchange' => $on_change                  /* if (this.value == '+') location.href='<?php echo $link_base_plus; ?>'; else location.href='<?php echo $link_base; ?>' + this.value; */
                                        )
                        )
                  );     
        ?><div class="control-group wpbc-no-padding"><?php 
                wpbc_bs_input_group( $params );                   
        ?></div><?php

    }

    
    ////////////////////////////////////////////////////////////////////////////
    //  Toolbar for Booking > Resources page -          Add New Resource
    ////////////////////////////////////////////////////////////////////////////

    /** Show Help Dropdown menu at Booking > Resources page at Top Right side of Toolbar
     * 
     * @param string $menu_in_page_tag - active page
     */    
    function wpbc_toolbar_add_new_booking_resource__help( $menu_in_page_tag ) {

        if ( $menu_in_page_tag == 'wpbc-resources' ) {

           wpbc_bs_dropdown_menu_help();
        }
    }
    add_action( 'wpbc_toolbar_top_tabs_after', 'wpbc_toolbar_add_new_booking_resource__help' );


    /** Show Toolbar at  Booking > Resources page - Add New Resource */
    function wpbc_add_new_booking_resource_toolbar() {

        wpbc_clear_div();

        $max_resources = 200; 
                
        $max_resources = apply_filters( 'wpbc_check_max_allowed_booking_resources', $max_resources );       // Here we need to check about number of exist booking resources and maximum allowed booking resources in  Booking Calendar MultiUser version and update this value
     
        if ( $max_resources <= 0 ) return;

        
        //  Toolbar ////////////////////////////////////////////////////////////////

        ?><div id="toolbar_booking_resources" style="position:relative;"><?php


            // <editor-fold     defaultstate="collapsed"                        desc=" T O P    T A B s "  >

            // Show Tabs only in for PS and BS versions other versions already  have it.
            if ( ! class_exists( 'wpdev_bk_biz_m' ) ) {                             

                wpbc_bs_toolbar_tabs_html_container_start();

                    wpbc_bs_display_tab(   array(
                                                        'title'         => __('Add New Booking Resource(s)', 'booking')
                                                        // , 'hint' => array( 'title' => __('Manage bookings' ,'booking') , 'position' => 'top' )
                                                        , 'onclick'     =>  ""
                                                        , 'font_icon'   => 'glyphicon glyphicon-plus'
                                                        , 'default'     => true
                                        ) ); 

                    wpbc_bs_dropdown_menu_help();

                wpbc_bs_toolbar_tabs_html_container_end();
            } 
            // </editor-fold>

            wpbc_bs_toolbar_sub_html_container_start();

            //  T o o l b a r
            ?><div id="booking_resources_toolbar_container" class="visibility_container clearfix-height" style="display:block;margin-top:-5px;"><?php 

            $submit_form_name = 'wpbc_form_add_new_booking_resources';
            ?><form  name="<?php echo $submit_form_name; ?>" id="<?php echo $submit_form_name; ?>" action="" method="post" autocomplete="off"><?php         

                // N o n c e   field, and key for checking   S u b m i t 
                wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo $submit_form_name; ?>" id="is_form_sbmitted_<?php echo $submit_form_name; ?>" value="1" /><?php                 

                //                                                                              <editor-fold   defaultstate="collapsed"   desc=" Resource Title " >    
                $params = array(  
                              'label_for' => 'booking_resource_name'                // "For" parameter  of label element
                            , 'label' => '' //__('Add New Field', 'booking')        // Label above the input group
                            , 'style' => ''                                         // CSS Style of entire div element
                            , 'items' => array(     
                                                array(
                                                    'type'          => 'text' 
                                                    , 'id'          => 'booking_resource_name'  
                                                    , 'name'        => 'booking_resource_name'  
                                                    , 'attr' => array( 'maxlength' => '200' )
                                                    , 'label'       => ''  
                                                    , 'disabled'    => false
                                                    , 'class'       => ''
                                                    , 'style'       => 'min-width:220px;'
                                                    , 'placeholder' => __('Enter name of booking resource' ,'booking')                                                                                                                                    
                                                    , 'attr'        => array()
                                                    , 'value' => ''
                                                    , 'onfocus' => ''                                            
                                                )
                                                , array( 
                                                    'type' => 'button'
                                                    , 'title' => __( 'Add New', 'booking' )  // __('Reset', 'booking')
                                                    , 'hint' => array( 'title' => __('Add New Booking Resource(s)' ,'booking') , 'position' => 'top' )
                                                    , 'class' => 'button tooltip_top' 
                                                    , 'font_icon' => 'glyphicon glyphicon-plus'
                                                    , 'icon_position' => 'left'                                                                            
                                                    , 'action' => " if (jQuery('#booking_resource_name' ).val() == '' ) { wpbc_field_highlight( '#booking_resource_name' ); } else { jQuery('#wpbc_form_add_new_booking_resources').submit(); }"
                                                )                            
                                    )
                            );

                ?><div class="new_booking_resource_control_group control-group wpbc-no-padding"><?php 
                        wpbc_bs_input_group( $params );                   
                ?></div><?php     
                //                                                                              </editor-fold>
                
                wpbc_toolbar_btn__selection_element( array(
                                                                'name' => 'resources_count'
                                                              , 'title' => __('Resources count' ,'booking') . ':'
                                                              , 'selected' => 1  
                                                              , 'options' => array_combine( range(1, $max_resources) ,range(1, $max_resources) ) 
                                                ) ) ;                        
                ////////////////////////////////////////////////////////////////////

                ?><div class="control-group wpbc-no-padding" style="float:right;margin-right: 0;margin-left: 15px;"><?php 

                    //                                                                              <editor-fold   defaultstate="collapsed"   desc=" Show | Hide Children " >    
                    if ( class_exists( 'wpdev_bk_biz_l' ) ) {
                        
                        ?><a href="javascript:void(0);" onclick="javascript:jQuery('.wpbc_resource_child').toggle(500);jQuery('.wpbc_show_hide_children').toggle();" 
                             class="button wpbc_show_hide_children tooltip_left" data-original-title="<?php _e('Show Children Resources' , 'booking') ?>" style="display:none;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a><?php    
                        ?><a href="javascript:void(0);" onclick="javascript:jQuery('.wpbc_resource_child').toggle(500);jQuery('.wpbc_show_hide_children').toggle();" 
                             class="button wpbc_show_hide_children tooltip_left" data-original-title="<?php _e('Hide Children Resources' , 'booking') ?>"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></a><?php    
                    }
                    //                                                                              </editor-fold>
                    
                    /** Save Button
                     * Note! This button submit saving of chnages to Booking Resources Table
                        
                        ?><a                 
                             class="button button-primary " 
                             href="javascript:void(0)"
                             onclick="javascript:jQuery('#wpbc_bresources').submit();" 
                             ><?php _e('Save Changes' , 'booking') ?></a><?php    
                    */
                    
                ?></div><?php
                ////////////////////////////////////////////////////////////////////


                ?><span class="advanced_booking_filter" style="display:none;"><div class="clear" style="width:100%;border-bottom:1px solid #ccc;height:10px;"></div><?php 

                //                                                                              <editor-fold   defaultstate="collapsed"   desc=" Parent | Custom Form | Priority " >    
                if ( class_exists( 'wpdev_bk_biz_l' ) ) 
                    wpbc_toolbar_btn__resource_selection(   array( 
                                                                  'on_change'   => ''
                                                                , 'title'       => __('Parent', 'booking') . ':'
                                                                , 'resource_type'   => 'single_parent'                            
                                                                , 'resources'   => array( 0 => array( 'id' => 0, 'title' => ' - ' ) )
                                                        )
                                            );

                if ( class_exists( 'wpdev_bk_biz_m' ) ) 
                    wpbc_toolbar_btn__form_selection(   array( 
                                                                  'on_change'   => ''
                                                                , 'title'       => __('Default Form', 'booking') . ':'
                                                            )            
                                                    );


                if ( class_exists( 'wpdev_bk_biz_l' ) ) {
                    
                    wpbc_toolbar_btn__selection_element( array(
                                                                'name' => 'resources_priority'
                                                              , 'title' => __('Priority' ,'booking') . ':'
                                                              , 'selected' => 0
                                                              , 'options' => array_combine( range(0, 500) ,range(0, 500) ) 
                                                ) ) ;                      
                }
                //                                                                              </editor-fold>

                /** Add New Button
                    * Note! This button submit Add New Resource

                    ?><div class="control-group wpbc-no-padding"><?php 
                        ?><a                 
                             class="button button-primary " 
                             href="javascript:void(0)"
                             onclick="javascript:jQuery('#wpbc_form_add_new_booking_resources').submit();" 
                             ><?php _e('Add New Booking Resource(s)' , 'booking') ?></a><?php    
                    ?></div><?php
                */
                
                ?><div class="clear"></div></span><?php

                wpbc_clear_div();
                
                if ( class_exists( 'wpdev_bk_biz_m' ) ) 
                    wpbc_toolbar_expand_collapse_btn( 'advanced_booking_filter' );   

            ?></div><?php

            wpbc_bs_toolbar_sub_html_container_end();       

        ?></form><?php
        ?></div><?php

        wpbc_clear_div();

    }

    
    /** Submit of New booking resource(s)
     * 
     * @global type $wpdb
     */    
    function wpbc_bresources_check_submit_actions() {

        global $wpdb;
                             
        $submit_form_name = 'wpbc_form_add_new_booking_resources';              // Define form name

        // $this->get_api()->validated_form_id = $submit_form_name;             // Define ID of Form for ability to  validate fields (like required field) before submit.

        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name );  // Its stop show anything on submiting, if its not refear to the original page
//debuge($_POST);

            // Save Changes 

            // Validate Number of booking resources to  create
            $validated_resources_count = WPBC_Settings_API::validate_text_post_static( 'resources_count' );
            $validated_resources_count = intval( $validated_resources_count );
            if ( $validated_resources_count < 1 ) $validated_resources_count = 1;
            if ( $validated_resources_count > 200 ) $validated_resources_count = 200;

            // Here we need to check about number of exist booking resources and maximum allowed booking resources in  Booking Calendar MultiUser version and update this value
            $validated_resources_count = apply_filters( 'wpbc_check_max_allowed_booking_resources', $validated_resources_count );
       
            // Validate Title
            $validated_title = WPBC_Settings_API::validate_text_post_static( 'booking_resource_name' );


            for ( $i = 0; $i < $validated_resources_count; $i++ ) {

                if ( $validated_resources_count > 1 ) $sufix = '-' . ( $i + 1 );
                else                                  $sufix = '';


                // Need this complex query  for ability to  define different paramaters in differnt versions.
                $sql_arr = apply_filters(   'wpbc_resources_table__add_new_sql_array'
                                                    , array(
                                                            'sql'       => array(
                                                                                  'start'      => "INSERT INTO {$wpdb->prefix}bookingtypes "
                                                                                , 'params'     => array( 'title' )    
                                                                                , 'param_types' => array( '%s' )    
                                                                        )
                                                            , 'values'  => array( $validated_title . $sufix )
                                                        )
                                                    , array( 'sufix' => $sufix , 'index' => $i )
                                    );                                                                                                                                                                                    
                $sql = $wpdb->prepare(    $sql_arr['sql']['start']                                                              // SQL
                                            .         '( ' . implode( ', ' , $sql_arr['sql']['params'] ) . ') '
                                            . ' VALUES ( ' . implode( ', ' , $sql_arr['sql']['param_types'] ) . ') '
                                        , $sql_arr[ 'values' ]                                                                  // Array of validated parameters
                                    ); 

//debuge($sql);continue;            
                if ( false === $wpdb->query( $sql )  ){                                                                         // Insert into DB
                    debuge_error( 'Error inserting into DB' ,__FILE__ , __LINE__);                     
                }        
            }
            
            make_bk_action( 'wpbc_reinit_booking_resource_cache' );
        }                        
    }        
    add_action('wpbc_bresources_check_submit_actions', 'wpbc_bresources_check_submit_actions', 10, 0);   