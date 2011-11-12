<?php
/**
 * @authors	sachin,shine,jonia
 * @copyright   CMM Technologies
 * @date        11-11-2011
 * @file	Login.cls.php
 * @description manipulation of common functions are handled here.
 */

 class Login extends Base
 {
	 public function __construct()
	 {
		parent::__construct();
	 }

 /**
	* This is  method used for validating a login
	* @param string $username username for checking
	* @param string $hash hashed password for checking
    * @return boolean true if vaild log in else false
*/
	public function checkLogin($username,$hash)
	{
		$result = $this->db->getDBContentsBySql("SELECT COUNT(*) AS count FROM tms_users WHERE username='$username' AND PASSWORD='$hash'");
		$count=$result[0]['count'];

		if($count==1)
			return true;
		else 
			return false;

	}
 }
?>