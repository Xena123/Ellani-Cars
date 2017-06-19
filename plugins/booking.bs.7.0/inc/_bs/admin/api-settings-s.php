<?php
/**
 * @version     1.0
 * @package     General Settings API - Saving different options
 * @category    Settings API
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


/** Range Days Selection - Settings ( Calendar ) page 
 * 
 * @param array $fields 
 * @return array
 */
function wpbc_settings_calendar_range_days_selection__bs( $fields, $default_options_values ) {
    
    //  Days Selection - Override from General API Settings ////////////////////
    $field_options = array(
                                'single'   => array( 'title' => __('Single day' ,'booking'),    'attr' => array( 'id' => 'type_of_day_selections_single' ) )
                              , 'multiple' => array( 'title' => __('Multiple days' ,'booking'), 'attr' => array( 'id' => 'type_of_day_selections_multiple' ) )
                              , 'range'    => array( 'title' => __('Range days' ,'booking'),    'attr' => array( 'id' => 'type_of_day_selections_range' ) )
                        );        
    $fields['booking_type_of_day_selections'] = array(   
                                'type'          => 'radio'
                                , 'default'     => $default_options_values['booking_type_of_day_selections']   //'multiple'            
                                , 'title'       => __('Type of days selection in calendar', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'calendar'
                        );

    ////////////////////////////////////////////////////////////////////////////
    //  Range Days Selection 
    ////////////////////////////////////////////////////////////////////////////
    $field_options = array(
                              'fixed'   => array( 'title' =>  sprintf(__('Select a %sFIXED%s number of days with %s1 mouse click%s' ,'booking'),'<strong>','</strong>','<strong>','</strong>')
                                                , 'attr' =>  array( 'id' => 'range_selection_type_fixed' ) )
                            , 'dynamic' => array( 'title' =>  sprintf(__('Select a %sDYNAMIC%s range of days with %s2 mouse clicks%s' ,'booking'),'<strong>','</strong>','<strong>','</strong>')
                                                , 'attr' =>  array( 'id' => 'range_selection_type_dynamic' ) )
                        );

    $fields['booking_range_selection_type'] = array(   
                                'type'          => 'radio'
                                , 'default'     => $default_options_values['booking_range_selection_type']   //'multiple'            
                                , 'title'       => ''
                                , 'description' => '' 
                                , 'options'     => $field_options
                                , 'group'       => 'calendar'
                                , 'tr_class'    => 'wpbc_range_days_selection wpbc_sub_settings_grayed wpbc_range_days_selection_radio'
                        );

    ////////////////////////////////////////////////////////////////////////////
    //  F i x e d 
    ////////////////////////////////////////////////////////////////////////////
    // <editor-fold     defaultstate="collapsed"                        desc=" FIXED "  >
    $field_options = array();
    foreach ( range( 1, 180, 1) as $value ) {
        $field_options[ $value ] = $value;
    }

    $fields['booking_range_selection_days_count'] = array(   
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_range_selection_days_count']   //'3'            
                                , 'title'       => __('Days selection number', 'booking')
                                , 'description' => sprintf(__('Type your %snumber of days for range selection%s' ,'booking'),'<b>','</b>')
                                , 'options'     => $field_options
                                , 'group'       => 'calendar'
                                , 'tr_class'    => 'wpbc_range_days_selection wpbc_sub_settings_grayed wpbc_range_fixed_selection'
                        );

    //  Start day of FIXED range  //////////////////////////////////////////////
    $field_options = array(
                              'specific' => array( 'title' => __('Specific day(s) of week', 'booking'), 'attr' =>  array( 'id' => 'range_fixed_start_day_specific_day' ) )
                            , '-1'       => array( 'title' => __('Any day of week', 'booking'),         'attr' =>  array( 'id' => 'range_fixed_start_day_any_day' ) )
                        );

    $fields['booking_range_start_day'] = array(   
                                'type'          => 'radio'
                                , 'default'     => $default_options_values['booking_range_start_day']   //'-1'            
                                , 'title'       => __('Start day of range', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'calendar'
                                , 'tr_class'    => 'wpbc_range_days_selection wpbc_sub_settings_grayed wpbc_range_fixed_selection'
                        );

    //  Start week days  of FIXED range  ///////////////////////////////////////
    $fields['booking_range_start_day_html_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_range_start_day_week 
                                                                            wpbc_range_days_selection wpbc_sub_settings_grayed 
                                                                            wpbc_range_fixed_selection 
                                                                            wpbc_range_fixed_selection_week_days">
                                                        <th scope="row"></th>
                                                        <td><fieldset>'
                        );        
    $fields['booking_range_start_day0'] = array(  'label'  => __('Sunday' ,'booking'),   'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day1'] = array(  'label'  => __('Monday' ,'booking'),   'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day2'] = array(  'label'  => __('Tuesday' ,'booking'),  'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day3'] = array(  'label'  => __('Wednesday' ,'booking'),'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day4'] = array(  'label'  => __('Thursday' ,'booking'), 'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day5'] = array(  'label'  => __('Friday' ,'booking'),   'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day6'] = array(  'label'  => __('Saturday' ,'booking'), 'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_html_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '          <p class="description">' 
                                                                . __('Select your start day of range selection at week' ,'booking') 
                                                        . '   </p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                        );        
    // </editor-fold>
    
    ////////////////////////////////////////////////////////////////////////////
    //  D y n a m i c
    ////////////////////////////////////////////////////////////////////////////
    // <editor-fold     defaultstate="collapsed"                        desc=" DYNAMIC "  >
    $fields['booking_range_selection_days_count_dynamic_prefix'] = array( 'type' => 'pure_html', 'group' => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_range_selection_days_count_dynamic 
                                                                            wpbc_range_days_selection wpbc_sub_settings_grayed 
                                                                            wpbc_range_dynamic_selection 
                                                                            wpbc_range_dynamic_selection_days_count">
                                                        <th scope="row">
                                                            <label class="wpbc-form-selectbox" for="set_gen_booking_range_selection_days_count_dynamic">' 
                                                            .   wp_kses_post(  __('Days selection number' ,'booking') ) 
                                                            . '</label>
                                                        </th>
                                                        <td><fieldset>'
                        );            
    $field_options = array();
    foreach ( range( 1, 180, 1) as $value ) {
        $field_options[ $value ] = $value;
    }
    //  Min num.  of days selections - DYNAMIC range  //////////////////////////
    $fields['booking_range_selection_days_count_dynamic_label'] = array( 
                                'type'    => 'pure_html'
                                , 'group' => 'calendar' 
                                , 'html'  => WPBC_Settings_API::label_static( 'set_gen_booking_range_selection_days_count_dynamic'
                                                                            , array(   'title'=> __('Min', 'booking'), 'label_css' => 'margin: 0.25em 0 !important;vertical-align: middle;' ) )
        );    
    $fields['booking_range_selection_days_count_dynamic'] = array(   
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_range_selection_days_count_dynamic']   //'1'            
                                , 'title'       => __('Min', 'booking')
                                , 'description' => '' 
                                , 'options'     => $field_options
                                , 'group'       => 'calendar'
                                , 'tr_class'    => 'wpbc_range_days_selection wpbc_sub_settings_grayed wpbc_range_dynamic_selection'
                                , 'css'         => 'margin-right:20px'
                                , 'only_field'  => true
                        );
    //  Max num.  of days selections - DYNAMIC range  //////////////////////////
    $fields['booking_range_selection_days_max_count_dynamic_label'] = array( 
                                  'type'  => 'pure_html'
                                , 'group' => 'calendar'
                                , 'html'  => WPBC_Settings_API::label_static( 'set_gen_booking_range_selection_days_max_count_dynamic'
                                                                            , array(   'title'=> __('Max', 'booking'), 'label_css' => 'margin: 0.25em 0 !important;vertical-align: middle;' ) )
        );    
    $fields['booking_range_selection_days_max_count_dynamic'] = array(   
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_range_selection_days_max_count_dynamic']   //'30'            
                                , 'title'       => __('Max', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'calendar'
                                , 'tr_class'    => 'wpbc_range_days_selection wpbc_sub_settings_grayed wpbc_range_dynamic_selection'
                                , 'only_field'  => true
                        );
    
    $fields['booking_range_selection_days_count_dynamic_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '          <p class="description">' 
                                                                . sprintf(__('Select your %sminimum and maximum number of days for range selection%s' ,'booking'),'<b>','</b>')
                                                        . '   </p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                        );        
    
    //  Specific num. of days selections - DYNAMIC range  //////////////////////    
    $fields['booking_range_selection_days_specific_num_dynamic'] = array(   
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_range_selection_days_specific_num_dynamic']   //'1'
                                , 'title'       => __('Specific days selections' ,'booking')
                                , 'placeholder' => '7,14,21,28'
                                , 'description' => sprintf( __('Type your %sspecific%s days, which can be selected by visitors, or leave this value empty. It can be several days separated by comma (example: %s) or by dash (example: %s, its the same like this: %s) or combination (example:%s, its the same like this: %s)' ,'booking')
                                                          ,'<b>','</b>', '<code>7,14,21,28</code>', '<code>3-5</code>', '<code>3,4,5</code>', '<code>3-5,7,14</code>', '<code>3,4,5,7,14</code>')
                                , 'class'       => 'large-text'
                                , 'group'       => 'calendar'
                                , 'tr_class'    => 'wpbc_range_days_selection wpbc_sub_settings_grayed wpbc_range_dynamic_selection'
                        );
    
    
    //  Start day of DYNAMIC range  //////////////////////////////////////////////
    $field_options = array(
                              'specific' => array(
                                                  'title' => __('Specific day(s) of week', 'booking')
                                                , 'attr' =>  array( 'id' => 'range_dynamic_start_day_specific_day' )
                                            )
                            , '-1' => array(
                                                  'title' => __('Any day of week', 'booking')
                                                , 'attr' =>  array( 'id' => 'range_dynamic_start_day_any_day' )
                                            )
                        );

    $fields['booking_range_start_day_dynamic'] = array(   
                                'type'          => 'radio'
                                , 'default'     => $default_options_values['booking_range_start_day_dynamic']   //'-1'            
                                , 'title'       => __('Start day of range', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'calendar'
                                , 'tr_class'    => 'wpbc_range_days_selection wpbc_sub_settings_grayed wpbc_range_dynamic_selection'
                        );

    //  Start week days  of DYNAMIC range  /////////////////////////////////////
    $fields['booking_range_start_day_dynamic_html_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_range_start_day_dynamic_week 
                                                                            wpbc_range_days_selection wpbc_sub_settings_grayed 
                                                                            wpbc_range_dynamic_selection 
                                                                            wpbc_range_dynamic_selection_week_days">
                                                        <th scope="row"></th>
                                                        <td><fieldset>'
                        );        
    $fields['booking_range_start_day_dynamic0'] = array(  'label'  => __('Sunday' ,'booking'),   'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_dynamic1'] = array(  'label'  => __('Monday' ,'booking'),   'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_dynamic2'] = array(  'label'  => __('Tuesday' ,'booking'),  'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_dynamic3'] = array(  'label'  => __('Wednesday' ,'booking'),'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_dynamic4'] = array(  'label'  => __('Thursday' ,'booking'), 'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_dynamic5'] = array(  'label'  => __('Friday' ,'booking'),   'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_dynamic6'] = array(  'label'  => __('Saturday' ,'booking'), 'type' => 'checkbox', 'default' => 'Off', 'only_field' => true, 'group' => 'calendar' );
    $fields['booking_range_start_day_dynamic_html_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '          <p class="description">' 
                                                                . __('Select your start day of range selection at week' ,'booking') 
                                                        . '   </p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                        );        
    // </editor-fold>
            
    $fields = wpbc_override_fields_in_settings_page__bs( $fields );             // Override "Specific number of Week Start days"                                
                    
    return $fields;
}
add_filter('wpbc_settings_calendar_range_days_selection', 'wpbc_settings_calendar_range_days_selection__bs' ,10, 2);


/** Recurrent time  - Settings ( Calendar ) page 
 * 
 * @param array $fields
 * @return array
 */
function wpbc_settings_calendar_recurrent_time_slots__bs( $fields, $default_options_values ) {
    
    //  Divider  ///////////////////////////////////////////////////////////////        
    $fields['hr_calendar_before_recurrent_time'] = array( 'type' => 'hr', 'group' => 'calendar' , 'tr_class'    => 'wpbc_recurrent_check_in_out_time_slots');

    $fields['booking_recurrent_time'] = array(   
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_recurrent_time']   //'Off'            
                            , 'title'       =>  __('Use time selections as recurrent time slots' ,'booking')
                            , 'label'       => __('Check this box if you want to use recurrent time to reserve several days. This means that middle days will be partially booked by actual times, otherwise the time in the booking form will be used as check-in/check-out time for the first and last day of the reservation.' ,'booking')
                            //, 'description' => ''
                            , 'group'       => 'calendar'
                            , 'tr_class'    => 'wpbc_recurrent_check_in_out_time_slots'
        );    
    return $fields;
}
add_filter('wpbc_settings_calendar_recurrent_time_slots', 'wpbc_settings_calendar_recurrent_time_slots__bs' ,10, 2);        // Recurent Times        


/** Check in/out  - Settings ( Calendar ) page 
 * 
 * @param array $fields
 * @return array
 */
function wpbc_settings_calendar_check_in_out_times__bs( $fields, $default_options_values ) { 
    
    $fields['booking_range_selection_time_is_active'] = array(   
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_range_selection_time_is_active']   //'Off'            
                            , 'title'       =>  __('Use check in/out time' ,'booking')
                            , 'label'       => __('Check this option, to use check in/out time during booking process. ' ,'booking')
                            , 'description' => sprintf(__('%s Important!%s This will overwrite any times selection in your booking form.' ,'booking'),'<b>','</b>')
                            , 'group'       => 'calendar'
                            , 'tr_class'    => 'wpbc_recurrent_check_in_out_time_slots'
        );        
    $fields['booking_range_selection_start_time'] = array(  
                            'type'          => 'text'
                            , 'default'     => $default_options_values['booking_range_selection_start_time']   //'12:00'
                            , 'title'         => __('Check-in time' ,'booking')
                            , 'description'   => sprintf(__('Type your %sCheck-in%s time of booking' ,'booking'),'<b>','</b>')
                            , 'group'       => 'calendar'
                            , 'tr_class'    => 'wpbc_recurrent_check_in_out_time_slots wpbc_check_in_out_time_slots wpbc_sub_settings_grayed'
                            , 'class'       => 'wpdev-validates-as-time'
                            , 'css'         => 'width:5em;'
                            , 'placeholder' => '12:00'
                            , 'description_tag' => 'span'
        );    
    $fields['booking_range_selection_end_time'] = array(  
                            'type'          => 'text'
                            , 'default'     => $default_options_values['booking_range_selection_end_time']   //'10:00'
                            , 'title'         => __('Check-Out time' ,'booking')
                            , 'description'   => sprintf(__('Type your %sCheck-Out%s time of booking' ,'booking'),'<b>','</b>')
                            , 'group'       => 'calendar'
                            , 'tr_class'    => 'wpbc_recurrent_check_in_out_time_slots wpbc_check_in_out_time_slots wpbc_sub_settings_grayed'
                            , 'class'       => 'wpdev-validates-as-time'
                            , 'css'         => 'width:5em;'
                            , 'placeholder' => '10:00'
                            , 'description_tag' => 'span'
        );    

    return $fields;
}
add_filter('wpbc_settings_calendar_check_in_out_times', 'wpbc_settings_calendar_check_in_out_times__bs' ,10, 2);            // Check In/Out Times


/** Showing Title for Timeslots  - Settings ( Calendar ) page 
 * 
 * @param array $fields
 * @return array
 */
function wpbc_settings_calendar_title_for_timeslots__bs( $fields, $default_options_values ) {
    
    $fields['booking_highlight_timeslot_word'] = array(   
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_highlight_timeslot_word']   //__('Booked Times:' ,'booking')
                                , 'placeholder' => __('Booked Times:' ,'booking')
                                , 'title'       => __('Title of booked timeslot(s)' ,'booking')
                                , 'description' => sprintf(__('Type your %stitle%s, what will show in mouseover tooltip near booked timeslot(s)' ,'booking'),'<b>','</b>')
                                //,'description_tag' => 'span'
                                , 'class'       => 'regular-text'
                                , 'group'       => 'calendar'
                        );
//    //  Help Section ///////////////////////////////////////////////////////////
//    $fields['help_translation_section_after_timeslot_word'] = array(   
//                                  'type'              => 'help'
//                                , 'value'             => wpbc_get_help_rows_about_config_in_several_languges()
//                                , 'class'             => ''
//                                , 'css'               => ''
//                                , 'description'       => ''
//                                , 'cols'              => 2 
//                                , 'group'             => 'calendar'
//                                , 'tr_class'          => ''
//                                , 'description_tag'   => 'span'
//                        );
    return $fields;
}
add_filter('wpbc_settings_calendar_title_for_timeslots', 'wpbc_settings_calendar_title_for_timeslots__bs' ,10, 2);        // Recurent Times        



/** Time Format  - Settings ( Booking Listing ) page 
 * 
 * @param array $fields
 * @return array
 */
function wpbc_settings_booking_time_format__bs( $fields, $default_options_values ) {
    
    // Time Format /////////////////////////////////////////////////////////////
    $fields['booking_time_format_html_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_listing'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_time_format">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_time_format'
                                                                , array(   'title'=> __('Time Format' ,'booking'), 'label_css' => 'margin: 0.25em 0 !important;vertical-align: middle;' ) )
                                                        .'</th>
                                                        <td><fieldset>'
                        );          
    $field_options = array();
    foreach ( array( 'g:i a', 'g:i A', 'H:i' ) as $format ) {
        $field_options[ esc_attr($format) ] = array( 'title' => date_i18n( $format ) );
    }
    $field_options['custom'] =  array( 'title' =>  __('Custom' ,'booking') . ':', 'attr' =>  array( 'id' => 'time_format_selection_custom' ) );

    $fields['booking_time_format_selection'] = array(   
                                'type'          => 'radio'
                                , 'default'     => 'H:i'
                                , 'options'     => $field_options
                                , 'group'       => 'booking_listing'
                                , 'only_field'  => true
                        );
 
    $booking_time_format = get_bk_option( 'booking_time_format');              
    $fields['booking_time_format'] = array(  
                            'type'          => 'text'
                            , 'default'     => $default_options_values['booking_time_format']   //'H:i'
                            , 'value'       => htmlentities( $booking_time_format )      // Display value of this field in specific way
                            , 'group'       => 'booking_listing'
                            , 'placeholder' => 'H:i'
                            , 'css'         => 'width:5em;' 
                            , 'only_field'  => true
        );    

    $fields['booking_time_format_html_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_listing'
                                , 'html'        => '          <span class="description"><code>' . date_i18n( $booking_time_format ) . '</code></span>'
                                                            . '<p class="description">' 
                                                                . sprintf(__('Type your time format for emails and the booking table. %sDocumentation on time formatting%s' ,'booking'),'<br/><a href="http://php.net/manual/en/function.date.php" target="_blank">','</a>')
                                                        . '   </p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                        );        

    return $fields;
}
add_filter('wpbc_settings_booking_time_format', 'wpbc_settings_booking_time_format__bs' ,10, 2);        // Recurent Times        




/** Auto cancellation / auto approval Settings - Settings ( Auto cancellation / auto approval ) page 
 * 
 * @param array $fields
 * @return array
 */
function wpbc_settings_auto_cancelation_approval_section__bs( $fields, $default_options_values ) {
    
    
    $fields['booking_auto_approve_new_bookings_is_active'] = array(   
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_auto_approve_new_bookings_is_active']   //'Off'            
                            , 'title'       =>  __('Auto approve all new bookings' ,'booking')
                            , 'label'       => sprintf(__('Check this checkbox to %sactivate%s auto approve of all new pending bookings.' ,'booking'),'<b>','</b>')
                            , 'description' => ''
                            , 'group'       => 'auto_cancelation_approval'
        );  
    
    $fields['booking_auto_cancel_pending_unpaid_bk_is_active'] = array(   
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_auto_cancel_pending_unpaid_bk_is_active']   //'Off'            
                            , 'title'       =>  __('Auto-cancel bookings' ,'booking')
                            , 'label'       => sprintf(__('Check this box to %sactivate%s auto-cancellation for pending, unpaid bookings.' ,'booking'),'<b>','</b>')
                            , 'description' => ''
                            , 'group'       => 'auto_cancelation_approval'
        );       

    // Auto Cancel Sub Settings ////////////////////////////////////////////////
    $field_options = array( 1 => '1 ' . __('hour' ,'booking') );
    for ( $i = 2; $i < 24; $i++ ){
        $field_options[ $i ] =  $i . ' ' . __('hours' ,'booking');
    }
    $field_options[ 24 ] =  '1 ' . __('day' ,'booking');
    for ($i = 2; $i < 32; $i++) {
        $field_options[ $i*24 ] =  $i . ' ' . __('days' ,'booking');
    }
    $fields['booking_auto_cancel_pending_unpaid_bk_time'] = array(   
                              'type'        => 'select'
                            , 'default'     => $default_options_values['booking_auto_cancel_pending_unpaid_bk_time']   //'24'            
                            , 'title'       =>__('Cancel bookings older' ,'booking')
                            , 'description' => __('Cancel only pending, unpaid bookings, which are older than this selection.' ,'booking')
                            , 'options'     => $field_options
                            , 'group'       => 'auto_cancelation_approval'
                            , 'tr_class'    => 'wpbc_sub_settings_grayed wpbc_sub_settings_auto_cancelation'
                    );
    $fields['booking_auto_cancel_pending_unpaid_bk_is_send_email'] = array(   
                            'type'          => 'checkbox'
                            , 'default'     => $default_options_values['booking_auto_cancel_pending_unpaid_bk_is_send_email']   //'On'            
                            , 'title'       =>  __('Cancellation email sent' ,'booking')
                            , 'label'       => sprintf(__('Check this box to %ssend%s cancellation email for this resource.' ,'booking'),'<b>','</b>')
                            , 'description' => ''
                            , 'group'       => 'auto_cancelation_approval'
                            , 'tr_class'    => 'wpbc_sub_settings_grayed wpbc_sub_settings_auto_cancelation'
        );       
    $fields['booking_auto_cancel_pending_unpaid_bk_email_reason'] = array(   
                                'type'          => 'textarea'
                                , 'default'     => $default_options_values['booking_auto_cancel_pending_unpaid_bk_email_reason']   //__('This booking canceled because we did not receive payment and the administrator did not approve it.' ,'booking')
                                , 'title'       => __('Reason for cancellation' ,'booking')
                                , 'placeholder' => __('Reason for cancellation' ,'booking')
                                , 'description' => sprintf(__('Type the reason for %scancellation%s for the email template.' ,'booking'),'<b>','</b>')
                                , 'css'         => 'width:100%'
                                , 'rows'        => 2
                                , 'group'       => 'auto_cancelation_approval'
                                , 'tr_class'    => 'wpbc_sub_settings_grayed wpbc_sub_settings_auto_cancelation'
                        );
    
    
    return $fields;
}
add_filter('wpbc_settings_auto_cancelation_approval_section', 'wpbc_settings_auto_cancelation_approval_section__bs' ,10, 2);        // Recurent Times        


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////


/** SUPPORT FUNCTION - Override "Specific number of Week Start days" options for settings page
 * Description:
 * Options "range_start_day_dynamic0-6" and "range_start_day0-6" does not exist in the DB they  exist  only in settings page, 
 * So after loading from DB, we need to get values from  the "range_start_day" and "range_start_day_dynamic" 
 * and depend from this value set options "range_start_day_dynamic0-6" and "range_start_day0-6"
 *
 * @param array $fields
 * @return array
 */
function wpbc_override_fields_in_settings_page__bs( $fields ) {

    // FIXED
    $fixed_week_start = get_bk_option('booking_range_start_day');               // get_bk_option('booking_range_start_day') can be "-1" - any days or "2,3,5" - specific week days

    if ( $fixed_week_start != '-1' ) {                                      
        $fields['booking_range_start_day']['value'] = 'specific';            
        $fixed_week_start = explode( ',', $fixed_week_start );
    } else 
        $fixed_week_start = array();

    for ( $i = 0; $i < 7; $i++ ) {
        if ( in_array( $i, $fixed_week_start ) )    $fields['booking_range_start_day' . $i ]['value'] = 'On';
        else                                        $fields['booking_range_start_day' . $i ]['value'] = 'Off';
    } 

    // DYNAMIC
    $fixed_week_start = get_bk_option('booking_range_start_day_dynamic');               // get_bk_option('booking_range_start_day_dynamic') can be "-1" - any days or "2,3,5" - specific week days

    if ( $fixed_week_start != '-1' ) {                                      
        $fields['booking_range_start_day_dynamic']['value'] = 'specific';            
        $fixed_week_start = explode( ',', $fixed_week_start );
    } else 
        $fixed_week_start = array();

    for ( $i = 0; $i < 7; $i++ ) {
        if ( in_array( $i, $fixed_week_start ) )    $fields['booking_range_start_day_dynamic' . $i ]['value'] = 'On';
        else                                        $fields['booking_range_start_day_dynamic' . $i ]['value'] = 'Off';
    } 

    return $fields;
}


/** Override fields array  of Settings page,  AFTER saving to  DB. Some fields have to have different Values.
 * 
 * @param array $fields
 * @param string $page_id
 * @return array - fields
 */
function wpbc_fields_after_saving_to_db__bs( $fields, $page_id ) {
    if ( $page_id == 'set_gen' ) {
        $fields = wpbc_override_fields_in_settings_page__bs( $fields );         // Override "Specific number of Week Start days"                                
    }
    return $fields;
}
add_filter('wpbc_fields_after_saving_to_db', 'wpbc_fields_after_saving_to_db__bs', 10, 2);


/** Override VALIDATED fields BEFORE saving to DB 
 * Description:
 * Range_start_day_dynamic0-6 and range_start_day0-6 does not exist in the DB
 * they  exist  only in settings page, so  need to  get  values from these options
 * and ovverride values to the "range_start_day" and "range_start_day_dynamic" if its required.
 * 
 * @param array $validated_fields
 */
function wpbc_settings_validate_fields_before_saving__bs( $validated_fields ) {
    
    // FIXED
    if ( $validated_fields['booking_range_start_day'] == '-1' ) {                       // Fixed - Any  week days        
        for ( $i = 0; $i < 7; $i++ ) {
            unset( $validated_fields[ 'booking_range_start_day' . $i ] );
        }
        
    } else {                                                                    // Fixed - Specific Week days
        $validated_fields['booking_range_start_day'] = array();
        for ( $i = 0; $i < 7; $i++ ) {
            if ( $validated_fields[ 'booking_range_start_day' . $i ] == 'On' )   $validated_fields['booking_range_start_day'][] = $i;             
            unset( $validated_fields[ 'booking_range_start_day' . $i ] );
        }
        $validated_fields['booking_range_start_day'] = implode( ',', $validated_fields['booking_range_start_day'] );
    }
    
    if ( $validated_fields['booking_range_start_day'] == '' )                           // If not selected any weekdays,  then  set as days selection "Any weekdays".
        $validated_fields['booking_range_start_day'] = '-1';
    
    
    // DYNAMIC
    if ( $validated_fields['booking_range_start_day_dynamic'] == '-1' ) {               // Dynamic - Any  week days        
        for ( $i = 0; $i < 7; $i++ ) {
            unset( $validated_fields[ 'booking_range_start_day_dynamic' . $i ] );
        }
        
    } else {                                                                    // Dynamic - Specific Week days
        $validated_fields['booking_range_start_day_dynamic'] = array();
        for ( $i = 0; $i < 7; $i++ ) {
            if ( $validated_fields[ 'booking_range_start_day_dynamic' . $i ] == 'On' )   $validated_fields['booking_range_start_day_dynamic'][] = $i;             
            unset( $validated_fields[ 'booking_range_start_day_dynamic' . $i ] );
        }
        $validated_fields['booking_range_start_day_dynamic'] = implode( ',', $validated_fields['booking_range_start_day_dynamic'] );
    }
    
    if ( $validated_fields['booking_range_start_day_dynamic'] == '' )                   // If not selected any weekdays,  then  set as days selection "Any weekdays".
        $validated_fields['booking_range_start_day_dynamic'] = '-1';
    
    
    unset( $validated_fields[ 'booking_time_format_selection' ] );                      // We do not need to this field,  because saving to DB only: "time_format" field

    
    return $validated_fields;
}
add_filter( 'wpbc_settings_validate_fields_before_saving', 'wpbc_settings_validate_fields_before_saving__bs', 10, 1 );   // Hook for validated fields.


/** JavaScript     at Bottom of Settings page
 * 
 * @param string $page_tag
 */
function wpbc_settings_enqueue_js__bs( $page_tag, $active_page_tab, $active_page_subtab ) {

    // Check if this correct  page /////////////////////////////////////////////
    
    if ( !(
               ( $page_tag == 'wpbc-settings')                                      // Load only at 'wpbc-settings' menu
            && (  ( ! isset( $_GET['tab'] ) ) || ( $_GET['tab'] == 'general' )  )   // At ''general' tab
          )
      ) return;
  
    // JavaScript //////////////////////////////////////////////////////////////
    
    $js_script = '';
    
    ////////////////////////////////////////////////////////////////////////////
    // Initital Hiding some Sections in settings
    ////////////////////////////////////////////////////////////////////////////
    
    $js_script .= " function wpbc_check_showing_range_days_selection_sections() {        
                                                                                                    // Single selected
                        if ( jQuery('#type_of_day_selections_single').is(':checked') ) {
                            jQuery('.wpbc_recurrent_check_in_out_time_slots').addClass('hidden_items');                            // Hide Reccurent, Check in/out Sections
                            
                            jQuery('#set_gen_booking_recurrent_time').prop('checked', false);                                     // Uncheck  Reccurent
                            jQuery('#set_gen_booking_range_selection_time_is_active').prop('checked', false);                     //      and Check In/Out

                            jQuery('.wpbc_range_days_selection').addClass('hidden_items');                                         // Hide Range section
                        }                                                                           // Multiple selected
                        if ( jQuery('#type_of_day_selections_multiple').is(':checked') ) {
                            jQuery('.wpbc_recurrent_check_in_out_time_slots').removeClass('hidden_items');                         // Show Reccurent, Check in/out Sections

                            jQuery('.wpbc_range_days_selection').addClass('hidden_items');                                         // Hide Range section
                        }                                                       
                                                                                                    // Range selected
                        if ( jQuery('#type_of_day_selections_range').is(':checked') ) {
                            
                            jQuery('.wpbc_recurrent_check_in_out_time_slots').removeClass('hidden_items');                         // Show Reccurent, Check in/out Sections
                        
                            jQuery('.wpbc_range_days_selection').removeClass('hidden_items');                                      // Show Range section
                            jQuery('.wpbc_tr_set_gen_booking_range_start_day_week fieldset').removeClass('hidden_items'); 
                            jQuery('.wpbc_tr_set_gen_booking_range_start_day_dynamic_week fieldset').removeClass('hidden_items'); 
                            
                                                                                                    // Fixed selected
                            if ( jQuery('#range_selection_type_fixed').is(':checked') ) {
                                jQuery('.wpbc_range_dynamic_selection').addClass('hidden_items');
                                                                                                    // Any Week Days selected
                                if ( jQuery('#range_fixed_start_day_any_day').is(':checked') ) {   
                                    jQuery('.wpbc_tr_set_gen_booking_range_start_day_week fieldset').addClass('hidden_items'); 
                                }
                            }
                                                                                                    // Dynamic selected
                            if ( jQuery('#range_selection_type_dynamic').is(':checked') ) {
                                jQuery('.wpbc_range_fixed_selection').addClass('hidden_items'); 
                                                                                                    // Any Week Days selected
                                if ( jQuery('#range_dynamic_start_day_any_day').is(':checked') ) {   
                                    jQuery('.wpbc_tr_set_gen_booking_range_start_day_dynamic_week fieldset').addClass('hidden_items'); 
                                }
                            }                            
                        }
                        
                        if ( jQuery('#set_gen_booking_range_selection_time_is_active').is(':checked') ) { // Check In/Out selected
                            jQuery('.wpbc_check_in_out_time_slots').removeClass('hidden_items');                      // Show Check In/Out times                         
                        } else {
                            jQuery('.wpbc_check_in_out_time_slots').addClass('hidden_items');                         // Hide Check In/Out times                         
                        }
                    } 
                    wpbc_check_showing_range_days_selection_sections();         // Run first  time to  init                
                    ";
    
    ////////////////////////////////////////////////////////////////////////////
    // Hiding or showing section based on User Clicks in settings
    ////////////////////////////////////////////////////////////////////////////    
    $list_of_id_to_hook = array( 
                                  '#type_of_day_selections_single'
                                , '#type_of_day_selections_multiple'        
                                , '#type_of_day_selections_range'        
                                , '#range_selection_type_fixed'        
                                , '#range_selection_type_dynamic'
                                , '#range_fixed_start_day_specific_day'
                                , '#range_fixed_start_day_any_day'
                                , '#range_dynamic_start_day_specific_day'
                                , '#range_dynamic_start_day_any_day'
                               );
    $list_of_id_to_hook = implode( ',', $list_of_id_to_hook );
    
                                                                                // Click on "Days Selections", "Type of range", "Start Week days" checkboxes or radioboxes, show/hide sections.
    $js_script .= " jQuery('{$list_of_id_to_hook}').on( 'change', function(){            
                            wpbc_check_showing_range_days_selection_sections();
                        } ); ";        

                                                                                // Click on "Recurrent Time" - then Uncheck "Check In/Out" and hide show sections.
    $js_script .= " jQuery('#set_gen_booking_recurrent_time').on( 'change', function(){    
                            if ( this.checked ) { 
                                jQuery('#set_gen_booking_range_selection_time_is_active').prop('checked', false);
                            }
                            wpbc_check_showing_range_days_selection_sections();
                        } ); ";   
                                                                                // Click on "Check In/Out" - then Uncheck "Recurrent Time" and hide show sections.
    $js_script .= " jQuery('#set_gen_booking_range_selection_time_is_active').on( 'change', function(){    
                            if ( this.checked ) { 
                                jQuery('#set_gen_booking_recurrent_time').prop('checked', false);
                            }
                            wpbc_check_showing_range_days_selection_sections();
                        } ); ";        
    
    
    ////////////////////////////////////////////////////////////////////////
    // Set  correct  value for Time Format,  depend from selection of radio buttons
    $booking_time_format = get_bk_option( 'booking_time_format');       
    // Function  to  load on initial stage of page loading, set correct value of text and select correct radio button.
    $js_script .= " 
                    // Select by  default Custom  value, later  check all other predefined values
                    jQuery( '#time_format_selection_custom' ).prop('checked', true);

                    jQuery('input[name=\"set_gen_booking_time_format_selection\"]').each(function() {
                       var radio_button_value = jQuery( this ).val()
                       var encodedStr = radio_button_value.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
                                                                                    return '&#'+i.charCodeAt(0)+';';
                                                                                });
                       if ( encodedStr == '". $booking_time_format ."' ) {
                            jQuery( this ).prop('checked', true);                     
                       }
                    });

                    jQuery('#set_gen_booking_time_format').val('". $booking_time_format ."');
                    ";
    // On click Radio button "Time Format", - set value in custom Text field
    $js_script .= " jQuery('input[name=\"set_gen_booking_time_format_selection\"]').on( 'change', function(){    
                            if (  ( this.checked ) && ( jQuery(this).val() != 'custom' )  ){ 

                                jQuery('#set_gen_booking_time_format').val( jQuery(this).val().replace(/[\u00A0-\u9999<>\&]/gim, 
                                    function(i) {
                                        return '&#'+i.charCodeAt(0)+';';
                                    }) 
                                );
                            }                            
                        } ); "; 
    // If we edit custom "Date Format" Text  field - select Custom Radio button.                                 
    $js_script .= " jQuery('#set_gen_booking_time_format').on( 'change', function(){                                              
                            jQuery( '#time_format_selection_custom' ).prop('checked', true);
                        } ); ";        
    
    
    // Auto Cancelation section ////////////////////////////////////////////////    
    $js_script .= " if ( ! jQuery('#set_gen_booking_auto_cancel_pending_unpaid_bk_is_active').is(':checked') ) {
                        jQuery('.wpbc_sub_settings_auto_cancelation').addClass('hidden_items');
                    }
                    if ( ! jQuery('#set_gen_booking_auto_cancel_pending_unpaid_bk_is_send_email').is(':checked') ) {
                        jQuery('.wpbc_tr_set_gen_booking_auto_cancel_pending_unpaid_bk_email_reason').addClass('hidden_items');
                    }                    
                  ";                                                                         
                                                                                // Click on "Auto-cancel bookings"
    $js_script .= " jQuery('#set_gen_booking_auto_cancel_pending_unpaid_bk_is_active').on( 'change', function(){    
                            if ( this.checked ) { 
                                jQuery('.wpbc_sub_settings_auto_cancelation').removeClass('hidden_items');
                                if ( ! jQuery('#set_gen_booking_auto_cancel_pending_unpaid_bk_is_send_email').is(':checked') ) {
                                    jQuery('.wpbc_tr_set_gen_booking_auto_cancel_pending_unpaid_bk_email_reason').addClass('hidden_items');
                                }
                            } else {
                                jQuery('.wpbc_sub_settings_auto_cancelation').addClass('hidden_items');
                            }
                        } ); ";   
                                                                                // Click "Cancellation email sent"
    $js_script .= " jQuery('#set_gen_booking_auto_cancel_pending_unpaid_bk_is_send_email').on( 'change', function(){    
                            if ( this.checked ) { 
                                jQuery('.wpbc_tr_set_gen_booking_auto_cancel_pending_unpaid_bk_email_reason').removeClass('hidden_items');
                            } else {
                                jQuery('.wpbc_tr_set_gen_booking_auto_cancel_pending_unpaid_bk_email_reason').addClass('hidden_items');
                            }
                        } ); ";   
    
    
    wpbc_enqueue_js( $js_script );                                              // Eneque JS to  the footer of the page.
}
add_action( 'wpbc_after_settings_content',  'wpbc_settings_enqueue_js__bs', 10, 3 );



