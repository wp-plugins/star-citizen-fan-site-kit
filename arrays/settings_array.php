<?php
/** 
 * Default administration settings for Star Citizen Fan Site Kit plugin. These settings are installed to the 
 * wp_options table and are used from there by default. 
 * 
 * @package Star Citizen Fan Site Kit
 * @author Ryan Bayne   
 * @since 0.0.1
 * @version 1.0.7
 */

// load in WordPress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

// install main admin settings option record
$starcitizenfansitekit_settings = array();
// encoding
$starcitizenfansitekit_settings['standardsettings']['encoding']['type'] = 'utf8';
// admin user interface settings start
$starcitizenfansitekit_settings['standardsettings']['ui_advancedinfo'] = false;// hide advanced user interface information by default
// other
$starcitizenfansitekit_settings['standardsettings']['ecq'] = array();
$starcitizenfansitekit_settings['standardsettings']['chmod'] = '0750';
$starcitizenfansitekit_settings['standardsettings']['systematicpostupdating'] = 'enabled';
// testing and development
$starcitizenfansitekit_settings['standardsettings']['developementinsight'] = 'disabled';
// global switches
$starcitizenfansitekit_settings['standardsettings']['textspinrespinning'] = 'enabled';// disabled stops all text spin re-spinning and sticks to the last spin

##########################################################################################
#                                                                                        #
#                           SETTINGS WITH NO UI OPTION                                   #
#              array key should be the method/function the setting is used in            #
##########################################################################################
$starcitizenfansitekit_settings['create_localmedia_fromlocalimages']['destinationdirectory'] = 'wp-content/uploads/importedmedia/';
 
##########################################################################################
#                                                                                        #
#                            DATA IMPORT AND MANAGEMENT SETTINGS                         #
#                                                                                        #
##########################################################################################
$starcitizenfansitekit_settings['datasettings']['insertlimit'] = 100;

##########################################################################################
#                                                                                        #
#                                    WIDGET SETTINGS                                     #
#                                                                                        #
##########################################################################################
$starcitizenfansitekit_settings['widgetsettings']['dashboardwidgetsswitch'] = 'disabled';

##########################################################################################
#                                                                                        #
#                               CUSTOM POST TYPE SETTINGS                                #
#                                                                                        #
##########################################################################################
$starcitizenfansitekit_settings['posttypes']['wtgflags']['status'] = 'disabled'; 
$starcitizenfansitekit_settings['posttypes']['posts']['status'] = 'disabled';

##########################################################################################
#                                                                                        #
#                                    NOTICE SETTINGS                                     #
#                                                                                        #
##########################################################################################
$starcitizenfansitekit_settings['noticesettings']['wpcorestyle'] = 'enabled';

##########################################################################################
#                                                                                        #
#                           YOUTUBE RELATED SETTINGS                                     #
#                                                                                        #
##########################################################################################
$starcitizenfansitekit_settings['youtubesettings']['defaultcolor'] = '&color1=0x2b405b&color2=0x6b8ab6';
$starcitizenfansitekit_settings['youtubesettings']['defaultborder'] = 'enable';
$starcitizenfansitekit_settings['youtubesettings']['defaultautoplay'] = 'enable';
$starcitizenfansitekit_settings['youtubesettings']['defaultfullscreen'] = 'enable';
$starcitizenfansitekit_settings['youtubesettings']['defaultscriptaccess'] = 'always';

##########################################################################################
#                                                                                        #
#                                  LOG SETTINGS                                          #
#                                                                                        #
##########################################################################################
$starcitizenfansitekit_settings['logsettings']['uselog'] = 1;
$starcitizenfansitekit_settings['logsettings']['loglimit'] = 1000;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['timestamp'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['line'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['function'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['page'] = true; 
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['panelname'] = true;   
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['userid'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['type'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['category'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['action'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['priority'] = true;
$starcitizenfansitekit_settings['logsettings']['logscreen']['displayedcolumns']['comment'] = true;
?>