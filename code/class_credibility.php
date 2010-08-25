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



class Credibility extends FrameworkDatabase {



	public $database_table_name = "credibility"; // This is the table that this class interacts with.
	public $insert_fields_to_ignore = array("added"); // These are tables fields that will be IGNORED when inserts happen.
	
	public $value = "y";
	
	
	
	public static function getAllCred($evidence, $users) { // All incoming vars are arrays of IDs.
		$all_cred = array();
		$all_evidence = implode(",", $evidence);
		$all_users = implode(",", $users);
		$results = mysql_fast("SELECT * FROM credibility WHERE user_id IN ( $all_users ) AND evidence_id IN ( $all_evidence )");
		if( count($results) > 0 ) {
			for( $i = 0; $i < count($results); $i++ ) {
				$all_cred[$results[$i]['user_id']][$results[$i]['evidence_id']] = $results[$i];
			}
		}
		return $all_cred;
	}
	
	

	public function getUserEvidence($evidence_id) { // Populates for a user/evidence ID pair.
		global $active_user;
		
		$return_value = FALSE;
		$results = mysql_fast("SELECT * FROM credibility WHERE user_id='$active_user->id' AND evidence_id='$evidence_id' LIMIT 1");
		if( count($results) > 0 ) {
			$this_result = $results[0]; // Since only one results comes back.
			foreach ($this_result as $field => $value) {
				$this->$field = $value;
			}
			$return_value = TRUE;
		}
		
		if( $return_value == FALSE ) {
			$this->user_id = $active_user->id;
			$this->evidence_id = $evidence_id;
			$this->weight = "1";
			//$this->insertNew();
		}
		
		return $return_value;
	}	
	
	

	public function getUserEvidenceUser($evidence_id, $this_user) { // Populates for a user/evidence ID pair.
		
		$return_value = FALSE;
		$results = mysql_fast("SELECT * FROM credibility WHERE user_id='$this_user->id' AND evidence_id='$evidence_id' LIMIT 1");
		if( count($results) > 0 ) {
			$this_result = $results[0]; // Since only one results comes back.
			foreach ($this_result as $field => $value) {
				$this->$field = $value;
			}
			$return_value = TRUE;
		}
		
		if( $return_value == FALSE ) {
			$this->user_id = $this_user->id;
			$this->evidence_id = $evidence_id;
			$this->weight = "1";
			//$this->insertNew();
		}
		
		return $return_value;
	}	



	public function getUserUserEvidence($user_id, $evidence_id) { // Populates for a user/evidence ID pair.
		global $active_user, $all_cred;
		
		$return_value = FALSE;
		$results = array();
		//$results = mysql_fast("SELECT * FROM credibility WHERE user_id='$user_id' AND evidence_id='$evidence_id' LIMIT 1");
		//print_r($results);
		$results = $all_cred[$user_id][$evidence_id];
		
		if( isset($results) ) {
			foreach ($results as $field => $value) {
				$this->$field = $value;
			}
			$return_value = TRUE;
		}
		
		if( $return_value == FALSE ) {
			$this->user_id = $user_id;
			$this->evidence_id = $evidence_id;
			$this->weight = "1";
			//$this->insertNew();
		}
		
		return $return_value;
	}
	
	
	
	public function switchCred($toValue) { // Use this to change credibility.
		global $active_user;
	
		$return_value = "";
		
		$this_evidence = new Evidence();
		$this_evidence->populateFromId($this->evidence_id);
	
		if( $toValue == "y" ) {
			$return_value = "Credible";
		} else {
			$return_value = "Suspect";
		}
	
		if( $this_evidence->serial_number != "" ) {
			$result = mysql_do("SELECT id FROM evidence WHERE serial_number='$this_evidence->serial_number'");
			while($query_data = mysql_fetch_array($result)) {
			
				$exists = FALSE;
				
				$this_evidence_id = $query_data['id'];

				$result2 = mysql_do("SELECT id FROM credibility WHERE user_id='$active_user->id' AND evidence_id='$this_evidence_id' LIMIT 1");
				while($query_data2 = mysql_fetch_array($result2)) {
					$exists = TRUE;
				}
				
				if( !$exists ) {
					mysql_do("INSERT INTO credibility (value, evidence_id, user_id, weight) VALUES ('$toValue', '$this_evidence_id', '$active_user->id', '1')");
				}
				
			}
			mysql_do("UPDATE credibility SET value='$toValue' WHERE user_id='$active_user->id' AND evidence_id IN (SELECT id FROM evidence WHERE serial_number='$this_evidence->serial_number')");
		} else {
			mysql_do("UPDATE credibility SET value='$toValue' WHERE user_id='$active_user->id' AND evidence_id='$this_evidence->id'");
		}
		
		return $return_value;

	}
	
	

}



?>