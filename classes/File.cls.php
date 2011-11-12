<?php
/**
 * @author Rony Samuel ,rony@cmmtechnologies.in>
 * @date 17-Oct-2011
 * Class to define functions related to file handling
 */

class File extends Base
{
	/**
	 * To override the max upload size set in config
	 * @var int
	 */
	private $max_upload_size;

	/**
	 * To set the directory path to upload files
	 * @var string
	 */
	private $dir_path;

	/**
	 * To set whether files can be renamed or not
	 * @var boolean
	 */
	private $allow_rename;

	/**
	 * To set whether files can be overwritten
	 * @var boolean
	 */
	private $allow_overwrite;

	/**
	 * If set to true, files cannot be uploaded. Will be set to true, if some error occured while initializing the object
	 * @var boolean
	 */
	private $block_upload = false;

	/**
	 * Allowed file extensions set in config
	 * @var array
	 */
	private $allowed_file_extensions;

	/**
	 * Banned file extensions set in config
	 * @var array
	 */
	private $banned_file_extensions;

	/**
	 * Array to store uploaded file information
	 * Have indexes: name, status, status_code, path ###
	 * name: Name of the file uploaded ###
	 * status: 1 - Success, 0 - Failure ###
	 * status_code: 0 - Error, 1 - Success, 2 - Renamed, 3 - Overwritten, 4 - Already Exist, 5 - Exceeds Size, 6 - Extension Error ###
	 * path: Path of the uploaded file (without file name)
	 * @var array
	 */
	var $upload_info;

	/**
	 * Uploads a file to the default directory with default settings if an array containing information about the file is passed while creating an object. Else, returns void.
	 * @param string $dir [Optional] If set, a directory with the specified name will be created in the upload_path set in config, and the uploaded file will be moved to the new directory. The directory name can or cannot have starting and training slashes(/)
	 * @param string $extension [Optional] (Comma seperated) If set, the file extension(s) will be allowed to be uploaded apart from the list of allowed extensions set in config. This won't work if the extension specified is in the banned list. The extension can or cannot have periods(.)
	 * @param int $max_size [Optional] If a value is passed other than 0, then the specified value will be set as the MAX_UPLOAD_FILE_SIZE overriding the value set in config. This may or may not work depending on server configurations.
	 * @param boolean $allow_overwrite [Optional] If set to true, the uploaded file will be overwritten onto the existing file with the same name, if any.
	 * @param boolean $allow_rename [Optional] If set to true, the uploaded file will be renamed appending numbers (count) to the filename, if any file exist in the same name. This parameter is ignored if $allow_overwrite is set to true
	 */
	function __construct($dir = "", $extension = "", $max_size = 0, $allow_overwrite = false, $allow_rename = true)
	{
		parent::__construct();
		
		/*******	Set the directory for upload	*******/

		$this->dir_path = trim(_FILE_UPLOAD_DIR, "/,\, ")."/";	//	sets class variable with value from config

		if($dir != "")
		{	//	 if a new directory has to be created in the uploaded path
			$dir = $this->dir_path.trim($dir,"/,\, ")."/";

			if(!file_exists($dir))
			{
				try
				{
					if(!mkdir($dir, null, true))
					{
						$this->functions->setErrorMessage("Failed to create directory");
						$this->block_upload = true;
					}
				}
				catch (Exception $e)
				{
					$this->functions->setErrorMessage("Failed to create directory");
					$this->block_upload = true;
				}
			}

			if(!is_dir($dir))
			{	//	 if the created one or existing one is not a directory
				$this->functions->setErrorMessage("Failed to create directory");
				$this->block_upload = true;
			}

			$this->dir_path = $dir;
		}

		/*******	Set the extension list	*******/

		$this->setFileExtensions();	//	sets the class variable with the values from config

		if($extension != "")
		{
			if(!$this->addFileExtension($extension))
			{	//	if extension addition fails
				$this->functions->setErrorMessage("The extension cannot be allowed to upload");
				$this->block_upload = true;
			}
		}

		/*******	Set the max_file_upload_size	*******/
		if($max_size != 0)
			$this->max_upload_size = $max_size;
		else
			$this->max_upload_size = _FILE_MAX_UPLOAD_SIZE;

		/*******	Set whether the file can be overwritten	*******/
		$this->allow_overwrite = $allow_overwrite;

		/*******	Set whether the file can be renamed	*******/
		$this->allow_rename = $allow_rename;
	}

