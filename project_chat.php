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

$active_user->getProjects();

$id = $_REQUEST['id'];

$active_project = new Project();
$active_project->populateFromId($id);

?>

<html>
<head>
	<title>ACH: Chatting about project "<?=$active_project->title?>"</title>
	<?php include("parts/includes.php"); ?>
	<script language="JavaScript">
	
	chatActive = "y";
	
	</script>
</head>

<body style="background: #DAE3FD;">



<?php if( in_array($active_project->id, $active_user->projects) ) { ?>



<h1 class="chatHead" style="margin-bottom: 50px;">Chatting about project: "<?=$active_project->title?>"</h1>



<div class="sendMessage">

<input type="hidden" id="project_id" value="<?=$active_project->id?>" /><input class="text" type="text" size="60" id="message" onkeydown="return getReturn(event)" /> <input type="submit" value="Say it now &raquo;" onclick="insertMessage();" /> <span id="wheel" class="wheel"></span>

</div>



<div id="messages" class="chatMessages">

<?php showChat($active_project->id); ?>

</div>



<div class="currentUsers">

<?php /* <p class="title"><b>Users currently viewing this project:</b></p>

<div id="activeUsers">

<?php

$page = 'show_active_users.php?project_id=' . $active_project->id;

echo($page);
//include($page);

$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, $page);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);

// display file
echo $file_contents;

?> */ ?>

</div>



<?php } else { ?>

<p style="margin: 20px;">You don't have permission to view this page.</p>

<?php } ?>




</body>
</html>