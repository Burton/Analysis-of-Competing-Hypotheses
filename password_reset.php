<?php
include("parts/includes.php");
include("code/includes.php");

if( isset($_REQUEST['submit']) ) {
	$this_user = new User();
	$this_user->getAttr($_REQUEST['email'], "email");
	if( $this_user->id > 0 ) {
		$user_found = true;
	} else {
		$user_found = false;
	}
	if( $user_found ) {
		$this_user->sendPasswordReset();
		//sendMail($this_user->email, "[CACH] Password reset request", "Please reset your password by visiting this URL:\r\n\r\n " . $base_URL . "/password_reset/" . $this_user->username . "/" . md5($this_user->password) . "\r\n\r\nThanks!\r\n\r\n - The ACH Bot");

	}
}

?>

<html>
<head>
	<title>ACH: Reset Your Password</title>
	<?php include("parts/includes.php"); ?>
</head>

<body>



<?php include("parts/header.php"); ?>







<div class="mainContainer">



<h2>Forgotten Password Recovery</h2>

<?php

if( $user_found ) { ?>
<p>Okay &mdash; we've sent you an e-mail with instructions for reseting your password.</p>
<?php } else {
	if( isset($_REQUEST['submit']) ) { ?>
<p class="error">Oops. We can't find that e-mail address in our system.</p>
	<?php } ?>

<p>Please enter your e-mail address and we'll send you instructions for resetting your password.</p>

<form method="post" action="/password_reset/">

<p><b>E-mail address:</b> <input type="text" size="30" name="email" / ></p>

<p><input type="submit" name="submit" value="Send instructions..." />

</form>
<?php }

?>



</div>







<?php include("parts/footer.php"); ?>





</body>
</html>