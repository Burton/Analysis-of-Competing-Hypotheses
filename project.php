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

/* this file is the parent of every project-specific page. It needs to be cleaned up: divs, JS scripts and PHP
	are pretty messy here */


include("code/includes.php");

$id = $_REQUEST['id'];
$part = $_REQUEST['part'];

$active_project = new Project();
$active_project->populateFromID($id);

$active_project->getUsers();

$active_owner = new User();
$active_owner->populateFromID($active_project->user_id);

?>



<html>
<head>
	<title>
	<? if ($active_project->id === NULL) { ?>	
		ACH: This project does not exist
	<? } else if ( !in_array($active_user->id, $active_project->users) && $active_project->directory != "y" ) { ?>
	ACH: This is a private project.

	<? } else { ?>
	
	ACH: <?=$active_project->title?> <? } ?>
	</title>
	
<?php include("parts/includes.php"); ?>
<script language="JavaScript">

	
	
var last_sort_1 = "created";
var last_sort_1_dir = "asc";
var last_sort_2 = "name";
var last_sort_2_dir = "asc";

var edit_table = 0;
var table_kind = "";

var hypo_sort = "added";



var dccDateAdded = 0;
var dccDateOfSource = 0;
var dccType = 0;
var dccCode = 0;
var dccFlag = 0;
var dccCredWeight = 0;
var dccDiag = 0;



var sortColsBy = "added";


function Disab (val) {
if(val=="1")
{nav.public[0].disabled=true;nav.public[0].checked=false;
nav.public[1].disabled=true;nav.public[1].checked=false;
nav.open[0].disabled=true;nav.open[0].checked=false;
nav.open[1].disabled=true;nav.open[1].checked=false;
}
if(val=="2")
{
nav.public[0].disabled=false; nav.public[0].checked=true
nav.public[1].disabled=false;
nav.open[0].disabled=false; nav.open[0].checked=true;
nav.open[1].disabled=false
}
}

// THE NEXT 40 LINES ARE FOR MAKING SURE LABELS ARE ENTERED FOR NEW HYPOS AND EVIDENCE


function validateHypoFormOnSubmit(newHypothesis) {
var reason = "";

  reason += validateEmpty(newHypothesis.label);
      
  if (reason != "") {
    alert(reason);
    return false;
  }

  return true;
}

function validateMultiHypoFormOnSubmit(newHypothesis) {
var reason = "";

  reason += validateEmpty(newHypothesis.label1);
      
  if (reason != "") {
    alert(reason);
    return false;
  }

  return true;
}

function validateEvidenceFormOnSubmit(newEvidence) {
var reason = "";

  reason += validateEmpty(newEvidence.name);
      
  if (reason != "") {
    alert(reason);
    return false;
  }

  return true;
}

function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Required fields have not been completed.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}




function sortGroupTable(which) {

	sortColsBy = document.getElementById('hypotheses_column_sort').value;

	if( last_sort_1 == which ) {
		if( last_sort_1_dir == "asc" ) { last_sort_1_dir = "desc"; } else if( last_sort_1_dir == "desc" ) { last_sort_1_dir = "asc"; }
	} else {
		last_sort_2 = last_sort_1;
		last_sort_2_dir = last_sort_1_dir;
		last_sort_1 = which;
		last_sort_1_dir = "asc";
	}
	
	reloadAjaxGroupTable();
	
}
	
	

function sortGroupTable2(which_1, dir_1, which_2, dir_2) {

	last_sort_1 = which_1;
	last_sort_1_dir = dir_1;
	last_sort_2 = which_2;
	last_sort_2_dir = dir_2;
	
	reloadAjaxGroupTable();
	
}



