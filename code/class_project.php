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


class Project extends FrameworkDatabase {


	public $database_table_name = "projects"; // This is the table that this class interacts with.
	public $insert_fields_to_ignore = array("created"); // These are tables fields that will be IGNORED when inserts happen.


	
	// These are other extra variables that don't need to be matched in the DB table.
	public $users = Array();
	public $users_view_only = Array();
	public $nonadmins = Array();
	public $evidence = Array();
	public $hypotheses = Array();
	public $hypotheses_rating_scores = Array();
	public $hypotheses_rating_scores_users = Array();
	public $hypotheses_rating_scores_personal = Array();
	public $ratings = Array();
	public $join_requests = Array();
	
	public $all_ratings = Array();
	public $all_evidence = Array();
	
	
	
	public function getJoinRequests() {	
		$result = mysql_do("SELECT * FROM join_requests WHERE project_id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this->join_requests[] = $query_data['user_id'];
		}
		$this->join_requests = array_unique($this->join_requests);
	}

	public function getUsers() { // Load up users array.
		$result = mysql_do("SELECT * FROM projects WHERE id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this->users[] = $query_data['user_id'];
		}
		$result = mysql_do("SELECT * FROM users_in_projects WHERE project_id='$this->id' AND user_id > 0");
		while($query_data = mysql_fetch_array($result)) {
			$this->users[] = $query_data['user_id'];
		}
		$this->users = array_unique($this->users);
		sort($this->users);
		
		// View-only users.
		$result = mysql_do("SELECT * FROM users_in_projects_view_only WHERE project_id='$this->id' AND user_id > 0");
		while($query_data = mysql_fetch_array($result)) {
			if( !in_array($query_data['user_id'], $this->users) ) {
				$this->users_view_only[] = $query_data['user_id'];
			}
		}
		$this->users_view_only = array_unique($this->users_view_only);
		sort($this->users_view_only);
	}
	
	public function getNonAdmins() { // Load up all non-admin users.
		$result = mysql_do("SELECT * FROM users_in_projects WHERE project_id='$this->id' AND user_id > 0");
		while($query_data = mysql_fetch_array($result)) {
			$this->nonadmins[] = $query_data['user_id'];
		}
		$this->nonadmins = array_unique($this->nonadmins);
		sort($this->nonadmins);
	}

