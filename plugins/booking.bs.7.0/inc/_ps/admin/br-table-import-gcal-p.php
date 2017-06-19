<?php
/**
 * @version     1.0
 * @package     Booking > Settings > Import page
 * @category    Settings API
 * @author      wpdevelop
 *
 * @web-site    http://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-08-07
 * 
 * This is COMMERCIAL SCRIPT
 * We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

/** Show rows for booking resource table
 * 
 * @param int $row_num
 * @param array $resource
 */
function wpbc_import_gcal__show_rows( $row_num, $resource ) {
//debuge($resource);        

    ?><tr class="wpbc_row" id="resource_<?php echo $resource['id']; ?>"><?php
            
                ?><th class="check-column wpbc_hide_mobile">
                        <label class="screen-reader-text" for="br-select-<?php echo $resource['id' ]; ?>"><?php echo esc_js(__('Select Booking Resource', 'booking')); ?></label>
                        <input type="checkbox" 
                                       id="br-select-<?php echo $resource['id' ]; ?>" 
                                       name="br-select-<?php echo $resource['id' ]; ?>" 
                                       value="resource_<?php echo $resource['id' ]; ?>" 
                            />       
                </th>
                <td><?php echo $resource['id' ]; ?></td>
                <td>
                <?php 
                        if ( ! empty( $resource['parent']) ) {
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            echo  esc_js( $resource['title'] );
                        } else {
                            echo  '<strong>' . esc_js( $resource['title'] ) . '</strong>';
                        }
                ?>
                </td>
                <td style="text-align:center;">
                    <input type="text" 
                           value="<?php echo $resource['import' ]; ?>" 
                           id="booking_gcal_feed<?php echo $resource['id' ]; ?>" 
                           name="booking_gcal_feed<?php echo $resource['id' ]; ?>" 
                           class="large-text" 
                           style="width:100%;" 
                    />
                </td>
                <?php if ( class_exists( 'wpdev_bk_biz_l' ) ) { ?>
                <td style="text-align:center;" class="wpbc_hide_mobile"><?php 
                        
                        if ( $resource['count'] > 1 ) {
                            ?> <span class="label label-default label-warning"><?php 

                                echo __('Capacity' ,'booking'), ': ', intval( $resource['count'] ); 

                            ?></span><?php                                    
                        }
                    
                        if ( class_exists( 'wpdev_bk_multiuser' ) ) {
                            ?> <span class="label label-default label-info"><?php 

                                $us_data = get_userdata( $resource['users'] );

                                echo __('User' ,'booking'), ': ', esc_js( $us_data->display_name ); 

                            ?></span><?php
                        }
                        
                ?></td><?php                 
                } 
                ?>            
    </tr>
    <?php    
}


/** Save "Google Calendar ID" for booking resources */
function wpbc_import_gcal__update() {
// debuge($_POST);
    if (  ( wpbc_is_this_demo() ) ||  ( ! class_exists( 'wpdev_bk_personal' ) )  )
        return;
    
    global $wpdb;
    
    $wpbc_br_table = new WPBC_BR_Table( 'resources_submit' );
    $linear_resources_for_one_page = $wpbc_br_table->get_linear_data_for_one_page();
    
    foreach ( $linear_resources_for_one_page as $resource_id => $resource ) {
        
        // Check posts of only visible on page booking resources 
        if ( isset( $_POST['booking_gcal_feed' . $resource_id ] ) ) {
            
            // Validate POST value
            $validated_value = WPBC_Settings_API::validate_text_post_static( 'booking_gcal_feed' . $resource_id );
            
            // Check  if its different from  original value in DB
            if ( $validated_value != $resource['import'] ) {

                // Save to DB    
                if ( false === $wpdb->query( 
                        $wpdb->prepare( 
                                        "UPDATE {$wpdb->prefix}bookingtypes SET import = %s WHERE booking_type_id = %d "  
                                        , $validated_value
                                        , intval($resource_id) )                                        
                                    )  
                    ){ debuge_error( 'Error saving to DB' ,__FILE__ , __LINE__); }
                
            }
        }
        
    }
    
    make_bk_action( 'wpbc_reinit_booking_resource_cache' );
}


/** Show booking resources table - Import - Google Calendar ID */
function wpbc_import_gcal__show_table() {
    
    echo ( ( wpbc_is_this_demo() ) ? wpbc_get_warning_text_in_demo_mode() . '<div class="clear" style="height:20px;"></div>' : '' );
    
    $wpbc_br_table = new WPBC_BR_Table( 
                        'resources' 
                        , array(
                              'url_sufix'   =>  '#wpbc_resources_link'
                            , 'rows_func'   =>  'wpbc_import_gcal__show_rows'
                            , 'columns'     =>  array(
                                                    'check' => array( 'title' => '<input type="checkbox" value="" id="br-select-all" name="resource_id_all" />'
                                                                    , 'class' => 'check-column wpbc_hide_mobile' 
                                                                )
                                                    , 'id' => array(  'title' => __( 'ID' )
                                                                    , 'style' => 'width:5em;'
                                                                    , 'sortable' => true 
                                                                )
                                                    , 'title' => array(   'title' => __( 'Resources' )
                                                                        , 'style' => 'width:20em;'
                                                                        , 'sortable' => true 
                                                                    )
                                                    , 'gcalid' => array(  'title' => __( 'Google Calendar ID' )
                                                                        , 'style' => 'text-align:center;' 
                                                                    )
                                                    , 'info' => array(    'title' => __( 'Info' )
                                                                        , 'class' => 'wpbc_hide_mobile'
                                                                        , 'style' => 'width:15em;text-align:center;' 
                                                                    )
                                            )
                        )
                    );

    $wpbc_br_table->display();        
}


/** Show Selectbox for selecting booking resources as TR for TABLE */
function wpbc_gcal_settings_content_field_selection_booking_resources() {

    $resources_cache = wpbc_br_cache();                                         // Get booking resources from  cache        
    $resource_list = $resources_cache->get_resources();
    ?>
    <tr valign="top">
        <th scope="row"><label for="wpbc_booking_resource"><?php _e( 'Booking resource', 'booking' ); ?>:</label></th>
        <td>                        
            <select id="wpbc_booking_resource" name="wpbc_booking_resource">
                <option value="all" style="font-weight:600;border-bottom:1px solid #ccc;padding:5px;" ><?php _e( 'All', 'booking' ); ?></option>
                <?php foreach ( $resource_list as $resource ) { ?>
                <option value="<?php echo $resource['id']; ?>"
                                style="<?php if ( isset( $resource['parent'] ) ) if ( $resource['parent'] == 0 ) {
                                            echo 'padding:3px;font-weight:600;';
                                        } else {
                                            echo 'padding:3px;font-size:11px;padding-left:20px;';
                                        } ?>"
                    ><?php echo $resource['title']; ?></option>
                <?php } ?>
            </select>
          <span class="description"><?php _e( 'Select booking resource', 'booking' ); ?></span>
        </td>
    </tr>
    <?php
}