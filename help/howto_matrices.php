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



<div class="help">

<div class="fontSize"><a href="javascript:changeFontSize(1)" style:font-size="14px">Enlarge font</a><br /><a href="javascript:changeFontSize(-1)" style:font-size="8px">Shrink font</a></p></div>

<h2>The Matrices</h2>
<p>The core of an ACH project is a matrix of hypotheses and evidence. There are a few different ways to look at the matrix:
<ul><li>The Personal Matrix displays your own consistency/inconsistency ratings.</li>
<li>The Group Matrix shows you how much your team agrees about each evidence-hypothesis pair.</li>
<li>You can view the matrix with a teammate's consistency scores.</li>
<li>Finally, you can generate a comparison matrix: this looks just like the Group Matrix, only it compares your scores with those of one other team member instead of the entire team.</li>
</ul></p>

<a name="personal"></a>
<h2>Personal Matrix</h2>
<p>The Personal Matrix is for your own consistency scores. Here, you will assess the consistency of each piece of evidence to each hypothesis. To begin, click the "Edit Consistency Scores" link. When you do this, that link turns into a link to "stop editing."</p>

<p>As you complete the matrix, be sure to <a href="../help/rate_consistency.php#working_across">work across the matrix, not down</a>. For each hypothesis, ask yourself: if this hypothesis were true, is it likely that I would see this evidence? (For more tips, see our Help article on <a href="../help/rate_consistency.php">rating consistency scores</a>.) You do not have to complete the entire matrix; for example, if there is a piece of evidence that requires technical expertise you do not have, you are free to leave those cells blank.</p>

<p>Be sure to move your mouse over the evidence and hypothesis headers, as doing so will expose more details about these items. This is very helpful when assessing consistency.</p>

<p>When finished, click the "stop editing" link. When you do this, the hypothesis scores will adjust to reflect your new ratings. You can come back at any time and change your ratings.</p>

<a name="group"></a>
<h2>Group Matrix</h2>

<p>The Group Matrix shows the same set of evidence and hypotheses, only instead of filling the cells with inconsistency scores, it shows you how much consensus there is among you and your teammates. Each member of an analytical team completes a matrix. The Group Matrix then highlights the root causes of your disagreements, so that you can have a more productive discussion.</p>

<p>As you move your mouse over the cells, each member's score for that cell is revealed.</p>

<h2>Compare Matrices and User Matrices</h2>

<p>At the bottom of the Group and Personal Matrices, you are given options for two other types of matrices: one that let's you view another member's Personal Matrix, and one that lets you compare one member's scores with another's.</p>

<h2>Matrix Tools</h2>

<p>ACH gives you several options for manipulating matrices and making them more manageable:</p>

<p><strong>Adjust Column Width:</strong> If you need additional space for your hypothesis columns, simply drag the bottom-right corner of your browser window to adjust its size. ACH matrices will automatically adjust their widths accordingly.</p>

<p><strong>Hide/Show Columns:</strong> To save space in the matrix, it is possible to hide or show certain columns that are used less frequently than others. This is done by clicking on the Show Data Columns tab just above the matrix and then checking the columns you want to appear in the matrix. </p>

<p><strong>Printing:</strong> To print a matrix, click the Printer icon select Print in the File menu. If you have created multiple matrices, the program will only print one matrix at a time. To print all matrices, they must be selected and printed individually. You may need to adjust the column widths or slide the panel dividers so that the printed matrix will fit on one page.</p>

<p><strong>Matrix Duplication:</strong> If you are part of a multi-member ACH project, you may want to begin a private, solo project based on the same set of evidence and hypotheses. To do this, use the Duplicate Matrix link from your Personal Matrix. This will create an entirely separate project, with you as the sole member.</p>



</div>










</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>