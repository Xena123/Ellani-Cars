<?php
/*
This is COMMERCIAL SCRIPT
We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
*/

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  S u p p o r t    f u n c t i o n s       ///////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        
        function rangeNumListToCommaNumList( $specific_selected_dates ){
            $specific_selected_dates = explode(',',$specific_selected_dates);
            $js_specific_selected_dates = array();
            foreach ($specific_selected_dates as $value) {
               $is_range = strpos($value, '-');
               if ($is_range>0){
                   $value=explode('-',$value);
                   for ($ii = $value[0]; $ii <= $value[1]; $ii++) {
                      $js_specific_selected_dates[] = $ii; 
                   }
               } else $js_specific_selected_dates[] = $value;
            }
            $js_specific_selected_dates = implode(',',$js_specific_selected_dates);
            return $js_specific_selected_dates;
        }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  Filters interface     Controll elements  ///////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // <editor-fold     defaultstate="collapsed"                        desc=" P a y m e n t   s t a t u s   F i l t e r "  >
        function wpbc_filter_payment_status(){

            $params = array(                                                    
                              'id'  => 'wh_pay_status'
                            // , 'id2' => 'wh_booking_date2'
                            , 'default' =>  ( isset( $_REQUEST[ 'wh_pay_status' ] ) ) ? esc_attr( $_REQUEST[ 'wh_pay_status' ] ) : 'all'
                            // , 'default2' => ( isset( $_REQUEST[ 'wh_booking_date2' ] ) ) ? esc_attr( $_REQUEST[ 'wh_booking_date2' ] ) : ''
                            , 'hint' => array( 'title' => __('Payment status' ,'booking') , 'position' => 'top' )
                            , 'label' => ''//__('Booked Dates', 'booking') . ':'
                            , 'title' => __('Payment', 'booking')                                                              
                            , 'options' => array (
                                                    __('Any Status' ,'booking')       =>'all',
                                                    'divider0' => 'divider',
                                                    __('Paid OK' ,'booking') =>'group_ok',
                                                    __('Unknown Status' ,'booking')    =>'group_unknown',
                                                    __('Not Completed' ,'booking')     =>'group_pending',
                                                    __('Failed' ,'booking')            =>'group_failed'
                                                    , 'divider2' => 'divider'                                
                                                    , 'custom' => array( array(  'type' => 'group', 'class' => 'input-group text-group') 
                                                                        , array( 
                                                                                'type' => 'radio'
                                                                              , 'label' => __('Custom' ,'booking') 
                                                                              , 'id' => 'wh_pay_statuscustom_radios1' 
                                                                              , 'name' => 'wh_pay_statuscustom_Radios'                                                                                            
                                                                              , 'style' => ''                     // CSS of select element
                                                                              , 'class' => ''                     // CSS Class of select element                                                                                
                                                                              , 'disabled' => false
                                                                              , 'attr' => array()                 // Any  additional attributes, if this radio | checkbox element 
                                                                              , 'legend' => ''                    // aria-label parameter 
                                                                              , 'value' => '1'                     // Some Value from optins array that selected by default                                      
                                                                              , 'selected' => ( isset($_REQUEST[ 'wh_pay_statuscustom_Radios'] ) 
                                                                                                && ( $_REQUEST[ 'wh_pay_statuscustom_Radios'] == '1' ) ) ? true : false
                                                                              )
                                                        
                                                                        , array(                                                                                 
                                                                                'type'          => 'text' 
                                                                                , 'id'          => 'wh_pay_statuscustom'  
                                                                                , 'name'        => 'wh_pay_statuscustom'  
                                                                                , 'label'       => __('Payment status' ,'booking') . ':'
                                                                                , 'disabled'    => false
                                                                                , 'class'       => ''
                                                                                , 'style'       => ''
                                                                                , 'placeholder' => ''
                                                                                , 'attr'        => array()    
                                                                                , 'value' => isset( $_REQUEST[ 'wh_pay_statuscustom'] ) ? esc_attr( $_REQUEST[ 'wh_pay_statuscustom'] ) : ''
                                                                              )
                                                                        )
                                                    , 'divider4' => 'divider'  
                                                    , 'buttons' => array( array(  'type' => 'group', 'class' => 'btn-group' ), 
                                                                        array( 
                                                                                  'type' => 'button' 
                                                                                , 'title' => __('Apply' ,'booking')                     // Title of the button
                                                                                , 'hint' => ''                      // , 'hint' => array( 'title' => __('Select status' ,'booking') , 'position' => 'bottom' )
                                                                                , 'link' => 'javascript:void(0)'    // Direct link or skip  it
                                                                                , 'action' => "wpbc_show_selected_in_dropdown__radio_select_option("
                                                                                                                                                 . "  'wh_pay_status'"
                                                                                                                                                 . ", ''"
                                                                                                                                                 . ", 'wh_pay_statuscustom_Radios' "
                                                                                                                                                 . ");"
                                                                                                                    // Some JavaScript to execure, for example run  the function
                                                                                , 'class' => 'button-primary'       // button-secondary  | button-primary
                                                                                , 'icon' => ''
                                                                                , 'font_icon' => ''
                                                                                , 'icon_position' => 'left'         // Position  of icon relative to Text: left | right
                                                                                , 'style' => ''                     // Any CSS class here
                                                                                , 'mobile_show_text' => false       // Show  or hide text,  when viewing on Mobile devices (small window size).
                                                                                , 'attr' => array()
                                                                            
                                                                              )
                                                                        , array( 
                                                                                  'type' => 'button' 
                                                                                , 'title' => __('Close' ,'booking')                     // Title of the button
                                                                                , 'hint' => ''                      // , 'hint' => array( 'title' => __('Select status' ,'booking') , 'position' => 'bottom' )
                                                                                , 'link' => 'javascript:void(0)'    // Direct link or skip  it
                                                                                //, 'action' => ''                    // Some JavaScript to execure, for example run  the function
                                                                                , 'class' => 'button-secondary'     // button-secondary  | button-primary
                                                                                , 'icon' => ''
                                                                                , 'font_icon' => ''
                                                                                , 'icon_position' => 'left'         // Position  of icon relative to Text: left | right
                                                                                , 'style' => ''                     // Any CSS class here
                                                                                , 'mobile_show_text' => false       // Show  or hide text,  when viewing on Mobile devices (small window size).
                                                                                , 'attr' => array()                                                                            
                                                                              )
                                                                        )
                                                )
                        );  
            
            
            wpbc_bs_dropdown_list( $params );                 
            
        }        
        // </editor-fold>
        
        

        // <editor-fold     defaultstate="collapsed"                        desc=" M i n   /   M a x     C o s t     F i l t e r "  >   
        function wpbc_filter_min_max_cost() {
            
            $params = array(  
                              'label_for' => 'wh_cost'                       // "For" parameter  of label element
                            , 'label' => ''                                     // Label above the input group
                            , 'style' => ''                                     // CSS Style of entire div element
                            , 'items' => array(
                                                array(      
                                                    'type' => 'addon' 
                                                    , 'element' => 'text'       // text | radio | checkbox
                                                    , 'text' => __('Cost', 'booking') . ': <em style="color:#888;">(' .__('min' ,'booking') . '-' . __('max' ,'booking') . ')</em>'
                                                    , 'class' => ''                 // Any CSS class here
                                                    , 'style' => 'font-weight:600;'                 // CSS Style of entire div element
                                                )  
                                                , array(    
                                                    'type' => 'text'
                                                    , 'id' => 'wh_cost'            // HTML ID  of element                                                          
                                                    , 'value' => ( isset( $_REQUEST[ 'wh_cost' ] ) ) ? esc_attr( $_REQUEST[ 'wh_cost' ] ) : ''    // Value of Text field
                                                    , 'placeholder' => '0'
                                                    , 'style' => 'width:5em;'                 // CSS of select element
                                                    , 'class' => ''                 // CSS Class of select element
                                                    , 'attr' => array()             // Any  additional attributes, if this radio | checkbox element 
                                                ) 
                                                , array(      
                                                    'type' => 'addon' 
                                                    , 'element' => 'text'       // text | radio | checkbox
                                                    , 'text' => '-'
                                                    , 'class' => ''                 // Any CSS class here
                                                    , 'style' => 'font-weight:600;'                 // CSS Style of entire div element
                                                )  
                                                , array(    
                                                    'type' => 'text'
                                                    , 'id' => 'wh_cost2'            // HTML ID  of element                                                          
                                                    , 'value' => ( isset( $_REQUEST[ 'wh_cost2' ] ) ) ? esc_attr( $_REQUEST[ 'wh_cost2' ] ) : ''    // Value of Text field
                                                    , 'placeholder' => '100000'
                                                    , 'style' => 'width:6em;'                 // CSS of select element
                                                    , 'class' => ''                 // CSS Class of select element
                                                    , 'attr' => array()             // Any  additional attributes, if this radio | checkbox element 
                                                ) 
                            )
                      );     
            ?><div class="control-group wpbc-no-padding"><?php 
                    wpbc_bs_input_group( $params );                   
            ?></div><?php    
        }
        // </editor-fold>
        
        
        // Get the sort options for the filter at the booking listing page
        function get_s_bk_filter_sort_options($wpdevbk_selectors_def){
              $wpdevbk_selectors = array(__('ID' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-up "></i>' =>'',
                               __('Dates' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-up "></i>' =>'sort_date',
                               __('Resource' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-up "></i>' =>'booking_type',
                               __('Cost' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-up "></i>' =>'cost',
                               'divider0'=>'divider',
                               __('ID' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-down "></i>' =>'booking_id_asc',
                               __('Dates' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-down "></i>' =>'sort_date_asc',
                               __('Resource' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-down "></i>' =>'booking_type_asc',
                               __('Cost' ,'booking').'&nbsp;<i class="glyphicon glyphicon-arrow-down "></i>' =>'cost_asc'
                              );
              return $wpdevbk_selectors;
        }
        add_bk_filter('bk_filter_sort_options', 'get_s_bk_filter_sort_options');


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //  S Q L   Modifications  for  Booking Listing  ///////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Pay status
        function get_s_bklist_sql_paystatus($blank, $wh_pay_status ){
            $sql_where = '';

            if ( (isset($_REQUEST['wh_pay_status']) ) && ( $_REQUEST['wh_pay_status'] != 'all') ) {

                $sql_where .= " AND ( ";

                // Check  firstly if we are selected some goup of payment status
                if ($_REQUEST['wh_pay_status'] == 'group_ok' ) {                // SUCCESS

                   $payment_status = wpbc_get_payment_status_ok();

                   foreach ($payment_status as $label) {
                       $sql_where .= " ( bk.pay_status = '". $label ."' ) OR";
                   }
                   $sql_where = substr($sql_where, 0, -2);

                } else if ( ($_REQUEST['wh_pay_status'] == 'group_unknown' ) || (is_numeric($wh_pay_status)) || ($wh_pay_status == '') ) {     // UNKNOWN

                   $payment_status = wpbc_get_payment_status_unknown();
                   foreach ($payment_status as $label) {
                       $sql_where .= " ( bk.pay_status = '". $label ."' ) OR";
                   }
                   //$sql_where = substr($sql_where, 0, -2);
                   $sql_where .= " ( bk.pay_status = '' ) OR ( bk.pay_status regexp '^[0-9]') ";

                } else if ($_REQUEST['wh_pay_status'] == 'group_pending' ){     // Pending

                   $payment_status = wpbc_get_payment_status_pending();
                   foreach ($payment_status as $label) {
                       $sql_where .= " ( bk.pay_status = '". $label ."' ) OR";
                   }
                   $sql_where = substr($sql_where, 0, -2);

                } else if ($_REQUEST['wh_pay_status'] == 'group_failed' ) {     // Failed

                   $payment_status   = wpbc_get_payment_status_error();
                   foreach ($payment_status as $label) {
                       $sql_where .= " ( bk.pay_status = '". $label ."' ) OR";
                   }
                   $sql_where = substr($sql_where, 0, -2);

                } else {                                                        // CUSTOM Payment Status
                    $sql_where .= " bk.pay_status = '" . $wh_pay_status . "' ";
                }

                $sql_where .= " ) ";
            }

            return $sql_where;
        }
        add_bk_filter('get_bklist_sql_paystatus', 'get_s_bklist_sql_paystatus');

        // Cost
        function get_s_bklist_sql_cost($blank, $wh_cost, $wh_cost2  ){
            $sql_where = '';

            if ( $wh_cost   !== '' )    $sql_where.=   " AND (  bk.cost >= " . $wh_cost . " ) ";
            if ( $wh_cost2  !== '' )    $sql_where.=   " AND (  bk.cost <= " . $wh_cost2 . " ) ";

            return $sql_where;
        }
        add_bk_filter('get_bklist_sql_cost', 'get_s_bklist_sql_cost');


        function wpdev_bk_listing_show_payment_label(  $is_paid, $pay_print_status , $real_payment_status_label){

            $css_payment_label = 'payment-label-' . wpbc_check_payment_status($real_payment_status_label);
            if ($is_paid) { ?><span class="label label-default label-payment-status label-success <?php echo $css_payment_label; ?> "><?php echo '<span style="font-size:07px;">'.__('Payment' ,'booking') .'</span> '.$pay_print_status ; ?></span><?php     }
            else          {               
                ?><span class="label label-default label-payment-status <?php echo $css_payment_label; ?> "><?php  echo '<span style="font-size:07px;">'.__('Payment' ,'booking') .'</span> '. $pay_print_status; ; ?></span><?php
           }
        }
        add_bk_action( 'wpdev_bk_listing_show_payment_label', 'wpdev_bk_listing_show_payment_label');


        function wpdev_bk_get_payment_status_simple($bk_pay_status) {

            if ( wpbc_is_payment_status_ok( trim($bk_pay_status) ) ) $is_paid = 1 ;
            else $is_paid = 0 ;

            $payment_status_titles = get_payment_status_titles();
            $payment_status_titles_current = array_search($bk_pay_status, $payment_status_titles);
            if ($payment_status_titles_current === FALSE ) $payment_status_titles_current = $bk_pay_status ;

            $pay_print_status = '';

            if ($is_paid) {
                $pay_print_status = __('Paid OK' ,'booking');
                if ($payment_status_titles_current == 'Completed') $pay_print_status = $payment_status_titles_current;
            } else if ( (is_numeric($bk_pay_status)) || ($bk_pay_status == '') )        {
                $pay_print_status = __('Unknown' ,'booking');
            } else  {
                $pay_print_status = $payment_status_titles_current;
            }

            return $pay_print_status;

        }
        

    function get_payment_status_titles() {

        $payment_status_titles = array(
            __( 'Completed', 'booking' ) => 'Completed',
            __( 'In-Progress', 'booking' ) => 'In-Progress',
            __( 'Unknown', 'booking' ) => '1',
            __( 'Partially paid', 'booking' ) => 'partially',
            __( 'Cancelled', 'booking' ) => 'canceled',
            __( 'Failed', 'booking' ) => 'Failed',
            __( 'Refunded', 'booking' ) => 'Refunded',
            __( 'Fraud', 'booking' ) => 'fraud'
        );

        return $payment_status_titles;


        $payment_status_titles = array(
            __( '!Paid OK', 'booking' ) => 'OK',
            __( 'Unknown status', 'booking' ) => '1',
            __( 'Not Completed', 'booking' ) => 'Not_Completed',
            // PayPal statuses
            __( 'Completed', 'booking' ) => 'Completed',
            __( 'Pending', 'booking' ) => 'Pending',
            __( 'Processed', 'booking' ) => 'Processed',
            __( 'In-Progress', 'booking' ) => 'In-Progress',
            __( 'Canceled_Reversal', 'booking' ) => 'Canceled_Reversal',
            __( 'Denied', 'booking' ) => 'Denied',
            __( 'Expired', 'booking' ) => 'Expired',
            __( 'Failed', 'booking' ) => 'Failed',
            __( 'Partially_Refunded', 'booking' ) => 'Partially_Refunded',
            __( 'Refunded', 'booking' ) => 'Refunded',
            __( 'Reversed', 'booking' ) => 'Reversed',
            __( 'Voided', 'booking' ) => 'Voided',
            __( 'Created', 'booking' ) => 'Created',
            // Sage Statuses
            __( 'Not authed', 'booking' ) => 'not-authed',
            __( 'Malformed', 'booking' ) => 'malformed',
            __( 'Invalid', 'booking' ) => 'invalid',
            __( 'Abort', 'booking' ) => 'abort',
            __( 'Rejected', 'booking' ) => 'rejected',
            __( 'Error', 'booking' ) => 'error',
            __( 'Partially paid', 'booking' ) => 'partially',
            __( 'Cancelled', 'booking' ) => 'canceled',
            __( 'Fraud', 'booking' ) => 'fraud',
            __( 'Suspended', 'booking' ) => 'suspended'
        );
        return $payment_status_titles;
    }

