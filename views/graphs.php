<?php
/**
 * Taxonomies [page]   
 *
 * @package Star Citizen Fan Site Kit
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 0.0.1
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Taxonomies [page] 
 * 
 * @package Star Citizen Fan Site Kit
 * @subpackage Views
 * @author Ryan Bayne
 * @since 0.0.1
 */
class STARCITIZENFANSITEKIT_Graphs_View extends STARCITIZENFANSITEKIT_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 0.0.1
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'graphs';
    
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
            array( 'taxonomies-singletaxonomies', __( 'Single Taxonomies', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'singletaxonomies' ), true, 'activate_plugins' )
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

        // using array register many meta boxes
        foreach( self::meta_box_array() as $key => $metabox ) {
            // the $metabox array includes required capability to view the meta box
            if( isset( $metabox[7] ) && current_user_can( $metabox[7] ) ) {
                $this->add_meta_box( $metabox[0], $metabox[1], $metabox[2], $metabox[3], $metabox[4], $metabox[5] );   
            }               
        }          
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
    * post box function
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_graphs_singletaxonomies( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Import values for none heirarchical taxonomies.', 'starcitizenfansitekit' ), false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );
        
        ?>  
        
            <table class="form-table">
            </table>
 
        <?php 
        $this->UI->postbox_content_footer();
    }
    
}?>