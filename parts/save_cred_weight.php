<?php
/* ////////////////////////////////////////////////////////////////////////////////
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

include("../code/includes.php");

$this_rating = $_REQUEST['new_value'];

$evidence_id = $_REQUEST['evidence_id'];

$this_evidence_id = substr($evidence_id, 17);

$exists = FALSE;

$result = mysql_do("SELECT * FROM credibility WHERE evidence_id='$this_evidence_id' AND user_id='$active_user->id'");
while($query_data = mysql_fetch_array($result)) {
	$exists = TRUE;
}

//if( $this_rating != "" ) {
	if( $exists ) {
		mysql_do("UPDATE credibility SET weight='$this_rating' WHERE evidence_id='$this_evidence_id' AND user_id='$active_user->id'");
	} else {
		mysql_do("INSERT INTO credibility (weight, evidence_id, user_id, value) VALUES ('$this_rating', '$this_evidence_id', '$active_user->id', 'y')");
	}
//}
	
?>	<select onChange="saveCredWeight('<?=$evidence_id?>');" name="<?=$evidence_id?>" id="<?=$evidence_id?>">
		<option value="2" <?php if( $this_rating == "2" ) { echo("selected"); } ?> >High</option>
		<option value="1" <?php if( $this_rating == "1" || $this_rating == "" || $this_rating == "0" ) { echo("selected"); } ?> >Med</option>
		<option value="0.5" <?php if( $this_rating == "0.5" ) { echo("selected"); } ?> >Low</option>
	</select>