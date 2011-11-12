<?php
/**
 * Initialize page properties
 */

ob_start();
session_start();

require_once 'config.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.cls.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/functions.cls.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/base.cls.php';


/**
 * DB class object
 * @var object
 */
$db = new DB();
/**
 * Function class object
 * @var object
 */
$functions = new Functions();


?>
