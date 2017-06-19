<?php
/*
This is COMMERCIAL SCRIPT
We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
*/
if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

require_once(WPBC_PLUGIN_DIR. '/inc/_ps/class/wpbc-settings-table.php' );       // Abstarct Settings Table Class

require_once(WPBC_PLUGIN_DIR. '/inc/_ps/admin/wpbc-resources-cache.php' );            // Caching booking resources.
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/admin/wpbc-resources-table.php' );            // Class for showing Table of booking resources in Setting pages

require_once(WPBC_PLUGIN_DIR. '/inc/_ps/lib_p.php' );
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/p-toolbar.php' );
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/wpbc-print.php' );
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/wpbc-booking-select-widget.php' );

require_once( WPBC_PLUGIN_DIR . '/inc/_ps/admin/page-resources.php' );          //TODO: Finish this !   

require_once(WPBC_PLUGIN_DIR. '/inc/_ps/form/class-wpbc-form-help.php' ); 
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/wpbc-form-templates.php' ); 
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/admin/page-settings-form.php' );        // Form

require_once( WPBC_PLUGIN_DIR . '/core/admin/page-email-new-admin.php' );       // Email - New Admin
require_once( WPBC_PLUGIN_DIR . '/core/admin/page-email-new-visitor.php' );     // Email - New Visitor
require_once( WPBC_PLUGIN_DIR . '/core/admin/page-email-approved.php' );        // Email - Approved
require_once( WPBC_PLUGIN_DIR . '/core/admin/page-email-deny.php' );            // Email - Deny
require_once( WPBC_PLUGIN_DIR . '/core/admin/page-email-trash.php' );           // Email - Trash
require_once( WPBC_PLUGIN_DIR . '/core/admin/page-email-deleted.php' );           // Email - Trash

require_once( WPBC_PLUGIN_DIR . '/inc/_ps/admin/page-email-edit.php' );         // Email - Edit

require_once( WPBC_PLUGIN_DIR . '/core/admin/page-import-gcal.php' );           // Import from  Google Calendar Settings page 
require_once( WPBC_PLUGIN_DIR . '/inc/_ps/admin/br-table-import-gcal-p.php' );  // Import gCal functions for settings page - resources table

    
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/admin/api-settings-p.php' );            // Settings page    
require_once(WPBC_PLUGIN_DIR. '/inc/_ps/admin/activation-p.php' );              // Activate / Deactivate

if ( file_exists(WPBC_PLUGIN_DIR. '/inc/_bs/biz_s.php') ) { 
    require_once(WPBC_PLUGIN_DIR. '/inc/_bs/biz_s.php' ); }

require_once( WPBC_PLUGIN_DIR . '/inc/_ps/admin/page-settings-up.php' );           //TODO: Finish this !        
    
if( is_admin() ) {     
        
    if ( file_exists(WPBC_PLUGIN_DIR. '/inc/_ps/wpbc-check-updates.php') ) {            // Checking updates
        require_once(WPBC_PLUGIN_DIR. '/inc/_ps/wpbc-check-updates.php' ); 
        $wpbc_plugin_updater = new WPBC_Plugin_Updater(  WPBC_FILE, 'http://wpbookingcalendar.com/check-update/booking.json', array( 'version' => WP_BK_VERSION_NUM , 'plugin_html_id' => 'booking-calendar' ) );        
    }     
}


class wpdev_bk_personal   {

    var $current_booking_type;
    var $wpdev_bk_biz_s;
    var $current_edit_booking;
    var $countries_list;

    function __construct() {
        $this->current_booking_type = 1;
        $this->current_edit_booking = false;

        add_bk_filter('wpbc_get_booking_data', array(&$this, 'get_booking_data'));  //FixIn: 5.4.5.11  
        add_bk_filter('get_bk_dates_sql', array(&$this, 'get_bk_dates_4_edit'));  // At hotel edition already edit it

        add_bk_action('show_remark_editing_field', array(&$this, 'show_remark_editing_field'));     // Show fields for editing
        add_bk_action('wpdev_updating_remark', array(&$this, 'wpdev_updating_remark'));             // Ajax POST request for updating remark
        add_bk_action('wpdev_make_update_of_remark', array(&$this, 'wpdev_make_update_of_remark')); // Ajax POST request for updating remark

        add_bk_action('wpdev_updating_bk_resource_of_booking', array(&$this, 'wpdev_updating_bk_resource_of_booking')); // Ajax POST request for updating remark
        add_bk_action('wpbc_duplicate_booking_to_other_resource', array(&$this, 'wpbc_duplicate_booking_to_other_resource')); // Ajax POST request for duplication  of Booking Calendar //FixIn: 5.4.5.1

        
        
        add_bk_action('wpdev_delete_booking_by_visitor', array(&$this, 'delete_booking_by_visitor'));   // Ajax POST request for updating remark
        

        

        

        
        add_bk_action('booking_aproved', array(&$this, 'booking_aproved_afteraction'));

        add_action('wpbc_define_js_vars',   array(&$this, 'wpbc_define_js_vars') );
        add_action('wpbc_enqueue_js_files', array(&$this, 'wpbc_enqueue_js_files') );
        add_action('wpbc_enqueue_css_files',array(&$this, 'wpbc_enqueue_css_files') );
        
        

        add_bk_action('show_all_bookings_at_one_page', array(&$this, 'show_all_bookings_at_one_page'));


        
        

        

        if ( class_exists('wpdev_bk_biz_s')) {
                $this->wpdev_bk_biz_s = new wpdev_bk_biz_s();
        } else { $this->wpdev_bk_biz_s = false; }

        global $wpdev_booking_country_list;
        $this->countries_list = $wpdev_booking_country_list;

        add_bk_filter( 'wpdev_booking_get_hash_to_id', array(&$this, 'get_hash_to_id'));  //HASH_EDIT
        add_bk_filter( 'wpdev_booking_get_hash_using_booking_id', array(&$this, 'get_id_using_hash'));  //HASH_EDIT

        add_bk_filter( 'wpdev_booking_set_booking_edit_link_at_email', array(&$this, 'set_booking_edit_link_at_email'));
        
        add_bk_action( 'wpbc_update_booking_hash', array(&$this, 'wpbc_update_booking_hash'));     // HASH Update
        
        add_bk_filter( 'wpdev_is_booking_resource_exist', array(&$this, 'wpdev_is_booking_resource_exist'));    // Check if this booking resource exist or not exist anymore

        add_bk_filter( 'get_sql_for_checking_new_bookings', array(&$this, 'get_sql_for_checking_new_bookings'));

        


        add_bk_action('wpdev_ajax_export_bookings_to_csv', array($this, 'wpdev_ajax_export_bookings_to_csv'));
        add_bk_action('wpdev_ajax_save_bk_listing_filter', array($this, 'wpdev_ajax_save_bk_listing_filter'));
        add_bk_action('wpdev_ajax_delete_bk_listing_filter', array($this, 'wpdev_ajax_delete_bk_listing_filter'));

        add_bk_filter('recheck_version', array($this, 'recheck_version'));           // check Admin pages, if some user can be there.

        // Select booking resource
        add_bk_filter('wpdev_get_booking_select_form', array(&$this, 'wpdev_get_booking_select_form'));
        
        // Show booking resource Title or Cost
        add_bk_filter('wpbc_booking_resource_info', array(&$this, 'wpbc_booking_resource_info'));
    }




// S U P P O R T       F u n c t i o n s    //////////////////////////////////////////////////////////////////////////////////////////////////


    // Save the filter configuration for the booking listing in Ajax request
    function wpdev_ajax_save_bk_listing_filter(){ //get_user_option( 'booking_listing_filter_' . 'default' ) ;

        // Save filter of the booking listings
        update_user_option($_POST['user_id'], 'booking_listing_filter_' . $_POST['filter_name'] ,$_POST['filter_value']);

        ?>  <script type="text/javascript">            
                var my_message = '<?php echo html_entity_decode( esc_js( __('Saved' ,'booking') ),ENT_QUOTES) ; ?>';
                wpbc_admin_show_message( my_message, 'success', 1000 );            
            </script> <?php
        die();
    }

    // Delete the filter configuration for the booking listing in Ajax request
    function wpdev_ajax_delete_bk_listing_filter(){ //get_user_option( 'booking_listing_filter_' . 'default' ) ;

        // Delete Saved filter of the booking listings
        delete_user_option($_POST['user_id'], 'booking_listing_filter_' . $_POST['filter_name'] );

        
        
        ?>  <script type="text/javascript">
                var my_message = '<?php echo html_entity_decode( esc_js( __('Deleted' ,'booking') ),ENT_QUOTES) ; ?>';
                wpbc_admin_show_message( my_message, 'warning', 1000 );            
            </script> <?php
        die();
    }

    function get_sql_for_checking_new_bookings($sql_req){
        global $wpdb;
        
        $trash_bookings = ' AND bk.trash != 1 ';                                //FixIn: 6.1.1.10  - check also  below usage of {$trash_bookings}
        
        $sql_req = "SELECT bk.booking_id FROM {$wpdb->prefix}booking as bk
                    INNER JOIN {$wpdb->prefix}bookingtypes as bt
                    ON  bk.booking_type = bt.booking_type_id WHERE bk.is_new = 1 {$trash_bookings}";
        return $sql_req;
    }



    //   M o d i f y   --   S Q L
    function get_bk_dates_4_edit($mysql, $bk_type, $approved) {

//TODO: Edited after hotel version corrections            if ( class_exists('wpdev_bk_biz_l') ) { return; } // Already exist at that class

        global $wpdb;
        if (isset($_GET['booking_hash'])) {
            $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $_GET['booking_hash'] );
            if ($my_booking_id_type !== false) {
                $my_booking_id = $my_booking_id_type[0];
                //$bk_type        = $my_booking_id_type[1];
            } else $my_booking_id = '-1';
            $skip_bookings = ' AND bk.booking_id <>' .$my_booking_id . ' ';
        } else { $skip_bookings = ''; }

        $trash_bookings = ' AND bk.trash != 1 ';                                //FixIn: 6.1.1.10  - check also  below usage of {$trash_bookings}
        
        if ($approved == 'all')
              $sql_req =   "SELECT DISTINCT dt.booking_date

                 FROM {$wpdb->prefix}bookingdates as dt

                 INNER JOIN {$wpdb->prefix}booking as bk

                 ON    bk.booking_id = dt.booking_id

                 WHERE  dt.booking_date >= CURDATE() {$trash_bookings} AND bk.booking_type  IN ($bk_type) ".$skip_bookings."

                 ORDER BY dt.booking_date";

        else
             $sql_req = "SELECT DISTINCT dt.booking_date

                 FROM {$wpdb->prefix}bookingdates as dt

                 INNER JOIN {$wpdb->prefix}booking as bk

                 ON    bk.booking_id = dt.booking_id

                 WHERE  dt.approved = $approved AND dt.booking_date >= CURDATE() {$trash_bookings} AND bk.booking_type IN ($bk_type) ".$skip_bookings."

                 ORDER BY dt.booking_date" ;
//debuge($sql_req);
        return $sql_req;
    }

    // Check if this booking resource exist or not exist anymore
    function wpdev_is_booking_resource_exist($blank, $bk_type_id, $is_echo) {
        global $wpdb;
        $wp_q = $wpdb->prepare( "SELECT booking_type_id as id FROM {$wpdb->prefix}bookingtypes WHERE booking_type_id = %d ",  $bk_type_id );
        $res = $wpdb->get_results( $wp_q );
        if (  count($res) == 0 ) {
            if ($is_echo) {
                ?> <script type="text/javascript">
                    if (document.getElementById('booking_form_div<?php echo $bk_type_id; ?>') !== null)
                        document.getElementById('booking_form_div<?php echo $bk_type_id; ?>').innerHTML = '<?php echo __('This booking resources does not exist' ,'booking'); ?>';
                </script> <?php
            }
            return false;
        } else {
            return true;
        }

    }





