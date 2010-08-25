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
<h3>Edit Project</h3>



<form name="nav" method="post" class="edit" action="edit_project_action.php">

<input type="hidden" name="project_id" value="<?=$active_project->id?>" />

<div class="form">

<h4>Reassign Project Owner</h4>

<p style="margin-bottom: 0px;"><select name="user_id"><option value="0">--- No Change ---</option><?php

$active_project->getUsers();

for( $j = 0; $j < count($active_project->users); $j++ ) {
	if( $active_project->users[$j] != $active_user->id ) {
		$this_user = new User();
		$this_user->populateFromId($active_project->users[$j]);
		echo('<option value="' . $this_user->id . '">' . $this_user->name . '</a> ');
	}
}

?></select>
<?php 	if (count($active_project->users) == 1) {
			echo "<p class=\"formNote\">You may not transfer ownership because you are the only member of this project. To appoint a new owner, first have them become a project member.</p>";
		}	
			else { 
			echo "<p class=\"formNote\">If you change this, you'll no longer have access to this page.</p>";
		}
?>
<h4>Title</h4>

<p><input type="text" name="title" value="<?=$active_project->title?>" size="20" /></p>

<p class="formNote">A short phrase or question that summarizes the project.</p>

<h4>Description</h4>

<p><textarea rows="4" name="description" cols="30"><?=$active_project->description?></textarea></p>

<h4>Keywords</h4>

<p><textarea rows="4" name="keywords" cols="30"><?=$active_project->keywords?></textarea></p>

<p class="formNote">Comma-seperated. Optional.</p>

<h4>Project's Overall Classification</h4>

<p><select name="classification">
	<option value="U" <?php if( $active_project->classification == 'U' ) { echo('selected'); } ?> >Unclassified</option>
	<option value="C" <?php if( $active_project->classification == 'C' ) { echo('selected'); } ?> >Confidential</option>
	<option value="S" <?php if( $active_project->classification == 'S' ) { echo('selected'); } ?> >Secret</option>
	<option value="TS" <?php if( $active_project->classification == 'TS' ) { echo('selected'); } ?> >Top Secret</option>
</select></p>
<br/>
<div class="privacySettings">
<h3>Project Privacy <?php helpLink('howto_project_management.php#project_privacy') ?></h3>
<br />
<p class="formNote">Note: The below options enable you to decide whether your project 
is listed in your organization's directory of ACH projects, and, if so, the 
circumstances under which others may view or join your project. The 
directory provides a basic description of the project and lists its participants.</p><br />

<input type="radio" name="directory" value="n" onClick="Disab(1)" <?php if( $active_project->directory == 'n' ) { echo('checked'); } ?> /><strong>Private Project</strong>
<p class="formNote">This project will not be listed in the directory. You will select and communicate directly with any individuals whom you 
want to view your work or to participate with you in a collaborative project. </p>

<br/>______________<br/><br/>

<p><input type="radio" name="directory" value="y" onClick="Disab(2)" <?php if( $active_project->directory == 'y' ) { echo('checked');} else {echo('unchecked');} ?> />
<strong>Open Project</strong></p>
<p class="formNote">This project will be listed in the directory. The following options apply to this listing:</p>
<br/>
<p>&nbsp;&nbsp;<input type="radio" name="public" value="n" <?php if( $active_project->public == 'n' && $active_project->directory == 'y') { echo('checked'); } ?> /><em>Restricted Viewership</em>. 
Anyone who wants to view your project's data and discussion must first obtain your approval.
<br />
&nbsp;&nbsp;<input type="radio" name="public" value="y" <?php if( $active_project->public == 'y' && $active_project->directory == 'y' ) { echo('checked'); } ?> /><em>Publicly Viewable</em>. 
Anyone user will have access to view this project's data and discussion at any time.</p>
<br/>
<p>&nbsp;&nbsp;<input type="radio" name="open" value="n" <?php if( $active_project->open == 'n' && $active_project->directory == 'y') { echo('checked'); } ?> /><em>Restricted Membership</em>. 
Anyone who wants to become a member and active participant in this project must 
contact you and ask for your permission.
<br/>
&nbsp;&nbsp;<input type="radio" name="open" value="y" <?php if( $active_project->open == 'y' && $active_project->directory == 'y') { echo('checked'); } ?> /><em>Open Membership</em>. <span class="formNote">
&nbsp;&nbsp;Anyone who wishes to contribute to this project is welcome to join it and become 
active members. </span></p>
<br/>
</div>


<p class="submit"><input class="button" type="submit" value="Save" /></p>
<p class="formNote">NOTE: As the project owner, you may change these settings at any time.</p>








</div>

</form>