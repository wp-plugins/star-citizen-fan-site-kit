<?php
/**
 * Data Sources [page]   
 *
 * @package Star Citizen Fan Site Kit
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 0.0.1
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Data Sources [page] 
 * 
 * @package Star Citizen Fan Site Kit
 * @subpackage Views
 * @author Ryan Bayne
 * @since 0.0.1
 */
class STARCITIZENFANSITEKIT_Tablelist_View extends STARCITIZENFANSITEKIT_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 0.0.1
     *
     * @var int
     */
    protected $screen_columns = 1;
    
    protected $view_name = 'tablelist';
    
    public $purpose = 'normal';// normal, dashboard

    /**
    * Array of meta boxes, looped through to register them on views and as dashboard widgets
    * 
    * @author Ryan R. Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function meta_box_array() {
        // array of meta boxes + used to register dashboard widgets (id, title, callback, context, priority, callback arguments (array), dashboard widget (boolean) )   
        return $this->meta_boxes_array = array(
            // array( id, title, callback (usually parent, approach created by Ryan Bayne), context (position), priority, call back arguments array, add to dashboard (boolean), required capability
            array( $this->view_name . '-datasourcestable', __( 'Data Sources Table', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'datasourcestable' ), true, 'activate_plugins' ),

        );    
    }
            
    /**
     * Set up the view with data and do things that are specific for this view
     *
     * @since 0.0.1
     *
     * @param string $action Action for this view
     * @param array $data Data for this view
     */
    public function setup( $action, array $data ) {
        global $starcitizenfansitekit_settings;
        
        // create constant for view name
        if(!defined( "STARCITIZENFANSITEKIT_VIEWNAME") ){define( "STARCITIZENFANSITEKIT_VIEWNAME", $this->view_name );}
        
        // create class objects
        $this->STARCITIZENFANSITEKIT = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT', 'class-starcitizenfansitekit.php', 'classes' );
        $this->UI = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT_UI', 'class-ui.php', 'classes' ); 
        $this->DB = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT_DB', 'class-wpdb.php', 'classes' );
        $this->PHP = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT_PHP', 'class-phplibrary.php', 'classes' );
        $this->Forms = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT_Formbuilder', 'class-forms.php', 'classes' );
        
        parent::setup( $action, $data );

        // create a data table ( use "head" to position before any meta boxes and outside of meta box related divs)
        $this->add_text_box( 'head', array( $this, 'datatables' ), 'normal' );
                
        // using array register many meta boxes
        foreach( self::meta_box_array() as $key => $metabox ) {
            // the $metabox array includes required capability to view the meta box
            if( isset( $metabox[7] ) && current_user_can( $metabox[7] ) ) {
                $this->add_meta_box( $metabox[0], $metabox[1], $metabox[2], $metabox[3], $metabox[4], $metabox[5] );   
            }               
        }                  
    }

    /**
    * Displays one or more tables of data at the top of the page before post boxes
    * 
    * @author Ryan R. Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function datatables( $data, $box ) {       
        $WPTableObject = new WORDPRESSPLUGINSTARCITIZENFANSITEKIT_WPTable_Example();
        $WPTableObject->prepare_items_further( array(), 10 );
        ?>

        <form method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
            <?php             
            // pass data here or use prepare_items_further() itself to query data
            $WPTableObject->prepare_items_further( false, 5 );
            
            // add search field
            $WPTableObject->search_box( 'search', 'theidhere' ); 
            
            // display the table
            $WPTableObject->display();
            ?>
        </form>
 
        <?php               
    }
    
    /**
    * Outputs the meta boxes
    * 
    * @author Ryan R. Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.3
    * @version 1.0
    */
    public function metaboxes() {
        parent::register_metaboxes( self::meta_box_array() );     
    }

    /**
    * This function is called when on WP core dashboard and it adds widgets to the dashboard using
    * the meta box functions in this class. 
    * 
    * @uses dashboard_widgets() in parent class STARCITIZENFANSITEKIT_View which loops through meta boxes and registeres widgets
    * 
    * @author Ryan R. Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.2
    * @version 1.0
    */
    public function dashboard() { 
        parent::dashboard_widgets( self::meta_box_array() );  
    }
    
    /**
    * All add_meta_box() callback to this function to keep the add_meta_box() call simple.
    * 
    * This function also offers a place to apply more security or arguments.
    * 
    * @author Ryan R. Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    function parent( $data, $box ) {
        eval( 'self::postbox_' . $this->view_name . '_' . $box['args']['formid'] . '( $data, $box );' );
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_tablelist_datasourcestable( $data, $box ) { 

    }      
}

     
/**
* Example of WP List Table class for display on this view only.
*/
class WORDPRESSPLUGINSTARCITIZENFANSITEKIT_WPTable_Example extends WP_List_Table {
    
    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct() {
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }
    
    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default( $item, $column_name ){   
      
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch( $column_name){
            
            case 'exampleone':
                return $item['exampleone'];    
                break;
            case 'exampletwo':
                return $item['exampletwo'];    
                break;                
            case 'examplethree':
                return $item['examplethree'];
                break;    
                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }
                    
    /** ************************************************************************
    * Recommended. This is a custom column method and is responsible for what
    * is rendered in any column with a name/slug of 'title'. Every time the class
    * needs to render a column, it first looks for a method named 
    * column_{$column_title} - if it exists, that method is run. If it doesn't
    * exist, column_default() is called instead.
    * 
    * This example also illustrates how to implement rollover actions. Actions
    * should be an associative array formatted as 'slug'=>'link html' - and you
    * will need to generate the URLs yourself. You could even ensure the links
    * 
    * 
    * @see WP_List_Table::::single_row_columns()
    * @param array $item A singular item (one full row's worth of data)
    * @return string Text to be placed inside the column <td> (movie title only )
    **************************************************************************/
    /*
    function column_title( $item){

    } */
    
    /** ************************************************************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns() {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'exampleone' => 'Example One',
            'exampletwo' => 'Example Two',
            'examplethree'     => 'Example Three'
        );
        
        /*
        if( isset( $this->action ) ){
            $columns['action'] = 'Action';
        } 
        */                                      
           
        return $columns;
    }
   
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="book[]" value="%s" />', $item['ID']
        );    
    }
        
    /** ************************************************************************
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
     * you will need to register it here. This should return an array where the 
     * key is the column that needs to be sortable, and the value is db column to 
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     * 
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within prepare_items_further() and sort
     * your data accordingly (usually by modifying your query ).
     * 
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array( 'data_values',bool)
     **************************************************************************/
    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array( 'post_title', false ),     //true means it's already sorted
        );
        return $sortable_columns;
    }
    
    /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(
            'canceltask' => 'Cancel Tasks'
        );
        return $actions;
    }

    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     * 
     * @see $this->prepare_items_further()
     **************************************************************************/
    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
        
    }
    
    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items_further( $data, $per_page = 20 ) {
        global $wpdb; //This is used only if making any database queries        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        /**
        * OPTIONAL APPROACH. We can get our data here if not using $data. We can also
        * use $columns to improve the query and only return the values we will actually use.
        * 
        * We can apply $_GET['s'] for search here and improve the query further 
        */
        if( $data === false || !is_array( $data ) ) {
            # example only
            $data = array( 0 => array( 'ID' => 100,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Buy pro edition at WebTechGlobal.co.uk',
                                       'examplethree' => 'Support for this feature at http://forum.webtechglobal.co.uk and is free.' ), 
                           1 => array( 'ID' => 200,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Test Data',
                                       'examplethree' => 'You need to replace this sample data, contact me for help if your unsure how.' ),
                           2 => array( 'ID' => 300,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Reporting Faults Is Work',
                                       'examplethree' => '10% discount for reporting a software or service fault through my ticket system which was not previously reported.' ),                        
                           3 => array( 'ID' => 400,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Donations Matter',
                                       'examplethree' => 'A donation of $15/£10 allows me to work for an hour. That could be a new feature or an important fix.' ),                        
                           4 => array( 'ID' => 500,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Founders Get All',
                                       'examplethree' => 'Becoming a WebTechGlobal Founder grants you a copy of every premium plugin and theme we create for life. Terms apply.' ),                        
                           5 => array( 'ID' => 600,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Contributor Spotlight',
                                       'examplethree' => 'Contributions to a plugin or theme in the form of donation or code will get your name and site listed in that softwares portal.' ),                        
                           6 => array( 'ID' => 700,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Your Good Ideas',
                                       'examplethree' => 'If your request/idea is voted for 1000 times by the community you will get a 10% on any product for any CMS.' ),                        
                           7 => array( 'ID' => 800,
                                       'exampleone' => 'www.webtechglobal.co.uk', 
                                       'exampletwo' => 'Community Support Content',
                                       'examplethree' => 'Community support material will be added to the applicable portal on the WTG site. An opportunity for traffic.' ),                        
                           8 => array( 'ID' => 900,
                                       'exampleone' => 'www.yourownsite.co.uk', 
                                       'exampletwo' => 'Review Discount',
                                       'examplethree' => '10% discount on any WP plugin or theme for publishing a review of any free plugin by WTG.' ),                        
                           9 => array( 'ID' => 101,
                                       'exampleone' => 'www.youtube.com', 
                                       'exampletwo' => 'YouTube video discount',
                                       'examplethree' => '10% discount on WordPress plugins for creating a 10 minute YouTube supporting/reviewing the free edition of any WTG plugin.' ),                                               

            );            
        }
        
        // in this example I'm going to remove records from the array that do not have the searched string (test string is: 2)
        if( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
            $searched_string = wp_unslash( $_GET['s'] );
            foreach( $data as $key => $record_values  ) {
                $match_found = false;
                foreach( $record_values as $example_value ) {
                   if ( strpos( $example_value, $searched_string ) !== FALSE) { // Yoshi version
                        $match_found = true;
                        break;
                   }                
                }    
                
                // if no $match_found remove the current $record_values using the $key
                if( !$match_found ) {
                    unset( $data[ $key ] );    
                }
            }
        }
                
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array( $columns, $hidden, $sortable);
        
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();
      
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count( $data);

        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice( $data,(( $current_page-1)*$per_page), $per_page);
 
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
  
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

?>