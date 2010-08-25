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

header("Content-Type: text/html; charset=iso-8859-1");



include("code/includes.php");

if ( isset($_FILES['achz']['name']) ) {
	
	$filedir = 'imports/';
	$filename = $filedir . basename($_FILES['achz']['name']);
	
	if( move_uploaded_file($_FILES['achz']['tmp_name'], $filename) ) {
		$success = TRUE;
	} else {
		$success = FALSE;
	}

}

if( $success ) {

	$short_filename = substr($filename, 0, -4) . "gz";
	$unzip_filename = substr($filename, 0, -5);

	exec("mv " . $filename . " " . $short_filename);
	exec("gunzip -d " . $short_filename);
	
	$fh = fopen($unzip_filename, "r");
	while( !feof($fh) ) { $filedata .= fgets($fh, 4096); }
	fclose($fh);
	
	$filedata = utf16_to_utf8($filedata);
	
	$filedata = str_replace("PROJECT-TITLE>", "PROJECTTITLE>", $filedata);
	$filedata = str_replace("LAST-INDEX>", "LASTINDEX>", $filedata);
	$filedata = str_replace("COLOR-SCHEME>", "COLORSCHEME>", $filedata);
	
	//echo($filedata);
	
	$dom = new domDocument;
	$dom->loadXML($filedata);
	
	$achz = simplexml_import_dom($dom);
	
	//print_r($achz);
	
	$this_project = new Project();
	
	$this_project->title = $achz->PROJECTTITLE;

	if( strtolower($achz->CLASSIFICATION) == "u" ) { $this_project->classification = "U"; }
	if( strtolower($achz->CLASSIFICATION) == "fouo" ) { $this_project->classification = "U"; }
	if( strtolower($achz->CLASSIFICATION) == "aiou" ) { $this_project->classification = "U"; }
	if( strtolower($achz->CLASSIFICATION) == "unclassified" ) { $this_project->classification = "U"; }
	
	if( strtolower($achz->CLASSIFICATION) == "c" ) { $this_project->classification = "C"; }
	if( strtolower($achz->CLASSIFICATION) == "confidential" ) { $this_project->classification = "C"; }
	
	if( strtolower($achz->CLASSIFICATION) == "s" ) { $this_project->classification = "S"; }
	if( strtolower($achz->CLASSIFICATION) == "secret" ) { $this_project->classification = "S"; }
	
	if( strtolower($achz->CLASSIFICATION) == "t" ) { $this_project->classification = "TS"; }
	if( strtolower($achz->CLASSIFICATION) == "ts" ) { $this_project->classification = "TS"; }
	if( strtolower($achz->CLASSIFICATION) == "top secret" ) { $this_project->classification = "TS"; }
	if( strtolower($achz->CLASSIFICATION) == "top-secret" ) { $this_project->classification = "TS"; }
	
	$this_project->open = "n";
	
	$this_project->user_id = $active_user->id;
	
	$this_project->insertNew();
	
	$this_hypothesis = Array();
	
	for( $i = 0; $i < count($achz->MATRIX->HYPOTHESIS); $i++ ) {
		
		$this_hypothesis[$i] = new Hypothesis();
		$this_hypothesis[$i]->label = $achz->MATRIX->HYPOTHESIS[$i]->NAME;
		$this_hypothesis[$i]->user_id = $active_user->id;
		$this_hypothesis[$i]->project_id = $this_project->id;
		
		$this_hypothesis[$i]->insertNew();
		
	}
	
	for( $i = 0; $i < count($achz->MATRIX->EVIDENCE); $i++ ) {
		
		$this_evidence = new Evidence();
		$this_evidence->name = $achz->MATRIX->EVIDENCE[$i]->NAME[0];
		$this_evidence->details = $achz->MATRIX->EVIDENCE[$i]->NOTES[0];
		
		if( $achz->MATRIX->EVIDENCE[$i]->LINK[0] != "" ) {
			if( $this_evidence->details != "" ) { $this_evidence->details .= " "; }
			$this_evidence->details .= "Link: " . $achz->MATRIX->EVIDENCE[$i]->LINK[0];
		}
		
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "open source" ) { $this_evidence->type = "OSINT"; }
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "osint" ) { $this_evidence->type = "OSINT"; }
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "press" ) { $this_evidence->type = "OSINT"; }
		
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "assu" ) { $this_evidence->type = "Assumption"; }
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "assumption" ) { $this_evidence->type = "Assumption"; }
		
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "hum" ) { $this_evidence->type = "HUMINT"; }
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "humint" ) { $this_evidence->type = "HUMINT"; }
		
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "imagery" ) { $this_evidence->type = "IMINT"; }
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "imint" ) { $this_evidence->type = "IMINT"; }
		
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "sig" ) { $this_evidence->type = "SIGINT"; }
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "sigint" ) { $this_evidence->type = "SIGINT"; }
		
		if( strtolower($achz->MATRIX->EVIDENCE[$i]->TYPE[0]) == "masint" ) { $this_evidence->type = "MASINT"; }
		
		$date_of_source = substr($achz->MATRIX->EVIDENCE[$i]->DATE, 0, -3);
		if ($achz->MATRIX->EVIDENCE[$i]->DATE == 0) { 
		$this_evidence->date_of_source = "";
		} else { $this_evidence->date_of_source = date("Y-m-d H:i:s", $date_of_source);
		}
		
		$this_evidence->code = $achz->MATRIX->EVIDENCE[$i]->CODE[0];
		
		$this_evidence->user_id = $active_user->id;
		$this_evidence->project_id = $this_project->id;
		
		if( $achz->MATRIX->EVIDENCE[$i]->FLAG == 1 ) {
			$this_evidence->flag = "y";
		} else {
			$this_evidence->flag = "n";
		}
		
		$this_evidence->insertNew();
		
		$values = Array();
		$values = explode(",", $achz->MATRIX->EVIDENCE[$i]->VALUES[0]);
		
		for( $j = 0; $j < count($values); $j++ ) {
			
			if( $values[$j] == "I I" ) { $this_rating = "Very Inconsistent"; }
			if( $values[$j] == "I" ) { $this_rating = "Inconsistent"; }
			if( $values[$j] == "NA" ) { $this_rating = "N/A"; }
			if( $values[$j] == "N" ) { $this_rating = "Neutral"; }
			if( $values[$j] == "C" ) { $this_rating = "Consistent"; }
			if( $values[$j] == "C C" ) { $this_rating = "Very Consistent"; }
			
			$this_hypothesis_id = $this_hypothesis[$j]->id;
		
			mysql_do("INSERT INTO `ratings` (`hypothesis_id`,`evidence_id`,`user_id`,`rating`) VALUES ('$this_hypothesis_id', '$this_evidence->id', '$active_user->id', '$this_rating');");
				
		}
		
		$this_credibility = new Credibility();
		$this_credibility->evidence_id = $this_evidence->id;
		$this_credibility->user_id = $active_user->id;
		
		if( $achz->MATRIX->EVIDENCE[$i]->CREDIBILITY == "HIGH" ) { $this_credibility->value = "y"; }
		if( $achz->MATRIX->EVIDENCE[$i]->CREDIBILITY == "MEDIUM" ) { $this_credibility->value = "y"; }
		if( $achz->MATRIX->EVIDENCE[$i]->CREDIBILITY == "LOW" ) { $this_credibility->value = "n"; }
		
		$this_credibility->weight = 1;
		
		$this_credibility->insertNew();
				
	}
	
}
	
?>

<html>
<head>
	<title>Updating...</title>
	<meta http-equiv=Refresh content="0; url=project/<?=$this_project->id?>/edit">
</head>



<body>
</body>
</html>