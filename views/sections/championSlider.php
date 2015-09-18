

<!-- Carousel section 
================================================== 
Specs: Fluid on all sizes, image should resize and stay 100% width. 
If a new css or html version somehow breaks this, it needs to be fixed. 
==================================================-->
<div id="myCarousel" class="carousel slide">
  <!-- Indicators -->
  <ol class="carousel-indicators">
	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	<?php   
	  $i = 1;
	  foreach ($champObj->freeChampionList as $freebie) {
		echo "<li data-target=\"#myCarousel\" data-slide-to=".$i."></li>";
		$i++;
	  }
	?>
  </ol><!--End of incidators-->
  <!--Start of carousel-->
  <div class="carousel-inner">
	<!--Start of header carousel item-->
	<div class="item active">
	  <img src="img/hec.png" style="width: 100%" class="img-responsive">
	  <div class="container">
		<div class="carousel-caption">
		  <h2>Free Champs</h2>
		</div>
	  </div>
	</div><!--End of header carousel item-->

	<?php foreach ($champObj->freeChampionList as $freebie) {
			/*****************************
			This loops over the free week champions pulled in by the model. 
			We create a carousel item for each free week item pulled in from the api.
			We also check to see if the picture we show is stored locally. If we have the file
			on our server, great just use that; otherwise we download it and THEN use it. 
			*****************************/
			//The path needed for the free week champion's image (locally)
			$path = "img/splash/".$champObj->championList[$freebie['id']]['key']."_0.jpg";

			//The path needed for the free week champion's image (remotely)
			$url = "http://ddragon.leagueoflegends.com/cdn/img/champion/splash/".$champObj->championList[$freebie['id']]['key']."_0.jpg";

			//If the file isn't on our server, download it
			if (!file_exists($path)) {
					file_put_contents($path, file_get_contents($url));
			}

	?>  
	<!--Start of php carousel item-->
	<div class="item">
	  <?php 
		//If the champion is enabled for play, show it in all it's color, otherwise apply a greyscale css class
		if ($freebie['active']) {
	  ?>
		<!--Enabled champion picture-->
		<img src="<?php echo htmlspecialchars($path) ?>" style="width: 100%;" class="img-responsive">
	  <?php } else { ?>
		<!--Disabled champion picture-->
		<img src="<?php echo htmlspecialchars($path) ?>" style="width: 100%;" class="disabled img-responsive">
	  <?php } ?>
		<div class="container">
		<div class="carousel-caption">
		  <h2><?php echo htmlspecialchars($champObj->championList[$freebie['id']]['name']) ?></h2>
		</div>
	  </div>
	</div><!--End of php carousel-->
	<?php } ?>
  </div><!--carosel inner end -->
  <!-- Controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	<span class="icon-prev"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
	<span class="icon-next"></span>
  </a>  
</div>
<!--End of carousel-->

<script src="js/carousel.js"></script>
