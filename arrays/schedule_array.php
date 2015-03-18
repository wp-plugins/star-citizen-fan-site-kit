<?php
/** 
 * Default schedule array for Star Citizen Fan Site Kit plugin 
 * 
 * @package Star Citizen Fan Site Kit
 * @author Ryan Bayne   
 * @since 0.0.1
 */

// load in WordPress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

$starcitizenfansitekit_schedule_array = array();
// history
$starcitizenfansitekit_schedule_array['history']['lastreturnreason'] = __( 'None', 'starcitizenfansitekit' );
$starcitizenfansitekit_schedule_array['history']['lasteventtime'] = time();
$starcitizenfansitekit_schedule_array['history']['lasteventtype'] = __( 'None', 'starcitizenfansitekit' );
$starcitizenfansitekit_schedule_array['history']['day_lastreset'] = time();
$starcitizenfansitekit_schedule_array['history']['hour_lastreset'] = time();
$starcitizenfansitekit_schedule_array['history']['hourcounter'] = 1;
$starcitizenfansitekit_schedule_array['history']['daycounter'] = 1;
$starcitizenfansitekit_schedule_array['history']['lasteventaction'] = __( 'None', 'starcitizenfansitekit' );
// times/days
$starcitizenfansitekit_schedule_array['days']['monday'] = true;
$starcitizenfansitekit_schedule_array['days']['tuesday'] = true;
$starcitizenfansitekit_schedule_array['days']['wednesday'] = true;
$starcitizenfansitekit_schedule_array['days']['thursday'] = true;
$starcitizenfansitekit_schedule_array['days']['friday'] = true;
$starcitizenfansitekit_schedule_array['days']['saturday'] = true;
$starcitizenfansitekit_schedule_array['days']['sunday'] = true;
// times/hours
$starcitizenfansitekit_schedule_array['hours'][0] = true;
$starcitizenfansitekit_schedule_array['hours'][1] = true;
$starcitizenfansitekit_schedule_array['hours'][2] = true;
$starcitizenfansitekit_schedule_array['hours'][3] = true;
$starcitizenfansitekit_schedule_array['hours'][4] = true;
$starcitizenfansitekit_schedule_array['hours'][5] = true;
$starcitizenfansitekit_schedule_array['hours'][6] = true;
$starcitizenfansitekit_schedule_array['hours'][7] = true;
$starcitizenfansitekit_schedule_array['hours'][8] = true;
$starcitizenfansitekit_schedule_array['hours'][9] = true;
$starcitizenfansitekit_schedule_array['hours'][10] = true;
$starcitizenfansitekit_schedule_array['hours'][11] = true;
$starcitizenfansitekit_schedule_array['hours'][12] = true;
$starcitizenfansitekit_schedule_array['hours'][13] = true;
$starcitizenfansitekit_schedule_array['hours'][14] = true;
$starcitizenfansitekit_schedule_array['hours'][15] = true;
$starcitizenfansitekit_schedule_array['hours'][16] = true;
$starcitizenfansitekit_schedule_array['hours'][17] = true;
$starcitizenfansitekit_schedule_array['hours'][18] = true;
$starcitizenfansitekit_schedule_array['hours'][19] = true;
$starcitizenfansitekit_schedule_array['hours'][20] = true;
$starcitizenfansitekit_schedule_array['hours'][21] = true;
$starcitizenfansitekit_schedule_array['hours'][22] = true;
$starcitizenfansitekit_schedule_array['hours'][23] = true;
// limits
$starcitizenfansitekit_schedule_array['limits']['hour'] = '1000';
$starcitizenfansitekit_schedule_array['limits']['day'] = '5000';
$starcitizenfansitekit_schedule_array['limits']['session'] = '300';
// event types (update event_action() if adding more eventtypes)
// deleteuserswaiting - this is the auto deletion of new users who have not yet activated their account 
$starcitizenfansitekit_schedule_array['eventtypes']['deleteuserswaiting']['name'] = __( 'Delete Users Waiting', 'starcitizenfansitekit' ); 
$starcitizenfansitekit_schedule_array['eventtypes']['deleteuserswaiting']['switch'] = 'disabled';
// send emails - rows are stored in wp_c2pmailing table for mass email campaigns 
$starcitizenfansitekit_schedule_array['eventtypes']['sendemails']['name'] = __( 'Send Emails', 'starcitizenfansitekit' ); 
$starcitizenfansitekit_schedule_array['eventtypes']['sendemails']['switch'] = 'disabled';    
?>