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
<h3>Compare User Matrices</h3>

<?php

$compare_user = new User();
$compare_user->populateFromId($_REQUEST['compare_user_id']);

$compare_user_2 = new User();

if( $_REQUEST['compare_user_id_2'] ) {
	$compare_user_2->populateFromId($_REQUEST['compare_user_id_2']);
	?>
	<p>Comparing the ratings of <b><?=$compare_user->name?></b> with <b><?=$compare_user_2->name?></b>.</p>
	<?php
} else {
	$compare_user_2->populateFromId($active_user->id);
	?>
	<p>Comparing your ratings with <b><?=$compare_user->name?></b>.</p>
	<?php
}

?>


<p><img src="<?=$base_URL?>images/consensusgauge.gif"></p>



<?php

$sort_field_1 = "name";
$sort_field_1_dir = "asc";
$sort_field_2 = "created";
$sort_field_2_dir = "asc";
	
?>



<div class="groupMatrix">



<div id="ajaxTableGroup"><?php include_once("print_table.php"); ?></div>



</div>