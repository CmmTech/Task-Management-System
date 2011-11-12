<?php
/*
 * @author	Rony Samuel
 * @date	12-10-2011
 * 
 * This class defines the entire connections and related functions on the DB
 */
class DB
{
    /**
     * Host server name/ip
     * @var string
     */
    private $host;

    /**
     * Database name
     * @var string
     */
    private $db;

    /**
     * DB Server Username
     * @var string
     */
    private $user;

    /**
     * DB Server Password
     * @var string
     */
    private $password;
    
    /**
     * DB Server Connection
     * @var object
     */
    private $connection;

    /**
     * Object of the function class
     * @var object
     */
    private $functions;

    /**
     * Object of the email class
     * @var object
     */
    private $email;

    /**
     * Constructor Function. Connection to the database will be created on the call to this function
     * @param int $new_connection [Optional] To define if a new connection is to be created while another connection exist to the same host. Possible values: _DB_DEFAULT_CONNECTION, _DB_NEW_CONNECTION
     * @param string $new_db The name of the DB to be connected, if other than the one defined in config.inc.php
     * @return object Returns connection object
     */
    function __construct($new_connection = 0, $new_db = "")
    {
        $this->functions    = new Functions();	//	to access the functions from the Function class
        //  $this->email      = new Email();	//	to access the functions of the Email class
        
        $this->host         = _DB_HOST;
        $this->db           = _DB_NAME;
        $this->user         = _DB_USER;
        $this->password     = _DB_PASSWORD;

	//  returns the connection object
        $this->connectDB($new_connection, $new_db);
    }

    /**
     * Function to connect to DB
     * @param int $new_connection [Optional] To define if a new connection is to be created while another connection exist to the same host. Possible values: _DB_DEFAULT_CONNECTION, _DB_NEW_CONNECTION
     * @param string $new_db The name of the DB to be connected, if other than the one defined in config.inc.php
     * @return object Returns connection object
     */
    private function connectDB($new_connection, $new_db)
    {
        if(!$new_connection)
            $this->connection   = mysql_connect($this->host, $this->user, $this->password);
        else	//  if requires a new connection apart form the existing one
            $this->connection   = mysql_connect($this->host, $this->user, $this->password, true);

        if (!$this->connection)
        {	//  if the connection was not success, show error
            $msg                = "Error connecting to server <b>$this->host</b>.<br>".mysql_error();
            $this->functions->setErrorMessage($msg);

            //  if the connection was not success, send a main to the administrator
            $mail_to            = _ADMIN_EMAIL;
            $mail_from          = "From: Administrator "._SYSTEM_EMAIL."\r\n";
            $mail_subject       = _PRODUCT_NAME." ("._HTTP.") - Database Connection Error";
            $mail_body          = "Dear Administrator,\n\nThere was an error connecting to the server $this->host.\n".mysql_error()."\n\nNote : Auto generated email.";

            $this->email->sendMail($mail_to, $mail_subject, $mail_body, $mail_from);

            //	shows the Site Offline Page
            header("Location: "._SITE_OFFLINE_PAGE);
            exit;
	}

        if($new_db != "")	//	if required to select a new DB
            $this->db           = $new_db;

        if (!mysql_select_db($this->db, $this->connection))
        {	//	if selecting DB was not a success
            $msg                = "Error selecting the database <b>$this->db</b>.<br>".mysql_error();
            $this->functions->setErrorMessage($msg);

            $mail_to            = _ADMIN_EMAIL;
            $mail_from          = "From: Administrator "._GENERAL_EMAIL."\r\n";
            $mail_subject       = _PRODUCT_NAME." ("._HTTP.") - Database Connection Error";
            $mail_body          = "Dear Administrator,\n\nThere was an error connecting to the server $this->host.\n".mysql_error()."\n\nNote : Auto generated email.";

            $this->email->sendMail($mail_to, $mail_subject, $mail_body, $mail_from);

            header("Location: "._SITE_OFFLINE_PAGE);
            exit;
        }
    }

