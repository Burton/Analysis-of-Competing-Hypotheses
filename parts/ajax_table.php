<?php

$dccDateAdded = 0;
$dccDateOfSource = 0;
$dccType = 0;
$dccCode = 0;
$dccFlag = 0;
$dccCredWeight = 0;
$dccDiag = 0;

$sortColsBy = "added";



if( isset($_REQUEST['reload']) && $_REQUEST['reload'] == "y" ) {

	include_once("../code/includes.php");
	
	$kind = $_REQUEST['kind'];

	$id = $_REQUEST['project_id'];
	
	$sort_field_1 = $_REQUEST['sort_field_1'];
	$sort_field_1_dir = $_REQUEST['sort_field_1_dir'];
	$sort_field_2 = $_REQUEST['sort_field_2'];
	$sort_field_2_dir = $_REQUEST['sort_field_2_dir'];
	
	$dccDateAdded = $_REQUEST['dccDateAdded'];
	$dccDateOfSource = $_REQUEST['dccDateOfSource'];
	$dccType = $_REQUEST['dccType'];
	$dccCode = $_REQUEST['dccCode'];
	$dccFlag = $_REQUEST['dccFlag'];
	$dccCredWeight = $_REQUEST['dccCredWeight'];
	$dccDiag = $_REQUEST['dccDiag'];
	
	$sortColsBy = $_REQUEST['sortColsBy'];
	
	$active_project = new Project();
	$active_project->populateFromID($id);
	
	$active_project->getUsers();
	
	$active_owner = new User();
	$active_owner->populateFromID($active_project->user_id);

	$active_project->getEandH();

} else {
	$kind = $part;
}

