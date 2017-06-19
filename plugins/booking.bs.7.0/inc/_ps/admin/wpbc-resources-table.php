<?php
/**
 * @version 1.0
 * @package Caching Booking Resources
 * @category Cache
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-08-09
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/** Booking Resources  Table for Settings page */
class WPBC_BR_Table extends WPBC_Settings_Table {
    
    
    public function __construct( $id, $args = array() ) {
        
        parent::__construct( $id, $args );
        
        add_action('wpbc_before_showing_settings_table', array( $this, 'wpbc_toolbar_search_by_id_booking_resources_pseudo' ) );        
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    // Data
    ////////////////////////////////////////////////////////////////////////////
    
    /** Load Data for showing in Table
     * 
     * @return array
     */
    public function load_data(){
        
        return wpbc_br_cache();
    }
    
    
    /** Get sorted part of booking resources array for ONE Page
     * 
     * @return array
     */
    public function get_linear_data_for_one_page() {
                
        // Get sorted part of booking resources array based on $_GET paramters, like: &orderby=id&order=asc&page_num=2
        $resources = $this->loaded_data->get_resources_for_one_page();
        
        return $resources;
    }

    
    /** Get Actual sorting parameter
     *  based on version and $_GET['orderby'] & $_GET['order'] params
     * 
     * @return array( 'orderby' => 'id', 'order' => 'desc' )     ||     array('orderby' => 'title', 'order' => 'asc' ) .... 
     */    
    public function get_sorting_params() {
        $active_sort = $this->loaded_data->get_sorting_params();                // array( 'orderby' => 'id', 'order' => 'asc');
        return $active_sort;
    }
    
    
    /** Get ONLY the paramters that  possible to  use in pagination buttons
     * 
     * @return array( 'page', 'tab', 'wh_resource_id' );
     */
    public function gate_paramters_for_pagination(){
        return array( 'page', 'tab', 'wh_resource_id' );
    }
    
    
    /** Show Footer Row */
    public function show_footer(){
        
        // Footer
        ?><th colspan="<?php echo count( $this->get_columns() ); ?>" style="text-align: center;"><?php 

            // Pagination 


            $pagination_param = $this->loaded_data->get_pagination_params();        // array( 'selected_page_num' => 2, 'items_per_page' => 10, 'start' => 10, 'end' => 19 );

            $summ_number_of_items   = count( $this->loaded_data->get_single_parent_resources() );
            $active_page_num        = $pagination_param['selected_page_num']; 
            $num_items_per_page     = $pagination_param['items_per_page'];
            $only_these_parameters  = array( 'page', 'tab', 'wh_resource_id', 'orderby', 'order');

            wpbc_show_pagination(  $summ_number_of_items, $active_page_num, $num_items_per_page , $only_these_parameters, $this->url_sufix );

        ?></th><?php
        
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    // Support
    ////////////////////////////////////////////////////////////////////////////
    
    
    /** Pseudo search form above resource table and submit real form at  top of page 
     * Its means that  we need to  show real  form:
     * 
        wpbc_toolbar_search_by_id__top_form( array( 
                                                    'search_form_id' => 'wpbc_booking_resources_search_form'
                                                  , 'search_get_key' => 'wh_resource_id'
                                                  , 'is_pseudo'      => false
                                            ) );
     * 
     * at  the top  of page - 
     * BEFORE SHOWING FORM  OF SAVING BOOKING RESOURCES - FOR HAVING 2 SEPAEATE HTML FORMS
     */
    public function wpbc_toolbar_search_by_id_booking_resources_pseudo( $id ) {

        if ( $this->id != $id ) return;

        if ( ! empty( $this->parameters['is_show_pseudo_search_form'] ) ) {

            wpbc_toolbar_search_by_id__top_form( array( 
                                                    'search_form_id' => 'wpbc_booking_resources_search_form'
                                                  , 'search_get_key' => 'wh_resource_id'
                                                  , 'is_pseudo'      => true
                                            ) );
        }        
                      
    }
}
