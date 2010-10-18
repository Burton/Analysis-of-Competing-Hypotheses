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
<h3>View Partner Matrix</h3>

<?php

$ratings_user = new User();
$ratings_user->populateFromId($_REQUEST['ratings_user_id']);

?>

<p>Viewing ratings by <b><?=$ratings_user->name?></b>.</p>



<table cellspacing="0" cellpadding="0" border="0" class="sort-table" id="userMatrix"><thead><tr><th class="hypothesis"></th>
<?php

$active_project->getEandH();

?>

	<td class="dclDateAdded" style="display: none;">Date Added</td>
	<td class="dclDateOfSource" style="display: none;">Date of Source</td>
	<td class="dclType" style="display: none;">Type</td>
	<td class="dclCode" style="display: none;">Code</td>
	<td class="dclFlag" style="display: none;">Flag</td>

<?php

for( $j = 0; $j < count($active_project->hypotheses); $j++ ) {
	$this_hypothesis = new Hypothesis();
	$this_hypothesis->populateFromId($active_project->hypotheses[$j]);
	echo('<th class="hypothesis" onmouseover="return overlib(\'' . addslashes($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $active_project->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a></th>');
}

echo('</tr></thead><tbody>');

for( $i = 0; $i < count($active_project->evidence); $i++ ) {
	$this_evidence = new Evidence();
	$this_evidence->populateFromId($active_project->evidence[$i]);
	echo('<tr><td class="evidence" onmouseover="return overlib(\'' . addslashes($this_evidence->details) . '\', CAPTION, \'Evidence\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $active_project->id . '/evidence/' . $this_evidence->id . '">' . $this_evidence->name . '</a></td>');

?>

	<td class="dcDateAdded" style="display: none;"><?=$this_evidence->created?></td>
	<td class="dcDateOfSource" style="display: none;"><?=substr($this_evidence->date_of_source, 0, 10)?></td>
	<td class="dcType" style="display: none;"><?=$this_evidence->type?></td>
	<td class="dcCode" style="display: none;"><?=$this_evidence->code?></td>
	<td class="dcFlag" style="display: none;"><a id="flag_<?=$this_evidence->id?>" onclick="switchFlag('flag_<?=$this_evidence->id?>', <?=$this_evidence->id?>);"><?php if( $this_evidence->flag == "y" ) { echo("<img src='$base_URL/images/icons/flag_red.png' />"); } else { echo("<img src='$base_URL/images/icons/bullet_add.png' />"); } ?></a></td>
	
<?php

	for( $j = 0; $j < count($active_project->hypotheses); $j++ ) {
		$this_hypothesis = new Hypothesis();
		$this_hypothesis->populateFromId($active_project->hypotheses[$j]);
		$this_rating = "";
		$result = mysql_do("SELECT * FROM ratings WHERE evidence_id='$this_evidence->id' AND hypothesis_id='$this_hypothesis->id' AND user_id='$ratings_user->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this_rating = $query_data['rating'];
		}
		$this_rating_style = strtolower(str_replace(" ", "_", str_replace("/", "", $this_rating)));
		?>
		<td class="<?=$this_rating_style?>"><?=$this_rating?></td>
		
<?php	}
	echo('</tr>');	
}

?>
</tbody></table>

<script type="text/javascript">
var st1 = new SortableTable(document.getElementById("userMatrix"), ["String", "String", "String", "String", "String", "String", "String", "String", ]);
</script>