	public function getEandH() { // Load up hypo and evidence arrays. And calculate some rating scores.
	
		global $active_user, $SQL_CACHING_ACTIVE, $all_cred;
		
		$this->hypotheses = Array();
		$this->evidence = Array();
		
		$this->hypotheses_rating_scores = Array();
		$this->hypotheses_rating_scores_personal = Array();
		
		$this->ratings = Array();
	
		$result = mysql_do("SELECT id FROM evidence WHERE project_id='$this->id' AND deleted!='y' ORDER BY name DESC");
		while($query_data = mysql_fetch_array($result)) {
			$this->evidence[] = $query_data['id'];
		}
		$result = mysql_do("SELECT id FROM hypotheses WHERE project_id='$this->id' AND deleted!='y' ORDER BY label DESC");
		while($query_data = mysql_fetch_array($result)) {
			$this->hypotheses[] = $query_data['id'];
		}
		
		// Shut off if too much memory is being used.
		/*if( count($this->evidence)*count($this->hypotheses) > 10000 ) {
			$SQL_CACHING_ACTIVE = FALSE;
		}*/
		
		$all_cred = Credibility::getAllCred($this->evidence, $this->users);
		$this->all_ratings = $this->getAllRatings($this->hypotheses, $this->evidence, $this->users);
		
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this->hypotheses_rating_scores[$this->hypotheses[$j]] = 0;
			$this->hypotheses_rating_scores_personal[$this->hypotheses[$j]] = 0;
			for( $i = 0; $i < count($this->evidence); $i++ ) {
				for( $k = 0; $k < count($this->users); $k++ ) {
				
					$this_cred = new Credibility();
					$this_cred->getUserUserEvidence($this->users[$k], $this->evidence[$i]);
					
					if( $this_cred->weight == "" ) { $this_cred->weight = 1; }
					
					$rating = $this->getRating($this->evidence[$i], $this->hypotheses[$j], $this->users[$k]);
					$this->ratings[$this->evidence[$i]][$this->hypotheses[$j]][$this->users[$k]] = $rating;
					$this->hypotheses_rating_scores[$this->hypotheses[$j]] += getHypoRatingScore($rating)*$this_cred->weight;
					if( $this->users[$k] == $active_user->id ) {
						$this->hypotheses_rating_scores_personal[$this->hypotheses[$j]] += getHypoRatingScore($rating)*$this_cred->weight;
					}
					$this->hypotheses_rating_scores_users[$this->users[$k]][$this->hypotheses[$j]] += getHypoRatingScore($rating)*$this_cred->weight;
				}
			}
		}
	}

	public function getDiags() { // Load up diags for the evidence array.
		for( $i = 0; $i < count($this->evidence); $i++ ) {
			$this_evidence = new Evidence();
			$this_evidence->populateFromId($this->evidence[$i]);
			$this_evidence->diag = Evidence::getDiag($this_evidence, $this);
			//$this_evidence->update();
		}
	}

	public function getDiagsUser($this_user) { // Load up diags for the evidence array.
		for( $i = 0; $i < count($this->evidence); $i++ ) {
			$this_evidence = new Evidence();
			$this_evidence->populateFromId($this->evidence[$i]);
			$this_evidence->diag = Evidence::getDiagUser($this_evidence, $this, $this_user);
			//$this_evidence->update();
		}
	}

	public function getDiagsGroup() { // Load up diags for the evidence array.
		for( $i = 0; $i < count($this->evidence); $i++ ) {
			$this_evidence = new Evidence();
			$this_evidence->populateFromId($this->evidence[$i]);
			$this_evidence->diag = Evidence::getDiagGroup($this_evidence->id, $this);
			//$this_evidence->update();
		}
	}

	public function getDiagsCompare($user_1, $user_2) { // Load up diags for the evidence array.
		for( $i = 0; $i < count($this->evidence); $i++ ) {
			$this_evidence = new Evidence();
			$this_evidence->populateFromId($this->evidence[$i]);
			$this_evidence->diag = Evidence::getDiagCompare($this_evidence->id, $this, $user_1, $user_2);
			//$this_evidence->update();
		}
	}

	public function sortH($sort) { // Sorts the hypotheses. $sort can be "least_likely", "most_likely", "alpha", and "added".
		if( $sort == "added" ) {
			$this->hypotheses = Array();
			$results = mysql_fast("SELECT id FROM hypotheses WHERE project_id='$this->id' AND deleted!='y' ORDER BY created");
			for($i = 0; $i < count($results); $i++ ) {
				$this->hypotheses[] = $results[$i]['id'];
			}
		}
		if( $sort == "alpha" ) {
			$this->hypotheses = Array();
			$results = mysql_fast("SELECT id FROM hypotheses WHERE project_id='$this->id' AND deleted!='y' ORDER BY label");
			for($i = 0; $i < count($results); $i++ ) {
				$this->hypotheses[] = $results[$i]['id'];
			}
		}
		if( $sort == "most_likely" ) {
			$this->hypotheses = Array();
			asort($this->hypotheses_rating_scores);
			foreach($this->hypotheses_rating_scores as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
		if( $sort == "least_likely" ) {
			$this->hypotheses = Array();
			arsort($this->hypotheses_rating_scores);
			foreach($this->hypotheses_rating_scores as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
		if( $sort == "most_likely_personal" ) {
			$this->hypotheses = Array();
			asort($this->hypotheses_rating_scores_personal);
			foreach($this->hypotheses_rating_scores_personal as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
		if( $sort == "least_likely_personal" ) {
			$this->hypotheses = Array();
			arsort($this->hypotheses_rating_scores_personal);
			foreach($this->hypotheses_rating_scores_personal as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
	}

	public function sortHUser($sort, $user_id) { // Sorts the hypotheses. $sort can be "least_likely", "most_likely", "alpha", and "added".
		if( $sort == "added" ) {
			$this->hypotheses = Array();
			$results = mysql_fast("SELECT id FROM hypotheses WHERE project_id='$this->id' AND deleted!='y' ORDER BY created");
			for($i = 0; $i < count($results); $i++ ) {
				$this->hypotheses[] = $results[$i]['id'];
			}
		}
		if( $sort == "alpha" ) {
			$this->hypotheses = Array();
			$results = mysql_fast("SELECT id FROM hypotheses WHERE project_id='$this->id' AND deleted!='y' ORDER BY label");
			for($i = 0; $i < count($results); $i++ ) {
				$this->hypotheses[] = $results[$i]['id'];
			}
		}
		if( $sort == "most_likely" ) {
			$this->hypotheses = Array();
			arsort($this->hypotheses_rating_scores_users[$user_id]);
			foreach($this->hypotheses_rating_scores_users[$user_id] as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
		if( $sort == "least_likely" ) {
			$this->hypotheses = Array();
			asort($this->hypotheses_rating_scores_users[$user_id]);
			foreach($this->hypotheses_rating_scores_users[$user_id] as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
	}

	public function sortHCompare($sort, $user_id_1, $user_id_2) { // Sorts the hypotheses. $sort can be "least_likely", "most_likely", "alpha", and "added".
		if( $sort == "added" ) {
			$this->hypotheses = Array();
			$results = mysql_fast("SELECT id FROM hypotheses WHERE project_id='$this->id' AND deleted!='y' ORDER BY created");
			for($i = 0; $i < count($results); $i++ ) {
				$this->hypotheses[] = $results[$i]['id'];
			}
		}
		if( $sort == "alpha" ) {
			$this->hypotheses = Array();
			$results = mysql_fast("SELECT id FROM hypotheses WHERE project_id='$this->id' AND deleted!='y' ORDER BY label");
			for($i = 0; $i < count($results); $i++ ) {
				$this->hypotheses[] = $results[$i]['id'];
			}
		}
		if( $sort == "most_likely_compare" ) {
			$this->hypotheses = Array();
			$this->hypotheses_rating_scores_compare = Array();
			foreach($this->hypotheses_rating_scores_users[$user_id_1] as $key => $value) {
				$this->hypotheses_rating_scores_compare[$key] = $this->hypotheses_rating_scores_users[$user_id_1][$key];
			}
			arsort($this->hypotheses_rating_scores_compare);
			foreach($this->hypotheses_rating_scores_compare as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
		if( $sort == "least_likely_compare" ) {
			$this->hypotheses = Array();
			$this->hypotheses_rating_scores_compare = Array();
			foreach($this->hypotheses_rating_scores_users[$user_id_1] as $key => $value) {
				$this->hypotheses_rating_scores_compare[$key] = $this->hypotheses_rating_scores_users[$user_id_1][$key];
			}
			asort($this->hypotheses_rating_scores_compare);
			foreach($this->hypotheses_rating_scores_compare as $key => $value) {
				$this->hypotheses[] = $key;
			}
		}
	}
	
	public function classificationText($code) {
		if( $code == "U" ) {
			$to_return = "Unclassified";
		}
		if( $code == "C" ) {
			$to_return = "Confidential";
		}
		if( $code == "S" ) {
			$to_return = "Secret";
		}
		if( $code == "TS" ) {
			$to_return = "Top Secret";
		}
		return $to_return;
	}
	
	public function classificationTextStyled($code) {
		if( $code == "U" ) {
			$to_return = "<span class='unclassifiedLabel'>Unclassified</span>";
		}
		if( $code == "C" ) {
			$to_return = "<span class='confidentialLabel'>Confidential</span>";
		}
		if( $code == "S" ) {
			$to_return = "<span class='secretLabel'>Secret</span>";
		}
		if( $code == "TS" ) {
			$to_return = "<span class='topSecretLabel'>Top Secret</span>";
		}
		return $to_return;
	}
	
	public function getAllRatings($hypotheses, $evidence, $users) {
		$all_ratings = array();
		$all_hypotheses = implode(",", $hypotheses);
		$all_evidence = implode(",", $evidence);
		$all_users = implode(",", $users);
		$results = mysql_fast("SELECT * FROM ratings WHERE evidence_id IN ( $all_evidence ) AND hypothesis_id IN ( $all_hypotheses ) AND user_id IN ( $all_users )");
		//print_r($results);
		for( $i = 0; $i < count($results); $i++ ) {
			$all_ratings[$results[$i]['evidence_id']][$results[$i]['hypothesis_id']][$results[$i]['user_id']] = $results[$i];
		}
		return $all_ratings;
	}
	
	public function getRating($evidence_id, $hypothesis_id, $user_id) {
		$results = $this->all_ratings[$evidence_id][$hypothesis_id][$user_id];
		//$results = mysql_fast("SELECT * FROM ratings WHERE evidence_id='$evidence_id' AND hypothesis_id='$hypothesis_id' AND user_id='$user_id' LIMIT 1");
		return $results['rating'];
	}
	
	
	
	public function showHypothesisGroupLabels($sort, $display) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
 			echo('<br><i>' . $this->hypotheses_rating_scores[$this_hypothesis->id] . '</i></th>');
		}
	
	}
	
	
	
	public function showHypothesisCompareLabels($sort, $display, $user_1, $user_2) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;

		$this->sortHCompare($sort, $user_1->id, $user_2->id);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
			$total = $this->hypotheses_rating_scores_users[$user_1->id][$this_hypothesis->id] + $this->hypotheses_rating_scores_users[$user_2->id][$this_hypothesis->id];
 			echo('<br><i>' . $total . '</i></th>');
		}
	
	}
	
	
	
	public function showHypothesisPersonalLabels($sort, $display) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;
	
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
 			echo('<br><i>' . $this->hypotheses_rating_scores_personal[$this_hypothesis->id] . '</i></th>');
		}
	
	}
	
	public function showHypothesisUserLabels($sort, $display, $this_user) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;
	
		$this->sortHUser($sort, $this_user->id);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
 			echo('<br><i>' . $this->hypotheses_rating_scores_users[$this_user->id][$this_hypothesis->id] . '</i></th>');
		}
	
	}	
	
	public function showHypothesisGroupLabelsInner($sort, $display) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;
	
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
 			echo('<br><i>' . $this->hypotheses_rating_scores[$this_hypothesis->id] . '</i></th>');
		}
	
	}
	
	public function showHypothesisCompareLabelsInner($sort, $display, $user_1, $user_2) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;
	
		$this->sortHCompare($sort, $user_1->id, $user_2->id);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
			$total = $this->hypotheses_rating_scores_users[$user_1->id][$this_hypothesis->id] + $this->hypotheses_rating_scores_users[$user_2->id][$this_hypothesis->id];
 			echo('<br><i>' . $total . '</i></th>');
		}
	
	}
	
	
	
	public function showHypothesisPersonalLabelsInner($sort, $display) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;
	
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
 			echo('<br><i>' . $this->hypotheses_rating_scores_personal[$this_hypothesis->id] . '</i></th>');
		}
	
	}

	public function showHypothesisUserLabelsInner($sort, $display, $this_user) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;
	
		$this->sortHUser($sort, $this_user->id);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			echo('<th ');
			if( !$display ) { echo('style="display: none;" '); }
			echo('class="hypothesis_colgroup_' . $sort . '" onmouseover="return overlib(\'' . cleanForDisplay($this_hypothesis->description) . '\', CAPTION, \'Hypothesis\');" onmouseout="return nd();"><a href="'. $base_URL . 'project/' . $this->id . '/hypothesis/' . $this_hypothesis->id . '">' . $this_hypothesis->label . '</a> ');
 			echo('<br><i>' . $this->hypotheses_rating_scores_users[$this_user->id][$this_hypothesis->id] . '</i></th>');
		}
	
	}
	
	public function showCellPersonal($evidence, $sort, $display) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	
		global $active_user;
	
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
	
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			$this_rating = "";
			$results = mysql_fast("SELECT * FROM ratings WHERE evidence_id='$evidence->id' AND hypothesis_id='$this_hypothesis->id' AND user_id='$active_user->id'");
			for($i = 0; $i < count($results); $i++ ) {
				$this_rating = $results[$i]['rating'];
			}

			$this_rating_style = strtolower(str_replace(" ", "_", str_replace("/", "", $this_rating)));
			
			echo("<td class='colgroup_" . $sort . "' ");
			if( !$display ) { echo('style="display: none;" '); }
			echo(" >");
		
			echo("<div class='" . $this_rating_style . "'>");
		
			echo($this_rating);
			
			echo("</span>");
			
			echo("</td>");
	
		}
	}
	
	public function showCellUser($evidence, $sort, $display, $this_user) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {
	
			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			$this_rating = "";
			$results = mysql_fast("SELECT * FROM ratings WHERE evidence_id='$evidence->id' AND hypothesis_id='$this_hypothesis->id' AND user_id='$this_user->id'");
			for($i = 0; $i < count($results); $i++ ) {
				$this_rating = $results[$i]['rating'];
			}

			$this_rating_style = strtolower(str_replace(" ", "_", str_replace("/", "", $this_rating)));
			
			echo("<td class='colgroup_" . $sort . "' ");
			if( !$display ) { echo('style="display: none;" '); }
			echo(" >");
		
			echo("<div class='" . $this_rating_style . "'>");
		
			echo($this_rating);
			
			echo("</span>");
			
			echo("</td>");
	
		}
	}
	
	public function showCellEdit($evidence, $sort, $display) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	
		global $active_user;
	
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {

			$this_hypothesis = new Hypothesis();
			$this_hypothesis->populateFromId($this->hypotheses[$j]);
			$this_rating = "";
			$results = mysql_fast("SELECT * FROM ratings WHERE evidence_id='$evidence->id' AND hypothesis_id='$this_hypothesis->id' AND user_id='$active_user->id'");
			for($i = 0; $i < count($results); $i++ ) {
				$this_rating = $results[$i]['rating'];
			}

			$this_rating_style = strtolower(str_replace(" ", "_", str_replace("/", "", $this_rating)));
			
			echo("<td class='colgroup_" . $sort . "' id='"); ?>td_rating_<?=$evidence->id?>-<?=$this_hypothesis->id?>_<?=$sort?><?php echo("' ");
			if( !$display ) { echo('style="display: none;" '); }
			echo(" >");
			
			echo("<div class='blank " . $this_rating_style . "'>");
				
			?>				
		
		<select onChange="saveCellRating('rating_<?=$evidence->id?>-<?=$this_hypothesis->id?>_<?=$sort?>');" class="table" id="rating_<?=$evidence->id?>-<?=$this_hypothesis->id?>_<?=$sort?>" name="rating_<?=$evidence->id?>-<?=$this_hypothesis->id?>_<?=$sort?>">
			<option value="">Select:</option>
			<option <?php if($this_rating=="Very Inconsistent") { echo("selected"); }?> value="Very Inconsistent">Very Incons't</option>
			<option <?php if($this_rating=="Inconsistent") { echo("selected"); }?> value="Inconsistent">Inconsistent</option>
			<option <?php if($this_rating=="N/A") { echo("selected"); }?> value="N/A">N/A</option>
			<option <?php if($this_rating=="Neutral") { echo("selected"); }?> value="Neutral">Neutral</option>
			<option <?php if($this_rating=="Consistent") { echo("selected"); }?> value="Consistent">Consistent</option>
			<option <?php if($this_rating=="Very Consistent") { echo("selected"); }?> value="Very Consistent">Very Cons't</option>
		</select>
		
			<?php
			
			echo("</span>");
			
			echo("</td>");
	
		}
	}
	
	public function showCellGroup($evidence, $sort, $display) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;

	//THIS FUNCTION IS FOR THE CONSENSUS RATINGS ON THE GROUP MATRIX
		$this->sortH($sort);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {

			echo("<td ");
			if( !$display ) { echo('style="display: none;" '); }
			echo("onmouseover=\"return overlib('");
		
			$ratings = Array();
		
			for( $k = 0; $k < count($this->users); $k++ ) {
				$this_user = new User();
				$this_user->populateFromId($this->users[$k]);
				$rating = $this->ratings[$evidence->id][$this->hypotheses[$j]][$this->users[$k]];
				$rating_score = getRatingScore($rating);
				if( $rating != "" ) {
					$ratings[] = getRatingScore($rating);
				}
				echo($this_user->name . ": " . $rating);
				if( $k < count($this->users)-1 ) {
					echo('&lt;br&gt;');
				}
			}
			
			$group_rating = getGroupRating(getStDev($ratings));
			if(average($ratings) == 0) {
				$unanimous_score = "N";
				$this_rating_style = "neutral"; //HAVE TO ADD THAT STYLE
				}
				else if (average($ratings) <= -1.5) {
				$unanimous_score = "I";
				$this_rating_style = "inconsistent";
				} 
				else if (average($ratings) >= 1.5) {
				$unanimous_score = "C";
				$this_rating_style = "consistent";
				}
				
				
			if( $group_rating <= 1 ) {
				echo("', CAPTION, 'Consensus');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"unanimity\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Consensus</a> <span class=\"". $this_rating_style . "\">&nbsp $unanimous_score &nbsp</span></div>");
			}
	
			if( $group_rating == 2 ) {
				echo("', CAPTION, 'Mild Dispute');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"mildDisagreement\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Mild Dispute</a></div>");
			}
	
			if( $group_rating == 3 ) {
				echo("', CAPTION, 'Large Dispute');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"starkDisagreement\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Large Dispute</a></div>");
			}
	
			if( $group_rating == 4 ) {
				echo("', CAPTION, 'Extreme Dispute');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"extremeDisagreement\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Extreme Dispute</a></div>");
			}
			
			
			/*if( count($ratings) > 1 ) {
				echo("<br /><small>StDev: " . getStDev($ratings) . "</small>");
			} else {
				echo("<br /><small>StDev: N/A</small>");
			}*/
			
			echo("</td>");
	
		}
	}
	
	public function showCellCompare($evidence, $sort, $display, $user_1, $user_2) { // $sort can be "least_likely", "most_likely", "alpha", and "added".
	global $base_URL;

	//THIS FUNCTION IS JUST FOR CONSENSUS RATINGS ON THE MATRIX THAT COMPARES TWO USERS
		$this->sortHCompare($sort, $user_1->id, $user_2->id);
	
		for( $j = 0; $j < count($this->hypotheses); $j++ ) {

			echo("<td ");
			if( !$display ) { echo('style="display: none;" '); }
			echo("onmouseover=\"return overlib('");
		
			$ratings = Array();
		
		
	
			$rating = $this->ratings[$evidence->id][$this->hypotheses[$j]][$user_1->id];
			$rating_score = getRatingScore($rating);
			if( $rating != "" ) {
				$ratings[] = getRatingScore($rating);
			}
			echo($user_1->name . ": " . $rating);
			
			echo('&lt;br&gt;');
		
			$rating = $this->ratings[$evidence->id][$this->hypotheses[$j]][$user_2->id];
			$rating_score = getRatingScore($rating);
			if( $rating != "" ) {
				$ratings[] = getRatingScore($rating);
			}
			echo($user_2->name . ": " . $rating);
			
			
				
			$group_rating = getGroupRating(getStDev($ratings));
			if(average($ratings) == 0) {
				$unanimous_score = "N";
				$this_rating_style = "neutral"; //HAVE TO ADD THAT STYLE
				}
				else if (average($ratings) <= -1.5) {
				$unanimous_score = "I";
				$this_rating_style = "inconsistent";
				} 
				else if (average($ratings) >= 1.5) {
				$unanimous_score = "C";
				$this_rating_style = "consistent";
				}
				
				
			if( $group_rating <= 1 ) {
				echo("', CAPTION, 'Consensus');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"unanimity\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Consensus</a> <span class=\"". $this_rating_style . "\">&nbsp $unanimous_score &nbsp</span></div>");
			}
	
			if( $group_rating == 2 ) {
				echo("', CAPTION, 'Mild Dispute');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"mildDisagreement\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Mild Dispute</a></div>");
			}
	
			if( $group_rating == 3 ) {
				echo("', CAPTION, 'Large Dispute');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"starkDisagreement\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Large Dispute</a></div>");
			}
	
			if( $group_rating == 4 ) {
				echo("', CAPTION, 'Extreme Dispute');\" onmouseout=\"return nd();\" class=\"colgroup_" . $sort . "\"><div class=\"extremeDisagreement\"><a href='" . $base_URL . "project/" . $this->id . "/cell/" . $evidence->id . "/" . $this->hypotheses[$j] . "'>Extreme Dispute</a></div>");
			}
			
			
			/*if( count($ratings) > 1 ) {
				echo("<br /><small>StDev: " . getStDev($ratings) . "</small>");
			} else {
				echo("<br /><small>StDev: N/A</small>");
			}*/
			
			echo("</td>");
	
		}
	}
	
	
	
	public function sortByFields($field_1, $field_1_dir, $field_2, $field_2_dir, $kind="personal", $user=null, $user_2=null) { // $field_*_dir can be "asc" or "desc".

		global $this_field_1;
		global $this_field_1_dir;
		global $this_field_2;
		global $this_field_2_dir;
		
		$this_field_1 = $field_1;
		$this_field_1_dir = $field_1_dir;
		$this_field_2 = $field_2;
		$this_field_2_dir = $field_2_dir;
	
		$evidence = Array();
		
		for( $i = 0; $i < count($this->evidence); $i++ ) {
			$evidence[] = new Evidence();
			$evidence[$i]->populateFromId($this->evidence[$i]);
			$evidence[$i]->getCredWeight();
			if( $kind == "personal" ) { $evidence[$i]->diag = $evidence[$i]->getDiag($evidence[$i], $this); }
			if( $kind == "group" ) { $evidence[$i]->diag = $evidence[$i]->getDiagGroup($evidence[$i]->id, $this); }
			if( $kind == "user" ) { $evidence[$i]->diag = $evidence[$i]->getDiagUser($evidence[$i], $this, $user); }
			if( $kind == "compare" ) { $evidence[$i]->diag = $evidence[$i]->getDiag($evidence[$i], $this, $user, $user_2); }
			$evidence[$i]->created_order = $i+1;
		}
		
		usort($evidence, array("Evidence", "created_sort"));

		for( $i = 0; $i < count($evidence); $i++ ) {
			$evidence[$i]->created_order = $i+1;
		}
	
		// Sort.
		usort($evidence, array("Evidence", "object_sort"));
				
		return $evidence;
	
	}
	
	
	
	public function getSortArrow($this_cell) {
		global $sort_field_1, $sort_field_1_dir, $sort_field_2, $sort_field_2_dir;
		
		$match_1 = FALSE;
		$match_2 = FALSE;
		
		if( $this_cell == $sort_field_1 ) { $match_1 = TRUE; }
		if( $this_cell == $sort_field_2 ) { $match_2 = TRUE; }
		
		if( $this_cell == "name" ) {
			if( $match_1 ) {
				if( $sort_field_1_dir == "asc" ) { return "sort1Down"; }
				if( $sort_field_1_dir == "desc" ) { return "sort1Up"; }
			}
			if( $match_2 ) {
				if( $sort_field_2_dir == "asc" ) { return "sort2Down"; }
				if( $sort_field_2_dir == "desc" ) { return "sort2Up"; }
			}
		}
		
		if( $this_cell == "created" ) {
			if( $match_1 ) {
				if( $sort_field_1_dir == "asc" ) { return "dclSort1Down"; }
				if( $sort_field_1_dir == "desc" ) { return "dclSort1Up"; }
			}
			if( $match_2 ) {
				if( $sort_field_2_dir == "asc" ) { return "dclSort2Down"; }
				if( $sort_field_2_dir == "desc" ) { return "dclSort2Up"; }
			}
		}
		
		if( $this_cell == "date_of_source" ) {
			if( $match_1 ) {
				if( $sort_field_1_dir == "asc" ) { return "dclSort1Down"; }
				if( $sort_field_1_dir == "desc" ) { return "dclSort1Up"; }
			}
			if( $match_2 ) {
				if( $sort_field_2_dir == "asc" ) { return "dclSort2Down"; }
				if( $sort_field_2_dir == "desc" ) { return "dclSort2Up"; }
			}
		}
		
		if( $this_cell == "type" ) {
			if( $match_1 ) {
				if( $sort_field_1_dir == "asc" ) { return "dclSort1Down"; }
				if( $sort_field_1_dir == "desc" ) { return "dclSort1Up"; }
			}
			if( $match_2 ) {
				if( $sort_field_2_dir == "asc" ) { return "dclSort2Down"; }
				if( $sort_field_2_dir == "desc" ) { return "dclSort2Up"; }
			}
		}
		
		if( $this_cell == "code" ) {
			if( $match_1 ) {
				if( $sort_field_1_dir == "asc" ) { return "dclSort1Down"; }
				if( $sort_field_1_dir == "desc" ) { return "dclSort1Up"; }
			}
			if( $match_2 ) {
				if( $sort_field_2_dir == "asc" ) { return "dclSort2Down"; }
				if( $sort_field_2_dir == "desc" ) { return "dclSort2Up"; }
			}
		}
		
		if( $this_cell == "flag" ) {
			if( $match_1 ) {
				if( $sort_field_1_dir == "asc" ) { return "dclSort1Down"; }
				if( $sort_field_1_dir == "desc" ) { return "dclSort1Up"; }
			}
			if( $match_2 ) {
				if( $sort_field_2_dir == "asc" ) { return "dclSort2Down"; }
				if( $sort_field_2_dir == "desc" ) { return "dclSort2Up"; }
			}
		}
		
		if( $this_cell == "diag" ) {
			if( $match_1 ) {
				if( $sort_field_1_dir == "asc" ) { return "dclSort1Down"; }
				if( $sort_field_1_dir == "desc" ) { return "dclSort1Up"; }
			}
			if( $match_2 ) {
				if( $sort_field_2_dir == "asc" ) { return "dclSort2Down"; }
				if( $sort_field_2_dir == "desc" ) { return "dclSort2Up"; }
			}
		}
		
	}
	
	
	
	public function mailEveryone($subject, $message) { // Sends a message to everyone in the group.
		$this->getUsers();
		for( $i = 0; $i < count($this->users); $i++ ) {
			$this_user = new User();
			$this_user->populateFromId($this->users[$i]);
			sendMail($this_user->email, $subject, $message);
		}
	}
	
	
	
	public function delete() {
	
		$result = mysql_do("SELECT id FROM evidence WHERE project_id='$this->id';");
		while($query_data = mysql_fetch_array($result)) {
			$evidence_id = $query_data['id'];
			mysql_do("DELETE FROM comments WHERE evidence_id='$evidence_id';");
			mysql_do("DELETE FROM credibility WHERE evidence_id='$evidence_id';");
			mysql_do("DELETE FROM evidence WHERE id='$evidence_id';");
			mysql_do("DELETE FROM ratings WHERE evidence_id='$evidence_id';");
		}
		$result = mysql_do("SELECT id FROM hypotheses WHERE project_id='$this->id';");
		while($query_data = mysql_fetch_array($result)) {
			$hypothesis_id = $query_data['id'];
			mysql_do("DELETE FROM comments WHERE hypothesis_id='$hypothesis_id';");
			mysql_do("DELETE FROM hypotheses WHERE id='$hypothesis_id';");
			mysql_do("DELETE FROM ratings WHERE evidence_id='$hypothesis_id';");
		}
		
		mysql_do("DELETE FROM chat_log WHERE project_id='$this->id';");
		mysql_do("DELETE FROM comments WHERE project_id='$this->id';");
		mysql_do("DELETE FROM evidence WHERE project_id='$this->id';");
		mysql_do("DELETE FROM hypotheses WHERE project_id='$this->id';");
		mysql_do("DELETE FROM invitation_notices WHERE project_id='$this->id';");
		mysql_do("DELETE FROM join_requests WHERE project_id='$this->id';");
		mysql_do("DELETE FROM users_in_projects WHERE project_id='$this->id';");
		mysql_do("DELETE FROM users_in_projects_view_only WHERE project_id='$this->id';");
		
		mysql_do("DELETE FROM projects WHERE id='$this->id';");
		
	}
	
	

}



?>