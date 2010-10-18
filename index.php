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

$is_index = TRUE;

?>

<?php

if( $active_user->logged_in ) { 
	$pagetitle = "ACH: Your Projects";
	} else {
	$pagetitle = "ACH: Collaborative Analysis of Competing Hypotheses";
	}
?>
<html>
<head>
	<title><?=$pagetitle?></title>
	<?php include("parts/includes.php"); ?>
	
</head>

<body>



<?php include("parts/header.php"); ?>







<?php

if( $active_user->logged_in ) { ?>
	
	
	
<?php include("parts/menu_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">



<div class="mainProjectList">



<h2>Your Projects</h2>



<?php

$active_user->getProjects();

		if( count($active_user->projects) == 0) {
			echo "You are not a member of any projects. Use the above links to browse existing projects or create your own.";
		}
		else {


			//DISPLAY THE STATUS OF OUTSTANDING REQUESTS TO JOIN PRIVATE PROJECTS. FUNCTION DEFINED IN CODE/CLASS_USER.PHP
			$active_user->displayWaitingForApproval();
			
			//AND DISPLAY NEW INVITATIONS TO JOIN PROJECTS. FUNCTION DEFINED IN CODE/CLASS_USER.PHP
			$active_user->displayInvitationNotices();
			
			?>
			
			
			
			<?php
			//THE FIRST LIST IS A LIST OF ALL PROJECTS OWNED BY THE ACTIVE USER
			for( $i = 0; $i <= count($active_user->owner_of_projects); $i++ ) {
			
				if( $i == 0 && count($active_user->owner_of_projects) > 0 ) { echo("<h3>Projects owned by you:</h3>"); }
			
				$this_project = new Project();	
				$this_project->populateFromId($active_user->owner_of_projects[$i]);
				if( $this_project->title != "" ) {
			?>
			
			
			
			<div class="projectList">
			
			<h4><a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> <?php if( in_array($this_project->id, $active_user->owner_of_projects) ) { echo('<span class="isOwner">Owner</span>'); } ?></h4>
			
			<p class="desc"><?=$this_project->description?></p>
			
			<p class="otherMembers"><span class="membersLabel">Members:</span> <?php
			//LIST ALL USERS IN EACH PROJECT
			$this_project->getUsers();
			
			for( $j = 0; $j < count($this_project->users); $j++ ) {
				$this_user = new User();
				$this_user->populateFromId($this_project->users[$j]);
				echo('<a href="'. $base_URL . 'profile/' . $this_user->username . '">' . $this_user->name . '</a> ');
			}
			
			if( count($this_project->users) == 0 ) { echo("None."); }
			
			?></p>
			
			<?php
			
			$this_project->getJoinRequests();
			if( count($this_project->join_requests) > 0 && in_array($this_project->id, $active_user->owner_of_projects) ) { ?>
			
			<p class="joinRequests"><b>Join Requests:</b></p>
			
			<ul class="joinRequests">
			<?php
			//FIND OUT IF ANYONE HAS REQUESTED TO JOIN THIS PROJECT, AND LIST THE REQUESTS
			for( $j = 0; $j < count($this_project->join_requests); $j++ ) {
				$this_user = new User();
				$this_user->populateFromId($this_project->join_requests[$j]);
				echo('<li><a href="'. $base_URL . 'profile/' . $this_user->username . '">' . $this_user->name . '</a> <a class="approve" href="' . $base_URL . 'joinrequest/' . $this_user->id . '/' . $this_project->id . '/approve">Approve</a> <a class="deny" href="' . $base_URL . 'joinrequest/' . $this_user->id . '/' . $this_project->id . '/deny">Deny</a></li>');
			}
			
			?>
			</ul>
			
			<?php }
			
			
			
			?>
			
			</div>
			
			<?php }	} ?>
			
			
			
			<?php
			//FOLLOWED BY A LIST OF ALL OTHER PROJECTS THE ACTIVE USER IS PARTICIPATING IN
			for( $i = 0; $i <= count($active_user->member_of_projects); $i++ ) {
			
				if( $i == 0 && count($active_user->member_of_projects) > 0 ) { echo("<h3>Member of Projects:</h3>"); }
				
				$this_project = new Project();
				$this_project->populateFromId($active_user->member_of_projects[$i]);
				if( $this_project->title != "" ) {
			?>
			
			
			
			<div class="projectList">
			
			<h4><a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> <?php if( in_array($this_project->id, $active_user->owner_of_projects) ) { echo('<span class="isOwner">Owner</span>'); } ?></h4>
			
			<p class="desc"><?=$this_project->description?></p>
			
			<p class="otherMembers"><span class="membersLabel">Members:</span> <?php
			
			$this_project->getUsers();
			//AND A LIST OF THOSE PROJECTS' MEMBERS
			for( $j = 0; $j < count($this_project->users); $j++ ) {
				$this_user = new User();
				$this_user->populateFromId($this_project->users[$j]);
				echo('<a href="' . $base_URL . 'profile/' . $this_user->username . '">' . $this_user->name . '</a> ');
			}
			
			if( count($this_project->users) == 0 ) { echo("None."); }
			
			?></p>
			
			<?php
			
			$this_project->getJoinRequests();
			if( count($this_project->join_requests) > 0 && in_array($this_project->id, $active_user->owner_of_projects) ) { ?>
			
			<p class="joinRequests"><b>Join Requests:</b></p>
			
			<ul class="joinRequests">
			<?php
			
			for( $j = 0; $j < count($this_project->join_requests); $j++ ) {
				$this_user = new User();
				$this_user->populateFromId($this_project->join_requests[$j]);
				echo('<li><a href="' . $base_URL . 'profile/' . $this_user->username . '">' . $this_user->name . '</a> <a class="approve" href="' . $base_URL . 'joinrequest/' . $this_user->id . '/' . $this_project->id . '/approve">Approve</a> <a class="deny" href="' . $base_URL . 'joinrequest/' . $this_user->id . '/' . $this_project->id . '/deny">Deny</a></li>');
			}
			
			?>
			</ul>
			
			<?php }
			
			
			
			?>
			
			</div>
			
			<?php }	} ?>
			
			
			
			<?php
			
			//FOLLOWED BY A LIST OF PROJECTS THAT THE ACTIVE USER IS A VIEW-ONLY MEMBER OF...
			
			for( $i = 0; $i <= count($active_user->member_of_projects_view_only); $i++ ) {
			
				if( $i == 0 && count($active_user->member_of_projects_view_only) > 0 ) { echo("<h3>View-Only Member of Projects:</h3>"); }
				
				$this_project = new Project();
				$this_project->populateFromId($active_user->member_of_projects_view_only[$i]);
				if( $this_project->title != "" ) {
			?>
			
			
			
			<div class="projectList">
			
			<h4><a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> <?php if( in_array($this_project->id, $active_user->owner_of_projects) ) { echo('<span class="isOwner">Owner</span>'); } ?></h4>
			
			<p class="desc"><?=$this_project->description?></p>
			
			<p class="otherMembers"><span class="membersLabel">Members:</span> <?php
			
			//...AND THOSE PROJECTS' MEMBERS...
			
			$this_project->getUsers();
			
			for( $j = 0; $j < count($this_project->users); $j++ ) {
				$this_user = new User();
				$this_user->populateFromId($this_project->users[$j]);
				echo('<a href="' . $base_URL . 'profile/' . $this_user->username . '">' . $this_user->name . '</a> ');
			}
			
			if( count($this_project->users) == 0 ) { echo("None."); }
			
			?></p>
			
			<?php
			
			$this_project->getJoinRequests();
			if( count($this_project->join_requests) > 0 && in_array($this_project->id, $active_user->owner_of_projects) ) { ?>
			
			<p class="joinRequests"><b>Join Requests:</b></p>
			
			<ul class="joinRequests">
			<?php
			
			for( $j = 0; $j < count($this_project->join_requests); $j++ ) {
				$this_user = new User();
				$this_user->populateFromId($this_project->join_requests[$j]);
				echo('<li><a href="' . $base_URL . 'profile/' . $this_user->username . '">' . $this_user->name . '</a> <a class="approve" href="' . $base_URL . 'joinrequest/' . $this_user->id . '/' . $this_project->id . '/approve">Approve</a> <a class="deny" href="' . $base_URL . 'joinrequest/' . $this_user->id . '/' . $this_project->id . '/deny">Deny</a></li>');
			}
			
			?>
			</ul>
			
			<?php }
			
			
			
			?>
			
			</div>
			
			<?php }	} ?>
			
			
			
			</div>
			
			
			
			<div class="mainRecentActivity">
			
			<?php include("parts/recent_activity.php"); ?>
			
			</div>
			
			
			
			<br /><br /><br /><br />
			
			
			
			</div>
			
			</div></div>
			
			</div>

		<?php } ?>

<?php } else { ?>



<?php include("parts/login_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main welcome">

				<p class="welcome">Welcome to ACH.</p>

				<div class="introBoxes">
				
					<div class="analyse">
					
						<h2>Analyze</h2>
					
						<p class="subtitle">multiple hypotheses against large bodies of evidence.</p>
					
						<p>ACH helps you track how many data points affect the validity of various outcomes, and compares 
						your assessments with your teammates'.</p> 
					
						<p><a href="help">Read more about ACH &raquo;</a></p>
					
					</div>
					
					
					<div class="manage">
					
						<h2>Manage</h2>
					
						<p class="subtitle">your data in one place.</p>
					
						<p>Store all of your working knowledge. Find out what it means to the issues you're working on.</p>
					
					</div>
					
					
					
					<div class="organize">
					
						<h2>Organize</h2>
					
						<p class="subtitle">a Community-wide team of analysts.</p>
					
						<p>Find out who is using the same data you are. Or e-mail your counterparts directly and get them to join.</p>
					
						<p>Keep in touch with your team throughout the day with live chat and message boards.</p>
					
					</div>
				
				
				
				
				</div>

			</div>
		</div>
	</div>
</div>



<?php } ?>



<?php include("parts/footer.php"); ?>









</body>
</html>