


$(document).ready(function(){

	showComments();

	//on submit
	$('#commentForm').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			//Gör allt som står i comments.php
			url: "comment-system/comments.php",
			method: "POST",
			cache: false,
			data: $(this).serialize(),
			dataType: "JSON",
			success:function(response) {
					$('#commentForm')[0].reset();
					$('#commentId').val('0');
					showComments();
			}
		})
	});
});
function showComments()	{
	$.ajax({
		//Gör allt som står i show_comments.php
		url:"comment-system/show_comments.php",
		cache: false,
		method:"POST",
		success:function(response) {
			$('#showComments').html(response);
		}
	})
}