function reloadAjaxGroupTable() {
	
	document.getElementById("ajaxTableGroupLoading").innerHTML = "Loading. Please wait...   ";
	var oXmlHttp = zXmlHttp.createRequest();
	var sIdProject = document.getElementById("project_id").value;
	var baseURL = "<?php print $base_URL; ?>";

	if( edit_table == 0 ) {
		table_kind = "<?=$part?>";
	} else {
		table_kind = "edit";
	}
	
	var date = new Date();
	var timestamp = date.getTime();
	
	oXmlHttp.open("get", baseURL+"parts/ajax_table.php?kind=" + table_kind + "&sort_field_1=" + last_sort_1 + "&sort_field_1_dir=" + last_sort_1_dir + "&sort_field_2=" + last_sort_2 + "&sort_field_2_dir=" + last_sort_2_dir + "&reload=y&project_id=" + thisProjectId + "&dccDateAdded=" + dccDateAdded + "&dccDateOfSource=" + dccDateOfSource + "&dccType=" + dccType + "&dccCode=" + dccCode + "&dccFlag=" + dccFlag + "&dccCredWeight=" + dccCredWeight + "&dccDiag=" + dccDiag + "&sortColsBy=" + sortColsBy + "&internetexplorerisawful=" + timestamp <?php if( isset($_REQUEST['ratings_user_id']) ) { echo(' + "&display_user_id=' . $_REQUEST['ratings_user_id'] . '"'); } ?> <?php if( isset($_REQUEST['compare_user_id']) ) { echo(' + "&compare_user_id=' . $_REQUEST['compare_user_id'] . '"'); } ?> <?php if( isset($_REQUEST['compare_user_id_2']) ) { echo(' + "&compare_user_id_2=' . $_REQUEST['compare_user_id_2'] . '"'); } ?>, true);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById("ajaxTableGroup").innerHTML = oXmlHttp.responseText;
				document.getElementById("ajaxTableGroupLoading").innerHTML = "";
			} else {
				document.getElementById("ajaxTableGroup").innerHTML = "(Error.)";
			}
		}            
	}
	oXmlHttp.send(null);
}





function showDetails() {
	new Effect.BlindDown('projectDetails');
	document.getElementById("showHideDetails").innerHTML = '<a style="cursor: pointer;" onclick="hideDetails();">Hide details</a>';
}

function hideDetails() {
	new Effect.BlindUp('projectDetails');
	document.getElementById("showHideDetails").innerHTML = '<a style="cursor: pointer;" onclick="showDetails();">Show details</a>';
}



function showInviteViewer() {
	new Effect.BlindDown('inviteViewer');
	document.getElementById("showHideInviteViewer").innerHTML = '<a class="inviteViewer" onclick="hideInviteViewer();">Invite</a>';
}

function hideInviteViewer() {
	new Effect.BlindUp('inviteViewer');
	document.getElementById("showHideInviteViewer").innerHTML = '<a class="inviteViewer" onclick="showInviteViewer();">Invite</a>';
}



var currentShowSortTool = "";

function showSortTools(which) {
	new Effect.BlindDown('sortTools_'+which);
	if( which == "show_data_columns" ) { var label = "Show Data Columns"; }
	if( which == "sort_hypotheses" ) { var label = "Sort Hypotheses"; }
	if( which == "sort_evidence" ) { var label = "Sort Evidence"; }
	document.getElementById("groupMatrixSortTab_"+which).innerHTML = '<a style="cursor: pointer;" onclick="hideSortTools(\''+which+'\');">' + label + '</a>';
	if( which != currentShowSortTool ) { hideSortTools(currentShowSortTool); }
	currentShowSortTool = which;
}

function hideSortTools(which) {
	if( which != "" ) {
		new Effect.BlindUp('sortTools_'+which);
		if( which == "show_data_columns" ) { var label = "Show Data Columns"; }
		if( which == "sort_hypotheses" ) { var label = "Sort Hypotheses"; }
		if( which == "sort_evidence" ) { var label = "Sort Evidence"; }
		document.getElementById("groupMatrixSortTab_"+which).innerHTML = '<a style="cursor: pointer;" onclick="showSortTools(\''+which+'\');">' + label + '</a>';
		currentShowSortTool = "";
	}
}



function showDataColumns() {
	if(document.getElementById('showDataColumns').checked == true) {
		setStyleByClass('td','dclDateAdded','display','');
		setStyleByClass('td','dcDateAdded','display','');
		setStyleByClass('td','dclDateOfSource','display','');
		setStyleByClass('td','dcDateOfSource','display','');
		setStyleByClass('td','dclType','display','');
		setStyleByClass('td','dcType','display','');
		setStyleByClass('td','dclCode','display','');
		setStyleByClass('td','dcCode','display','');
		setStyleByClass('td','dclFlag','display','');
		setStyleByClass('td','dcFlag','display','');
		setStyleByClass('td','dclCredWeight','display','');
		setStyleByClass('td','dcCredWeight','display','');
		setStyleByClass('td','dclDiag','display','');
		setStyleByClass('td','dcDiag','display','');
		dccDateAdded = 1;
		dccDateOfSource = 1;
		dccType = 1;
		dccCode = 1;
		dccFlag = 1;
		dccCredWeight = 1;
		dccDiag = 1;
	} else {
		setStyleByClass('td','dclDateAdded','display','none');
		setStyleByClass('td','dcDateAdded','display','none');
		setStyleByClass('td','dclDateOfSource','display','none');
		setStyleByClass('td','dcDateOfSource','display','none');
		setStyleByClass('td','dclType','display','none');
		setStyleByClass('td','dcType','display','none');
		setStyleByClass('td','dclCode','display','none');
		setStyleByClass('td','dcCode','display','none');
		setStyleByClass('td','dclFlag','display','none');
		setStyleByClass('td','dcFlag','display','none');
		setStyleByClass('td','dclCredWeight','display','none');
		setStyleByClass('td','dcCredWeight','display','none');
		setStyleByClass('td','dclDiag','display','none');
		setStyleByClass('td','dcDiag','display','none');
		dccDateAdded = 0;
		dccDateOfSource = 0;
		dccType = 0;
		dccCode = 0;
		dccFlag = 0;
		dccCredWeight = 0;
		dccDiag = 0;
	}	
}



