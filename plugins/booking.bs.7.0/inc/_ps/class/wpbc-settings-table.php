<?php
/**
 * @version 1.0
 * @package Abstarct Settings Table Class
 * @category Settings Table Class
 * @author wpdevelop
 *
 * @web-site http://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2016-08-14
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/** Settings Table Class  */
abstract class WPBC_Settings_Table {
    
    protected $id;
    
    protected $columns;
    
    protected $loaded_data;

    protected $url_sufix = '';                                                  // append to all links -  useful for anchor to  HTML section  with  specific ID,  Example: '#my_section'

    protected $callback_rows_func = false;                                      // Callback Function  for showing rows in table: 'function_name'  or array( $object, 'method' );        
    
    protected $parameters = array();
    
    
    public function __construct( $id, $args = array() ){
        
        $this->id = $id;
        
        $defaults = array( 
                              'id' => rand( 1000000 , ( 10000000-1 ) )  
                            , 'is_show_pseudo_search_form' => true
                            , 'url_sufix' => ''
                            , 'rows_func' => false
                            , 'columns'   => array()                            /** Exmaple:
                                                                                array(
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
                                                                                */
                        );
        $this->parameters = wp_parse_args( $args, $defaults );
        
        ////////////////////////////////////////////////////////////////////////
        
        $this->set_url_sufix( $this->parameters['url_sufix'] );
        
        $this->define_columns( $this->parameters['columns'] );
        
        $this->define_callback_rows_func( $this->parameters['rows_func'] );
        
        ////////////////////////////////////////////////////////////////////////
                
        $this->loaded_data = $this->load_data();                                //  Load Data for showing in Table (like booking resources from  cache )
    }
    

    ////////////////////////////////////////////////////////////////////////////
    // Data
    ////////////////////////////////////////////////////////////////////////////

    /** Load Data for showing in Table
     * 
     * @return array
     */    
    abstract public function load_data();
    
    
    /** Get sorted part of booking resources array for ONE Page
     * 
     * @return array
     */
    abstract public function get_linear_data_for_one_page();
    
    
    ////////////////////////////////////////////////////////////////////////////
    // Other Abstarct 
    ////////////////////////////////////////////////////////////////////////////
    
    /** Get Actual sorting parameter from Data Class or some other source
     *  based on version and $_GET['orderby'] & $_GET['order'] params
     * 
     * @return array( 'orderby' => 'id', 'order' => 'desc' )     ||     array('orderby' => 'title', 'order' => 'asc' ) .... 
     */    
    abstract public function get_sorting_params();
    
    
    /** Get ONLY the paramters that  possible to  use in pagination buttons
     * 
     * @return array( 'page', 'tab', 'wh_resource_id' );
     */
    abstract public function gate_paramters_for_pagination();
    
    
    // Visual //////////////////////////////////////////////////////////////////
    
    /** Show Footer Row 
     * Its must  be something like:
     *                              <th colspan="<?php echo count( $this->get_columns() ); ?>" style="text-align: center;"> ... Data .... </th>
     */
    abstract public function show_footer();


    ////////////////////////////////////////////////////////////////////////////
    //  Structure
    ////////////////////////////////////////////////////////////////////////////
        
