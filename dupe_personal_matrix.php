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

$project_id = $_REQUEST['project_id'];

$active_project = new Project();
$active_project->populateFromId($project_id);

$active_project->id = "";
$active_project->title .= " (Copy)"; //DEFAULT TITLE FOR DUPLICATED PROJECTS IS "[ORIGINAL PROJECT NAME] (Copy)"

$active_project->user_id = $active_user->id;

$active_project->insertNew();

$new_project_id = $active_project->id;

$old_evidence = Array();
$old_hypotheses = Array();
$new_evidence = Array();
$new_hypotheses = Array();

//GET ALL OF THE EVIDENCE FROM THIS MATRIX AND DUPLICATE IT
$result = mysql_do("SELECT id, deleted FROM evidence WHERE project_id='$project_id'");
while($query_data = mysql_fetch_array($result)) {
	if( $query_data['deleted'] != "y" ) {
		$this_evidence = new Evidence();
		$this_evidence->populateFromId($query_data['id']);
		$this_evidence->project_id = $active_project->id;
		$this_evidence->user_id = $active_user->id; //this makes the duplicating user the creator of the new evidence, regardless of who originally created it
		$this_evidence->insertNew();
		$new_evidence[] = $this_evidence->id;
		$old_evidence[] = $query_data['id'];
	}
}

//GET ALL OF THE HYPOTHESES FROM THIS MATRIX AND DUPLICATE THEM
$result = mysql_do("SELECT id, deleted FROM hypotheses WHERE project_id='$project_id'");
while($query_data = mysql_fetch_array($result)) {
	if( $query_data['deleted'] != "y" ) {
		$this_hypothesis = new Hypothesis();
		$this_hypothesis->populateFromId($query_data['id']);
		$this_hypothesis->project_id = $active_project->id;
		$this_hypothesis->user_id = $active_user->id; //this makes the duplicating user the creator of the new hypothesis, regardless of who originally created it
		$this_hypothesis->insertNew();
		$new_hypotheses[] = $this_hypothesis->id;
		$old_hypotheses[] = $query_data['id'];
	}
}

$active_user_id = $active_user->id;
//GET ALL OF THE DUPLICATING USER'S CONSISTENCY RATINGS FOR THIS MATRIX
$result = mysql_do("SELECT * FROM ratings WHERE user_id='$active_user_id'");
while($query_data = mysql_fetch_array($result)) {
	
	if( in_array($query_data['evidence_id'], $old_evidence) && in_array($query_data['hypothesis_id'], $old_hypotheses) ) {
		for( $i = 0; $i < count($old_evidence); $i++ ) {
			if( $old_evidence[$i] == $query_data['evidence_id'] ) { $new_evidence_id = $new_evidence[$i]; }
		}
		for( $i = 0; $i < count($old_hypotheses); $i++ ) {
			if( $old_hypotheses[$i] == $query_data['hypothesis_id'] ) { $new_hypothesis_id = $new_hypotheses[$i]; }
		}
		$new_user_id = $query_data['user_id'];
		$new_rating = $query_data['rating'];
		$new_note = $query_data['note'];
		$new_created = $query_data['created'];
	
		mysql_do("INSERT INTO ratings (hypothesis_id, evidence_id, user_id, rating, note, created) VALUES ('$new_hypothesis_id', '$new_evidence_id', '$new_user_id', '$new_rating', '$new_note', '$new_created')");
	}
}

//mysql_do("INSERT INTO users_in_projects (user_id, project_id) VALUES ('$active_user_id', '$new_project_id')");


//AFTER ALL THE DATA IS DUPLICATED, THE USER IS SENT TO THE PROJECT EDIT PAGE...
?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=<?=$base_URL?>project/<?=$active_project->id?>/edit">
</head>



<body>



</body>
</html>