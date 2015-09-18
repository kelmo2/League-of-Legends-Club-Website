<!-- Page Content -->
<div class="container">
	<div class="col-md-offset-2 col-md-8">
				
	<div class="text-center"><h1>Contact Us</h1></div>
		<hr>
		<?php
			foreach ($errors as $error) {
				if ($error != "") {
		?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Error!</strong> <?php echo htmlspecialchars($error); ?>
			</div>
		<?php } }
			if (isset($result)) {
				if ($result) {	
		 ?>	
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Success!</strong> <?php echo "Email sent, we will be in contact"; ?>
			</div>
		<?php }
			else {
		?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Error!</strong> <?php echo "Failed to send email"; ?>
			</div>
		<?php }} ?>
			<form class="form-horizontal" role="form" method="post" action="contact.php">
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="message" class="col-sm-2 control-label">Message</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="4" name="message"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="antispam" class="col-sm-2 control-label">5+2?</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="antispam" name="antispam" placeholder="Your answer" value="">
				  	</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">	
						<button class="btn btn-primary">Send</button>
					</div>
				</div>

			</form>
	</div>
</div>
