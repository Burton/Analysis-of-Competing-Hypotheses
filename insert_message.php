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

header("Content-Type: text/plain");

include("code/includes.php");

$message = addslashes($_GET['message']);
$project_id = $_GET['project_id'];

if( $_GET['insert'] != "n" && $message != "" ) {
	mysql_do("INSERT INTO chat_log (user_id, project_id, chat) VALUES ('$active_user->id', '$project_id', '$message');");
}

if( $_REQUEST['project_id'] > 0 ) {
	showChat($_REQUEST['project_id']);
}

?>