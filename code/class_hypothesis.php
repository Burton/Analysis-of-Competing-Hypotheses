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



class Hypothesis extends FrameworkDatabase {



	public $database_table_name = "hypotheses"; // This is the table that this class interacts with.
	public $insert_fields_to_ignore = array("created"); // These are tables fields that will be IGNORED when inserts happen.
	
	
	
	public function getComments($thread_id) {
		$this->comments = Array();
		$result = mysql_do("SELECT id FROM comments WHERE hypothesis_id='$this->id' AND evidence_id='0' AND reply_to_id='$thread_id';");
		while($query_data = mysql_fetch_array($result)) {
			$this->comments[] = $query_data['id'];
		}
		return true;
	}
	
	public function showComments($thread_id) {
		global $reply_depth;
	
		$this->comments = Array();
		$this->getComments($thread_id);

		$to_return = FALSE;

		if( count($this->comments) > 0 ) {
		
			$to_return = TRUE;
		
			foreach( $this->comments as $comment_id ) {
				$this_comment = new Comment();
				$this_comment->populateFromId($comment_id);
				$commenter = new User();
				$commenter->populateFromId($this_comment->user_id);
				?>
			
		<div class="comment" style="margin-left: <?php echo($reply_depth*50); ?>">
		
		<a name="comment_<?=$this_comment->id?>" />
		
		<p class="by"><a href="<?=$base_URL?>profile/<?=$commenter->username?>"><?=$commenter->name?></a> <?php if( $thread_id == 0 ) { ?>writes<?php } else { ?>replies<?php } ?>:</p>
		
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
		
		<input type="hidden" name="evidence_id" value="0" />
		
		<input type="hidden" name="hypothesis_id" value="<?=$this->id?>" />
		
		<input type="hidden" name="project_id" value="<?=$this->project_id?>" />
		
		<input type="hidden" name="reply_to_id" value="<?=$this_comment->id?>" />
		
		<p><textarea rows="8" name="comment" cols="60"></textarea></p>
		
		<p><b>Classification</b> <select name="classification">
			<option value="U">Unclassified</option>
			<option value="C">Confidential</option>
			<option value="S">Secret</option>
			<option value="TS">Top Secret</option>
		</select> <b style="padding-left: 15px;">Caveat</b> <select name="caveat">
			<option value="FOUO/AIUO">FOUO/AIUO</option>
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
				
				$this->showComments($this_comment->id);
				
				$reply_depth--;
				
			}
			
		}

		return $to_return;
		
	}
	
	

}



?>