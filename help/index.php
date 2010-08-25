<?php

include("../code/includes.php");

$username = $_REQUEST['username'];

$display_user = new User();
$display_user->populateFromAttribute($username, "username");

?>

<html>
<head>
	<title>ACH: Help</title>
	<?php include("../parts/includes.php"); ?>
	<script language="JavaScript" type="text/javascript">

function changeFontSize(inc)

{

  var p = document.getElementsByTagName('p');

  for(n=0; n<p.length; n++) {

    if(p[n].style.fontSize) {

       var size = parseInt(p[n].style.fontSize.replace("px", ""));

    } else {

       var size = 14;

    }

    p[n].style.fontSize = size+inc + 'px';

   }

}

</script>
</head>

<?php include("../parts/header.php"); ?>







<?php
	
if( $active_user->logged_in ) { ?>
	


<?php include("../parts/menu_sidebar.php"); ?>

<?php } else { ?>



<?php include("../parts/login_sidebar.php"); ?>





</div>

<?php } ?>



<div class="mainContainer">

<div class="ydsf left"><div class="inner">

<h2>ACH Help Documents</h2>

	<h3>The ACH Methodology</h3>
		
	<p><a href="../help/ach.php">What is ACH?</a>: An introduction to the concept.</p>
	<p><a href="../help/ach_2.php">ACH: A 9-Step Process</a>: step-by-step instructions, along with a sample product.</p>
	<p><a href="../help/collaboration_steps.php">ACH as a Collaborative Process</a></p>
	<p><a href="../help/hypotheses.php">Choosing Hypotheses</a></p>
	<p><a href="../help/evidence.php">Choosing Evidence</a></p>
	<p><a href="../help/rate_consistency.php">Rating the Consistency of Your Evidence</a></p>
	
	<h3>The ACH Software</h3>
	<p><a href="../help/howto_collaborate.php">ACH's Collaboration Tools</a></p>
	<p><a href="../help/howto_hypotheses.php">Entering and Editing Hypotheses</a></p>
	<p><a href="../help/howto_evidence.php">Entering and Editing Evidence and Arguments</a></p>	
	<p><a href="../help/howto_matrices.php">Working With Matrices</a></p>
	<p><a href="../help/howto_project_management.php">Project Management</a></p>






</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>