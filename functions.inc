<?php

function checkLogin($username,$password,$con)
{

	$password_hash =md5($password);

	$query="SELECT COUNT(*) FROM USER WHERE USERNAME='$username' AND PASSWORD='$password_hash'";

	$result = mysql_query($query,$con);

	$count = mysql_result($result,0,0);

	if($count==1)

		return true;
	else
		return false;

}


function dbConnect()
{


	$con = mysql_connect("localhost","root","") or die("Could not connect to server") ;
	mysql_select_db("tms") or die("could not select the database");
	
	return $con;

}

?>
