<?php /**
 * @version 1.0
 * @package Booking > Resources page
 * @category Settings page 
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-08-13
 * 
 * This is COMMERCIAL SCRIPT
 * We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/** Show Content
 *  Update Content
 *  Define Slug
 *  Define where to show
 */
class WPBC_Page_Settings__bresources extends WPBC_Page_Structure {


    public function in_page() {
        return 'wpbc-resources';
    }
    

    public function tabs() {
        
        $tabs = array();
                
        $tabs[ 'resources' ] = array(
                              'title'       => __('Resources','booking')            // Title of TAB    
                            , 'hint'        => __('Customizaton of booking resources', 'booking')                      // Hint    
                            , 'page_title'  => ucwords( __('Booking resources','booking') )                               // Title of Page    
                            //, 'link'      => ''                                 // Can be skiped,  then generated link based on Page and Tab tags. Or can  be extenral link
                            //, 'position'  => 'left'                             // 'left'  ||  'right'  ||  ''
                            //, 'css_classes'=> ''                                // CSS class(es)
                            //, 'icon'      => ''                                 // Icon - link to the real PNG img
                            , 'font_icon' => 'glyphicon glyphicon-list'           // CSS definition  of forn Icon
                            , 'default'   => true                              // Is this tab activated by default or not: true || false. 
                            //, 'disabled'  => false                              // Is this tab disbaled: true || false. 
                            , 'hided'     => ( class_exists('wpdev_bk_biz_m') ) ? false : true                              // Is this tab hided: true || false. 
                            , 'subtabs'   => array()   
                    );
        
        /*
        $subtabs = array();        
        $subtabs[ 'gcal' ] = array( 
                            'type' => 'subtab'                                  // Required| Possible values:  'subtab' | 'separator' | 'button' | 'goto-link' | 'html'
                            , 'title' => __('Google Calendar' ,'booking') . '  - ' . __('Events Import' ,'booking')         // Title of TAB    
                            , 'page_title' => __('Google Calendar' ,'booking') . ' ' . __('Settings' ,'booking')    // Title of Page   
                            , 'hint' => __('Customization of synchronization with Google Calendar' ,'booking')      // Hint    
                            , 'link' => ''                                      // link
                            , 'position' => ''                                  // 'left'  ||  'right'  ||  ''
                            , 'css_classes' => ''                               // CSS class(es)
                            //, 'icon' => 'http://.../icon.png'                 // Icon - link to the real PNG img
                            //, 'font_icon' => 'glyphicon glyphicon-envelope'   // CSS definition of Font Icon
                            , 'default' =>  true                                // Is this sub tab activated by default or not: true || false. 
                            , 'disabled' => false                               // Is this sub tab deactivated: true || false. 
                            , 'checkbox'  => false                              // or definition array  for specific checkbox: array( 'checked' => true, 'name' => 'feature1_active_status' )   //, 'checkbox'  => array( 'checked' => $is_checked, 'name' => 'enabled_active_status' )
                            , 'content' => 'content'                            // Function to load as conten of this TAB
                        );        
        $tabs[ 'users' ]['subtabs'] = $subtabs;
        */
        
        return $tabs;
    }


    /** Show Content of Settings page */
    public function content() {

        $this->css();
        
        ////////////////////////////////////////////////////////////////////////
        // Checking 
        ////////////////////////////////////////////////////////////////////////

        do_action( 'wpbc_hook_settings_page_header', 'resources');              // Define Notices Section and show some static messages, if needed
        
        if ( ! wpbc_is_mu_user_can_be_here('activated_user') ) return false;    // Check if MU user activated, otherwise show Warning message.
   
        // if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;  // User is not Super admin, so exit.  Basically its was already checked at the bottom of the PHP file, just in case.
        
        
        ////////////////////////////////////////////////////////////////////////
        // Load Data 
        ////////////////////////////////////////////////////////////////////////
        
        
        ////////////////////////////////////////////////////////////////////////
        //  S u b m i t   Main Form  
        ////////////////////////////////////////////////////////////////////////
        
        $submit_form_name = 'wpbc_bresources';                         // Define form name
        
        // $this->get_api()->validated_form_id = $submit_form_name;             // Define ID of Form for ability to  validate fields (like required field) before submit.
        
        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name );  // Its stop show anything on submiting, if its not refear to the original page

