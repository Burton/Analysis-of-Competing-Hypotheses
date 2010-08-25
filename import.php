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

?>

<html>
<head>
	<title>ACH: Import PARC ACH file</title>
	<?php include("parts/includes.php"); ?>
</head>

<body onload="setTimeout('Effect.Fade(\'statusMessage\')',2500); setTimeout('Effect.Fade(\'statusMessage2\')',2500); bridge.replaceHeader('BridgeHeader', '1');">



<?php include("parts/header.php"); ?>







<?php
	
if( $active_user->logged_in ) { ?>
	


<?php include("parts/menu_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">

<h2>Import ACH Project</h2>

<p>Use this form to import a project from <a href="http://www2.parc.com/istl/projects/ach/ach.html">previous ACH software</a>.</p>

<p><b>Note:</b> <br />1. The file format must be <b>.achz</b>. An export file of this type may be created by selecting "Save As..." from the "File" menu in the PARC ACH application.<br />
2. The filename must contain alphanumeric characters ONLY. Filenames with special characters will be rejected.</p>

<form method="POST" action="import_action.php" enctype="multipart/form-data">

<h3>ACH .achz File:</h3>

<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

<p><input type="file" name="achz"> Max file size: 3MB</p>

<p><input type="Submit" value="Import Now" class="button"></p>

<p>After importing the ACH file, you will be taken to the Edit Project page to add important details about your matrix.</p>

</form>







<?php } else { ?>



<?php include("parts/login_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">

<h2>Access Denied</h2>

<p>You are not authorized to view this page.</p>


<?php } ?>



			</div>
		</div>
	</div>
</div>







<?php include("parts/footer.php"); ?>





</body>
</html>