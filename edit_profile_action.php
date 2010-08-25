<?php
/* ////////////////////////////////////////////////////////////////////////////////
**    Copyright 2010 Matthew Burton, http://matthewburton.org
**    Code by Burton and Joshua Knowles, http://auscillate.com 
**
**    This software is part of the Open Source ACH Project (ACH). You'll find 
**    all current information about project contributors, installation, updates, 
**    bugs and more at http://competinghypotheses.org.
**
**
**    ACH is free software: you can redistribute it and/or modify
**    it under the terms of the GNU General Public License as published by
**    the Free Software Foundation, either version 3 of the License, or
**    (at your option) any later version.
**
**    ACH is distributed in the hope that it will be useful,
**    but WITHOUT ANY WARRANTY; without even the implied warranty of
**    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
**    GNU General Public License for more details.
**
**    You should have received a copy of the GNU General Public License
**    along with Open Source ACH. If not, see <http://www.gnu.org/licenses/>.
//////////////////////////////////////////////////////////////////////////////// */

include("code/includes.php");





$size = 200; // the thumbnail width

$filedir = 'images/user/'; // the directory for the original image
$thumbdir = 'images/user/'; // the directory for the thumbnail image
$prefix = 'profile_'; // the prefix to be added to the original name

$maxfile = '2000000';
$mode = '0666';

$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_size = $_FILES['image']['size'];
$userfile_type = $_FILES['image']['type'];

if (isset($_FILES['image']['name'])) 
{
	$prod_img = $filedir.$userfile_name;

	$prod_img_thumb = $thumbdir.$prefix.$active_user->id.".jpg";
	move_uploaded_file($userfile_tmp, $prod_img);
	chmod ($prod_img, octdec($mode));
	
	$sizes = getimagesize($prod_img);

	$aspect_ratio = $sizes[1]/$sizes[0]; 

	$new_width = $size;
	$new_height = abs($new_width*$aspect_ratio);

	$destimg=ImageCreateTrueColor($new_width,$new_height)
		or die('Problem In Creating image');
	$srcimg=ImageCreateFromJPEG($prod_img)
		or die('Problem In opening Source Image');
	if(function_exists('imagecopyresampled')) {
		imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
		or die('Problem In resizing');
	} else {
		Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
		or die('Problem In resizing');
	}
	ImageJPEG($destimg,$prod_img_thumb,90)
		or die('Problem In saving');
	imagedestroy($destimg);
}







foreach ($_REQUEST as $field => $value) {
	$active_campaign->$field = addslashes($value);
}



setStatusMessage("Added!");

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=profile/<?=$active_user->username?>">
</head>



<body>



</body>
</html>