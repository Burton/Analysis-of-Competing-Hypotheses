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

$active_hypothesis = new Hypothesis();
$active_hypothesis->populateFromId($_REQUEST['hypothesis_id']);

?>

<h3>Cell Details</h3>

<h4>Evidence: <a href="<?=$base_URL?>/project/<?=$active_project->id?>/evidence/<?=$active_evidence->id?>"><?=$active_evidence->name?></a></h4>
<br/><?=$active_evidence->details?><br>

<h4>Hypothesis: <a href="<?=$base_URL?>/project/<?=$active_project->id?>/hypothesis/<?=$active_hypothesis->id?>"><?=$active_hypothesis->label?></a></h4>

<h4>User Ratings</h4>

<div class="userRatings">

<?php

$ratings = Array();

for( $k = 0; $k < count($active_project->users); $k++ ) {
	$this_user = new User();
	$this_user->populateFromId($active_project->users[$k]);
	$rating = $this_user->getRating($active_evidence->id, $active_hypothesis->id);
	$rating_score = getRatingScore($rating);
	if( $rating != "" ) {
		$ratings[] = getRatingScore($rating);
	}
	echo("<p><b>" . $this_user->name . ":</b> " . $rating . "</p>");
} ?>

</div>

<?php

$group_rating = getGroupRating(getStDev($ratings));

if( $group_rating <= 1 ) {
	echo("<p class='unanimity'>Consensus");
}

if( $group_rating == 2 ) {
	echo("<p class='mildDisagreement'>Mild Dispute");
}

if( $group_rating == 3 ) {
	echo("<p class='starkDisagreement'>Large Dispute");
}

if( $group_rating == 4 ) {
	echo("<p class='extremeDisagreement'>Extreme Dispute");
}


if( count($ratings) > 1 ) {
	echo("<br /><small>StDev: " . getStDev($ratings) . "</small>");
} else {
	echo("<br /><small>StDev: N/A; no ratings yet.</small>");
}
?>





<h3 class="comments">Discuss this Cell</h3>



<?php

$reply_depth = 0;

if( showCellComments($active_evidence->id, $active_hypothesis->id, 0) ) {
} else {
	echo('<p><i>No comments.</i></p>');
}

?>



<form method="post" class="edit" action="add_comment_action.php">

<input type="hidden" name="this_url" value="<?=$_SERVER['REQUEST_URI']?>" />

<input type="hidden" name="user_id" value="<?=$active_user->id?>" />

<input type="hidden" name="evidence_id" value="<?=$active_evidence->id?>" />

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