//  E x p o r t to CSV  ///////////////////////////////////////////////////////////////////////

    function wpdev_ajax_export_bookings_to_csv(){


        wpbc_show_ajax_message(  __('Processing','booking') . '...' , 3000 );
        $all_booking_types = wpdebk_get_keyed_all_bk_resources(array());

        $params = str_replace('\"', '"', $_POST['csv_data']) ;
        $export_type = str_replace('\"', '"', $_POST['export_type']) ;
        $args = unserialize($params);
        if ($export_type == 'all') {
            $args['page_num']         = 1;                                      // Start export from the first page
            $args['page_items_count'] = 100000;                                 // Expot ALL bookings - Maximum: 1 000 000
        }

        $selected_id = str_replace('\"', '"', $_POST['selected_id']) ;
        if ($selected_id != '' ) {
            $selected_id = explode('|',$selected_id);
        } else 
            $selected_id = array();
        
        $bk_listing = wpbc_get_bookings_objects( $args );                       // Get Bookings structure
        $bookings           = $bk_listing[ 'bookings' ];
        $booking_types      = $bk_listing[ 'resources' ];
        $bookings_count     = $bk_listing[ 'bookings_count' ];
        $page_num           = $bk_listing[ 'page_num' ];
        $page_items_count   = $bk_listing[ 'count_per_page' ];

        $export_collumn_titles = array();

        wpbc_show_ajax_message(  __('Generating columns','booking') . '...' , 3000 );

        foreach ($bookings as $key=>$value) {
            //unset($bookings[$key]->dates);
            //unset($bookings[$key]->dates_short);
            //unset($bookings[$key]->dates_short_id);
            //unset($bookings[$key]->form_show);
            
            // Set  here booking resoutrces for the dates of reservation, which in different sub resources
            for ($ibt = 0; $ibt < count($bookings[$key]->dates_short_id); $ibt++) {
                if (! empty($bookings[$key]->dates_short_id[$ibt]) ) {
                    $bookings[$key]->dates_short[$ibt] .= ' (' . $all_booking_types[ $bookings[$key]->dates_short_id[$ibt] ]->title . ') ';
                }
            }

            $bookings[$key]->dates_show = implode(' ',$bookings[$key]->dates_short);

            $fields = $bookings[$key]->form_data['_all_'];
            if ( class_exists('wpdev_bk_multiuser') )  {                        //FixIn: 6.0.1.10
                // Get  the owner of this booking resource                                    
                $user_bk_id = apply_bk_filter('get_user_of_this_bk_resource', false, $bookings[$key]->booking_type );
                $user_data = get_userdata( $user_bk_id );
                if (  ( ! isset($fields['user' .  $bookings[$key]->booking_type ] ) ) && ( isset($user_data->data) ) && ( isset($user_data->data->display_name) )  )
                    $fields['user' .  $bookings[$key]->booking_type ] = $user_data->data->display_name;
                if ( ( isset($user_data->data) ) && ( isset($user_data->data->display_name) )  )
                    $bookings[$key]->form_data['_all_']['user' .  $bookings[$key]->booking_type ] = $user_data->data->display_name;
            }
            
//debuge($bookings[$key]->booking_type, $fields);
            foreach ($fields as $field_key=>$field_value) {

                $field_key = str_replace('[', '', $field_key);
                $field_key = str_replace(']', '', $field_key);
                if ( substr($field_key,-1* (strlen($bookings[$key]->booking_type) )) == $bookings[$key]->booking_type ) {
                    $field_key = substr($field_key,0,-1* (strlen($bookings[$key]->booking_type) ));
                }
                if (! in_array($field_key, $export_collumn_titles))
                    $export_collumn_titles[] = $field_key;
            }
        }

        wpbc_show_ajax_message(  __('Exporting booking data','booking') . '...' , 3000 );
        $export_bookings = array();
        foreach ($bookings as $key=>$value) {
            
            if ( ! empty($selected_id ) ) {     // We was selected some bookings, so we need to export only these selected bookings.                                
                if (  in_array( $value->booking_id, $selected_id ) === false )
                        continue;
            }
            
            $export_bk_row = array();
            $export_bk_row['dates']=$value->dates_show ;
            $export_bk_row['id']=$value->booking_id ;
            $export_bk_row['modification_date']=$value->modification_date ;
            $export_bk_row['booking_type']= $all_booking_types[$value->booking_type]->title;
            $export_bk_row['remark']=$value->remark ;
            $export_bk_row['cost']=$value->cost ;
            $export_bk_row['pay_status']=$value->pay_status ;

            $is_approved = 0;   if (count($value->dates) > 0 )     $is_approved = $value->dates[0]->approved ;
            if ($is_approved) $bk_print_status =  __('Approved' ,'booking');
            else              $bk_print_status =  __('Pending' ,'booking');
            $export_bk_row['status']= $bk_print_status;

            foreach ($export_collumn_titles as $field_key=>$field_value) {
                if (isset($value->form_data['_all_'][ $field_value . $value->booking_type ]))
                    $export_bk_row[$field_value] = $value->form_data['_all_'][ $field_value . $value->booking_type ] ;
                else
                    $export_bk_row[$field_value] = '';
            }

            $export_bookings[]=$export_bk_row;
        }

        // Write this collumns to the begining
        array_unshift($export_collumn_titles,'id','booking_type','status','dates','modification_date','cost','pay_status');
        $export_collumn_titles[]='remark';

//debuge( $export_collumn_titles, $export_bookings);

       wpbc_show_ajax_message(  __('Generating content of file' ,'booking') , 3000 );

       $message = wp_upload_dir();
       if ( ! empty ($message['error']) ) {
           wpbc_show_ajax_message( $message['error'] , 3000 );
           die;
       }
       $bk_baseurl = $message['baseurl'];
       $bk_upload_dir = $message['basedir'];
     
       $line__separator = get_bk_option( 'booking_csv_export_separator' );
       if ( empty( $line__separator ) ) 
           $line__separator  = ';';
       
       $csv_file_content = '';
       $write_line = '';

        // Write Titles
       foreach ($export_collumn_titles as $line) { $write_line .= "\"".$line."\"". $line__separator; }
       $write_line=substr_replace($write_line,"",-1);    // replace last charcater "," in EOL
       $write_line.= "\r\n";
       $csv_file_content .= $write_line;

       // Write Values
       foreach ($export_bookings as $line) {
           $write_line = '';

           foreach ($export_collumn_titles as $key) {    // Because titles have all keys, we loop keys from titles and then get and write values
               $line[$key] = html_entity_decode( $line[$key], ENT_QUOTES, 'UTF-8' ); 
               if (isset( $line[$key] )) $write_line .= "\"".$line[$key]."\"". $line__separator;
               else                      $write_line .= "\"". "\"". $line__separator;

           }

           $write_line=substr_replace($write_line,"",-1);    // replace last charcater "," in EOL
           $write_line.= "\r\n";
           $csv_file_content .= $write_line;

       }

//debuge($csv_file_content);

       wpbc_show_ajax_message(  __('Saving to file','booking') . '...' , 3000 );

       $dir      = $bk_upload_dir; 
       $filename = 'bookings_export.csv';
       $fp =    fopen(  $dir . '/' .  $filename , 'w' );                        // Write File
       fwrite($fp, trim($csv_file_content) );
       fclose($fp);

       make_bk_action( 'wpbc_write_content_for_modal_export_csv', $filename, $bk_upload_dir);
       
       wpbc_show_ajax_message(  __('Done','booking') , 1000 );
    }

// S H O R T C O D E    Select Booking form using the select box

    // Shortcode to  show cost  or Title of booking resource
    function wpbc_booking_resource_info( $return_data_info, $attr ) {
                
        if ( isset( $attr['type'] ) ) 
            $my_boook_type = $attr['type'];                    
        else 
            $my_boook_type = 1;
                
        if ( isset( $attr['show'] ) )  
            $show_info = $attr['show'];                    
        else
            $show_info = 'title';
              
        
        $booking_resource_attr = get_booking_resource_attr( $my_boook_type );
        
        if ( ! empty($booking_resource_attr) ) {
            
            switch ( $show_info ) {
                case 'title':
                    if ( isset( $booking_resource_attr->title ) ) {
                        $bk_res_title = apply_bk_filter('wpdev_check_for_active_language', $booking_resource_attr->title );
                        return $bk_res_title;
                    }
                    break;
                    
                case 'cost':
                    if (  ( class_exists('wpdev_bk_biz_s') ) && ( isset ($booking_resource_attr->cost ) )  ) {
                        
                        $booking_cost = wpbc_get_cost_with_currency_for_user( $booking_resource_attr->cost, $my_boook_type );
                        
                        return $booking_cost;
                    }
                    break;
                    
                case 'capacity':
                    if (  ( class_exists('wpdev_bk_biz_l') )  ) {  
                        
                        if ( isset( $attr['date'] ) ) {                         // FixIn: 6.2.3.5.1 - Ability to  use shortcode like: [bookingresource type=1 show='capacity' date='2016-09-13']                         
                            //$availability = apply_bk_filter('wpbc_get_availability_for_date', $my_boook_type, $attr['date'] );
                            $temp_date = explode('-',$attr['date']);
                            $mydate = array();
                            $mydate['year'] = intval( $temp_date[0] );
                            $mydate['month'] = intval( $temp_date[1] );
                            $mydate['day'] = intval( $temp_date[2] );
                            
                            $availability = apply_filters('wpdev_booking_show_availability_at_calendar', '', $my_boook_type);
                            $search_start = "availability_per_day[" . $my_boook_type . "]['".$mydate['month']."-".$mydate['day']."-". $mydate['year'] ."'] = ";
                           
                            $search_start = strpos( $availability, $search_start ) + strlen( $search_start );
                           
                            $search_end = strpos( $availability, ';',  $search_start) ;
                           
                            $seacrh_value = trim(  substr( $availability, $search_start, ($search_end - $search_start ) )  );
                            $seacrh_value = trim( $seacrh_value, "'"  );
                            return  $seacrh_value;
                        }
                        
                        $number_of_child_resources = apply_bk_filter('wpbc_get_number_of_child_resources', $my_boook_type );        
                        return  $number_of_child_resources ;
                    }
                    break;


                default:
                    break;
            }            
        }
        
        return $return_data_info;
    }
    
    
    // shortcode for Selection  of booking resources 
    function wpdev_get_booking_select_form($booking_select_form, $attr){    global $wpdb;

       if ( isset( $attr['nummonths'] ) ) { $my_boook_count = $attr['nummonths'];  }
       else $my_boook_count = 1;

       if ( isset( $attr['type'] ) )      { $my_boook_type = $attr['type'];        }

       if ( isset( $attr['form_type'] ) ) { $my_booking_form = $attr['form_type']; }
       else $my_booking_form = 'standard';

       if ( isset( $attr['selected_type'] ) ) { 
           $selected_booking_resource = $attr['selected_type'];            
       } else {
           $selected_booking_resource = '';
       }
       if ( isset($_GET['resource_id'] ) ) 
               $selected_booking_resource = $_GET['resource_id'];
       
       
       if ( isset( $attr['label'] ) ) { $label = $attr['label']; }
       else $label = '';

       if ( isset( $attr['first_option_title'] ) ) { $first_option_title = $attr['first_option_title']; }
       else $first_option_title = __('Please Select' ,'booking');

       $first_option_title = apply_bk_filter('wpdev_check_for_active_language',  $first_option_title );
       
       if (! empty($label))
            $booking_select_form  .= '<label for="calendar_type">'.$label.'</label>';
       
       $booking_select_form .= '<select name="active_booking_form" onchange="jQuery(\'.bk_forms\').css(\'display\', \'none\');';
       $booking_select_form .= 'document.getElementById(\'hided_booking_form\' + this.value).style.display=\'block\';" >';
       
       if ( ! empty($first_option_title) )
            $booking_select_form .= ' <option value="select" ' . ( ( $selected_booking_resource == '' )?' selected="selected" ':'' ) . '>' . $first_option_title . '</option> ';

       $my_selected_dates_without_calendar = ''; 
       
       $start_month_calendar = false; 
        if ( isset( $attr['startmonth'] ) ) { // Set start month of calendar, fomrat: '2011-1'
            $start_month_calendar = explode( '-', $attr['startmonth'] );
            if ( (is_array($start_month_calendar))  && ( count($start_month_calendar) > 1) ) { }
            else $start_month_calendar = false;
        }
              
        $bk_otions=array();
        if ( isset( $attr['options'] ) ) { $bk_otions = $attr['options']; }


       // Select the booking resources
       if ( ! empty($my_boook_type) ) $where = ' WHERE booking_type_id IN ('.$my_boook_type.') ' ;
       else                           $where = ' ';

       $or_sort = 'title_asc';
       if ( class_exists('wpdev_bk_biz_l')) $or_sort = 'prioritet';

       if (strpos($or_sort, '_asc') !== false) {                            // Order
               $or_sort = str_replace('_asc', '', $or_sort);
               $sql_order = " ORDER BY " .$or_sort ." ASC ";
       } else $sql_order = " ORDER BY " .$or_sort ." DESC ";

       if ( class_exists('wpdev_bk_biz_m'))
           $types_list = $wpdb->get_results( "SELECT booking_type_id as id, title, default_form as form FROM {$wpdb->prefix}bookingtypes" . $where . $sql_order);
       else
           $types_list = $wpdb->get_results( "SELECT booking_type_id as id, title FROM {$wpdb->prefix}bookingtypes" . $where . $sql_order);

       // Sort booking resources by order, which  set in the "type" parameter of bookingselect shortcode.
       if ( ! empty($my_boook_type) ) {
            $br_data_array = array();
            foreach ( $types_list as $br_data ) {
                $br_data_array[ $br_data->id ] = $br_data;
            }
            $br_ordered_array = array();
            $br_order = explode(',', $my_boook_type);
            foreach ( $br_order as $br_id ) {
                if ( isset( $br_data_array[ $br_id ] ) ) {
                    $br_ordered_array[] = $br_data_array[ $br_id ];
                }
            }
            $types_list = $br_ordered_array;
       }

       if ( ( empty($first_option_title) ) && empty( $selected_booking_resource) && (! empty($types_list)) ) {
           $selected_booking_resource = $types_list[0]->id;
       }
       
       foreach ($types_list as $tl) {
        if ( $selected_booking_resource == $tl->id ) 
             $is_res_selected = ' selected="SELECTED" ';
        else $is_res_selected = '';
        $bk_res_title = apply_bk_filter('wpdev_check_for_active_language', $tl->title );
        $booking_select_form .= ' <option '.$is_res_selected.' value="'.$tl->id.'">'.$bk_res_title.'</option>';
       }
       $booking_select_form .= ' </select><br/><br/>';

       foreach ($types_list as $tl) {
           
        if ( $selected_booking_resource == $tl->id )
             $is_res_selected = 'display: block;';
        else $is_res_selected = 'display: none;';
           
        $booking_select_form .= ' <div class="bk_forms" id="hided_booking_form'.$tl->id.'" style="'.$is_res_selected.'">';

         //$my_boook_type=1,$my_boook_count=1, $my_booking_form = 'standard',  $my_selected_dates_without_calendar = '', $start_month_calendar = false
        if ( ( isset($tl->form) ) && ( ! isset( $attr['form_type'] ) ) )
            $booking_select_form .= apply_bk_filter('wpdevbk_get_booking_form', $tl->id , $my_boook_count, $tl->form, $my_selected_dates_without_calendar, $start_month_calendar, $bk_otions );
        else
            $booking_select_form .= apply_bk_filter('wpdevbk_get_booking_form', $tl->id , $my_boook_count, $my_booking_form, $my_selected_dates_without_calendar, $start_month_calendar, $bk_otions );

        $booking_select_form .= '</div>';
       }

       return $booking_select_form;
    }


