<?php
/**
 * @author Name
 * @version	
 * @date 
 * @copyright 
 */
require_once('includes/init.inc.php');
require('header.php');
require_once('classes/Login.cls.php');
$login = new Login();



if(isset($_POST['Login']))
{
	$user = $_POST['user_name'];
	$passhash =  md5($_POST['password']);

	if( $login->checkLogin($user,$passhash) )
	{
		echo'yes';
		die();
	}
}

$smarty->display('index.tpl');


?>




<?php
require('footer.php');
?>

