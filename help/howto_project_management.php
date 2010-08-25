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

<h2>Project Management</h2> 

<p>This page will guide you through creating a project, maintaining privacy settings, and inviting new users.</p>

<a name="creating_a_project"></a> 
<h2>Creating a Project</h2>

<p>To create a new project, click the Create New Project link at the top of any page on this site. There, you can fill out basic project details such as a title, a brief explanation of the problem, classification, and privacy settings.</p>

<a name="project_privacy"></a> 
<h2>Privacy Settings & Access Control</h2>
<p>Open Source ACH allows for multiple levels of data privacy. These settings are established on the Create New Project page:
<ul>
<li>Publicly Viewable: If you make your project publicly viewable, anyone in your organization will be able to see the project's matrices, whether they have joined the project or not. If the project is not publicly viewable, people will have to join your project in order to see its data. You can therefore control membership access with Open or Closed Membership, explained below.</li> 

<li>Open membership: If your project is not publicly viewable, people will have to join the project in order to see its data. ACH lets you control who can and who cannot join your project. If you choose Open Membership, any member of your organization has permission to join your project at the click of a button. Otherwise, new members will have to first request access. The site will then notify the project owner, who can then grant or deny access through this Web site. All outstanding requests--both those you've made and those you've received--are listed on your home page.</li>
</ul>
</p>
<p>Both of these settings can be changed later on the Edit Project page (accessible only to the project owner).</p>

<p>Note that when someone joins a project, they receive their own Personal Matrix. Sometimes, you will want to show your private project to someone, such as a supervisor, without creating a Personal Matrix for them. This can be done by inviting a View-Only Member:
<ul>
<li>Go to the project home page and click the Show Details link next to the project title.</li>
<li>Click the INVITE link on the View-Only Members line.</li>
<li>Enter the email address of the person you wish to invite, and click the Invite button.</li>
</ul></p>
<p>Only join a project if you intend to complete your Personal Matrix. Otherwise, the project will become overloaded with members who have not contributed any analysis, diluting the contributions of the true members.</p>

<p>All of the information you enter here can be seen from any matrix by clicking the Show Details link next to the project header. Here you'll find a list of all project members and viewers, the keywords associated with the project, the project's overall classification, and the privacy settings.</p>

<h2>Project Owners</h2>
<p>When you create a project, you automatically become the project's "owner." This means you have more control over the project's details than others do. It also means you have certain responsibilities. Those controls and responsibilities include:
<ul>
<li>Editing the project title, description, and classification, and changing the project's privacy settings. If you are the project owner, you will see the Edit Project link underneath the project title. Clicking this link will allow you to modify these settings.</li>
<li>Adding and editing hypotheses</li>
<li>Granting and refusing membership requests (if your project does not have Open Membership)</li>
</ul></p>

<p>If you are the project owner, you may relinquish this power to another member on the Edit Project page.</p>

<h2>Leaving Projects</h2>
<p>If you no longer want to participate in a project, click the Leave Project link. This link will be revealed if you click
the Show Details link next to the project header. When you leave, your consistency scores will no longer be reflected
in the Group Matrix; however, in case you decide to return later, all of your scores will be preserved.</p>

<p>If you are the project owner, you cannot leave a project until you designate a new owner on the Edit Project Options
page.</p>
</div>










</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>