function savePersonalMatrix() {
	var matrixData;
	
<?php

if( in_array($active_user->id, $active_project->users) || ($active_project->public =="y")) {
	
	$active_project->getEandH();
	
	for( $i = 0; $i<count($active_project->evidence); $i++ ) {
		for( $j = 0; $j<count($active_project->hypotheses); $j++ ) { ?>
		matrixData += '&rating_<?=$active_project->evidence[$i]?>-<?=$active_project->hypotheses[$j]?>=' + document.getElementById("rating_<?=$active_project->evidence[$i]?>-<?=$active_project->hypotheses[$j]?>_" + document.getElementById("hypotheses_column_sort").value).value + '&';	
	<?php
		} ?>
		matrixData += '&cred_edit_<?=$active_project->evidence[$i]?>=' + document.getElementById("cred_edit_<?=$active_project->evidence[$i]?>").value + '&';
		matrixData += '&cred_weight_edit_<?=$active_project->evidence[$i]?>=' + document.getElementById("cred_weight_edit_<?=$active_project->evidence[$i]?>").value + '&';
	<?php
	}

}

?>

	window.location = "project_ratings_action.php?project_id=<?=$active_project->id?>&x=x" + matrixData;

}



function saveCellRating(cell_id) {
	var new_value = document.getElementById(cell_id).value;
	document.getElementById("td_" + cell_id).innerHTML = "Changing...";
	var oXmlHttp = zXmlHttp.createRequest();
	
	oXmlHttp.open("get", "parts/save_cell_rating.php?cell_id=" + cell_id + "&new_value=" + new_value);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById("td_" + cell_id).innerHTML = oXmlHttp.responseText;
				//if( new_value != "" ) {
					document.getElementById("td_" + cell_id).className= new_value.replace(" ", "_").replace("/", "").toLowerCase();
				//}
			} else {
				document.getElementById("td_" + cell_id).innerHTML = "(Save error.)";
			}
		}            
	}
	oXmlHttp.send(null);
}



function saveCredRating(evidence_id) {
	var new_value = document.getElementById(evidence_id).value;
	document.getElementById("td_" + evidence_id).innerHTML = "Changing...";
	var oXmlHttp = zXmlHttp.createRequest();
	
	oXmlHttp.open("get", "parts/save_cred_rating.php?evidence_id=" + evidence_id + "&new_value=" + new_value);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById("td_" + evidence_id).innerHTML = oXmlHttp.responseText;
			} else {
				document.getElementById("td_" + evidence_id).innerHTML = "(Save error.)";
			}
		}            
	}
	oXmlHttp.send(null);
}



function saveCredWeight(evidence_id) {
	var new_value = document.getElementById(evidence_id).value;
	document.getElementById("td_" + evidence_id).innerHTML = "Changing...";
	var oXmlHttp = zXmlHttp.createRequest();
	
	oXmlHttp.open("get", "parts/save_cred_weight.php?evidence_id=" + evidence_id + "&new_value=" + new_value);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById("td_" + evidence_id).innerHTML = oXmlHttp.responseText;
			} else {
				document.getElementById("td_" + evidence_id).innerHTML = "(Save error.)";
			}
		}            
	}
	oXmlHttp.send(null);
}



function inviteViewer() {
	var viewerEmail = document.getElementById("inviteViewerEmail").value;
	document.getElementById("inviteViewerResult").innerHTML = "...";
	var oXmlHttp = zXmlHttp.createRequest();
	
	oXmlHttp.open("get", "project_invite_viewer.php?project_id=<?=$active_project->id?>&viewerEmail=" + viewerEmail);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById("inviteViewerResult").innerHTML = oXmlHttp.responseText;
			} else {
				document.getElementById("inviteViewerResult").innerHTML = "(Error.)";
			}
		}            
	}
	oXmlHttp.send(null);
}



