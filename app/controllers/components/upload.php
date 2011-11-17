<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UploadComponent  extends Object{

var $data;
var $upload_dir; 				// The directory for the images to be saved in
var $upload_path;				// The path to where the image will be saved
var $large_image_name; 		// New name of the large image
var $thumb_image_name; 	// New name of the thumbnail image
var $max_file; 						// Approx 1MB
var $max_width;							// Max width allowed for the large image
var $thumb_width;						// Width of thumbnail image
var $thumb_height;						// Height of thumbnail image
var $error;


function UploadComponent($upload_dir = "",$upload_path = "", $large_image_name="",$thumb_image_name="", $max_file= "", $max_width= "", $thumb_width="",$thumb_height=""){

        if(isset($upload_dir) and !empty($upload_dir)){

            $this->upload_dir = $upload_dir;
        }else{

            $this->upload_dir = "D:\webroot\HotelMS\app\webroot\uploads\hotels\\";
        }


        if(isset($upload_dir) and !empty($upload_path)){

            $this->upload_path = $upload_path;
        }else{

            $this->upload_path = $this->upload_dir."/";
        }


        if(isset($large_image_name) and !empty($large_image_name)){
            $this->large_image_name = $large_image_name;
        }else{
            $this->large_image_name = "resized_pic.jpg";
        }

        if(isset($thumb_image_name) and !empty($thumb_image_name)){

            $this->thumb_image_name = $thumb_image_name;
        }else{
            $this->thumb_image_name = "thumbnail_pic.jpg";
        }


        if(isset($max_file) and !empty($max_file)){
            $this->max_file = $max_file;

        }else{
            $this->max_file = "1148576";

        }


         if(isset($max_width) and !empty($max_width)){

             $this->max_width = $max_width;
         }else{

             $this->max_width = "500";
         }

        if(isset($thumb_width) and !empty($thumb_width)){
            $this->thumb_width = $thumb_width;
        }else{
            $this->thumb_width = "100";
        }

        

        if(isset($thumb_height) and !empty($thumb_height)){

            $this->thumb_height = $thumb_height;
        }else{
            $this->thumb_height = "100";
        }

}

function _resizeImage($image,$width,$height,$scale) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,90);
	chmod($image, 0777);
	return $image;
}



function _resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$thumb_image_name,90);
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

function _getHeight($image) {
	$sizes = getimagesize($image);
	$height = $sizes[1];
	return $height;
}

function _getWidth($image) {
	$sizes = getimagesize($image);
	$width = $sizes[0];
	return $width;
}

function getError(){
    
    return $this->error;
}

function _uploadExe(){
    //Image Locations
$large_image_location = $this->upload_path.$this->large_image_name;
$thumb_image_location = $this->upload_path.$this->thumb_image_name;

 
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($this->upload_dir)){
  
	mkdir($this->upload_dir, 0777);
	chmod($this->upload_dir, 0777);
}

//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){

	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
              
	}else{
		$thumb_photo_exists = "";
              
	}
   	$large_photo_exists = "<img src=\"".$this->upload_path.$this->large_image_name."\" alt=\"Large Image\"/>";
        
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";

}

if (isset($this->data['Hotel']['img']['name'])) {

	//Get the file information
	$userfile_name = $this->data['Hotel']['img']['name'];
	$userfile_tmp = $this->data['Hotel']['img']['tmp_name'];
	$userfile_size = $this->data['Hotel']['img']['size'];
	$filename = basename($this->data['Hotel']['img']['name']);
        $error = $this->data['Hotel']['img']['error'];
	$file_ext = substr($filename, strrpos($filename, '.') + 1);

	//Only process if the file is a JPG and below the allowed limit
	if((!empty($userfile_name)) && ($error == 0)) {
		if (($file_ext!="jpg") && ($userfile_size > $max_file)) {
			$this->error[]= "ONLY jpeg images under 1MB are accepted for upload";
		}
	}else{
		$this->error[]= "Select a jpeg image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (count($this->error)==0){

		if (isset($userfile_name)){

			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);

			$width = $this->_getWidth($large_image_location);
			$height = $this->_getHeight($large_image_location);
			//Scale the image if it is greater than the width set above

                        
			if ($width > $this->max_width){
				$scale = $this->max_width/$width;
				$uploaded = $this->_resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = $this->_resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
		header("location:".$_SERVER["PHP_SELF"]);
		exit();
	}
}

if (isset($this->data['upload_thumbnail']) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 =  $_POST["x1"];
	$y1 =  $_POST["y1"];
	$x2 =  $_POST["x2"];
	$y2 =  $_POST["y2"];
	$w  =  $_POST["w"];
	$h  =  $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = $this->_resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail
	header("location:".$_SERVER["PHP_SELF"]);
	exit();
}

if (isset($_GET['a']) and $_GET['a']=="delete"){
	if (file_exists($large_image_location)) {
		unlink($large_image_location);
	}
	if (file_exists($thumb_image_location)) {
		unlink($thumb_image_location);
	}
	header("location:".$_SERVER["PHP_SELF"]);
	exit();
}

}
}
?>
