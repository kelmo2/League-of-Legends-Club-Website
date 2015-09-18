
<?php
	/*****************************
	Need to cache the images for improved performance, can't completely
	rely on Riot's server for everything
	*****************************/



	//The path needed for the free week champion's image (locally)
	$path2 = "img/load/".$guy->champion."_0.jpg";
	//The path needed for the free week champion's image (remotely)
	$url2 = "http://ddragon.leagueoflegends.com/cdn/img/champion/loading/".$guy->champion."_0.jpg";
	//If the file isn't on our server, download it
	if (!file_exists($path2)) {
		file_put_contents($path2, file_get_contents($url2));
	}

	//The path needed for the champion's image (locally)
	$path = "img/icons/".$guy->champion.".png";
		
	//The path needed for the free week champion's image (remotely)
	$url = "http://ddragon.leagueoflegends.com/cdn/5.14.1/img/champion/".$guy->champion.".png";
	//If the file isn't on our server, download it
	if (!file_exists($path)) {
		file_put_contents($path, file_get_contents($url));
	}

	if ($guy->admin == 0) {
		$class ="";
		$style = "";
		$level = "Unpaid dues";
	}
	else if ($guy->admin == 1) {
		$class = "paid";
		$style = "<i class=\"fa fa-star\" style=\"color:gold\"></i></i>";
		$level = "Paid dues";
	}
	else if ($guy->admin == 3) {
		$class = "banned";
		$style = "";
		$level = "Banned";
	}
	else {
		$class = "admin";
		$style = "<i class=\"fa fa-star\" style=\"color:red\"></i>";
		$level = "Officer";
	}

	if ($guy->username == "") {
		$guy->username = "not given";
	}
	if ($guy->major == "") {
		$guy->major = "not given";
	}

	if ($guy->rank == "8" ) {
		if ($guy->username == "not given")
			$guy->rank = " not given";
		else
			$guy->rank = " unranked";
	}


?>
<?php 
	if ($guy->admin == 3) {
?>
	<div class="container"><h1 style="color:red" class="text-center">Banned</h1></div>
<?php 
	}
?>
<div class="container"><h1 class="<?php echo htmlspecialchars($class); ?> text-center page-header"><?php echo htmlspecialchars("Profile page of ".$guy->first_name); ?></h1></div>
<div class="container">
	<div class="col-sm-6">
		<blockquote>
			<p><img class="img-thumbnail mobilePics <?php echo htmlspecialchars($class); ?>" src="<?php echo htmlspecialchars($path); ?>"  alt="" class="mobilePics"> <?php echo $style." ".htmlspecialchars($guy->first_name." ".$guy->last_name); ?></p>
			<div class="span4">
			<small>
				<cite title="Source Title"><?php echo htmlspecialchars("College: ".$guy->major); ?>  <i class="icon-map-marker"></i></cite></small>
			<hr>
			<p>
				<i class="icon-envelope"></i>Summoner Name: <?php echo htmlspecialchars($guy->username); ?><br>
				<i class="icon-globe"></i>Rank: <?php echo htmlspecialchars(substr($guy->rank, 1)); ?><br>
				<i class="icon-gift"></i>Lane: <?php echo htmlspecialchars($guy->lane);?>
			</p>
			<p>
				<i class="icon-envelope"></i>Member Status: <?php echo htmlspecialchars($level); ?><br>
				<i class="icon-globe"></i>Hours: <?php echo htmlspecialchars($guy->hours); ?><br>
			</p>
		</blockquote>
		<h1 class="page-header">Bio</h1>
		<blockquote>
			<p><?php echo nl2br($guy->bio); ?></p>
		</blockquote>
	</div>
	<div class="col-sm-6">
		<img class="img-responsive center-block <?php echo htmlspecialchars($class); ?>" src="<?php echo htmlspecialchars($path2); ?>"/>
	</div>
</div>
</br>