    /** Define Collumns for table
     * 
     * @param array $collumns
     * Example:
                array(
                        'check'     => array( 'title' => '', 'attr' => array( 'class' => '', 'style' => ''  ), 'sortable' => true )
                      , 'id'        => array( 'title' => __('ID'), 'attr' => array( 'class' => '', 'style' => ''  ), 'sortable' => true )
                      , 'resources' => array( 'title' => __('Resources'), 'attr' => array( 'class' => '', 'style' => ''  ), 'sortable' => true )
                      , 'gcalid'    => array( 'title' => __('Google Calendar ID'), 'attr' => array( 'class' => '', 'style' => ''  ) )
                      , 'actions'   => array( 'title' => __('Actions'), 'attr' => array( 'class' => '', 'style' => ''  ) )
                )

     */
    public function define_columns( $collumns = array() ) {
        
       $this->columns = $collumns;
    }
    
    
    /** Get header collumns array
     * 
     * @return array
     */
    public function get_columns() {
        
       return $this->columns;
    }
    
    
    /**  Define function name (or array for obj) to call  for showing rows in table
     * 
     * @param type $callback_rows_func
     */
    public function define_callback_rows_func( $callback_rows_func ) {
        $this->callback_rows_func = $callback_rows_func;
    }
    
        
    /** Display Table Columns - Header | Footer*/
    public function print_column_headers( $is_header = true ) {
       
        if ( $is_header ) {
            foreach ( $this->get_columns() as $col_id => $col_value ) {

                if ( ! empty( $col_value['sortable'] ) ) $is_sortable = true;
                else                                     $is_sortable = false;

                $active_sort = $this->get_sorting_params();                     // array( 'orderby' => 'id', 'order' => 'asc');

                ?><th <?php echo   isset($col_value['id'] ) ? ' id="' . $col_value['id'] . '" ' : ''; ?>
                        <?php echo isset($col_value['class'] ) ? ' class="' . $col_value['class'] . '" ' : ''; ?>
                        <?php echo isset($col_value['style'] ) ? ' style="' . $col_value['style'] . '" ' : ''; ?>
                        <?php echo isset($col_value['attr'] ) ? ' ' . $this->get_custom_attr_static( $col_value['attr'] ) . ' ' : ''; ?>

                    ><?php 
                        if ( $is_sortable ) { 
                            
                            // First  parameter  will overwriten by $_GET['page'] parameter
                            $exclude_params = array();                          //  array( 'page_num', 'orderby', 'order' );  
                                                                                //  if using "only_these_parameters",  then this parameter  does not require
                            
                            $only_these_parameters  = $this->gate_paramters_for_pagination();       // array( 'page', 'tab', 'wh_resource_id' );
                            
                            $wpbc_admin_url         = wpbc_get_params_in_url( wpbc_get_bookings_url( false, false ), $exclude_params, $only_these_parameters );

                            $order = 'asc';                                     // Default order
                            
                            if ( $active_sort['orderby'] == $col_id ) {
                                if ( $active_sort['order'] == 'asc' )           // Change order if its actual order right now
                                    $order = 'desc';
                                else
                                    $order = 'asc';
                            }
                            
                            ?><a href="<?php echo $wpbc_admin_url . '&orderby=' . $col_id . '&order=' . $order . $this->url_sufix ; ?>"><?php
                        }
                            echo $col_value['title']; 

                            if ( $is_sortable ) {                            

                                if ( $active_sort['orderby'] == $col_id ) {                                                                                   
                                    ?> <span aria-hidden="true" class="glyphicon <?php 
                                            echo ( $active_sort['order'] == 'asc' ) ? 'glyphicon-sort-by-attributes' : 'glyphicon-sort-by-attributes-alt'; ?>"                                              
                                        ></span><?php 
                                } else {
                                    ?> <span class="glyphicon glyphicon-sort" aria-hidden="true"></span><?php 
                                }
                                ?></a><?php 
                            }

                   ?></th><?php 
            }
        } else {    
            $this->show_footer();            
        }
    }
   
     
    /** Display Table Rows */
    public function print_rows() {
        
        
        $data_rows = $this->get_linear_data_for_one_page();

        $i = -1;
        if ( count( $data_rows ) > 0 ) {
            foreach ( $data_rows as $row_key_id => $data_arr ) {                                                        
                $i++;

                    if ( $this->callback_rows_func === false ) {
                        ?><tr class="wpbc_row"><td colspan="<?php echo count( $this->get_columns() ); ?>" style="text-align: center;"><?php 
                                echo 'Error. Does not defined WPBC_Settings_Table::callback_rows_func';
                        ?></td></tr><?php 

                        return;
                    }

                call_user_func_array( $this->callback_rows_func, array( $i,  $data_arr ) );                        
            }        
        } else {
            ?><tr class="wpbc_row wpbc_no_results_row"><td colspan="<?php echo count( $this->get_columns() ); ?>" style="text-align: center;font-weight:600;font-size:1.2em;"><?php 
                _e('No results found.');
            ?></td></tr><?php             
        }
    }
   
    
        // Support Visual Fucntions, that possible to overrride  ///////////////
       
        /** Get array of CSS classes for DIV element before  Table
         * 
         * @return array            - array( 'wpbc_resources_table' );   
         */
        public function div_before_table_css_classes() {

            return array( 'wpbc_resources_table' );   
        }

        /** Get array of CSS classes for Table
         * 
         * @return array            - array( 'sortable' );
         */
        public function table_css_classes() {

            return array();                     // array( 'sortable' );   
        }

        ////////////////////////////////////////////////////////////////////////
        
    
    /** Display Table */
    public function display() {
        
        do_action( 'wpbc_before_showing_settings_table', $this->id );
        
        ?>
        <div class="wpdevelop wpbc_selectable_table <?php echo implode( ' ', $this->div_before_table_css_classes() ); ?>">
            <table class="table table-striped widefat <?php echo implode( ' ', $this->table_css_classes() ); ?>" cellspacing="0" cellpadding="0">
                <thead class="wpbc_selectable_head">
                    <tr>
                        <?php $this->print_column_headers(); ?>
                    </tr>
                </thead>

                <tbody class="wpbc_selectable_body">
                        <?php $this->print_rows(); ?>
                </tbody>
                <tfoot class="wpbc_selectable_foot">
                    <tr>
                        <?php $this->print_column_headers( false ); ?>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php    
        
        do_action( 'wpbc_after_showing_settings_table', $this->id );
    }

    
    ////////////////////////////////////////////////////////////////////////////
    // Support
    ////////////////////////////////////////////////////////////////////////////
        
    /** Get custom attributes
     *
     * @param  array $field
     * @return string
     */
    protected static function get_custom_attr_static( $field ) {

        $attributes = array();

        if ( ! empty( $field['attr'] ) && is_array( $field['attr'] ) ) {

            foreach ( $field['attr'] as $attr => $attr_v ) {
                $attributes[] = esc_attr( $attr ) . '="' . esc_attr( $attr_v ) . '"';
            }
        }

        return implode( ' ', $attributes );
    }
    
    public function set_url_sufix( $param ) {
        $this->url_sufix = $param;
    }
        
}