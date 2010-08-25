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



<h3>Enter Evidence/Arguments <?php helpLink('howto_evidence.php') ?></h3>



<p class="evidenceSubmenu"><b>Single</b> <a href="<?=$base_URL?>/project/<?=$active_project->id?>/evidence/new/multiple">Multiple</a></p>



<form name="newEvidence" onsubmit="return validateEvidenceFormOnSubmit(this)" class="formatted" method="post" class="edit" action="project_add_evidence_action.php">

<input type="hidden" name="project_id" value="<?=$id?>" />

<h4 style="color: red">Evidence Name (required)</h4>

<p><input type="text" name="name" value="" size="40" /></p>

<h4>Evidence Notes <?php helpLink('howto_evidence.php#notes') ?></h4>
<p class="formNote">Additional details about this evidence/argument.</p>
<p><textarea rows="4" name="details" cols="60"></textarea></p>

<h4>Classification</h4>

<p><select name="classification">
  <option value="U">Unclassified</option>
  <option value="C">Confidential</option>
  <option value="S">Secret</option>
  <option value="TS">Top Secret</option>
  <option value="Compartmented">Compartmented</option>
</select></p>

<h4>Caveat</h4>

<p><select name="caveat">
  <option value="">(No caveat)</option>
  <option value="FOUO">FOUO/AIUO</option>
  <option value="SI">SI</option>
  <option value="TK">TK</option>
  <option value="HCS">HCS</option>
  <option value="G">G</option>
</select></p>

<h4>Type <?php helpLink('howto_evidence.php#type') ?></h4>

<p><select name="type">
  <option value="Assumption">Assumption</option>
  <option value="OSINT">OSINT</option>
  <option value="HUMINT">HUMINT</option>
  <option value="IMINT">IMINT</option>
  <option value="SIGINT">SIGINT</option>
  <option value="MASINT">MASINT</option>
</select></p>

<h4>Serial Number <?php helpLink('howto_evidence.php#serial') ?></h4>

<p><input type="text" name="serial_number" value="" size="20" /></p>

<h4>Credibility</h4>

<p><select name="credibility">
  <option value="none">---</option>
  <option value="credible">Credible</option>
  <option value="suspect">Suspect</option>
</select></p>

<h4>Date/Time <?php helpLink('howto_evidence.php#datetime') ?></h4>

<p><i>Format: YYYY-MM-DD HH:MM:SS. You may enter a date only, but not time only.</i></p>

<p><input type="text" name="date_of_source" value="" size="20" /></p>

<h4>Code <?php helpLink('howto_evidence.php#code') ?></h4>

<p><input type="text" name="code" value="" size="20" /></p>

<h4>Flagged</h4>

<p><select name="flag">
  <option value="n">No</option>
  <option value="y">Yes</option>
</select></p>

<p class="submit"><input class="button" type="submit" value="Save" /></p>

</form>


<?php } else { ?>

<p>You do not have permission to add evidence. You must first join this project.</p>

<?php } ?>