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

<?php if( !$print_mode ) { ?>



<div class="menu mainMenu">

<p><a href="<?=$base_URL?>/"><img src="<?=$base_URL?>/images/icons/house.png" width="16" height="16" border="0" />Home</a></p>

<p><a href="<?=$base_URL?>/recent/"><img src="<?=$base_URL?>/images/icons/calendar.png" width="16" height="16" border="0" />Recent Activity</a></p>

<!-- <p><a href="<?=$base_URL?>/profile/<?=$active_user->username?>"><img src="<?=$base_URL?>/images/icons/user_red.png" width="16" height="16" border="0" />My Profile</a></p> -->

<p><a href="<?=$base_URL?>/project/new"><img src="<?=$base_URL?>/images/icons/page_add.png" width="16" height="16" border="0" />Create New Project</a></p>

<p><a href="<?=$base_URL?>/projects/"><img src="<?=$base_URL?>/images/icons/page_copy.png" width="16" height="16" border="0" />Browse Public Projects</a></p>

<!--<p><a href="search/"><img src="images/icons/magnifier.png" width="16" height="16" border="0" />Search</a></p>-->

<p><a href="<?=$base_URL?>/help/"><img src="<?=$base_URL?>/images/icons/help_red.png" width="16" height="16" border="0" />Help</a></p>

</div>

<!--<p style="margin-left: 50px; color: #999999; font-size: 11px;"><i><b style="color: #FF6666;">NOTE</b>: We are still adding features and debugging this application. Expect errors.</i></p>-->

<?php } ?>