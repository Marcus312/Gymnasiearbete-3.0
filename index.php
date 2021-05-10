<?php



session_start();



include("connection.php");
include("login-page/check_login.php");


$user_data = check_login($con);

date_default_timezone_set("Europe/stockholm");

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr" >
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main-page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <!--  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
  <!--  <script src='https://www.google.com/recaptcha/api.js'></script> -->

    <!--Ta bort ?ver=1-->
    <link rel="stylesheet" href="style.css?ver=1" type="text/css">
    <link rel="stylesheet" href="commentBox.css?ver=1" type="text/css">
  </head>
  <body>



  <div id="menu">
    <button id="logout-button" onclick="location.href='login-page/logout.php'">Logout</button>
    <a id="welcome-sign">Welcome <?php echo $user_data['user_name']; ?>!</a>
  </div>




<div id="bild"></div>

        <button id="btn123" onclick="showPost();">Create a post</button>


        <!--Post/reply form-->
    <form method="POST" id="commentForm" enctype="multipart/form-data" class="korv">
            <div id="commentFormheader">
            <a id="exit-button" onclick="hidePost()">⨉</a>
              </div><br>
              <!-- name input (default anonymous)-->
            <input type="text" name="name" id="name" class="korv" placeholder="Name" value="Anonymous" required maxlength="25"></input><br><br>

            <!-- Textarea-->
            <textarea name="comment" id="comment" class="korv" onkeyup="countCharacters(this);"  placeholder="Enter Comment" rows="5" required maxlength="512"></textarea><br>

            <!-- Comment Id, value 0 if it is a post and value "x" if its a reply-->
            <input type="hidden" name="commentId" id="commentId" value="0" class="korv"></input>
            <!-- Senders real username-->
            <input type="hidden" name="originalSender" id="originalSender" value="<?php echo $user_data['user_name']; ?>" class="korv"></input>

            <!-- Submit Button-->
            <input type="submit" onclick="countReset(); hidePost2();"  name="submit" id="submit" class="korv" value="Post Comment"></input><br>
            <span id="count-characters">512</span>

      </form>



    <br>
  <div id="showComments" ></div>
    </div>

    <script src="comment-system/comments.js"></script>
    <script>




    //Reply funktion
    //Ändrar texten på "commentBox" till reply saker
    $(document).on('click', '.reply', function(){
  		var commentId = $(this).attr("id");
  		// repy to the post id that you clicked on
  		$('#commentId').val(commentId);
  		//put text field in focus
  		$('#comment').focus();
  		//change placeholder name
  		$("#comment").attr("placeholder", "Reply to post id: " + commentId);
      $("#comment").val("@" + "OP" + "\n\n");
      //$("#comment").val("");
  		//Ändrar namnet på submit knappen
  		$("#submit").val("Reply to post");
  	});

    //reply 2
    //Ändrar texten på "commentBox" till reply to reply saker
    $(document).on('click', '.reply2', function(){
  		var commentId = $(this).attr("id");
  		// repy to the reply id that you clicked on
  		$('#commentId').val(commentId);
  		//put text field in focus
  		$('#comment').focus();
  		//ändras så att när man reply till en reply så blir det @123 och 2 linebreaks
      $("#comment").val("@" + commentId + "\n\n");
  		$("#comment").attr("placeholder", "Reply to reply: " + commentId);
  		//Ändrar namnet på submit knappen
  		$("#submit").val("Reply to reply");
  	});


    //Count the words from the textarea.
    function countCharacters(obj){
      document.getElementById("count-characters").innerHTML = 512 - obj.value.length;
}
    // Reset the counter when window is closed
    function countReset(){
      document.getElementById("count-characters").innerHTML = 512;
    }

    $("#btn123").click(function(){
      // Stops the user from replying to post and instead creates one if reply window is already open
	     $('#commentId').val('0');
       $('#comment').focus();
       $('#comment').val("");
       $("#comment").attr("placeholder", "Write your post here...");
       $("#submit").val("Create post");
    });



    function showPost(){
      for (var element of document.getElementsByClassName("korv")){
     element.style.display="block";
  }
}

function hidePost(){
  for (var element of document.getElementsByClassName("korv")){
 element.style.display="none";
}
  $("#commentForm")[0].reset();
}

//hides the commentBox when textarea is not empty
//dålig kod
function hidePost2(){
  var x = document.getElementById("comment").value.charCodeAt(0);
  // it breaks if you type just 0 in the textarea
  if (x >= 1){
    for (var element of document.getElementsByClassName("korv")){
   element.style.display="none";
    }
  }
}


    // Source: https://www.w3schools.com/howto/howto_js_draggable.asp
    // Make the DIV element draggable
    dragElement(document.getElementById("commentForm"));

    function dragElement(elmnt) {
      var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
      if (document.getElementById(elmnt.id + "header")) {
        // if present, the header is where you move the DIV from:
        document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
      } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
      }

      function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
      }

      function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
      }

      function closeDragElement() {
        // stop moving when mouse button is released:
        document.onmouseup = null;
        document.onmousemove = null;


      }
    }

    </script>




  </body>
</html>
