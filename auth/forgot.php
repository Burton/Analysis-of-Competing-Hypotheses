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

	$hasEmail = false;

if ($_POST['Submit'])
	{
	$email = $_POST['email'];
	
		$result = mysql_do("SELECT password, username FROM users WHERE email = '$email' LIMIT 1");	
		
			if ($hit = mysql_fetch_array($result, MYSQL_ASSOC)){
				$hasEmail = true; 
				$password = $hit["password"];
				$username = $hit["username"];
				$subject = "CACH Login Info";
				$from = "noreply@competinghypotheses.org";
				$to = $_POST['email'];
				$message = "Your CACH username is '$username', and your password is '$password'.\r\n\r\n - the CACH robot";
				$headers = "From: $from\r\nReply-To: $from\r\n";
				$params = "-f $from";
				mail($to, $subject, $message, $headers, $params);
			} else { $error = "We do not have a record with the email <strong>".$_POST['email']."</strong> in our files.";}
}	
?>

<html>
<head>
<meta http-equiv = "Content-Type" content = "text/html; charset = iso-8859-1">
<title>Forgot Username/Password</title>
<style type = "text/css">

body {
	font-family: lucida grande, verdana;
	font-size: 11px;
	margin: 30px;
	padding: 0px;
	background: #FFFFFF;
}

h3 {
	margin-top: 10px;
	margin-bottom: 0px;
	font-weight: normal;
	font-size: 16px;
}

a {
	color: #FF0000;
	font-weight: bold;
	text-decoration: none;
}

a {
	color: #0095E5;
	text-decoration: none;
}

a:hover {
	text-decoration: underline;
}

textarea,input {
	background: #EAEAEA;
}

input.submit {
	background: #62D5FF;
	border: #00B2F4 2px solid;
}

div.error {
	margin: 10px 0px 10px 0px;
	padding: 1px 5px;
	border: solid 1px #FF0000;
}

div.error p {
	margin: 3px 15px;
	color: #FF0000;
}

</style>
</head>

<body>
<div class = "body">
 
 <h3>Lost username/password?</h3>
 <?php if ($hasEmail == true)
	{
	echo "<div class = 'message'><p>You will receive your username and password via email shortly.</p><a href = 'javascript:window.close();'>Close this window...</a></p></div>";
	}
	?>
<?php if ($hasEmail == false) {
	if ($error) {?>
 <div class="error"><p><?php echo $error; ?></p></div>
 <?php }?>
 <p>Enter your email address, and your username and password will automatically be emailed to you. </p>
<form name="form1" method="post" action="">
   <p>
     <b>Email:</b>
     <input name="email" type="text" id="email" value="<?php echo $_POST["email"]; ?>" size="30">
     <input class="submit" type="submit" name="Submit" value="Get it">
</p>
   </form>
</div>
</body>
</html>
<?php } ?>