    /**
     * Function to fetch data by passing some conditions
     * @param string $table Table name
     * @param string $cond Parameters coming after WHERE condition in sql
     * @return array Returns all fields of the table as a 2D associative array with field name as index
     */
    function getDBContentsByCond($table,$cond)
    {
        if($cond == "")  $cond	= '1';
        $final_sql	=	"SELECT * FROM $table WHERE $cond";
        $final_result	=	mysql_query($final_sql);
        $arr_cnt		=	-1;
        $data_arr	=	array();
        while($temp	= mysql_fetch_assoc($final_result))
        {
            $arr_cnt++;
            $data_arr[$arr_cnt]	=	$temp;
        }
        return $data_arr;
     }

     /**
      * Function to fetch data by passing sql
      * @param string $sql Query to be executed to fetch data
      * @return array Returns selected fields as a 2D associative array with field name as index
      */
    function getDBContentsBySql($sql)
    {
        $sql;
        $final_res		=	mysql_query($sql);
        $arr_cnt		=	-1;
        $data_arr               =	array();
        while($temp	= mysql_fetch_assoc($final_res))
        {
            $arr_cnt++;
            $data_arr[$arr_cnt]	=	$temp;
        }
        return $data_arr;
    }

    /**
     * Function to execute a query
     * @param string $qry Query to be executed
     * @return boolean Returns the query handle for SELECT queries, TRUE/FALSE for other queries, or FALSE on failure.
     */
    function executeQuery($qry)
    {
        return mysql_query($qry);
    }

    /**
      * Function to fetch data by passing result of executed query
      * @param string $res Result of executed query to fetch data
      * @return array Returns Selected fields of table as a 2D associative array with field name as index
      */
    function getDBContentsByExe($res)
    {
        $arr_cnt		=	-1;
        $data_arr	=	array();
        while($temp	= mysql_fetch_assoc($res))
        {
            $arr_cnt++;
            $data_arr[$arr_cnt]	=	$temp;
        }
        return $data_arr;
    }


    /**
     * Function to fetch all the fields of a table by passing primary key value
     * @param string $table Table name
     * @param string $cond Primary key value
     * @return array Returns all fields of the table as a 2D associative array with field name as index
     */
    function getDBcontentsByPrimaryKey($table,$cond)
    {
        $tmpstr		=	$this->get_primarykey($table);
        if($tmpstr	<>	"")
        {
            if($cond == "")  $cond	= '1';
            else $cond	= "$tmpstr = '$cond'";
            $fn_sql	=	"select * from $table where $cond";
            $fn_res	=	mysql_query($fn_sql);
            $arr_cnt	=	-1;
            $data_arr	=	array();
            while($temp	= mysql_fetch_assoc($fn_res))
            {
                $arr_cnt++;
                $data_arr[$arr_cnt]	=	$temp;
            }
        }
        return $data_arr;
    }

    /**
     * Function to get the number of rows in a recordset by passing table name and conditions
     * @param string $table Table name
     * @param string $cond [Optional] Parameters coming after WHERE condition in sql
     * @return integer  Returns the number of rows in a recordset
     */
    function getDBCountByCond($table,$cond="")
    {
        if($cond == "")  $cond	= '1';
        $fn_sql	=	"select * from $table where $cond";
        $fn_res		=	mysql_query($fn_sql);
        return mysql_num_rows($fn_res);
    }

    /**
     * Function to get the number of rows in a recordset by passing a query
     * @param string $sql Query to be executed
     * @return integer  Returns the number of rows in a recordset
     */
    function getDBCountBySql($sql)
    {
        $fn_res		=	mysql_query($sql);
        return mysql_num_rows($fn_res);
    }

    /**
     * Function to get the number of rows in a recordset by passing result of executed query
     * @param string $res result of executed query
     * @return integer  Returns the number of rows in a recordset
     */
    function getDBCountByExe($res)
    {
        return mysql_num_rows($res);
    }


    /**
     * Function to execute an insert query
     * @param string $qry Insert query to be executed
     * @return boolean Returns last inserted id on success or FALSE on failure
     */
    function insertQuery($qry)
    {
        return mysql_query($qry)? mysql_insert_id() : "0";
    }

