<?php

include("code/includes.php");

if( isset($_REQUEST['username']) ) {
	$this_user = new User();
	$this_user->getAttr($_REQUEST['username'], "username");
	if( md5($this_user->password) == $_REQUEST['password_hash'] ) {
		$user_found_with_password = true;
	} else {
		$user_found_with_password = false;
	}
}

?>

<html>
<head>
	<title>Change Your Password</title>
	<?php include("parts/includes.php"); ?>
</head>

<body>



<?php include("parts/header.php"); ?>







<div class="mainContainer">



<h2>Password Reset</h2>

<?php

if( $user_found_with_password ) { ?>

<p>Please enter and confirm your password below:</p>

<form method="post" action="/password_reset/action">

<input type="hidden" value="<?=$_REQUEST['username']?>" name="username" / >

<input type="hidden" value="<?=$_REQUEST['password_hash']?>" name="password_hash" / >

<p><b>Password:</b> <input type="password" size="15" name="password" / ></p>

<p><b>Confirm Password:</b> <input type="password" size="15" name="password_2" / ></p>

<p><input type="submit" name="submit" value="Change Password" />

</form>

<?php } else { ?>

<p>Account not found.</p>

<?php }

?>



</div>







<?php include("parts/footer.php"); ?>





</body>
</html>