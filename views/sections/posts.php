
<div class="container">
	<!--Contains all the posts for the front page-->
	<div class="col-sm-8">
		<?php
				if (isset($user)) {
					if ($user->admin ==2) {

		?>

		<form class="form-group" action="createPost">
		    <input class="btn btn-success btn-md btn-block" type="submit" value="Create Post">
		</form>
		<?php 
					}
				}
		?>


		<?php 

			foreach ($posts as $item) {
				$comments = $comment->getPostComments($dbh, $item->id);
				$officer = $guy->findUser($dbh, $item->userid);
				/*****************************
				Need to cache the images for improved performance, can't completely
				rely on Riot's server for everything
				*****************************/

				//The path needed for the champion's image (locally)
				$path = "img/icons/".$officer->champion.".png";
					
				//The path needed for the free week champion's image (remotely)
				$url = "http://ddragon.leagueoflegends.com/cdn/5.14.1/img/champion/".$officer->champion.".png";
				//If the file isn't on our server, download it
				if (!file_exists($path)) {
					file_put_contents($path, file_get_contents($url));
				}
		?>

		<div class="panel panel-primary">
		 <div class="panel-heading text-center">
		  	<h4 class="media-heading"><?php echo htmlspecialchars($item->title); ?></h4>
		  </div>
		  <div class="panel-body">
		<!--Div containing the post-->
		<div class="post">
			<!--Start of bootstrap media div-->
			<div class="media">
				<div class="media-left media-middle">
					<a href="post?id=<?php echo htmlspecialchars($item->id); ?>">
					<img class = "media-object img-responsive admin mobilePics" src="<?php echo htmlspecialchars($path); ?>">
					</a>
				</div>
				<div class="media-body">
					
					<p>
						<?php echo (substr($item->post, 0, 70)."..."); ?>
						<i class="icon-tags"></i>
						<a href="post?id=<?php echo htmlspecialchars($item->id); ?>">Read more...</a>
					</p>

				</div>
			</div><!--End of bootstrap media div-->

			<!--Start of information section below media div-->
			<p>
				<i class="fa fa-user"></i> <a href="user?user=<?php echo htmlspecialchars($item->userid); ?>"><?php echo htmlspecialchars($officer->first_name." ".$officer->last_name); ?></a> 
				| <i class="fa fa-calendar"></i> <?php echo htmlspecialchars($item->date); ?>
				| <i class="fa fa-comments"></i> <a href="post?id=<?php echo htmlspecialchars($item->id); ?>"><?php echo sizeof($comments); ?> Comments</a>
			</p><!--End of info section below media div-->
		</div><!--End of post div-->
		  
		  </div>
		</div>



		<?php
			}

		?>


	</div><!--End of posts div-->


	<div class="col-sm-4 hidden-xs" style="" >
		                  

	  <a class="twitter-timeline"  href="https://twitter.com/LeagueOfLegends" data-widget-id="630957273221758978">Tweets by @LeagueOfLegends</a>
            
   							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item"
								src="https://www.google.com/calendar/embed?mode=AGENDA&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=utrgv.league%40gmail.com&amp;color=%232952A3&amp;ctz=America%2FChicago"
								style=" border-width:0"
								width="100%" 
								height="400" 
								frameborder="0"
								scrolling="yes">
							</iframe>          
		</div>
          
	</div>
</div>

</br>


