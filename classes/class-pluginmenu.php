<?php
/**
* Beta testing only (check if in use yet) - phasing array files into classes of their own then calling into the main class
*/
class STARCITIZENFANSITEKIT_TabMenu {
    public function menu_array() {
        $menu_array = array();
        
        ######################################################
        #                                                    #
        #                        MAIN                        #
        #                                                    #
        ######################################################
        // can only have one view in main right now until WP allows pages to be hidden from showing in
        // plugin menus. This may provide benefit of bringing user to the latest news and social activity
        // main page
        $menu_array['main']['groupname'] = 'main';        
        $menu_array['main']['slug'] = 'starcitizenfansitekit';// home page slug set in main file
        $menu_array['main']['menu'] = __( 'SC Kit Dashboard', 'starcitizenfansitekit' );// plugin admin menu
        $menu_array['main']['pluginmenu'] = __( 'SC Kit Dashboard' ,'starcitizenfansitekit' );// for tabbed menu
        $menu_array['main']['name'] = "main";// name of page (slug) and unique
        $menu_array['main']['title'] = 'SC Kit Dashboard';// title at the top of the admin page
        $menu_array['main']['parent'] = 'parent';// either "parent" or the name of the parent - used for building tab menu         
        $menu_array['main']['tabmenu'] = false;// boolean - true indicates multiple pages in section, false will hide tab menu and show one page 

        ######################################################
        #                                                    #
        #                 SAMPLES SECTION                    #
        #                                                    #
        ###################################################### 
  
        // Import Media (artwork) and Data (ship specs) 
        $menu_array['importstuff']['groupname'] = 'samples';
        $menu_array['importstuff']['slug'] = 'starcitizenfansitekit_importstuff'; 
        $menu_array['importstuff']['menu'] = __( 'Import Media and Data', 'starcitizenfansitekit' );
        $menu_array['importstuff']['pluginmenu'] = __( 'Import Media and Data', 'starcitizenfansitekit' );
        $menu_array['importstuff']['name'] = "importstuff";
        $menu_array['importstuff']['title'] = __( 'Import Media and Data', 'starcitizenfansitekit' ); 
        $menu_array['importstuff']['parent'] = 'parent'; 
        $menu_array['importstuff']['tabmenu'] = true;
        
        // graphs
        /*
        $menu_array['graphs']['groupname'] = 'samples';
        $menu_array['graphs']['slug'] = 'starcitizenfansitekit_graphs'; 
        $menu_array['graphs']['menu'] = __( 'Graphs', 'starcitizenfansitekit' );
        $menu_array['graphs']['pluginmenu'] = __( 'Graphs', 'starcitizenfansitekit' );
        $menu_array['graphs']['name'] = "graphs";
        $menu_array['graphs']['title'] = __( 'Graphs', 'starcitizenfansitekit' ); 
        $menu_array['graphs']['parent'] = 'importstuff'; 
        $menu_array['graphs']['tabmenu'] = true;
          
        // WP Table 2
        $menu_array['tablelist']['groupname'] = 'samples';
        $menu_array['tablelist']['slug'] = 'starcitizenfansitekit_tablelist'; 
        $menu_array['tablelist']['menu'] = __( 'WP Table 2', 'starcitizenfansitekit' );
        $menu_array['tablelist']['pluginmenu'] = __( 'WP Table 2', 'starcitizenfansitekit' );
        $menu_array['tablelist']['name'] = "table";
        $menu_array['tablelist']['title'] = __( 'WP Table 2', 'starcitizenfansitekit' ); 
        $menu_array['tablelist']['parent'] = 'commonforms'; 
        $menu_array['tablelist']['tabmenu'] = true;
          */
                           
        return $menu_array;
    }
} 
?>
