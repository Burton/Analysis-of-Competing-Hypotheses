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



/**
* 
* Pretty much just the link to the competinghypotheses.org and the About page.
* There's a section in here for a special footer for the printable version.
* For diagnostics, you can add load times to the bottom of the page by uncommenting from line 39 
*/

?>



<div class="footer">



<?php if( $print_mode ) { ?>

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

<p>Powered by <a href="http://competinghypotheses.org">The Open Source ACH Project</a> | <a href="http://competinghypotheses.org/reportABug">Report a bug</a> | <a href="/help/about.php">About this instance</a></p>

<!-- UNCOMMENT THE REMAINDER OF THE FILE IF YOU WANT LOADING TIMES AND STATS TO APPEAR AT THE BOTTOM OF THE PAGE
<?php 
/*

// Load times DO NOT take into account the chat window at the moment.

$LOAD_TIMER_STOP = microtime(TRUE);

$LOAD_TIME = $LOAD_TIMER_STOP-$LOAD_TIMER_START;

$flag = $SQL_CACHING_ACTIVE ? "ACTIVE SQL CACHING" : "INACTIVE SQL CACHING";

$this_uri = $_SERVER['REQUEST_URI'];
mysql_do("INSERT INTO load_times (url, load_time, queries, flag, user_id) VALUES ('$this_uri', '$LOAD_TIME', '$DB_QUERIES', '$flag', '$active_user->id');");

if( $SPEED_REPORTING ) { */
?>

<div style="color: #999999;">

<p>(<?=round($LOAD_TIME, 3)?> seconds to load.)</p>

<p>(<?=$DB_QUERIES-1?> database queries, <?=$SQL_DUPES?> dupes, <?=$SQL_SELECTS?> selects)</p>

</div>

</div>

<?php // }

//sort($SQL_STATEMENTS_ALL);
//sort($SQL_STATEMENTS_CACHE);

//print_r($SQL_STATEMENTS_ALL);

//echo("<hr />");

//print_r($SQL_STATEMENTS_CACHE)

?>
-->