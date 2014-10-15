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



$SQL_CACHING_ACTIVE = TRUE; // Set this to FALSE to turn off SQL caching.
$SPEED_REPORTING = TRUE; // Set this to FALSE to turn off the speed display at the bottom of the pages.



$DB_QUERIES = 0; // Total number of times the database is accessed.

$SQL_STATEMENTS_ALL = array();
$SQL_STATEMENTS_CACHE = array();
$SQL_CACHE = array();
$SQL_DUPES = 0;
$SQL_SELECTS = 0;

$dbhost = 'localhost';
$dbusername = 'root';
$dbuserpassword = '';
$default_dbname = 'ach';
$MYSQL_ERRNO = '';

function db_connect() {
	global $dbhost, $dbusername, $dbuserpassword, $default_dbname;
	global $MYSQL_ERRNO, $MYSQL_ERROR;
	global $DB_QUERIES;
	
	$DB_QUERIES++;
	
	$link_id = mysql_connect($dbhost, $dbusername, $dbuserpassword);
	if(!$link_id) {
		$MYSQL_ERRNO = 0;
		$MYSQL_ERROR = "Connection failed to the host $dbhost.";
		return 0;
	}
	else if(empty($dbname) && !mysql_select_db($default_dbname)) {
		// MYSQL_ERRNO = mysql_errno();
		// MYSQL_ERROR = mysql_error();
		return 0;
	}
	else return $link_id;
}

function sql_error() {
	global $MYSQL_ERRNO, $MYSQL_ERROR;
	
	if(empty($MYSQL_ERROR)) {
		$MYSQL_ERRNO = mysql_errno();
		$MYSQL_ERROR = mysql_error();
	}
	return "$MYSQL_ERRNO: $MYSQL_ERROR";
}

function mysql_do($sql) {
	global $SQL_SELECTS, $SQL_STATEMENTS_ALL;
	
	$SQL_STATEMENTS_ALL[] = $sql;

	if( strtolower(substr($sql, 0, 6)) == "select" ) {
		$SQL_SELECTS++;
	}

	$link_id = db_connect();
	$result = mysql_query($sql, $link_id);
	
	//if( strpos($sql, "hypotheses") > 0 ) {
		//echo($sql . "<br />\r\n");
	//}

	return $result;
}

function mysql_fast($sql) { // Cached SQL statements, DOESN'T RESULT RESULT RESOURCE, RETURNS $query_data ARRAY. FOR NOW, limit to QUERIES WITH ONE RESULT.
	global $SQL_CACHING_ACTIVE, $SQL_STATEMENTS_CACHE, $SQL_DUPES, $SQL_CACHE;

	$results = array();

	if( $SQL_CACHING_ACTIVE && strtolower(substr($sql, 0, 6)) == "select" ) {
		if( in_array($sql, $SQL_STATEMENTS_CACHE) ) {
			$SQL_DUPES++;
			$results = $SQL_CACHE[$sql];
		} else {
			$result = mysql_do($sql);
			while( $query_data = mysql_fetch_array($result) ) {
				$results[] = $query_data;
			}
			$SQL_CACHE[$sql] = $results;
			$SQL_STATEMENTS_CACHE[] = $sql;
		}
	} else {
		$result = mysql_do($sql);
		while( $query_data = mysql_fetch_array($result) ) {
			$results[] = $query_data;
		}
	}
	
	//echo("<i>" . $sql . "</i><br />");
		
	return $results;
}

function getFieldList($table) { //updated for PHP5.3, contributed by Chris Snow of ISW Corp

        $fldlist = mysql_query("SHOW COLUMNS FROM ".$table);

        $colCount = mysql_num_rows($fldlist);

 

        for ($i = 0; $i < $colCount; $i++) {

            $fieldNames = mysql_fetch_row($fldlist);

            $listing[] = $fieldNames[0];

        }

        return($listing);

}

?>
