<div class="menu">


<form method="post" action="auth/check_log_in.php">

<div class="loginForm">

<?php

if ($_COOKIE['failed_login'] ) {
	echo "<div class='loginFail'><p>You provided an incorrect username/password combination. Please try again.</p></div>";
}

?>

<p class="label">User Name: <input class="login" type="text" size="15" name="cookie_user_username" /></p>

<p class="label">Password: <input class="login" type="password" size="15" name="cookie_user_password" /></p>

<p><input type="submit" value="Sign in" /></p>

<p class="forgot"><a href="/password_reset/">Forget your password?</a></p>

<p class="signUp"><a href="/signup/">Sign Up for an Account...</a></p>

</div>

</form>


</div>