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


include("code/common_db.php");
include("code/class_user.php");
include("code/functions.php");

$id = $_REQUEST['id'];
$name = $_REQUEST['name'];
$campaign_id = $_REQUEST['campaign_id'];
$email_address = $_REQUEST['email_address'];
$outgoing_message = $_REQUEST['outgoing_message'];

mysql_do("UPDATE campaigns SET name='$name', campaign_id='$campaign_id', outgoing_message='$outgoing_message', email_address='$email_address' WHERE id='$id';");

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=campaign/<?=$id?>">
</head>



<body>



</body>
</html>