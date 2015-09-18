<!-- Registration section 
================================================== -->
<div class="container">
	<div class="row col-sm-10 col-sm-offset-1">
		<div class="row">      			
			<!--Header for the registration form-->
			<div class="page-header text-center">
				<h1>User Dashboard</h1>
			</div><!--End of the header-->



			<?php
				if (isset($sent)) {
					if ($sent) {
			?>
			<!--Error message-->
			<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Success!</strong> Update sent
			</div><!--End of error message-->
			<?php
					}
				}
			?>


			<?php
				if (isset($twitchErr)) {
					if ($twitchErr) {
			?>
			<!--Error message-->
			<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong> Twitch account doesn't exist, didn't change twitch
			</div><!--End of error message-->
			<?php
					}
				}
			?>

			<?php
				if (isset($summonerErr)) {
					if ($summonerErr) {
			?>
			<!--Error message-->
			<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong> Summoner name doesn't exist, didn't change summoner
			</div><!--End of error message-->
			<?php
					}
				}
			?>

			<?php
				if (isset($passwordErr)) {
					if ($passwordErr) {
			?>
			<!--Error message-->
			<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Error!</strong> Passwords don't match, didn't change password
			</div><!--End of error message-->
			<?php
					}
				}
			?>


			<!--Form for submitting the registration info-->
			<form method="POST" action="dashboard">
				
				<div class="form-group">
                                        <div class="form-group">
                                                <textarea placeholder="Enter Bio Here" class="form-control" maxlength="200" rows="4" name="bio"></textarea>
                                        </div>
                                </div>


				<!--Input for password-->
				<div class="form-group">
					<input type="password" maxlength="20" class="form-control input-lg" name="password" placeholder="Change Password">
					<input type="password" maxlength="20" class="form-control input-lg" name="password2" placeholder="Retype Password">
				</div>
				<!--Input for favorite champion-->
				<div class="form-group">
					<select class="input-lg form-control" name="champion">
						<option disabled="true" selected="true">Change champion</option>
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
						<option disabled="true" selected="true">Change lane</option>
						<option value="Top">Top</option>
						<option value="Jungle">Jungle</option>
						<option value="Mid">Mid</option>
						<option value="ADC">ADC</option>
						<option value="Support">Support</option>
					</select>
				</div>
				<!--Input for summoner name (optional)-->
				<div class="form-group">
					<input type="text" maxlength="30" class="form-control input-lg" name="username" value="" placeholder="Change Summoner Name">
				</div>
				<!--Input for twitch name (option)-->
				<div class="form-group">
					<input type="text" maxlength="30" class="form-control input-lg" name="twitch" value="" placeholder="Change Twitch Name">
				</div>
				<!--Input for major (optional)-->
				<div class="form-group">
					<select class="input-lg form-control" name="major">
							<option disabled="true" selected="true">Change college</option>
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

				<!--Button to send the form-->
				<div class="form-group">
					<button class="btn btn-primary btn-lg btn-block">Change Values</button>
				</div>
			</form>
		</div>
	</div>
</div>
