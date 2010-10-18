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
include("parts/includes.php");

$active_hypothesis = new Hypothesis();

$active_hypothesis->populateFromId($_REQUEST['hypothesis_id']);

$active_hypothesis->id = $_REQUEST['hypothesis_id'];

$active_hypothesis->deleted = "y";

$active_hypothesis->update();

setStatusMessage("Updated!");

?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=<?=$base_URL?>project/<?=$active_hypothesis->project_id?>">
</head>



<body>



</body>
</html>