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

$active_evidence = new Evidence();

$active_evidence->populateFromId($_REQUEST['evidence_id']);

foreach ($_REQUEST as $field => $value) {
	$active_evidence->$field = addslashes($value);
}

$active_evidence->id = $_REQUEST['evidence_id'];

$active_evidence->update();

$cred = $_REQUEST['credibility'];

$this_credibility = new Credibility();
$this_credibility->getUserEvidence($_REQUEST['evidence_id']);

if( $cred == "credible" ) {
	$this_credibility->switchCred("y");
} else if( $cred == "suspect" ) {
	$this_credibility->switchCred("n");
}

setStatusMessage("Updated!");

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=project/<?=$active_evidence->project_id?>/evidence/<?=$_REQUEST['evidence_id']?>">
</head>



<body>



</body>
</html>