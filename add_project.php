<?php
/* ////////////////////////////////////////////////////////////////////////////////
**    Copyright 2010 Matthew Burton, http://matthewburton.org
**    Code by Burton and Joshua Knowles, http://auscillate.com 
**
**    This software is part of the Open Source ACH Project (ACH). You'll find 
**    all current information about project contributors, installation, updates, 
**    bugs and more at http://competinghypotheses.org.
**
**
**    ACH is free software: you can redistribute it and/or modify
**    it under the terms of the GNU General Public License as published by
**    the Free Software Foundation, either version 3 of the License, or
**    (at your option) any later version.
**
**    ACH is distributed in the hope that it will be useful,
**    but WITHOUT ANY WARRANTY; without even the implied warranty of
**    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
**    GNU General Public License for more details.
**
**    You should have received a copy of the GNU General Public License
**    along with Open Source ACH. If not, see <http://www.gnu.org/licenses/>.
//////////////////////////////////////////////////////////////////////////////// */

//THIS FILE IS THE PAGE AT [CACHDOMAIN]/PROJECT/NEW
include("code/includes.php");

$show_login = FALSE;
$show_client_menu = FALSE;
$is_index = TRUE;

?>

<html>
<head>
	<title>ACH: Create New Project</title>
	<?php include("parts/includes.php"); ?>

<script type="text/javascript">
//this function validates the form. it requires the project title and description fields to be filled out
function validateFormOnSubmit(theForm) {
var reason = "";

  reason += validateTitle(theForm.title);
  reason += validateEmpty(theForm.description);
      
  if (reason != "") {
    alert(reason);
    scrollTo(0, 100);
    return false;
    
  }

  return true;
}
function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Project Description is required.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
function validateTitle(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Project Title is required.\n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}

//this function grays out the Open Project options if Private Project is selected

function Disab (val) {
if(val=="1")
{nav.public[0].disabled=true;nav.public[0].checked=false;
nav.public[1].disabled=true;nav.public[1].checked=false;
nav.open[0].disabled=true;nav.open[0].checked=false;
nav.open[1].disabled=true;nav.open[1].checked=false;
}
if(val=="2")
{
nav.public[0].disabled=false; nav.public[1].checked=true
nav.public[1].disabled=false;
nav.open[0].disabled=false; nav.open[0].checked=true;
nav.open[1].disabled=false
}
}
</script>


</head>

<body>



<?php include("parts/header.php"); ?>







<?php
	
if( $active_user->logged_in ) { ?>
	
	
	
<?php include("parts/menu_sidebar.php"); ?>

<div class="mainContainer">

	<div class="ydsf left">
	
		<div class="inner">

			<div class="main">
	
				<form onsubmit="return validateFormOnSubmit(this)" name="nav" method="post" class="edit" action="add_project_action.php">
	
				
				<h2>Create New Project</h2>
				(If you have built any projects in the <a href="http://www2.parc.com/istl/projects/ach/ach.html">
				original ACH software</a>, you may <a href="<?=$base_URL?>import/">import those matrices here</a>.)
				<div class="form">
					
					<h3 style="color: red">Title (required)</h3>
					
					<p><input type="text" name="title" value="" size="20" /></p>
					
					<p class="formNote">A short phrase or question that summarizes the project.</p>
					
					<h3 style="color: red">Description (required)</h3>
					
					<p><textarea rows="4" name="description" cols="30"></textarea></p>
					
					<h3>Keywords</h3>
					
					<p><input type="text" name="keywords" size="50" /></p>
					
					<p class="formNote">Comma-seperated. Optional.</p>
					

					<div class="privacySettings">
					<h3>Project Privacy <?php helpLink('howto_project_management.php#project_privacy') ?></h3>
					<br />
					<p class="formNote">Note: The below options enable you to decide whether your project 
					is listed in your organization's directory of ACH projects, and, if so, the 
					circumstances under which others may view or join your project. The 
					directory provides a basic description of the project and its participants.</p><br />
					<input type="radio" name="directory" value="n" onClick="Disab
					(1)"><strong>Private Project</strong><p class="formNote">This project will not be listed in the directory. You will select and communicate directly with any individuals whom you 
					want to view your work or to participate with you in a collaborative project. </p>
					<br/>______________<br/><br/>
					<p><input type="radio" name="directory" value="y" CHECKED onClick="Disab
					(2)"><strong> Open Project</strong></p>
					<p class="formNote">This project will be listed in the directory. The following options apply to this listing:</p>
					<br/>
					<p>&nbsp;&nbsp;<input type="radio" name="public" value="n" ><em>Restricted Viewership</em>. Anyone
					who wants to view your project's data and discussion must first obtain your approval. 
					<br />
					&nbsp;&nbsp;<input type="radio" name="public" value="y" CHECKED ><em>Publicly Viewable</em>. Anyone will 
					have access to view this project's data and discussion at any time.</p>
					<br/>
					<p>&nbsp;&nbsp;<input type="radio" name="open" value="n" CHECKED><em>Restricted Membership</em>. 
					Anyone who wants to become a member and active participant in this project must 
					contact you and ask for your permission.
					<br/>
					&nbsp;&nbsp;<input type="radio" name="open" value="y" ><em>Open Membership</em>. <span class="formNote">
					&nbsp;&nbsp;Anyone who wishes to contribute to this project is welcome to join it and become 
					active members. </span></p>
					<br/>
					
					<!--
					<p><input type="radio" name="directory" value="y" CHECKED >put in searchable directory
					<br/>
					<input type="radio" name="directory" value="n" >leave out of directory and search</p>
					</div>
					Old way:
					
					<h4><input type="checkbox" onclick="intuitive_privacy_options()" name="ToggleButton" value="Enable/Disable Form Elements">Totally Private (Disables other options)</h4>
					<p class="formNote">Best for solo projects. No one will be informed of your project unless you give them access to view it or to participate with you in a collaborative project. This project will not be included in the A-Space list of ACH projects and their owners. This A-Space list is intended to support collaboration.</p>
					
					<h4><input type="checkbox" name="public" value="y" CHECKED/> Make Publicly Viewable?</h4>
					<p class="formNote">If checked, any A-Space user will be able to view this project's information without becoming a member of the project.</p>
					
					<h4><input type="radio" name="open" value="y" CHECKED/> Open Membership</h4>
					<p class="formNote">With open membership, anyone who wants to can join your project. If unchecked, new members must receive your permission in order to join.</p>
					
					<h4><input type="radio" name="open" value="n" /> Restricted Membership</h4>
					<p class="formNote">Those wishing to join your project must first request your permission.</p>
					
					-->
					
					
				
					</div>
				
					<p class="submit"><input class="button" type="submit" value="Save" /></p>
					<p class="formNote">NOTE: As the project owner, you may change these settings at any time.</p>

				</div>
			</form>

			</div>
		</div>
				
	</div>
				
</div>

<?php } else { ?>

<div class="mainContainer wide">

	<div class="ydsf left">
		<div class="inner">

			<div class="main">

				<h2>Access Denied</h2>
				
				<p>You are not authorized to view this page.</p>

			</div>

		</div>
	</div>

</div>

<?php } ?>







<?php include("parts/footer.php"); ?>





</body>
</html>