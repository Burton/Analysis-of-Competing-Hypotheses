<?php



include("../code/includes.php");

$cookie_user_username = $_REQUEST['cookie_user_username'];
$cookie_user_password = md5($_REQUEST['cookie_user_password']);

$result = mysql_do("SELECT username, password FROM users WHERE username='$cookie_user_username';");
while($query_data = mysql_fetch_array($result)) {
	if ($query_data['password'] == $cookie_user_password) {
		$success = TRUE;
	} else {
		$failedlogin="That username/password combination is not correct";
	}
}

$goto = $_REQUEST['goto'] . $active_user->users[0];

if ($success) {
	$active_user = new User();
	$active_user->populateFromAttribute($_POST['cookie_user_username'], "username");
	$active_user->setCookies();
	User::successfulLogin();
	//print_r($active_user);
} else {
	User::failedLogin();
}

if( $_REQUEST['goto'] ) {
	$goto = $_REQUEST['goto'] . $active_user->users[0];
}



?>

<html>
<head>
	<title>Checking Log In...</title>
	<meta http-equiv=Refresh content="0; url=../<?=$goto?>">
	<?php include("../parts/includes.php"); ?>
	 <script language="JavaScript">
	
createCookie('cachchat', 'y', 7);

	</script>
</head>



<body>



</body>
</html>