//     H   A   S   H                          //HASH_EDIT /////////////////////////////////////////////////////////////////////////////////////////

    // Get booking ID and type by booking HASH    // Edit exist booking - get ID of this booking
    function get_hash_to_id($blank, $booking_hash){

            if ($booking_hash != '') {
                global $wpdb;
                $sql = $wpdb->prepare( "SELECT booking_id as id, booking_type as type FROM {$wpdb->prefix}booking as bk  WHERE  bk.hash = %s", $booking_hash );
                $res = $wpdb->get_results( $sql );
                if (isset($res))
                    if( (count($res>0)) && (isset($res[0]->id)) && (isset($res[0]->type)) ){
                        return array($res[0]->id, $res[0]->type);
                    }
            }
            return false;
    }

    // Get booking ID and type by booking HASH    // Edit exist booking - get ID of this booking
    function get_id_using_hash($blank, $booking_id){

            if ($booking_id!= '') {
                global $wpdb;
                $sql = $wpdb->prepare( "SELECT hash, booking_type as type FROM {$wpdb->prefix}booking as bk  WHERE  bk.booking_id = %s", $booking_id );
                $res = $wpdb->get_results( $sql );

                if (count($res>0)) {
                    return array($res[0]->hash, $res[0]->type);
                }
            }
            return false;
    }

    function get_params_of_shortcode_in_string($shortcode, $subject) {
        $pos = strpos($subject, '['.$shortcode );
        if ( $pos !== false ) {
           $pos2 = strpos($subject, ']', ($pos+2));

           $my_params = substr($subject, $pos+strlen('['.$shortcode), ( $pos2-$pos-strlen('['.$shortcode) ) );

            $pattern_to_search = '%\s*([^=]*)=[\'"]([^\'"]*)[\'"]\s*%';
            preg_match_all($pattern_to_search, $my_params, $keywords, PREG_SET_ORDER);

            foreach ($keywords as $value) {
                if (count($value)>1) {
                    $shortcode_params[ $value[1] ] = trim($value[2]);
                }
            }
            $shortcode_params['start']=$pos+1;
            $shortcode_params['end']=$pos2;

            return $shortcode_params;
        } else
           return false;
    }


    // Check email body for booking editing link and replace this shortcode by link
    function set_booking_edit_link_at_email($mail_body,$booking_id ){


                $edit_url_for_visitors = get_bk_option( 'booking_url_bookings_edit_by_visitors');
                $edit_url_for_visitors =  apply_bk_filter('wpdev_check_for_active_language', $edit_url_for_visitors );

                $my_hash_start_parameter = '&booking_hash=';
                if (strpos($edit_url_for_visitors,'?')===false) {
                    $my_hash_start_parameter = '';
                    if (substr($edit_url_for_visitors,-1,1) != '/' ) $my_hash_start_parameter .= '/';
                    $my_hash_start_parameter .= '?booking_hash=';
                }
                $edit_url_for_visitors .= $my_hash_start_parameter;

                $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_using_booking_id',false, $booking_id );
                $my_edited_bk_hash = '';
                if ($my_booking_id_type !== false) {
                    $my_edited_bk_hash    = $my_booking_id_type[0];
                    $my_boook_type        = $my_booking_id_type[1];
                    $edit_url_for_visitors .= $my_edited_bk_hash;
                    //if ($my_boook_type == '') return __('Wrong booking hash in URL (probably expired)' ,'booking');
                } else { $edit_url_for_visitors = '';}

                $mail_body = str_replace('[visitorbookingediturl]', $edit_url_for_visitors /*'<a href= "'.$edit_url_for_visitors.'" >' . __('Edit booking' ,'booking') . '</a>' */ , $mail_body);

                $mail_body = str_replace('[visitorbookingcancelurl]', $edit_url_for_visitors . '&booking_cancel=1'   , $mail_body);

                $mail_body = str_replace('[visitorbookingpayurl]', 
                        $edit_url_for_visitors . '&booking_pay=1', 
                        //' <a href="'. $edit_url_for_visitors . '&booking_pay=1' .'" >' .__('link' ,'booking') .'</a> ' ,
                        $mail_body);

                $mail_body = str_replace('[bookinghash]',$my_edited_bk_hash,$mail_body);


                // Check for URL parameter in the shortcodes
                $shortcode_params = $this->get_params_of_shortcode_in_string('visitorbookingediturl', $mail_body);
                if (! empty($shortcode_params) ) {
                   if ( isset($shortcode_params[ 'url' ]) ) {
                      $shortcode_params[ 'url' ] = str_replace('"', '', $shortcode_params[ 'url' ]);
                      $shortcode_params[ 'url' ] = str_replace("'", '', $shortcode_params[ 'url' ]);

                      $my_hash_start_parameter = '&booking_hash=';
                      if (strpos($shortcode_params[ 'url' ],'?')===false) {
                            $my_hash_start_parameter = '';
                            if (substr($shortcode_params[ 'url' ],-1,1) != '/' ) $my_hash_start_parameter .= '/';
                            $my_hash_start_parameter .= '?booking_hash=';
                      }
                      $mail_body_temp = substr($mail_body, 0, ($shortcode_params['start']-1) );
                      if ($my_booking_id_type !== false) { // Check if the HASH Exist at all  there
                             $mail_body_temp .= $shortcode_params[ 'url' ] . $my_hash_start_parameter . $my_edited_bk_hash ;
                      }
                      $mail_body_temp .= substr($mail_body, ($shortcode_params['end']+1) );
                      $mail_body = $mail_body_temp;
                   }
                }

                // Check for URL parameter in the shortcodes
                $shortcode_params = $this->get_params_of_shortcode_in_string('visitorbookingcancelurl', $mail_body);
                if (! empty($shortcode_params) ) {
                   if ( isset($shortcode_params[ 'url' ]) ) {
                      $shortcode_params[ 'url' ] = str_replace('"', '', $shortcode_params[ 'url' ]);
                      $shortcode_params[ 'url' ] = str_replace("'", '', $shortcode_params[ 'url' ]);

                      $my_hash_start_parameter = '&booking_hash=';
                      if (strpos($shortcode_params[ 'url' ],'?')===false) {
                            $my_hash_start_parameter = '';
                            if (substr($shortcode_params[ 'url' ],-1,1) != '/' ) $my_hash_start_parameter .= '/';
                            $my_hash_start_parameter .= '?booking_hash=';
                      }
                      $mail_body_temp = substr($mail_body, 0, ($shortcode_params['start']-1) );
                      if ($my_booking_id_type !== false) { // Check if the HASH Exist at all  there
                             $mail_body_temp .= $shortcode_params[ 'url' ] . $my_hash_start_parameter . $my_edited_bk_hash . '&booking_cancel=1';
                      }
                      $mail_body_temp .= substr($mail_body, ($shortcode_params['end']+1) );
                      $mail_body = $mail_body_temp;
                   }
                }

                // Check for URL parameter in the shortcodes
                $shortcode_params = $this->get_params_of_shortcode_in_string('visitorbookingpayurl', $mail_body);
                if (! empty($shortcode_params) ) {
                   if ( isset($shortcode_params[ 'url' ]) ) {
                      $shortcode_params[ 'url' ] = str_replace('"', '', $shortcode_params[ 'url' ]);
                      $shortcode_params[ 'url' ] = str_replace("'", '', $shortcode_params[ 'url' ]);

                      $my_hash_start_parameter = '&booking_hash=';
                      if (strpos($shortcode_params[ 'url' ],'?')===false) {
                            $my_hash_start_parameter = '';
                            if (substr($shortcode_params[ 'url' ],-1,1) != '/' ) $my_hash_start_parameter .= '/';
                            $my_hash_start_parameter .= '?booking_hash=';
                      }
                      $mail_body_temp = substr($mail_body, 0, ($shortcode_params['start']-1) );
                      if ($my_booking_id_type !== false) { // Check if the HASH Exist at all  there
                             $mail_body_temp .= $shortcode_params[ 'url' ] . $my_hash_start_parameter . $my_edited_bk_hash . '&booking_pay=1';
                      }
                      $mail_body_temp .= substr($mail_body, ($shortcode_params['end']+1) );
                      $mail_body = $mail_body_temp;
                   }
                }


                return $mail_body;

    }

    // Function call after booking is inserted or modificated in post request
    function wpbc_update_booking_hash( $booking_id, $bktype = '1' ) {
           global $wpdb;

            $update_sql = $wpdb->prepare( "UPDATE {$wpdb->prefix}booking AS bk SET bk.hash = MD5('". time() . '_' . rand(1000,1000000)."') WHERE bk.booking_id = %d", $booking_id );
            if ( false === $wpdb->query( $update_sql ) ) {
                ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $bktype; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php debuge_error('Error during updating hash in BD',__FILE__,__LINE__); ?></div>'; </script> <?php
                die();
            }/**/

    }

    // chnage hash of booking after approval process
    function booking_aproved_afteraction ( $res, $booking_form_show) {
        $is_change_hash_after_approvement = get_bk_option( 'booking_is_change_hash_after_approvement');
        if( $is_change_hash_after_approvement == 'On' )
            $this->wpbc_update_booking_hash( $res->booking_id );
    }




// D e l e t e
    // Delete some bookings by visitor request of CAncellation (Ajax request)
    function delete_booking_by_visitor(){   global $wpdb;

        make_bk_action('check_multiuser_params_for_client_side', $_POST[ "bk_type"] );

        $booking_hash = $_POST[ "booking_hash" ];
        $my_boook_type= $_POST[ "bk_type" ];
        $denyreason = __('The booking was canceled by the visitor.' ,'booking');

        $my_edited_bk_id = false;
        $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $booking_hash );


        if ($my_booking_id_type !== false) {
            $my_edited_bk_id        = $my_booking_id_type[0];
            $my_boook_type_new      = $my_booking_id_type[1];

            if ( ($my_boook_type_new == '') || ($my_boook_type_new == false) ) {

                ?>
                <script type="text/javascript">
                    document.getElementById('submiting<?php echo $my_boook_type; ?>').innerHTML = '<div class=\"submiting_content\" ><?php echo __('Wrong booking hash in URL (probably expired)' ,'booking'); ?></div>';
                    document.getElementById("submiting<?php echo $my_boook_type; ?>" ).style.display="block";
                    jQuery('#submiting<?php echo $my_boook_type; ?>').fadeOut(<?php echo get_bk_option( 'booking_title_after_reservation_time'); ?>);
                </script>
                <?php
                die;
            }
            $my_boook_type = $my_boook_type_new;
        } else {
                ?>
                <script type="text/javascript">
                    document.getElementById('submiting<?php echo $my_boook_type; ?>').innerHTML = '<div class=\"submiting_content\" ><?php echo __('Wrong booking hash in URL (probably expired)' ,'booking'); ?></div>';
                    document.getElementById("submiting<?php echo $my_boook_type; ?>" ).style.display="block";
                    jQuery('#submiting<?php echo $my_boook_type; ?>').fadeOut(<?php echo get_bk_option( 'booking_title_after_reservation_time'); ?>);
                </script>
                <?php
                die();
        }


        if ( ($my_edited_bk_id !=false) && ($my_edited_bk_id !='')) {
            $approved_id_str = $my_edited_bk_id;
            $is_send_emeils = 1;

            
            wpbc_send_email_trash( $approved_id_str, $is_send_emeils, $denyreason );
            if ( false === $wpdb->query( "UPDATE {$wpdb->prefix}booking AS bk SET bk.trash = 1 WHERE booking_id IN ({$approved_id_str})" ) ){ 
                ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $my_boook_type; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php debuge_error('Error during deleting dates at DB',__FILE__,__LINE__ ); ?></div>'; </script> <?php
                die();
            }
                
            
//            wpbc_send_email_deny($approved_id_str, $is_send_emeils, $denyreason);
//            if ( false === $wpdb->query( "DELETE FROM {$wpdb->prefix}bookingdates WHERE booking_id IN ($approved_id_str)"  ) ){
//                ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $my_boook_type; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php debuge_error('Error during deleting dates at DB',__FILE__,__LINE__ ); ?></div>'; </script> <?php
//                die();
//            }
//            if ( false === $wpdb->query( "DELETE FROM {$wpdb->prefix}booking WHERE booking_id IN ($approved_id_str)"  ) ){
//                ?> <script type="text/javascript"> document.getElementById('submiting<?php echo $my_boook_type; ?>').innerHTML = '<div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php debuge_error('Error during deleting booking at DB' ,__FILE__,__LINE__); ?></div>'; </script> <?php
//                die();
//            }


            // Visitor cancellation
            ?> <script type="text/javascript">
                document.getElementById('submiting<?php echo $my_boook_type; ?>').innerHTML = '<div class=\"submiting_content\" ><div style=&quot;height:20px;width:100%;text-align:center;margin:15px auto;&quot;><?php echo __('The booking has been canceled successfully' ,'booking'); ?></div></div>';
                document.getElementById("booking_form_div<?php echo $my_boook_type; ?>" ).style.display="none";
                makeScroll('#booking_form<?php echo $my_boook_type; ?>' );
                jQuery('#submiting<?php echo $my_boook_type; ?>').fadeOut(<?php echo get_bk_option( 'booking_title_after_reservation_time'); ?>);
               </script>
            <?php
            die();
        }
    }


                                    

// C l i e n t     s i d e     f u n c t i o n s     /////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Define JavaScripts Variables               //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function wpbc_define_js_vars( $where_to_load = 'both' ){ 
        wp_localize_script('wpbc-global-vars', 'wpbc_global2', array(
              'message_time_error'  => esc_js(__('Incorrect date format' ,'booking'))
        ) );        
    }    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Load JavaScripts Files                     //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    function wpbc_enqueue_js_files( $where_to_load = 'both' ){         
        wp_enqueue_script( 'wpbc-meio-mask', WPBC_PLUGIN_URL . '/inc/js/jquery.meio.mask.min'.((WP_BK_MIN)?'.min':'').'.js', array( 'wpbc-global-vars' ), '1.0');
        wp_enqueue_script( 'wpbc-personal',  WPBC_PLUGIN_URL . '/inc/js/personal'.((WP_BK_MIN)?'.min':'').'.js', array( 'wpbc-global-vars' ), '1.0');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Load CSS Files                     //////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    function wpbc_enqueue_css_files( $where_to_load = 'both' ){         
        
    }
            


