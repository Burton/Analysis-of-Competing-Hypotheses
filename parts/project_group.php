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
//if the matrix has no hypotheses, tell the user they need to add them...

		$result = mysql_query("SELECT * FROM hypotheses WHERE project_id='$active_project->id'");
		$result_evidence = mysql_query("SELECT * FROM evidence WHERE project_id='$active_project->id'");
		$count_evidence = mysql_num_rows($result_evidence);
		$count = mysql_num_rows($result);
		 if ($count == 0) {
			if( $active_user->id == $active_project->user_id)	{	
				
				//BRIDGE-SPECIFIC MATERIAL
				
				echo "<h2>You must <a href=\"$base_URL/project/$active_project->id/hypothesis/new\">add hypotheses</a> before continuing.</h2><p>Quick tips:
				<ul><li>All of your hypotheses must be mutually exclusive: if one is correct, all others must be false.</li>
				<li>Include all reasonable possibilities, including those that seem unlikely but not impossible.</li></ul></p>
				<p><a href=\"" . $base_URL . "help/hypotheses.php\">Read more about choosing good hypotheses</a>,
				 or <a href=\"https://mediawiki.bridge-ic.net/index.php?title=ACH:" . $active_project->title . "\">discuss potential hypotheses with your teammates on the BRIDGE wiki</a>.</p>"; 
				} else {
				echo "<h2>This matrix is empty. The project owner has not yet added any hypotheses.</h2>
				<p><a href=\"https://mediawiki.bridge-ic.net/index.php?title=ACH:" . $active_project->title . "\">Discuss potential hypotheses with your teammates on the BRIDGE wiki</a>.</p>";
				}
				//END BRIDGE-SPECIFIC MATERIAL

			} else if ($count_evidence == 0) {

//and if there are hypotheses but no evidence, tell the user to add them...

					echo "<h2>You must <a href=\"$base_URL/project/$active_project->id/evidence/new\">add evidence or arguments</a> 					before continuing.</h2>"; 
			} else {
			
//if there is at least one piece of evidence and one hypothesis, show the matrix
			
			?>
			
				<h3>Group Matrix <a onclick="goToPrintPage();"><img class="icon" src="<?$base_URL?>images/icons/printer.png" alt="Print this page" border="0" /></a></h3>
	
	
	
	<p><b>Consensus Guage:</b> <img style="position: relative; top: 4px; padding-left: 15px;" src="<?=$base_URL?>images/gauge.gif"></p>
	
	
	
	<?php
	
	$sort_field_1 = "created";
	$sort_field_1_dir = "asc";
	$sort_field_2 = "name";
	$sort_field_2_dir = "asc";
		
	?>
	
	
	
	<div class="groupMatrix">
	<p class="sortTab"><span id="groupMatrixSortTab_show_data_columns"><a style="cursor: pointer;" onclick="showSortTools('show_data_columns');">Show Data Columns</a></span> <span id="groupMatrixSortTab_sort_hypotheses"><a style="cursor: pointer;" onclick="showSortTools('sort_hypotheses');">Sort Hypotheses</a></span> <span id="groupMatrixSortTab_sort_evidence"><a style="cursor: pointer;" onclick="showSortTools('sort_evidence');">Sort Evidence</a></span> <span id="ajaxTableGroupLoading" style="color: #FF0000; font-weight: bold; font-size: 14px; position: relative; top: -2px; padding-left: 10px;"></span></p>
	
	
	
	<div class="sortTools" id="sortTools_show_data_columns" style="display: none;">
	
	
	
	<p><b>Show Data Columns:</b>
	
	<input type="checkbox" id="dateAdded" onclick="dccDateAdded = 1; if(document.getElementById('dateAdded').checked == true) { setStyleByClass('td','dclDateAdded','display',''); setStyleByClass('td','dcDateAdded','display',''); } else { setStyleByClass('td','dclDateAdded','display','none'); setStyleByClass('td','dcDateAdded','display','none'); }">Order Added 
	<input type="checkbox" id="dateOfSource" onclick="dccDateOfSource = 1; if(document.getElementById('dateOfSource').checked == true) { setStyleByClass('td','dclDateOfSource','display',''); setStyleByClass('td','dcDateOfSource','display',''); } else { setStyleByClass('td','dclDateOfSource','display','none'); setStyleByClass('td','dcDateOfSource','display','none'); }">Date/Time
	<input type="checkbox" id="type" onclick="dccType = 1; if(document.getElementById('type').checked == true) { setStyleByClass('td','dclType','display',''); setStyleByClass('td','dcType','display',''); } else { setStyleByClass('td','dclType','display','none'); setStyleByClass('td','dcType','display','none'); }">Type 
	<input type="checkbox" id="code" onclick="dccCode = 1; if(document.getElementById('code').checked == true) { setStyleByClass('td','dclCode','display',''); setStyleByClass('td','dcCode','display',''); } else { setStyleByClass('td','dclCode','display','none'); setStyleByClass('td','dcCode','display','none'); }">Code 
	<input type="checkbox" id="flag" onclick="dccFlag = 1; if(document.getElementById('flag').checked == true) { setStyleByClass('td','dclFlag','display',''); setStyleByClass('td','dcFlag','display',''); } else { setStyleByClass('td','dclFlag','display','none'); setStyleByClass('td','dcFlag','display','none'); }">Flag
	
	
	
	</div>
	
	
	
	<div class="sortTools" id="sortTools_sort_hypotheses" style="display: none;">
	
	
	
	<p><b>Sort Hypotheses Columns:</b>
	
	<select id="hypotheses_column_sort" onChange="setStyleByClass('th','hypothesis_colgroup_added','display','none'); setStyleByClass('th','hypothesis_colgroup_alpha','display','none'); setStyleByClass('th','hypothesis_colgroup_least_likely','display','none'); setStyleByClass('th','hypothesis_colgroup_most_likely','display','none'); setStyleByClass('th','hypothesis_colgroup_'+this.options[selectedIndex].value,'display',''); setStyleByClass('td','colgroup_added','display','none'); setStyleByClass('td','colgroup_alpha','display','none'); setStyleByClass('td','colgroup_least_likely','display','none'); setStyleByClass('td','colgroup_most_likely','display','none'); setStyleByClass('td','colgroup_'+this.options[selectedIndex].value,'display',''); sortColsBy = this.options[selectedIndex].value;">
		<option value="added">Date Added</option>
		<option value="most_likely">Most Likely</option>
		<option value="least_likely">Least Likely</option>
		<option value="alpha">Alphabetically</option>
	</select>
		
	</p>
	
	
	
	</div>
	
	
	
	<div class="sortTools" id="sortTools_sort_evidence" style="display: none;">
	
	
	
	<p><b>Sort Evidence Rows:</b></p> 
	
	<p>&nbsp;&nbsp;&nbsp;1: Choose first variable
	
	<select id="select_sort_1">
		<option value="created" <?php if( $sort_field_1 == "created" ) { echo("selected "); }?>>Order Added</option>
		<option value="diag" <?php if( $sort_field_1 == "diag" ) { echo("selected "); }?>>Diagnosticity</option>
		<option value="type" <?php if( $sort_field_1 == "type" ) { echo("selected "); }?>>Type</option>
		<option value="date_of_source" <?php if( $sort_field_1 == "date_of_source" ) { echo("selected "); }?>>Date/Time of Source</option>
		<option value="code" <?php if( $sort_field_1 == "code" ) { echo("selected "); }?>>Code</option>
		<option value="flag" <?php if( $sort_field_1 == "flag" ) { echo("selected "); }?>>Flag</option>
		<option value="name" <?php if( $sort_field_1 == "name" ) { echo("selected "); }?>>Name</option>
	</select>
	
	<select id="select_dir_1">
		<option value="asc" <?php if( $sort_field_1_dir == "asc" ) { echo("selected "); }?>>A-Z, 0-9</option>
		<option value="desc" <?php if( $sort_field_1_dir == "desc" ) { echo("selected "); }?>>Z-A, 9-0</option>
	</select>
	
	<br />
	
	&nbsp;&nbsp;&nbsp;2: Choose second variable
	
	<select id="select_sort_2">
		<option value="diag" <?php if( $sort_field_2 == "diag" ) { echo("selected "); }?>>Diagnosticity</option>
		<option value="created" <?php if( $sort_field_2 == "created" ) { echo("selected "); }?>>Order Added</option>
		<option value="type" <?php if( $sort_field_2 == "type" ) { echo("selected "); }?>>Type</option>
		<option value="date_of_source" <?php if( $sort_field_2 == "date_of_source" ) { echo("selected "); }?>>Date/Time of Source</option>
		<option value="code" <?php if( $sort_field_2 == "code" ) { echo("selected "); }?>>Code</option>
		<option value="flag" <?php if( $sort_field_2 == "flag" ) { echo("selected "); }?>>Flag</option>
		<option value="name" <?php if( $sort_field_2 == "name" ) { echo("selected "); }?>>Name</option>
	</select>
	
	<select id="select_dir_2">
		<option value="asc" <?php if( $sort_field_2_dir == "asc" ) { echo("selected "); }?>>A-Z, 0-9</option>
		<option value="desc" <?php if( $sort_field_2_dir == "desc" ) { echo("selected "); }?>>Z-A, 9-0</option>
	</select>
	
	<br />
	
	&nbsp;&nbsp;&nbsp;3: <input id="select_submit" type="button" value="Sort!" onclick="sortGroupTable2(document.getElementById('select_sort_1').value, document.getElementById('select_dir_1').value, document.getElementById('select_sort_2').value, document.getElementById('select_dir_2').value);" />
	
	</p>
	
	
	
	</div>
	
	
	
	<div id="ajaxTableGroup"><?php include_once("ajax_table.php"); ?></div>
	
	
	
	</div>
	
	<div style="clear: both;">
	
	
	<?php
	
	$active_project->getUsers();
	
	if( count($active_project->users) > 1 ) { ?>
	
	<form style="margin: 0px;" method="post" class="edit" action="project_compare_two_users_action.php">
	
	<input type="hidden" name="project_id" value="<?=$active_project->id?>">
	
	<p style="margin-bottom: 0px;">Compare the ratings of <select name="compare_user_id"><?php
	
	for( $j = 0; $j < count($active_project->users); $j++ ) {
		$this_user = new User();
		$this_user->populateFromId($active_project->users[$j]);
		echo('<option value="' . $this_user->id . '"');
		if( $active_project->users[$j] == $active_user->id ) {
			echo(' selected ');
		}
		echo('>' . $this_user->name . '</a> ');
	}
	
	?></select> with: <select name="compare_user_id_2"><?php
	
	$active_project->getUsers();
	
	for( $j = 0; $j < count($active_project->users); $j++ ) {
		if( $active_project->users[$j] != $active_user->id ) {
			$this_user = new User();
			$this_user->populateFromId($active_project->users[$j]);
			echo('<option value="' . $this_user->id . '">' . $this_user->name . '</a> ');
		}
	}
	
	?></select> <input type="submit" value="Compare..." /></p>
	
	</form>
	
	
	
	<form style="margin: 0px;" method="post" class="edit" action="project_ratings_user_action.php">
	
	<input type="hidden" name="project_id" value="<?=$active_project->id?>">
	
	<p style="margin-bottom: 0px;">View others' personal matrices: <select name="ratings_user_id"><?php
	
	$active_project->getUsers();
	
	for( $j = 0; $j < count($active_project->users); $j++ ) {
		if( $active_project->users[$j] != $active_user->id ) {
			$this_user = new User();
			$this_user->populateFromId($active_project->users[$j]);
			echo('<option value="' . $this_user->id . '">' . $this_user->name . '</a> ');
		}
	}
	
	?></select> <input type="submit" value="View..." /></p>
	
	</form>
	
	<?php } ?>
	
	
	
	</div>

<?php } ?>
