<?php

	class HttpPostUpload{

		public $filetype;
		public $maxfilesize;
		public $destpath;
		public $remotebasepath;
		public $verbosesign;
		public $formfieldname;
		public $allowedtypes;
		public $allowedmimetypes;
		public $maxfiles;
		public $uniquefilenames;

		// konstruktor
		// some usefull presets
		function __construct(){

			$this->verbosesign = "/[\s\"\*\\\'\%\$\&\@\<\>]/";
			$this->maxfilesize = 12*1024*1024;
			$this->uniquefilenames = FALSE;
			$this->chmod = "";
			$this->seed = 1;

			@set_time_limit (0);

		}


		function ProceedUpload(){

			global $_FILES,$HTTP_POST_FILES;
			// 1. Step getting all data

			if($this->formfieldname == ""){
				$this->EndWithError("Couldn'nt find the file, What ist the formfiled name?");
			}

			// check path

			if($this->destpath != "" AND !is_dir($this->destpath)){
				$this->EndWithError("Destination directory not found");
			}

			// checks older php versions
			if(!is_array($_FILES) AND is_array($HTTP_POST_FILES)){
				$THEFILES = $HTTP_POST_FILES;
			} elseif(is_array($_FILES)){
				$THEFILES = $_FILES;
			}


			if($this->maxfiles>1)
                        { // array

				$i=0;
				while($i<$this->maxfiles){//upper was:$this->maxfiles

					$this->clientfilename = $THEFILES[$this->formfieldname]["name"][$i];
					$this->mimetype 	  = $THEFILES[$this->formfieldname]["type"][$i];
					$this->tempfilename   = $THEFILES[$this->formfieldname]["tmp_name"][$i];
					$this->size 		  = $THEFILES[$this->formfieldname]["size"][$i];
                                        $this->picsize 		  = $THEFILES[$this->formfieldname]["size"][0];
					$this->error 		  = $THEFILES[$this->formfieldname]["error"][$i];


					if($this->size<=0){
						$this->log["status"][$i]="No File selected or file to big.";
					} elseif($this->size>$this->maxfilesize) {
						$this->log["status"][$i]="File to big (>".($this->maxfilesize/1000)." )";
					} else{
						$this->OneStep($i);
					}
					$i++;
				}

			} else{
					$this->clientfilename = $THEFILES[$this->formfieldname]["name"];
					$this->mimetype 	  = $THEFILES[$this->formfieldname]["type"];
					$this->size 		  = $THEFILES[$this->formfieldname]["size"];
					$this->tempfilename   = $THEFILES[$this->formfieldname]["tmp_name"];
					$this->error 		  = $THEFILES[$this->formfieldname]["error"];

					if($this->size<=0){
						$this->log["status"][0]="Keine Datei ausgewählt oder Datei zu groß.";
					} elseif($this->size>$this->maxfilesize) {
						$this->log["status"][0]="File to big (>".($this->maxfilesize/1000)." )";
					} else{
						$this->OneStep(0);
					}
			}

		}

		// uploading one file
		function OneStep($number){
			if(!is_uploaded_file($this->tempfilename)){
				return FALSE;
			}
			$this->ReparePhpBug($this->formfieldname);
			$this->Checkdoubledots($this->clientfilename);
			$this->clientfilename = $this->Checkverbosesigns($this->clientfilename);
			$this->filetype = $this->GetFileType($this->clientfilename);
			$this->CheckFileType($this->filetype);
			$this->CheckMimeType($this->mimetype);
			// new filenames
			if($this->uniquefilenames === TRUE){
				$this->filename = $this->MakeUniqueName();
			}
			else {
				$this->filename = $this->clientfilename;
			}
			// copy the file
                        if ($number == 0) $this->pic = $this->filename;
                        if ($number == 1) $this->destpath .= 'thumbs/';
			if(file_exists($this->destpath . $this->filename))
                        {
				$this->log["status"][$number] = "file exists already! ";
			}
			elseif (move_uploaded_file($this->tempfilename, $this->destpath . $this->filename)) 
                        {
				if($this->chmod != "")
                                {
					chmod($this->destpath . $this->filename,$this->chmod);
				}
   			 	$this->log["status"][$number] = "Erfolgreicher Upload";
   			 	$this->log["filename"][$number] = $this->filename;
   			 	$this->log["clientfilename"][$number] = $this->clientfilename;
   			}
			else {
   			 	$this->log["status"][$number] = "Possible file upload attack! ";
    		}
}

		function MakeUniqueName(){
			$uken = date("hms");
		  	mt_srand($uken);
		  	$url = mt_rand().$this->seed.".".$this->filetype;
   			while(file_exists($this->destpath.$url))
	                {
			    $this->seed++;
			    $uken = date("hms");
			    mt_srand($uken);
			    $url = mt_rand().$this->seed.".".$this->filetype;
   			}
   			return $url;
		}

		function EndWithError($msg){
			die($msg);
		}


		// Bugfix for: http://www.securityfocus.com/archive/1/80106
		function ReparePhpBug($formfieldname){

			global $HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_GET_VARS;

			if(	isset($HTTP_COOKIE_VARS[$formfieldname]) ||
			    isset($HTTP_POST_VARS  [$formfieldname]) ||
			    isset($HTTP_GET_VARS   [$formfieldname]) ){
			    	$this->EndWithError("Possible WTF attack");
			    }

		}

		// check about files like  foo.bac.jpg
		function Checkdoubledots($filename){

			if($filename == ""){
				$this->EndWithError("no file selected");
			} elseif(preg_match("/\.+.+\.+/",$filename)){
				$this->EndWithError("filename is not allowed");
			} else {
				return TRUE;
			}
		}

		// delete not allowed sign in the filename
		function Checkverbosesigns($filename){

			if($this->verbosesign != ''){
				$new_filename = preg_replace($this->verbosesign,'',$filename);
			} else {
				$new_filename = $filename;
			}
			$new_filename = strtolower($new_filename);
			return $new_filename;
		}

		// gets the filetyp
		function GetFileType($clientfilename){
			$fileinfo = @pathinfo($clientfilename);
			if(is_array($fileinfo) AND $fileinfo["extension"] != ""){
				return $fileinfo["extension"];
			}
			else{
				$this->EndWithError("no filetype");
			}
		}

		// are the filetypes allowed
		function CheckFileType($filetype){
			if(is_array($this->allowedtypes)){
				if(in_array($filetype,$this->allowedtypes)){
					return TRUE;
				}
				else {
					$this->EndWithError("this filetypes are not allowed to upload");
				}
			}
		}
		
		// are the filetypes allowed
		function CheckMimeType($mimetype){
			if(is_array($this->allowedmimetypes)){
				if(in_array($mimetype,$this->allowedmimetypes)){
					return TRUE;
				}
				else {
					$this->EndWithError("this MIMEtypes are not allowed to upload");
				}
			}
			else {
				$this->EndWithError("allowed MIMEtypes nicht angegeben");
			}
		}		


}



?>
