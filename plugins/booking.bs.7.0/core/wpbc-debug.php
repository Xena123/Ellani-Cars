<?php
/**
 * @version 1.1
 * @package Any
 * @category Dubug info showing
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 09.09.2015
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


    
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  D e b u g    f u n c t i o n s       ///////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
 * Show values of the arguments list
 */
if (!function_exists ('debuge')) {
    function debuge() {
        $numargs = func_num_args();
        $var = func_get_args();
        $makeexit = is_bool( $var[count($var)-1] ) ? $var[ count($var) - 1 ]:false;
        echo "<div><pre class='prettyprint linenums'>";
        print_r ( $var );
        echo "</pre></div>";
        echo '<script type="text/javascript"> jQuery(".ajax_respond_insert, .ajax_respond").show(); </script>';
        if ( $makeexit ) {
            echo '<div style="font-size:18px;float:right;">' . get_num_queries(). '/'  . timer_stop(0, 3) . 'qps</div>';
            exit;
        }
    }
}

/*
 * Show Speed of the execution and number of queries.
 */
if (!function_exists ('debuge_speed')) {
    function debuge_speed() {
        echo '<div style="font-size:18px;float:right;">' . get_num_queries(). '/'  . timer_stop(0, 3) . 'qps</div>';
    }
}

/** Show error info
 */
if (!function_exists ('debuge_error')) {
    function debuge_error( $msg , $file_name='', $line_num=''){
        echo get_debuge_error( $msg , $file_name , $line_num );
    }
}
if (!function_exists ('get_debuge_error')) {
    function get_debuge_error( $msg , $file_name='', $line_num=''){

        $ver_num = ( ! defined('WPDEV_BK_VERSION') ) ? '' : '|V:' . WPDEV_BK_VERSION ;
        
        $last_db_error = '';
        global $EZSQL_ERROR;
        if (isset($EZSQL_ERROR[ (count($EZSQL_ERROR)-1)])) {

            $last_db_error2 = $EZSQL_ERROR[ (count($EZSQL_ERROR)-1)];

            if  ( (isset($last_db_error2['query'])) && (isset($last_db_error2['error_str'])) ) {

                $str   = str_replace( array( '"', "'" ), '', $last_db_error2['error_str'] );     
                $query = str_replace( array( '"', "'" ), '', $last_db_error2['query'] );     

                $str   = htmlspecialchars( $str,    ENT_QUOTES );
                $query = htmlspecialchars( $query , ENT_QUOTES );

                $last_db_error =  $str ;                
                $last_db_error .= '::<span style="color:#300;">'.$query.'</span>';
            }
        }        
        return $msg . '<br /><span style="font-size:11px;"> ['
                                                        .   'F:' . str_replace( dirname( $file_name ) , '' , $file_name )
                                                        . '| L:' . $line_num  
                                                        . $ver_num  
                                                        . '| DB:' . $last_db_error  
                            . '] </span>' ;
    }
}

// Usage: if (  function_exists ('wpbc_check_post_key_max_number')) { wpbc_check_post_key_max_number(); }
if ( ! function_exists ('wpbc_check_post_key_max_number')) {
    function wpbc_check_post_key_max_number() {
        
        /*
        $post_max_totalname_length    = intval( ( ini_get( 'suhosin.post.max_totalname_length' ) ) ? ini_get( 'suhosin.post.max_totalname_length' ) : '9999999' );
        $request_max_totalname_length = intval( ( ini_get( 'suhosin.request.max_totalname_length' ) ) ? ini_get( 'suhosin.request.max_totalname_length' ) : '9999999' );
        $post_max_name_length         = intval( ( ini_get( 'suhosin.post.max_name_length' ) ) ? ini_get( 'suhosin.post.max_name_length' ) : '9999999' );
        $request_max_varname_length   = intval( ( ini_get( 'suhosin.request.max_varname_length' ) ) ? ini_get( 'suhosin.request.max_varname_length' ) : '9999999' );
        */
        $php_ini_vars = array( 
                                  'suhosin.post.max_totalname_length'
                                , 'suhosin.request.max_totalname_length'
                                , 'suhosin.post.max_name_length'
                                , 'suhosin.request.max_varname_length' 
                            );
        
        foreach ( $_POST as $key_name => $post_value ) {
            
            $key_length = strlen( $key_name );
            
            foreach ( $php_ini_vars as $php_ini_var ) {
                
                $php_ini_var_length    = intval( ( ini_get( $php_ini_var ) ) ? ini_get( $php_ini_var ) : '9999999' );
                
                if (  $key_length > $php_ini_var_length ) {
                    
                    wpbc_show_message_in_settings(  'Your php.ini configuration limited to ' 
                                                    . '<strong> '. $php_ini_var . ' = ' . $php_ini_var_length . '</strong>.' 
                                                    . ' '
                                                    . 'Plugin require at least ' . ( intval( $key_length ) + 1 ). ', '
                                                    . 'for saving option: ' . '<strong>'. $key_name    . '</strong>'
                                                  , 'error'
                                                  , __('Error' ,'booking') . '.' );
                    
                }                
            }
        }        
    }
}