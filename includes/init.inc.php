<?php
/**
 * Initialize page properties
 */

ob_start();
session_start();

require_once 'config.inc.php';
require_once _ROOT_PATH.'/classes/db.cls.php';
require_once _ROOT_PATH.'/classes/functions.cls.php';
require_once _ROOT_PATH.'/classes/base.cls.php';
require_once _ROOT_PATH.'/classes/Smarty/Smarty.cls.php';


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

$smarty = new Smarty();

$smarty->setTemplateDir(_ROOT_PATH.'/smarty/templates');
$smarty->setCompileDir(_ROOT_PATH.'/smarty/templates_c');
$smarty->setCacheDir(_ROOT_PATH.'/smarty/cache');
$smarty->setConfigDir(_ROOT_PATH.'/smarty/configs');


?>