            // Save Changes 
            $this->update();
        }                
        
        do_action('wpbc_bresources_check_submit_actions');
         
        ////////////////////////////////////////////////////////////////////////
        // JavaScript: Tooltips, Popover, Datepick (js & css) 
        ////////////////////////////////////////////////////////////////////////
        
        echo '<span class="wpdevelop">';
        
        wpbc_js_for_bookings_page();                                        

        // Toolbar
        $this->toolbar();


        echo '</span>';

        ?><div class="clear" style="margin-bottom:35px;"></div><?php
        
        
        // Scroll links ////////////////////////////////////////////////////////
        if (0) {
        ?>
        <div class="wpdvlp-sub-tabs" style="background:none;border:none;box-shadow: none;padding:0;"><span class="nav-tabs" style="text-align:right;">
            <?php  if ( class_exists('wpdev_bk_personal') ) {  ?>
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_booking_resource_table' );" original-title="" class="nav-tab go-to-link"><span><?php _e('Resources' ,'booking'); ?></span></a>
            <?php } ?>
        </span></div>
        <?php
        }
        
        wpbc_toolbar_search_by_id__top_form( array( 
                                                    'search_form_id' => 'wpbc_booking_resources_search_form'
                                                  , 'search_get_key' => 'wh_resource_id'
                                                  , 'is_pseudo'      => false
                                            ) );

        
        ////////////////////////////////////////////////////////////////////////
        // Content  ////////////////////////////////////////////////////////////
        ?>
        <div class="clear" style="margin-bottom:0px;"></div>
        <span class="metabox-holder">
            <form  name="<?php echo $submit_form_name; ?>" id="<?php echo $submit_form_name; ?>" action="" method="post" autocomplete="off">
                <?php 
                   // N o n c e   field, and key for checking   S u b m i t 
                   wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo $submit_form_name; ?>" id="is_form_sbmitted_<?php echo $submit_form_name; ?>" value="1" /><?php                 
                ?><div class="clear"></div><?php                 
                /* ?>
                <div class="wpbc-settings-notice notice-info" style="text-align:left;">
                    <strong><?php _e('Note!' ,'booking'); ?></strong> <?php 
                        printf( __('If you do not see search results at front-end side of your website, please check troubleshooting instruction %shere%s' ,'booking'),'<a href="http://wpbookingcalendar.com/faq/no-search-results/" target="_blank">','</a>');
                    ?>
                </div>
                <div class="clear" style="height:10px;"></div><?php 
                */             
                ?>
                <div class="clear" style="margin-top:20px;"></div>
                <div id="wpbc_booking_resource_table" class="wpbc_settings_row wpbc_settings_row_rightNO"><?php 
                
                    // wpbc_open_meta_box_section( 'wpbc_settings_bresources_resources', __('Resources', 'booking') );
                        
                        $this->wpbc_resources_table__show();
                        
                    // wpbc_close_meta_box_section();
                ?>
                </div>
                <div class="clear"></div>                
                <select id="bulk-action-selector-bottom" name="bulk-action">
                    <option value="-1"><?php _e('Bulk Actions', 'booking'); ?></option>
                    <option value="edit"><?php _e('Edit', 'booking'); ?></option>
                    <option value="delete"><?php _e('Delete', 'booking'); ?></option>
                </select>    
                
                <a href="javascript:void(0);" onclick="javascript: jQuery('#wpbc_bresources').submit();"
                  class="button button-primary wpbc_button_save" ><?php _e('Save Changes','booking'); ?></a>
                <a href="javascript:void(0);" id="wpbc_button_delete"
                  class="button wpbc_button_delete" style="display:none;background: #d9534f;border:#b92c28 1px solid;color:#eee;" ><?php _e('Delete','booking'); ?></a>
                
                    
                <span class="wpbc_button_delete" style="display:none;">
                    <div class="clear" style="height:10px;"></div>
                    <div class="wpbc-settings-notice notice-warning" style="text-align:left;">
                        <strong><?php _e('Note!' ,'booking'); ?></strong> <?php 
                            printf( __('Please reassign exist booking(s) from selected resource(s) to other resources or delete exist booking(s) from  this resource(s). Otherwise you will have %slost bookings%s.' ,'booking')
                                    ,'<a href="' . wpbc_get_menu_url('booking') . '&wh_booking_type" >','</a>');
                        ?>
                    </div>
                    <div class="clear" ></div>
                </span>    
                    
                    
            </form>
            <script type="text/javascript">
                jQuery('#bulk-action-selector-bottom').on( 'change', function(){    
                    if ( jQuery('#bulk-action-selector-bottom option:selected').val() == 'delete' ) { 
                        jQuery('.wpbc_button_delete').show();
                        jQuery('.wpbc_button_save').hide();
                    } else {
                        jQuery('.wpbc_button_delete').hide();
                        jQuery('.wpbc_button_save').show();
                    }
                } ); 
                jQuery('#wpbc_button_delete').on( 'click', function(){    
                    if ( wpbc_are_you_sure('<?php echo esc_js( __('Do you really want to do this ?' ,'booking') ); ?>') ) { 
                        jQuery('#wpbc_bresources').submit(); 
                    }
                } ); 
            </script>
        </span>
        <?php       
    
        do_action( 'wpbc_hook_settings_page_footer', 'resources' );
        
        $this->enqueue_js();
    }


    /** Save Chanages */  
    public function update() {

//        if (  ( wpbc_is_this_demo() ) ||  ( ! class_exists( 'wpdev_bk_personal' ) )  )
//            return;

        global $wpdb;

        $wpbc_br_table = new WPBC_BR_Table( 'resources_submit' );
        $linear_resources_for_one_page = $wpbc_br_table->get_linear_data_for_one_page();
                
        if ( isset( $_POST['bulk-action' ] ) ) 
            $submit_action = $_POST['bulk-action' ];
        else 
            $submit_action = 'edit';
        
        $bulk_action_arr_id = array();
        
        foreach ( $linear_resources_for_one_page as $resource_id => $resource ) {

            // Check posts of only visible on page booking resources 
            if ( isset( $_POST['booking_resource_' . $resource_id ] ) ) {

                    switch ( $submit_action ) {
                        case 'delete':                                          // Delete

                            if ( isset( $_POST['br-select-' . $resource_id ] ) )
                                    $bulk_action_arr_id[] = intval( $resource_id );
                            break;

                        default:                                                // Edit

                                // Validate POST value
                                $validated_value = WPBC_Settings_API::validate_text_post_static( 'booking_resource_' . $resource_id );

                                //if ( $validated_value != $resource['title'] ) {               // Check  if its different from  original value in DB

                                    // Need this complex query  for ability to  define different paramaters in differnt versions.
                                    $sql_arr = apply_filters(   'wpbc_resources_table__update_sql_array'
                                                                        , array(
                                                                                'sql'       => array(
                                                                                                      'start'   => "UPDATE {$wpdb->prefix}bookingtypes SET "
                                                                                                    , 'params' => array( 'title = %s' )                         
                                                                                                    , 'end'    => " WHERE booking_type_id = %d"
                                                                                            )
                                                                                , 'values'  => array( $validated_value )
                                                                            )
                                                                        , $resource_id, $resource 
                                                        );                
                                    $sql_arr['values'][] = intval( $resource_id );              // last parameter  for " WHERE booking_type_id = %d "

                                    $sql = $wpdb->prepare(    $sql_arr['sql']['start']                          // SQL
                                                                . implode( ', ' , $sql_arr['sql']['params'] ) 
                                                                . $sql_arr['sql']['end']            
                                                            , $sql_arr[ 'values' ]                              // Array of validated parameters
                                                        ); 

                                    if ( false === $wpdb->query( $sql )  ){ debuge_error( 'Error saving to DB' ,__FILE__ , __LINE__); }         // Save to DB
                                    
                                    wpbc_show_changes_saved_message();   
                            break;
                    }

                    
                //}
            }

        }


        
        if ( ! empty( $bulk_action_arr_id ) ) {
            
                    switch ( $submit_action ) {
                        
                        case 'delete':                                          // Delete
                            $bulk_action_arr_id = implode( ',', $bulk_action_arr_id );
                            $sql = "DELETE FROM {$wpdb->prefix}bookingtypes WHERE booking_type_id IN ({$bulk_action_arr_id})";

                            if ( false === $wpdb->query( $sql )  ){ debuge_error( 'Error during deleting items in DB' ,__FILE__ , __LINE__); }         // Action inDB

                            wpbc_show_message ( __( 'Deleted', 'booking'), 5 );
                            
                        default:                                                // Edit
                            break;
                    }
        }
        
        make_bk_action( 'wpbc_reinit_booking_resource_cache' );

        
        
        
        /**
        // Get Validated Email fields
        $validated_fields = $this->get_api()->validate_post();        
        $validated_fields = apply_filters( 'wpbc_fields_before_saving_to_db__bresources', $validated_fields );   //Hook for validated fields.        
//debuge($validated_fields);                
        $this->get_api()->save_to_db( $validated_fields );
        */
        
             
        
        // Old way of saving:
        // update_bk_option( 'booking_cache_expiration' , WPBC_Settings_API::validate_text_post_static( 'booking_cache_expiration' ) );
    }



    // <editor-fold     defaultstate="collapsed"                        desc=" CSS  &   JS   "  >
    
    /** CSS for this page */
    private function css() {
        ?>
        <style type="text/css">  
            .wpbc-help-message {
                border:none;
            }
            /* Selectbox element in toolbar */
            .visibility_container select optgroup{                            
                color:#999;
                vertical-align: middle;
                font-style: italic;
                font-weight: 400;
            }
            .visibility_container select option {
                padding:5px;
                font-weight: 600;
            }
            .visibility_container select optgroup option{
                padding: 5px 20px;       
                color:#555;
                font-weight: 600;
            }
            #wpbc_create_new_custom_form_name_fields {
                width: 360px;
                display:none;
            }
            @media (max-width: 399px) {
                #wpbc_create_new_custom_form_name_fields {
                    width: 100%;
                }          
            }
        </style>
        <?php
    }
    
    
    
    /**     Add Custon JavaScript - for some specific settings options
     *      Executed After post content, after initial definition of settings,  and possible definition after POST request.
     * 
     * @param type $menu_slug
     */
    private function enqueue_js(){                                                        
        
        // JavaScript //////////////////////////////////////////////////////////////
        
        $js_script = '';
        
        /*
        //Show|Hide grayed section      
        $js_script .= " 
                        if ( ! jQuery('#bresources_booking_gcal_auto_import_is_active').is(':checked') ) {   
                            jQuery('.wpbc_tr_auto_import').addClass('hidden_items'); 
                        }
                      ";        
        // Hide|Show  on Click      Checkbox
        $js_script .= " jQuery('#bresources_booking_gcal_auto_import_is_active').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_tr_auto_import').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_tr_auto_import').addClass('hidden_items');
                                }
                            } ); ";                     
        // Hide|Show  on Click      Radion
        $js_script .= " jQuery('input[name=\"paypal_pro_hosted_solution\"]').on( 'change', function(){    
                                jQuery('.wpbc_sub_settings_paypal_account_type').addClass('hidden_items'); 
                                if ( jQuery('#paypal_type_standard').is(':checked') ) {   
                                    jQuery('.wpbc_sub_settings_paypal_standard').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_sub_settings_paypal_pro_hosted').removeClass('hidden_items');
                                }
                            } ); ";        
        */
        ////////////////////////////////////////////////////////////////////////
        
        
        // Eneque JS to  the footer of the page
        wpbc_enqueue_js( $js_script );                
    }

    // </editor-fold>
    
    
    ////////////////////////////////////////////////////////////////////////////
    // Toolbar
    ////////////////////////////////////////////////////////////////////////////
    
    /** Show Toolbar  - Add new booking resources */
    private function toolbar() {
        
        wpbc_add_new_booking_resource_toolbar();        
    }
    
    ////////////////////////////////////////////////////////////////////////////
    //   B o o k i n g      R e s o u r c e s      T a b l e 
    ////////////////////////////////////////////////////////////////////////////
    
    /** Show booking resources table */
    public function wpbc_resources_table__show() {    
        // echo ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() . '<div class="clear" style="height:20px;"></div>' : '' );
        
        $columns = array();
        $columns[ 'check' ] = array( 'title' => '<input type="checkbox" value="" id="br-select-all" name="resource_id_all" />'
                                        , 'class' => 'check-column' 
                                    );
        $columns[ 'id' ] = array(         'title' => __( 'ID' )
                                        , 'style' => 'width:5em;'
                                        , 'class' => 'wpbc_hide_mobile'
                                        , 'sortable' => true 
                                    );
        
        $columns = apply_filters ('wpbc_resources_table_header__cost_title' , $columns );
        
        $columns[ 'title' ] = array(      'title' => __( 'Resource Name', 'booking' )
                                        , 'style' => ''
                                        , 'sortable' => true 
                                    );
                
        $columns = apply_filters ('wpbc_resources_table_header__customform_title' , $columns );        
        $columns = apply_filters ('wpbc_resources_table_header__parentchild_title' , $columns );        
        $columns = apply_filters ('wpbc_resources_table_header__info_title' , $columns );        
                                                        
        $columns = apply_filters ('wpbc_resources_table_header__user_title' , $columns );        
        
        $wpbc_br_table = new WPBC_BR_Table( 
                            'resources' 
                            , array(
                                  'url_sufix'   =>  '#wpbc_resources_link'
                                , 'rows_func'   =>  array( $this, 'wpbc_resources_table__show_rows' ) 
                                , 'columns'     =>  $columns
                                , 'is_show_pseudo_search_form' => false
                            )
                        );

        $wpbc_br_table->display();             
    }   
    

    /** Show rows for booking resource table
     * 
     * @param int $row_num
     * @param array $resource
     */
    public function wpbc_resources_table__show_rows( $row_num, $resource ) {

        $css_class = ' wpbc_resource_row';
        if ( class_exists( 'wpdev_bk_biz_l' ) ) {

                if ( intval($resource['count'] ) > 1 ) {  
                    $css_class .= ' wpbc_resource_parent wpbc_resource_capacity' . $resource['count'] ;
                } else {

                    if ( empty( $resource['parent'] ) ) {
                        $css_class .= ' wpbc_resource_single';
                    } else {
                        $css_class .= ' wpbc_resource_child';
                    }
                }
        }
                
        ?><tr class="wpbc_row<?php echo $css_class; ?>" id="resource_<?php echo $resource['id']; ?>"><?php

                    ?><th class="check-column">
                            <label class="screen-reader-text" for="br-select-<?php echo $resource['id' ]; ?>"><?php echo esc_js(__('Select Booking Resource', 'booking')); ?></label>
                            <input type="checkbox" 
                                           id="br-select-<?php echo $resource['id' ]; ?>" 
                                           name="br-select-<?php echo $resource['id' ]; ?>" 
                                           value="resource_<?php echo $resource['id' ]; ?>" 
                                />       
                    </th>
                    <td class="wpbc_hide_mobile"><?php echo $resource['id' ]; ?></td>
                    <?php do_action( 'wpbc_resources_table_show_col__cost_field', $row_num, $resource ); ?>
                    <td>
                        <input type="text" 
                               value="<?php echo esc_attr( $resource['title'] ); ?>" 
                               id="booking_resource_<?php echo $resource['id' ]; ?>" 
                               name="booking_resource_<?php echo $resource['id' ]; ?>" 
                               class="large-text" 
                               style="float:right;<?php  
                                    if ( ! empty( $resource['parent']) ) {
                                       echo 'width:95%;font-weight:400;';
                                    } else {
                                      echo 'width:100%;font-weight:600;';
                                    }
                                    ?>" 
                        />
                    </td>
                    <?php do_action( 'wpbc_resources_table_show_col__customform_field',  $row_num, $resource ); ?>
                    <?php do_action( 'wpbc_resources_table_show_col__parentchild_field',  $row_num, $resource ); ?>
                    <?php do_action( 'wpbc_resources_table_show_col__info_text',    $row_num, $resource ); ?>                    
                    <?php do_action( 'wpbc_resources_table_show_col__user_field',         $row_num, $resource ); ?>
        </tr>
        <?php    
    }

}
add_action('wpbc_menu_created', array( new WPBC_Page_Settings__bresources() , '__construct') );    // Executed after creation of Menu


/** Validate some fields during saving to DB
 *  Skip  saving some pseudo  options,  instead of that  creare new real  option.
 * 
 * @param array $validated_fields
 * @return type
 */
function wpbc_fields_before_saving_to_db__bresources( $validated_fields ) {
    
    /*
    // Set  new option based on pseudo  options
    $validated_fields['booking_gcal_events_form_fields'] = array( 'Tada' );
    // Unset  several pseudo options.
    unset( $validated_fields['booking_gcal_events_form_fields_title'] );
    */
    
    return $validated_fields;
}
add_filter('wpbc_fields_before_saving_to_db__bresources', 'wpbc_fields_before_saving_to_db__bresources');
