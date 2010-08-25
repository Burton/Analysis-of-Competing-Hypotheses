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

foreach ($_REQUEST as $field => $value) {
	if( substr($field, 0, 6) == "rating" ) {
		$evidence = substr($field, 7, strpos($field, "-")-7);
		$hypothesis = substr($field, strpos($field, "-")+1);
		mysql_do("DELETE FROM ratings WHERE evidence_id='$evidence' AND hypothesis_id='$hypothesis' AND user_id='$active_user->id'");
		if( is_numeric($evidence) && is_numeric($hypothesis) ) {
			mysql_do("INSERT INTO ratings (evidence_id, hypothesis_id, rating, user_id) VALUES ('$evidence', '$hypothesis', '$value', '$active_user->id')");
		}
		$value = "";
	}
	if( substr($field, 0, 9) == "cred_edit" ) {
		$evidence = substr($field, 10);
		mysql_do("DELETE FROM credibility WHERE evidence_id='$evidence' AND user_id='$active_user->id'");
		if( is_numeric($evidence) ) {
			$weight = $_REQUEST['cred_weight_edit_' . $evidence];
			mysql_do("INSERT INTO credibility (evidence_id, value, weight, user_id) VALUES ('$evidence', '$value', '$weight', '$active_user->id')");
		}
		$value = "";
	}
}

setStatusMessage("Done!");

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=project/<?=$_REQUEST['project_id']?>">
</head>



<body>



</body>
</html>