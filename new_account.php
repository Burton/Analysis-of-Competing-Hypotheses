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

$username = $_REQUEST['username'];

$display_user = new User();
$display_user->populateFromAttribute($username, "username");

?>

<html>
<head>
	<title>ACH: Sign Up</title>
	<?php include("parts/includes.php"); ?>
</head>

<body onload="setTimeout('Effect.Fade(\'statusMessage\')',2500); setTimeout('Effect.Fade(\'statusMessage2\')',2500);">


<?php include("parts/header.php"); ?>
<?php include("parts/login_sidebar.php"); ?>

<div class="mainContainer">

	<div class="ydsf left">
		<div class="inner">

			<div class="main">

				<?php if( !$active_user->logged_in ) { ?>
				
					<h2>Sign Up</h2>
					
					<form class="signUp" method="post" class="edit" action="make_new_account.php">
					
						<p><b>Username:</b> <input type="text" name="username" size="20" /></p>
						
						<p><b>Password:</b> <input type="password" name="password" size="20" /></p>
						
						<p><b>Confirm Password:</b> <input type="password" name="password2" size="20" /></p>
						
						<p><b>Real name:</b> <input type="text" name="name" size="40" /></p>
						
						<p><b>E-mail address:</b> <input type="text" name="email" size="40" /></p>
						
						<p><b>Phone:</b> <input type="text" name="unclassified_phone" size="40" /></p>
												
						<p><b>Office:</b> <input type="text" name="office" size="40" /></p>
						
						<p><b>Office Description:</b><br /><textarea rows="4" name="office_desc" cols="30"></textarea></p>
												
						<p><input type="submit" value="Sign Up" /></p>
					
					</form>
				
				<?php } ?>
			
			</div>

		</div>
	</div>

</div>



<?php include("parts/footer.php"); ?>





</body>
</html>