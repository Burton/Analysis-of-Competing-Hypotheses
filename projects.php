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

$display_user = new User();
$display_user->populateFromAttribute($username, "username");

?>

<html>
<head>
	<title>ACH: Project Directory</title>
	<?php include("parts/includes.php"); ?>
</head>


<?php include("parts/header.php"); ?>







<?php
	
if( $active_user->logged_in ) { ?>
	


<?php include("parts/menu_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">

			<h2>Browse Public Projects</h2>
			
			<p>The projects below may be viewed by anyone.<br />
			Those with a lock (
			<span class="closed"><img src="<?=$base_URL?>/images/icons/lock.png" alt="Closed" /></span>
			) are still publicly viewable, but require the owner's permission for you to join.</p>
			
			<?php
			
			$active_user->getProjects();
			
			$result = mysql_do("SELECT * FROM projects WHERE directory='y' ORDER BY title");
			while($query_data = mysql_fetch_array($result)) { 
			
				$this_project = new Project();
				$this_project->populateFromId($query_data['id']);
			?>
			
			<div class="projectList">
			
				<h4><a href="<?=$base_URL?>/project/<?=$this_project->id?>"><?=$this_project->title?></a> <?php if( $this_project->open != "y" ) { echo('<span class="closed"><img src="' . $base_URL . '/images/icons/lock.png" alt="Closed" /></span>'); } ?> <?php if( in_array($this_project->id, $active_user->owner_of_projects) ) { echo('<span class="isOwner">Owner</span>'); } ?></h4>
				
				<p class="desc"><?=$this_project->description?></p>
				
				<p class="otherMembers">Members: 
					<?php
				
					$this_project->getUsers();
					
					for( $j = 0; $j < count($this_project->users); $j++ ) {
						$this_user = new User();
						$this_user->populateFromId($this_project->users[$j]);
						echo('<a href="'. $base_URL . '/profile/' . $this_user->username . '">' . $this_user->name . '</a> ');
					}
					
					if( count($this_project->users) == 0 ) { echo("None."); }
				
					?>
				</p>
				
			</div>
			
			<?php }
			
			?>
			
			
			
			<br /><br /><br /><br />



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