// B o o k i n g     T y p e s              //////////////////////////////////////////////////////////////////////////////////////////////////


    // Get booking types from DB
    function get_booking_types($is_use_filter = false , $is_use_limit=true ) { global $wpdb;

        ////////////////////////////////////////////////////////////////////////
        // CONSTANTS
        ////////////////////////////////////////////////////////////////////////
        /*update_bk_option( 'booking_resourses_num_per_page',10);
        $defaults = array(
                'page_num' => '1',
                'page_items_count' => get_bk_option( 'booking_resourses_num_per_page')
        );

        $r = wp_parse_args( $args, $defaults );
        extract( $r, EXTR_SKIP );
        /**/
        $page_num         = (isset($_REQUEST['page_num']))?$_REQUEST['page_num']:1;         // Pagination
        $page_items_count = get_bk_option( 'booking_resourses_num_per_page');
        $page_start = ( $page_num - 1 ) * $page_items_count ;


        $sql = " SELECT * FROM {$wpdb->prefix}bookingtypes as bt" ;
        $or_sort = 'title_asc';
        //$or_sort = 'booking_type_id_asc';
        $where = '';                                                        // Where for the different situation: BL and MU
        $where = apply_bk_filter('multiuser_modify_SQL_for_current_user', $where);
        if ($where != '') $where = ' WHERE ' . $where;
        if ( class_exists('wpdev_bk_biz_l')) {
            if ($where != '')   $where .= ' AND bt.parent = 0 ';
            else                $where .= ' WHERE bt.parent = 0 ';
            $or_sort = 'prioritet';
        }

        if (isset($_REQUEST['wh_resource_id'])) {
             if ($where == '') $where .= " WHERE " ;
             else $where .= " AND ";
             $where .= $wpdb->prepare( " ( (bt.booking_type_id = %s) ", $_REQUEST['wh_resource_id'] ) 
                       . "OR (bt.title like '%%". wpbc_clean_like_string_for_db( $_REQUEST['wh_resource_id'] ) ."%%') )  ";
        }

        if (strpos($or_sort, '_asc') !== false) {                            // Order
               $or_sort = str_replace('_asc', '', $or_sort);
               $sql_order = " ORDER BY " .$or_sort ." ASC ";
        } else $sql_order = " ORDER BY " .$or_sort ." DESC ";

        if ($is_use_limit) $sql_limit = $wpdb->prepare( " LIMIT %d, %d ", $page_start, $page_items_count ) ;
        else               $sql_limit = " ";

        $types_list = $wpdb->get_results(  $sql .  $where. $sql_order . $sql_limit  );



        $bk_type_id = array();                                              // Get all ID of booking resources.
        if (! empty($types_list))
        foreach ($types_list as $key=>$res) {
            $types_list[$key]->id = $res->booking_type_id;
            $bk_type_id[]=$res->booking_type_id;
        }

        // FIx: This fix do not show the "Child" booking resources at the Booking > Resources page.             
        if  (    ( ( isset($_GET['hide'] )) && ( $_GET['hide'] == 'child') ) 
//                  || ( ( isset($_GET['tab'] ) ) && ( $_GET['tab'] == 'cost') ) 
            ) {
            foreach ($types_list as $key=>$res) {
                $types_list[$key]->count = 1;
                $types_list[$key]->id = $res->booking_type_id;
            }
            return $types_list;
        }

        if ( ( class_exists('wpdev_bk_biz_l')) && (count($bk_type_id)>0) ) {

            $bk_type_id = implode(',',$bk_type_id);                         // Get all ID of PARENT or SINGLE Resources.

            $sql = " SELECT * FROM {$wpdb->prefix}bookingtypes as bt" ;

            $where = '';                                                        // Where for the different situation: BL and MU
            $where = apply_bk_filter('multiuser_modify_SQL_for_current_user', $where);
            if ($where != '') $where = ' WHERE ' . $where;

            if ($where != '')   $where .= ' AND   bt.parent IN (' . $bk_type_id . ') ';
            else                $where .= ' WHERE bt.parent IN (' . $bk_type_id . ') ';

            $sql_order = 'ORDER BY parent, prioritet';                          // Order

            $linear_list_child_resources = $wpdb->get_results(  $sql . $where . $sql_order  );  // Get  child elements

            // Transfrom them into array for the future work
            $array_by_parents_child_resources = array();
            foreach ($linear_list_child_resources as $res) {
                if (! isset($array_by_parents_child_resources[$res->parent]))  $array_by_parents_child_resources[$res->parent] = array();
                $res->id = $res->booking_type_id;
                $array_by_parents_child_resources[$res->parent][] = $res;
            }


            $final_resource_array = array();
            foreach ($types_list as $key=>$res) {
                // check if exist child resources
                if ( isset($array_by_parents_child_resources[ $res->booking_type_id ])) {
                    $res->count = count( $array_by_parents_child_resources[ $res->booking_type_id ] )+1;
                } else
                    $res->count = 1;

                // Fill the parent resource
                $final_resource_array[] = $res;

                // Fill all child resources (its already sorted)
                if ( isset($array_by_parents_child_resources[ $res->booking_type_id ])) {
                    foreach ($array_by_parents_child_resources[ $res->booking_type_id ] as $child_obj) {
                        $child_obj->count = 1;
                        $final_resource_array[]  = $child_obj;
                    }
                }
            }
            $types_list = $final_resource_array;
        }

        return $types_list;

/*===========================================================================================================================================================*/

        if ( class_exists('wpdev_bk_biz_s'))  $mysql = "SELECT booking_type_id as id, title, cost FROM {$wpdb->prefix}bookingtypes  ORDER BY title";
        else                                  $mysql = "SELECT booking_type_id as id, title FROM {$wpdb->prefix}bookingtypes  ORDER BY title";

        if ( class_exists('wpdev_bk_biz_l')) {  // If Business Large then get resources from that
            $types_list = apply_bk_filter('get_booking_types_hierarhy_linear',array() );
            for ($i = 0; $i < count($types_list); $i++) {
                $types_list[$i]['obj']->count = $types_list[$i]['count'];
                $types_list[$i] = $types_list[$i]['obj'];
                //if ( ($booking_type_id != 0) && ($booking_type_id == $types_list[$i]->booking_type_id ) ) return $types_list[$i];
            }
        } else
            $types_list = $wpdb->get_results( $mysql );


        $types_list = apply_bk_filter('multiuser_resource_list', $types_list);

        return $types_list;

/**/
    }

    function get_default_booking_resource_id(){

        if ( class_exists( 'wpdev_bk_multiuser' ) ) {                           // If MU
            $bk_multiuser = apply_bk_filter( 'get_default_bk_resource_for_user', false );
            if ( $bk_multiuser !== false )
                return $bk_multiuser;
        }

        global $wpdb;
        $mysql = "SELECT booking_type_id as id FROM  {$wpdb->prefix}bookingtypes ORDER BY id ASC LIMIT 1";
        $types_list = $wpdb->get_results( $mysql );
        if ( count( $types_list ) > 0 )
            $types_list = $types_list[0]->id;
        else
            $types_list = 1;
        
        return $types_list;
    }

    // Show single menu Item
    function echoMenuItem( $title, $my_icon, $my_tab_id, $is_only_icons = 0){


        $my_style = '';
        if ($is_only_icons == 0){ $my_style = 'style="padding:4px 14px 6px;"';}
        if ($is_only_icons == 1){ $my_style = 'style="padding:4px 5px 6px 32px;"';}


        if (    ($_GET['booking_type'] == $my_tab_id) ||
                (  (! isset($_GET['booking_type'])) && ( (! isset($my_tab_id)) || ($my_tab_id==1)  )  )
           )  { $slct_a = 'selected'; }
        else  { $slct_a = ''; }


        //Start
        if ($slct_a == 'selected') {  $selected_title = $title;  $selected_icon = $my_icon;
            ?><span class="nav-tab nav-tab-active"  <?php echo $my_style; ?> ><?php
        } else {
            if ($my_tab_id == 'left')
              {  ?><span class="nav-tab" <?php echo $my_style;  ?> style="cursor:finger;" 
                 onclick="javascript:var marg = document.getElementById('menu_items_slide').style.marginLeft;
                     marg = marg.replace('px'  ,'');
                     marg = ( marg +10 ) + 'px';
                     document.getElementById('menu_items_slide').style.marginLeft = marg;"
                 ><?php }
            else
              { ?><a class="nav-tab" <?php echo $my_style; ?> href="<?php echo wpbc_get_bookings_url(); ?>&booking_type=<?php echo $my_tab_id; ?>"><?php }
        }

        if ($is_only_icons !== 0) { // Image
            if ($is_only_icons == 1) echo '&nbsp;';
            ?><img class="menuicons" src="<?php echo WPBC_PLUGIN_URL; ?>/img/<?php echo $my_icon; ?>"><?php
        }

        // Title
        if ($is_only_icons == 1) echo '&nbsp;';
        else echo $title;

        // End
        if (($slct_a == 'selected') || ($my_tab_id == 'left') || ($my_tab_id == 'right')) {
            ?></span><?php
        } else {
            ?></a><?php }
    }


// P A R S E   F o r m                      //////////////////////////////////////////////////////////////////////////////////////////////////
    function get_booking_form($my_boook_type, $my_booking_form = 'standard', $custom_params = array() ){    // FixIn:6.0.1.5


        $this->current_booking_type = $my_boook_type;
//debuge($_GET);
        // Get from the HASH booking data - BK RES  & BK ID ////////////////
        $my_edited_bk_id = false;
        if (isset($_GET['booking_hash'])) {
            $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $_GET['booking_hash'] );
            if ($my_booking_id_type !== false) {
                if (   ($my_booking_id_type[1] == '') ){

                } else {            
                    $my_boook_type        = $my_booking_id_type[1];
                    $my_edited_bk_id = $my_booking_id_type[0];
                    $this->current_booking_type = $my_booking_id_type[1];
                }
            }
        } 
        ////////////////////////////////////////////////////////////////////

