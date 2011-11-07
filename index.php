<?php
require("functions.inc");
if(isset($_POST['Login']))
{
	$connection = dbConnect();
	$username=$_POST['user_name'];
	$password=$_POST['password'];
	if(checkLogin($username,$password,$connection))
	{
		//header(""); 
		echo  "yooooooooooooo! Login sucessfull!";
		die();
	}
	
}

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE>Task Management System - Log In</TITLE>
		<link rel="stylesheet" href="login.css">	
		<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="jquery-1.6.2.min.js"></SCRIPT>
	    <SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="login.js"></SCRIPT>
	</HEAD>
	<BODY>
		
		<DIV id="wrapper">
			<DIV ID="logtop">
				<IMG SRC="images/login_lock.png" width="60px" height="60px" />
				<H2>Login</H2>
			</DIV>
			<FORM NAME="log" ID="log" ACTION="" METHOD="POST">
				
				<TABLE cellpadding="4">
				<TR>
					<TD>
						Username
					</TD>
					<TD>
						: <INPUT TYPE="TEXT" NAME="user_name" ID="username" maxlength="40" size="30" />
					</TD>
				</TR>
				<TR>
					<TD>Password</TD><TD>: <INPUT TYPE="PASSWORD" NAME="password" ID="password" maxlength="15" size="30" /></TD>
				</TR>
				<TR>
					<TD colspan="2">
					<INPUT class="btn" TYPE="submit" ID="login" NAME="Login" VALUE="Login" />
					<INPUT class="btn" TYPE="reset" ID="reset" NAME="Reset" VALUE="Reset" />					
					</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">
					<?php					 					
					if(isset($_POST['Login']))
					{
						echo "<SPAN ID='err_span' class='err_span err_border'>Invalid Username/Password</SPAN>";
					}
					else
					{
						echo "<SPAN ID='err_span'class='err_span'></span>";
					}

					?>
					
					</TD>
				</TR>
				</TABLE>
			</FORM>
		</DIV>
	</BODY>
</HTML>
