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

function getRatingScore($rating) { // $rating is the text value of a rating. This function is for determining group consensus. Note that C and VC count for something.
	if( $rating == "Very Inconsistent" ) { return -2; }
	if( $rating == "Inconsistent" ) { return -1.5; }
	if( $rating == "Neutral" ) { return 0; }
	if( $rating == "N/A" ) { return 0; }
	if( $rating == "Consistent" ) { return 1.5; }
	if( $rating == "Very Consistent" ) { return 2; }
	return null;
}

function getHypoRatingScore($rating) { // $rating is the text value of a rating. This function is for tabulating hypo scores. Note that C and VC have no value.
	if( $rating == "Very Inconsistent" ) { return 2; }
	if( $rating == "Inconsistent" ) { return 1; }
	if( $rating == "Neutral" ) { return 0; }
	if( $rating == "N/A" ) { return 0; }
	if( $rating == "Consistent" ) { return 0; }
	if( $rating == "Very Consistent" ) { return 0; }
	return null;
}

function getGroupRating($ratingStDev) { // Takes the standard deviation. Determines how much consensus there is among the group regarding a particular evidence-hypo pair
	if( $ratingStDev <= 0.25 ) { return 1; } // Consensus
	if( $ratingStDev <= 1.0 ) { return 2; } // Mild Disagreement
	if( $ratingStDev <= 1.74 ) { return 3; } // Strong Disagreement
	return 4; // Extreme Disagreement
}



function setStatusMessage($message) {
	setcookie("campaign_status_message", $message, time()+5, "/" );
}

function getStatusMessage() {
	return $_COOKIE['campaign_status_message'];
}



function get_tag_data() {
	$arr = Array();
	
	$result = mysql_do("SELECT tags FROM classes");
	while($query_data = mysql_fetch_array($result)) {
		$all_tags .= $query_data['tags'];
	}
	
	$tags = explode(" ", substr($all_tags, 0, -1));
	
	for( $i = 0; $i < count($tags); $i++ ) {
		$arr[$tags[$i]] += 1;
	}

    return $arr;
}

function get_tag_cloud() {
	$min_font_size = 14;
	$max_font_size = 18;
	
	$tags = get_tag_data();
	
	$minimum_count = min(array_values($tags));
	$maximum_count = max(array_values($tags));
	$spread = $maximum_count - $minimum_count;
	
	if($spread == 0) {
		$spread = 1;
	}
	
	$cloud_html = '';
	$cloud_tags = array(); // create an array to hold tag code
	foreach ($tags as $tag => $count) {
		$size = $min_font_size + ($count - $minimum_count) 
			* ($max_font_size - $min_font_size) / $spread;
		$cloud_tags[] = '<nobr><a style="font-size: '. floor($size) . 'px' 
			. '" class="tag_cloud" href="'. $base_URL . '/tag/' . $tag 
			. '" title="\'' . $tag  . '\' returned a count of ' . $count . '">' 
			. htmlspecialchars(stripslashes($tag)) . '</a> <span style="padding-right: 10px; color: #999999">&times;' . $count . '</span></nobr>';
	}
	$cloud_html = join("\n", $cloud_tags) . "\n";
	return $cloud_html;
}

function showClassification($classification_code) {
	if( $classification_code == "U" ) { return "Unclassified"; }
	if( $classification_code == "C" ) { return "Classified"; }
	if( $classification_code == "S" ) { return "Secret"; }
	if( $classification_code == "TS" ) { return "Top Secret"; }
	if( $classification_code == "Compartmented" ) { return "Compartmented"; }
	return($classification_code);
}

function showCaveat($caveat_code) {
	if( $caveat_code == "FOUO" ) { return "FOUO/AIUO"; }
	return $caveat_code;
}

function showType($type_code) {
	return $caveat_code;
}

function getStDev($numbers){ // Gets standard deviation. Takes an array called $numbers.

	if( count($numbers) <= 1 ) {
		return 0;
	} else {
	
		// Get n (total)
		$sum_n = array_sum($numbers); 
		$n = count($numbers); 
		$mean = $sum_n / $n; // avg or mean
		
		// Get x^2 
		$i = 0; 
		while(count($numbers) > $i) { 
			$x_minus_mean = $numbers[$i] - $mean; // x - Xbar
			$x2[$i] = $x_minus_mean * $x_minus_mean; // square above
			$i++; 
		} 
	
		$x2_total_sum = array_sum($x2); // sum up all x - Xbar square
		
		$x2_div_n = $x2_total_sum/($n); // divide above by number of elements
		$stdDev = sqrt($x2_div_n);  // get square root for standard deviation
		$stdDev = round($stdDev,4);
		return $stdDev; // return the standard deviation
	
	}
	
}

