<?php
/**
 * This file defines the constant variables used in different sections throughout the project
 * @author Rony Samuel
 * @copyright CMM Technologies Pvt. Ltd.
 * @category includes
 * @version 1.0.0
 * 
 */

#################################################################################
# Path Settings

/**
 * [CONSTANT VAR] The URL of the application
 * @global string
 */
define("_HTTP", "http://TMS.cmm.local/");

/**
 * [CONSTANT VAR] The URL to the administration area of the application
 * @global string
 */
define("_ADMINISTRATION", "http://jobs.cmm.local/back_office");

/**
 * [CONSTANT VAR] The root folder of the application in the server
 * @global string
 */
define("_ROOT_PATH","/jobapplication/");

/**
 * [CONSTANT VAR] Defines whether the running server is a production server or not
 * @global int
 */
define("_LIVE_SERVER",0);

#################################################################################
# Product Settings

/**
 * [CONSTANT VAR] Name of the application (product)
 * @global string
 */
define("_PRODUCT_NAME", "Task Management System");

/**
 * [CONSTANT VAR] Short name of the application
 * @global string
 */
define("_SHORT_PRODUCT_NAME", "TMS");

/**
 * [CONSTANT VAR] Version of the product
 * @global string
 */
define("_VERSION", "Pre-alpha 1.0.0");

/**
 * [CONSTANT VAR] Title text that appears at the browser title bar
 * @global string
 */
define("_WINDOW_TITLE", "Task Management System");


#################################################################################
# Database Settings

/**
 * [CONSTANT VAR] Database server name/ip
 * @global string
 */
define("_DB_HOST", "cmm.local");

/**
 * [CONSTANT VAR] Database name
 * @global string
 */
define("_DB_NAME", "training");

/**
 * [CONSTANT VAR] DB server username
 * @global string
 */
define("_DB_USER", "training");

/**
 * [CONSTANT VAR] DB server password
 * @global string
 */
define("_DB_PASSWORD", "train@CMM");


#################################################################################
# Session & Cookie Settings

/**
 * [CONSTANT VAR] The prefix to appended before every session variable name
 * @global string
 */
define("_SESSION_PREFIX", "TMS_");

/**
 * [CONSTANT VAR] The prefix to appended before every cookie variable name
 * @global string
 */
define("_COOKIE_PREFIX", "TMS_");


#################################################################################
# File Settings

/**
 * [CONSTANT VAR] Path to which the uploaded files are moved
 * @global string
 */
define("_FILE_UPLOAD_DIR", "/upload_files/");

/**
 * [CONSTANT VAR] Max file upload size allowed (in bytes).
 * Eg: For 2 MB, provide the value 2(MB)*1024(KB)*1024(Bytes) = 2097152
 * @global int
 */
define("_FILE_MAX_UPLOAD_SIZE", 5242880);	//	5 MB

/**
 * [CONSTANT VAR] Allowed file extensions to be uploaded (Comma sperated)
 * @global string
 */
define("_FILE_ALLOWED_EXTENSIONS","doc,docx,pdf,jpg,jpeg,png,gif,bmp");

/**
 * [CONSTANT VAR] File extensions that is banned from uploading even if the above values are overrided in the function calls (Comma sperated)
 * @global string
 */
define("_FILE_BANNED_EXTENSIONS","php,php3,phtml,html,js,css,exe");

#################################################################################
# Client Details

/**
 * [CONSTANT VAR] Name of the client company
 * @global string
 */
define("_CLIENT_NAME", "United Indian School");

/**
 * [CONSTANT VAR] Address of the client company
 * @global string
 */
define("_CLIENT_ADDRESS", "UIS Campus, Jleeb Al Shuyoukh, Kuwait.");

/**
 * [CONSTANT VAR] Phone # of the client company
 * @global string
 */
define("_CLIENT_PHONE", "+965-2222222");

/**
 * [CONSTANT VAR] Contact e-mail of the client company
 * @global string
 */
define("_CLIENT_EMAIL", "admin@uis.com");


#################################################################################
# Date Settings

/**
 * [CONSTANT VAR] Date format to be used in forms
 * @global string
 */
define("_DATE_FORMAT", "d-m-Y");

/**
 * [CONSTANT VAR] Date format to be used in reports and listings
 * @global string
 */
define("_DATE_DISPLAY_FORMAT", "d-M-Y");





#################################################################################
# Email Settings

/**
 * [CONSTANT VAR] Administrator Email address
 * @global string
 */
define("_ADMIN_EMAIL", "admin@cmmtechnologies.in");

/**
 * [CONSTANT VAR] Email address for use in From address when specific mails are sent
 * @global string
 */
define("_FROM_EMAIL", "admin@cmmtechnologies.in");

/**
 * [CONSTANT VAR] Email address for use in From address when common mails are sent
 * @global string
 */
define("_SYSTEM_EMAIL", "noreply@cmmtechnologies.in");



#################################################################################
# Pagination Settings

/**
 * [CONSTANT VAR] Number of records to be displayed per page in listing pages
 * @global int
 */
define("_NO_OF_RECORDS_PER_PAGE", 50);



?>
