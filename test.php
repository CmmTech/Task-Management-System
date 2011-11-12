<?php
require_once('includes/init.inc.php');
require_once('classes/Login.cls.php');

$login= new Login();
if($login->checkLogin("test1",md5("s6hine")))
	echo "yaaaaaaaaaaa";



?>