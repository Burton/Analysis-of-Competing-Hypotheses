<?php

include("code/includes.php");

$error = false;

if( isset($_REQUEST['username']) ) {
	$this_user = new User();
	$this_user->getAttr($_REQUEST['username'], "username");
	if( md5($this_user->password) == $_REQUEST['password_hash'] ) {
		if( $_REQUEST['password'] == $_REQUEST['password_2'] ) {
			$this_user->password = md5($_REQUEST['password']);
			$this_user->update();
		} else {
			$error = true;
			$error_message = "Your passwords don't match. Please go back and fix this.";
		}
	} else {
		$error = true;
		$error_message = "Account not found.";
	}
}

?>

<html>
<head>
	<title>Password Reset</title>
	<?php include("parts/includes.php"); ?>
</head>

<body>



<?php include("parts/header.php"); 
include("parts/login_sidebar.php"); ?>



<div class="mainContainer">



<h2>Password Reset</h2>

<?php

if( $error ) { ?>

<p><?=$error_message?></p>

<?php } else { ?>

<p>Your password has been changed. Please log in above.</p>

<?php }

?>



</div>







<?php include("parts/footer.php"); ?>





</body>
</html>