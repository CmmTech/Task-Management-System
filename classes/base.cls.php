<?php
/*
 * @author	Selvaraj Thangavel
 * @date	12-10-2011
 *
 * This class create the DB connection object and object for Functions.cls.php for the use in extended classes
 */
class Base
{
    /**
     * This is for declare the object of DB Class
     * @var object
     */
    protected $db;

    /**
     * This is for declare the object of Function Class
     * @var object
     */

    protected $functions;


    /**
     * This is default method used for get the global variables while create the object of this class
     * @return void
     */
    function __construct()
    { 
        $this->db           =	$GLOBALS['db'];   //Assign the global variable to class variable of DB Class
        $this->functions    =	$GLOBALS['functions'];     //Assign the global variable to class variable of Function Class
    }
}
?>
