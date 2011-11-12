<?php /* Smarty version Smarty 3.1.4, created on 2011-11-12 09:23:00
         compiled from "C:/wamp/www/tms/smarty/templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:121784ebe370b7968d3-11417462%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9567dbf1cd2e975be8194d16e1c7c45ecc45a643' => 
    array (
      0 => 'C:/wamp/www/tms/smarty/templates\\index.tpl',
      1 => 1321089778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121784ebe370b7968d3-11417462',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ebe370bc6d29',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ebe370bc6d29')) {function content_4ebe370bc6d29($_smarty_tpl) {?><script type="text/javascript" src="js/login.js"></script>
<div class="login_wrapper">
	<div>
		<img src="images/login/login_lock.png" width="60px" height="60px" />
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
									 					
						<?php if (isset($_POST['Login'])){?>
							<span id='err_span' class='err_span err_border'>Invalid Username/Password</span>
						
						<?php }else{ ?>
							<span id='err_span' class='err_span'></span>
						<?php }?>

				
					
				</td>
			</tr>
		</table>
	</form>
</div><?php }} ?>