function cleanForDisplay($text) {
	$text = addslashes($text);
	$text = str_replace("\r", "", $text);
	$text = str_replace("\n", "", $text);
	return $text;
}

function getCellComments($evidence_id, $hypothesis_id, $thread_id) {
	$comments = Array();
	$result = mysql_do("SELECT id FROM comments WHERE hypothesis_id='$hypothesis_id' AND evidence_id='$evidence_id' AND reply_to_id='$thread_id';");
	while($query_data = mysql_fetch_array($result)) {
		$comments[] = $query_data['id'];
	}
	return $comments;
}

function showCellComments($evidence_id, $hypothesis_id, $thread_id) {
	global $base_URL;
	global $reply_depth;

	$comments = Array();
	$comments = getCellComments($evidence_id, $hypothesis_id, $thread_id);

	$to_return = FALSE;

	if( count($comments) > 0 ) {
	
		$to_return = TRUE;
	
		foreach( $comments as $comment_id ) {
			$this_comment = new Comment();
			$this_comment->populateFromId($comment_id);
			$commenter = new User();
			$commenter->populateFromId($this_comment->user_id);
			?>
		
	<div class="comment" style="margin-left: <?php echo($reply_depth*50); ?>">
	
	<p class="by"><a href="<?=$base_URL?>/profile/<?=$commenter->username?>"><?=$commenter->name?></a> <?php if( $thread_id == 0 ) { ?>writes<?php } else { ?>replies<?php } ?>:</p>
	
	<p class="comment"><?=nl2br($this_comment->comment)?></p>
	
	<p class="time"><b>Time:</b> <?=$this_comment->created?></p>
	
	<p class="classification"><b>Classification:</b> <?=$this_comment->classification?></p>
	
	<p class="caveat"><b>Caveat:</b> <?=$this_comment->caveat?></p>
	
	
	
	<?php $reply_id = rand(0, 10000000000); ?>
	
	<p class="replyTo"><a style="cursor: pointer;" onclick="new Effect.BlindDown(reply<?=$reply_id?>);">Reply</a></p>
	
	<div class="replyToThis" id="reply<?=$reply_id?>" style="display: none;">
	
	<form method="post" class="edit" action="add_comment_action.php">

	<input type="hidden" name="this_url" value="<?=$_SERVER['REQUEST_URI']?>" />
	
	<input type="hidden" name="user_id" value="<?=$active_user->id?>" />
	
	<input type="hidden" name="evidence_id" value="<?=$evidence_id?>" />
	
	<input type="hidden" name="hypothesis_id" value="<?=$hypothesis_id?>" />
	
	<input type="hidden" name="reply_to_id" value="<?=$this_comment->id?>" />
	
	<p><textarea rows="8" name="comment" cols="60"></textarea></p>
	
	<p><b>Classification</b> <select name="classification">
		<option value="U">Unclassified</option>
		<option value="C">Confidential</option>
		<option value="S">Secret</option>
		<option value="TS">Top Secret</option>
	</select> <b style="padding-left: 15px;">Caveat</b> <select name="caveat">
		<option value="">(No caveat)</option>
		<option value="FOUO">FOUO/AIUO</option>		
		<option value="SI">SI</option>
		<option value="TK">TK</option>
		<option value="HCS">HCS</option>
		<option value="G">G</option>
	</select></p>
	
	<p class="submit"><input class="button" type="submit" value="Add Reply" /></p>
	
	</form>
	
	</div>


	
	</div>
		
		<?php
			
			$reply_depth++;
			
			showCellComments($evidence_id, $hypothesis_id, $this_comment->id);
			
			$reply_depth--;
			
		}
		
	}

	return $to_return;
	
}