//debuge($my_booking_form);
        // Get the Booking Form content ////////////////////////////////////
        if ( $my_booking_form == 'standard' ) {

            // S T A N D A R D
            $booking_form = get_bk_option( 'booking_form' );

            if ( isset( $_GET['booking_hash'] ) ) {                             // Edit Booking - in case,  if booking resource have default custom form

                
                $is_load_custom_form = true;
                //MU :: if resource of "Regular User" - then  GET STANDARD user form ( if WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS == false )
                if ( class_exists('wpdev_bk_multiuser') ) {

                    $booking_resource_user_id = apply_bk_filter('get_user_of_this_bk_resource', false, $my_boook_type );

                    $is_booking_resource_user_super_admin = apply_bk_filter('is_user_super_admin',  $booking_resource_user_id );

                    if (  ( ! $is_booking_resource_user_super_admin ) && ( ! WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS )  ){

                        // Get Form of Regular User
                        $is_load_custom_form = false;
                    }   
                }                
                
                
                if ( $is_load_custom_form ) {
                    $custom_form_name = apply_bk_filter( 'wpbc_get_default_custom_form', 'standard', $my_boook_type );
                    $my_booking_form = $custom_form_name;                           //FixIn: 5.4.2
                    if ( ( $custom_form_name != 'standard' ) && ( ! empty( $custom_form_name ) )  )
                        $booking_form = apply_bk_filter( 'wpdev_get_booking_form', $booking_form, $custom_form_name );
                }
            }
            
            // If we are have the name of booking form in the GET, so then  load it
            if ( isset( $_GET['booking_form'] ) ) {
                $my_booking_form = esc_attr( $_GET['booking_form'] );
                $booking_form = apply_bk_filter( 'wpdev_get_booking_form', $booking_form, $my_booking_form );
            }

        } else {  // C U S T O M
            $booking_form = get_bk_option( 'booking_form' );
            $booking_form = apply_bk_filter( 'wpdev_get_booking_form', $booking_form, $my_booking_form );
        }
        ////////////////////////////////////////////////////////////////////


        // Cehck  for the Active Language in the Booking Form.
        $booking_form =  apply_bk_filter('wpdev_check_for_active_language', $booking_form );
        // FixIn:6.0.1.5
        foreach ( $custom_params as $custom_params_key => $custom_params_value ) {
            $booking_form = str_replace( $custom_params_key, $custom_params_value, $booking_form );
        }
        // FixIn:6.0.1.5

        // Assign the current BK ID
        if ($my_edited_bk_id !== false)  $this->current_edit_booking = $this->get_booking_data($my_edited_bk_id);
        else                             $this->current_edit_booking =  false;

        // FixIn: 6.1.1.9          
        if ( $this->current_edit_booking !==  false ) {      
            // Check situation when  we have editing "child booking resource",  so  need to  reupdate calendar and form  to have it for parent resource.
            if  (  ( function_exists( 'wpbc_is_this_child_resource') ) && ( wpbc_is_this_child_resource( $my_boook_type ) )  ){
                $bk_parent_br_id = wpbc_get_parent_resource( $my_boook_type );        

                $this->current_edit_booking['parsed_form'];
                foreach ( $this->current_edit_booking['parsed_form'] as $old_key => $booking_data ) {
                    unset($this->current_edit_booking['parsed_form'][ $old_key ]);
                    $this->current_edit_booking['parsed_form'][ $booking_data['element_name'] . $bk_parent_br_id ]  = $booking_data;
                }

                $this->current_booking_type = $bk_parent_br_id;
                $my_boook_type = $bk_parent_br_id;     
            }   
        }
        // End: 6.1.1.9        
        
        
        // P A R S E     Booking Form
        $return_res = $this->form_elements($booking_form);
        //$return_res = wpdev_bk_form_elements($booking_form);

        // Parse additional elements in other versions
        $return_res = apply_bk_filter('wpdev_reapply_bk_form',$return_res, $this->current_booking_type, $my_booking_form);

        $return_res = $this->replace_bookingresource_info_in_form( $return_res, $this->current_booking_type );  //FixIn: 5.4.5.4

        // Set some custom elemtns:
        if ( $my_edited_bk_id !== false ) { $return_res .= '<input name="edit_booking_id"  id="edit_booking_id" type="hidden" value="'.$my_edited_bk_id.'">'; }

        if ( $my_booking_form != 'standard' ) { $return_res .= '<input name="booking_form_type'.$my_boook_type.'"  id="booking_form_type'.$my_boook_type.'" type="hidden" value="'.$my_booking_form.'">'; }

        // Select Dates in Calendar ////////////////////////////////////////
        if ( $my_edited_bk_id !== false ){                    
            ?><script type="text/javascript">
                jQuery(document).ready(function(){        
                    timeout_DSwindow=setTimeout("wpdevbk_select_days_in_calendar(<?php 
                                    echo $my_boook_type; ?>, <?php 
                                    echo 'new Array( ';
                                        foreach ($this->current_edit_booking['dates'] as $dt_key=>$dt) {
                                            $dt = trim($dt);
                                            $dta = explode(' ',$dt);
                                            $dta = explode('-',$dta[0]);
                                            echo 'new Array( ' . $dta[0].', '.$dta[1].', '.$dta[2] . ' ) ';
                                            if  ( $dt_key < (count($this->current_edit_booking['dates'])-1)  ) echo ', ';
                                        }
                                    echo ')'; ?> )", 1500); }); 
              </script><?php
        } //////////////////////////////////////////////////////////////////

        return $return_res;
    }

    
    /** Replace folowing shortcodes in the booking form at Booking > Settings > Fields page:
        [bookingresource show='id'] - to booking resource ID
        [bookingresource show='title'] - to booking resource Title
        [bookingresource show='cost'] - to  booking resource Cost
        [bookingresource show='capacity'] - to booking resource Capacity
        [bookingresource show='maxvisitors'] - to booking resource maximum  number of visitors per resource
     * @param string $return_form
     * @param int $bk_type
     * @return string
     */
    function replace_bookingresource_info_in_form( $return_form, $bk_type ) {   //FixIn: 5.4.5.4
        
        $patterns = array();
        
        $parameters = array( 'id', 'title', 'cost', 'capacity', 'maxvisitors' );
        foreach ( $parameters as $parameter ) {
            $patterns[] = '/\[bookingresource\s*show=\''. $parameter .'\'\\s*]/';
        }

        
        $replacements = array( $bk_type );
        
        $booking_resource_attr = get_booking_resource_attr( $bk_type );
        
        if ( ! empty($booking_resource_attr) ) {
            
            if ( isset( $booking_resource_attr->title ) ) {
                $bk_res_title = apply_bk_filter('wpdev_check_for_active_language', $booking_resource_attr->title );
                $replacements[] = $bk_res_title;
            } else $replacements[] = '';

            if (  ( class_exists('wpdev_bk_biz_s') ) && ( isset ($booking_resource_attr->cost ) )  ) {
                
                
                $replacements[] = wpbc_get_cost_with_currency_for_user( $booking_resource_attr->cost, $bk_type );
                
            } else $replacements[] = '';

            if (  ( class_exists('wpdev_bk_biz_l') )  ) {                        
                $number_of_child_resources = apply_bk_filter('wpbc_get_number_of_child_resources', $bk_type );        
                $replacements[] = $number_of_child_resources ;
            } else $replacements[] = '';

            if (  ( class_exists('wpdev_bk_biz_l') )  ) {                        
                $max_number_of_visitors = apply_bk_filter('wpbc_get_max_visitors_for_bk_resources', $bk_type );        
                if ( isset( $max_number_of_visitors[ $bk_type ] ) )                
                    $max_number_of_visitors = $max_number_of_visitors[ $bk_type ];
                else 
                    $max_number_of_visitors = 1;
                $replacements[] = $max_number_of_visitors ;
            } else $replacements[] = '';

            
            
        }
        $replaced_form = preg_replace( $patterns, $replacements, $return_form);
             

        return $replaced_form;
    }
    

    function get_booking_data($booking_id){
        global $wpdb;

        if (isset($booking_id)) $booking_id = $wpdb->prepare( " WHERE  bk.booking_id = %d " , $booking_id );
        else                    $booking_id = ' ';

        $sql = "SELECT * FROM {$wpdb->prefix}booking as bk
                INNER JOIN {$wpdb->prefix}bookingdates as dt
                ON    bk.booking_id = dt.booking_id
                ". $booking_id .
                " ORDER BY dt.booking_date ASC ";

        $result = $wpdb->get_results( $sql );
        $return = array( 'dates'=>array());
        foreach ($result as $res) { $return['dates'][] = $res->booking_date; }
        $return['form'] = $res->form;
        $return['type'] = $res->booking_type;
        $return['approved'] = $res->approved;
        $return['id'] = $res->booking_id;

        // Parse data from booking form ////////////////////////////////////
        $bktype = $res->booking_type;
        $parsed_form = $res->form;
        $parsed_form = explode('~',$parsed_form);

        $parsed_form_results  = array();

        foreach ($parsed_form as $field) {
            $elemnts = explode('^',$field);
            $type = $elemnts[0];
            $element_name = $elemnts[1];
            $value = $elemnts[2];

            $count_pos = strlen( $bktype );
            //debuge(substr( $elemnts[1], 0, -1*$count_pos ))                ;
            $type_name = $elemnts[1];
            $type_name = str_replace('[]','',$type_name);
            if ($bktype == substr( $type_name,  -1*$count_pos ) ) $type_name = substr( $type_name, 0, -1*$count_pos );

            if ($type_name == 'email') { if ( ! isset($email_adress)) { $email_adress = $value; } }     //FixIn: 6.0.1.9
            if ($type_name == 'name')  { $name_of_person = $value; }
            if ($type == 'checkbox') {
                if ($value == 'true')   { $value = 'on'; }
                else {
                    if (($value == 'false') || ($value == 'Off') || ( !isset($value) ) )  $value = '';
                }
            }
            $element_name = str_replace('[]','',$element_name);
            if ( isset($parsed_form_results[$element_name]) ) {
                if ($value !=='') $parsed_form_results[$element_name]['value'] .= ',' . $value;
            } else
                $parsed_form_results[$element_name] = array('value'=>$value, 'type'=> $type, 'element_name'=>$type_name );
        }
        $return['parsed_form'] = $parsed_form_results;
        ////////////////////////////////////////////////////////////////////
        if (isset($email_adress))   $return['email'] = $email_adress;
        if (isset($name_of_person)) $return['name']  = $name_of_person;

        return $return;
    }

            // Getted from script under GNU /////////////////////////////////////
            function form_elements($form, $replace = true) {
                    $types = 'text[*]?|email[*]?|coupon[*]?|time[*]?|textarea[*]?|select[*]?|checkbox[*]?|radio[*]?|acceptance|captchac|captchar|file[*]?|quiz';
                    $regex = '%\[\s*(' . $types . ')(\s+[a-zA-Z][0-9a-zA-Z:._-]*)([-0-9a-zA-Z:#_/|\s]*)?((?:\s*(?:"[^"]*"|\'[^\']*\'))*)?\s*\]%';
                    $regex_start_end_time = '%\[\s*(country[*]?|starttime[*]?|endtime[*]?)(\s*[a-zA-Z]*[0-9a-zA-Z:._-]*)([-0-9a-zA-Z:#_/|\s]*)*((?:\s*(?:"[^"]*"|\'[^\']*\'))*)?\s*\]%';
                    $submit_regex = '%\[\s*submit(\s[-0-9a-zA-Z:#_/\s]*)?(\s+(?:"[^"]*"|\'[^\']*\'))?\s*\]%';
                    if ($replace) {
                            $form = preg_replace_callback($regex, array(&$this, 'form_element_replace_callback'), $form);
                            // Start end time
                            $form = preg_replace_callback($regex_start_end_time, array(&$this, 'form_element_replace_callback'), $form);
                            // Submit button
                            $form = preg_replace_callback($submit_regex, array(&$this, 'submit_replace_callback'), $form);
                            return $form;
                    } else {
                            $results = array();
                            preg_match_all($regex, $form, $matches, PREG_SET_ORDER);
                            foreach ($matches as $match) {
                                    $results[] = (array) $this->form_element_parse($match);
                            }
                            return $results;
                    }
            }

            function form_element_replace_callback($matches) {
                    extract((array) $this->form_element_parse($matches)); // $type, $name, $options, $values, $raw_values
//debuge('1!!!!!', $type, $name, $options, $values, $raw_values);
                    if ( ($type == 'country') || ($type == 'country*') ) {
                        //debuge('$type, $name, $options, $values, $raw_values', $type, $name, $options, $values, $raw_values);
                        if ( empty($name) )
                            $name = $type ;
                    }
                    $name .= $this->current_booking_type ;


                    $my_edited_bk_id = false;
                    if (isset($_GET['booking_hash'])) {
                        $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $_GET['booking_hash'] );
                        if ($my_booking_id_type !== false) {
                            $my_edited_bk_id = $my_booking_id_type[0];  //$bk_type        = $my_booking_id_type[1];
                        }
                    }
                    //if (isset($_GET['booking_id'])) $my_edited_bk_id = $_GET['booking_id'];
                    //else $my_edited_bk_id = false;


                    // Edit values
                    if ( $my_edited_bk_id !== false ) {
                          if (preg_match('/^(?:select|country|checkbox|radio)[*]?$/', $type)) {

                              if (isset($this->current_edit_booking['parsed_form'][$name]))
                                      if (isset($this->current_edit_booking['parsed_form'][$name]['value'])) {

                                          foreach ($options as $op_key=>$value) {
                                              if (strpos($value,'default')!==false) {   // Right now we are editing specific booking
                                                  unset($options[$op_key]);             // We are do not need th  default values, so erase it.
                                              }
                                          }  

                                        $multiple_selections = explode(',',$this->current_edit_booking['parsed_form'][$name]['value']);
                                        foreach ($multiple_selections as $s_key=>$s_value) {
                                            $options[] = 'default:' . $s_value;
                                        }                                                    
                                        //$options[0] = 'default:' . $this->current_edit_booking['parsed_form'][$name]['value'];
                                      }
                          } else {
                                $values[0] = '';
                                if ( ($type == 'starttime') || ($type == 'starttime*') || ($type == 'endtime') || ($type == 'endtime*') ) {
                                    if (isset(  $this->current_edit_booking['parsed_form'][$type . $this->current_booking_type ] ))
                                        $values[0] = $this->current_edit_booking['parsed_form'][$type . $this->current_booking_type ]['value'];
                                } elseif ( ($type == 'country') || ($type == 'country*') ) {
                                    $options[0] = $this->current_edit_booking['parsed_form'][$type . $this->current_booking_type ]['value'];
                                } else {
                                    $values[0] = '';
                                    if (isset($this->current_edit_booking['parsed_form'][$name]))
                                            if (isset($this->current_edit_booking['parsed_form'][$name]['value']))
                                                $values[0] = $this->current_edit_booking['parsed_form'][$name]['value'];
                                }
                          }

                    }
//debuge($values,$options);
                    if (isset($this->processing_unit_tag)) {
                        if ($this->processing_unit_tag == $_POST['wpdev_unit_tag']) {
                                $validation_error = $_POST['wpdev_validation_errors']['messages'][$name];
                                $validation_error = $validation_error ? '<span class="wpdev-not-valid-tip-no-ajax">' . $validation_error . '</span>' : '';
                        } else {
                                $validation_error = '';
                        }
                    } else  $validation_error = '';

                    $atts = '';
            $options = (array) $options;
//debuge($type, $options);
            $id_array = preg_grep('%^id:[-0-9a-zA-Z_]+$%', $options);
            if ($id = array_shift($id_array)) {
                preg_match('%^id:([-0-9a-zA-Z_]+)$%', $id, $id_matches);
                if ($id = $id_matches[1])
                    $atts .= ' id="' . $id . $this->current_booking_type .'"';
            }

            $placeholder_array = preg_grep('%^placeholder:[-0-9a-zA-Z_]+$%', $options);
            if ($placeholder = array_shift($placeholder_array)) {
                preg_match('%^placeholder:([-0-9a-zA-Z_]+)$%', $placeholder, $placeholder_matches);
                if ($placeholder = $placeholder_matches[1])
                    $atts .= ' placeholder="' . str_replace('_',' ',$placeholder)  .'"';
            }
//debuge($atts, $placeholder_array, $placeholder, $placeholder_matches);
            $class_att = "";
            $class_array = preg_grep('%^class:[-0-9a-zA-Z_]+$%', $options);
            foreach ($class_array as $class) {
                preg_match('%^class:([-0-9a-zA-Z_]+)$%', $class, $class_matches);
                if ($class = $class_matches[1])
                    $class_att .= ' ' . $class;
            }

            if (preg_match('/^email[*]?$/', $type))
                $class_att .= ' wpdev-validates-as-email';

            if (preg_match('/^coupon[*]?$/', $type))
                $class_att .= ' wpdev-validates-as-coupon';

            if (preg_match('/^time[*]?$/', $type))
                $class_att .= ' wpdev-validates-as-time';
            if (preg_match('/^starttime[*]?$/', $type))
                $class_att .= ' wpdev-validates-as-time';
            if (preg_match('/^endtime[*]?$/', $type))
                $class_att .= ' wpdev-validates-as-time';
            if (preg_match('/[*]$/', $type))
                $class_att .= ' wpdev-validates-as-required';

            if (preg_match('/^checkbox[*]?$/', $type))
                $class_att .= ' wpdev-checkbox';

            if (preg_match('/^radio[*]?$/', $type))
                $class_att .= ' wpdev-radio';

            if (preg_match('/^captchac$/', $type))
                $class_att .= ' wpdev-captcha-' . $name;

            if ('acceptance' == $type) {
                $class_att .= ' wpdev-acceptance';
                if (preg_grep('%^invert$%', $options))
                    $class_att .= ' wpdev-invert';
            }

            if ($class_att)
                $atts .= ' class="' . trim($class_att) . '"';

                    // Value.
                    if (   (isset($this->processing_unit_tag)) && ($this->processing_unit_tag == $_POST['wpdev_unit_tag']) ) {
                            if (isset($_POST['wpdev_mail_sent']) && $_POST['wpdev_mail_sent']['ok'])
                                    $value = '';
                            elseif ('captchar' == $type)
                                    $value = '';
                            else
                                    $value = $_POST[$name];
                    } else {
                        if (isset($values[0])) $value = $values[0];
                        else $value = '';
                    }

            // Default selected/checked for select/checkbox/radio
            if (preg_match('/^(?:select|checkbox|radio)[*]?$/', $type)) {
//debuge('$options',$options);
                $scr_defaults = array_values(preg_grep('/^default:/', $options));

                $scr_default = array();                                     // Firstly set  the selected options as Empty

                foreach ($scr_defaults as $scr_defaults_value) {            // Search  for selected options

                    preg_match('/^default:([^~]+)$/', $scr_defaults_value, $scr_default_matches);
//debuge($scr_default_matches[1]);                        
                    if (isset($scr_default_matches[1])) {

                         $scr_default_option = explode('_', $scr_default_matches[1]);                        
//debuge($scr_default_option);                             
                         $scr_default_option = str_replace( '&#37;','%', $scr_default_option[0] );
                         $scr_default[] = $scr_default_option;              // Add Selected Option
                    }
                }
            }
//debuge($scr_default);

            if (preg_match('/^(?:country)[*]?$/', $type)) {
                
                $scr_defaults = array_values(preg_grep('/^default:/', $options));

                if ( ( isset($scr_defaults) ) && ( count($scr_defaults) > 0 ) && ( isset($scr_defaults[0]) )  )
                    preg_match('/^default:([0-9a-zA-Z_:\s-]+)$/', $scr_defaults[0], $scr_default_matches);
                
                if ( ( isset($scr_default_matches) ) && ( count($scr_default_matches) > 1 ) && ( isset($scr_default_matches[1]) ) ) 
                    $scr_default = explode('_', $scr_default_matches[1]);
                else 
                    $scr_default = '';
            }


                    if ( ($type == 'starttime') || ($type == 'starttime*') )     $name = 'starttime' . $this->current_booking_type ;
                    if ( ($type == 'endtime') || ($type == 'endtime*') )         $name = 'endtime' . $this->current_booking_type ;

                    switch ($type) {
                            case 'starttime':  
                            case 'starttime*':
                            case 'endtime':
                            case 'endtime*':  
                            case 'time':
                            case 'time*':
                            case 'text':
                            case 'text*':
                            case 'email':
                            case 'email*':
                            case 'coupon':
                            case 'coupon*':
                            case 'captchar':
                                    if (is_array($options)) {
                                            $size_maxlength_array = preg_grep('%^[0-9]*[/x][0-9]*$%', $options);
                                            if ($size_maxlength = array_shift($size_maxlength_array)) {
                                                    preg_match('%^([0-9]*)[/x]([0-9]*)$%', $size_maxlength, $sm_matches);
                                                    if ($size = (int) $sm_matches[1])
                                                            $atts .= ' size="' . $size . '"';
                            else
                                $atts .= ' size="40"';
                                                    if ($maxlength = (int) $sm_matches[2])
                                                            $atts .= ' maxlength="' . $maxlength . '"';
                                            } else {
                            $atts .= ' size="40"';
                        }
                                    }

                                    if ( ($type=='coupon') || ($type=='coupon*'))
                                        $additional_js = ' onchange="javascript:if(typeof( showCostHintInsideBkForm ) == \'function\') {  showCostHintInsideBkForm('.$this->current_booking_type.');}" ';
                                    else
                                        $additional_js = '';

                                    $html = '<input type="text" name="' . $name . '" value="' . esc_attr($value) . '"' . $atts . $additional_js . ' />';
                                    $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                    return $html;
                                    break;
                            case 'textarea':
                            case 'textarea*':
                                    if (is_array($options)) {
                                            $cols_rows_array = preg_grep('%^[0-9]*[x/][0-9]*$%', $options);
                                            if ($cols_rows = array_shift($cols_rows_array)) {
                                                    preg_match('%^([0-9]*)[x/]([0-9]*)$%', $cols_rows, $cr_matches);
                                                    if ($cols = (int) $cr_matches[1])
                                                            $atts .= ' cols="' . $cols . '"';
                            else
                                $atts .= ' cols="40"';
                                                    if ($rows = (int) $cr_matches[2])
                                                            $atts .= ' rows="' . $rows . '"';
                            else
                                $atts .= ' rows="10"';
                                            } else {
                            $atts .= ' cols="40" rows="10"';
                        }
                                    }
                                    $html = '<textarea name="' . $name . '"' . $atts . '>' . $value . '</textarea>';
                                    $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                    return $html;
                                    break;
                            case 'country':
                            case 'country*':

                                    $html = '';
                                    //debuge($values, $empty_select);
                                    foreach ($this->countries_list as $key => $value_country) {
                                        $selected = '';
//debuge($key , $value, $scr_default, in_array($key , (array) $scr_default) );
                                        if ( in_array($key , (array) $scr_default)) $selected = ' selected="selected"';
                                        if ($value == $key ) { $selected = ' selected="selected"'; }
                                        //if ($this->processing_unit_tag == $_POST['wpdev_unit_tag'] && ( $multiple && in_array($value, (array) $_POST[$name]) || ! $multiple && $_POST[$name] == $value)) $selected = ' selected="selected"';
                                        $html .= '<option value="' . esc_attr($key) . '"' . $selected . '>' . $value_country . '</option>';
                                    }
                                    $html = '<select name="' . $name   . '"' . $atts . '>' . $html . '</select>';
                                    $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                    return $html;
                                    break;

                            case 'select':
                            case 'select*':
//debuge($options);                                    
                    $multiple = (preg_grep('%^multiple$%', $options)) ? true : false;
                    $include_blank = preg_grep('%^include_blank$%', $options);

                                    if ($empty_select = empty($values) || $include_blank)
                                            array_unshift($values, '---');

                                    $html = '';

                    if (preg_match('/^select[*]?$/', $type) &&  $multiple && ($name == 'rangetime' . $this->current_booking_type ) ) 
                            $onclick = ' wpdevExclusiveSelectbox(this); ';
                    else    $onclick = '';

//debuge($values, $empty_select);
                    foreach ($values as $key => $value) {

                        $selected = '';

                        $my_title = false;
                        if (strpos($value, '@@') !==false ) {
                            $my_title_value = explode('@@',$value);
                            $my_title = $my_title_value[0];
                            $value = $my_title_value[1];
                        }                                                        
//debuge( $value, $scr_default );
                        if ( in_array($value , (array) $scr_default))
                            $selected = ' selected="selected"';
                        if ( (isset($this->processing_unit_tag)) && ($this->processing_unit_tag == $_POST['wpdev_unit_tag']) && (
                                $multiple && in_array($value, (array) $_POST[$name]) ||
                                ! $multiple && $_POST[$name] == $value))
                            $selected = ' selected="selected"';

                       // debuge($name, $atts);
                        if ( ($name == 'rangetime' . $this->current_booking_type ) && (strpos($atts,'hideendtime')!== false ) )
                            $html .= '<option value="' . esc_attr($value) . '"' . $selected . '>' . ( (empty($my_title))?( substr($value,0, strpos($value,'-')) ):($my_title) ) . '</option>';
                        elseif  ($name == 'rangetime' . $this->current_booking_type ) {

                            $time_format = get_bk_option( 'booking_time_format');

                            $value_times = explode('-', $value);
                            $value_times[0] = trim($value_times[0]);
                            $value_times[1] = trim($value_times[1]);

                            $s_tm = explode(':', $value_times[0]);
                            $e_tm = explode(':', $value_times[1]);

                            $s_tm_value = $s_tm;
                            $e_tm_value = $e_tm;

                            $s_tm = date_i18n( $time_format, mktime( intval( $s_tm[0] ), intval( $s_tm[1] ) ) );
                            $e_tm = date_i18n( $time_format, mktime( intval( $e_tm[0] ), intval( $e_tm[1] ) ) );
                            $t_delimeter = ' - ';
                            if (strpos($atts,'hideendtime')!== false ) {
                               $e_tm = '';
                               $t_delimeter = '';
                            }

                            // Recheck for some errors in time formating of shortcode, like whitespace or empty zero before hours less then 10am
                            $s_tm_value[0] = trim($s_tm_value[0]);
                            $s_tm_value[1] = trim($s_tm_value[1]);
                            if ( ($s_tm_value[0] + 0) < 10 ) $s_tm_value[0] = '0' . ($s_tm_value[0] + 0);
                            if ( ($s_tm_value[1] + 0) < 10 ) $s_tm_value[1] = '0' . ($s_tm_value[1] + 0);
                            $e_tm_value[0] = trim($e_tm_value[0]);
                            $e_tm_value[1] = trim($e_tm_value[1]);
                            if ( ($e_tm_value[0] + 0) < 10 ) $e_tm_value[0] = '0' . ($e_tm_value[0] + 0);
                            if ( ($e_tm_value[1] + 0) < 10 ) $e_tm_value[1] = '0' . ($e_tm_value[1] + 0);

                            $value_time_range =  $s_tm_value[0] . ':' . $s_tm_value[1] . $t_delimeter . $e_tm_value[0] . ':' . $e_tm_value[1];

                            $html .= '<option value="' . esc_attr($value_time_range) . '"' . $selected . '>' . ( (empty($my_title))?($s_tm . $t_delimeter . $e_tm):($my_title) ) . '</option>';

                        } elseif  ($name == 'starttime' . $this->current_booking_type ) {
                            $time_format = get_bk_option( 'booking_time_format');
                            $s_tm = explode(':', $value);                            
                            $s_tm = date_i18n($time_format, mktime($s_tm[0], $s_tm[1]));
                            $html .= '<option value="' . esc_attr($value) . '"' . $selected . '>' . ( (empty($my_title))?($s_tm):($my_title) )   . '</option>';

                        } elseif  ($name == 'endtime' . $this->current_booking_type ) {
                            $time_format = get_bk_option( 'booking_time_format');
                            $s_tm = explode(':', $value);
                            $s_tm = date_i18n($time_format, mktime($s_tm[0], $s_tm[1]));
                            $html .= '<option value="' . esc_attr($value) . '"' . $selected . '>' . ( (empty($my_title))?($s_tm):($my_title) )   . '</option>';

                        } else {
                            if (strpos($value, '@@') !==false ) {
                                $my_title_value = explode('@@',$value);
                                $html .= '<option value="' . esc_attr($my_title_value[1]) . '"' . $selected . '>' . $my_title_value[0] . '</option>';
                            } else
                                $html .= '<option value="' . esc_attr($value) . '"' . $selected . '>' . ( (empty($my_title))?($value):($my_title) )  . '</option>';
                        }
                    }

                    if ($multiple)
                        $atts .= ' multiple="multiple"';

                                    $html = '<select onchange="javascript:'.$onclick.'if(typeof( showCostHintInsideBkForm ) == \'function\') {  showCostHintInsideBkForm('.$this->current_booking_type.');}" '
                                            .'name="' . $name . ($multiple ? '[]' : '') . '"' 
                                            . $atts 
                                            . '>' 
                                            . $html . '</select>';
                                    $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
//debuge($options, $values, $scr_default, $html);die;
                                    return $html;
                                    break;
                case 'checkbox':
                case 'checkbox*':
                case 'radio':
                case 'radio*':
                    $multiple = (preg_match('/^checkbox[*]?$/', $type) && ! preg_grep('%^exclusive$%', $options)) ? true : false;
                    $html = '';

                    if (preg_match('/^checkbox[*]?$/', $type) && ! $multiple) 
                            $onclick = ' onclick="wpdevExclusiveCheckbox(this);"';

                    $defaultOn = (bool) preg_grep('%^default:on$%', $options);
                    $defaultOn = $defaultOn ? ' checked="checked"' : '';

                    $input_type = rtrim($type, '*');

                    $id_attr_for_group    = '';   

                    foreach ($values as $key => $value) {
                        $checked = '';

                        // Check  if the Lables Titles different from the Values inside of the checkboxes.
                        $label_different = false;
                        if (strpos($value, '@@') !== false ) {
                            $my_title_value = explode('@@',$value);
                            $label_different    = $my_title_value[0];
                            $value              = $my_title_value[1];
                        } else $label_different = $value;
                        ////////////////////////////////////////////////////////////////////////////////////

                        // Get default selected options ////////////////////
                        $multi_values = array();
                        foreach ($options as $op_value) {
                            $multi_values[] = str_replace('default:', '', $op_value);
                        }                      
                        $multi_values = implode(',',$multi_values);
                        $multi_values_array = explode(',',$multi_values);
                        foreach ($multi_values_array as $mv) {
                            if ( ( trim($mv) == trim($value) ) && ($value !=='') ) 
                                $checked = ' checked="checked"';
                        }
                        ////////////////////////////////////////////////////

                        if (in_array($key + 1, (array) $scr_default))       //TODO: ??? Need to retest this parameter
                            $checked = ' checked="checked"';

                        if (                                                //TODO: ??? Need to retest this parameter
                                (isset($this->processing_unit_tag)) 
                                && ($this->processing_unit_tag == $_POST['wpdev_unit_tag']) 
                                && ( 
                                     $multiple 
                                     && in_array($value, (array) $_POST[$name] ) 
                                     || ! $multiple 
                                     && $_POST[$name] == $value
                                   )
                           ) 
                            $checked = ' checked="checked"';
                        ////////////////////////////////////////////////////

                        if (! isset($onclick)) $onclick = '';

                        $is_use_label       = ( preg_grep('%^use[_-]?label[_-]?element$%', $options) ) ? 'label' : 'span';                            
                        $is_use_label_first = ( preg_grep('%^label[_-]?first$%', $options) ) ? true : false;
//debuge($options, $is_use_label, $is_use_label_first, 0);


                        $id_attr_for_checkbox = ''; 
                        $label_for_parameter  = '';
                        // If we are using the LABELS instead of the SPAN so  we are need
                        // to remove the ID attribute from the INPUT elements (we can set it to the parent element)                            
                        if ( $is_use_label == 'label' ) {

                            preg_match('%id="([-0-9a-zA-Z_]+)"%', $atts , $id_matches);
                            if ( count($id_matches) > 0 ) {
                                $atts = str_replace($id_matches[0], '', $atts);
                                $id_attr_for_group = ' id="'.$id_matches[1].'" ';                                    
                                $id_attr_for_checkbox = $id_matches[1]. time().$key.rand(10,100);     //Uniq ID
                            } else {
                                $id_attr_for_checkbox = 'checkboxid'. time().$key.rand(10,100);       //Uniq ID
                            }

                            $label_for_parameter  = ' for="'. $id_attr_for_checkbox . '" ';
                            $id_attr_for_checkbox = ' id="' . $id_attr_for_checkbox . '" ';   
                        }

                        $item_label = '<'.$is_use_label . $label_for_parameter. ' class="wpdev-list-item-label">' . $label_different . '</'.$is_use_label.'>';

                        $item = '<input '
                                . $atts
                                . $id_attr_for_checkbox
                                .' onchange="javascript:if(typeof( showCostHintInsideBkForm ) == \'function\') {  showCostHintInsideBkForm('.$this->current_booking_type.');}" '
                                .' type="' . $input_type . '" '
                                .' name="' . $name . ($multiple ? '[]' : '') . '" '
                                .' value="' . esc_attr($value) . '"' 
                                . $checked 
                                . $onclick 
                                . $defaultOn 
                                . ' />';

                        if ( $is_use_label_first ) 
                            $item = $item_label . '&nbsp;' . $item;
                        else 
                            $item = $item . '&nbsp;' . $item_label;

                        $item = '<span class="wpdev-list-item">' . $item . '</span>';
                        $html .= $item;
                    }

                    $html = '<span' . $atts . $id_attr_for_group . '>' . $html . '</span>';
                    $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                    return $html;
                    break;

                case 'quiz':
                    if (count($raw_values) == 0 && count($values) == 0) { // default quiz
                        $raw_values[] = '1+1=?|2';
                        $values[] = '1+1=?';
                    }

                    $pipes = $this->get_pipes($raw_values);

                    if (count($values) == 0) {
                        break;
                    } elseif (count($values) == 1) {
                        $value = $values[0];
                    } else {
                        $value = $values[array_rand($values)];
                    }

                    $answer = $this->pipe($pipes, $value);
                    $answer = $this->canonicalize($answer);

                                    if (is_array($options)) {
                                            $size_maxlength_array = preg_grep('%^[0-9]*[/x][0-9]*$%', $options);
                                            if ($size_maxlength = array_shift($size_maxlength_array)) {
                                                    preg_match('%^([0-9]*)[/x]([0-9]*)$%', $size_maxlength, $sm_matches);
                                                    if ($size = (int) $sm_matches[1])
                                                            $atts .= ' size="' . $size . '"';
                            else
                                $atts .= ' size="40"';
                                                    if ($maxlength = (int) $sm_matches[2])
                                                            $atts .= ' maxlength="' . $maxlength . '"';
                                            } else {
                            $atts .= ' size="40"';
                        }
                                    }

                    $html = '<span class="wpdev-quiz-label">' . $value . '</span>&nbsp;';
                    $html .= '<input type="text" name="' . $name . '"' . $atts . ' />';
                    $html .= '<input type="hidden" name="wpdev_quiz_answer_' . $name . '" value="' . wp_hash($answer, 'wpdev_quiz') . '" />';
                                    $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                                    return $html;
                    break;
                case 'acceptance':
                    $invert = (bool) preg_grep('%^invert$%', $options);
                    $default = (bool) preg_grep('%^default:on$%', $options);

                    $onclick = ' onclick="wpdevToggleSubmit(this.form);"';
                    $checked = $default ? ' checked="checked"' : '';
                    $html = '<input type="checkbox" name="' . $name . '" value="1"' . $atts . $onclick . $checked . ' />';
                    return $html;
                    break;
                case 'captchac':
                    if (! class_exists('ReallySimpleCaptcha')) {
                        return '<em>' . 'To use CAPTCHA, you need <a href="http://wordpress.org/extend/plugins/really-simple-captcha/">Really Simple CAPTCHA</a> plugin installed.' . '</em>';
                        break;
                    }

                                    $op = array();
                                    // Default
                                    $op['img_size'] = array(72, 24);
                                    $op['base'] = array(6, 18);
                                    $op['font_size'] = 14;
                                    $op['font_char_width'] = 15;

                                    $op = array_merge($op, $this->captchac_options($options));

                                    if (! $filename = $this->generate_captcha($op)) {
                                            return '';
                                            break;
                                    }
                                    if (is_array($op['img_size']))
                                            $atts .= ' width="' . $op['img_size'][0] . '" height="' . $op['img_size'][1] . '"';
                                    $captcha_url = trailingslashit($this->captcha_tmp_url()) . $filename;
                                    $html = '<img alt="captcha" src="' . $captcha_url . '"' . $atts . ' />';
                                    $ref = substr($filename, 0, strrpos($filename, '.'));
                                    $html = '<input type="hidden" name="wpdev_captcha_challenge_' . $name . '" value="' . $ref . '" />' . $html;
                                    return $html;
                                    break;
                case 'file':
                case 'file*':
                    $html = '<input type="file" name="' . $name . '"' . $atts . ' value="1" />';
                    $html = '<span class="wpdev-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
                    return $html;
                    break;
                    }
            }

            function submit_replace_callback($matches) {
            $atts = '';
            $options = array();
            if (isset($matches[2]))            
                $options = preg_split('/[\s]+/', trim($matches[1]));

            $id_array = preg_grep('%^id:[-0-9a-zA-Z_]+$%', $options);
            if ($id = array_shift($id_array)) {
                preg_match('%^id:([-0-9a-zA-Z_]+)$%', $id, $id_matches);
                if ($id = $id_matches[1])
                    $atts .= ' id="' . $id . '"';
            }

            $class_att = '';
            $class_array = preg_grep('%^class:[-0-9a-zA-Z_]+$%', $options);
            foreach ($class_array as $class) {
                preg_match('%^class:([-0-9a-zA-Z_]+)$%', $class, $class_matches);
                if ($class = $class_matches[1])
                    $class_att .= ' ' . $class;
            }

            $html = '';
            if ($class_att)
                $atts .= ' class="' . trim($class_att) . '"';
                    if (isset($matches[2]))
                        if ($matches[2])   $value = $this->strip_quote($matches[2]);
                    if (empty($value)) $value = __('Send' ,'booking');
                    $ajax_loader_image_url =   WPBC_PLUGIN_URL . '/assets/img/ajax-loader.gif';

                    if (isset($_GET['booking_hash'])) {
                        $my_booking_id_type = apply_bk_filter('wpdev_booking_get_hash_to_id',false, $_GET['booking_hash'] );
                        if ($my_booking_id_type !== false) {
                            $my_edited_bk_id = $my_booking_id_type[0];  //$bk_type        = $my_booking_id_type[1];

                            $admin_uri = ltrim( str_replace( get_site_url( null, '', 'admin' ), '', admin_url('admin.php?') ), '/' ) ;    
                            if (  ( strpos($_SERVER['REQUEST_URI'], $admin_uri ) !== false ) && ( isset( $_SERVER['HTTP_REFERER'] ) )  )
                                $html .= '<input type="hidden" name="wpdev_http_referer" id="wpdev_http_referer" value="' . $_SERVER['HTTP_REFERER'] . '" />' ;

                            $value = __('Change your Booking' ,'booking');
                            if (isset($_GET['booking_cancel'])) {
                                $value = __('Cancel Booking' ,'booking');

                                $wpbc_nonce  = wp_nonce_field('DELETE_BY_VISITOR',  ("wpbc_nonce_delete" . $this->current_booking_type) ,  true , false );
                                $html .= $wpbc_nonce . '<input type="button" value="' . $value . '"' . $atts . ' onclick="bookingCancelByVisitor(\''.$_GET['booking_hash'].'\','.$this->current_booking_type.', \''.wpbc_get_booking_locale().'\' );" />';                                                  
                                $html .= '<img class="ajax-loader"  style="vertical-align:middle;box-shadow:none;width:14px;visibility: hidden;" alt="ajax loader" src="' . $ajax_loader_image_url . '" />';

                                return $html;
                            }
                        }
                    }


                    $html .= '<input type="button" value="' . $value . '"' . $atts . ' onclick="mybooking_submit(this.form,'.$this->current_booking_type.', \''.wpbc_get_booking_locale().'\' );" />';
                    $html .= '<img class="ajax-loader"  style="vertical-align:middle;box-shadow:none;width:14px;visibility: hidden;" alt="ajax loader" src="' . $ajax_loader_image_url . '" />';

                    return $html;
            }

            function form_element_parse($element) {
                    $type = trim($element[1]);
                    $name = trim($element[2]);
                    $options = preg_split('/[\s]+/', trim($element[3]));

                    preg_match_all('/"[^"]*"|\'[^\']*\'/', $element[4], $matches);
                    $raw_values = $this->strip_quote_deep($matches[0]);

                    if ( preg_match('/^(select[*]?|checkbox[*]?|radio[*]?)$/', $type) || 'quiz' == $type) {
                        $pipes = $this->get_pipes($raw_values);
                        $values = $this->get_pipe_ins($pipes);
                    } else {
                        $values =& $raw_values;
                    }

                    return compact('type', 'name', 'options', 'values', 'raw_values');
            }

            function strip_quote($text) {
                    $text = trim($text);
                    if (preg_match('/^"(.*)"$/', $text, $matches))
                            $text = $matches[1];
                    elseif (preg_match("/^'(.*)'$/", $text, $matches))
                            $text = $matches[1];
                    return $text;
            }

            function strip_quote_deep($arr) {
                    if (is_string($arr))
                            return $this->strip_quote($arr);
                    if (is_array($arr)) {
                            $result = array();
                            foreach ($arr as $key => $text) {
                                    $result[$key] = $this->strip_quote($text);
                            }
                            return $result;
                    }
            }

            function pipe($pipes, $value) {
                if (is_array($value)) {
                    $results = array();
                    foreach ($value as $k => $v) {
                        $results[$k] = $this->pipe($pipes, $v);
                    }
                    return $results;
                }

                foreach ($pipes as $p) {
                    if ($p[0] == $value)
                        return $p[1];
                }

                return $value;
            }

            function get_pipe_ins($pipes) {
                $ins = array();
                foreach ($pipes as $pipe) {
                    $in = $pipe[0];
                    if (! in_array($in, $ins))
                        $ins[] = $in;
                }
                return $ins;
            }

            function get_pipes($values) {
                $pipes = array();

                foreach ($values as $value) {
                    $pipe_pos = strpos($value, '|');
                    if (false === $pipe_pos) {
                        $before = $after = $value;
                    } else {
                        $before = substr($value, 0, $pipe_pos);
                        $after = substr($value, $pipe_pos + 1);
                    }

                    $pipes[] = array($before, $after);
                }

                return $pipes;
            }

            function pipe_all_posted($contact_form) {
                $all_pipes = array();

                $fes = $this->form_elements($contact_form['form'], false);
                foreach ($fes as $fe) {
                    $type = $fe['type'];
                    $name = $fe['name'];
                    $raw_values = $fe['raw_values'];

                    if (! preg_match('/^(select[*]?|checkbox[*]?|radio[*])$/', $type))
                        continue;

                    $pipes = $this->get_pipes($raw_values);

                    $all_pipes[$name] = array_merge($pipes, (array) $all_pipes[$name]);
                }

                foreach ($all_pipes as $name => $pipes) {
                    if (isset($this->posted_data[$name]))
                        $this->posted_data[$name] = $this->pipe($pipes, $this->posted_data[$name]);
                }
            }
            ////////////////////////////////////////////////////////////////////////



