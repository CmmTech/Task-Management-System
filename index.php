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

?>
<script type="text/javascript" src="/js/login.js"></script>
<div class="login_wrapper">
	<div>
		<img src="/images/login/login_lock.png" width="60px" height="60px" />
		<h2>Login</h2>
	</div>
	<form name="log" id="log" action="" method="POST">
		<table cellpadding="4" border=0>
			<tr>
				<td>
					Username :
				</td>
				<td>
					<input type="text" name="user_name" id="username" maxlength="40" size="30" />
				</td>
			</tr>				
			<tr>
				<td>
					Password :
				</td>
				<td>
					<input type="password" name="password" id="password" maxlength="15" size="30" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input  type="submit" id="login" name="Login" value="Login" />
					<input  type="reset" id="reset" name="Reset" value="Reset" />					
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php					 					
						if(isset($_POST['Login']))
						{
							echo "<span id='err_span' class='err_span err_border'>Invalid Username/Password</span>";
						}
						else
						{
							echo "<span id='err_span' class='err_span'></span>";
						}

					?>
					
				</td>
			</tr>
		</table>
	</form>
</div>



<?php
require('footer.php');
?>

