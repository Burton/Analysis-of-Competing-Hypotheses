<?
###################################### C O P Y R I G H T S ####################################
# THIS SCRIPT IS DISTRIBUTED BY WEBUNE.COM UNDER LICENSE UNDER THE GPL RULES
# PLEASE DO NOT REMOVE THIS MESSAGE IN SUPPORT OF OUR HARD WORK TO CONTINUE TO PROVIDE FREE SUPPORT
###############################################################################################
# OK, HERE WE GO
# Use this varialble if you are using an installation script
$step = $_GET['step'];
if (!$step) {
	$page_title = 'Form';
}
else{
	$page_title = 'install step '.$step;
}
############## BEGIN FUNCTIONS ##############################
# FUNCTION TO TEST USERNAME AND PASSWORD IN MYSQL HOST
function db_connect($server, $username, $password, $link = 'db_link') {
	global $$link, $db_error;
	$db_error = false;
	if (!$server) {
		$db_error = 'No Server selected.';
		return false;
	}
	$$link = @mysql_connect($server, $username, $password) or $db_error = mysql_error();
	return $$link;
}
# FUNCTION TO SELECT DATABASE ACCESS
function db_select_db($database) {
	echo mysql_error();
	return mysql_select_db($database);
}
# FUNCTION TO TEST DATABASE ACCESS
function db_test_create_db_permission($database) {
	global $db_error;
	$db_created = false;
	$db_error = false;
	if (!$database) {
		$db_error = 'No Database selected.';
		return false;
	}
	if ($db_error) {
		return false;
	} else {
		if (!@db_select_db($database)) {
			$db_error = mysql_error();
			return false;
		}else {
			return true;
		}
	return true;
	}
}

function step1 ($error) {
	echo '<h1 style="color:#FF0000">'.$error.'</h1><hr>';
?>
<form name="form1" method="post" action="<? $_SERVER['PHP_SELF']; ?>?step=2">
<table border="0" cellspacing="5" cellpadding="5">
<tr>
<td><div align="right">mysql hostname:</div></td>
<td><input name="server" type="text" value="<? echo $_REQUEST['server']; ?>"> (usually &quot;localhost&quot;)</td>
</tr>
<tr>
<td><div align="right">mysql username:</div></td>
<td><input type="text" name="username" value="<? echo $_REQUEST['username']; ?>"></td>
</tr>
<tr>
<td><div align="right">mysql username password:</div></td>
<td><input type="text" name="password" value="<? echo $_REQUEST['password']; ?>"></td>
</tr>
<tr>
<td><div align="right">mysql database name:</div></td>
<td><input type="text" name="database" value="<? echo $_REQUEST['database']; ?>"></td>
</tr>
<tr>
<td colspan="2"><input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</form>
<?php
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Webune MYSQL TEST - <? echo $page_title; ?></title>
</head>
<body>
<h1><? echo $page_title; ?></h1>
<?
############## END FUNCTIONS ##############################
switch ($step) {
	case '2':
		if ($_REQUEST['server']) {
				$db = array();
				$db['DB_SERVER'] = trim(stripslashes($_REQUEST['server']));
				$db['DB_SERVER_USERNAME'] = trim(stripslashes($_REQUEST['username']));
				$db['DB_SERVER_PASSWORD'] = trim(stripslashes($_REQUEST['password']));
				$db['DB_DATABASE'] = trim(stripslashes($_REQUEST['database']));
				$db_error = false;
				db_connect($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);
				if ($db_error == false) {
					if (!db_test_create_db_permission($db['DB_DATABASE'])) {
						$error = $db_error;
					}
				} else {
					$error = $db_error;
				}
				if ($db_error != false) {
					$error = "failed";
					echo step1($db_error);
				} else {
					echo '<h1 style="color:green">Congratulations!</h1>Connected Successfuly to datbase <strong><a href="http://www.webune.com">Continue &gt;&gt; </a></strong>';
				}
		} else {
			$error = "ERROR: please provide a hostanme";
			echo step1($error);
		}
	break;

	default:
	echo step1('Step 1');
	break;
}
?>
<div align="center"><img src="http://www.webune.com/images/headers/default_logo.jpg" alt="Webune Hosting"></div>
<div align="center">Script Courtesy of <a href="http://www.webune.com">Webune PHP/Mysql Hosting</a></div>
</body>
</html>
