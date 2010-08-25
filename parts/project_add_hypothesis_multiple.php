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



<h3>Enter Hypotheses <?php helpLink('howto_hypotheses.php') ?></h3>



<p class="evidenceSubmenu"><a href="<?=$base_URL?>/project/<?=$active_project->id?>/hypothesis/new">Single</a> <b>Multiple</b></p>

<p>Quick tips:
	<ul><li>All of your hypotheses must be mutually exclusive: if one is correct, all others must be false.</li>
		<li>Include all reasonable possibilities, including those that seem unlikely but not impossible.</li>
	</ul>
<a href="<?=$base_URL?>/help/hypotheses.php">More tips...</a></p>

<form name="newHypothesis" onsubmit="return validateMultiHypoFormOnSubmit(this)" class="formatted" method="post" class="edit" action="project_add_hypothesis_multiple_action.php">

<input type="hidden" name="project_id" value="<?=$id?>" />



<div style="float: left; margin-right: 20px; margin-bottom: 20px;">

<h4 style="color: red">Label (required)</h4>

<p><input type="text" name="label1" value="" size="20" /></p>

<h4>Description</h4>

<p><textarea rows="4" name="description1" cols="30"></textarea></p>

</div>



<div style="float: left; margin-right: 20px; margin-bottom: 20px;">

<h4>Label</h4>

<p><input type="text" name="label2" value="" size="20" /></p>

<h4>Description</h4>

<p><textarea rows="4" name="description2" cols="30"></textarea></p>

</div>



<div style="float: left; margin-right: 20px; margin-bottom: 20px;">

<h4>Label</h4>

<p><input type="text" name="label3" value="" size="20" /></p>

<h4>Description</h4>

<p><textarea rows="4" name="description3" cols="30"></textarea></p>

</div>



<div style="float: left; margin-right: 20px; margin-bottom: 20px;">

<h4>Label</h4>

<p><input type="text" name="label4" value="" size="20" /></p>

<h4>Description</h4>

<p><textarea rows="4" name="description4" cols="30"></textarea></p>

</div>



<p class="submit" style="clear: both;">
<input type="checkbox" name="add_more" /> Add more hypotheses after this. <br />
<input class="button" type="submit" onclick="isEmpty(document.getElementById('label'), 'Please Enter a Value')" value="Save" /> </p>

</form>



<?php } else { ?>

<p>You do not have permission to add hypotheses. Only the project owner may do so.</p>

<?php } ?>