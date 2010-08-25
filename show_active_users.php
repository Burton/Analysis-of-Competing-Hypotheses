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

include_once("code/includes.php");

$project_id = $_REQUEST['project_id'];

$active_users = getActiveUsers($project_id); 
print_r($active_users);
if (empty($active_users)) { 
	echo "No active users."; 
	}
?>

<ul>

<?php for( $i = 0; $i < count($active_users); $i++ ) {
	$this_user = new User();
	$this_user->populateFromId($active_users[$i]);
	echo("<li><p><a class='name' href='" . $base_URL . "/profile/" . $this_user->username . "' style='color: #" . $this_user->color . ";'>" . $this_user->name . "</a><br />Viewing: <a href='" . $this_user->last_page . "'>" . $this_user->last_page . "</a></p></li>");
}

?></ul>