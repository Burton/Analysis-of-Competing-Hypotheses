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

<h2>Rate Consistency of Evidence </h2> 

<p>After entering your evidence and hypotheses, the next step is to assess whether each item of evidence is Consistent or Inconsistent with each hypothesis. For each hypothesis, ask yourself: if this hypothesis were true, is it likely that I would see this evidence? If the answer is "Yes," change the consistency rating to show that the evidence is Consistent (C) with the hypothesis; if "No," mark it as Inconsistent (I). If it is Very Consistent or Very Inconsistent, mark it CC or II. The Very Consistent (CC) and Very Inconsistent (II) ratings are used when you have a high degree of confidence in providing the rating or believe the item of evidence makes a compelling case supporting or contradicting a hypothesis.</p>

<p>Evidence may also be Neutral (N) or Not Applicable (NA) to some hypotheses. The Neutral (N) designation is used when there are alternative interpretations of the evidence, one Consistent and the other Inconsistent. The Not Applicable (NA) rating is appropriate when an item of evidence is clearly not applicable to one or more of the hypotheses.</p>

<p>You may sometimes find that you are not qualified to comment on the consistency of some evidence; for instance, if you are a human factors expert, and the evidence regards chemical weapons. In such cases, you are free to leave the cell blank.</p>

<h2>How to Start Rating</h2>

	<p>To enter or edit Consistency ratings, go to your Personal Matrix and click the "Edit your consistency scores" link. Your matrix cells will become pop-up lists. Scoring each cell is as simple as choosing the appropriate scores from the pop-up lists. Each score is instantly saved the moment you select it. If your computer crashes while you're in the middle of scoring a matrix, all of the scores entered up to that point are safe.</p>
	
	<p>Also note that while you enter scores, the hypothesis scores at the top of the matrix do not change. Updated hypothesis scores will be displayed once you click the "stop editing" link.</p>

<a name="working_across"></a>
<h2>Working Across the Matrix</h2>

	<p>In entering the Consistency ratings, <strong>it is essential that you work across the matrix</strong>, assessing the Consistency of the evidence, one item at a time, against each of the hypotheses. <strong>Do not work down the matrix.</strong> That is, do not take one hypothesis at a time and assess the consistency or inconsistency of all the evidence for that single hypothesis.</p>
	
	<p>This procedure enables you to assess what is called the "diagnostic" value of the evidence. Diagnosticity of evidence is an important concept that is, unfortunately, unfamiliar to many analysts. Evidence is diagnostic when it is Inconsistent with one or more hypotheses and Consistent with others. That is, it influences your judgment on the relative likelihood of the various hypotheses. If an item of evidence is Consistent or Inconsistent with all hypotheses, it has no diagnostic value. In doing an ACH analysis, it is a common experience to discover that much of the evidence supporting what you believe to be the most likely hypothesis is really not helpful, because the same evidence is consistent with all the other hypotheses. In this case, it would be misleading to use this particular item of evidence to support your analytic conclusion. In some cases, it might even prove counterproductive because someone reading your assessment who supports a contrary hypothesis could argue that the evidence you cite also is consistent with their view.</p>
	
	<p>If an item of evidence is Very Inconsistent (II) with a hypothesis, and if that evidence rates high on Credibility, this is a strong indicator that the hypothesis is unlikely. To sort by Diagnosticity, go to Sort Evidence and select Diagnosticity.</p>
	
	<p>The standards you use for judging Consistency and Credibility sometimes evolve as you gain a better understanding of the relationship between the hypotheses and the evidence. After entering all the evidence, go back and make sure the judgments are consistent. Change any ratings you now see in a different light. You may need to do this several times during the course of the analysis.</p>
	
	<p>ACH uses the Consistency ratings to calculate an Inconsistency Score for each hypothesis. Evidence that is Inconsistent (I) counts one point, and Very Inconsistent (II) counts two points. Because the focus is on refuting hypotheses rather than confirming them, only Inconsistent and Very Inconsistent evidence is counted in the Inconsistency Score.</p>

<h2><A NAME="credWeight" class="name">Credibility Weight</A></h2>

	<p>Open Source ACH allows you to assign credibility weights to each item of evidence. This is optional because it adds an element of complexity to the analysis that is not always needed to achieve the basic goals of the ACH analysis. How this weight is conceptualized is also optional. Credbility weight can be rated as High, Medium, or Low for each item of evidence. A High weight increases the value of an Inconsistent or Very Inconsistent rating of the evidence, while a low weight decreases it.</p>
	
	<p>It is suggested that analysts starting a new project should not use Credibility weights. They can be added later if desired.</p>
	
	<p>Credibility depends on both the reliability of the source and the credibility of the information provided by the source, which are separate but closely related concepts. For example, even a highly reliable source can occasionally produce information of questionable accuracy. A proven source may report inaccurate information if the source has only indirect or incomplete access to the information, or if the source is reporting his or her own conclusions which may or may not be accurate. Similarly, imagery and SIGINT are unimpeachable sources but may be vulnerable to denial or deception if our collection capability is known to the other side. Some technical sources are also vulnerable to faulty interpretation of imagery or faulty translation of communication intercepts. For an eyewitness source in a criminal investigation, credibility of the reported observation depends upon such things as time elapsed since the observation, circumstances of how the observation was made, and whether the witness at the time of the observation recognized the importance of remembering what was observed. The analyst should consider such factors before rating Credibility. </p>
	<p>Sorting by Credibility highlights the evidence that you have said is most credible. It is an alternative means of identifying evidence that may warrant a hard look at how the evidence was evaluated. To sort by Credibility, go to Sort Evidence and select Credibility. For a discussion of how this variable affects the Weighted Inconsistency Score, see Calculation of Scores. If you do not want to assign Credibility or Relevance weights, change the scoring calculation to Inconsistency Score and this column will disappear.</p>
</div>










</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>