////////////////////////////////////////////////////////////////////////////////
// Booking Resources Table
////////////////////////////////////////////////////////////////////////////////

/** Get Price period (per/day or per/hour, per/nights) cost
 * 
 * @return string - link to Booking > Settings > Payment page with  title of price period
 */
function wpbc_get_per_day_night_title() {
    
    $price_period = get_bk_option( 'booking_paypal_price_period' );
    switch ( $price_period ) {
        case 'day': 
                    $price_period = ' / ' . __( 'day', 'booking' );
                    break;
        case 'night': 
                    $price_period = ' / ' . __( 'night', 'booking' );
                    break;
        case 'hour': 
                    $price_period = ' / ' . __( 'hour', 'booking' );
                    break;
        default:                                                                // 'fixed'
                    $price_period = '';
                    break;
    }
    $price_period = '<a style="font-size:1em;padding-bottom: 2px;border-bottom:1px dashed;" href="'. wpbc_get_settings_url(). '&tab=payment#gateways_booking_paypal_price_period' .'">' . $price_period . '</a>';
    
    return $price_period;
}


/** Add Column Header to Resources Table -- Cost Fields
 * 
 * @param array $columns
 * @return array
 */
function wpbc_resources_table_header__cost_title__bs( $columns ) {

    $price_period = wpbc_get_per_day_night_title();
    
    $columns[ 'cost' ] = array(   
                                  'title' => __( 'Cost' ) . $price_period
                                , 'style' => 'width:8em;'
                                // , 'sortable' => true                         // Sortable opearation  on this field is SLOW, because its require converting types from varchar to decimal,  thats why its not activated by  default.
                        );
    return $columns;
}
add_filter( 'wpbc_resources_table_header__cost_title', 'wpbc_resources_table_header__cost_title__bs', 10, 1 );   // Hook for validated fields.


