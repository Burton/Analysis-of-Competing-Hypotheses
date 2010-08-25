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

$active_hypothesis = new Hypothesis();
$active_hypothesis->populateFromId($_REQUEST['hypothesis_id']);

$this_user = new User();
$this_user->populateFromId($active_hypothesis->user_id);

?>

<hypothesis>
	<id><?=$active_hypothesis->id?></id>
	<name><![CDATA[<?=$active_hypothesis->label?>]]></name>
	<details><![CDATA[<?=$active_hypothesis->description?>]]></details>
	<classification><?=showClassification($active_hypothesis->classification)?></classification>
	<caveat><?=showCaveat($active_hypothesis->caveat)?></caveat>
	<creator><?=$this_user->name?></creator>
	<creator_id><?=$this_user->id?></creator_id>
	<date_created><?=$active_hypothesis->created?></date_created>
</hypothesis>