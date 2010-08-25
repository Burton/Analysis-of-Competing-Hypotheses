<?php /* ////////////////////////////////////////////////////////////////////////////////
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
?>

<base href="">
<?php $base_URL="";
$email_domain="";
$versionNumber="0.9alpha"?>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/sortabletable.css" />


<script type="text/javascript" src="js/sortabletable.js"></script>

<script language="JavaScript" src="js/overlib/overlib.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_anchor.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_crossframe.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_cssstyle.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_exclusive.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_followscroll.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_hideform.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_shadow.js" type="text/javascript"></script>
<script language="JavaScript" src="js/overlib/overlib_centerpopup.js" type="text/javascript"></script>

<script src="js/lib/prototype.js" type="text/javascript"></script>
<script src="js/src/scriptaculous.js" type="text/javascript"></script>

<script src="js/zxml.js" type="text/javascript"></script>
<script src="js/misc.js" type="text/javascript"></script>
<script src="js/cookies.js" type="text/javascript"></script>

<script language="JavaScript">

isIE = "n";
if( navigator.appName == "Microsoft Internet Explorer" ) { isIE = "y"; }

<?php

// Only load this stuff if we're on a project page.

if( $active_project->id != "" ) {
	$active_project_id = $active_project->id;

?>

var chatActive = <?php if( $_COOKIE['cachchat'] == "y" ) { echo('"y"'); } else { echo('"n"'); } ?>;
var baseURL = "<?php print $base_URL; ?>";

function confirm_delete_evidence(id) {
	confirmer = confirm("Are you sure you want to delete this piece of evidence?");
	if( confirmer == true ) { 
		window.location.href = baseURL+"/project/<?=$active_project_id?>/evidence/"+id+"/delete";
	} else {
		alert("Delete canceled.");
	}
}

function confirm_delete_hypothesis(id) {
	confirmer = confirm("Are you sure you want to delete this hypothesis?");
	if( confirmer == true ) { 
		window.location.href = baseURL+"/project/<?=$active_project_id?>/hypothesis/"+id+"/delete";
	} else {
		alert("Delete canceled.");
	}
}

var thisProjectId = <?=$active_project_id?>;



function insertMessage() {
	showWheel();
	var sIdMessage = document.getElementById("message").value;
	//var sIdProject = document.getElementById("project_id").value;
	var oXmlHttp = zXmlHttp.createRequest();
	oXmlHttp.open("get", "insert_message.php?insert=y&message=" + sIdMessage + "&project_id=" + thisProjectId, true);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById("messages").innerHTML = oXmlHttp.responseText;
				document.getElementById("message").value = "";
			} else {
				document.getElementById("messages").innerHTML = "Error.";
			}
			hideWheel();
			//document.getElementById("charCount").innerHTML = "0";
		}            
	}
	oXmlHttp.send(null);
}



<?php if( $is_firefox || !$is_firefox) { ?>

function reloadConversation() {
	if( chatActive == "y" ) {
		var date = new Date();
		var timestamp = date.getTime();
		var oXmlHttp = zXmlHttp.createRequest();
		//var sIdProject = document.getElementById("project_id").value;
		oXmlHttp.open("get", "insert_message.php?insert=n&message=&project_id=" + thisProjectId+"&internetexplorerisawful="+timestamp, true);
		oXmlHttp.onreadystatechange = function () {
			if (oXmlHttp.readyState == 4) {
				if (oXmlHttp.status == 200) {
					document.getElementById("messages").innerHTML = oXmlHttp.responseText;
				} else {
					document.getElementById("messages").innerHTML = "";
				}
			}            
		}
		oXmlHttp.send(null);
		setTimeout("reloadConversation()", 3000);
	}
}

<?php } ?>



function reloadActiveUsers() {
	var oXmlHttp = zXmlHttp.createRequest();
	//var sIdProject = document.getElementById("project_id").value;
	oXmlHttp.open("get", "show_active_users.php?project_id=" + thisProjectId, true);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				displayUsers(oXmlHttp.responseText);
			} else {
				displayUsers("");
			}
		}            
	}
	oXmlHttp.send(null);
	setTimeout("reloadActiveUsers()", 5000);
}

function displayUsers(sText) {
	var divActiveUsers = document.getElementById("activeUsers");
	activeUsers.innerHTML = sText;
}



function showWheel() {	
	document.getElementById("wheel").innerHTML = "Saying..."; //<img src='/images/chat_wheel.gif' /> 
}

function hideWheel() {
	document.getElementById("wheel").innerHTML = "";
}



reloadConversation();
//reloadActiveUsers();



<?php if( $is_firefox ) { ?>

function getReturn(e) {
	var keychar
	if(window.event) { // IE
		keychar = e.keyCode
	}
	else if(e.which) { // Netscape/Firefox/Opera
		keychar = e.which
	}
	if( keychar == 13 ) {
		insertMessage();
	}
}

<?php } ?>

<?php } ?>







function switchFlag(dom_id, ev_id) {
	document.getElementById(dom_id).innerHTML = "<img src='"+baseURL+"/images/icons/arrow_refresh_small.png' />";
	var oXmlHttp = zXmlHttp.createRequest();
	oXmlHttp.open("get", "switch_flag.php?evidence_id=" + ev_id, true);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById(dom_id).innerHTML = oXmlHttp.responseText;
			} else {
				document.getElementById(dom_id).innerHTML = "<img src='"+baseURL+"/images/icons/error.png' />";
			}
		}            
	}
	oXmlHttp.send(null);
}



function switchCred(dom_id, cred_id) {
	document.getElementById(dom_id).innerHTML = "<img src='"+baseURL+"/images/icons/arrow_refresh_small.png' />";
	var oXmlHttp = zXmlHttp.createRequest();
	oXmlHttp.open("get", "switch_cred.php?credibility_id=" + cred_id, true);
	oXmlHttp.onreadystatechange = function () {
		if (oXmlHttp.readyState == 4) {
			if (oXmlHttp.status == 200) {
				document.getElementById(dom_id).innerHTML = oXmlHttp.responseText;
			} else {
				document.getElementById(dom_id).innerHTML = "<img src='"+baseURL+"/images/icons/error.png' />";
			}
		}            
	}
	oXmlHttp.send(null);
}



function startScrollingDetector(){setInterval("scrollingDetector()",100);}

function scrollingDetector(){
<?php if( !$is_firefox ) { ?>
	if (navigator.appName.indexOf("Microsoft")!=-1) {
		//alert ("You're at " + document.body.scrollTop + " pixels.");
		var topAmt = document.body.scrollTop + document.body.offsetHeight - 30;
		document.getElementById('chatTab').style.position="absolute";
		document.getElementById('chatTab').style.top=topAmt+"px";
		document.getElementById('chatTab').style.left="0px";
		var topAmtPanel = document.body.scrollTop + document.body.offsetHeight - 240;
		document.getElementById('chatPanel').style.position="absolute";
		document.getElementById('chatPanel').style.top=topAmtPanel+"px";
		document.getElementById('chatPanel').style.left="0px";
	}
<?php } ?>
}



</script>
<?php if( $is_ie ) { ?>
<link rel="stylesheet" type="text/css" href="css/chat_ie.css" />
<?php } else { ?>
<link rel="stylesheet" type="text/css" href="css/chat.css" />
<?php } ?>














