<?php
error_reporting(E_ALL);											// Disable PHP error messages in production

/*
 * General system setup
 * You are required to change these values for the setup of the system.
 */
$conf['conf']['installed'] = TRUE;									// Set to true to enable system
$conf['conf']['debugging'] = FALSE;									// Set TRUE to enable debugging
$conf['conf']['institutionName'] = "CoreLink"; 				// Institution name
$conf['conf']['organization'] = "CoreLink"; 					// Institution name
$conf['conf']['domain'] = "corelink.co.zm";						// Domain on which the pages will be served
$conf['conf']['mailEnabled'] = TRUE;								// Whether to enable in-system mailclient
$conf['conf']['hash'] = "2#FCLWJEFO2j3@K#LKF";						// Change this to a unique random set of characters
$conf['conf']['titleName'] = "CoreLink Consulting Ltd. | ERP"; 	// Default Page Title
$conf['conf']['systemMail'] = "info@corelink.co.zm"; 					// System email
$conf['conf']['path'] = "https://www.corelink.co.zm/management"; 			// Change to the installation path of Edurole on webserver (example: www.example.com/pathtosystem) would be /pathtosystem.
$conf['conf']['currency'] = "ZMW"; 									// Used Currency
$conf['conf']['language'] = "ENG"; 									// Used LANG


$conf['institution']['head'] = "Prof....";
$conf['institution']['title'] = "Vice Chancellor";

/*
 * Update repository server
 */
$conf['conf']['updates']['server'] = "http://edurole.com/update/";	// Update server

/*
 * MYSQL server information
 */
$conf['mysql']['server'] = "localhost"; 					// MySQL server host
$conf['mysql']['user'] = "root"; 						// MySQL user
$conf['mysql']['password'] = 'MysqlSERVER$2019SC*RE'; 					// MySQL password
$conf['mysql']['db'] = "corelink"; 									// MySQL database
							

/*
 * SMS server information
 */ 
$conf['sms']['server'] = "https://www.probasesms.com/api/json/commercials/sms/send-bulk"; 		// SMS server host
$conf['sms']['user'] = "George Benson"; 						// SMS user
$conf['sms']['password'] = "Ed3nUni"; 					// SMS password
$conf['sms']['name'] = "George Benson"; 									// SMS Sender Name
$conf['sms']['source'] = "George Benson University"; 							// SMS source Name


/*
 * LDAP server information
 */
$conf['ldap']['ldapEnabled'] = TRUE; 							// Enable LDAP integration or not
$conf['ldap']['server'] = "George Bensondc01.George Benson.edu.zm"; 				// LDAP host
$conf['ldap']['port'] = "389"; 									// LDAP server port
$conf['ldap']['domain']    = "dc=George Benson,dc=edu,dc=zm"; 			// Dedicated OU is needed for students
$conf['ldap']['studentou'] = "George Benson_Students"; 					// Dedicated OU is needed for students
$conf['ldap']['staffou']   = "ou=staff"; 						// Dedicated OU is needed for staff
$conf['ldap']['adminou']   = "ou=administrators"; 				// Dedicated OU is needed for administrators

/*
 * Moodle information
 */ 
$conf['moodle']['url'] = "http://www.George Benson.edu.zm/moodle"; 		// Moodle host url
$conf['moodle']['database'] = "elearning"; 						// Moodle database
$conf['moodle']['prefix'] = "eln"; 								// Moodle table prefix 
$conf['moodle']['path'] = "/data/website/moodle/"; 				// Moodle file path


/*
 * Mail server information
 */
$conf['mail']['server'] = "mail.George Bensonuniversity.edu.zm"; 		// IMAP server address
$conf['mail']['port'] = "465"; 									// IMAP port

/*
 * System paths
 */
$conf['conf']['corePath'] = "system/"; 
$conf['conf']['classPath'] = "system/classes/"; 				// Location for classes
$conf['conf']['viewPath'] = "system/views/"; 					// Location for views
$conf['conf']['libPath'] = "lib/"; 								// Location for forms
$conf['conf']['servicePath'] = "system/services/"; 				// Location for services
$conf['conf']['formPath'] = "system/forms/"; 					// Location for forms
$conf['conf']['templatePath'] = "templates/"; 					// Location for templates
$conf['conf']['dataStorePath'] = getcwd() . "/datastore/"; 		// Datastore location (userhomes, identities, etc.)


