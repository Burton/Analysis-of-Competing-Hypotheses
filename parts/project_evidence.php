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

$active_evidence = new Evidence();
$active_evidence->populateFromId($_REQUEST['evidence_id']);

$this_user = new User();
$this_user->populateFromId($active_evidence->user_id);

?>

<div id="nonEdit">
<p><a onClick="document.getElementById('edit').style.display='block'; document.getElementById('nonEdit').style.display='none';">Edit evidence information</a><?php if( $active_project->user_id == $active_user->id ) { ?> |<a style="color: #FF0000; padding-left: 10px;" onclick="javascript:confirm_delete_evidence(<?=$active_evidence->id?>);">Delete evidence record</a><?php } ?></p>


<h3>Evidence: <?=$active_evidence->name?></h3>

<h4>Details: <?=$active_evidence->details?></h4><br>





<p class="classification"><b>Classification:</b> <?=showClassification($active_evidence->classification)?></p>

<p class="caveat"><b>Caveat: </b><?=showCaveat($active_evidence->caveat)?></p>

<p class="type"><b>Type: </b><?=$active_evidence->type?></p>

<p class="serial"><b>Serial Number: </b><?=$active_evidence->serial_number?>
<?php if ($active_evidence->serial_number != NULL) { ?>
<a href="<?=$base_URL?>/evidence/<?=$active_evidence->serial_number?>"><em> Who else is using this?</em></a></p>
<? } ?>

<p class="caveat"><b>Date and Time of Source: </b><?=substr($active_evidence->date_of_source, 0, 19)?></p>

<p class="type"><b>Code: </b><?=$active_evidence->code?></p>

<p class="serial"><b>Flagged: </b><?=$active_evidence->flag?></p>

<p class="xml"><a href="<?=$base_URL?>/project/<?=$active_project->id?>/evidence/<?=$active_evidence->id?>/xml">XML</a></p>



</div>



<div id="edit" style="display: none;">

<form method="post" class="edit" action="project_edit_evidence_action.php">

<p><input class="button" type="submit" value="Save changes" /> <small><a onClick="document.getElementById('edit').style.display='none'; document.getElementById('nonEdit').style.display='block';">Cancel</a></small></p>

<form method="post" class="edit" action="project_edit_evidence_action.php">

<input type="hidden" name="evidence_id" value="<?=$active_evidence->id?>" />

<input type="hidden" name="project_id" value="<?=$active_evidence->project_id?>" />

<input type="hidden" name="user_id" value="<?=$active_evidence->user_id?>" />

<h3>Evidence Name: <input type="text" name="name" value="<?=$active_evidence->name?>" size="40" /></h3>

<h4>Details:</h4>

<p><textarea rows="4" name="details" cols="60"><?=$active_evidence->details?></textarea></p>

<h4>Classification</h4>

<p><select name="classification">
  <option value="U" <?php if( $active_evidence->classification == "U" ) { echo('selected'); } ?> >Unclassified</option>
  <option value="C" <?php if( $active_evidence->classification == "C" ) { echo('selected'); } ?> >Confidential</option>
  <option value="S" <?php if( $active_evidence->classification == "S" ) { echo('selected'); } ?> >Secret</option>
  <option value="TS" <?php if( $active_evidence->classification == "TS" ) { echo('selected'); } ?> >Top Secret</option>
  <option value="Compartmented" <?php if( $active_evidence->classification == "Compartmented" ) { echo('selected'); } ?> >Compartmented</option>
</select></p>

<h4>Caveat</h4>

<p><select name="caveat">
  <option value="" <?php if( $active_evidence->caveat == "" ) { echo('selected'); } ?> >(No caveat)</option>
  <option value="FOUO" <?php if( $active_evidence->caveat == "FOUO" ) { echo('selected'); } ?> >FOUO/AIUO</option>
  <option value="SI" <?php if( $active_evidence->caveat == "SI" ) { echo('selected'); } ?> >SI</option>
  <option value="TK" <?php if( $active_evidence->caveat == "TK" ) { echo('selected'); } ?> >TK</option>
  <option value="HCS" <?php if( $active_evidence->caveat == "HCS" ) { echo('selected'); } ?> >HCS</option>
  <option value="G" <?php if( $active_evidence->caveat == "G" ) { echo('selected'); } ?> >G</option>
