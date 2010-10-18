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
include("parts/includes.php");

$project_id = $_REQUEST['id'];
$this_project = new Project();
$this_project->populateFromId($project_id);

if( $this_project->open == "y" ) {
	$result = mysql_do("INSERT INTO users_in_projects (project_id, user_id) VALUES ('$project_id', '$active_user->id')");
	$this_project->mailEveryone("[ACH] New user in project '" . $this_project->title . "'", "Hello,\r\n\r\n" . $active_user->name . " has joined the project '" . $this_project->title . "':\r\n" . $base_URL . "project/" . $this_project->id . "\r\n\r\n - The ACH Bot");
} else {
	$result = mysql_do("INSERT INTO join_requests (user_id, project_id) VALUES ('$active_user->id', '$project_id')");
	$project_owner = new User();
	$project_owner->populateFromId($this_project->user_id);

	sendMail($project_owner->email, "[ACH] A user has requested to join your project", "Hello,\r\n\r\n" . $active_user->name . " has requested permission to join your project '" . $this_project->title . "'. To respond, please log into your ACH account here:\r\n" . $base_URL . "\r\n\r\nThanks!\r\n\r\n - The ACH Bot");
	
}

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=project/<?=$project_id?>">
</head>



<body>



</body>
</html>