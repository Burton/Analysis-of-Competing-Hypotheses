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

$username = $_REQUEST['username'];
$name = $_REQUEST['name'];

$display_user = new User();
$display_user->populateFromAttribute($username, "username");

/* if ($base_URL == "https://ach.bridge-ic.net") {
	header("location: https://gms.bridge-ic.net/manager/index.html#ReadMemberAction?nodeId=$username&type=User");
	}

else { */
?>

	<html>
	<head>
		<title>ACH: <?php if ($display_user->name === NULL) { ?>
	No such user
	<?php } else { ?><?=$display_user->name?>, aka <?=$display_user->username?> <?php } ?></title>
		<?php include("parts/includes.php"); ?>
	</head>
	
	<body onload="setTimeout('Effect.Fade(\'statusMessage\')',2500); setTimeout('Effect.Fade(\'statusMessage2\')',2500);">
	
	
	
	<?php include("parts/header.php"); ?>
	
	
	
	
	
	
	
	<?php
		
	if( $active_user->logged_in ) { ?>
		
	
	
	<?php include("parts/menu_sidebar.php"); ?>
	
	
	
	<div class="mainContainer">
	
	<div class="ydsf left"><div class="inner">
	
	<div class="main">
	
	<?php if ($display_user->name === NULL) { ?>
	<p>This user does not exist.</p>
	<?php } else { ?>
	
	<h2><?=$display_user->name?> 
	<?php if( $active_user->id == $display_user->id ) { ?>
	<a href="<?=$base_URL?>profile/edit">(Edit your profile)</a>
	<?php } ?>
	</h2>
	<?php
	
	$profile_image_path = "/images/user/profile_" . $display_user->id . ".jpg";
	
	?>
	
	<h2><span class="hilight">Public Projects</span></h2>
	
	<?php
	$display_user->getDirectoryProjects();
	
	if( count($display_user->projects) == 0){
		echo "This user is not a member of any public projects.";
		}
		else {
	?>
	
	<?php
	
	for( $i = 0; $i <= count($display_user->projects); $i++ ) {
		$this_project = new Project();
		
		$this_project->populateFromId($display_user->projects[$i]);
		if( $this_project->title != "" ) {
	?>
	
	<div class="projectList">

	<h3><a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> <?php if( in_array($this_project->id, $display_user->owner_of_projects) ) { echo('<span class="isOwner">Owner</span>'); } ?></h3>
	
	<p class="desc"><?=$this_project->description?></p>
	</div>
	<?php } } } }?>
	
<br /><br />	

	
	</div></div>
	
	</div>
	
	
	
	<?php } else { ?>
	
	
	
	<?php include("parts/login_sidebar.php"); ?>
	
	
	
	<div class="mainContainer">
	
	<div class="ydsf left"><div class="inner">
	
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

<?php //} ?>