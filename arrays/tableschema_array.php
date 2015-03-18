<?php
/** 
 * Database tables information for past and new versions.
 * 
 * This file is not fully in use yet. The intention is to migrate it to the
 * installation class and rather than an array I will simply store every version
 * of each tables query. Each query can be broken down to compare against existing 
 * tables. I find this array approach too hard to maintain over many plugins.
 * 
 * @todo move this to installation class but also reduce the array to actual queries per version
 * 
 * @package Star Citizen Fan Site Kit
 * @author Ryan Bayne   
 * @since 0.0.1
 * @version 8.1.2
 */

// load in WordPress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
 
 
/*   Column Array Example Returned From "mysql_query( "SHOW COLUMNS FROM..."
        
          array(6) {
            [0]=>
            string(5) "row_id"
            [1]=>
            string(7) "int(11)"
            [2]=>
            string(2) "NO"
            [3]=>
            string(3) "PRI"
            [4]=>
            NULL
            [5]=>
            string(14) "auto_increment"
          }
                  
    +------------+----------+------+-----+---------+----------------+
    | Field      | Type     | Null | Key | Default | Extra          |
    +------------+----------+------+-----+---------+----------------+
    | Id         | int(11)  | NO   | PRI | NULL    | auto_increment |
    | Name       | char(35) | NO   |     |         |                |
    | Country    | char(3)  | NO   | UNI |         |                |
    | District   | char(20) | YES  | MUL |         |                |
    | Population | int(11)  | NO   |     | 0       |                |
    +------------+----------+------+-----+---------+----------------+            
*/
   
global $wpdb;   
$starcitizenfansitekit_tables_array =  array();
##################################################################################
#                                 webtechglobal_log                                         #
##################################################################################        
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['name'] = $wpdb->prefix . 'webtechglobal_log';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['required'] = false;// required for all installations or not (boolean)
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['pluginversion'] = '0.0.1';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['usercreated'] = false;// if the table is created as a result of user actions rather than core installation put true
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['version'] = '0.0.1';// used to force updates based on version alone rather than individual differences
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['primarykey'] = 'row_id';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['uniquekey'] = 'row_id';
// webtechglobal_log - row_id
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['row_id']['type'] = 'bigint(20)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['row_id']['null'] = 'NOT NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['row_id']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['row_id']['default'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['row_id']['extra'] = 'AUTO_INCREMENT';
// webtechglobal_log - outcome
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['outcome']['type'] = 'tinyint(1)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['outcome']['null'] = 'NOT NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['outcome']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['outcome']['default'] = '1';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['outcome']['extra'] = '';
// webtechglobal_log - timestamp
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['timestamp']['type'] = 'timestamp';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['timestamp']['null'] = 'NOT NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['timestamp']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['timestamp']['default'] = 'CURRENT_TIMESTAMP';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['timestamp']['extra'] = '';
// webtechglobal_log - line
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['line']['type'] = 'int(11)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['line']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['line']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['line']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['line']['extra'] = '';
// webtechglobal_log - file
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['file']['type'] = 'varchar(250)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['file']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['file']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['file']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['file']['extra'] = '';
// webtechglobal_log - function
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['function']['type'] = 'varchar(250)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['function']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['function']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['function']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['function']['extra'] = '';
// webtechglobal_log - sqlresult
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlresult']['type'] = 'blob';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlresult']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlresult']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlresult']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlresult']['extra'] = '';
// webtechglobal_log - sqlquery
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlquery']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlquery']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlquery']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlquery']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlquery']['extra'] = '';
// webtechglobal_log - sqlerror
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlerror']['type'] = 'mediumtext';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlerror']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlerror']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlerror']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['sqlerror']['extra'] = '';
// webtechglobal_log - wordpresserror
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['wordpresserror']['type'] = 'mediumtext';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['wordpresserror']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['wordpresserror']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['wordpresserror']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['wordpresserror']['extra'] = '';
// webtechglobal_log - screenshoturl
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['screenshoturl']['type'] = 'varchar(500)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['screenshoturl']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['screenshoturl']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['screenshoturl']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['screenshoturl']['extra'] = '';
// webtechglobal_log - userscomment
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userscomment']['type'] = 'mediumtext';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userscomment']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userscomment']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userscomment']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userscomment']['extra'] = '';
// webtechglobal_log - page
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['page']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['page']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['page']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['page']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['page']['extra'] = '';
// webtechglobal_log - version
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['version']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['version']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['version']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['version']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['version']['extra'] = '';
// webtechglobal_log - panelid
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelid']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelid']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelid']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelid']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelid']['extra'] = '';
// webtechglobal_log - panelname
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelname']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelname']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelname']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelname']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['panelname']['extra'] = '';
// webtechglobal_log - tabscreenid
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenid']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenid']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenid']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenid']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenid']['extra'] = '';
// webtechglobal_log - tabscreenname
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenname']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenname']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenname']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenname']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['tabscreenname']['extra'] = '';
// webtechglobal_log - dump
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['dump']['type'] = 'longblob';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['dump']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['dump']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['dump']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['dump']['extra'] = '';
// webtechglobal_log - ipaddress
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['ipaddress']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['ipaddress']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['ipaddress']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['ipaddress']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['ipaddress']['extra'] = '';
// webtechglobal_log - userid
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userid']['type'] = 'int(11)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userid']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userid']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userid']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['userid']['extra'] = '';
// webtechglobal_log - comment
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['comment']['type'] = 'mediumtext';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['comment']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['comment']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['comment']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['comment']['extra'] = '';
// webtechglobal_log - type
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['type']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['type']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['type']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['type']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['type']['extra'] = '';
// webtechglobal_log - category
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['category']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['category']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['category']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['category']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['category']['extra'] = '';
// webtechglobal_log - action
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['action']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['action']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['action']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['action']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['action']['extra'] = '';
// webtechglobal_log - priority
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['priority']['type'] = 'varchar(45)';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['priority']['null'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['priority']['key'] = '';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['priority']['default'] = 'NULL';
$starcitizenfansitekit_tables_array['tables']['webtechglobal_log']['columns']['priority']['extra'] = '';              
?>