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

include("../code/includes.php");

$this_rating = $_REQUEST['new_value'];

$cell_id = $_REQUEST['cell_id'];

$evidence_id = substr($cell_id, strpos($cell_id, "_")+1, strpos($cell_id, "-")-strpos($cell_id, "_")-1);
$hypothesis_id = substr($cell_id, strpos($cell_id, "-")+1, strpos($cell_id, "_", strpos($cell_id, "-"))-strpos($cell_id, "-")-1);

//echo($evidence_id . " " . $hypothesis_id);

$exists = FALSE;

$result = mysql_do("SELECT * FROM ratings WHERE evidence_id='$evidence_id' AND hypothesis_id='$hypothesis_id' AND user_id='$active_user->id'");
while($query_data = mysql_fetch_array($result)) {
	$exists = TRUE;
}

//if( $this_rating != "" ) {
	if( $exists ) {
		mysql_do("UPDATE ratings SET rating='$this_rating' WHERE evidence_id='$evidence_id' AND hypothesis_id='$hypothesis_id' AND user_id='$active_user->id'");
	} else {
		mysql_do("INSERT INTO ratings (rating, evidence_id, hypothesis_id, user_id) VALUES ('$this_rating', '$evidence_id', '$hypothesis_id' ,'$active_user->id')");
	}
//}
	
?>				

<select onChange="saveCellRating('<?=$cell_id?>');" class="table" id="<?=$cell_id?>" name="<?=$cell_id?>">
<option value="">Select:</option>
<option <?php if($this_rating=="Very Inconsistent") { echo("selected"); }?> value="Very Inconsistent">Very Incons't</option>
<option <?php if($this_rating=="Inconsistent") { echo("selected"); }?> value="Inconsistent">Inconsistent</option>
<option <?php if($this_rating=="N/A") { echo("selected"); }?> value="N/A">N/A</option>
<option <?php if($this_rating=="Neutral") { echo("selected"); }?> value="Neutral">Neutral</option>
<option <?php if($this_rating=="Consistent") { echo("selected"); }?> value="Consistent">Consistent</option>
<option <?php if($this_rating=="Very Consistent") { echo("selected"); }?> value="Very Consistent">Very Cons't</option>
</select>