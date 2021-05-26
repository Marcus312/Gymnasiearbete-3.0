<?php

//error_reporting(E_ERROR);




include_once("../connection.php");


$commentQuery = "SELECT id, parent_id, comment, sender, date FROM comment WHERE parent_id = '0' ORDER BY date DESC";
$commentsResult = mysqli_query($con, $commentQuery) or die("database error:". mysqli_error($con));
$commentHTML = '';
while($comment = mysqli_fetch_assoc($commentsResult)){


	//POSTS-----------------------------------------------------------------------

	//position, style, datum, tid, post id, etc etc
	$commentHTML .= '
		<div style="border-top: 1px solid #A1998D; margin-top:39px;  background-color: white; word-wrap: break-word; min-height: 80px;"><div>
		<div style="color:black; margin-left:3px; font-family:arial; font-size: 14px;"><b style="text-transform: capitalize; font-size: 16px">'.$comment["sender"].'</b>  <a>'.$comment["date"].'</a>
	';

	// reply knapp
	$commentHTML .= '
	[<a type="button" style="color: blue; cursor:pointer;"onclick="showPost(); " class="reply" id="'.$comment["id"].'"> Reply</a> ] Post id: <a>'.$comment["id"].'</div>	';


//htmlentities för att användarna inte ska kunna skriva in html kod på hemsidan
//användar text
	$commentHTML .= '
		<div id="outputText"  style="width:50%; white-space:pre-wrap; color: black; font-family:arial; font-size:14px; margin-left:3px;">'.htmlentities($comment["comment"]).'</div> ';

	$commentHTML .= '
		</div> ';
//------------------------------------------------------------------------------



	$commentHTML .= getCommentReply($con, $comment["id"]);
}



echo $commentHTML;

function getCommentReply($con, $parentId = 0) {
	$commentHTML = '';
	$commentQuery = "SELECT id, parent_id, comment, sender, date FROM comment WHERE parent_id = '".$parentId."' ORDER BY date ASC";
	$commentsResult = mysqli_query($con, $commentQuery);
	$commentsCount = mysqli_num_rows($commentsResult);

		while($comment = mysqli_fetch_assoc($commentsResult)){



// REPLY------------------------------------------------------------------------

		// position etc etc
			$commentHTML .= '	<div style="  margin-left: 40px; margin:bottom: 4px; border-bottom: 1px solid #A1998D; border-right: 1px solid #A1998D; max-width:50%; min-width:25%; word-wrap: break-word; ">
			';
			// bakgrounds färg och höjd
			$commentHTML .= '<div style="background-color: #f2f2f2; min-height: 60px;">
			';
			// användarnamn, datum, tid, reply to reply knapp och post id
			$commentHTML .= '<div style="color:black; font-family:arial; font-size:14px; margin-left:3px;"><b style="text-transform: capitalize;
			font-family:arial; font-size:15px;">'.$comment["sender"].'</b> <a>'.$comment["date"].' [<a type="button" style="color:blue; cursor:pointer;" onclick="showPost();" class="reply2" id="'.$comment["id"].'"> Reply </a> ]
			Reply id: <a>'.$comment["id"].'</a></div>
			';
			//htmlentities för att användarna inte ska kunna skriva in html kod på hemsidan
			//användar text
			$commentHTML .= '	<div id="outputText" style=" white-space:pre-wrap; color: black; font-family: arial; font-size:14px; margin-left:3px;">'.htmlentities($comment["comment"]).'</div>
			';

			$commentHTML .= '		</div></div>
			';



//------------------------------------------------------------------------------


			$commentHTML .= getCommentReply($con, $comment["id"]);
		}

	return $commentHTML;
}

?>
