<div class="container">
	<div class="text-center page-header"><h1 ><i class="fa fa-users"></i> Member List</h1></div>
	
	<div class="members table-responsive">
		<table class="table">
			<tr class="row" id = "tableHeader">
				<th><a href="memberlist?sort=champion&way=<?php echo $direction ?>">Champion <span class="fa fa-caret-down"></span></a></th>
				<th><a href="memberlist?sort=first_name&way=<?php echo $direction ?>">Name  <span class="fa fa-caret-down"></span></a></th>
				<th><a href="memberlist?sort=hours&way=<?php echo $direction ?>">Hours <span class="fa fa-caret-down"></span></a></th>
				<th><a href="memberlist?sort=username&way=<?php echo $direction ?>">Summoner Name  <span class="fa fa-caret-down"></span></a></th>
				<th><a href="memberlist?sort=rank&way=<?php echo $direction ?>">Rank  <span class="fa fa-caret-down"></span></a></th>
				<th><a href="memberlist?sort=lane&way=<?php echo $direction ?>">Lane  <span class="fa fa-caret-down"></span></a></th>
			</tr>
				<?php
					foreach ($list as $guy) {
				?>
				<!--Start of table row-->
				<tr class="row" id = "streamRow2">

					<td><!--Start of icon for champion-->
						<?php
							/*****************************
							Need to cache the images for improved performance, can't completely
							rely on Riot's server for everything
							*****************************/

							//The path needed for the champion's image (locally)
							$path = "img/icons/".$guy->champion.".png";
								
							//The path needed for the free week champion's image (remotely)
							$url = "http://ddragon.leagueoflegends.com/cdn/5.14.1/img/champion/".$guy->champion.".png";
							//If the file isn't on our server, download it
							if (!file_exists($path)) {
								file_put_contents($path, file_get_contents($url));
							}
							if ($guy->admin == 0) {
								$class ="img-thumbnail mobilePics";
								$style = "";
							}
							else if ($guy->admin == 1) {
								$class = "img-thumbnail mobilePics paid";
								$banned = false;
								$style = "<i class=\"fa fa-star\" style=\"color:gold\"></i></i>";
							}
							else if ($guy->admin == 3) {
								$class = "img-thumbnail mobilePics";
								$banned = true;
								$style = "";
							}
							else {
								$class = "img-thumbnail mobilePics admin";
								$banned = false;
								$style = "<i class=\"fa fa-star\" style=\"color:red\"></i>";
							}
							if (!$banned) {
						?>
						<a href="<?php echo htmlspecialchars("user?user=".$guy->id); ?>"><img class="<?php echo htmlspecialchars($class); ?>" src="<?php echo htmlspecialchars($path); ?>"/></a>
					</td><!--End of icon for champion-->

					<td><!--Start of name-->
						<a href="<?php echo htmlspecialchars("user?user=".$guy->id); ?>"><?php echo $style.htmlspecialchars(" ".$guy->first_name." ".$guy->last_name) ?></a>
					</td><!--End of name-->

					<td><!--Start of hours-->
						<?php echo htmlspecialchars($guy->hours) ?>
					</td><!--End of hours-->

					<td><!--Start of Summoner Name-->
						<?php
							/*****************************
							This field was optional so we need to check for it first.
							*****************************/
							$username = htmlspecialchars("");
							if ($guy->username != "") {
								$username = $guy->username;
							}
							echo htmlspecialchars($username);
						?>
					</td><!--End of Summoner Name-->

					<td><!--Start of Rank-->
						<?php
							/*****************************
							This field was optional so we need to check for it first.
							*****************************/
							$username = "8";
							if ($guy->rank != "8") {
								$username = $guy->rank;
							}
							echo htmlspecialchars(substr($username,1));
						?>
					</td><!--End of rank-->

					<td><!--Start of lane-->
						<?php echo htmlspecialchars($guy->lane); ?>
					</td><!--End of lane-->
				</tr><!--End of table row-->
				<?php } } ?>
	</table>
</div>
</div>
