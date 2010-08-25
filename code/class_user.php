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



class User extends FrameworkDatabase {



	public $database_table_name = "users"; // This is the table that this class interacts with.
	public $insert_fields_to_ignore = array("created"); // These are tables fields that will be IGNORED when inserts happen.


	
	// These are other extra variables that don't need to be matched in the DB table.
	public $projects = Array();
	public $owner_of_projects = Array();
	public $member_of_projects = Array(); // But not the owner.
	public $member_of_projects_view_only = Array();



	public function __construct() { // Populates all of the varibles in this object from the DB.
		$this->logged_in = FALSE;
		$this->found = FALSE;
	}
	
	public function setCookies() { // Sets cookies when the User logs in.
		setcookie("cookie_user_id", $this->id, time()+2592000, "/" );
		setcookie("cookie_user_password", $this->password, time()+2592000, "/" );
		$this->logged_in_full_account = TRUE;
	}
	
	public function eraseCookies() { // Sets cookies when the User logs in.
		setcookie("cookie_user_id", "", time(), "/" );
		setcookie("cookie_user_password", "", time(), "/" );
	}

	public function failedLogin() { // Sets cookies when the User logs in.
		setcookie("failed_login", "1", time()+5, "/" );
	}

	public function successfulLogin() { // Sets cookies when the User logs in.
		setcookie("failed_login", "1", time()-3600, "/" );
	}
		
	public function checkLoggedIn() { // Returns a boolean as to whether the current User object is the User that's logged in.
		return $this->id > 0;
		
		/*global $cookie_user_id;
		global $cookie_user_password;
		if( $cookie_user_id != "" ) {
			if ( $this->id == $cookie_user_id && $this->password == $cookie_user_password ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}*/
	}

	public function getProjects() { // Add all projects for this user to the $projects variable.
		$this->projects = Array();
		$result = mysql_do("SELECT * FROM projects WHERE user_id='$this->id' ORDER BY title");
		while($query_data = mysql_fetch_array($result)) {
			$this->projects[] = $query_data['id'];
			$this->owner_of_projects[] = $query_data['id'];
		}
		$result = mysql_do("SELECT * FROM users_in_projects WHERE user_id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this->projects[] = $query_data['project_id'];
			if( !in_array($query_data['project_id'], $this->owner_of_projects) ) {
				$this->member_of_projects[] = $query_data['project_id'];
			}
		}
		$result = mysql_do("SELECT * FROM users_in_projects_view_only WHERE user_id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this->projects[] = $query_data['project_id'];
			if( !in_array($query_data['project_id'], $this->owner_of_projects) && !in_array($query_data['project_id'], $this->member_of_projects) ) {
				$this->member_of_projects_view_only[] = $query_data['project_id'];
			}
		}
		$this->projects = array_unique($this->projects);
	}

	public function getComments() {
		$this->comments = Array();
		$result = mysql_do("SELECT * FROM comments WHERE user_id='$this->id' ORDER BY `created` DESC");
		while($query_data = mysql_fetch_array($result)) {
			$this->comments[] = $query_data['id'];
		}
	}
	
	public function getPublicProjects() { // Add all projects for this user to the $projects variable.
		$this->projects = Array();
		$result = mysql_do("SELECT * FROM projects WHERE public='y' AND user_id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this->projects[] = $query_data['id'];
			$this->owner_of_projects[] = $query_data['id'];
		}
		$result = mysql_do("SELECT * FROM users_in_projects JOIN projects ON users_in_projects.project_id=projects.id WHERE users_in_projects.user_id='$this->id' AND projects.public='y'");//JOIN projects ON users_in_projects.user_id='$this->id' AND projects.public='y'");
		while($query_data = mysql_fetch_array($result)) {
			$this->projects[] = $query_data['project_id'];
		}
		$this->projects = array_unique($this->projects);
	}

	public function getDirectoryProjects() { // Add all projects for this user to the $projects variable.
		$this->projects = Array();
		$result = mysql_do("SELECT * FROM projects WHERE directory='y' AND user_id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this->projects[] = $query_data['id'];
			$this->owner_of_projects[] = $query_data['id'];
		}
		$result = mysql_do("SELECT * FROM users_in_projects JOIN projects ON users_in_projects.project_id=projects.id WHERE users_in_projects.user_id='$this->id' AND projects.directory='y'");//JOIN projects ON users_in_projects.user_id='$this->id' AND projects.public='y'");
		while($query_data = mysql_fetch_array($result)) {
			$this->projects[] = $query_data['project_id'];
		}
		$this->projects = array_unique($this->projects);
	}
	
