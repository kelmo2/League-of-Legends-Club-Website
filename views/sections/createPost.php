<!-- Registration section 
================================================== -->
<div class="container">
	<div class="row col-sm-10 col-sm-offset-1">
		<div class="row">      			
			<!--Header for the registration form-->
			<div class="page-header text-center">
				<h1>Create a Post</h1>
			</div><!--End of the header-->



			<?php
				if (isset($sent)) {
					if ($sent) {
			?>
			<!--Error message-->
			<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> Post Created
			</div><!--End of error message-->
			<?php
					}
				}
			?>


			<?php
				if (isset($error)) {
					if (!$error) {
			?>
			<!--Error message-->
			<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong> Fields can't be empty
			</div><!--End of error message-->
			<?php
					}
				}
			?>


			<!--Form for submitting the registration info-->
			<form method="POST" action="createPost.php">
		
				<!--Input for email-->
				<div class="form-group">
					<input autocomplete="off" type="title" class="form-control input-lg" name="img" value="" placeholder="Enter Image URL">
				</div>

				<!--Input for email-->
				<div class="form-group">
					<input autocomplete="off" type="title" maxlength="40" class="form-control input-lg" name="title" value="" placeholder="Enter Title">
				</div>


				<div class="form-group">
                        <div class="form-group">
                                <textarea id="textbox" placeholder="Enter Post Here" class="form-control" rows="4" name="post"></textarea>
                        </div>
                </div>
				
			<!--Button to send the form-->
				<div class="form-group">
					<button class="btn btn-primary btn-lg btn-block">Create Post</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script >
$(document).delegate('#textbox', 'keydown', function(e) {
  var keyCode = e.keyCode || e.which;

  if (keyCode == 9) {
    e.preventDefault();
    var start = $(this).get(0).selectionStart;
    var end = $(this).get(0).selectionEnd;

    // set textarea value to: text before caret + tab + text after caret
    $(this).val($(this).val().substring(0, start)
                + "\t"
                + $(this).val().substring(end));

    // put caret at right position again
    $(this).get(0).selectionStart =
    $(this).get(0).selectionEnd = start + 1;
  }
});

</script>
