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

$project_list = implode(", ", $active_user->projects);

?>

<h2>Recent Activity</h2>

<p style="color: #555555;">Activity in your projects in the past week.</p>













<?php

$total_counter = 0;

$counter = 0;

//RETRIEVE ALL NEW EVIDENCE ITEMS ADDED TO USER'S PROJECTS IN THE LAST SEVEN DAYS
$result = mysql_do("SELECT * FROM evidence WHERE project_id IN ($project_list) AND created > DATE_SUB(CURDATE(),INTERVAL 7 DAY) ORDER BY `created` DESC LIMIT 20;");
while($query_data = mysql_fetch_array($result)) {

	if( $counter == 0 ) { ?>
<h3>New Evidence in Your Projects</h3>
<div class="recentEvidenceHypotheses">
	<?php }

	// Probably needs optimizing.
	$this_project = new Project();
	$this_project->get($query_data['project_id']);
	
	$this_evidence = new Evidence();
	$this_evidence->get($query_data['id']);
	
	$this_user = new User();
	$this_user->get($query_data['user_id']);
	
	$counter++;
		
?>

<div class="recentEvidenceHypothesis">

<p class="item"><a href="<?=$base_URL?>project/<?=$this_project->id?>/evidence/<?=$this_evidence->id?>"><?=$this_evidence->name?></a> in project <a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a></p>

<?php if( $this_evidence->details != "" ) { ?>
<p class="description">Details: <i>"<?=condenseComment($this_evidence->details)?>"</i></p>
<?php } ?>

<p class="details">Added by <a href="<?=$base_URL?>profile/<?=$this_user->username?>"><?=$this_user->name?></a> on <b style="color: #888888;"><?=date("M d, g:ia", strtotime($query_data['created']))?></b></p>

</div>

<?php } ?>

<?php if( $counter > 0 ) { ?>
</div>
<?php }

$total_counter += $counter;

?>














<?php

$counter = 0;

//RETRIEVE ALL NEW HYPOTHESES ADDED TO USER'S PROJECTS IN THE LAST SEVEN DAYS
$result = mysql_do("SELECT * FROM hypotheses WHERE project_id IN ($project_list) AND created > DATE_SUB(CURDATE(),INTERVAL 7 DAY) ORDER BY `created` DESC LIMIT 20;");
while($query_data = mysql_fetch_array($result)) {

	if( $counter == 0 ) { ?>
<h3>New Hypotheses in Your Projects</h3>

<div class="recentEvidenceHypotheses">
	<?php }

	// Probably needs optimizing.
	$this_project = new Project();
	$this_project->get($query_data['project_id']);
	
	$this_hypothesis = new Hypothesis();
	$this_hypothesis->get($query_data['id']);
	
	$this_user = new User();
	$this_user->get($query_data['user_id']);
	
	$counter++;
		
?>

<div class="recentEvidenceHypothesis">

<p class="item"><a href="<?=$base_URL?>project/<?=$this_project->id?>/hypothesis/<?=$this_hypothesis->id?>"><?=$this_hypothesis->label?></a> in project <a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a></p>

<?php if( $this_hypothesis->description != "" ) { ?>
<p class="description">Description: <i>"<?=condenseComment($this_hypothesis->description)?>"</i></p>
<?php } ?>

<p class="details">Added by <a href="<?=$base_URL?>profile/<?=$this_user->username?>"><?=$this_user->name?></a> on <b style="color: #888888;"><?=date("M d, g:ia", strtotime($query_data['created']))?></b></p>

</div>

<?php } ?>

<?php if( $counter > 0 ) { ?>
</div>
<?php }

$total_counter += $counter;

?>













<?php

$counter = 0;

$active_user->getComments();

$comments_list = implode(", ", $active_user->comments);
//RETRIEVE ALL NEW REPLIES TO USER'S MESSAGE BOARD COMMENTS FROM THE LAST SEVEN DAYS