	/**
	 * Uploads a single file to the specified server upload directory
	 * @param array $file The info of the file to be uploaded.
	 * @return boolean True if success, false if error.
	 */
	function uploadFile($file)
	{
		if($this->block_upload)
		{
			$this->functions->setErrorMessage("The file upload has been blocked due to error in initializing object");
			return false;
		}

		/**
		 * to store the status of upload
		 * @var int
		 */
		$upload_status = 0;

		if(is_array($file))
		{//	the variable $file must be an array
			if(isset($file["name"]))
			{//	checks if file information is at the first level
				if(is_array($file["name"]))
				{//	if the array is having multiple files under one associative name
					return $this->uploadMultiFileArray($file);
				}
				else
				{
					return $this->moveUploadedFile($file);
				}
			}
			else
			{// if the passed array is a multidimensional array
				foreach($file as $temp_file)
				{
					if(is_array($temp_file))
					{//	the variable must be an array
						if(isset($temp_file["name"]))
						{// the file information should be at this level
							if(is_array($temp_file["name"]))
							{//	is the array is having multiple file info under one associative name
								$this->uploadMultiFileArray($temp_file);
							}
							else
							{
								$this->moveUploadedFile($temp_file);
							}
						}
						else
						{
							$this->functions->setErrorMessage("The file(s) cannot be uploaded due to some error");
							return false;
						}
					}
					else
					{
						$this->functions->setErrorMessage("The file(s) cannot be uploaded due to some error");
						return false;
					}
				}
			}
		}
		else
		{
			$this->functions->setErrorMessage("The file(s) cannot be uploaded due to some error");
			return false;
		}
	}

	/**
	 * Uploads file to the server folder from a multi dimension array.
	 * Eg: Array([name] => Array([0] => 1.jpg [1] => 2.jpg [2] => .......) [type] => Array([0] => .......))
	 * @param array $multi_file_array
	 */
	private function uploadMultiFileArray($multi_file_array)
	{
		//	TODO: Write code for handling multiple uploads
	}

	/**
	 * Uploads file to the server folder from a single dimension array.
	 * Eg: Array([name] => 1.jpg [type] => .......)
	 * @param array $file Array containing file info
	 * @return boolean Returns true on success, false on failure
	 */
	private function moveUploadedFile($file)
	{
		if($file["error"] > 0)
		{
			$this->upload_info[] = array(	"name"			=>	$file["name"],
											"uploaded_name"	=>	"",
											"status"		=>	0,
											"status_code"	=>	0,
											"server_code"	=>	$file["error"]
										);
			return false;
		}
		else if($file["size"] > $this->max_upload_size)
		{
			$this->upload_info[] = array(	"name"			=>	$file["name"],
											"uploaded_name"	=>	"",
											"status"		=>	0,
											"status_code"	=>	5,
											"server_code"	=>	$file["error"]
										);
			return false;
		}
		else
		{
			$file_name = $file['name'];   
			$file_path = $this->dir_path.$file_name;
			$file_ext = strrchr($file_name,"."); //	gets the extension from the file name
                        
			if(!$this->validateFileExtension($file_ext))
			{
				$this->upload_info[] = array(	"name"			=>	$file["name"],
												"uploaded_name"	=>	"",
												"status"		=>	0,
												"status_code"	=>	6,
												"server_code"	=>	$file["error"]
											);
				return false;
			}

			/**
			 * Set the status code to identify whether the file is overwritten, renamed, or not
			 */
			$status_code = 0;

			if (file_exists($file_path))	//	if file exist, rename it to a new file name
			{
				if(!$this->allow_overwrite)
				{//	if overwrite not allowed
					if($this->allow_rename)
					{
						$incr = 1;	//	incrementer to append a count to the end of the filename
						$new_file_name = "";

						do
						{
							$new_file_name = substr($file_name,0,strripos($file_name,"."))."_".$incr.$file_ext;	//	insert a count at the end of file name and before extension
							$file_path = $this->dir_path.$new_file_name;
							$incr++;
						}while(file_exists($file_path));

						$file_name = $new_file_name;
						$status_code = 2;	//	File Renamed
					}
					else
					{
						$this->upload_info[] = array(	"name"			=>	$file["name"],
														"uploaded_name"	=>	"",
														"status"		=>	0,
														"status_code"	=>	4,
														"server_code"	=>	$file["error"]
													);
						return false;
					}
				}
				else
				{
					$status_code = 3;	//	 File overwritten
				}
			}

			try
			{
				if($status_code == 0)	$status_code = 1;
				
				if(move_uploaded_file($file["tmp_name"], $file_path))
				{
					$this->upload_info[] = array(	"name"			=>	$file["name"],
													"uploaded_name"	=>	$file_name,
													"status"		=>	1,
													"status_code"	=>	$status_code,
													"server_code"	=>	$file["error"]
												);
					return true;
				}
				else
				{
					$this->upload_info[] = array(	"name"			=>	$file["name"],
													"uploaded_name"	=>	"",
													"status"		=>	0,
													"status_code"	=>	0,
													"server_code"	=>	$file["error"]
												);
					return false;
				}
			}
			catch (Exception $e)
			{
				$this->upload_info[] = array(	"name"			=>	$file["name"],
												"uploaded_name"	=>	"",
												"status"		=>	0,
												"status_code"	=>	0,
												"server_code"	=>	$file["error"]
											);
				return false;
			}
		}
	}

