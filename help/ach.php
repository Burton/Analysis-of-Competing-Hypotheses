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


<h2> What Is ACH?</h2> 
<p>Analysis of Competing Hypotheses (ACH) is a simple model for how to think about a complex problem. It is an analytic process that identifies a complete set of alternative hypotheses, systematically evaluates data that is consistent and inconsistent with each hypothesis, and rejects hypotheses that contain too much inconsistent data. </p>

<p>ACH takes you through a process for making well-reasoned, analytical judgments. It is particularly useful for issues that require a careful weighing of alternative explanations of what has happened or is happening. ACH can also be used to provide early warning or help you evaluate alternative scenarios of what might happen in the future. ACH helps you overcome, or at least minimize, some of the cognitive limitations that make prescient intelligence analysis so difficult; it helps clarify why analysts are talking past one another and do not understand each other's interpretation of the data. ACH is grounded in basic insights from cognitive psychology, decision analysis, and the scientific method. It helps analysts protect themselves from avoidable error and improve their chances of making the right call.</p>

<p>This software provides a structured process for breaking a complex analytical problem down into its component parts - a full set of hypotheses (i.e., alternative explanations or outcomes), evidence and arguments that are useful in assessing these hypotheses, and judgments about the consistency or inconsistency of each item of evidence with each hypothesis. The software steps you through a process that helps you question your assumptions and gain a better understanding of the issue. The value of ACH is measured by the extent to which it helps you see an issue from alternative perspectives, prods you to look for additional evidence you had not realized was relevant, helps you question assumptions, identifies the most lucrative future areas of investigation, and generally stimulates systematic and creative thinking about the issue at hand.</p>

<p>The hypotheses, evidence, and analysis of the evidence are entered into a matrix that becomes a record of your thought process in analyzing a given topic or problem. This written record of your thought process is what helps you deal with the complexity inherent in most analytical problems. The software also allows you to sort and compare evidence in a variety of analytically-useful ways.


<h2>When to Use ACH, and Why</h2> 

<p>Use ACH:
<ul><li>when the judgment or decision is so important that you can't afford to be wrong.</li>
<li>to record and organize relevant evidence prior to making an analytical judgment or decision.</li>
<li>to identify and then question assumptions that may be driving your thinking, perhaps without realizing it.</li>
<li>when the evidence you are working with may be influenced by denial and deception.</li>
<li>when gut feelings are not good enough, and you need a more systematic approach that raises questions you had not thought of.</li>
<li>to prevent being surprised by an unforeseen outcome.</li>
<li>when an issue is particularly controversial and you want to highlight the precise sources of disagreement.</li>
<li>to maintain a record of how and why you reached your conclusion.</li>
</ul></p>


<h2>How Is ACH Different?</h2>

<p>ACH differs from conventional intuitive analysis in three important ways. Each of these differences is discussed in greater detail elsewhere in this Tutorial.</p>
<p><ul><li>ACH requires that you identify and analyze a full set of alternative hypotheses rather than a single most likely conclusion. This ensures that less likely but possible hypotheses receive fair treatment.</li>
<li>You proceed by trying to refute or eliminate hypotheses, whereas conventional intuitive analysis generally seeks to confirm a favored hypothesis. The correct hypothesis is the one with the least--or no--inconsistent information.</li>
<li>Instead of looking at one hypothesis and weighing the evidence pro and con for that hypothesis, you look at each item of evidence, one at a time, and assess whether that evidence is consistent or inconsistent with each of the hypotheses. This enables you to determine the "diagnosticity" of the evidence. An item of evidence is diagnostic when it helps you determine that one hypothesis is more likely to be true than another hypothesis. An item of evidence that is consistent with all hypotheses has no diagnostic value.</li>
</ul></p>
<a name="refuting"></a> 
<h2>Refuting vs. Confirming Hypotheses</h2>
<p>A fundamental precept of the scientific method is that one should proceed by rejecting or eliminating hypotheses, while tentatively accepting only those hypotheses that cannot be refuted. No matter how much information you have that is consistent with a given hypothesis, you cannot prove that hypothesis is true, because the same information may be and often is consistent with one or more other hypotheses. On the other hand, a single item of evidence that is inconsistent with a hypothesis may be sufficient grounds for rejecting that hypothesis. A classic example is a criminal suspect who has a solid alibi. A natural human tendency is to give more weight to information that supports our favorite hypothesis than to information that weakens it. This is unfortunate, as we should do just the opposite.</p>

<p>The scientific method obviously cannot be applied in toto when working with ambiguous and incomplete information, but the principle of seeking to disprove hypotheses, rather than to confirm them, can and should be applied to the extent possible. Instead of being content with showing that your favored hypothesis is supported by a lot of evidence, you need to refute all the possible alternatives. Any hypothesis that you cannot refute should be taken seriously. This switch in perspective forces you to ask questions and seek evidence you would not otherwise consider. This is what provides insurance against unpleasant surprise.</p>

<h2>When ACH May Not Meet Your Needs</h2>
<p>ACH will stimulate and guide an inquiring mind but will not force open a closed mind. It assumes analysts are truly interested in identifying and questioning assumptions and in developing new insights about the issue in question. It is unlikely that ACH will resolve an impasse between analysts who are firmly entrenched in their views about the issue and have a strong commitment to maintaining those views. If an analyst is unable to see alternative perspectives, the evidence will always be interpreted in a way that supports that analyst's preferred view. ACH can still be useful, however, in helping to pin down the exact basis for the disagreement. </p>

<p>If your goal is mathematical accuracy in calculating probabilities for each hypothesis, there are other versions of ACH that may better meet your needs. They use Bayesian inference or Bayesian belief networks and may require a methodologist trained in Bayesian statistics to assist you through the process. Although the Bayesian probability calculations are mathematically correct, the results cannot be any more accurate than the multitude of subjective judgments about the evidence that go into the Bayesian calculation. This ACH software program emphasizes what is practical and understandable for the average analyst to use. Its payoff comes from the analytical process it takes the analyst through, not from precise probability calculations for each hypothesis. The final judgment is made by the analyst, not by the computer.</p>

<p>ACH is not appropriate for all types of decisions. It is used to analyze hypotheses about what is true or what is likely to happen. One might also want to evaluate alternative courses of action, such as alternative business strategies, which computer to buy, or where to retire. In such cases, this software is of limited value. The ACH matrix can be used to break such a decision problem down into its component parts, with alternative choices (comparable to hypotheses) across the top of the matrix and goals or values to be maximized by making the right choice (comparable to evidence) down the side. However, this type of analysis requires a different type of calculation. The principle of refuting hypotheses (in this case alternative courses of action) cannot be applied to a decision based on goals or personal preferences. One would need a more traditional analysis of the pros and cons of each alternative.</p>
<p></p>

<p>On the next page, we explain <a href="help/ach_2.php">the mechanics of ACH</a>.</p>


</div>










</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>