    /**
     * Function to insert data to a table
     * @param string $table Table name
     * @param string $fields Fields of the table(All the fields are not mandatory)
     * @param string $values values to be entered to the fields
     * @return integer Returns last inserted id on success or FALSE on failure
     */
    function dbInsert($table,$fields,$values)
    {
        $fieldsarr				=	split(",",$fields);//accept the values to array,seperated by commas
        $valuesarr				=	split(",",$values);//accept the values to array,seperated by commas
        if(count($fieldsarr)   !=	count($valuesarr))	return "Error Occured";
        $values_org				=	"";
        
        for($i=0;$i<count($valuesarr);$i++)
        {
            if(strtolower(substr($valuesarr[$i],-6))	==	"escape" &&	strtolower(substr($valuesarr[$i],0,6))	==	"escape")
            {
                $valuesarr[$i]	=	str_replace("escape","",strtolower($valuesarr[$i]));
                $flag_escape	=	"1";
            }
            else
            {
                $flag_escape	=	"0";
            }
            if($i	==	0)
            {
                if($flag_escape	==	"0")
                    $values_org	    =	"'". mysql_real_escape_string($valuesarr[$i])."'";
                else
                    $values_org	    =	$valuesarr[$i];

            }
            else
            {
                if($flag_escape	==	"0")
                    $values_org	   .=	",'".mysql_real_escape_string($valuesarr[$i])."'";
                else
                    $values_org	   .=	",".$valuesarr[$i];
            }
        }
        return (mysql_query("insert into $table($fields) values($values_org)")) ? mysql_insert_id() : "0";
    }

    /**
     * Function to update table by passing table name and SET params
     * @param string $tbname Table name
     * @param string $field SET params in an update query with WHERE condition
     * @param int $log [Optional] 1 for logging ,0 for not
     * @return boolean Returns TRUE on success or FALSE on failure
     */
    function dbUpdate($tbname,$field,$log=0)
    {
        $updatequery	= "update $tbname set $field";
        $query       	= mysql_query($updatequery) or die(mysql_error("Update failed"));
        if($log)
        {// TODO : logging
            if($query)
            {
                $this->logclass->log_update();
                $this->logclass->log_unsetupdate();
            }
            else	$this->logclass->log_unsetupdate();
        }
        return $query;
    }
	
    /**
     * Function to get the primary key of the table
     * @param string $table Table name
     * @return string Returns primary key
     */
    function getPrimaryKey($table)
    {
        $result	=	mysql_query("SELECT * FROM $table where 0");
        $num	=	mysql_num_fields($result);
        for($i=0;$i<$num;$i++)
        {
            if(strstr(mysql_field_flags($result, $i),"primary_key"))
            $primary_key=mysql_field_name($result, $i);
        }
        return $primary_key;
    }
    /**
     * Function to get an object containing information of a field from a recordset
     * @param string $table Table name
     * @param string $field [Optional] Field name. Parameters are name,table,def,max_length,not_null,primary_key,multiple_key,unique_key,numeric,blob,type,unsigned,zerofill
     * @return array Returns an array containing information of a field from a recordset
     */
    function getDBFields($table,$field="")
    {
        $fn_sql		=	"select * from $table where 0";
        $fn_res		=	mysql_query($fn_sql);
        $i			=	0;
        $arr		=	array();
        if($field)
        {
            while($temp	= mysql_fetch_field($fn_res))
            {
                $arr[$i]["$field"]			=	$temp->$field;
                $i++;
            }
        }
        else
        {
            while($temp	= mysql_fetch_field($fn_res))
            {
                $arr[$i]["name"]			=	$temp->name;
                $arr[$i]["table"]			=	$temp->table;
                $arr[$i]["def"]				=	$temp->def;
                $arr[$i]["max_length"]		=	$temp->max_length;
                $arr[$i]["not_null"]		=	$temp->not_null;
                $arr[$i]["primary_key"]		=	$temp->primary_key;
                $arr[$i]["multiple_key"]	=	$temp->multiple_key;
                $arr[$i]["unique_key"]		=	$temp->unique_key;
                $arr[$i]["numeric"]			=	$temp->numeric;
                $arr[$i]["blob"]			=	$temp->blob;
                $arr[$i]["type"]			=	$temp->type;
                $arr[$i]["unsigned"]		=	$temp->unsigned;
                $arr[$i]["zerofill"]		=	$temp->zerofill;
                $i++;
            }
        }
        return $arr;
    }
}
?>
