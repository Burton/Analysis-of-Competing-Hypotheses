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

if( in_array($active_user->id, $active_project->users) ) { ?>


<div class="chatBigWrapper">



<p class="chatTab" id="chatTab" onclick="document.getElementById('chatPanel').style.display='block'; createCookie('cachchat', 'y', 7); chatActive = 'y'; reloadConversation();"><a href="javascript:void(0);">Chat</a></p>

<div class="chatWrapper" id="chatWrapper">
<div class="chatPanel" id="chatPanel" style="bottom: 0px; display: none;" <?php if( $_COOKIE['cachchat'] == "n" ) { echo('style="display: none;"'); } ?> >

<div class="chatShadow"> </div>

<div class="chatMain">

<p class="chatClose" onclick="document.getElementById('chatPanel').style.display='none'; createCookie('cachchat', 'n', 7); chatActive = 'n';"><a href="javascript:void(0);">Close</a></p>

<!--<p class="chatPopOut" style="border: #9FB3ED 2px solid; width: 4em; padding: 2px; margin: 0px; position: relative; top: 4px; left: 2px; text-align: center;"><a style="color: #7492EF; font-size: 10px;" href="/project/<?=$active_project->id?>/chat" onClick="window.open('/project/<?=$active_project->id?>/chat', 'Chat', 'toolbar=yes,directories=no,location=no,status=yes,menubar=no,resizable=yes,scrollbars=yes,width=1000,height=500'); return false">Pop out</a></p>-->


<div class="sendMessage">

<input class="text" type="text" size="60" id="message" onkeydown="return getReturn(event)" /> <input type="submit" value="Say it now &raquo;" onclick="insertMessage();" /> <span id="wheel" class="wheel"></span>

</div>



<div id="messages" class="chatMessages">

<?php showChat($active_project->id); ?>

</div>



<!-- <div class="currentUsers">

<p class="title"><b>Users currently viewing this project:</b></p>

<div id="activeUsers"> 

<?php /*

$page = 'http://cach.matthewburton.org/show_active_users.php?project_id=' . $active_project->id;

//echo($page);
include($page);

$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, $page);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);

// display file
echo $file_contents;
*/
?>

</div>

</div>
-->
</div>

</div>
</div>



</div>



<?php } ?>