	public function populateFromId($id) { // Populates all of the varibles in this object from the DB. Maybe this and the next functions can be merged.
		$return_value = parent::populateFromId($id);
		$results = mysql_fast("SELECT last_visited, last_page, color FROM users_active WHERE user_id='$id'");
		for( $i = 0; $i < count($results); $i++ ) {
			foreach ($results[$i] as $field => $value) {
				$this->$field = $value;
			}
		}
		$this->logged_in = $this->checkLoggedIn();
		$this->found = $return_value;
		if( $this->password != "" ) {
			$this->logged_in_full_account = TRUE;
		} else {
			$this->logged_in_full_account = FALSE;
		}
		return $return_value;
	}

	public function populateFromAttribute($value, $kind) { // Populates all of the varibles in this object from the DB.
		$return_value = parent::populateFromAttribute($value, $kind);
		$results = mysql_fast("SELECT last_visited, last_page, color FROM users_active WHERE user_id='$id'");
		for( $i = 0; $i < count($results); $i++ ) {
			foreach ($results[$i] as $field => $value) {
				$this->$field = $value;
			}
		}
		$this->logged_in = $this->checkLoggedIn();
		$this->found = $return_value;
		if( $this->password != "" ) {
			$this->logged_in_full_account = TRUE;
		} else {
			$this->logged_in_full_account = FALSE;
		}
		return $return_value;
	}
	
	public function checkUsernameAvailability($username) {
		$username_exists = FALSE;
		$result = mysql_do("SELECT username FROM users WHERE username='$username'");
		while($query_data = mysql_fetch_array($result)) {
			$username_exists = TRUE;
		}
		return $username_exists;
	}
	
	public function changeUsername($new_username) { // Changes the user's nickname.
		// First, make sure it doesn't already exist.
		$username_exists = $this->checkUsernameAvailability($new_username);
		// Then do the thing.
		if( $username_exists ) {
			return FALSE;
		} else {
			$this->username = $new_username;
			$this->update();
			return TRUE;
		}	
	}
	
	public function getRating($evidence_id, $hypothesis_id) {
		$result = mysql_do("SELECT * FROM ratings WHERE evidence_id='$evidence_id' AND hypothesis_id='$hypothesis_id' AND user_id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			return $query_data['rating'];
		}
	}
	
	public function display() { // Just prints out some basic user data for testing.
		if( $this->logged_in ) {
			$this_logged_in = "Logged in.";
		} else {
			$this_logged_in = "Not logged in.";
		}
		echo('<p><b>' . $this->id . '. ' . $this->username . '</b> is  ' . $this->first_name . ' ' . $this->last_name . ' &mdash; ' . $this_logged_in . '</p>');
	}
	
	
	
	public function displayInvitationNotices() {
		echo('<div class="invitationNotices">');
		$result = mysql_do("SELECT * FROM invitation_notices WHERE user_id='$this->id' AND displayed='n'");
		while($query_data = mysql_fetch_array($result)) {
			$this_project = new Project();
			$this_project->populateFromId($query_data['project_id']);
			$by_user = new User();
			$by_user->populateFromId($query_data['by_user_id']);
			echo('<p class="' . $query_data['type'] . '">You have been ');
			if( $query_data['type'] == "approve" ) { echo('approved'); }
			if( $query_data['type'] == "deny" ) { echo('denied'); }
			echo(' access to project <a href="' . $base_URL . '/project/' . $this_project->id . '">' . $this_project->title . '</a> by <a href="' . $base_URL . '/profile/' . $by_user->username . '">' . $by_user->name . '</a>.');
		}
		echo('</div>');
		mysql_do("UPDATE invitation_notices SET displayed='y' WHERE user_id='$this->id';");
	}
	
	public function displayWaitingForApproval() {
		$result = mysql_do("SELECT * FROM join_requests WHERE user_id='$this->id'");
		while($query_data = mysql_fetch_array($result)) {
			$this_project = new Project();
			$this_project->populateFromId($query_data['project_id']);
			echo('<p>Still waiting on approval to join project <a href="' . $base_URL . '/project/' . $this_project->id . '">' . $this_project->title . '</a>.</p>');
		}
	}
	
	
	
	
	
	
	public function sendPasswordReset() {
		global $base_URL;
		global $email_domain;
		$message = "Please reset your password by visiting this URL:\r\n\r\n" . $base_URL . "/password_reset/" . $this->username . "/" . md5($this->password) . "\r\n\r\nThanks!\r\n\r\n - The ACH Bot";
		$headers = 'From: ACH System <noreply@' . $email_domain . ">\r\n" . 'Reply-To: noreply@' . $email_domain;
		mail($this->email, "[ACH] Password Reset Link", $message, $headers);
	}	

}



?>