<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<HEAD>
		<TITLE>LOGIN PAGE</TITLE>
		<link rel="stylesheet" href="login.css">	
		<SCRIPT TYPE="TEXT/JAVASCRIPT" SRC="jquery-1.6.2.min.js"></SCRIPT>
		<SCRIPT TYPE="TEXT/JAVASCRIPT"></SCRIPT>
	</HEAD>
	<BODY>
		<SPAN ID="err_msg"></SPAN>
		<DIV id="wrapper">
			<DIV ID="logtop">
				<IMG SRC="images/login_lock.png" width="60px" height="60px" />
				<H2>Login</H2>
			</DIV>
			<FORM NAME="log" ACTION="" METHOD="POST">
				
				<TABLE cellpadding="4">
				<TR>
					<TD>Username</TD><TD>: <INPUT TYPE="TEXT" NAME="user_name" maxlength="40" size="30" /></TD>
				</TR>
				<TR>
					<TD>Password</TD><TD>: <INPUT TYPE="PASSWORD" NAME="pass" maxlength="40" size="30" /></TD>
				</TR>
				<TR>
					<TD colspan="2">
					<INPUT class="btn" TYPE="reset" NAME="Reset" VALUE="Reset" />
					<INPUT class="btn" TYPE="submit" NAME="Login" VALUE="Login" />
					</TD>
				</TR>
				</TABLE>
			</FORM>
		</DIV>
	</BODY>
</HTML>