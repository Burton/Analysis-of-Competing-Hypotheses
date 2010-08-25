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

<h2>ACH's Collaboration Tools</h2>

ACH features a number of tools to help you collaborate.

<h2>Evidence-Based Networking</h2>

<p>ACH allows you to find others in your organization who are using the same source documents you are. Often, analysts doing similar work are not aware of one another. An excellent way of finding such people is by identifying those who work with the same documents as you. ACH makes this easy.</p>

<p>If your evidence is based on a document with a unique ID, such as a URL or serial number, you can enter this ID into the Serial Number field on the evidence page. The ID will then be displayed on that page, and clicking the link next to it ("Who else is using this?") will show you all other ACH projects in your organization that are using that source document.</p>

<h2>Group Matrix</h2>

<p>If your ACH project as multiple members, each member, like you, will complete a Personal Matrix. Naturally, you and your counterparts will disagree on some of the consistency scores. The Group Matrix automatically shows you where those disagreements lie. Rolling your mouse over the cells will reveal how each project member scored the cell. <a href="../help/howto_matrices.php#group">Learn more about what you can do with the Group Matrix</a>.</p>

<h2>Persistent Chat</h2>

<p>Each ACH project has a dedicated chat room. When viewing your project, you can access the room by clicking the Chat button in the lower left corner of the page.</p>

<p>Unlike most chat rooms, you do not have to be present in the room to read what others have been saying. The ACH chat room displays the entire transcript since the project's creation, and any project member may participate.</p>

<h2>Message Boards</h2>

<p>Along with the chat tool, ACH provides a separate message board for each component of your project: every hypothesis, evidence item, and evidence-hypothesis pair has a dedicated page, the bottom half of which is dedicated to discussion.</p>

<p>You can reach the evidence and hypothesis pages from any matrix by clicking the text that corresponds to that item. For the evidence-hypothesis pair pages, click the cell while viewing the Group Matrix.</p>

</div>










</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>