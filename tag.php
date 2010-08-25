<!--THIS FILE IS DEPRECATED
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

$tag = $_REQUEST['tag'];

?>

<html>
<head>
	<title>ACH</title>
	<?php include("parts/includes.php"); ?>
</head>

<body onload="setTimeout('Effect.Fade(\'statusMessage\')',2500); setTimeout('Effect.Fade(\'statusMessage2\')',2500);">



<?php include("parts/header.php"); ?>







<?php
	
if( $active_user->logged_in ) { ?>
	


<?php include("parts/menu_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">

<h2>Classes matching "<span class="hilight"><?=$tag?></span>"</h2>



<?php

$tag_space = $tag . " ";

$result = mysql_do("SELECT * FROM classes WHERE tags LIKE '%$tag_space%'");
while($query_data = mysql_fetch_array($result)) {
	$this_teacher = new User();
	$this_teacher->populateFromID($query_data['user_id']);

?>

<p><a href="<?=$base_URL?>/class/<?=$query_data['id']?>"><?=$query_data['title']?></a><br />
<span class="classListInfo">Taught by <a href="<?=$base_URL?>/profile/<?=$this_teacher->username?>"><?=$this_teacher->name?></a><br />
Starts <a href="">June 1st, 2007</a></span></p>

<?php } ?>



</div>

</div></div>

</div>



<?php } else { ?>



<?php include("parts/login_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">

<h2>Access Denied</h2>

<p>You are not authorized to view this page.</p>

</div>

</div></div>

</div>

<?php } ?>



</div>

</div></div>

</div>







<?php include("parts/footer.php"); ?>





</body>
</html>