/** Show Column in Resources Table - Edit Cost
 * 
 * @param int $row_num
 * @param array $resource
 */
function wpbc_resources_table_show_col__cost_field__bs( $row_num, $resource ) {
    ?> 
    <td class="field-currency-cost">
        <?php  
            // Currency
            $currency = wpbc_get_currency_symbol_for_user( $resource['id' ] );
        ?>                
        <div class="field-currency"><?php echo $currency; ?></div>        
        <input type="text" 
               value="<?php echo esc_js( $resource['cost'] ); ?>" 
               id="booking_resource_cost_<?php echo $resource['id' ]; ?>" 
               name="booking_resource_cost_<?php echo $resource['id' ]; ?>" 
               class="large-text" 
               style="margin-left: 5%;width: 70%;"
        />                                                
    </td>
    <?php 
}
add_action( 'wpbc_resources_table_show_col__cost_field',  'wpbc_resources_table_show_col__cost_field__bs', 10, 2 );


/** Show Column in Resources Table - Edit Cost
 * 
 * @param int $row_num
 * @param array $resource
 */
function wpbc_resources_table_show_col__cost_text__bs( $row_num, $resource ) {
    ?> 
    <td class="field-currency-cost">
        <?php  
            // Currency
            $currency = wpbc_get_currency_symbol_for_user( $resource['id' ] );
            $cost_text = wpbc_cost_show( $resource['cost'], array(  'currency' => 'CURRENCY_SYMBOL' ) );
            $cost_text = str_replace( 'CURRENCY_SYMBOL', $currency, $cost_text );
        ?>                
        <div class="field-currency"><?php echo $cost_text; ?></div>                
    </td>
    <?php 
}
add_action( 'wpbc_resources_table_show_col__cost_text',  'wpbc_resources_table_show_col__cost_text__bs', 10, 2 );


