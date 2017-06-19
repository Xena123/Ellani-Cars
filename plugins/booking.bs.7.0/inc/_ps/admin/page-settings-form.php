<?php
/**
 * @version     1.0
 * @package     Booking > Settings > Fields page - Saving booking form
 * @category    Settings API
 * @author      wpdevelop
 *
 * @web-site    http://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-04-15
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
class WPBC_Page_SettingsFormFields extends WPBC_Page_Structure {
    
    public function in_page() {
        return 'wpbc-settings';
    }
    
    
    public function tabs() {
        
        $tabs = array();
                
        $tabs[ 'form' ] = array(
                              'title'     => __( 'Form', 'booking')             // Title of TAB    
                            , 'page_title'=> __( 'Fields Settings', 'booking')      // Title of Page    
                            , 'hint'      => __( 'Customizaton of Form Fields', 'booking')               // Hint    
                            //, 'link'      => ''                                 // Can be skiped,  then generated link based on Page and Tab tags. Or can  be extenral link
                            //, 'position'  => ''                                 // 'left'  ||  'right'  ||  ''
                            //, 'css_classes'=> ''                                // CSS class(es)
                            //, 'icon'      => ''                                 // Icon - link to the real PNG img
                            , 'font_icon' => 'glyphicon glyphicon-edit'         // CSS definition  of forn Icon
                            //, 'default'   => false                               // Is this tab activated by default or not: true || false. 
                            //, 'disabled'  => false                              // Is this tab disbaled: true || false. 
                            //, 'hided'     => false                              // Is this tab hided: true || false. 
                            , 'subtabs'   => array()   
                    );
        
        return $tabs;
    }

    
    public function content() {
        
        $this->css();

        ////////////////////////////////////////////////////////////////////////
        // Checking ////////////////////////////////////////////////////////////
        
        do_action( 'wpbc_hook_settings_page_header', 'form_field_settings');       // Define Notices Section and show some static messages, if needed
        
        if ( ! wpbc_is_mu_user_can_be_here('activated_user') ) return false;    // Check if MU user activated, otherwise show Warning message.
   
        // if ( ! wpbc_is_mu_user_can_be_here('only_super_admin') ) return false;  // User is not Super admin, so exit.  Basically its was already checked at the bottom of the PHP file, just in case.
        
        
        //////////////////////////////////////////////////////////////////////// 
        // Submit  /////////////////////////////////////////////////////////////
        
        $submit_form_name = 'wpbc_form_field';                             // Define form name
                
        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name  );  // Its stop show anything on submiting, if its not refear to the original page

            // Save Changes 
            $this->update();
        }                

        ////////////////////////////////////////////////////////////////////////
        // Get Data from DB ////////////////////////////////////////////////////                
        $booking_form       =  get_bk_option( 'booking_form' );
        $booking_form_show  =  get_bk_option( 'booking_form_show' );
         
        $is_can = apply_bk_filter('multiuser_is_user_can_be_here', true, 'only_super_admin');
        if ( ( isset($_GET['booking_form']) ) && ( ($is_can) || (WP_BK_CUSTOM_FORMS_FOR_REGULAR_USERS) ) ) {
            $my_booking_form_name = $_GET['booking_form'];
            $booking_form       = apply_bk_filter('wpdev_get_booking_form',         $booking_form,      $my_booking_form_name);
            $booking_form_show  = apply_bk_filter('wpdev_get_booking_form_content', $booking_form_show, $my_booking_form_name);
        }
        //$booking_form      = wpbc_nl_after_br( $booking_form );
        //$booking_form_show = wpbc_nl_after_br( $booking_form_show );
        
         
        ////////////////////////////////////////////////////////////////////////
        // Toolbar /////////////////////////////////////////////////////////////
        wpbc_bs_toolbar_sub_html_container_start();

        ?><span class="wpdevelop"><div class="visibility_container clearfix-height" style="display:block;"><?php

            wpbc_js_for_bookings_page();                                            // JavaScript functions
        
            if ( function_exists( 'wpbc_toolbar_btn__custom_forms_in_settings_fields' ) ) {
                wpbc_toolbar_btn__custom_forms_in_settings_fields();
            }
            
            $this->toolbar_reset_to_default();                                // Reset to Default Forms
            
            $save_button = array( 'title' => __('Save Changes', 'booking'), 'form' => $submit_form_name );
            $this->toolbar_save_button( $save_button );                         // Save Button 
            
        ?></div></span><?php
        
        wpbc_bs_toolbar_sub_html_container_end();
        
        ?><div class="clear"></div><?php

        // Scroll links ////////////////////////////////////////////////////////
        ?>
        <div class="wpdvlp-sub-tabs" style="background:none;border:none;box-shadow: none;padding:0;"><span class="nav-tabs" style="text-align:right;">
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_settings_form_fields_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php echo ucwords( __('Form fields', 'booking') ); ?></span></a>
            <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_settings_form_fields_show_metabox' );" original-title="" class="nav-tab go-to-link"><span><?php _e('Content of Booking Fields' , 'booking' ); ?></span></a>
        </span></div>
        <?php
        
        ////////////////////////////////////////////////////////////////////////
        // Content  ////////////////////////////////////////////////////////////
        ?>
        <div class="clear" style="margin-bottom:10px;"></div>
        <span class="metabox-holder">
            <form  name="<?php echo $submit_form_name; ?>" id="<?php echo $submit_form_name; ?>" action="" method="post">
                <?php 
                   // N o n c e   field, and key for checking   S u b m i t 
                   wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo $submit_form_name; ?>" id="is_form_sbmitted_<?php echo $submit_form_name; ?>" value="1" /><?php 
                
                ?><input type="hidden" name="reset_to_default_form" id="reset_to_default_form" value="" /><?php 
                     
                ?><div class="wpbc_settings_row wpbc_settings_row_left"><?php
                
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields', __('Form fields', 'booking') );
                    $this->show_booking_form( $booking_form );                    
                    wpbc_close_meta_box_section();
                ?>
                </div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields_generator', __('Generate tag', 'booking') );
                    $this->show_fields_shortcodes_generator( $booking_form );                    
                    wpbc_close_meta_box_section();
                ?>
                </div>
                <div class="clear"></div>
                
                <div class="wpbc_settings_row wpbc_settings_row_left"><?php                
                
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields_show', sprintf(__('Content of booking fields data for email templates (%s-shortcode) and booking listing page' ,'booking'),'[content]')  );                
                    $this->show_content_data_form( $booking_form_show );                
                    wpbc_close_meta_box_section();
                
                ?>
                </div>  
                <div class="wpbc_settings_row wpbc_settings_row_right"><?php                
                
                    wpbc_open_meta_box_section( 'wpbc_settings_form_fields_show_help', __('Help', 'booking') );
                    $this->show_content_data_form_help( $booking_form );                    
                    wpbc_close_meta_box_section();
                ?>
                </div>
                <div class="clear"></div>
                <input type="submit" value="<?php _e('Save Changes','booking'); ?>" class="button button-primary wpbc_submit_button" />  
            </form>
        </span>
        <?php       
    
        do_action( 'wpbc_hook_settings_page_footer', 'form_field_settings' );
    }

    
    /** Save Chanages */  
    public function update() {

        if (
             (
                ( ( isset($_POST['booking_form_new_name'])  )  && (! empty($_POST['booking_form_new_name']) ) )
                ||
                ( ( isset($_GET['booking_form'])  ) && ($_GET['booking_form'] !== 'standard')  )
             )
             /* && ($_POST['select_booking_form'] !== 'standard') /**/
           )
        {
            make_bk_action('wpbc_make_save_custom_booking_form');
        } else {
            
            // We can  not use here such code:
            // WPBC_Settings_API::validate_textarea_post_static( 'booking_form' );
            // becuse its will  remove also JavaScript,  which  possible to  use for wizard form  or in some other cases.
            $booking_form =  trim( stripslashes( $_POST['booking_form'] ) );
            update_bk_option(   'booking_form' , $booking_form );

            $booking_form_show = trim( stripslashes( $_POST['booking_form_show'] ) );
            update_bk_option( 'booking_form_show' , $booking_form_show );
       }
         
        wpbc_show_changes_saved_message();        
    }

        
    // <editor-fold     defaultstate="collapsed"                        desc=" CSS & JS  "  >
    
    /** CSS for this page */
    private function css() {
        ?>
        <style type="text/css">  
            .wpbc-help-message {
                border:none;
            }
            /* toolbar fix */
            .wpdevelop .visibility_container .control-group {
                margin: 0 8px 5px 0;
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
    
    // </editor-fold>
    
    
    // <editor-fold     defaultstate="collapsed"                        desc=" Toolbar "  >
    
    /** Show Save button  in toolbar  for saving form */
    private function toolbar_save_button( $save_button ) {
                
        ?>
        <div class="clear-for-mobile"></div><input 
                                type="button" 
                                class="button button-primary wpbc_submit_button" 
                                value="<?php echo $save_button['title']; ?>" 
                                onclick="if (typeof document.forms['<?php echo $save_button['form']; ?>'] !== 'undefined'){ 
                                            document.forms['<?php echo $save_button['form']; ?>'].submit(); 
                                         } else { 
                                             wpbc_admin_show_message( '<?php echo ' <strong>', __('Error', 'booking') ,'!</strong> ', __('Form', 'booking') , ' <strong>' , $save_button['form'] , '</strong> ', __('does not exist', 'booking'); ?>.', 'error', 10000 ); 
                                         }" 
                                />
        <?php
    }
    
    
    /** Selection  of default Template and Button for Reseting  */
    private function toolbar_reset_to_default() {
        
        
        $templates = array();
        
        $templates['selector_hint'] = array(  
                                                'title' => __('Select', 'booking') . ' ' .  __('Form Template', 'booking')
                                                , 'id' => ''   
                                                , 'name' => ''  
                                                , 'style' => 'font-weight: 400;border-bottom:1px dashed #ccc;'    
                                                , 'class' => ''     
                                                , 'disabled' => false
                                                , 'selected' => false
                                                , 'attr' => array()   
                                            );       
        
        $templates[ 'optgroup_sf_s' ] = array( 
                                                'optgroup' => true
                                                , 'close'  => false
                                                , 'title'  => '&nbsp;' . __('Standard Templates' ,'booking') 
                                            );
        $templates[ 'standard' ] = array(  
                                                'title' => __('Standard', 'booking')
                                                , 'id' => ''   
                                                , 'name' => ''  
                                                , 'style' => ''
                                                , 'class' => ''     
                                                , 'disabled' => false
                                                , 'selected' => false
                                                , 'attr' => array()   
                                            );        
        $templates[ '2collumns' ] = array(  
                                                'title' => '2 ' . __('Columns', 'booking')
                                                , 'id' => ''   
                                                , 'name' => ''  
                                                , 'style' => ''
                                                , 'class' => ''     
                                                , 'disabled' => false
                                                , 'selected' => false
                                                , 'attr' => array()   
                                            );

        if (class_exists('wpdev_bk_biz_s')) {


            $templates['payment'] = array(  
                                                'title' => __('Payment', 'booking')
                                                , 'id' => ''   
                                                , 'name' => ''  
                                                , 'style' => ''
                                                , 'class' => ''     
                                                , 'disabled' => false
                                                , 'selected' => false
                                                , 'attr' => array()   
                                            );
            $templates['times'] = array(  
                                                'title' => __('Time Slots', 'booking')
                                                , 'id' => ''   
                                                , 'name' => ''  
                                                , 'style' => ''
                                                , 'class' => ''     
                                                , 'disabled' => false
                                                , 'selected' => false
                                                , 'attr' => array()   
                                            );
        }
        
        $templates[ 'optgroup_sf_e' ] = array( 'optgroup' => true, 'close'  => true );
                                        
                                        
        $templates[ 'optgroup_af_s' ] = array(  
                                                'optgroup' => true
                                                , 'close'  => false
                                                , 'title'  => '&nbsp;' . __('Advanced Templates' ,'booking') 
                                            );
        $templates[ 'wizard' ] = array(  
                                                'title' => __('Wizard (several steps)', 'booking')
                                                , 'id' => ''   
                                                , 'name' => ''  
                                                , 'style' => ''
                                                , 'class' => ''     
                                                , 'disabled' => false
                                                , 'selected' => false
                                                , 'attr' => array()   
                                            );
        
        if (class_exists('wpdev_bk_biz_m')) {

            $templates['timesweek'] = array(  
                                                                'title' => __('Time slots for different weekdays', 'booking')
                                                                , 'id' => ''   
                                                                , 'name' => ''  
                                                                , 'style' => ''
                                                                , 'class' => ''     
                                                                , 'disabled' => false
                                                                , 'selected' => false
                                                                , 'attr' => array()   
                                                            );
            $templates['hints'] = array(  
                                                                'title' => __('Hints', 'booking')
                                                                , 'id' => ''   
                                                                , 'name' => ''  
                                                                , 'style' => ''
                                                                , 'class' => ''     
                                                                , 'disabled' => false
                                                                , 'selected' => false
                                                                , 'attr' => array()   
                                                            );
        }
        
        $templates[ 'optgroup_af_e' ] = array( 'optgroup' => true, 'close'  => true );
                                                   
                                                                
        $params = array(  
                          'label_for' => 'select_form_help_shortcode'           // "For" parameter  of label element
                        , 'label' => '' //__('Add New Field', 'booking')        // Label above the input group
                        , 'style' => ''                                         // CSS Style of entire div element
                        , 'items' => array(
                                array(      
                                    'type' => 'addon' 
                                    , 'element' => 'text'           // text | radio | checkbox
                                    , 'text' => __('Reset Form', 'booking') . ':'
                                    , 'class' => ''                 // Any CSS class here
                                    , 'style' => 'font-weight:600;' // CSS Style of entire div element
                                )  
                                // Warning! Can be text or selectbox, not both  OR you need to define width                     
                                , array(                                            
                                      'type' => 'select'                              
                                    , 'id' => 'select_default_form_template'  
                                    , 'name' => 'select_default_form_template'  
                                    , 'style' => ''                            
                                    , 'class' => ''   
                                    , 'multiple' => false
                                    , 'disabled' => false
                                    , 'disabled_options' => array()             // If some options disbaled,  then its must list  here                                
                                    , 'attr' => array()                         // Any  additional attributes, if this radio | checkbox element                                                   
                                    , 'options' => $templates                   // Associated array  of titles and values                                                       
                                    , 'value' => ''                             // Some Value from optins array that selected by default                                                                              
                                    , 'onfocus' => ''
                                    //, 'onchange' => "wpbc_show_fields_generator( this.options[this.selectedIndex].value );"
                                )              
                        )
                    );

            
            
            
        ?><div class="control-group wpbc-no-padding"><?php 
                wpbc_bs_input_group( $params );                   
        ?></div><?php
        
        
        $params = array(  
                      'label_for' => 'min_cost'                             // "For" parameter  of label element
                    , 'label' => '' //__('Add New Field', 'booking')        // Label above the input group
                    , 'style' => ''                                         // CSS Style of entire div element
                    , 'items' => array(     
                                        array( 
                                            'type' => 'button'
                                            , 'title' => __('Reset', 'booking')  // __('Reset', 'booking')
                                            , 'hint' => array( 'title' => __('Reset current Form' ,'booking') , 'position' => 'top' )
                                            , 'class' => 'button tooltip_top' 
                                            , 'font_icon' => 'glyphicon glyphicon-repeat'
                                            , 'icon_position' => 'right'
                                            , 'action' => " var sel_res_val = document.getElementById('select_default_form_template').options[ document.getElementById('select_default_form_template').selectedIndex ].value;"
                                                        . " if   ( sel_res_val == 'selector_hint') { "
                                                        . "    wpbc_field_highlight( '#select_default_form_template' ); return;"          //. "  jQuery('#wpbc_form_field').submit();"
                                                        . " }"  
                                                        //. " if ( wpbc_are_you_sure('" . esc_js(__('Do you really want to do this ?' ,'booking')) . "') ) {"
                                                        . "    reset_to_def_from( sel_res_val ); "          //. "  jQuery('#wpbc_form_field').submit();"
                                                        //. " }"  
                                        )                            
                                        , array( 
                                            'type' => 'button'
                                            , 'title' => __('Both', 'booking')  // __('Reset', 'booking')
                                            , 'hint' => array( 'title' => __('Reset Booking Form and Content of Booking Fields Form' ,'booking') , 'position' => 'top' )
                                            , 'class' => 'button tooltip_top' 
                                            , 'font_icon' => 'glyphicon glyphicon-refresh'
                                            , 'icon_position' => 'right'
                                            , 'action' => " var sel_res_val = document.getElementById('select_default_form_template').options[ document.getElementById('select_default_form_template').selectedIndex ].value;"
                                                        . " if   ( sel_res_val == 'selector_hint') { "
                                                        . "    wpbc_field_highlight( '#select_default_form_template' ); return;"          //. "  jQuery('#wpbc_form_field').submit();"
                                                        . " }"  
                                                        //. " if ( wpbc_are_you_sure('" . esc_js(__('Do you really want to do this ?' ,'booking')) . "') ) {"
                                                        . "    reset_to_def_from( sel_res_val ); "
                                                        . "    reset_to_def_from_show( sel_res_val ); "     //. "  jQuery('#wpbc_form_field').submit();"
                                                        //. " }"  
                                        )                            
                            )
                    );

        ?><div class="control-group wpbc-no-padding"><?php 
                wpbc_bs_input_group( $params );                   
        ?></div><?php
        
    }    
    
    // </editor-fold>
    
    
    // <editor-fold     defaultstate="collapsed"                        desc=" C O N T E N T   F o r m s "  >

    
    /** Show Booking Form  - in Settings page */
    private function show_booking_form( $booking_form ) {
        
        wp_editor( $booking_form, 
           'booking_form',  
           array(
                 'wpautop'       => false
               , 'media_buttons' => false
               , 'textarea_name' => 'booking_form'
               , 'textarea_rows' => 27
               , 'tinymce' => false                                 // Remove Visual Mode from the Editor        
               , 'editor_class'  => 'wpbc-textarea-tinymce'         // Any extra CSS Classes to append to the Editor textarea 
               , 'teeny' => true                                    // Whether to output the minimal editor configuration used in PressThis 
               , 'drag_drop_upload' => false                        // Enable Drag & Drop Upload Support (since WordPress 3.9) 
               )
         );                     
        //echo '<textarea id="booking_form" name="booking_form" class="darker-border" style="width:100%;" rows="33">' . htmlspecialchars($booking_form, ENT_NOQUOTES ) . '</textarea>';
        ?><div class="clear"></div><?php
    }
    
    
    /** Show Content Fields Data Form  - in Settings page */
    private function show_content_data_form( $booking_form_show ) {
        
        wp_editor( $booking_form_show, 
           'booking_form_show',  
           array(
                 'wpautop'       => false
               , 'media_buttons' => false
               , 'textarea_name' => 'booking_form_show'
               , 'textarea_rows' => 9
               , 'tinymce' => false         // Remove Visual Mode from the Editor        
               // , 'default_editor' => 'html'
               , 'editor_class'  => 'wpbc-textarea-tinymce'      // Any extra CSS Classes to append to the Editor textarea 
               , 'teeny' => true            // Whether to output the minimal editor configuration used in PressThis 
               , 'drag_drop_upload' => false //Enable Drag & Drop Upload Support (since WordPress 3.9) 
               )
        ); 
        
        //echo '<textarea id="booking_form_show" name="booking_form_show" class="darker-border" style="width:100%;" rows="12">' . htmlspecialchars($booking_form_show, ENT_NOQUOTES ) . '</textarea>';
    }

    
    /** Show Shortcode Fields Generator for Booking Form  - in Settings page */
    private function show_fields_shortcodes_generator( $booking_form ) {
        
        if ( class_exists('WPBC_Form_Help') ) {

            $default_Form_Help = new WPBC_Form_Help( array(
                                                        'id'=>'booking_form',
                                                        'version'=> get_bk_version()
                                                        )
                                                   );
            $default_Form_Help->show();               
        }  
        
        ?><div class="clear"></div><?php
    }
    
    
    /** Show Help section for Content Fields Data Form  - in Settings page */
    private function show_content_data_form_help( $param ) {
        
        ?>
        <div  class="wpbc-help-message">
            <span class="description"><strong><?php printf(__('Use these shortcodes for customization: ' ,'booking'));?></strong></span><br/><br/>
            <span class="description"><?php printf(__('%s - inserting data from fields of booking form' ,'booking'),'<code>[field_name]</code>');?></span><br/>
            <span class="description"><?php printf(__('%s - inserting new line' ,'booking'),'<code>&lt;br/&gt;</code>');?></span><br/>
            <span class="description">
                <?php
                echo '<strong>' . __('HTML' ,'booking') . '.</strong> ' 
                     . sprintf(__('You can use any %sHTML tags%s in the booking form. Please use the HTML tags carefully. Be sure, that all "open" tags (like %s) are closed (like this %s).' ,'booking')
                                   ,'<strong>','</strong>'
                                   ,'<code>&lt;div&gt;</code>'
                                   ,'<code>&lt;/div&gt;</code>'
                                );
                ?>
            </span>
        </div>        
        <?php 
        //echo '<hr />';    
        
    }
    
    // </editor-fold>
    
}
add_action('wpbc_menu_created', array( new WPBC_Page_SettingsFormFields() , '__construct') );    // Executed after creation of Menu