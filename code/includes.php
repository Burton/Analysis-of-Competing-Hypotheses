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

ini_set("memory_limit", "16M");



$LOAD_TIMER_START = microtime(TRUE);


//THE BELOW LINE SHOULD BE UNCOMMENTED IF YOU WANT ERROR REPORTING ON
//error_reporting(E_ALL);

//THE BELOW LINE SHOULD BE UNCOMMENTED IF YOU WANT ERROR REPORTING OFF
error_reporting(0);

if( strpos($_SERVER['HTTP_USER_AGENT'], "Firefox") > 0 ) { $is_firefox = TRUE; } else { $is_firefox = FALSE; }
if( strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") > 0 ) { $is_ie = TRUE; } else { $is_ie = FALSE; }

include("common_db.php");
include("frameworks/framework_database.php");
include("class_user.php");
include("class_evidence.php");
include("class_hypothesis.php");
include("class_project.php");
include("class_comment.php");
include("class_credibility.php");
include("functions.php");

include("nusoap/lib/nusoap.php");



if( isset($_REQUEST['print']) && $_REQUEST['print'] == "y" ) {
	$print_mode = TRUE;
} else {
	$print_mode = FALSE;
}


if( $_COOKIE['cookie_user_id'] == "0" ) {
	unset( $_COOKIE['cookie_user_id'] );
}

// Grab the cookie data.
if( isset($_COOKIE['cookie_user_id']) ) {
	$cookie_user_id = $_COOKIE['cookie_user_id'];
	$cookie_user_password = $_COOKIE['cookie_user_password'];
	$active_user = new User();
	$active_user->populateFromID($cookie_user_id);
	$show_user_menu = TRUE;
} else {
	/*$new_user = new User();
	$new_user->username = "anonymous";
	$new_user->password = "";
	$new_user->insertNew();
	$new_user->setCookies();
	$cookie_user_id = $new_user->id;*/
	$show_user_menu = FALSE;
}



// Log user in users_active.
if( $active_user->logged_in && substr($_SERVER['REQUEST_URI'], 0, 19) != "/insert_message.php" && substr($_SERVER['REQUEST_URI'], 0, 22) != "/show_active_users.php" ) {
	$found = false;
	$result = mysql_do("SELECT id FROM users_active WHERE user_id='$active_user->id'");
	while($query_data = mysql_fetch_array($result)) {
		$found = true;
	}
	$this_page = $_SERVER['REQUEST_URI'];
	if( $found ) {
		mysql_do("UPDATE users_active SET last_visited=NOW(), last_page='$this_page' WHERE user_id='$active_user->id'");
	} else {
		mysql_do("INSERT INTO users_active (id, user_id, last_visited, last_page, color) VALUES (NULL, '$active_user->id', NOW(), '$this_page', '000000');");
	}
}



?>