/** Update SQL during Saving data at Booking > Resources page 
 * 
 * @param array $sql            array(
                                                            'sql' => array(
                                                                                  'start'   => "UPDATE {$wpdb->prefix}bookingtypes SET "
                                                                                , 'params' => array( 'title = %s' )
                                                                                , 'end'    => " WHERE booking_type_id = %d"
                                                                        )
                                                            , 'values' => array(
                                                                                  $validated_value 
                                                                        )
                                                        )
 * @param int $resource_id
 * @param array $resource
 * @return string - updated SQL
 */
function wpbc_resources_table__update_sql_array__bs( $sql, $resource_id, $resource ) {
    
    // Validate Cost
    $validated_cost = WPBC_Settings_API::validate_text_post_static( 'booking_resource_cost_' . $resource_id );    
    $validated_cost = str_replace(',', '.', $validated_cost );                  // In case,  if someone was used , instead of . for decimal
    $validated_cost = floatval( $validated_cost );
    
    
    $sql['sql']['params'][] = 'cost = %s';
    $sql['values'][]        = $validated_cost;
    
    return $sql;
}
add_filter( 'wpbc_resources_table__update_sql_array', 'wpbc_resources_table__update_sql_array__bs', 10, 3 );   // Hook for validated fields.
add_filter( 'wpbc_resources_table__update_sql_cost_array', 'wpbc_resources_table__update_sql_array__bs', 10, 3 );   // Hook for validated fields.

/** Update SQL during Inserting data at Booking > Resources page 
 * 
 * @param array $sql                                array(
                                                            'sql'       => array(
                                                                                  'start'      => "INSERT INTO {$wpdb->prefix}bookingtypes "
                                                                                , 'params'     => array( 'title' )    
                                                                                , 'param_types' => array( '%s' )    
                                                                        )
                                                            , 'values'  => array( $validated_title . $sufix )
                                                    )
 * @param array $params                             array( 'sufix' => $sufix )
 * @return array - updated SQL
 */
function wpbc_resources_table__add_new_sql_array__bs( $sql, $params ) {    
    return $sql;
}
add_filter( 'wpbc_resources_table__add_new_sql_array', 'wpbc_resources_table__add_new_sql_array__bs', 10, 2 );   // Hook for validated fields.