/*
 * Enabled templates, default is first template listed
 */
$conf['conf']['templates'] = array("mobile", "mobileold");			// Template names in array form

/*
 * CSS available to the system, required is included everywhere header is active
 */
$conf['css']['required'] = array( "style", "bootstrap", "ddslick", "chat");

$conf['css']['bootstrap'] = '<link href="%BASE%/templates/%TEMPLATE%/css/bootstrap.css" rel="stylesheet" type="text/css" />';
$conf['css']['style'] = '<link href="%BASE%/templates/%TEMPLATE%/css/style.css" rel="stylesheet" type="text/css" />';
$conf['css']['ddslick'] = '<link href="%BASE%/templates/%TEMPLATE%/css/ddSlick.css" rel="stylesheet" type="text/css" />';
$conf['css']['jq'] = '<link href="%BASE%/templates/%TEMPLATE%/css/jq.css" rel="stylesheet" type="text/css" />';
$conf['css']['login'] = '<link href="%BASE%/templates/%TEMPLATE%/css/login.css" rel="stylesheet" type="text/css" />';
$conf['css']['fullcalendar'] = '<link href="%BASE%/lib/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />';
$conf['css']['fullcalendar.print'] = '<link href="%BASE%/lib/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print" />';
$conf['css']['aloha'] = '<link href="%BASE%/lib/aloha/css/aloha.css" rel="stylesheet" type="text/css" />';
$conf['css']['autocomplete'] = '<link href="%BASE%/lib/autocomplete/autocomplete.css" rel="stylesheet" type="text/css" />';
$conf['css']['chat'] = '<link href="%BASE%/templates/%TEMPLATE%/css/chat.css" rel="stylesheet" type="text/css" />';

/*
 * Javascript available to the system, required is included everywhere header is active
 */
$conf['javascript']['required'] = array("mail", "jquery.dropdown", "bootstrap", "jquery");


$conf['javascript']['jquery'] = '<script type="text/javascript" src="%BASE%/lib/jquery/jquery.js"></script>';
$conf['javascript']['bootstrap'] = '<script type="text/javascript" src="%BASE%/lib/bootstrap/bootstrap.js"></script>';
$conf['javascript']['jquery.dropdown'] = '<script type="text/javascript" src="%BASE%/lib/jquery/jquery.dropdown.js"></script>';
$conf['javascript']['mail'] = '<script type="text/javascript" src="%BASE%/lib/edurole/javascript/mail.js"></script>';
$conf['javascript']['jquery.ui'] = '<script type="text/javascript" src="%BASE%/lib/jquery/jquery.ui.core.js"></script>';
$conf['javascript']['jquery.ui.widget'] = '<script type="text/javascript" src="%BASE%/lib/jquery/jquery.ui.widget.js"></script>';
$conf['javascript']['jquery.ui.datepicker'] = '<script type="text/javascript" src="%BASE%/lib/jquery/jquery.ui.datepicker.js"></script>';
$conf['javascript']['require'] = '<script type="text/javascript" src="%BASE%/lib/requirejs/require.js"></script>';
$conf['javascript']['aloha'] = '<script src="%BASE%/lib/aloha/lib/aloha.js" data-aloha-plugins="common/ui,  common/format, common/list, common/link, common/highlighteditables"></script>';
$conf['javascript']['fullcalendar'] = '<script type="text/javascript" src="%BASE%/lib/fullcalendar/fullcalendar.min.js"></script>';
$conf['javascript']['register'] = '<script type="text/javascript" src="%BASE%/lib/edurole/javascript/register.js"></script>';
$conf['javascript']['jquery.form-repeater'] = '<script type="text/javascript" src="%BASE%/lib/jquery/jquery.form-repeater.js"></script>';
$conf['javascript']['jquery.ui.dialog'] = '<script type="text/javascript" src="%BASE%/lib/jquery/jquery.ui.dialog.js"></script>';
$conf['javascript']['jquery.autocomplete'] = '<script type="text/javascript" src="%BASE%/lib/autocomplete/jquery.autocomplete.js"></script>';

?>
