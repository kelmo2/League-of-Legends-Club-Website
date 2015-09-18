<!-- Login section - Needs indents and comments
================================================== -->
<div class="container">

	<div class="row col-sm-10 col-sm-offset-1 text-center">
		<?php
			echo "</br>";
				if ($login_user->errors['email'] != "") {
		?>
		   
		    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> <?php echo htmlspecialchars($login_user->errors['email']); ?>
            </div>
		<?php }?>
		<div class="row">
			<div class="page-header text-center">
				<h1>Welcome!</h1>
				<span ><a href="signUp.php">Register</a></span>
				<span > | <a href="forgotPassword">Forgot Password </a></span>
			</div>
			<form method="POST" action="loginCtrl">
				<div class="form-group">
					<input  type="email" class="form-control input-lg" id="email" name="email" placeholder="Email">
				</div>
				<div class="form-group">
					<input type="password" class="form-control input-lg" name="pw" placeholder="Password">
				</div>
				
				<div class="form-group">
					<button class="btn btn-success btn-lg btn-block">Sign In</button>
				</div>
				
			</form>

			<div class="form-group">
				<button id="les" class="btn btn-info btn-md btn-block" data-toggle="modal" data-target=".les-modal">Click to read the Lore for <?php echo nl2br($val['name']); ?></button>
			</div>
            <div class="modal fade les-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-body les modal-content">
			<div class=" center-text modal-header">
				<h4><?php echo nl2br($val['name']." ".$val['title']); ?></h4>
				<?php
					foreach ($val['tags'] as $tag) {		
				?> 
				</h4>
				<span class="label label-default"><?php echo htmlspecialchars($tag); ?></span>
				<?php } ?>
			</div>
                        <p><?php echo nl2br($val['lore']); ?></p>
                
			 <div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		    </div>
		</div>
            </div>
 


			<div class="text-center">
				<img class="img-responsive center-block loading" src="<?php echo htmlspecialchars($path); ?>"/>
			</div>
			</br>
		</div>
	</div>
</div>
