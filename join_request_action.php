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

$user_id = $_REQUEST['user_id'];
$project_id = $_REQUEST['project_id'];
$action = $_REQUEST['action'];

$this_project = new Project();
$this_project->populateFromId($project_id);

$this_user = new User();
$this_user->populateFromId($user_id);

if( $active_user->id == $this_project->user_id ) {
	if( $action == "approve" ) {
	$this_project->mailEveryone("[ACH] New user in project '" . $this_project->title . "'", "Hello,\r\n\r\n" . $this_user->name . " has joined the project '" . $this_project->title . "':\r\n " . $base_URL . "project/" . $this_project->id . "\r\n\r\n - The ACH Bot");
		$result = mysql_do("INSERT INTO users_in_projects (project_id, user_id) VALUES ('$project_id', '$user_id')");
		$result = mysql_do("INSERT INTO invitation_notices (user_id, by_user_id, project_Id, type, message) VALUES ('$user_id', '$active_user->id', '$project_id', 'approve', '');");
		sendMail($this_user->email, "[ACH] Project join request approved.", "Hello,\r\n\r\nYou have been approved to join project '" . $this_project->title . "':\r\n " . $base_URL . "project/" . $this_project->id . "\r\n\r\n - The ACH Bot");
	} else if( $action == "deny" ) {
		$result = mysql_do("INSERT INTO invitation_notices (user_id, by_user_id, project_Id, type, message) VALUES ('$user_id', '$active_user->id', '$project_id', 'deny', '');");
		sendMail($this_user->email, "[ACH] Project join request denied.", "Hello,\r\n\r\nYou have been denied access to project '" . $this_project->title . "'.\r\n\r\n - The ACH Bot");
	}
	mysql_do("DELETE FROM join_requests WHERE user_id='$user_id' AND project_id='$project_id'");
}

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=<?=$base_URL?>index.php">
</head>



<body>



</body>
</html>