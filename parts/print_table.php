<?php /* ////////////////////////////////////////////////////////////////////////////////
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
?>
<?php

$dccDateAdded = 0;
$dccDateOfSource = 0;
$dccType = 0;
$dccCode = 0;
$dccFlag = 0;
$dccCredWeight = 0;
$dccDiag = 0;

$sortColsBy = "added";



$kind = substr($part, 0, -6);

$sortColsBy = $_REQUEST['sortColsBy'];
	
$sort_field_1 = $_REQUEST['sort_field_1'];
$sort_field_1_dir = $_REQUEST['sort_field_1_dir'];
$sort_field_2 = $_REQUEST['sort_field_2'];
$sort_field_2_dir = $_REQUEST['sort_field_2_dir'];



if( $_REQUEST['dccs']{0} == "1" ) {
	$dccDateAdded = 1;
}
if( $_REQUEST['dccs']{1} == "1" ) {
	$dccDateOfSource = 1;
}
if( $_REQUEST['dccs']{2} == "1" ) {
	$dccType = 1;
}
if( $_REQUEST['dccs']{3} == "1" ) {
	$dccCode = 1;
}
if( $_REQUEST['dccs']{4} == "1" ) {
	$dccFlag = 1;
}
if( $_REQUEST['dccs']{5} == "1" ) {
	$dccCredWeight = 1;
}
if( $_REQUEST['dccs']{6} == "1" ) {
	$dccDiag = 1;
}
	
	

if( !isset($active_project) ) {
	$active_project = new Project();
}

$active_project->getEandH();
if( $kind == "group" ) {
	$active_project->getDiagsGroup();
} else {
	$active_project->getDiags();
}

$evidence = Array();
$evidence = $active_project->sortByFields($sort_field_1, $sort_field_1_dir, $sort_field_2, $sort_field_2_dir);

?>



<table cellspacing="0" cellpadding="0" border="0" class="groupMatrix" id="groupMatrix"><thead><tr><th onclick="sortGroupTable('name');" class="hypothesis cursorHand <?=$active_project->getSortArrow("name")?>"></th>

	<td onclick="sortGroupTable('created');" class="dclDateAdded" style="<?php if( $dccDateAdded == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("created")?>">Order Added</span></td>
	<td onclick="sortGroupTable('date_of_source');" class="dclDateOfSource" style="<?php if( $dccDateOfSource == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("date_of_source")?>">Date/Time</span></td>
	<td onclick="sortGroupTable('type');" class="dclType" style="<?php if( $dccType == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("type")?>">Type</span></td>
	<td onclick="sortGroupTable('code');" class="dclCode" style="<?php if( $dccCode == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("code")?>">Code</span></td>
	<td onclick="sortGroupTable('flag');" class="dclFlag" style="<?php if( $dccFlag == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("flag")?>">Flag</span></td>	
	
<?php if( $kind != "group" && $kind != "compare" ) { ?>

	<td onclick="sortGroupTable('cred');" class="dclCred"><span class="cursorHand <?=$active_project->getSortArrow("cred")?>">Credibility</span></td>
	<td onclick="sortGroupTable('credWeight');" class="dclCredWeight" style="<?php if( $dccCredWeight == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("credWeight")?>">Cred Weight</span></td>
	
<?php } ?>

	<td onclick="sortGroupTable('diag');" class="dclDiag" style="<?php if( $dccDiag == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("diag")?>">Diag.</span></td>	

<?php

if( $kind == "group" ) {
	$active_project->showHypothesisGroupLabels("least_likely", $sortColsBy == "least_likely");
	$active_project->showHypothesisGroupLabels("most_likely", $sortColsBy == "most_likely");
	$active_project->showHypothesisGroupLabels("added", $sortColsBy == "added");
	$active_project->showHypothesisGroupLabels("alpha", $sortColsBy == "alpha");
} else if( $kind == "compare" ) {
	$active_project->showHypothesisCompareLabels("least_likely_compare", $sortColsBy == "least_likely_compare", $compare_user, $compare_user_2);
	$active_project->showHypothesisCompareLabels("most_likely_compare", $sortColsBy == "most_likely_compare", $compare_user, $compare_user_2);
	$active_project->showHypothesisCompareLabels("added", $sortColsBy == "added", $compare_user, $compare_user_2);
	$active_project->showHypothesisCompareLabels("alpha", $sortColsBy == "alpha", $compare_user, $compare_user_2);
} else if( $kind == "user" ) {
	$active_project->showHypothesisUserLabels("least_likely", $sortColsBy == "least_likely", $ratings_user);
	$active_project->showHypothesisUserLabels("most_likely", $sortColsBy == "most_likely", $ratings_user);
	$active_project->showHypothesisUserLabels("added", $sortColsBy == "added", $ratings_user);
	$active_project->showHypothesisUserLabels("alpha", $sortColsBy == "alpha", $ratings_user);
} else {
	$active_project->showHypothesisPersonalLabels("least_likely_personal", $sortColsBy == "least_likely_personal");
	$active_project->showHypothesisPersonalLabels("most_likely_personal", $sortColsBy == "most_likely_personal");
	$active_project->showHypothesisPersonalLabels("added", $sortColsBy == "added");
	$active_project->showHypothesisPersonalLabels("alpha", $sortColsBy == "alpha");
}

echo('</tr></thead><tbody>');

for( $i = 0; $i < count($evidence); $i++ ) {
	echo('<tr><td class="evidence"><a href="'. $base_URL . '/project/' . $active_project->id . '/evidence/' . $evidence[$i]->id . '">' . $evidence[$i]->name . '</a>');
	if( $evidence[$i]->getCredFlag() ) {
		echo(' <span class="credFlagged">( ! )</span>');
	}
	echo('</td>');

?>

	<td class="dcDateAdded" style="<?php if( $dccDateAdded == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->created_order?> <!--<span style="color: #999999;"><small>(<?=$evidence[$i]->created?>)</small></span>--></td>
	<td class="dcDateOfSource" style="<?php if( $dccDateOfSource == 0 ) { ?>display: none;<?php } ?>"><?=substr($evidence[$i]->date_of_source, 0, 19)?></td>
	<td class="dcType" style="<?php if( $dccType == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->type?></td>
	<td class="dcCode" style="<?php if( $dccCode == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->code?></td>
	<td class="dcFlag" style="<?php if( $dccFlag == 0 ) { ?>display: none;<?php } ?>"><?php if( $evidence[$i]->flag == "y" ) { echo("<img src='$base_URL/images/icons/flag_red.png' />"); } else { echo("<img src='$base_URL/images/icons/bullet_add.png' />"); } ?></td>

<?php if( $kind == "personal" ) { 

	$this_credibility = new Credibility();
	$this_credibility->getUserEvidence($evidence[$i]->id);
	
	?>
	
	<td class="dcCred"><?php if( $this_credibility->value == "n" ) { echo("Suspect"); } else { echo("Credible"); } ?></td>
	<td class="dcCredWeight" style="<?php if( $dccCredWeight == 0 ) { ?>display: none;<?php } ?>"><?php if( $this_credibility->weight == "2" ) { echo("High"); } else if($this_credibility->weight == "1" || $this_credibility->weight == "" || $this_credibility->weight == "0" ) { echo("Med"); } else if( $this_credibility->weight == "0.5" ) { echo("Low"); } ?></td>
	
<?php } ?>

<?php if( $kind == "personal" || $kind == "edit" ) { ?>

	<td class="dcDiag" style="<?php if( $dccDiag == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->getDiag($evidence[$i], $active_project)?></td>

<?php } else if( $kind == "compare" ) { ?>

	<td class="dcDiag" style="<?php if( $dccDiag == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->getDiagCompare($evidence[$i]->id, $active_project, $user_1, $user_2)?></td>

<?php } else { ?>

	<td class="dcDiag" style="<?php if( $dccDiag == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->getDiagGroup($evidence[$i]->id, $active_project)?></td>

<?php } ?>

<?php

if( $kind == "personal" ) {
	$active_project->showCellPersonal($evidence[$i], "least_likely_personal", $sortColsBy == "least_likely_personal");
	$active_project->showCellPersonal($evidence[$i], "most_likely_personal", $sortColsBy == "most_likely_personal");
	$active_project->showCellPersonal($evidence[$i], "added", $sortColsBy == "added");
	$active_project->showCellPersonal($evidence[$i], "alpha", $sortColsBy == "alpha");
} else if( $kind == "user" ) {
	$active_project->showCellUser($evidence[$i], "least_likely", $sortColsBy == "least_likely", $ratings_user);
	$active_project->showCellUser($evidence[$i], "most_likely", $sortColsBy == "most_likely", $ratings_user);
	$active_project->showCellUser($evidence[$i], "added", $sortColsBy == "added", $ratings_user);
	$active_project->showCellUser($evidence[$i], "alpha", $sortColsBy == "alpha", $ratings_user);
} else if( $kind == "group" ) {
	$active_project->showCellGroup($evidence[$i], "least_likely", $sortColsBy == "least_likely");
	$active_project->showCellGroup($evidence[$i], "most_likely", $sortColsBy == "most_likely");
	$active_project->showCellGroup($evidence[$i], "added", $sortColsBy == "added");
	$active_project->showCellGroup($evidence[$i], "alpha", $sortColsBy == "alpha");
} else if( $kind == "edit" ) {
	$active_project->showCellEdit($evidence[$i], "least_likely_personal", $sortColsBy == "least_likely_personal");
	$active_project->showCellEdit($evidence[$i], "most_likely_personal", $sortColsBy == "most_likely_personal");
	$active_project->showCellEdit($evidence[$i], "added", $sortColsBy == "added");
	$active_project->showCellEdit($evidence[$i], "alpha", $sortColsBy == "alpha");
} else if( $kind == "compare" ) {
	$active_project->showCellCompare($evidence[$i], "least_likely_compare", $sortColsBy == "least_likely_compare", $compare_user, $compare_user_2);
	$active_project->showCellCompare($evidence[$i], "most_likely_compare", $sortColsBy == "most_likely_compare", $compare_user, $compare_user_2);
	$active_project->showCellCompare($evidence[$i], "added", $sortColsBy == "added", $compare_user, $compare_user_2);
	$active_project->showCellCompare($evidence[$i], "alpha", $sortColsBy == "alpha", $compare_user, $compare_user_2);
}

?>

	</tr>

<?php } ?>

</tbody></table>