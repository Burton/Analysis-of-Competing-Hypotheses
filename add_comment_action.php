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

//THIS FILE IS CALLED WHEN COMMENTS ARE POSTED TO MESSAGE BOARDS
include("code/includes.php");
include("parts/includes.php");

$previous_page = $_REQUEST['this_url'];

$this_comment = new Comment();

foreach ($_REQUEST as $field => $value) {
	$this_comment->$field = addslashes($value);
}

$this_comment->user_id = $active_user->id;

$this_comment->insertNew();

setStatusMessage("Added!");

if( $_REQUEST['reply_to_id'] > 0 ) {
	$reply_comment = new Comment();
	$reply_comment->populateFromId($_REQUEST['reply_to_id']);
	$this_user = new User();
	$this_user->populateFromId($reply_comment->user_id);

	sendMail($this_user->email, "[ACH] Someone repied to your comment.", "Hello,\r\n\r\n" . $active_user->name . " has replied to your comment here:\r\n" . $base_URL . $previous_page . "#comment_" . $this_comment->id . "\r\n\r\n - The ACH Bot");

}

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=<?=$previous_page?>#comment_<?=$this_comment->id?>">
</head>



<body>



</body>
</html>