	/**
	 * Creates an array with file extensions loaded from config file
	 * @return void
	 */
	private function setFileExtensions()
	{
		//	explodes the extension list string to array
		$allowed_extension_array = explode(",",_FILE_ALLOWED_EXTENSIONS);
		$banned_extension_array = explode(",",_FILE_BANNED_EXTENSIONS);

		foreach($allowed_extension_array as $key=>$val)
		{
			//	trims periods, spaces, commas, and other common escape sequences on each array content
			$allowed_extension_array[$key] = trim($allowed_extension_array[$key]," ,.,\0,\t,\n,\r");
		}

		foreach($banned_extension_array as $key=>$val)
		{
			//	trims periods, spaces, commas, and other common escape sequences on each array content
			$banned_extension_array[$key] = trim($banned_extension_array[$key]," ,.,\0,\t,\n,\r");
		}

		$this->allowed_file_extensions = $allowed_extension_array;
		$this->banned_file_extensions = $banned_extension_array;
	}

	/**
	 * To add an extension to the allowed list
	 * @param string $ext The extension to be added
	 * @return boolean True if the extension is added, else false
	 */
	private function addFileExtension($extension)
	{
		$extensions = explode(",", $extension);

		foreach ($extensions as $key => $val)
		{
			$extensions[$key] = trim($extensions[$key]," ,.,\0,\t,\n,\r");

			if(!in_array($extensions[$key], $this->banned_file_extensions))
			{
				$this->allowed_file_extensions[] = $extensions[$key];
			}
			else
			{//	if the extension is in the banned list
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate an extension and returns if the extension is allowed to upload and not in the banned list
	 * @param string $extension
	 * @return boolean Returns true if the extension can be allowed, else false
	 */
	private function validateFileExtension($extension)
	{
		$extension = trim($extension," ,.,\0,\t,\n,\r");

		if(in_array($extension, $this->allowed_file_extensions) && !in_array($extension, $this->banned_file_extensions))
			return true;
		else
			return false;
	}

	/**
	 * To check if the file upload is blocked due to error. Will return false if no errors exist
	 * @return boolean
	 */
	function isBlocked()
	{
		return $this->block_upload;
	}

	/**
	 * Sets the success, warning & error messages for every file uploaded, depending on the file upload status.
	 * By default, all types of messages are shown, while success & warning messages are consolidated, but error messages shown in details.
	 * @param boolean [Optional] $parse_success If true, success messages will be parsed
	 * @param boolean [Optional] $parse_warning If true, warning messages will be parsed
	 * @param boolean [Optional] $parse_error If true, error messages will be parsed
	 * @param boolean [Optional] $consolidate_success If true, success messages will be consolidated into one message instead of issuing seperately
	 * @param boolean [Optional] $consolidate_warning If true, warning messages will be consolidated into one message instead of issuing seperately
	 * @param boolean [Optional] $consolidate_error If true, error messages will be consolidated into one message instead of issuing seperately
	 * return void
	 */
	function parseUploadMessages($parse_success = true, $parse_warning = true, $parse_error = true, $consolidate_success = true, $consolidate_warning = true, $consolidate_error = false)
	{
		if(!$parse_success && !$parse_warning && !$parse_error)
		{//	if called unwantedly
			return;
		}

		$file_count = count($this->upload_info);

		if($file_count < 1)	//	if no files
			return;

		$success_count = 0;	//	to count the number of files uploaded successfully
		$warning_count = 0;	//	to count the number of files uploaded successfully, but by renaming or overwriting
		$error_count = 0;	//	to count the number of file not uploaded due to errors

		foreach ($this->upload_info as $file)
		{
			if($file["server_code"] == 4)	//	if no files were uploaded
				continue;

			if($file["status"] == 1 && $file["status_code"] == 1)
			{
				if($parse_success)
				{
					if($consolidate_success && $file_count > 1)
					{
						$success_count++;
					}
					else
					{
						$this->functions->setSuccessMessage("File '".$file["uploaded_name"]."' has been uploaded successfully");
					}
				}
			}

			if($file["status"] == 1 && ($file["status_code"] == 2 || $file["status_code"] == 3))
			{
				if($parse_warning)
				{
					if($consolidate_warning && $file_count > 1)
					{
						$warning_count++;
					}
					else
					{
						if($file["status_code"] == 2)
							$this->functions->setWarningMessage("File '".$file["name"]."' has been uploaded successfully, but was renamed to '".$file["uploaded_name"]."'");
						else if($file["status_code"] == 3)
							$this->functions->setWarningMessage("File '".$file["uploaded_name"]."' has been uploaded successfully, but was overwritten");
					}
				}
			}

			if($file["status"] == 0)
			{
				if($parse_error)
				{
					if($consolidate_error && $file_count > 1)
					{
						$error_count++;
					}
					else
					{
						//	to show the max upload size in MB or KB. If size less than 1 MB, then the size will be shown in KB
						$size_str = ($this->max_upload_size/1024/1024) < 1?floor($this->max_upload_size/1024)." KB":($this->max_upload_size/1024/1024)." MB";

						if($file["status_code"] == 0)
							$this->functions->setErrorMessage("File '".$file["name"]."' could not be uploaded");
						else if($file["status_code"] == 4)
							$this->functions->setErrorMessage("File '".$file["name"]."' cannot be uploaded, because another file with the same name already exist");
						else if($file["status_code"] == 5)
							$this->functions->setErrorMessage("File '".$file["name"]."' cannot be uploaded, because the file exceeds maximum allowed size of ".$size_str);
						else if($file["status_code"] == 6)
							$this->functions->setErrorMessage("File '".$file["name"]."' could not be uploaded, because the file type is not allowed to be uploaded.");
					}
				}
			}
		}

		if($parse_success && $consolidate_success)
		{
			if($file_count > 1)
			{
				if($success_count == $file_count)
					$this->functions->setSuccessMessage("All the files has been uploaded successfully");
				else if($success_count > 0)
					$this->functions->setSuccessMessage("$success_count file(s) has been uploaded successfully");
			}
		}

		if($parse_warning && $consolidate_warning)
		{
			if($file_count > 1)
			{
				if($warning_count == $file_count)
					$this->functions->setWarningMessage("All the files has been uploaded successfully, but were renamed or overwritten");
				else if($warning_count > 0)
					$this->functions->setWarningMessage("$warning_count file(s) has been uploaded successfully, but were renamed or overwritten");
			}
		}

		if($parse_error && $consolidate_error)
		{
			if($file_count > 1)
			{
				if($error_count == $file_count)
					$this->functions->setErrorMessage("No files were uploaded to the server due to some error");
				else if($error_count > 0)
					$this->functions->setErrorMessage("$error_count file(s) were not uploaded due to some error");
			}
		}
	}
}
?>