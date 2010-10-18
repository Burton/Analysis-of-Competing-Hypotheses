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

$active_hypothesis = new Hypothesis();
$active_hypothesis->populateFromId($_REQUEST['hypothesis_id']);

$this_user = new User();
$this_user->populateFromId($active_hypothesis->user_id);

?>

<div id="nonEdit">

<?php if( $active_project->user_id == $active_user->id ) { ?><p><a onClick="document.getElementById('edit').style.display='block'; document.getElementById('nonEdit').style.display='none';">Edit hypothesis information</a> | <?php } ?>
<?php if( $active_project->user_id == $active_user->id ) { ?><a style="color: #FF0000;" onclick="javascript:confirm_delete_hypothesis(<?=$active_hypothesis->id?>);">Delete hypothesis</a></p><?php } ?>

<h3>Hypothesis: <?=$active_hypothesis->label?></h3>
<h4>Description: <?=$active_hypothesis->description?></h4>

<p class="info">Added by <a href="<?=$base_URL?>profile/<?=$this_user->username?>"><?=$this_user->name?></a> on <b><?=$active_hypothesis->created?></b>.</p>

<p class="xml"><a href="<?=$base_URL?>project/<?=$active_project->id?>/hypothesis/<?=$active_hypothesis->id?>/xml">XML</a></p>


</div>


<div id="edit" style="display: none;">

<form method="post" class="edit" action="project_edit_hypothesis_action.php">

<p><input class="button" type="submit" value="Save changes" /> <small><a onClick="document.getElementById('edit').style.display='none'; document.getElementById('nonEdit').style.display='block';">Cancel</a></small></p>

<form method="post" class="edit" action="project_edit_hypothesis_action.php">

<input type="hidden" name="hypothesis_id" value="<?=$active_hypothesis->id?>" />

<input type="hidden" name="project_id" value="<?=$active_project->id?>" />

<input type="hidden" name="user_id" value="<?=$active_hypothesis->user_id?>" />

<h3>Hypothesis Name: <input type="text" name="label" value="<?=$active_hypothesis->label?>" size="40" /></h3>

<h4>Description:</h4>

<p><textarea rows="4" name="description" cols="60"><?=$active_hypothesis->description?></textarea></p>

</div>
</form>



<h3 class="comments">Discuss this Hypothesis</h3>



<?php

$reply_depth = 0;

if( $active_hypothesis->showComments(0) ) {
} else {
	echo('<p><i>No comments.</i></p>');
}

?>



<form method="post" class="edit" action="add_comment_action.php">

<input type="hidden" name="this_url" value="<?=$_SERVER['REQUEST_URI']?>" />

<input type="hidden" name="user_id" value="<?=$active_user->id?>" />

<input type="hidden" name="evidence_id" value="0" />

<input type="hidden" name="project_id" value="<?=$active_project->id?>" />

<input type="hidden" name="hypothesis_id" value="<?=$active_hypothesis->id?>" />

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