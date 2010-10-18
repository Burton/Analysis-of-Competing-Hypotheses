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
<?php if( in_array($active_user->id, $active_project->users)) { ?>



<h3>Enter Evidence/Arguments</h3>



<p class="evidenceSubmenu"><a href="<?=$base_URL?>project/<?=$active_project->id?>/evidence/new">Single</a> <b>Multiple</b></p>



<form name="newEvidence" onsubmit="return validateEvidenceFormOnSubmit(this)" class="formatted" method="post" class="edit" action="project_add_evidence_multiple_action.php">

<input type="hidden" name="project_id" value="<?=$id?>" />

<h4>Tab-seperated list of evidence (ideal for those logging evidence in a spreadsheet, eg Excel)</h4>

<p class="formNote">Please enter one piece of evidence per line. Evidence name and details must be separated by a tab.</p>

<p><textarea rows="14" name="all_evidence" cols="60"></textarea></p>

<p class="submit"><input class="button" type="submit" value="Save" /></p>

</form>



<?php } else { ?>

<p>You do not have permission to add evidence. You must first join this project.</p>

<?php } ?>