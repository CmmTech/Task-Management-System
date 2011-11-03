<?php
function dbConnect()
{
	

	$con = mysql_connect("localhost","root","") or die("Could not connect to server") ;
	 mysql_select_db("tms") or die("could not select the database");
	 

	
}

?>