function getActiveUsers($project_id) {
	$ten_minutes_ago = date('Y-m-d H:i:s', strtotime('-10 minutes'));	
	$result = mysql_fetch_array("SELECT user_id FROM users_active;");// WHERE last_visited >= $ten_minutes_ago;");
	print_r($result);
	while($query_data = mysql_fetch_array($result)) {
		$this_strlen = 8 + strlen($project_id);
		if( substr($query_data['last_page'], 0, $this_strlen) == "/project/".$project_id ) {
			$active_users[] = $query_data['user_id'];
		}
	}
	return $active_users;
}



function showChat($project_id) {
	global $base_URL;
	$messages = false;
	$result = mysql_do("SELECT * FROM chat_log WHERE project_id='$project_id' ORDER BY created DESC LIMIT 50;");
	while($query_data = mysql_fetch_array($result)) {
		$messages = true;
		$this_user = new User();
		$this_user->populateFromId($query_data['user_id']);
		$result_2 = mysql_do("SELECT * FROM users_active WHERE user_id='$this_user->id' LIMIT 1;");
		while($query_data_2 = mysql_fetch_array($result_2)) {
			echo('<p><span class="date">' . $query_data['created'] . '</span> <span class="name"><a href="'. $base_URL . '/profile/' . $this_user->username . '" style="color: #' . $query_data_2['color'] . ';">' . $this_user->name . '</a></span>: <span class="message">' . $query_data['chat'] . '</span></p>');
		}
	}
	if( !$messages ) {
		echo('<p><span class="none">No chat messages yet.</span></p>');
	}
}

function average($array){
  return array_sum($array)/count($array) ;
}



function utf16_to_utf8($str) {
    $c0 = ord($str[0]);
    $c1 = ord($str[1]);

    if ($c0 == 0xFE && $c1 == 0xFF) {
        $be = true;
    } else if ($c0 == 0xFF && $c1 == 0xFE) {
        $be = false;
    } else {
        return $str;
    }

    $str = substr($str, 2);
    $len = strlen($str);
    $dec = '';
    for ($i = 0; $i < $len; $i += 2) {
        $c = ($be) ? ord($str[$i]) << 8 | ord($str[$i + 1]) : 
                ord($str[$i + 1]) << 8 | ord($str[$i]);
        if ($c >= 0x0001 && $c <= 0x007F) {
            $dec .= chr($c);
        } else if ($c > 0x07FF) {
            $dec .= chr(0xE0 | (($c >> 12) & 0x0F));
            $dec .= chr(0x80 | (($c >>  6) & 0x3F));
            $dec .= chr(0x80 | (($c >>  0) & 0x3F));
        } else {
            $dec .= chr(0xC0 | (($c >>  6) & 0x1F));
            $dec .= chr(0x80 | (($c >>  0) & 0x3F));
        }
    }
    return $dec;
}



function sendMail($to, $subject, $message, $headers) {
	global $email_domain;
	$headers = 'From: ACH System <noreply@' . $email_domain . ">\r\n" . 'Reply-To: noreply@' . $email_domain;	
	mail($to, $subject, $message, $headers);

}

function helpLink($helpSubject) {
	global $base_URL;
	echo "<a href='" . $base_URL . "/help/$helpSubject' onClick=\"window.open('" . $base_URL . "/help/" . $helpSubject . "', 'Help', 'toolbar=yes,directories=no,location=no,status=yes,menubar=no,resizable=yes,scrollbars=yes,width=1000,height=500');  return false\"><img src=\"images/icons/help_red.png\" width=\"16\" height=\"16\" border=\"0\" alt='Help' /></a>";
	
}

function helpTextLink($helpSubject, $linktext) {
	global $base_URL;
	echo "<a href='" . $base_URL . "/help/$helpSubject' onClick=\"window.open('" . $base_URL . "/help/" . $helpSubject . "', 'Help', 'toolbar=yes,directories=no,location=no,status=yes,menubar=no,resizable=yes,scrollbars=yes,width=1000,height=500'); return false\">" . $linktext . "</a>";
	
}

function condenseComment($text) {
	
	$num_words_to_show = 10;
	
	$words = explode(" ", $text);
	
	if( count($words) > $num_words_to_show ) {
		$is_long = true;
		$comment = "";
		for( $i = 0; $i < $num_words_to_show; $i++ ) {
			$comment .= $words[$i] . " ";
		}
		$comment .= " <small>[...]</small>";
	} else {
		$comment = $text;
	}
	
	return $comment;

}

?>