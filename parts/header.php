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



<div class="container">



<?php if( !$print_mode ) { ?>
	

<div class="header">

<p class="menu"><?php

if( $active_user->logged_in_full_account ) {

	echo('<span class="tab">Hello, <a href="' . $base_URL . '/profile/' . $active_user->username . '"> ' . $active_user->name . '</a> ');
	
	
	echo('</span> <span class="tab"><a href="' . $base_URL . '/auth/log_out.php">Logout</a></span>');
	
}

?></p>

</div>



<script type="text/javascript">
var baseURL = "<?php print $base_URL; ?>";

function forgotPassword() {
	window.open(baseURL+"auth/forgot.php","forgotBox","width=450,height=220,resizeable=no,status=yes");
}			  
</script>



<?php } else { ?>



<div class="printHeader">

<p>Page printed by <b><?=$active_user->name?></b> on <b><?=date("F j, Y, g:ia")?> (EST)</b>.</p>

</div>
<?php if ($active_project->classification == 'U') {
			$classificationBannerStyle = "unclassifiedPrintBanner"; } else
		if ($active_project->classification == 'C') {
			$classificationBannerStyle = "confidentialPrintBanner"; } else
		if ($active_project->classification == 'S') {
			$classificationBannerStyle = "secretPrintBanner"; } else
		if ($active_project->classification == 'TS') {
			$classificationBannerStyle = "topSecretPrintBanner"; }


echo "<div class=\"". $classificationBannerStyle . " projectClassificationPrintBanner\">";?>

<p>Overall Project Classification: <b><?=Project::classificationText($active_project->classification)?></b></p>

</div>



<?php } ?>