if( $kind == "group" ) {
	$active_project->getDiagsGroup();
} else if( $kind == "compare" ) {
	if( isset($_REQUEST['compare_user_id']) ) {
		$compare_user = new User();
		$compare_user->populateFromId($_REQUEST['compare_user_id']);
		$compare_user_2 = new User();
		$compare_user_2->populateFromId($_REQUEST['compare_user_id_2']);
	}
	$active_project->getDiagsCompare($compare_user, $compare_user_2);
} else if( $kind == "user" ) {
	if( isset($_REQUEST['display_user_id']) ) {
		$ratings_user = new User();
		$ratings_user->populateFromId($_REQUEST['display_user_id']);
	}
	$active_project->getDiagsUser($ratings_user);
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
	echo('<tr><td class="evidence"><a href="'. $base_URL . 'project/' . $active_project->id . '/evidence/' . $evidence[$i]->id . '" onmouseover="return overlib(\'' . cleanForDisplay($evidence[$i]->details) . '\', CAPTION, \'Evidence Notes\');" onmouseout="return nd();">' . $evidence[$i]->name . '</a>');
	if( $evidence[$i]->getCredFlag() ) {
		echo(' <span class="credFlagged" onmouseover="return overlib(\'One or more analysts doubts the credibility of this source.\', CAPTION, \'CREDIBILITY ALERT\');" onmouseout="return nd();">( ! )</span>');
	}
	echo('</td>');

?>

	<td class="dcDateAdded" style="<?php if( $dccDateAdded == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->created_order?> <!--<span style="color: #999999;"><small>(<?=$evidence[$i]->created?>)</small></span>--></td>
	<td class="dcDateOfSource" style="<?php if( $dccDateOfSource == 0 ) { ?>display: none;<?php } ?>"><?=substr($evidence[$i]->date_of_source, 0, 19)?></td>
	<td class="dcType" style="<?php if( $dccType == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->type?></td>
	<td class="dcCode" style="<?php if( $dccCode == 0 ) { ?>display: none;<?php } ?>"><?=$evidence[$i]->code?></td>
	<td class="dcFlag" style="<?php if( $dccFlag == 0 ) { ?>display: none;<?php } ?>"><a id="flag_<?=$evidence[$i]->id?>" onclick="switchFlag('flag_<?=$evidence[$i]->id?>', <?=$evidence[$i]->id?>);"><?php if( $evidence[$i]->flag == "y" ) { echo("<img src='". $base_URL . "images/icons/flag_red.png' />"); } else { echo("<img src='". $base_URL . "images/icons/bullet_add.png' />"); } ?></a></td>

<?php if( $kind == "personal" || $kind == "user" ) { 

	$this_credibility = new Credibility();
	if( $kind == "user" ) {
		$this_credibility->getUserEvidenceUser($evidence[$i]->id, $ratings_user);
	} else {
		$this_credibility->getUserEvidence($evidence[$i]->id);
	}
	
	?>
	
	<td class="dcCred"><?php if( $this_credibility->value == "n" ) { echo("Suspect"); } else { echo("Credible"); } ?></td>
	<td class="dcCredWeight" style="<?php if( $dccCredWeight == 0 ) { ?>display: none;<?php } ?>"><?php if( $this_credibility->weight == "2" ) { echo("High"); } else if($this_credibility->weight == "1" || $this_credibility->weight == "" || $this_credibility->weight == "0" ) { echo("Med"); } else if( $this_credibility->weight == "0.5" ) { echo("Low"); } ?></td>
	
<?php } ?>

<?php if( $kind == "edit" ) { 

	$this_credibility = new Credibility();
	if( $kind == "user" ) {
		$this_credibility->getUserEvidenceUser($evidence[$i]->id, $ratings_user);
	} else {
		$this_credibility->getUserEvidence($evidence[$i]->id);
	}
	
	?>
	
	<td class="dcCred" id="td_cred_edit_<?=$evidence[$i]->id?>"><select onChange="saveCredRating('cred_edit_<?=$evidence[$i]->id?>');" name="cred_edit_<?=$evidence[$i]->id?>" id="cred_edit_<?=$evidence[$i]->id?>">
		<option value="y" <?php if( $this_credibility->value != "n" ) { echo("selected"); } ?> >Credible</option>
		<option value="n" <?php if( $this_credibility->value == "n" ) { echo("selected"); } ?> >Suspect</option>
	</select></td>
	<td class="dcCredWeight" id="td_cred_weight_edit_<?=$evidence[$i]->id?>" style="<?php if( $dccCredWeight == 0 ) { ?>display: none;<?php } ?>"><select onChange="saveCredWeight('cred_weight_edit_<?=$evidence[$i]->id?>');" name="cred_weight_edit_<?=$evidence[$i]->id?>" id="cred_weight_edit_<?=$evidence[$i]->id?>">
		<option value="2" <?php if( $this_credibility->weight == "2" ) { echo("selected"); } ?> >High</option>
		<option value="1" <?php if( $this_credibility->weight == "1" || $this_credibility->weight == "" || $this_credibility->weight == "0" ) { echo("selected"); } ?> >Med</option>
		<option value="0.5" <?php if( $this_credibility->weight == "0.5" ) { echo("selected"); } ?> >Low</option>
	</select></td>
	
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
	
<?php if( $i%25 == 24 ) { ?>

	<tr class="innerHeaders"><th>&nbsp;</th>

	<td onclick="sortGroupTable('date_added');" class="dclDateAdded" style="<?php if( $dccDateAdded == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("created")?>">Date Added</span></td>
	<td onclick="sortGroupTable('date_of_source');" class="dclDateOfSource" style="<?php if( $dccDateOfSource == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("date_of_source")?>">Date of Source</span></td>
	<td onclick="sortGroupTable('type');" class="dclType" style="<?php if( $dccType == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("type")?>">Type</span></td>
	<td onclick="sortGroupTable('code');" class="dclCode" style="<?php if( $dccCode == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("code")?>">Code</span></td>
	<td onclick="sortGroupTable('flag');" class="dclFlag" style="<?php if( $dccFlag == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("flag")?>">Flag</span></td>	
	
<?php if( $kind != "group" ) { ?>

	<td onclick="sortGroupTable('cred');" class="dclCred"><span class="cursorHand <?=$active_project->getSortArrow("cred")?>">Credibility</span></td>
	<td onclick="sortGroupTable('credWeight');" class="dclCredWeight" style="<?php if( $dccCredWeight == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("credWeight")?>">Cred Weight</span></td>
	<td onclick="sortGroupTable('diag');" class="dclDiag" style="<?php if( $dccDiag == 0 ) { ?>display: none;<?php } ?>"><span class="cursorHand <?=$active_project->getSortArrow("diag")?>">Diag.</span></td>
	
<?php } ?>

<?php

if( $kind == "group" ) {
	$active_project->showHypothesisGroupLabelsInner("least_likely", $sortColsBy == "least_likely");
	$active_project->showHypothesisGroupLabelsInner("most_likely", $sortColsBy == "most_likely");
	$active_project->showHypothesisGroupLabelsInner("added", $sortColsBy == "added");
	$active_project->showHypothesisGroupLabelsInner("alpha", $sortColsBy == "alpha");
} else if( $kind == "compare" ) {
	$active_project->showHypothesisCompareLabelsInner("least_likely_compare", $sortColsBy == "least_likely_compare", $compare_user, $compare_user_2);
	$active_project->showHypothesisCompareLabelsInner("most_likely_compare", $sortColsBy == "most_likely_compare", $compare_user, $compare_user_2);
	$active_project->showHypothesisCompareLabelsInner("added", $sortColsBy == "added", $compare_user, $compare_user_2);
	$active_project->showHypothesisCompareLabelsInner("alpha", $sortColsBy == "alpha", $compare_user, $compare_user_2);
} else if( $kind == "user" ) {
	$active_project->showHypothesisUserLabelsInner("least_likely", $sortColsBy == "least_likely", $ratings_user);
	$active_project->showHypothesisUserLabelsInner("most_likely", $sortColsBy == "most_likely", $ratings_user);
	$active_project->showHypothesisUserLabelsInner("added", $sortColsBy == "added", $ratings_user);
	$active_project->showHypothesisUserLabelsInner("alpha", $sortColsBy == "alpha", $ratings_user);
} else {
	$active_project->showHypothesisPersonalLabelsInner("least_likely_personal", $sortColsBy == "least_likely_personal");
	$active_project->showHypothesisPersonalLabelsInner("most_likely_personal", $sortColsBy == "most_likely_personal");
	$active_project->showHypothesisPersonalLabelsInner("added", $sortColsBy == "added");
	$active_project->showHypothesisPersonalLabelsInner("alpha", $sortColsBy == "alpha");
}

echo('</tr>');

	}

} ?>

</tbody></table>