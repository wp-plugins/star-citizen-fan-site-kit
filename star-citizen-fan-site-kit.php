<?php         
/*
Plugin Name: Star Citizen Fan Site Kit Beta
Version: 0.0.1
Plugin URI: http://www.webtechglobal.co.uk/wtg-plugin-framework-wordpress/
Description: Star Citizen Fan Site Kit created by the games community.
Author: WebTechGlobal
Author URI: http://www.webtechglobal.co.uk/
Last Updated: March 2015
Text Domain: starcitizenfansitekit
Domain Path: /languages

GPL v3 

This program is free software downloaded from WordPress.org: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. This means
it can be provided for the sole purpose of being developed further
and we do not promise it is ready for any one persons specific needs.
See the GNU General Public License for more details.

See <http://www.gnu.org/licenses/>.
*/           
  
// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'Direct script access is not allowed!' );

// exit early if Star Citizen Fan Site Kit doesn't have to be loaded
if ( ( 'wp-login.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) ) // Login screen
    || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST )
    || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
    return;
}
              
// package variables
$starcitizenfansitekit_currentversion = '0.0.1';# to be removed, version is now in the STARCITIZENFANSITEKIT() class 
$starcitizenfansitekit_debug_mode = false;# to be phased out, going to use environment variables (both WP and php.ini instead)

// go into dev mode if on test installation (if directory contains the string you will see errors and other fun stuff for geeks)               
if( strstr( ABSPATH, 'OFFstarcitizenfansitekit' ) ){
    $starcitizenfansitekit_debug_mode = true;     
}               

// avoid error output here and there for the sake of performance...              
if ( ( 'wp-login.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) )
        || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST )
        || ( defined( 'DOING_CRON' ) && DOING_CRON )
        || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
    $starcitizenfansitekit_debug_mode = false;
}                   

// define WebTechGlobal constants applicable to all projects...
if(!defined( "WEBTECHGLOBAL_FULLINTEGRATION") ){define( "WEBTECHGLOBAL_FULLINTEGRATION", false );}// change to true to force tables and files to be shared among WTG plugins automatically
if(!defined( "WEBTECHGLOBAL_FORUM" ) ){define( "WEBTECHGLOBAL_FORUM", 'http://forum.webtechglobal.co.uk/' );}
if(!defined( "WEBTECHGLOBAL_TWITTER" ) ){define( "WEBTECHGLOBAL_TWITTER", 'http://www.twitter.com/WebTechGlobal/' );}
if(!defined( "WEBTECHGLOBAL_FACEBOOK" ) ){define( "WEBTECHGLOBAL_FACEBOOK", 'https://www.facebook.com/WebTechGlobal1/' );}
if(!defined( "WEBTECHGLOBAL_REGISTER" ) ){define( "WEBTECHGLOBAL_REGISTER", 'http://www.webtechglobal.co.uk/login/?action=register' );}
if(!defined( "WEBTECHGLOBAL_LOGIN" ) ){define( "WEBTECHGLOBAL_LOGIN", 'http://www.webtechglobal.co.uk/login/' );}
if(!defined( "WEBTECHGLOBAL_YOUTUBE" ) ){define( "WEBTECHGLOBAL_YOUTUBE", 'https://www.youtube.com/user/WebTechGlobal' );}

// define package constants...                           
if(!defined( "STARCITIZENFANSITEKIT_NAME") ){define( "STARCITIZENFANSITEKIT_NAME", 'Star Citizen Fan Site Kit' );} 
if(!defined( "STARCITIZENFANSITEKIT__FILE__") ){define( "STARCITIZENFANSITEKIT__FILE__", __FILE__);}
if(!defined( "STARCITIZENFANSITEKIT_BASENAME") ){define( "STARCITIZENFANSITEKIT_BASENAME",plugin_basename( STARCITIZENFANSITEKIT__FILE__ ) );}
if(!defined( "STARCITIZENFANSITEKIT_ABSPATH") ){define( "STARCITIZENFANSITEKIT_ABSPATH", plugin_dir_path( __FILE__) );}//C:\AppServ\www\wordpress-testing\wtgplugintemplate\wp-content\plugins\wtgplugintemplate/  
if(!defined( "STARCITIZENFANSITEKIT_PHPVERSIONMINIMUM") ){define( "STARCITIZENFANSITEKIT_PHPVERSIONMINIMUM", '5.3.0' );}// The minimum php version that will allow the plugin to work                                
if(!defined( "STARCITIZENFANSITEKIT_IMAGES_URL") ){define( "STARCITIZENFANSITEKIT_IMAGES_URL",plugins_url( 'images/' , __FILE__ ) );}
if(!defined( "STARCITIZENFANSITEKIT_PORTAL" ) ){define( "STARCITIZENFANSITEKIT_PORTAL", 'http://www.webtechglobal.co.uk/wtg-plugin-framework-wordpress/' );}
if(!defined( "STARCITIZENFANSITEKIT_FORUM" ) ){define( "STARCITIZENFANSITEKIT_FORUM", 'http://forum.webtechglobal.co.uk/viewforum.php?f=43' );}
if(!defined( "STARCITIZENFANSITEKIT_TWITTER" ) ){define( "STARCITIZENFANSITEKIT_TWITTER", 'http://www.twitter.com/WebTechGlobal' );}
if(!defined( "STARCITIZENFANSITEKIT_FACEBOOK" ) ){define( "STARCITIZENFANSITEKIT_FACEBOOK", 'https://www.facebook.com/WebTechGlobal1/' );}
if(!defined( "STARCITIZENFANSITEKIT_YOUTUBEPLAYLIST" ) ){define( "STARCITIZENFANSITEKIT_YOUTUBEPLAYLIST", 'https://www.youtube.com/playlist?list=PLMYhfJnWwPWAh49jnSfNRwR_HSfnhCdF4' );}

// require main class...
require_once( STARCITIZENFANSITEKIT_ABSPATH . 'classes/class-starcitizenfansitekit.php' );

// call the Daddy methods here or remove some lines as a quick configuration approach...
$STARCITIZENFANSITEKIT = new STARCITIZENFANSITEKIT();
$STARCITIZENFANSITEKIT->custom_post_types();

// localization because we all love speaking a little chinese or russian or Klingon!
// Hmm! has anyone ever translated a WP plugin in Klingon?
function starcitizenfansitekit_textdomain() {
    load_plugin_textdomain( 'starcitizenfansitekit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action( 'plugins_loaded', 'starcitizenfansitekit_textdomain' );                                                                                                       
?>