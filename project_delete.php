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

$id = $_REQUEST['id'];
$part = $_REQUEST['part'];

$active_project = new Project();
$active_project->populateFromID($id);

$can_delete = FALSE;

// User must be owner and they must get to this page via the Delete link on the project page.

include("parts/includes.php");

if( $active_user->id == $active_project->user_id && substr($_SERVER['HTTP_REFERER'], 0, strlen("$base_URL/project/")) == "$base_URL/project/" ) {
	$can_delete = TRUE;
	$active_project->delete();
}


?>

<html>
<head>
	<title>Deleting...</title>
	<script language="JavaScript">
	
<?php if( $can_delete ) { ?>
alert("Project deleted.");
<?php } else { ?>
alert("Could not delete.");
<?php } ?>
location.href = "/";
	
	</script>
</head>



<body>



</body>
</html>