//  A d m i n   P a n e l  ->  B o o k i n g    p a g e           //////////////////////////////////////////////////////////////////////////////////////////////////
    function wpdev_updating_bk_resource_of_booking(){
        
                $booking_id  = intval( $_POST["booking_id"] );
                $resource_id = intval( $_POST["resource_id"] );
                global $wpdb;

               // 0.Get dates of specific booking
                $sql = $wpdb->prepare( "SELECT *
                        FROM  {$wpdb->prefix}booking as bk
                        WHERE booking_id = %d ", $booking_id );
                $res = $wpdb->get_row( $sql  );
                $formdata = $res->form;
                $bktype   = $res->booking_type;

                // 1.Get dates of specific booking
                $sql = $wpdb->prepare( "SELECT *
                        FROM  {$wpdb->prefix}bookingdates as dt
                        WHERE booking_id = %d
                        ORDER BY booking_date ASC ", $booking_id );
                $selected_dates_array = $wpdb->get_results( $sql );

                // Get dates in good format for SQL checking
                $dates_string = '';
                foreach ($selected_dates_array as $k=>$v) {
                    $dates_string .= " DATE('" . $v->booking_date . "'), ";
                }
                $dates_string = substr($dates_string,0,-2);

                $trash_bookings = ' AND bk.trash != 1 ';                                //FixIn: 6.1.1.10  - check also  below usage of {$trash_bookings}

                //2. Get bookings of selected booking resource - checking if some dates there is booked or not
                $sql = $wpdb->prepare( "SELECT *
                            FROM {$wpdb->prefix}booking as bk
                            INNER JOIN {$wpdb->prefix}bookingdates as dt
                            ON    bk.booking_id = dt.booking_id
                            WHERE     bk.booking_type = %d {$trash_bookings}",  $resource_id ) ;
                $sql .=       " AND DATE(dt.booking_date) IN ( $dates_string )";                
//              $sql .= apply_bk_filter('get_sql_4_dates_from_other_types', ''  , $resource_id, '0,1' ); // Select bk ID from other TYPES, if they partly exist inside of DATES
                //FixIn: 6.0.1.16
                //TODO (start  from 6.1.1.10): need to  check situation  here about belonging specific booking to TRASH,  here in BL version its does not chekked for booking belonging to  several  booking resources 
                if ( class_exists('wpdev_bk_biz_l')) {
                    $sql .= " OR  bk.booking_id IN ( SELECT DISTINCT booking_id FROM {$wpdb->prefix}bookingdates as dtt WHERE  dtt.approved IN ( 0,1 ) AND dtt.type_id = {$resource_id} "
                                                        . " AND DATE(dt.booking_date) IN ( $dates_string )"
                                                    .") ";
                }                                
                $sql .= "   ORDER BY bk.booking_id DESC, dt.booking_date ASC ";

                $exist_dates_results = $wpdb->get_results( $sql );
                
                //FixIn: 5.4.5 /////////////////////////////////////////////////              
                $is_date_time_booked = wpbc_check_dates_intersections( $selected_dates_array, $exist_dates_results );
                
                if ( ! $is_date_time_booked ) { // Possible to change
                ////////////////////////////////////////////////////////////////
                
                    // Chnage the booking form:

                    // Fix the booking form ID of elements /////////////////////////////////////////////////////////////////
                    $updated_type_id = $resource_id;
                    $formdata_new = '';
                    $formdata_array = explode('~',$formdata);
                    $formdata_array_count = count($formdata_array);
                    for ( $i=0 ; $i < $formdata_array_count ; $i++) {
                        $elemnts = explode('^',$formdata_array[$i]);

                        $type = $elemnts[0];
                        $element_name = $elemnts[1];
                        $value = $elemnts[2];

                        $element_sufix = '';
                        if (substr($element_name, -2  )=='[]') {
                            //$element_sufix = '[]';
                            //$element_name = substr($element_name, 0,  (strlen($element_name) - 1) ) ;
                            $element_name = str_replace('[]', '', $element_name);
                        }

                        $element_name = substr($element_name, 0, -1 * strlen($bktype) ) . $updated_type_id    ;  // Change bk RES. ID in elemnts of FORM

                        if ($formdata_new!='') $formdata_new.= '~';
                        $formdata_new .= $type . '^' . $element_name . '^' . $value;
                    } ////////////////////////////////////////////////////////////////////////////////////////////////

                    // Update
                    $update_sql = $wpdb->prepare( "UPDATE {$wpdb->prefix}booking AS bk SET bk.form=%s, bk.booking_type=%d WHERE bk.booking_id=%d;"
                            ,$formdata_new, $updated_type_id, $booking_id );
                    if ( false === $wpdb->query( $update_sql ) ) {
                         ?> <script type="text/javascript">
                                var my_message = '<?php echo html_entity_decode( esc_js( get_debuge_error('Error during updating booking reource type in BD' ,__FILE__,__LINE__) ),ENT_QUOTES) ; ?>';
                                wpbc_admin_show_message( my_message, 'error', 30000 );                                                                                                                                                                          
                        </script> <?php
                        die();
                   }


                    if ( class_exists('wpdev_bk_biz_l')) {
                        $update_sql =  $wpdb->prepare( "UPDATE {$wpdb->prefix}bookingdates SET type_id=NULL WHERE booking_id=%d ", $booking_id  );
                        if ( false === $wpdb->query( $update_sql ) ) {
                            ?> <script type="text/javascript">
                                var my_message = '<?php echo html_entity_decode( esc_js( get_debuge_error('Error during updating dates type in BD' ,__FILE__,__LINE__) ),ENT_QUOTES) ; ?>';
                                wpbc_admin_show_message( my_message, 'error', 30000 );                                                                                                                                                                          
                            </script> <?php
                            die();
                        }
                    }
                    
                    if ( isset( $_POST["is_send_emeils"] ) ) $is_send_emeils = intval( $_POST["is_send_emeils"] );
                    else                                     $is_send_emeils = 1; 

                    // Send modification email about this
                    if ( $is_send_emeils )                                      //FixIn: 6.1.0.2
                        wpbc_send_email_modified( $booking_id, $resource_id, $formdata_new );
                    
                    ?> <script type="text/javascript">
                        set_booking_row_resource_name('<?php echo $booking_id; ?>', '<?php
                                                        $bk_booking_type_name = get_booking_title($resource_id);
                                                        if (strlen($bk_booking_type_name)>19) $bk_booking_type_name = substr($bk_booking_type_name, 0, 16) . '...';
                                                        echo $bk_booking_type_name;
                                                      ?>');
                        var my_message = '<?php echo html_entity_decode( esc_js( __('Updated successfully' ,'booking') ),ENT_QUOTES) ; ?>';
                        wpbc_admin_show_message( my_message, 'success', 5000 );                                                                                                           
                    </script> <?php

                } else {            // Already busy there, need to chnage to other resource

                    ?> <script type="text/javascript">
                            var my_message = '<?php echo html_entity_decode( esc_js( __('Warning! The resource was not changed. Current dates are already booked there.' ,'booking') ),ENT_QUOTES) ; ?>';
                            wpbc_admin_show_message( my_message, 'warning', 50000 );                                                                                                                                       
                    </script> <?php

                }
                die;
            }


    //FixIn: 5.4.5.1
    function wpbc_duplicate_booking_to_other_resource() {
        $booking_id  = intval( $_POST["booking_id"] );
        $resource_id = intval( $_POST["resource_id"] );
        $wpdev_active_locale = $_POST["wpdev_active_locale"];
        
        global $wpdb;

       // 0.Get dates of specific booking
        $sql = $wpdb->prepare( "SELECT *
                FROM  {$wpdb->prefix}booking as bk
                WHERE booking_id = %d ", $booking_id );
        $res = $wpdb->get_row( $sql  );
        $formdata = $res->form;
        $bktype   = $res->booking_type;

        // 1.Get dates of specific booking
        $sql = $wpdb->prepare( "SELECT *
                FROM  {$wpdb->prefix}bookingdates as dt
                WHERE booking_id = %d
                ORDER BY booking_date ASC ", $booking_id );
        $selected_dates_array = $wpdb->get_results( $sql );

        // Get dates in good format for SQL checking
        $dates_string = '';
        $simple_dates_array_of_exist_booking = array();
        foreach ($selected_dates_array as $k=>$v) {
            $dates_string .= " DATE('" . $v->booking_date . "'), ";
            
            $simple_dates_array_of_exist_booking[ strtotime( substr($v->booking_date, 0, 10) ) ] = substr($v->booking_date, 0, 10);
        }
        $dates_string = substr($dates_string,0,-2);
        
        $trash_bookings = ' AND bk.trash != 1 ';                                //FixIn: 6.1.1.10  - check also  below usage of {$trash_bookings}

        //2. Get bookings of selected booking resource - checking if some dates there is booked or not
        $sql = $wpdb->prepare( "SELECT *
                    FROM {$wpdb->prefix}booking as bk
                    INNER JOIN {$wpdb->prefix}bookingdates as dt
                    ON    bk.booking_id = dt.booking_id
                    WHERE     bk.booking_type = %d {$trash_bookings} ",  $resource_id ) ;
        $sql .=       " AND DATE(dt.booking_date) IN ( $dates_string )";
//      $sql .= apply_bk_filter('get_sql_4_dates_from_other_types', ''  , $resource_id, '0,1' ); // Select bk ID from other TYPES, if they partly exist inside of DATES
        //FixIn: 6.0.1.16
        //TODO (start  from 6.1.1.10): need to  check situation  here about belonging specific booking to TRASH,  here in BL version its does not chekked for booking belonging to  several  booking resources 
        if ( class_exists('wpdev_bk_biz_l')) {
            $sql .= " OR  bk.booking_id IN ( SELECT DISTINCT booking_id FROM {$wpdb->prefix}bookingdates as dtt WHERE  dtt.approved IN ( 0,1 ) AND dtt.type_id = {$resource_id} "
                                                . " AND DATE(dt.booking_date) IN ( $dates_string )"
                                            .") ";
        }                        
        $sql .= "   ORDER BY bk.booking_id DESC, dt.booking_date ASC ";

        $exist_dates_results = $wpdb->get_results( $sql );

        //FixIn: 5.4.5 /////////////////////////////////////////////////              
        $is_date_time_booked = wpbc_check_dates_intersections( $selected_dates_array, $exist_dates_results );

        if ( ! $is_date_time_booked ) { // Possible to change
        
// debuge('Duplicate booking ' . $booking_id . ' to booking resource ' . $resource_id );
            
            
            // Fix the booking form ID of elements /////////////////////////////////////////////////////////////////
            $updated_type_id = $resource_id;
            $formdata_new = '';
            $formdata_array = explode('~',$formdata);
            $formdata_array_count = count($formdata_array);
            for ( $i=0 ; $i < $formdata_array_count ; $i++) {
                $elemnts = explode('^',$formdata_array[$i]);

                $type = $elemnts[0];
                $element_name = $elemnts[1];
                $value = $elemnts[2];

                $element_sufix = '';
                if (substr($element_name, -2  )=='[]') {
                    //$element_sufix = '[]';
                    //$element_name = substr($element_name, 0,  (strlen($element_name) - 1) ) ;
                    $element_name = str_replace('[]', '', $element_name);
                }

                $element_name = substr($element_name, 0, -1 * strlen($bktype) ) . $updated_type_id    ;  // Change bk RES. ID in elemnts of FORM

                if ($formdata_new!='') $formdata_new.= '~';
                
                $formdata_new .= $type . '^' . $element_name . '^' . $value;
            } ////////////////////////////////////////////////////////////////////////////////////////////////

            // Dates ///////////////////////////////////////////////////////////
            sort( $simple_dates_array_of_exist_booking );
            
            // Chnage dates from '2015-10-17' to '17.10.2015'
            $my_dates_for_sql = array();
            foreach ($simple_dates_array_of_exist_booking as $selected_date) {
                $selected_date = explode( '-', $selected_date );
                $my_dates_for_sql[]  = sprintf( "%02d.%02d.%04d", $selected_date[2], $selected_date[1], $selected_date[0] );
            }
            $my_dates_for_sql = implode( ', ', $my_dates_for_sql ); 
            ////////////////////////////////////////////////////////////////////
            
                        
            /*
            $params = array(
                ["bktype"] => 4
                ["dates"] => 24.09.2014, 25.09.2014, 26.09.2014
                ["form"] => select-one^rangetime4^14:00 - 16:00~text^name4^Costa~text^secondname4^Rika~email^email4^rika@cost.com~text^phone4^2423432~text^address4^Ferrari~text^city4^Rome~text^postcode4^2343~select-one^country4^IT~select-one^visitors4^1~select-one^children4^0~textarea^details4^dhfjksdhfkdhjs~checkbox^term_and_condition4[]^I Accept term and conditions
                ["is_send_emeils"] => 1
                ["booking_form_type"] => 
                      [wpdev_active_locale] => en_US
            
                      // Paramters for adding booking in the HTML:
                      ["skip_page_checking_for_updating"] = 0;
                      ["is_show_payment_form"] = 1;
              ); */ 
            // Params for creation  new booking
            $params = array(
                    'bktype'  => $updated_type_id
                    , 'dates' => $my_dates_for_sql                              // '27.08.2014, 28.08.2014, 29.08.2014'
                    , 'form'  => $formdata_new
                    , 'is_send_emeils' => 0
                    , 'booking_form_type' => ''
                    , 'wpdev_active_locale' => $wpdev_active_locale
            ); 
            
// debuge($params, $selected_dates_array, $formdata_new, $simple_dates_array_of_exist_booking , $my_dates_for_sql);            
            $booking_id = apply_bk_filter('wpbc_add_new_booking_filter' , $params ); 

            ?> <script type="text/javascript">
                    var my_message = '<?php echo html_entity_decode( esc_js( __('The booking has been duplicated successfully' ,'booking') ),ENT_QUOTES) ; ?>';
                    wpbc_admin_show_message( my_message, 'success', 3000 );                                                                                                                               
                    setTimeout(function ( ) {location.reload(true);} ,1500);
            </script> <?php
            
        ////////////////////////////////////////////////////////////////
        }  else {            // Already busy there, need to chnage to other resource

            ?> <script type="text/javascript">
                    var my_message = '<?php echo html_entity_decode( esc_js( __('Warning! Operation failed. Current dates are already booked there.' ,'booking') ),ENT_QUOTES) ; ?>';
                    wpbc_admin_show_message( my_message, 'warning', 30000 );                                                                                                                               
            </script> <?php

        }
        die;
    }        
    //     R  E   M   A   R   K   S      /////////////////////////////////////////////////////////////////////////////////////////

        function wpdev_updating_remark(){
            $remark_id   = $_POST["remark_id"];
            $remark_text = $_POST["remark_text"];

            $remark_text = str_replace('%','&#37;',$remark_text);
            $my_remark = str_replace('"','',$remark_text);
            $my_remark = str_replace("'",'',$my_remark);
            $my_remark =trim($my_remark);

            global $wpdb;

            $update_sql =  $wpdb->prepare( "UPDATE {$wpdb->prefix}booking AS bk SET bk.remark= %s WHERE bk.booking_id= %d ", $remark_text, $remark_id );
            if ( false === $wpdb->query( $update_sql ) ) {
                ?> <script type="text/javascript">
                        var my_message = '<?php echo html_entity_decode( esc_js( get_debuge_error('Error during updating notes in DB' ,__FILE__,__LINE__) ),ENT_QUOTES) ; ?>';
                        wpbc_admin_show_message( my_message, 'error', 30000 );                                                                                                                                                                                                  
                </script> <?php
                die();
            }

            ?> <script type="text/javascript">
                <?php if ( strlen( $my_remark ) > 100 ) {
                    $my_remark = esc_js( substr( $my_remark, 0, 100 ) ) . '...';                    
                } 
                $my_remark = str_replace(array("\r\n", "\n", "\r"),' ',$my_remark);
                ?>
                set_booking_row_remark_in_hint(<?php echo $remark_id; ?>, "<?php echo $my_remark; ?>") ; 
                var my_message = '<?php echo html_entity_decode( esc_js( __('Updated successfully' ,'booking') ),ENT_QUOTES) ; ?>';
                wpbc_admin_show_message( my_message, 'success', 3000 );                                                                                                                                               
            </script> <?php
            die();
        }

        function wpdev_make_update_of_remark($remark_id, $remark_text, $is_append = false ){

             $my_remark = str_replace('"','',$remark_text);
             $my_remark = str_replace("'",'',$my_remark);
             $my_remark =trim(strip_tags($my_remark));
             //$my_remark = substr($my_remark,0,75) . '...';

            global $wpdb;

            if ( $is_append ) {
                $my_remark .= ' ' . $wpdb->get_var( $wpdb->prepare( "SELECT remark FROM {$wpdb->prefix}booking  WHERE booking_id = %d " , $remark_id ) );
            }

            $update_sql =  $wpdb->prepare( "UPDATE {$wpdb->prefix}booking AS bk SET bk.remark= %s WHERE bk.booking_id= %d ", $my_remark, $remark_id );
            if ( false === $wpdb->query( $update_sql  ) ) {
                   echo '<div class="error_message ajax_message textleft" style="font-size:12px;font-weight:600;">';
                   debuge_error('Error during updating remark of booking' ,__FILE__,__LINE__);
                   echo   '</div>';

            }

        }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




    // Check if user can be at some admin panel, which belong to specific booking resource
    function recheck_version($blank){ 

        $ver = get_bk_option('bk_version_data');      

        if ( $ver === false ) {
            ?>
            <div id="recheck_version">
                <div class="clear" style="height:10px;"></div>
                <script type="text/javascript">
                    function sendRecheck(order_num){

                        // Code geeted from  this function:  wpbc_admin_show_message( wpbc_message, 'info', 10000 );                                                               

                        var wpbc_message = ' <span class="wpdevelop"><span class="glyphicon glyphicon-refresh wpbc_spin wpbc_ajax_icon"  aria-hidden="true"></span></span> ' 
                                            + '<?php echo esc_js( __('Sending request...' ,'booking') ) ; ?>';
                        var wpbc_alert_class = 'notice notice-info ';
                        jQuery('#ajax_working').html(   '<div id="wpbc_alert_message" class="wpbc_alert_message">' +
                                                            '<div ' 
                                                                + 'id="ajax_message"'           //Backward compatibility
                                                                + ' class="wpbc_inner_message ' + wpbc_alert_class + '"> ' +
                                                                '<a class="close" href="javascript:void(0)" onclick="javascript:jQuery(this).parent().hide();">&times;</a> ' + 
                                                                wpbc_message + 
                                                            '</div>' +
                                                        '</div>'
                                                    );
                        //jQuery('#wpbc_alert_message').animate( {opacity: 1}, 60000 ).fadeOut(500);        
                                                            
                        jQuery.ajax({                                           // Start Ajax Sending
                            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                            type:'POST',
                            success: function (data, textStatus){if( textStatus == 'success')   jQuery('#ajax_respond').html( data );},
                            error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);if (XMLHttpRequest.status == 500) {alert('Please check at this page according this error:' + ' http://wpbookingcalendar.com/faq/#ajax-sending-error');}},
                            data:{
                                action : 'CHECK_BK_VERSION',
                                order_num:order_num,
                                wpbc_nonce: document.getElementById('wpbc_admin_panel_nonce').value 
                            }
                        });
                    }
                </script>
                <div style="margin:15px auto;" class="code_description wpdevelop">
                    <div class="shortcode_help_section well0">
                        <div style="width:auto;text-align: center;padding:10px;">
                            <span style="font-weight:600;font-size:1.1em;line-height:24px;margin-right:10px;" ><?php _e('Order number' ,'booking'); ?>:</span>
                            <input type="text" maxlength="20" value="" style="width:170px;" id="bk_order_number" name="bk_order_number" />
                            <input class="button" style="" type="button" value="<?php _e('Register' ,'booking'); ?>" name="submit_advanced_resources_settings" onclick="javascript:sendRecheck(document.getElementById('bk_order_number').value);" />
                            <div class="clear" style="height:10px;"></div>
                            <span style="font-style: italic;text-shadow:0 1px 0 #fff;font-size:1em;"><?php _e('Please, enter order number of your purchased version, which you received to your billing email.' ,'booking');?></span>
                            <div class="clear" style="height:20px;"></div>
                            <span class="description" style="font-style: italic;font-size:1em;"><?php printf(__('If you will get any difficulties or have a questions, please contact by email %s' ,'booking'),'<code><a href="mailto:activate@wpbookingcalendar.com">activate@wpbookingcalendar.com</a></code>');?></span><br/>
                        </div>
                    </div>
                </div>
            </div>            
            <?php 
            return false;
        }
        return true;
    }

}