$result = mysql_do("SELECT * FROM comments WHERE reply_to_id IN ($comments_list) AND created > DATE_SUB(CURDATE(),INTERVAL 7 DAY) ORDER BY `created` DESC LIMIT 20;");
while($query_data = mysql_fetch_array($result)) {

	if( $counter == 0 ) { ?>
<h3>Replies to Your Comments</h3>

<div class="recentComments">
	<?php }

	// Probably needs optimizing.
	$this_project = new Project();
	$this_project->get($query_data['project_id']);
	
	if( $query_data['evidence_id'] > 0 ) {
		$this_evidence = new Evidence();
		$this_evidence->get($query_data['evidence_id']);
	}
	
	if( $query_data['hypothesis_id'] > 0 ) {
		$this_hypothesis = new Hypothesis();
		$this_hypothesis->get($query_data['hypothesis_id']);
	}
	
	$this_user = new User();
	$this_user->get($query_data['user_id']);
	
	$this_reply_comment = new Comment();
	$this_reply_comment->get($query_data['reply_to_id']);
	
	$counter++;
		
?>

<div class="recentComment">

<p class="comment"><a href="<?=$base_URL?>profile/<?=$this_user->username?>"><?=$this_user->name?></a> wrote: <i>"<?=condenseComment($query_data['comment'])?>"</i> <a href="<?=$base_URL?>project/<?=$this_project->id?>/<?php

if( $query_data['evidence_id'] > 0 ) {
	echo("evidence/" . $this_evidence->id);
} else if( $query_data['hypothesis_id'] > 0 ) {
	echo("hypothesis/" . $this_hypothesis->id);
}

?>#comment_<?=$query_data['id']?>" class="read">Read</a></p>



<p class="reply">In reply to your comment: <i>"<?=$this_reply_comment->comment?>"</i> <a href="<?=$base_URL?>project/<?=$this_project->id?>/<?php

if( $query_data['evidence_id'] > 0 ) {
	echo("evidence/" . $this_evidence->id);
} else if( $query_data['hypothesis_id'] > 0 ) {
	echo("hypothesis/" . $this_hypothesis->id);
}

?>#comment_<?=$this_reply_comment->id?>" class="readLight">Read</a></p>



<p class="which"><b style="color: #666666;"><?=date("M d, g:ia", strtotime($query_data['created']))?></b> &sim; 

<?php if( $query_data['evidence_id'] > 0 ) { ?>
Evidence: <a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> &rarr; <a href="<?=$base_URL?>project/<?=$this_project->id?>/evidence/<?=$this_evidence->id?>"><?=$this_evidence->name?></a></p>
<?php } else if( $query_data['hypothesis_id'] > 0 ) { ?>
Hypothesis: <a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> &rarr; <a href="<?=$base_URL?>project/<?=$this_project->id?>/hypothesis/<?=$this_hypothesis->id?>"><?=$this_hypothesis->label?></a></p>
<?php } ?>

</div>

<?php } ?>

<?php if( $counter > 0 ) { ?>
</div>
<?php }

$total_counter += $counter;

?>












<?php

$counter = 0;

//RETRIEVE ALL NEW MESSAGE BOARD COMMENTS ADDED TO USER'S PROJECTS IN THE LAST SEVEN DAYS
$result = mysql_do("SELECT * FROM comments WHERE project_id IN ($project_list) AND created > DATE_SUB(CURDATE(),INTERVAL 7 DAY) ORDER BY `created` DESC LIMIT 20;");
while($query_data = mysql_fetch_array($result)) {

	if( $counter == 0 ) { ?>
<h3>Comments in Your Projects</h3>

<div class="recentComments">
	<?php }

	// Probably needs optimizing.
	$this_project = new Project();
	$this_project->get($query_data['project_id']);
	
	if( $query_data['evidence_id'] > 0 ) {
		$this_evidence = new Evidence();
		$this_evidence->get($query_data['evidence_id']);
	}
	
	if( $query_data['hypothesis_id'] > 0 ) {
		$this_hypothesis = new Hypothesis();
		$this_hypothesis->get($query_data['hypothesis_id']);
	}
	
	$this_user = new User();
	$this_user->get($query_data['user_id']);
	
	$counter++;
		
?>

<div class="recentComment">

<p class="comment"><a href="<?=$base_URL?>profile/<?=$this_user->username?>"><?=$this_user->name?></a> wrote: <i>"<?php

$num_words_to_show = 10;

$words = explode(" ", $query_data['comment']);

if( count($words) > $num_words_to_show ) {
	$is_long = true;
	$comment = "";
	for( $i = 0; $i < $num_words_to_show; $i++ ) {
		$comment .= $words[$i] . " ";
	}
	$comment .= " <small>[...]</small>";
} else {
	$comment = $query_data['comment'];
}

echo($comment);

?>"</i> <a href="<?=$base_URL?>project/<?=$this_project->id?>/<?php

if( $query_data['evidence_id'] > 0 ) {
	echo("evidence/" . $this_evidence->id);
} else if( $query_data['hypothesis_id'] > 0 ) {
	echo("hypothesis/" . $this_hypothesis->id);
}

?>#comment_<?=$query_data['id']?>" class="read">Read</a></p>

<p class="which"><b style="color: #666666;"><?=date("M d, g:ia", strtotime($query_data['created']))?></b> &sim; 

<?php if( $query_data['evidence_id'] > 0 ) { ?>
Evidence: <a href="<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> &rarr; <a href="<?=$base_URL?>project/<?=$this_project->id?>/evidence/<?=$this_evidence->id?>"><?=$this_evidence->name?></a></p>
<?php } else if( $query_data['hypothesis_id'] > 0 ) { ?>
Hypothesis: <a href="/<?=$base_URL?>project/<?=$this_project->id?>"><?=$this_project->title?></a> &rarr; <a href="<?=$base_URL?>project/<?=$this_project->id?>/hypothesis/<?=$this_hypothesis->id?>"><?=$this_hypothesis->label?></a></p>
<?php } ?>

</div>

<?php } ?>

<?php if( $counter > 0 ) { ?>
</div>
<?php }

$total_counter += $counter;

if( $total_counter == 0 ) { ?>

<p><i>None.</i></p>

<?php }

?>