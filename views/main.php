<?php
/**
 * Main [section] - Projects [page]
 * 
 * @package Star Citizen Fan Site Kit
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 0.0.1
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Main [section] - Projects [page]
 * 
 * @package Star Citizen Fan Site Kit
 * @subpackage Views
 * @author Ryan Bayne
 * @since 0.0.1
 */
class STARCITIZENFANSITEKIT_Main_View extends STARCITIZENFANSITEKIT_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 0.0.1
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'main';
    
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
        global $starcitizenfansitekit_settings;

        // array of meta boxes + used to register dashboard widgets (id, title, callback, context, priority, callback arguments (array), dashboard widget (boolean) )   
        $this->meta_boxes_array = array(
            // array( id, title, callback (usually parent, approach created by Ryan Bayne), context (position), priority, call back arguments array, add to dashboard (boolean), required capability
            array( 'main-welcome', __( 'Support WordPress Plugin Development', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'welcome' ), true, 'activate_plugins' ),
            
            // framework settings
            array( 'main-schedulerestrictions', __( 'Schedule Restrictions', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'schedulerestrictions' ), true, 'activate_plugins' ),
            array( 'main-scheduleinformation', __( 'Schedule Information', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'scheduleinformation' ), true, 'activate_plugins' ),
            array( 'main-globalswitches', __( 'Global Switches', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'globalswitches' ), true, 'activate_plugins' ),
            array( 'main-logsettings', __( 'Log Settings', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'logsettings' ), true, 'activate_plugins' ),
            array( 'main-pagecapabilitysettings', __( 'Page Capability Settings', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'pagecapabilitysettings' ), true, 'activate_plugins' ),
            //array( 'main-testingajax1', __( 'Testing Ajax 1', 'wtgportalmanager' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'testingajax1' ), true, 'activate_plugins' ),          
        
            // side boxes
            array( 'main-twitterupdates', __( 'Twitter Updates', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'twitterupdates' ), true, 'activate_plugins' ),
            array( 'main-facebook', __( 'Facebook', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'facebook' ), true, 'activate_plugins' ),
            array( 'main-support', __( 'Support', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'support' ), true, 'activate_plugins' ),            
        );
        
        // add meta boxes that have conditions i.e. a global switch
        if( isset( $starcitizenfansitekit_settings['widgetsettings']['dashboardwidgetsswitch'] ) && $starcitizenfansitekit_settings['widgetsettings']['dashboardwidgetsswitch'] == 'enabled' ) {
            $this->meta_boxes_array[] = array( 'main-dashboardwidgetsettings', __( 'Dashboard Widget Settings', 'starcitizenfansitekit' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'dashboardwidgetsettings' ), true, 'activate_plugins' );   
        }
        
        return $this->meta_boxes_array;                
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
        $this->TabMenu = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT_TabMenu', 'class-pluginmenu.php', 'classes' );
        $this->Forms = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT_Formbuilder', 'class-forms.php', 'classes' );
        
        parent::setup( $action, $data );
        
        // only output meta boxes
        if( $this->purpose == 'normal' ) {
            self::metaboxes();// register meta boxes for the current view
        } elseif( $this->purpose == 'dashboard' ) {
            // do nothing - add_dashboard_widgets() in class-ui.php calls dashboard_widgets() from this class
        } elseif( $this->purpose == 'customdashboard' ) {
            return self::meta_box_array();// return meta box array
        } else {
            // do nothing 
        }       
    } 
    
     /**
     * Outputs the meta boxes
     * 
     * @author Ryan R. Bayne
     * @package Star Citizen Fan Site Kit
     * @since 0.0.1
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
    * @package STARCITIZENFANSITEKIT
    * @since 0.0.1
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
    public function postbox_main_welcome( $data, $box ) {    
        echo '<p>' . __( "It take weeks of unpaid work by WTG developers to create great plugins. Then we promise free support! All we ask is a Facebook like or a Tweet or a small donation to keep that happening. You can close this box or even hide it using the Screen Options.", 'starcitizenfansitekit' ) . '</p>';
        echo '<iframe id="coinbase_inline_iframe_34ec17a3078d3e04b5b19e5942bc91ad" src="https://www.coinbase.com/checkouts/34ec17a3078d3e04b5b19e5942bc91ad/inline?c=WTGPluginIntroduction" style="width: 460px; height: 350px; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.25);" allowtransparency="true" frameborder="0"></iframe>';
    }       

   
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_schedulerestrictions( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'This is a less of a specific day and time schedule. More of a system that allows systematic triggering of events within permitted hours. A new schedule system is in development though and will offer even more control with specific timing of events capable.', 'starcitizenfansitekit' ), false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );
        ?>  

            <table class="form-table">
 
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Days', 'starcitizenfansitekit' ); ?></th>
                    <td>
                        <?php 
                        $days_array = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );
                        $days_counter = 1;
                        
                        foreach( $days_array as $key => $day ){
                            
                            // set checked status
                            if( isset( $this->schedule['days'][$day] ) ){
                                $day_checked = 'checked';
                            }else{
                                $day_checked = '';            
                            }
                                 
                            echo '<input type="checkbox" name="starcitizenfansitekit_scheduleday_list[]" id="daycheck'.$days_counter.'" value="'.$day.'" '.$day_checked.' />
                            <label for="daycheck'.$days_counter.'">'.ucfirst( $day ).'</label><br />';    
                            ++$days_counter;
                        }?>
                    </td>
                </tr>
                <!-- Option End -->                          

                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Hours', 'starcitizenfansitekit' ); ?></th>
                    <td>
                    <?php
                    // loop 24 times and create a checkbox for each hour
                    for( $i=0;$i<24;$i++){
                        
                        // check if the current hour exists in array, if it exists then it is permitted, if it does not exist it is not permitted
                        if( isset( $this->schedule['hours'][$i] ) ){
                            $hour_checked = ' checked'; 
                        }else{
                            $hour_checked = '';
                        }
                        
                        echo '<input type="checkbox" name="starcitizenfansitekit_schedulehour_list[]" id="hourcheck'.$i.'"  value="'.$i.'" '.$hour_checked.' />
                        <label for="hourcheck'.$i.'">'.$i.'</label><br>';    
                    }
                    ?>
                    </td>
                </tr>
                <!-- Option End -->          
         
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Daily Limit', 'starcitizenfansitekit' );?></th>
                    <td>
                        <fieldset><legend class="screen-reader-text"><span>Daily Limit</span></legend>
                            <input type="radio" id="starcitizenfansitekit_radio1_dripfeedrate_maximumperday" name="day" value="1" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 1){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio1_dripfeedrate_maximumperday"> <?php _e( '1', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio2_dripfeedrate_maximumperday" name="day" value="5" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 5){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio2_dripfeedrate_maximumperday"> <?php _e( '5', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio3_dripfeedrate_maximumperday" name="day" value="10" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 10){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio3_dripfeedrate_maximumperday"> <?php _e( '10', 'starcitizenfansitekit' );?> </label><br> 
                            <input type="radio" id="starcitizenfansitekit_radio9_dripfeedrate_maximumperday" name="day" value="24" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 24){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio9_dripfeedrate_maximumperday"> <?php _e( '24', 'starcitizenfansitekit' );?> </label><br>                    
                            <input type="radio" id="starcitizenfansitekit_radio4_dripfeedrate_maximumperday" name="day" value="50" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 50){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio4_dripfeedrate_maximumperday"> <?php _e( '50', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio5_dripfeedrate_maximumperday" name="day" value="250" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 250){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio5_dripfeedrate_maximumperday"> <?php _e( '250', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio6_dripfeedrate_maximumperday" name="day" value="1000" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 1000){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio6_dripfeedrate_maximumperday"> <?php _e( '1000', 'starcitizenfansitekit' );?> </label><br>                                                                                                                       
                            <input type="radio" id="starcitizenfansitekit_radio7_dripfeedrate_maximumperday" name="day" value="2000" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 2000){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio7_dripfeedrate_maximumperday"> <?php _e( '2000', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio8_dripfeedrate_maximumperday" name="day" value="5000" <?php if( isset( $this->schedule['limits']['day'] ) && $this->schedule['limits']['day'] == 5000){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio8_dripfeedrate_maximumperday"> <?php _e( '5000', 'starcitizenfansitekit' );?> </label>                   
                        </fieldset>
                    </td>
                </tr>
                <!-- Option End -->   
                         
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Hourly Limit', 'starcitizenfansitekit' );?></th>
                    <td>
                        <fieldset><legend class="screen-reader-text"><span>Hourly Limit</span></legend>
                            <input type="radio" id="starcitizenfansitekit_radio1_dripfeedrate_maximumperhour" name="hour" value="1" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 1){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio1_dripfeedrate_maximumperhour"> <?php _e( '1', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio2_dripfeedrate_maximumperhour" name="hour" value="5" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 5){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio2_dripfeedrate_maximumperhour"> <?php _e( '5', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio3_dripfeedrate_maximumperhour" name="hour" value="10" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 10){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio3_dripfeedrate_maximumperhour"> <?php _e( '10', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio9_dripfeedrate_maximumperhour" name="hour" value="24" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 24){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio9_dripfeedrate_maximumperhour"> <?php _e( '24', 'starcitizenfansitekit' );?> </label><br>                    
                            <input type="radio" id="starcitizenfansitekit_radio4_dripfeedrate_maximumperhour" name="hour" value="50" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 50){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio4_dripfeedrate_maximumperhour"> <?php _e( '50', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio5_dripfeedrate_maximumperhour" name="hour" value="100" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 100){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio5_dripfeedrate_maximumperhour"> <?php _e( '100', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio6_dripfeedrate_maximumperhour" name="hour" value="250" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 250){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio6_dripfeedrate_maximumperhour"> <?php _e( '250', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio7_dripfeedrate_maximumperhour" name="hour" value="500" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 500){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio7_dripfeedrate_maximumperhour"> <?php _e( '500', 'starcitizenfansitekit' );?> </label><br>       
                            <input type="radio" id="starcitizenfansitekit_radio8_dripfeedrate_maximumperhour" name="hour" value="1000" <?php if( isset( $this->schedule['limits']['hour'] ) && $this->schedule['limits']['hour'] == 1000){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio8_dripfeedrate_maximumperhour"> <?php _e( '1000', 'starcitizenfansitekit' );?> </label><br>                                                                                                                           
                       </fieldset>
                    </td>
                </tr>
                <!-- Option End -->   

                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row"><?php _e( 'Event Limit', 'starcitizenfansitekit' );?></th>
                    <td>
                        <fieldset><legend class="screen-reader-text"><span>Event Limit</span></legend>
                            <input type="radio" id="starcitizenfansitekit_radio1_dripfeedrate_maximumpersession" name="session" value="1" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 1){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio1_dripfeedrate_maximumpersession"> <?php _e( '1', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio2_dripfeedrate_maximumpersession" name="session" value="5" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 5){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio2_dripfeedrate_maximumpersession"> <?php _e( '5', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio3_dripfeedrate_maximumpersession" name="session" value="10" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 10){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio3_dripfeedrate_maximumpersession"> <?php _e( '10', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio9_dripfeedrate_maximumpersession" name="session" value="25" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 25){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio9_dripfeedrate_maximumpersession"> <?php _e( '25', 'starcitizenfansitekit' );?> </label><br>                    
                            <input type="radio" id="starcitizenfansitekit_radio4_dripfeedrate_maximumpersession" name="session" value="50" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 50){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio4_dripfeedrate_maximumpersession"> <?php _e( '50', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio5_dripfeedrate_maximumpersession" name="session" value="100" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 100){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio5_dripfeedrate_maximumpersession"> <?php _e( '100', 'starcitizenfansitekit' );?> </label><br>
                            <input type="radio" id="starcitizenfansitekit_radio6_dripfeedrate_maximumpersession" name="session" value="200" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 200){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio6_dripfeedrate_maximumpersession"> <?php _e( '200', 'starcitizenfansitekit' );?> </label><br>                                                                                                                        
                            <input type="radio" id="starcitizenfansitekit_radio7_dripfeedrate_maximumpersession" name="session" value="300" <?php if( isset( $this->schedule['limits']['session'] ) && $this->schedule['limits']['session'] == 300){echo 'checked';} ?> /><label for="starcitizenfansitekit_radio7_dripfeedrate_maximumpersession"> <?php _e( '300', 'starcitizenfansitekit' );?> </label><br>          
                        </fieldset>
                    </td>
                </tr>
                <!-- Option End -->     
                
            </table>
             
        <?php 
        $this->UI->postbox_content_footer();
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_scheduleinformation( $data, $box ) {  ?>
            <h4><?php _e( 'Last Schedule Finish Reason', 'starcitizenfansitekit' );?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['lastreturnreason'] ) ){
                echo $this->schedule['history']['lastreturnreason']; 
            }else{
                _e( 'No event refusal reason has been set yet', 'starcitizenfansitekit' );    
            }?>
            </p>
            
            <h4><?php _e( 'Events Counter - 60 Minute Period', 'starcitizenfansitekit' );?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['hourcounter'] ) ){
                echo $this->schedule['history']['hourcounter']; 
            }else{
                _e( 'No events have been done during the current 60 minute period', 'starcitizenfansitekit' );    
            }?>
            </p> 

            <h4><?php _e( 'Events Counter - 24 Hour Period', 'starcitizenfansitekit' );?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['daycounter'] ) ){
                echo $this->schedule['history']['daycounter']; 
            }else{
                _e( 'No events have been done during the current 24 hour period', 'starcitizenfansitekit' );    
            }?>
            </p>

            <h4><?php _e( 'Last Event Type', 'starcitizenfansitekit' ); ?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['lasteventtype'] ) ){
                
                if( $this->schedule['history']['lasteventtype'] == 'dataimport' ){
                    echo 'Data Import';            
                }elseif( $this->schedule['history']['lasteventtype'] == 'dataupdate' ){
                    echo 'Data Update';
                }elseif( $this->schedule['history']['lasteventtype'] == 'postcreation' ){
                    echo 'Post Creation';
                }elseif( $this->schedule['history']['lasteventtype'] == 'postupdate' ){
                    echo 'Post Update';
                }elseif( $this->schedule['history']['lasteventtype'] == 'twittersend' ){
                    echo 'Twitter: New Tweet';
                }elseif( $this->schedule['history']['lasteventtype'] == 'twitterupdate' ){
                    echo 'Twitter: Send Update';
                }elseif( $this->schedule['history']['lasteventtype'] == 'twitterget' ){
                    echo 'Twitter: Get Reply';
                }
                 
            }else{
                _e( 'No events have been carried out yet', 'starcitizenfansitekit' );    
            }?>
            </p>

            <h4><?php _e( 'Last Event Action', 'starcitizenfansitekit' ); ?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['lasteventaction'] ) ){
                echo $this->schedule['history']['lasteventaction']; 
            }else{
                _e( 'No event actions have been carried out yet', 'starcitizenfansitekit' );    
            }?>
            </p>
                
            <h4><?php _e( 'Last Event Time', 'starcitizenfansitekit' ); ?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['lasteventtime'] ) ){
                echo date( "F j, Y, g:i a", $this->schedule['history']['lasteventtime'] ); 
            }else{
                _e( 'No schedule events have ran on this server yet', 'starcitizenfansitekit' );    
            }?>
            </p>
            
            <h4><?php _e( 'Last Hourly Reset', 'starcitizenfansitekit' ); ?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['hour_lastreset'] ) ){
                echo date( "F j, Y, g:i a", $this->schedule['history']['hour_lastreset'] ); 
            }else{
                _e( 'No hourly reset has been done yet', 'starcitizenfansitekit' );    
            }?>
            </p>   
                
            <h4><?php _e( 'Last 24 Hour Period Reset', 'starcitizenfansitekit' ); ?></h4>
            <p>
            <?php 
            if( isset( $this->schedule['history']['day_lastreset'] ) ){
                echo date( "F j, Y, g:i a", $this->schedule['history']['day_lastreset'] ); 
            }else{
                _e( 'No 24 hour reset has been done yet', 'starcitizenfansitekit' );    
            }?>
            </p> 
               
            <h4><?php _e( 'Your Servers Current Data and Time', 'starcitizenfansitekit' ); ?></h4>
            <p><?php echo date( "F j, Y, g:i a",time() );?></p>     
            
        <?php                       
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_globalswitches( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'These switches disable or enable systems. Disabling systems you do not require will improve the plugins performance.', 'starcitizenfansitekit' ), false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );
        
        global $starcitizenfansitekit_settings;
        ?>  

            <table class="form-table">
            <?php        
            $this->UI->option_switch( __( 'WordPress Notice Styles', 'starcitizenfansitekit' ), 'uinoticestyle', 'uinoticestyle', $starcitizenfansitekit_settings['noticesettings']['wpcorestyle'] );
            $this->UI->option_switch( __( 'WTG Flag System', 'starcitizenfansitekit' ), 'flagsystemstatus', 'flagsystemstatus', $starcitizenfansitekit_settings['posttypes']['wtgflags']['status'] );
            $this->UI->option_switch( __( 'Dashboard Widgets Switch', 'starcitizenfansitekit' ), 'dashboardwidgetsswitch', 'dashboardwidgetsswitch', $starcitizenfansitekit_settings['widgetsettings']['dashboardwidgetsswitch'], 'Enabled', 'Disabled', 'disabled' );      
            ?>
            </table> 
            
        <?php 
        $this->UI->postbox_content_footer();
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_logsettings( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'The plugin has its own log system with multi-purpose use. Not everything is logged for the sake of performance so please request increased log use if required.', 'starcitizenfansitekit' ), false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );
        
        global $starcitizenfansitekit_settings;
        ?>  

            <table class="form-table">
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row">Log</th>
                    <td>
                        <?php 
                        // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                        if(!isset( $starcitizenfansitekit_settings['globalsettings']['uselog'] ) ){
                            $radio1_uselog_enabled = 'checked'; 
                            $radio2_uselog_disabled = '';                    
                        }else{
                            if( $starcitizenfansitekit_settings['globalsettings']['uselog'] == 1){
                                $radio1_uselog_enabled = 'checked'; 
                                $radio2_uselog_disabled = '';    
                            }elseif( $starcitizenfansitekit_settings['globalsettings']['uselog'] == 0){
                                $radio1_uselog_enabled = ''; 
                                $radio2_uselog_disabled = 'checked';    
                            }
                        }?>
                        <fieldset><legend class="screen-reader-text"><span>Log</span></legend>
                            <input type="radio" id="logstatus_enabled" name="starcitizenfansitekit_radiogroup_logstatus" value="1" <?php echo $radio1_uselog_enabled;?> />
                            <label for="logstatus_enabled"> <?php _e( 'Enable', 'starcitizenfansitekit' ); ?></label>
                            <br />
                            <input type="radio" id="logstatus_disabled" name="starcitizenfansitekit_radiogroup_logstatus" value="0" <?php echo $radio2_uselog_disabled;?> />
                            <label for="logstatus_disabled"> <?php _e( 'Disable', 'starcitizenfansitekit' ); ?></label>
                        </fieldset>
                    </td>
                </tr>
                <!-- Option End -->
      
                <?php       
                // log rows limit
                if(!isset( $starcitizenfansitekit_settings['globalsettings']['loglimit'] ) || !is_numeric( $starcitizenfansitekit_settings['globalsettings']['loglimit'] ) ){$starcitizenfansitekit_settings['globalsettings']['loglimit'] = 1000;}
                $this->UI->option_text( 'Log Entries Limit', 'starcitizenfansitekit_loglimit', 'loglimit', $starcitizenfansitekit_settings['globalsettings']['loglimit'] );
                ?>
            </table> 
            
                    
            <h4>Outcomes</h4>
            <label for="starcitizenfansitekit_log_outcomes_success"><input type="checkbox" name="starcitizenfansitekit_log_outcome[]" id="starcitizenfansitekit_log_outcomes_success" value="1" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['outcomecriteria']['1'] ) ){echo 'checked';} ?>> Success</label>
            <br> 
            <label for="starcitizenfansitekit_log_outcomes_fail"><input type="checkbox" name="starcitizenfansitekit_log_outcome[]" id="starcitizenfansitekit_log_outcomes_fail" value="0" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['outcomecriteria']['0'] ) ){echo 'checked';} ?>> Fail/Rejected</label>

            <h4>Type</h4>
            <label for="starcitizenfansitekit_log_type_general"><input type="checkbox" name="starcitizenfansitekit_log_type[]" id="starcitizenfansitekit_log_type_general" value="general" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['typecriteria']['general'] ) ){echo 'checked';} ?>> General</label>
            <br>
            <label for="starcitizenfansitekit_log_type_error"><input type="checkbox" name="starcitizenfansitekit_log_type[]" id="starcitizenfansitekit_log_type_error" value="error" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['typecriteria']['error'] ) ){echo 'checked';} ?>> Errors</label>
            <br>
            <label for="starcitizenfansitekit_log_type_trace"><input type="checkbox" name="starcitizenfansitekit_log_type[]" id="starcitizenfansitekit_log_type_trace" value="flag" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['typecriteria']['flag'] ) ){echo 'checked';} ?>> Trace</label>

            <h4>Priority</h4>
            <label for="starcitizenfansitekit_log_priority_low"><input type="checkbox" name="starcitizenfansitekit_log_priority[]" id="starcitizenfansitekit_log_priority_low" value="low" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['prioritycriteria']['low'] ) ){echo 'checked';} ?>> Low</label>
            <br>
            <label for="starcitizenfansitekit_log_priority_normal"><input type="checkbox" name="starcitizenfansitekit_log_priority[]" id="starcitizenfansitekit_log_priority_normal" value="normal" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['prioritycriteria']['normal'] ) ){echo 'checked';} ?>> Normal</label>
            <br>
            <label for="starcitizenfansitekit_log_priority_high"><input type="checkbox" name="starcitizenfansitekit_log_priority[]" id="starcitizenfansitekit_log_priority_high" value="high" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['prioritycriteria']['high'] ) ){echo 'checked';} ?>> High</label>
            
            <h1>Custom Search</h1>
            <p>This search criteria is not currently stored, it will be used on the submission of this form only.</p>
         
            <h4>Page</h4>
            <select name="starcitizenfansitekit_pluginpages_logsearch" id="starcitizenfansitekit_pluginpages_logsearch" >
                <option value="notselected">Do Not Apply</option>
                <?php
                $current = '';
                if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['page'] ) && $starcitizenfansitekit_settings['logsettings']['logscreen']['page'] != 'notselected' ){
                    $current = $starcitizenfansitekit_settings['logsettings']['logscreen']['page'];
                } 
                $this->UI->page_menuoptions( $current);?> 
            </select>
            
            <h4>Action</h4> 
            <select name="csv2pos_logactions_logsearch" id="csv2pos_logactions_logsearch" >
                <option value="notselected">Do Not Apply</option>
                <?php 
                $current = '';
                if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['action'] ) && $starcitizenfansitekit_settings['logsettings']['logscreen']['action'] != 'notselected' ){
                    $current = $starcitizenfansitekit_settings['logsettings']['logscreen']['action'];
                }
                $action_results = $this->DB->log_queryactions( $current);
                if( $action_results){
                    foreach( $action_results as $key => $action){
                        $selected = '';
                        if( $action['action'] == $current){
                            $selected = 'selected="selected"';
                        }
                        echo '<option value="'.$action['action'].'" '.$selected.'>'.$action['action'].'</option>'; 
                    }   
                }?> 
            </select>
            
            <h4>Screen Name</h4>
            <select name="starcitizenfansitekit_pluginscreens_logsearch" id="starcitizenfansitekit_pluginscreens_logsearch" >
                <option value="notselected">Do Not Apply</option>
                <?php 
                $current = '';
                if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['screen'] ) && $starcitizenfansitekit_settings['logsettings']['logscreen']['screen'] != 'notselected' ){
                    $current = $starcitizenfansitekit_settings['logsettings']['logscreen']['screen'];
                }
                $this->UI->screens_menuoptions( $current);?> 
            </select>
                  
            <h4>PHP Line</h4>
            <input type="text" name="starcitizenfansitekit_logcriteria_phpline" value="<?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['line'] ) ){echo $starcitizenfansitekit_settings['logsettings']['logscreen']['line'];} ?>">
            
            <h4>PHP File</h4>
            <input type="text" name="starcitizenfansitekit_logcriteria_phpfile" value="<?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['file'] ) ){echo $starcitizenfansitekit_settings['logsettings']['logscreen']['file'];} ?>">
            
            <h4>PHP Function</h4>
            <input type="text" name="starcitizenfansitekit_logcriteria_phpfunction" value="<?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['function'] ) ){echo $starcitizenfansitekit_settings['logsettings']['logscreen']['function'];} ?>">
            
            <h4>Panel Name</h4>
            <input type="text" name="starcitizenfansitekit_logcriteria_panelname" value="<?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['panelname'] ) ){echo $starcitizenfansitekit_settings['logsettings']['logscreen']['panelname'];} ?>">

            <h4>IP Address</h4>
            <input type="text" name="starcitizenfansitekit_logcriteria_ipaddress" value="<?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['ipaddress'] ) ){echo $starcitizenfansitekit_settings['logsettings']['logscreen']['ipaddress'];} ?>">
           
            <h4>User ID</h4>
            <input type="text" name="starcitizenfansitekit_logcriteria_userid" value="<?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['userid'] ) ){echo $starcitizenfansitekit_settings['logsettings']['logscreen']['userid'];} ?>">    
          
            <h4>Display Fields</h4>                                                                                                                                        
            <label for="starcitizenfansitekit_logfields_outcome"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_outcome" value="outcome" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] ) ){echo 'checked';} ?>> <?php _e( 'Outcome', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_line"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_line" value="line" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['line'] ) ){echo 'checked';} ?>> <?php _e( 'Line', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_file"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_file" value="file" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['file'] ) ){echo 'checked';} ?>> <?php _e( 'File', 'starcitizenfansitekit' );?></label> 
            <br>
            <label for="starcitizenfansitekit_logfields_function"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_function" value="function" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['function'] ) ){echo 'checked';} ?>> <?php _e( 'Function', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_sqlresult"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_sqlresult" value="sqlresult" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['sqlresult'] ) ){echo 'checked';} ?>> <?php _e( 'SQL Result', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_sqlquery"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_sqlquery" value="sqlquery" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['sqlquery'] ) ){echo 'checked';} ?>> <?php _e( 'SQL Query', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_sqlerror"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_sqlerror" value="sqlerror" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['sqlerror'] ) ){echo 'checked';} ?>> <?php _e( 'SQL Error', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_wordpresserror"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_wordpresserror" value="wordpresserror" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['wordpresserror'] ) ){echo 'checked';} ?>> <?php _e( 'WordPress Erro', 'starcitizenfansitekit' );?>r</label>
            <br>
            <label for="starcitizenfansitekit_logfields_screenshoturl"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_screenshoturl" value="screenshoturl" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['screenshoturl'] ) ){echo 'checked';} ?>> <?php _e( 'Screenshot URL', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_userscomment"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_userscomment" value="userscomment" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['userscomment'] ) ){echo 'checked';} ?>> <?php _e( 'Users Comment', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_page"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_page" value="page" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['page'] ) ){echo 'checked';} ?>> <?php _e( 'Page', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_version"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_version" value="version" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['version'] ) ){echo 'checked';} ?>> <?php _e( 'Plugin Version', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_panelname"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_panelname" value="panelname" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['panelname'] ) ){echo 'checked';} ?>> <?php _e( 'Panel Name', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_tabscreenname"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_tabscreenname" value="tabscreenname" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] ) ){echo 'checked';} ?>> <?php _e( 'Screen Name *', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_dump"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_dump" value="dump" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['dump'] ) ){echo 'checked';} ?>> <?php _e( 'Dump', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_ipaddress"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_ipaddress" value="ipaddress" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['ipaddress'] ) ){echo 'checked';} ?>> <?php _e( 'IP Address', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_userid"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_userid" value="userid" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['userid'] ) ){echo 'checked';} ?>> <?php _e( 'User ID', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_comment"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_comment" value="comment" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['comment'] ) ){echo 'checked';} ?>> <?php _e( 'Developers Comment', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_type"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_type" value="type" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['type'] ) ){echo 'checked';} ?>> <?php _e( 'Entry Type', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_category"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_category" value="category" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['category'] ) ){echo 'checked';} ?>> <?php _e( 'Category', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_action"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_action" value="action" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['action'] ) ){echo 'checked';} ?>> <?php _e( 'Action', 'starcitizenfansitekit' );?></label>
            <br>
            <label for="starcitizenfansitekit_logfields_priority"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_priority" value="priority" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['priority'] ) ){echo 'checked';} ?>> <?php _e( 'Priority', 'starcitizenfansitekit' );?></label> 
            <br>
            <label for="starcitizenfansitekit_logfields_thetrigger"><input type="checkbox" name="starcitizenfansitekit_logfields[]" id="starcitizenfansitekit_logfields_thetrigger" value="thetrigger" <?php if( isset( $starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['thetrigger'] ) ){echo 'checked';} ?>> <?php _e( 'Trigger', 'starcitizenfansitekit' );?></label> 

    
        <?php 
        $this->UI->postbox_content_footer();
    }    
        
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_iconsexplained( $data, $box ) {    
        ?>  
        <p class="about-description"><?php _e( 'The plugin has icons on the UI offering different types of help...' ); ?></p>
        
        <h3>Help Icon<?php echo $this->UI->helpicon( 'http://www.webtechglobal.co.uk/starcitizenfansitekit' )?></h3>
        <p><?php _e( 'The help icon offers a tutorial or indepth description on the WebTechGlobal website. Clicking these may open
        take a key page in the plugins portal or post in the plugins blog. On a rare occasion you will be taking to another users 
        website who has published a great tutorial or technical documentation.' )?></p>        
        
        <h3>Discussion Icon<?php echo $this->UI->discussicon( 'http://www.webtechglobal.co.uk/starcitizenfansitekit' )?></h3>
        <p><?php _e( 'The discussion icon open an active forum discussion or chat on the WebTechGlobal domain in a new tab. If you see this icon
        it means you are looking at a feature or area of the plugin that is a hot topic. It could also indicate the
        plugin author would like to hear from you regarding a specific feature. Occasionally these icons may take you to a discussion
        on other websites such as a Google circles, an official page on Facebook or a good forum thread on a users domain.' )?></p>
                          
        <h3>Info Icon<img src="<?php echo STARCITIZENFANSITEKIT_IMAGES_URL;?>info-icon.png" alt="<?php _e( 'Icon with an i click it to read more information in a popup.' );?>"></h3>
        <p><?php _e( 'The information icon will not open another page. It will display a pop-up with extra information. This is mostly used within
        panels to explain forms and the status of the panel.' )?></p>        
        
        <h3>Video Icon<?php echo $this->UI->videoicon( 'http://www.webtechglobal.co.uk/starcitizenfansitekit' )?></h3>
        <p><?php _e( 'clicking on the video icon will open a new tab to a YouTube video. Occasionally it may open a video on another
        website. Occasionally a video may even belong to a user who has created a good tutorial.' )?></p> 
               
        <h3>Trash Icon<?php echo $this->UI->trashicon( 'http://www.webtechglobal.co.uk/starcitizenfansitekit' )?></h3>
        <p><?php _e( 'The trash icon will be shown beside items that can be deleted or objects that can be hidden.
        Sometimes you can hide a panel as part of the plugins configuration. Eventually I hope to be able to hide
        notices, especially the larger ones..' )?></p>      
      <?php     
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_twitterupdates( $data, $box ) {    
        ?>
        <p class="about-description"><?php _e( 'Thank this plugins developers with a Tweet...', 'starcitizenfansitekit' ); ?></p>    
        <a class="twitter-timeline" href="https://twitter.com/WebTechGlobal" data-widget-id="511630591142268928">Tweets by @WebTechGlobal</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id) ){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script>                                                   
        <?php     
    }    
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0.4
    */
    public function postbox_main_support( $data, $box ) {    
        ?>      
        <p><?php _e( 'All users (free and pro editions) are supported. Please register on the <a href="http://www.webtechglobal.co.uk/register/" title="WebTechGlobal Registration" target="_blank">WebTechGlobal</a> site for free support.', 'starcitizenfansitekit' ); ?></p>                     
        <?php     
    }   
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_facebook( $data, $box ) {    
        ?>      
        <p class="about-description"><?php _e( 'Please show your appreciation for this plugin I made for you by clicking Like...', 'starcitizenfansitekit' ); ?></p>
        <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FWebTechGlobal1&amp;width=350&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="padding: 10px 0 0 0;border:none; overflow:hidden; width:100%; height:290px;" allowTransparency="true"></iframe>                                                                             
        <?php     
    }

    /**
    * Form for setting which captability is required to view the page
    * 
    * By default there is no settings data for this because most people will never use it.
    * However when it is used, a new option record is created so that the settings are
    * independent and can be accessed easier.  
    * 
    * @author Ryan R. Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_pagecapabilitysettings( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Set the capability a user requires to view any of the plugins pages. This works independently of role plugins such as Role Scoper.', 'starcitizenfansitekit' ), false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );
        
        // get the tab menu 
        $pluginmenu = $this->TabMenu->menu_array();
        ?>
        
        <table class="form-table">
        
        <?php 
        // get stored capability settings 
        $saved_capability_array = get_option( 'starcitizenfansitekit_capabilities' );
        
        // add a menu for each page for the user selecting the required capability 
        foreach( $pluginmenu as $key => $page_array ) {
            
            // do not add the main page to the list as a strict security measure
            if( $page_array['name'] !== 'main' ) {
                $current = null;
                if( isset( $saved_capability_array['pagecaps'][ $page_array['name'] ] ) && is_string( $saved_capability_array['pagecaps'][ $page_array['name'] ] ) ) {
                    $current = $saved_capability_array['pagecaps'][ $page_array['name'] ];
                }
                
                $this->UI->option_menu_capabilities( $page_array['menu'], 'pagecap' . $page_array['name'], 'pagecap' . $page_array['name'], $current );
            }
        }?>
        
        </table>
        
        <?php 
        $this->UI->postbox_content_footer();        
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package Star Citizen Fan Site Kit
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_dashboardwidgetsettings( $data, $box ) { 
        global $starcitizenfansitekit_settings;
           
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'This panel is new and is advanced.   
        Please seek my advice before using it.
        You must be sure and confident that it operates in the way you expect.
        It will add widgets to your dashboard. 
        The capability menu allows you to set a global role/capability requirements for the group of wigets from any giving page. 
        The capability options in the "Page Capability Settings" panel are regarding access to the admin page specifically.', 'starcitizenfansitekit' ), false );   
             
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );

        echo '<table class="form-table">';

        // now loop through views, building settings per box (display or not, permitted role/capability  
        $STARCITIZENFANSITEKIT_TabMenu = STARCITIZENFANSITEKIT::load_class( 'STARCITIZENFANSITEKIT_TabMenu', 'class-pluginmenu.php', 'classes' );
        $menu_array = $STARCITIZENFANSITEKIT_TabMenu->menu_array();
        foreach( $menu_array as $key => $section_array ) {

            /*
                'groupname' => string 'main' (length=4)
                'slug' => string 'starcitizenfansitekit_generalsettings' (length=24)
                'menu' => string 'General Settings' (length=16)
                'pluginmenu' => string 'General Settings' (length=16)
                'name' => string 'generalsettings' (length=15)
                'title' => string 'General Settings' (length=16)
                'parent' => string 'main' (length=4)
            */
            
            // get dashboard activation status for the current page
            $current_for_page = '123nocurrentvalue';
            if( isset( $starcitizenfansitekit_settings['widgetsettings'][ $section_array['name'] . 'dashboardwidgetsswitch'] ) ) {
                $current_for_page = $starcitizenfansitekit_settings['widgetsettings'][ $section_array['name'] . 'dashboardwidgetsswitch'];   
            }
            
            // display switch for current page
            $this->UI->option_switch( $section_array['menu'], $section_array['name'] . 'dashboardwidgetsswitch', $section_array['name'] . 'dashboardwidgetsswitch', $current_for_page, 'Enabled', 'Disabled', 'disabled' );
            
            // get current pages minimum dashboard widget capability
            $current_capability = '123nocapability';
            if( isset( $starcitizenfansitekit_settings['widgetsettings'][ $section_array['name'] . 'widgetscapability'] ) ) {
                $current_capability = $starcitizenfansitekit_settings['widgetsettings'][ $section_array['name'] . 'widgetscapability'];   
            }
                            
            // capabilities menu for each page (rather than individual boxes, the boxes will have capabilities applied in code)
            $this->UI->option_menu_capabilities( __( 'Capability Required', 'starcitizenfansitekit' ), $section_array['name'] . 'widgetscapability', $section_array['name'] . 'widgetscapability', $current_capability );
        }

        echo '</table>';
                    
        $this->UI->postbox_content_footer();
    }    

    /**
    * Ajax test form 1: PHP processing function in main class.
    * 
    * Test 2 will attempt to work with the processing class in class-requests.php and make
    * full use of the security it provides. 
    * 
    * @author Ryan Bayne
    * @package WTG Portal Manager
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_main_testingajax1( $data, $box ) { 
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Remove this post-box 1.', 'wtgportalmanager' ), false );        
        $this->Forms->form_start( $box['args']['formid'], $box['args']['formid'], $box['title'] );
        
        global $wtgportalmanager_settings;
        ?>

        <script  type='text/javascript'>
        <!--
        var count = 0;

        function update_hello_world1( count ) {
            jQuery.ajax({
                type: "post",url: "admin-ajax.php",data: { action: 'wtgajaxtest1', count: count, _ajax_nonce: '<?php echo $box['args']['formid']; ?>' },
                beforeSend: function() {jQuery("#helloworld1").fadeOut('fast');}, //fadeIn loading just when link is clicked
                success: function(html){ //so, if data is retrieved, store it in html
                    jQuery("#helloworld1").html(html); //fadeIn the html inside helloworld div
                    jQuery("#helloworld1").fadeIn("fast"); //animation
                }
            }); //close jQuery.ajax(
        }
        
        // When the document loads do everything inside here ...
        jQuery(document).ready(function(){
            update_hello_world1( count );
            jQuery('#updatecount1').click(function() { //start function when any update link is clicked
                count = count + 1;
                update_hello_world1( count );
            })
        })
        -->
        </script>
        
        <style type='text/css'>
        #loading { clear:both; background:url(images/loading.gif) center top no-repeat; text-align:center;padding:33px 0px 0px 0px; font-size:12px;display:none; font-family:Verdana, Arial, Helvetica, sans-serif; }
        #helloworld {
            text-align:center;
            margin: 0, auto;
        }
        </style>
        
        <div class="wrap">
        <a href='#' id='updatecount1'>Update!</a>
        <div id='loading1'>LOADING!</div>
        <div id='helloworld1'></div>
        </div>
        
        
        <?php        
        
        echo '<hr />';
        ?>  

            <table class="form-table">


            </table>
            
        <?php 
        $this->UI->postbox_content_footer();
                    
        echo '<hr />';
        echo '<h3>Debug Information 1</h3>';
        echo __( 'No information at this time.', 'wtgportalmanager' );                         
    } 
}?>