</select></p>

<h4>Type</h4>

<p><select name="type">
  <option value="Assumption" <?php if( $active_evidence->type == "Assumption" ) { echo('selected'); } ?> >Assumption</option>
  <option value="OSINT" <?php if( $active_evidence->type == "OSINT" ) { echo('selected'); } ?> >OSINT</option>
  <option value="HUMINT" <?php if( $active_evidence->type == "HUMINT" ) { echo('selected'); } ?> >HUMINT</option>
  <option value="IMINT" <?php if( $active_evidence->type == "IMINT" ) { echo('selected'); } ?> >IMINT</option>
  <option value="SIGINT" <?php if( $active_evidence->type == "SIGINT" ) { echo('selected'); } ?> >SIGINT</option>
  <option value="MASINT" <?php if( $active_evidence->type == "MASINT" ) { echo('selected'); } ?> >MASINT</option>
</select></p>

<h4>Serial Number</h4>

<p><input type="text" name="serial_number" value="<?=$active_evidence->serial_number?>" size="20" /></p>

<h4>Credibility</h4>

<?php

$this_credibility = new Credibility();
$this_credibility->getUserEvidence($active_evidence->id);

?>

<p>Remember, changing this will change the credibility of all of your pieces of evidence with the same serial number.</p>

<p><select name="credibility">
  <option value="none">---</option>
  <option <?php if( $this_credibility->value == "y" ) { echo("selected"); } ?> value="credible">Credible</option>
  <option <?php if( $this_credibility->value == "n" ) { echo("selected"); } ?> value="suspect">Suspect</option>
</select></p>

<h4>Date and Time of Source</h4>

<p><i>Format: YYYY-MM-DD HH:MM:SS. You may enter a date only, but not time only.</i></p>

<p><input type="text" name="date_of_source" value="<?=substr($active_evidence->date_of_source, 0, 19)?>" size="20" /></p>

<h4>Code</h4>

<p><input type="text" name="code" value="<?=$active_evidence->code?>" size="20" /></p>

<h4>Flagged</h4>

<p><select name="flag">
  <option value="n" <?php if( $active_evidence->flag != "y" ) { echo('selected'); } ?> >No</option>
  <option value="y" <?php if( $active_evidence->flag == "y" ) { echo('selected'); } ?> >Yes</option>
</select></p>
<br />
<p><input class="button" type="submit" value="Save changes" /> <small><a onClick="document.getElementById('edit').style.display='none'; document.getElementById('nonEdit').style.display='block';">Cancel</a></small></p>

</form>



</div>



<p class="info">Added by <a href="<?=$base_URL?>/profile/<?=$this_user->username?>"><?=$this_user->name?></a> on <b><?=$active_evidence->created?></b>.</p>





<h3 class="comments">Discuss this Evidence</h3>



<?php

$reply_depth = 0;

if( $active_evidence->showComments(0) ) {
} else {
	echo('<p><i>No comments.</i></p>');
}

?>



<form method="post" class="edit" action="add_comment_action.php">

<input type="hidden" name="this_url" value="<?=$_SERVER['REQUEST_URI']?>" />

<input type="hidden" name="user_id" value="<?=$active_user->id?>" />

<input type="hidden" name="evidence_id" value="<?=$active_evidence->id?>" />

<input type="hidden" name="hypothesis_id" value="0" />

<input type="hidden" name="project_id" value="<?=$active_project->id?>" />

<input type="hidden" name="reply_to_id" value="0" />

<h3 class="add_comment">Add Comment</h3>

<p><b>Comment</b></p>

<p><textarea rows="8" name="comment" cols="60"></textarea></p>

<p><b>Classification</b></p>

<p><select name="classification">
	<option value="U">Unclassified</option>
	<option value="C">Confidential</option>
	<option value="S">Secret</option>
	<option value="TS">Top Secret</option>
</select></p>

<p><b>Caveat</b></p>

<p><select name="caveat">
	<option value="">(No caveat)</option>
	<option value="FOUO">FOUO/AIUO</option>
	<option value="SI">SI</option>
	<option value="TK">TK</option>
	<option value="HCS">HCS</option>
	<option value="G">G</option>
</select></p>

<p class="submit"><input class="button" type="submit" value="Add Comment" /></p>

</form>