function goToPrintPage() {
	window.location = "<?=$_SERVER['REQUEST_URI']?>/print/" + sortColsBy + "/" + last_sort_1 + "/" + last_sort_1_dir + "/" + last_sort_2 + "/" + last_sort_2_dir + "/" + dccDateAdded + "" + dccDateOfSource + "" + dccType + "" + dccCode + "" + dccFlag + "" + dccCredWeight + "" + dccDiag + "/";	
}



function confirm_delete(url) {
	input_box = confirm("Are you sure you want to delete this? Cannot undo!");
	if (input_box == true) {
		input_box = confirm("All data associated with this project such as evidence and hypotheses will also be deleted. Still want to delete?");
		if (input_box == true) {
			location.href = url;
		}
	}
}


	
	</script>
	
	
</head>
	<!--BRIDGE-SPECIFIC MATERIAL (replaceHeader function) -->

<body onload="setTimeout('Effect.Fade(\'statusMessage\')',2500); setTimeout('Effect.Fade(\'statusMessage2\')',2500); startScrollingDetector(); bridge.replaceHeader('BridgeHeader', '1');">
	
	<!--END BRIDGE-SPECIFIC MATERIAL -->


<input type="hidden" id="project_id" value="<?=$active_project->id?>" />



<?php include("parts/header.php"); ?>







