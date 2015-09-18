<!-- Free week experimental section 
================================================== -->
<div class="container test">
	<!-- Center the pictures a bit -->
	<div class="col-md-offset-1"></div>

	<?php foreach ($champObj->freeChampionList as $freebie) {
		/*****************************
		Need to cache the images for improved performance, can't completely
		rely on Riot's server for everything
		*****************************/

		//The path needed for the free week champion's image (locally)
		$path = "img/icons/".$champObj->championList[$freebie['id']]['key'].".png";
			
		//The path needed for the free week champion's image (remotely)
		$url = "http://ddragon.leagueoflegends.com/cdn/5.14.1/img/champion/".$champObj->championList[$freebie['id']]['key'].".png";
		//If the file isn't on our server, download it
		if (!file_exists($path)) {
			file_put_contents($path, file_get_contents($url));
		}

		
	?>

	<div class="col-sm-12">
		<img class="pics" src="<?php echo htmlspecialchars($path); ?>"/>
	</div>

<?php } ?>



	
</div>
