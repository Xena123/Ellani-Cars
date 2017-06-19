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


/** Cache booking resources  */
class WPBC_BR_Cache {

    
    static public $booking_resources = array();         // Sorted one dimention linear array of booking resources 
            
    private $single_or_parent = array();
    private $child = array();
    
    static private $instance = NULL;        

    
    public function __construct() {

        $is_exist_resources = $this->wpbc_reinit_booking_resource_cache();
        if ( $is_exist_resources )
            if ( ! defined( 'WPBC_RESOURCES_CACHE' ) )    
                    define( 'WPBC_RESOURCES_CACHE', true );
        
        add_bk_action( 'wpbc_reinit_booking_resource_cache', array( $this, 'wpbc_reinit_booking_resource_cache' ) );
        
    }
    
    
    /** Need to  reinit booking resources cache,  because of saving new data to DataBase, or for any  other reason */
    public function wpbc_reinit_booking_resource_cache() {
        
        // Sorted All resources from DB
        $resources_from_db = $this->get_booking_resources_from_db();

        if ( $resources_from_db !== false ) {
            
            self::$booking_resources = $resources_from_db['linear_resources'];
            $this->single_or_parent  = $resources_from_db['single_or_parent'];
            $this->child             = $resources_from_db['child'];
            
            return true;
        } else {
            return false;
        }        
    }
    
    
    /** Get Single Instance of this Class and Init Plugin */
    public static function init() {

    
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPBC_BR_Cache ) ) {
            
            self::$instance = new WPBC_BR_Cache;
        }
        
        return self::$instance;
        
    }
    
    
    /** Get All booking resources from  DB
     * 
     * @global obj $wpdb
     * @return array of booking resources or false
     */
    private function get_booking_resources_from_db () {
        
        global $wpdb;
        
        $wpbc_sql = "SELECT * FROM {$wpdb->prefix}bookingtypes as bt";          

        $where = '';
        $where = apply_bk_filter( 'multiuser_modify_SQL_for_current_user', $where );  // MultiUser - only specific booking resources for specific Regular User in Admin panel.
        if ( $where != '' )
            $where = ' WHERE ' . $where;
        
//TODO: during searching child booking resources, system  does not show it. 
//      Because we do not have parent resource, and during linear showing 
//      booking resources in table its does notshowing.      
//      
        // if Searching ...
        if ( isset( $_REQUEST['wh_resource_id'] ) ) {
          
            //Escape digit or CSD
            $esc_sql_where_id = wpbc_clean_digit_or_csd( $_REQUEST['wh_resource_id'] );
            
            // Escape SQL string
            $esc_sql_where_title = wpbc_clean_like_string_for_db( $_REQUEST['wh_resource_id'] );
            
            
            $where_search_resource_id = '';
            
            if ( ! empty( $esc_sql_where_id ) )
                $where_search_resource_id .=    " ( bt.booking_type_id IN (" . $esc_sql_where_id . ") ) ";

            if ( ! empty( $esc_sql_where_title ) ) {
                
                if ( ! empty( $where_search_resource_id ) ){ 
                    $where_search_resource_id .= " OR ";
                }                
                    $where_search_resource_id .= " ( bt.title LIKE '%" . $esc_sql_where_title . "%' ) ";
            }
            
            
            if ( ! empty( $where_search_resource_id ) ) {
                
                if ( $where == '' )
                    $where .= ' WHERE ';
                else
                    $where .= ' AND ';

                $where .= " ( " . $where_search_resource_id . " ) ";
            }
        }

        $wpbc_sql .= $where;
        
            // Get Sorting /////////////////////////////////////////////////////
            $order = $this->get_sorting_params();

            // Exceptions //////////////////////////////////////////////////////
            if ( $order['orderby'] == 'id' )    $order['orderby'] = 'booking_type_id';

            if ( $order['orderby'] == 'cost' )  $order['orderby'] = 'CAST(cost AS decimal)';    // We are having cost as varchar  so  need to trasnform  it to numeric. This operation is SLOW so  do not sort booking resources by  cost in usual  way.
            ////////////////////////////////////////////////////////////////////
            
            $sql_order = ' ORDER BY ' . $order['orderby'] ;
            if ( strtolower( $order['order'] ) == 'asc' )   
                $sql_order .= ' ASC';
            else                            
                $sql_order .= ' DESC';

            $wpbc_sql .= $sql_order;
            ////////////////////////////////////////////////////////////////////
        
//debuge($wpbc_sql);            
        $all_resources = $wpdb->get_results( $wpbc_sql );
//debuge($all_resources);        
                        
        if ( count( $all_resources ) > 0 ) {
            
            $resources               = array();
            $child_resources         = array();
            $parent_single_resources = array();
            
            foreach ( $all_resources as $single_resources ) {
                
                $single_resources       = get_object_vars( $single_resources );
                $single_resources['id'] = $single_resources['booking_type_id'];
                
                // Child booking resource
                if ( ! empty( $single_resources['parent'] ) ) {                 // Child
                    
                    if ( ! isset( $child_resources[ $single_resources['parent'] ] ) )
                        $child_resources[ $single_resources['parent'] ] = array();
                    
                    $child_resources[ $single_resources['parent'] ][ $single_resources['id'] ] =  $single_resources;
                    
                } else {                                                        // Parent or Single
                    
                    $parent_single_resources[ $single_resources['id'] ] = $single_resources;                    
                }
                                                                                // All resources
                $resources[ $single_resources['id'] ] = $single_resources;
            }
            
            
            $final_resource_array = array();
            foreach ( $parent_single_resources as $key => $res) {
                
                // Calc Capacity
                if ( isset( $child_resources[$res['id']] ) )    $res['count'] = count( $child_resources[$res['id']] ) + 1;
                else                                            $res['count'] = 1;

                // Fill the parent resource
                $final_resource_array[ $res['id'] ] = $res;

                // Fill all child resources (its already sorted) - for having linear array with child resourecs.
                if ( isset( $child_resources[ $res['id'] ] ) ) {
                    foreach ( $child_resources[ $res['id'] ] as $child_obj ) {
                        $child_obj['count'] = 1;
                        $final_resource_array[ $child_obj['id'] ] = $child_obj;
                    }
                }
            }
            
            return array(
                              'linear_resources' => $final_resource_array
                            , 'single_or_parent' => $parent_single_resources
                            , 'child'            => $child_resources
                        );
        } else {
            return false;
        }        
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    // Get
    ////////////////////////////////////////////////////////////////////////////
    
    /** Get sorted part  of booking resources array 
     * based on $_GET paramters,  like: &orderby=id&order=asc&page_num=2
     * 
     * @return array
                    Example: array (
                                    [1] => Array (
                                                    [booking_type_id] => 1
                                                    [title] => Default
                                                    [users] => 1
                                                    [import] => 
                                                    [cost] => 25
                                                    [default_form] => standard
                                                    [prioritet] => 0
                                                    [parent] => 0
                                                    [visitors] => 1
                                                    [id] => 1
                                    ), 
                                    [5] => Array (
                                                    [booking_type_id] => 5
                                                    [title] => Default-1
                                                    [users] => 1
                                                    [import] => 
                                                    [cost] => 25
                                                    [default_form] => standard
                                                    [prioritet] => 1
                                                    [parent] => 1
                                                    [visitors] => 1
                                                    [id] => 5
                                    ), ...
     */
    public function get_resources_for_one_page() {
     
        $pagination = $this->get_pagination_params();
        
        // We need to  skip "child booking resources" for calculation number of items per page
        $part_single_or_parent = array_slice( $this->single_or_parent, $pagination['start'], $pagination['items_per_page'] );
        $child_resources = $this->child;
        
        $return_array = array();
        foreach ( $part_single_or_parent as $res ) {
            
            // Calc Capacity
            if ( isset( $child_resources[$res['id']] ) )    $res['count'] = count( $child_resources[$res['id']] ) + 1;
            else                                            $res['count'] = 1;
            
            $return_array[ $res['id'] ] = $res;                                 // Single or parent    
            
            if ( isset( $child_resources[ $res['id'] ] ) ) {                    // Child resources
                foreach ( $child_resources[ $res['id'] ] as $child_obj ) {
                    $child_obj['count'] = 1;
                    $return_array[ $child_obj['id'] ] = $child_obj;
                }
            }
        }
        
        return $return_array;
    }
    
    
    /** Get all booking resources - sorted one dimention linear array of booking resources 
     * 
     * @return array
     */
    public function get_resources() {
        
        return self::$booking_resources;
    }

    public function get_single_parent_resources() {
        return $this->single_or_parent;
    }
    
    public function get_children_resources() {
        return $this->child;
    }
    
    /** Get Parameter of specific booking resource
     * 
     * @param int $resource_id
     * @param string $parameter - name of parameter  to  get: {                 [id] => 1
                                                                                [booking_type_id] => 1
                                                                                [title] => Default
                                                                                [users] => 1
                                                                                [import] => 
                                                                                [cost] => 25
                                                                                [default_form] => standard
                                                                                [prioritet] => 0
                                                                                [parent] => 0
                                                                                [visitors] => 1 
                                                                                [count] => 1  - capacity
                                                              }
     * @return mixes - false  if not found
     *                 specific valyue,  if booking resource with  parameter  existr
     *                 or array  of parameters of booking resource
     */
    public function get_resource_attr( $resource_id, $parameter = '' ) {
        
        if ( isset( self::$booking_resources[ $resource_id ] ) ) {
            if ( empty( $parameter ) ) {
                return self::$booking_resources[ $resource_id ];                // array  of parameters for this resources            
            } else {
                
                if ( isset( self::$booking_resources[ $resource_id ][ $parameter ] ) ) {
                     return self::$booking_resources[ $resource_id ][ $parameter ];         // value of specific parameter  in specific resource
                } else {
                    return  false;                                                      // No parameter in this resource.
                }
                
            }
            
        } else {
            return  false;                                                      // No  resource with  this ID
        }
    }
    
    
    
        
    ////////////////////////////////////////////////////////////////////////////
    // Support
    ////////////////////////////////////////////////////////////////////////////
    
    /** Get Pagination parameters 
     *  based on $_GET parameter and 'booking_resourses_num_per_page'
     * 
     * @return array( 'selected_page_num' => 2, 'items_per_page' => 10, 'start' => 10, 'end' => 19 );
     */
    public function get_pagination_params() {
        
        $params = array();
        
        // Current page
        $params['selected_page_num'] = (! empty( $_REQUEST['page_num'] )) ? intval( $_REQUEST['page_num'] ) : 1;         // Pagination
        if (empty($params['selected_page_num'])) $params['selected_page_num'] = 1;
        
        // Number of items per page
        $params['items_per_page'] = intval( get_bk_option( 'booking_resourses_num_per_page' ) );
        
        // Start index of item for this page
        $params['start'] = ( $params['selected_page_num'] - 1 ) * $params['items_per_page'];
        
        // End index of item for this page
        $params['end'] = ( $params['selected_page_num'] ) * $params['items_per_page'] -1 ;
        
        return $params;
    }

    
    /** Get sorting parameter
     *  based on version and $_GET['orderby'] & $_GET['order'] params
     * 
     * @return array( 'orderby' => 'id', 'order' => 'desc' )     ||     array('orderby' => 'title', 'order' => 'asc' ) .... 
     */
    public function get_sorting_params() {
        /*
            id          bigint(20)
            title       varchar(200)
            users       bigint(20)
            cost        varchar(100)
            prioritet   int(4)
            parent      bigint(20)
        */
        //Default Params
        $sort_parameter = array( 
                                'orderby' => 'id'
                              , 'order' => 'asc' 
                            );
        
        if ( class_exists( 'wpdev_bk_biz_l' ) )
            $sort_parameter['orderby'] = 'prioritet';
        
        // Requested params
        if ( isset( $_GET['orderby'] ) ) {
            switch ( strtolower( $_GET['orderby'] ) ) {
                
                case 'id':
                        $sort_parameter['orderby'] = 'id';
                        break;
                case 'title':
                        $sort_parameter['orderby'] = 'title';
                        break;
                case 'users':
                        if ( class_exists( 'wpdev_bk_multiuser' ) )
                            $sort_parameter['orderby'] = 'users';
                        break;
                case 'cost':                                                    // We are having cost as varchar  so  need to trasnform  it to numeric. This operation is SLOW so  do not sort booking resources by  cost in usual  way.
                        if ( class_exists( 'wpdev_bk_biz_s' ) )
                            $sort_parameter['orderby'] = 'cost';
                        break;                    
                case 'prioritet':
                        if ( class_exists( 'wpdev_bk_biz_l' ) )
                            $sort_parameter['orderby'] = 'prioritet';
                        break;
                case 'visitors':
                        if ( class_exists( 'wpdev_bk_biz_l' ) )
                            $sort_parameter['orderby'] = 'visitors';
                        break;
                default:
                        break;
            }
        }

        if ( isset( $_GET['order'] ) ) {
            switch ( strtolower( $_GET['order'] ) ) {
                
                case 'asc':
                        $sort_parameter['order'] = 'asc';
                        break;
                case 'desc':
                        $sort_parameter['order'] = 'desc';
                        break;
                default:
                        break;
            }
        }

        return $sort_parameter;
    }
    
}




/** Get One True instance of WPBC Cache class
 *
 * Example: <?php $wpbc_br_cache = wpbc_br_cache(); ?>
 */
function wpbc_br_cache() {

//debuge('Resources Cache Started'); debuge_speed();

    return WPBC_BR_Cache::init();
}

// Start
//$wpbc_br_cache = wpbc_br_cache();
