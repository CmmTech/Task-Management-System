<?php
/**
 * @author	Jayaraj S
 * @copyright   CMM Technologies
 * @date        12-10-2011
 * @file	function.cls.php
 * @description manipulation of common functions are handled here.
 */
 class Functions
 {
    /**
     * This is for recognise developer need single select combo
     * @var int
     */
    public static $_COMBO_SELECT    =   1;

    /**
     * This is for recognise developer need multy select combo
     * @var int
     */
    public static $_COMBO_LIST  =   2;

    /**
     * This is for recognise developer need combo options only
     * @var int
     */
    public static $_COMBO_OPTION_ONLY   =   3;

    /**
     * This is for recognise developer need full combo
     * @var int
     */
    public static $_COMBO_COMPLETE  =   4;



    /**
     * This is for creating single select or multi select combo
     * @param array $data_array array for the combo
     * @param string $index this is the index of the array
     * @param string $value this is the value of the array
     * @param int|array $selected_value selected value for the combo (datatype of $selected_value should be integer if $combo_type is $_COMBO_SELECT and for $_COMBO_LIST the datatype of $selected_value should be array)
     * @param string $return_type its for analising the combo need full option ($_COMBO_COMPLETE for a complete combo and $_COMBO_OPTION_ONLY for only options of the combo)
     * @param string $combo_type its for analysing the combo is single select ($_COMBO_SELECT) or multi select ($_COMBO_LIST)
     * @param string $combo_name for combo name
     * @param string $combo_attribs additional attributes for the combo.
     * @return string a combo.
     */
    function createCombo($data_array,$index,$value,$selected_value="",$return_type,$combo_type="",$combo_name="",$combo_attribs="")
    {
        if($return_type    ==  self::$_COMBO_COMPLETE)
        {
            /**
             * This is for multi selection combo
             * @var string
             */
            $multi_select    =   "";

            if($combo_type==self::$_COMBO_LIST)
                $multi_select    =   "multiple='multiple'";

            if($combo_name) {
                /**
                 * This is for storing the combo
                 * @var string
                 */
                $str        =   "<select $multi_select id='".$combo_name."' name='".$combo_name."' $combo_attribs>";
            }
            else
                $str        =   "<select $multi_select $combo_attribs>";
        }
        else
            $str    =   "";
        $str        .=  "<option value=''>--Select--</option>";
        foreach ($data_array as $array_key	=>	$array_value)
        {
            /**
             * This is for storing the selected option
             * @var string
             */
            $select_flag     =   "";
            if(is_array($selected_value) && $combo_type == self::$_COMBO_LIST)
            {
                if(in_array($array_value[$index], $selected_value))
                    $select_flag     =   "selected=selected";
                else
                    $select_flag     =   "";
            }
            else if(is_array($selected_value) && $combo_type == self::$_COMBO_SELECT)
            {
                if(in_array($array_value[$index], $selected_value))
                    $select_flag     =   "selected=selected";
                else
                    $select_flag     =   "";
            }
            else if(!is_array($selected_value) && $combo_type == self::$_COMBO_SELECT)
            {
                if($array_value[$index] == $selected_value)
                    $select_flag     =   "selected=selected";
                else
                    $select_flag     =   "";
            }
            else if(!is_array($selected_value) && $combo_type == self::$_COMBO_LIST)
            {
                if($array_value[$index] == $selected_value)
                    $select_flag     =   "selected=selected";
                else
                    $select_flag     =   "";
            }
            else {
                // TODO : for the alteration needed later.
            }
            $str    .=  "<option $select_flag value='".$array_value[$index]."'>".ucwords(stripslashes($array_value[$value]))."</option>";
        }
        if($return_type    ==  self::$_COMBO_COMPLETE)
            $str		.=	"</select>";
        return $str;
    }

    /**
     * This is for creating the title of a page
     * @param sting $title the name of the title
     * @return a div containing this title
     */
    function printPageTitle($title)
    {
        return "<div class='pageTitle'>".$title."</div>";
    }

    /**
     * This is for creating the error messages
     * @return all the error messages in a table
     */
    function getErrorMessage()
    {
        if(isset($_SESSION['error_message']))
        {
            /**
             * This is for storing the session array
             * @var array
             */
            $error_message_array    =   $_SESSION['error_message'];

            /**
             * This is for creating the error message
             * @var string
             */
            $response       =   "<table>";

            foreach ($error_message_array as $array_key	=>	$array_value)
            {
                $response   .=  "<tr><td class='error_message'>".$array_value."</td></tr><tr><td class='error_message_seperator'></td></tr>";
            }

            $response       .=   "</table>";

            unset ($_SESSION['error_message']);

            return $response;
        }
    }

    /**
     * This is for creating the error messages
     * @return all the error messages in a table
     */
    function getSuccessMessage()
    {
        if(isset($_SESSION['success_message']))
        {
            /**
             * This is for storing the session array
             * @var array
             */
            $success_message_array    =   $_SESSION['success_message'];

            /**
             * This is for creating the error message
             * @var string
             */
            $response       =   "<table>";

            foreach ($success_message_array as $array_key	=>	$array_value)
            {
                $response   .=  "<tr><td class='success_message'>".$array_value."</td></tr><tr><td class='success_message_seperator'></td></tr>";
            }

            $response       .=   "</table>";

            unset ($_SESSION['success_message']);

            return $response;
        }
    }

    /**
     * This is for creating the warning messages
     * @return all the warning messages in a table
     */
    function getWarningMessages()
    {
        if(isset($_SESSION['warning_message']))
        {
            /**
             * This is for storing the session array
             * @var array
             */
            $warning_message_array    =   $_SESSION['warning_message'];

            /**
             * This is for creating the warning message
             * @var string
             */
            $response       =   "<table>";

            foreach ($warning_message_array as $array_key	=>	$array_value)
            {
                $response   .=  "<tr><td class='warning_message'>".$array_value."</td></tr><tr><td class='warning_message_seperator'></td></tr>";
            }

            $response       .=   "</table>";

            unset ($_SESSION['warning_message']);

            return $response;
        }
    }

    /**
     * Function for assigning warning message to SESSION variable $_SESSION['warning_message']
     * @param string $warning_message The message to be assined to the SESSION variable.It can be a string or single Dimension array.
     * @param boolean  $append [optional] This may be true or false ,if false push the message into the first of an array.Default true.
     * @param boolean  $clear [optional] This may be true or false , if true clear the session array.Default false.
     * @return void.
     */
    function setWarningMessage($warning_message,$append=true,$clear=false)
    {
        if($warning_message!="")
        {
            if($clear == true)
            {
                if(isset($_SESSION['warning_message']))
                {
                    foreach ($_SESSION['warning_message'] as $i => $value) {
                        unset($_SESSION['warning_message'][$i]);
                    }
                    $_SESSION['warning_message'] = array_values($_SESSION['warning_message']);
                }
            }

            if(is_array($warning_message))
            {
                if($append == false) $warning_message =   array_reverse($warning_message);
                foreach($warning_message as $key => $val)
                {
                    if(!is_array($val))
                    {
                        if($append == false)
                            array_unshift($_SESSION['warning_message'], $val);
                        else
                            $_SESSION['warning_message'][]    =   $val;
                    }
                }
            }
            else
            {
                if($append == false)
                {
                    if(isset($_SESSION['warning_message']))
                        array_unshift($_SESSION['warning_message'], $warning_message);
                    else
                        $_SESSION['warning_message'][]    =   $warning_message;
                }
                else
                    $_SESSION['warning_message'][]    =   $warning_message;
            }

            if(isset($_SESSION['warning_message']))
                $_SESSION['warning_message']  = array_values($_SESSION['warning_message']);
            
        }
    }
        
    /**
     * Function for assigning success message to SESSION variable $_SESSION['success_message']
     * @param string $success_message The message to be assined to the SESSION variable.It can be a string or single Dimension array.
     * @param string  $append [optional] This may be true or false ,if false push the message into the first of an array.Default true.
     * @param string  $clear [optional] This may be true or false , if true clear the session array.Default false.
     */
    function setSuccessMessage($success_message,$append=true,$clear=false)
    {
        if($success_message!="")
        {
            if($clear == true)
            {
                if(isset($_SESSION['success_message']))
                {
                    foreach ($_SESSION['success_message'] as $i => $value) {
                        unset($_SESSION['success_message'][$i]);
                    }
                    $_SESSION['success_message'] = array_values($_SESSION['success_message']);
                }
            }

            if(is_array($success_message))
            {
                if($append == false) $success_message =   array_reverse($success_message);
                foreach($success_message as $key => $val)
                {
                    if(!is_array($val))
                    {
                        if($append == false)
                            array_unshift($_SESSION['success_message'], $val);
                        else
                            $_SESSION['success_message'][]    =   $val;
                    }
                }
            }
            else
            {
                if($append == false)
                {
                    if(isset($_SESSION['success_message']))
                        array_unshift($_SESSION['success_message'], $success_message);
                    else
                        $_SESSION['success_message'][]    =   $success_message;
                }
                else
                    $_SESSION['success_message'][]    =   $success_message;
            }

            if(isset($_SESSION['success_message']))
                $_SESSION['success_message']  = array_values($_SESSION['success_message']);

        }
    }

    /**
     * Function for assigning error message to SESSION variable $_SESSION['error_message']
     * @param string  $error_message The message to be assined to the SESSION variable.It can be a string or single Dimension array.
     * @param string  $append [optional] This may be true or false ,if false push the message into the first of an array.Default true.
     * @param string  $clear [optional] This may be true or false , if true clear the session array.Default false.
     */
    function setErrorMessage($error_message,$append=true,$clear=false)
    {
        if($error_message!="")
        {
            if($clear == true)
            {
                if(isset($_SESSION['error_message']))
                {
                    foreach ($_SESSION['error_message'] as $i => $value) {
                        unset($_SESSION['error_message'][$i]);
                    }
                    $_SESSION['error_message'] = array_values($_SESSION['error_message']);
                }
            }

            if(is_array($error_message))
            {
                if($append == false) $error_message =   array_reverse($error_message);
                foreach($error_message as $key => $val)
                {
                    if(!is_array($val))
                    {
                        if($append == false)
                            array_unshift($_SESSION['error_message'], $val);
                        else
                            $_SESSION['error_message'][]    =   $val;
                    }
                }
            }
            else
            {
                if($append == false)
                {
                    if(isset($_SESSION['error_message']))
                        array_unshift($_SESSION['error_message'], $error_message);
                    else
                        $_SESSION['error_message'][]    =   $error_message;
                }
                else
                    $_SESSION['error_message'][]    =   $error_message;
            }

            if(isset($_SESSION['error_message']))
                $_SESSION['error_message']  = array_values($_SESSION['error_message']);

        }
    }
    
}





?>
