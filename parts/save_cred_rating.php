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

$evidence_id = $_REQUEST['evidence_id'];

$this_evidence_id = substr($evidence_id, 10);

$exists = FALSE;

$result = mysql_do("SELECT id FROM credibility WHERE user_id='$active_user->id' AND evidence_id='$this_evidence_id' LIMIT 1");
while($query_data = mysql_fetch_array($result)) {
	$exists = TRUE;
}

if( !$exists ) {
	mysql_do("INSERT INTO credibility (value, evidence_id, user_id, weight) VALUES ('$this_rating', '$this_evidence_id', '$active_user->id', '1')");
}

$result = mysql_do("SELECT id FROM credibility WHERE user_id='$active_user->id' AND evidence_id='$this_evidence_id' LIMIT 1");
while($query_data = mysql_fetch_array($result)) {
	
	$active_credibility = new Credibility();
	
	$active_credibility->populateFromId($query_data['id']);
	
	$active_credibility->switchCred($this_rating);

}
	
?>	<select onChange="saveCredRating('<?=$evidence_id?>');" name="<?=$evidence_id?>" id="<?=$evidence_id?>">
		<option value="y" <?php if( $this_rating != "n" ) { echo("selected"); } ?> >Credible</option>
		<option value="n" <?php if( $this_rating == "n" ) { echo("selected"); } ?> >Suspect</option>
	</select>