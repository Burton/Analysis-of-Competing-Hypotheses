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

include("code/includes.php");

$active_user = new User();

$success = TRUE;
$fail_text = "";

foreach ($_REQUEST as $field => $value) {
	$active_user->$field = addslashes($value);
}


if( $_REQUEST['username'] ) {
	$result = mysql_do("SELECT * FROM users WHERE username = '".$_REQUEST['username']."'");
	$rows = mysql_num_rows($result);
	if ($rows==0) {
	} else {
		$success = FALSE;
		$fail_text .= "<li>That username is already taken. Please try a different username.</li>";
	}
} else {
	$success = FALSE;
	$fail_text .= "<li>You must enter a username.</li>";
} 



if( strpos( $_REQUEST['username'], " " ) == FALSE ) {
} else {
	$success = FALSE;
	$fail_text .= "<li>Your username may not contain spaces.</li>";
}

if( $_REQUEST['password'] == $_REQUEST['password2'] ) {
	if( $_REQUEST['password'] ) {
	} else {
		$success = FALSE;
		$fail_text .= "<li>You must enter a password.</li>";
	}
	$active_user->password = $_REQUEST['password'];
} else {
	$success = FALSE;
	$fail_text .= "<li>Your passwords do not match.</li>";
}

if( strpos( $_REQUEST['email'], "@" ) != FALSE ) {
} else {
	$success = FALSE;
	$fail_text .= "<li>Your e-mail address does not contain a '@' and is not valid.</li>";
}

if( $success == TRUE ) {
	$active_user->password = md5($active_user->password);
	$active_user->insertNew();
	$active_user->setCookies();
}

?>



<html>
<head>
	<title>ACH</title>
	<?php include("parts/includes.php"); ?>
</head>

<body onload="setTimeout('Effect.Fade(\'statusMessage\')',2500); setTimeout('Effect.Fade(\'statusMessage2\')',2500); bridge.replaceHeader('BridgeHeader', '1');">



<?php include("parts/header.php"); ?>




	


<?php include("parts/login_sidebar.php"); ?>



<div class="mainContainer">
	<div class="ydsf left">
		<div class="inner">
			<div class="main">



			<?php if( $success == TRUE ) { ?>
				
				<h2>Created!</h2>
				
				<p>Your account has been made.</p>
				
				
				
				
				<?php include('intro.php');?>
			
			
			<?php } else { ?>
				
				<h2>Oops</h2>
				
				<p>There has been a problem:</p>
				
				<ul><?=$fail_text?></ul>
				
				<p>Please use your browser's back button to go back and fix these.</p>
			
			<?php } ?>



			</div>
		</div>
	</div>
</div>



<?php include("parts/footer.php"); ?>





</body>
</html>