<?php


	
if( $active_user->logged_in ) { ?>
	


<?php include("parts/menu_sidebar.php"); ?>




<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">

				<?php if ($active_project->id === NULL) { ?>
					<h2>This project does not exist.</h2>
				<?php } elseif  ( !in_array($active_user->id, $active_project->users) && $active_project->directory != "y" ) { ?>
					<h2>This is a private project.</h2>
					<p><a class="button" href="<?=$base_URL?>project/<?=$active_project->id?>/join">Request permission to join this project</a></p>
				<?php } else {
				?>
				
					<h2 class="classTitle">Project: <?=$active_project->title?> 
					<?php if( !$print_mode ) { ?><span class="showHideDetails" id="showHideDetails"><a style="cursor: pointer;" onclick="showDetails();">Show details</a></span><?php } ?>
					</h2>
					
					
					
					<?php if( !$print_mode ) { ?>
					
					
							
					<div class="projectDetails" id="projectDetails" style="display: none;">
					
					
					
					<p><?=$active_project->description?></p>
					
					<div class="projectInfo">
					
					
					<!--<p><b>Owner:</b> <a href="<?=$base_URL?>profile/<?=$active_owner->username?>"><?=$active_owner->name?></a></p>-->
					
					<p class="otherMembers"><b>Members:</b> <?php
					
					$active_project->getUsers();
					
					for( $j = 0; $j < count($active_project->users); $j++ ) {
						$this_user = new User();
						$this_user->populateFromId($active_project->users[$j]);
						echo('<a href="'. $base_URL . 'profile/' . $this_user->username . '">' . $this_user->name . '</a> ');
						if ($this_user->username == $active_owner->username) {
							echo "(Owner)";
						}
					
					}
					
					if( count($active_project->users) == 0 ) { echo("None."); }
					
					?></p>
					
					<?php if( $active_project->open == "n" ) { ?>
					
					<p class="otherMembers"><b>View-Only Members:</b> <?php
					
					for( $j = 0; $j < count($active_project->users_view_only); $j++ ) {
						$this_user = new User();
						$this_user->populateFromId($active_project->users_view_only[$j]);
						echo('<a href='. $base_URL . '"/profile/' . $this_user->username . '">' . $this_user->name . '</a> ');
					}
					
					if( count($active_project->users_view_only) == 0 ) { echo("None."); }
					
					?> <span class="showHideInviteViewer" id="showHideInviteViewer"><a class="inviteViewer" onclick="showInviteViewer();">Invite</a></span></p>
					
					
					
					<div class="inviteViewer" id="inviteViewer" style="display: none;">
					
					<input type="hidden" name="project_id" value="<?=$active_project->id?>" />
					
					<p>E-mail Address: <input id="inviteViewerEmail" type="text" size="30" name="inviteViewerEmail" /> <input type="button" value="Invite" onclick="inviteViewer();" /> <span id="inviteViewerResult"></span></p>
					
					</div>
					
					
					
					<?php } ?>
					
					
					
					
					<p class="otherMembers"><b>Keywords:</b> <?=$active_project->keywords?></p>
					
					<p class="otherMembers"><b>Overall Project Classification:</b> <?=Project::classificationTextStyled($active_project->classification)?></p>
					
					<p class="otherMembers"><b>Privacy Settings: </b><?php if( $active_project->public == "y" ) { ?>
					This project's data is <b>public</b> for all to see,
					<?php } else { ?>
					This project's data is <b>private</b>, 
					<?php } ?>
					
					<?php if( $active_project->open == "y" ) { ?>
					and anyone may join <b>without permission</b>.</p>
					<?php } else { ?>
					<span class="closed"></span>and new users <b>must request permission</b> to join.</p>
					<?php } ?>
					
					<?php if( in_array($active_user->id, $active_project->users) && $active_user->id != $active_project->user_id ) { ?>
					
					<?php if( !$print_mode ) { ?><p class="leaveProject"><a href="<?=$base_URL?>project/<?=$active_project->id?>/leave">Leave this project</a></p><?php } ?>
					
					<?php } ?>
					
					<?php if( !$print_mode ) { ?><?php if( !$is_firefox ) { ?><p><a onclick="window.open ('/project/<?=$active_project->id?>/chat','Chat');" style="color: #FF0000;">Project Chat</a> (pop-up window)</p><?php } ?><?php } ?>
					
					
					
					<?php if( $active_user->id == $active_project->user_id ) { ?>
					<p class="delete"><a href="JavaScript:confirm_delete('/project/<?=$active_project->id?>/delete');">Delete this Project</a><br /><span>This can not be undone, so <b>be careful</b>.</span></p>
					<?php } ?>
					
					
					
					</div>
					
					
					
					</div>
					
					
					
					<?php } ?>
					
					
					
					<?php if( in_array($active_user->id, $active_project->users) || in_array($active_user->id, $active_project->users_view_only) || $active_project->public =="y" ) { ?>
					
					
					
					<?php if( !$print_mode ) { ?>
					
					<p class="subMenu">
					<?php if( in_array($active_user->id, $active_project->users)) { ?>
					<a href="<?=$base_URL?>project/<?=$active_project->id?>">Personal Matrix</a> 
					<?php } else { ?>
					<a href="<?=$base_URL?>project/<?=$active_project->id?>/join">Join Project</a> 
					<?php } ?>
					<a href="<?=$base_URL?>project/<?=$active_project->id?>/group">Group Matrix</a> 
					<?php if( in_array($active_user->id, $active_project->users)) { ?>
					<a href="<?=$base_URL?>project/<?=$active_project->id?>/evidence/new">Enter Evidence/Arguments</a>  <!--<a href="<?=$base_URL?>project/<?=$active_project->id?>/export">Export Matrix</a> -->
					<?php } ?>
					<?php if( $active_user->id == $active_project->user_id) { ?><a href="<?=$base_URL?>project/<?=$active_project->id?>/hypothesis/new">Enter Hypotheses</a> <a href="<?=$base_URL?>project/<?=$active_project->id?>/edit">Edit Project Options</a> <?php } ?>
					</p>
					
					
					
					<?php } ?>
					
					
					
					<?php include("parts/project_" . $part . ".php"); ?>
				
				<?php } else { ?>
				
				
				
				<?php 
				$active_project->getJoinRequests();
				//if anyone can join this project, then display Join This Project link. Otherwise, display Request Permission link
				if( $active_project->open == "y" ) { ?>
				<p><a class="button" href="<?=$base_URL?>project/<?=$active_project->id?>/join">Join this project</a></p>
				<?php } else if( in_array($active_user->id, $active_project->join_requests) ) { ?>
				<p><i><b>You have requested permission to join this project. The project owner has been notified. When your request is acted upon, there will be a notification on your <a href="<?=$base_URL?>">home page</a>.</b></i></p>
				<?php } else { ?>
				<p><a class="button" href="<?=$base_URL?>project/<?=$active_project->id?>/join">Request permission to join this project</a></p>
				<?php } ?>
				
				
				
				<?php } ?>


			</div>
		</div>
	</div>
</div>

<?php } ?>

<?php } else { ?>



<?php include("parts/login_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">

<h2>Access Denied</h2>

<p>You are not authorized to view this page.</p>

			</div>
		</div>
	</div>
</div>

<?php } ?>

<?php include("parts/footer.php"); ?>


</div> <!--removing this screws up the Chat tab. -->


<?php if( !$print_mode ) { ?>
<?php if( $is_firefox || !$is_firefox ) { include("parts/chat_panel.php"); } ?>
<?php } ?>





</body>
</html>