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

<h2>ACH as a Collaborative Process</h2>

<p>ACH is an excellent framework for collaboration among analysts. Although the software tool can be used by an individual analyst, the cross-fertilization of ideas when a group of analysts work together as a team helps analysts avoid personal bias and generates more and better ideas. When a team approach is adopted, the project can combine inputs and insights from analysts with different backgrounds. When analysts disagree, the <a href="../help/howto_matrices.php#group">Group Matrix</a> can be used to highlight the precise area of disagreement. Subsequent discussion can then focus productively on the ultimate source of the differences.</p>
<p>It is also possible to do a sensitivity analysis to see how alternative interpretations of the evidence or different assumptions affect the likelihood of the alternative hypotheses. This often helps resolve, or at least narrow down, areas of disagreement. It is also possible to go back and enter different ratings and see how any single change or set of changes affects the overall likelihood of the various hypotheses. In this way, it is possible to clearly identify which disagreements are important to resolve and which really aren't worth arguing about.</p>

<p>A collaborative ACH project can be implemented with a four-step process:
<ul>
<li>Identify an agreed-upon set of data relevant to the topic; remember to include assumptions, logical deductions, the absence of data, and conclusions from other analyses.</li>
<li>Convene a structured brainstorming session with a diverse group of analysts to identify all the potential hypotheses.</li>
<li>Commission one analyst or a small group of analysts to work independently--and on their own time schedules--to load the data. Then invite all interested analysts to take part in the project by analyzing the data in their own Personal Matrix. This might take several days or weeks. This should provide independent validation of the key conclusions, and because they are working from their own desks instead of together, the likelihood of groupthink is minimized.</li>
<li>Reconvene the larger group to assess the results of the working group. Use the <a href="../help/howto_matrices.php#group">Group Matrix</a> to determine the sources of disagreement. Focus on what data emerges as most diagnostic, the most persuasive reasons for discounting hypotheses, the credibility of the data supporting the most likely hypotheses, and the most productive areas for future research or collection.</li>
</ul></p>
<p>(If you want to know more about collaborating with ACH, read our article about the software's <a href="../help/howto_collaborate.php">collaborative features</a>.)</p>
<p>The next article about the ACH methodology explains a critical step: <a href="../help/hypotheses.php">creating good hypotheses</a>.
</div>










</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>