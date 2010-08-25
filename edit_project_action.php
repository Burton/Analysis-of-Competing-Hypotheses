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

$active_project = new Project();

$active_project->populateFromId[$_REQUEST['project_id']];

//if( $active_user->id == $active_project->user_id ) {

	foreach ($_REQUEST as $field => $value) {
		$active_project->$field = addslashes($value);
	}
	
	if( !$active_project->open ) { $active_project->open = "n"; }
	
	$active_project->id = $_REQUEST['project_id'];
	
	if( $active_project->user_id == 0 ) {
		$active_project->user_id = $active_user->id;
	} else {
		$active_project->getNonAdmins();
		if( !in_array($active_user->id, $active_project->nonadmins) ) {
			mysql_do("INSERT INTO users_in_projects (project_id, user_id) VALUES ('$active_project->id', '$active_user->id')");
		}
	}
	
	$active_project->update();
	
	setStatusMessage("Updated!");

//}

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=project/<?=$_REQUEST['project_id']?>/">
</head>



<body>



</body>
</html>