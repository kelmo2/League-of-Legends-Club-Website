<!--Post page sectional-->
<div class="container">
	<!--Left side of page containing the div including the post-->
	<div class="col-sm-8">
		</br>
		<div class="panel panel-primary">
			<div class="panel-heading text-center">
				<div class="panel panel-default">
					<div class="panel-body">
						<img class="img-responsive img-rounded center-block" src="<?php echo htmlspecialchars($page->img); ?>" alt="" />
					</div>
				</div>
				<h1 class="page-header"><?php echo htmlspecialchars($page->title); ?></h1>
			</div>
			<div class="panel-body">
				<!--Start of information section below media div-->
				<p>
					<img class = "media-object img-responsive admin mobilePics" src="<?php echo htmlspecialchars($path); ?>"> <i class="fa fa-user"></i> <a href="user?user=<?php echo htmlspecialchars($page->userid); ?>"><?php echo htmlspecialchars($officer->first_name." ".$officer->last_name); ?></a> 
					| <i class="fa fa-calendar"></i> <?php echo htmlspecialchars($page->date); ?>
					| <i class="fa fa-share"></i> <span class="fb-share-button data-href="post?id=<?php echo htmlspecialchars($page->id); ?>" 
						data-layout="button_count""></span>
				</p><!--End of info section below media div-->
				<hr style="border-color:black">
				<p>
					<?php echo nl2br(strip_tags($body)); ?>
				</p>
			</div>
		</div>
		<h1 class="page-header text-center">Comments</h1>

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
				if ($error) {
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


		<?php
			if (isset($user)) {
		?>
			<form method="POST" action="post?id=<?php echo $page->id; ?>">

				<div class="form-group">
		                <div class="form-group">
		                    <textarea placeholder="Enter Comment Here" class="form-control" rows="2" name="newPost"></textarea>
		               	</div>
		        </div>

		        <!--Button to send the form-->
				<div class="form-group">
					<button class="btn btn-primary btn-lg btn-block">Create Comment</button>
				</div>
			</form>

			<hr>

        <?php
        	}
        ?>

        <?php 
        	foreach ($comments as $comment) {

				$member = new User();
				$member = $member->findUser($dbh, $comment->userid);


				/*****************************
				Need to cache the images for improved performance, can't completely
				rely on Riot's server for everything
				*****************************/

				//The path needed for the champion's image (locally)
				$userPath = "img/icons/".$member->champion.".png";
					
				//The path needed for the free week champion's image (remotely)
				$userUrl = "http://ddragon.leagueoflegends.com/cdn/5.14.1/img/champion/".$member->champion.".png";
				//If the file isn't on our server, download it
				if (!file_exists($userPath)) {
					file_put_contents($userPath, file_get_contents($userUrl));
				}
				if ($member->admin == 0) {
					$class ="";
					$style = "";
				}
				else if ($member->admin == 1) {
					$class = "paid";
					$style = "<i class=\"fa fa-star\" style=\"color:gold\"></i></i>";
				}
				else {
					$class = "admin";
					$style = "<i class=\"fa fa-star\" style=\"color:red\"></i>";
				}



   		?>
			<div class="panel panel-primary">

					<div class="panel-heading">
						<!--Start of information section below media div-->
						<p>
							<a href="user?user=<?php echo htmlspecialchars($comment->userid); ?>"><img class = "<?php echo htmlspecialchars($class); ?> media-object img-responsive mobilePics" src="<?php echo htmlspecialchars($userPath); ?>"></a> <i class="fa fa-user"></i> <a href="user?user=<?php echo htmlspecialchars($comment->userid); ?>"><?php echo $style; echo htmlspecialchars($member->first_name." ".$member->last_name); ?></a> 
							| <i class="fa fa-calendar"></i> <?php echo htmlspecialchars($comment->date); ?>
							<?php
								if (isset($user))
									if ($user->admin == 2 || $user->id == $comment->userid) {
							?>
							| <a style="color: red;" href="deleteComment?commentid=<?php echo $comment->id; ?>&postid=<?php echo $_GET['id']?>">Delete</a>
							<?php
								}
							?>					
						</p><!--End of info section below media div-->
					</div>
				<div class="panel-body">
					<!--Div containing the post-->
					<div class="post">
						<!--Start of bootstrap media div-->

					</div><!--End of bootstrap media div-->
					<p>
						<?php echo htmlspecialchars($comment->post); ?>
					</p>
				</div><!--End of post div-->
			  
			</div>
		<?php
			}
		?>



	</div><!--End of left div section-->

	<!--Right side of the page containing the side bar-->
	<div class="col-sm-4 hidden-xs" style="" >
		</br>
		<?php
			if (isset($user)) {
				if ($user->admin ==2) {

		?>

		<h1>
			<a href="editPost?id=<?php echo $page->id; ?>" class="btn btn-info btn-md pull-left" type="submit" value="Edit Post">Edit Post</a>
			<a href="deletePost?id=<?php echo $page->id; ?>" class="btn btn-danger btn-md pull-right" type="submit" value="Delete Post">Delete Post</a>
		</h1>

		<?php 
					}
				}
		?>
            <a class="twitter-timeline"  href="https://twitter.com/LeagueOfLegends" data-widget-id="630957273221758978">Tweets by @LeagueOfLegends</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          
	</div><!--End of the right side of the page that contained the sidebar content-->
</div><!--End of post page sectional-->



