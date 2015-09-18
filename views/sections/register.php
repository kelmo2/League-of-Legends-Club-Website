<!-- Registration section 
================================================== -->
<div class="container">
	<div class="row col-sm-10 col-sm-offset-1">
		<div class="row">      
			<?php
				echo "</br>";
				//Show all the errors that were generated after submitting the form
				foreach ($signup_user->errors as $error) {
					if ($error != "") {
			?>
		   	<!--Error message-->
			<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong> <?php echo htmlspecialchars($error); ?>
			</div><!--End of error message-->

			<?php } }?>
			
			<!--Header for the registration form-->
			<div class="page-header text-center">
				<h1>Register an account</h1>
				<p>Required fields marked with *</p>
			</div><!--End of the header-->

			<!--Form for submitting the registration info-->
			<form method="POST" action="signUp">
				<!--Input for email-->
				<div class="form-group">
					<input type="email" maxlength="45" class="form-control input-lg" name="email" value="" placeholder="*Email">
				</div>
				<!--Input for first name-->
				<div class="form-group">
					<input type="text" maxlength="20" class="form-control input-lg" name="first_name" value="" placeholder="*First Name">
				</div>
				<!--Input for Last name-->
				<div class="form-group">
					<input type="text" maxlength="20" class="form-control input-lg" name="last_name" value="" placeholder="*Last Name">
				</div>
				<!--Input for password-->
				<div class="form-group">
					<input type="password" maxlength="20" class="form-control input-lg" name="password" placeholder="*Password (Must contain at least 8 characters, 1 lowercase letter and 1 uppcase letter)">
					<input type="password" maxlength="20" class="form-control input-lg" name="password2" placeholder="*Retype Password">
				</div>
				<!--Input for favorite champion-->
				<div class="form-group">
					<select class="input-lg form-control" name="champion">
						<option disabled="true" selected="true">*Select your favorite champion</option>
							<?php
							//Print the sorted champions names in a dropdown list and give their keys as values
							foreach ($champObj->championList as $champ) {
						?>
								<option value="<?php echo htmlspecialchars($champ['key']); ?>"> <?php echo htmlspecialchars($champ['name']); ?> </option>
							<?php } ?>
						</select><!-- End select dropdown -->					
				</div><!--End of input for favorite champion-->
				<!--Selector for favorite lane-->
				<div class="form-group">
					<select class="input-lg form-control" name="lane">
						<option disabled="true" selected="true">*Select your favorite lane</option>
						<option value="Top">Top</option>
						<option value="Jungle">Jungle</option>
						<option value="Mid">Mid</option>
						<option value="ADC">ADC</option>
						<option value="Support">Support</option>
					</select>
				</div>
				<!--Input for summoner name (optional)-->
				<div class="form-group">
					<input type="text" maxlength="30" class="form-control input-lg" name="username" value="" placeholder="Summoner Name">
				</div>
				<!--Input for twitch name (option)-->
				<div class="form-group">
					<input type="text" maxlength="30" class="form-control input-lg" name="twitch" value="" placeholder="Twitch Name">
				</div>
				<!--Input for major (optional)-->
				<div class="form-group">
					<select class="input-lg form-control" name="major">
							<option disabled="true" selected="true">Select College</option>
							<option value="Medicine">Medicine</option>
							<option value="Health Affairs">Health Affairs</option>
							<option value="Sciences">Sciences</option>
							<option value="Liberal Arts">Liberal Arts</option>
							<option value="Fine Arts">Fine Arts</option>
							<option value="Engineering and Computer Science">Engineering and Computer Science</option>
							<option value="Business and Entrepreneurship">Business and Entrepreneurship</option>
							<option value="Education and P-16 Integration">Education and P-16 Integration</option>
							<option value="Honors College">Honors College</option>
							<option value="Graduate College">Graduate College</option>
							<option value="University College">University College</option>
					</select>
				</div><!--End of div for major-->
				<h6 class="text-center">disclaimer: Name and summoner name will be public on the member list page so club members can find eachother</h6>
				<!--Button to send the form-->
				<div class="form-group">
					<button class="btn btn-primary btn-lg btn-block">Sign Up</button>
				</div>
			</form>
		</div>
	</div>
</div>
