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

header("Content-type: application/xml");

echo('<?xml version="1.0" encoding="ISO-8859-1"?>');

include("code/includes.php");

$active_project = new Project();
$active_project->populateFromId($_REQUEST['project_id']);
$active_project->getUsers();

$active_evidence = new Evidence();
$active_evidence->populateFromId($_REQUEST['evidence_id']);

$active_hypothesis = new Hypothesis();
$active_hypothesis->populateFromId($_REQUEST['hypothesis_id']);

$this_user = new User();
$this_user->populateFromId($active_evidence->user_id);

for( $k = 0; $k < count($active_project->users); $k++ ) {
			$this_user = new User();
			$this_user->populateFromId($active_project->users[$k]);
			$rating = $this_user->getRating($active_evidence->id, $active_hypothesis->id);
			$rating_score = getRatingScore($rating);
			if( $rating != "" ) {
				$ratings[] = getRatingScore($rating);
			}
		}
?>

<cell>
	<project>
		<id><?=$active_project->id?></id>
		<title><![CDATA[<?=$active_project->title?>]]></title>
	</project>
	<evidence>
		<id><?=$active_evidence->id?></id>
		<name><![CDATA[<?=$active_evidence->name?>]]></name>
	</evidence>
	<hypothesis>
		<id><?=$active_hypothesis->id?></id>
		<label><![CDATA[<?=$active_hypothesis->label?>]]></label>
	</hypothesis>
	<ratings>	
<?php

$ratings = Array();

for( $k = 0; $k < count($active_project->users); $k++ ) {
	$this_user = new User();
	$this_user->populateFromId($active_project->users[$k]);
	$rating = $this_user->getRating($active_evidence->id, $active_hypothesis->id);
	$rating_score = getRatingScore($rating);
	if( $rating != "" ) {
		$ratings[] = getRatingScore($rating);
	}
	if( $rating != "" ) { ?>
		<rating>
			<user><![CDATA[<?=$this_user->name?>]]></user>
			<user_rating><![CDATA[<?=$rating?>]]></user_rating>
		</rating>
<?php } } ?>
	</ratings>
</cell>