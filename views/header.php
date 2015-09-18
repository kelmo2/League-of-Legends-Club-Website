<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<!-- Mobile browser scaling settings -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	
	<!-- Author -->
	<meta name="author" content="Corey Muniz">
	

	<?php 
		$title ="South Texas Summoners";
		$description = "The League of Legends club for UTRGV";
		$link = "http://www.stsutrgv.org";
		$type = "website";
		$img = "img/splash/logo.png";

		if (isset($postTitle)) {
			$title = $postTitle;
			$type = "article";
		}
		if (isset($postDescription)) {
			$description = $postDescription;
		}
		if (isset($postLink)) {
			$link = $postLink;
		}
		if (isset($postImg)) {
			$img = $postImg;
		}

	?>

	<!-- You can use open graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content="<?php echo htmlspecialchars($link); ?>" />
    <meta property="og:type"          content="<?php echo htmlspecialchars($type); ?>" />
    <meta property="og:title"         content="<?php echo htmlspecialchars($title); ?>" />
    <meta property="og:description"   content="<?php echo htmlspecialchars($description); ?>" />
    <meta property="og:image"         content="<?php echo htmlspecialchars($img); ?>" />
    <meta property="fb:app_id" content="806835319430009" />


	<!--Page title -->
	<title>South Texas Summoners</title>
	<link rel="shortcut icon" href="img/splash/logo.png" />
	
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Custom CSS -->
	<link href="css/stuff.css" rel="stylesheet">

	  	
    <!-- Importing Javascript frameworks -->  
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/images.js"></script>
</head>
  
<body>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


  	<!-- Navigation bar element begins -->
  	<nav class="navbar navbar-inverse navbar-static-top no-transition" role="navigation">
  		<div class="container-fluid">
  		
  			<!-- Menu button & Brand are grouped for better mobile display below -->
  			<header class="navbar-header" role="banner">
  			
  				<!-- Navigation button below (≡) only visible on navbar-collapse -->
  				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
  					<!-- "Toggle navigation" only visible on screen-readers -->
  					<span class="sr-only">Toggle navigation</span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  				</button><!-- End Navigation button -->
  				
  				<!-- Brand link below -->
  				<a class="navbar-brand" href="/">
  					<!-- <span>Home</span> -->
  					<img class="navPic" src="img/splash/logo.png" alt="">
  				</a><!-- End navbar-brand -->
  			</header><!-- End header -->
  			
  			<!-- Navigation links and other content will be collapsable when in mobile devices -->
  			<div class="collapse navbar-collapse" id="navbar-collapse-1">
  				<!-- Left navigation bar segment -->
  				<div class="navbar-left">
	  				<ul class="nav navbar-nav">
	  					<li><a class="nlink"  href="fantasy"><span class=" fa fa-fw fa-shield"></span>Fantasy LCS</a></li>
	  					<li><a a class="nlink" href="liveStreams"><span class="fa fa-fw fa-twitch"></span>Twitch</a></li>
	  					<li class="dropdown">
	  						<a href="events" class="nlink dropdown-toggle" data-toggle="dropdown" role="button" aria-expaned="false">
	  							<span class="fa fa-fw fa-gamepad"></span>Events<span class="caret"></span>
	  						</a>
	  						
	  						<!-- Dropdown-menu links -->
	  						<ul class="dropdown-menu" role="menu">
	  							<li><a href="events?id=1">Spring 2015 Tournament</a></li>
	  							<li><a href="events?id=2">End of the Year Social</a></li>
					            <li><a href="events?id=3">LAN Party/Tournament</a></li>
	  						</ul><!-- End dropdown-menu -->
	  						
	  					</li><!-- End dropdown -->
						<li><a class="nlink"  href="memberlist"><span class=" fa fa-fw fa-users"></span>Memberlist</a></li>
	  					<li class="dropdown">
	  						<a href="" class="nlink dropdown-toggle" data-toggle="dropdown" role="button" aria-expaned="false">
	  							<span class="fa fa-fw fa-question"></span> About <span class="caret"></span>
	  						</a>
	  						
	  						<!-- Dropdown-menu links -->
	  						<ul class="dropdown-menu" role="menu">
	  					    <li><a href="officers">Officers</a></li>
					            <li><a href="about">About Us</a></li>
					            <li><a href="tournaments">Tournaments</a></li>
					            <li><a href="meetings">Meetings</a></li>
	  						<li><a href="membership">Membership</a></li>
							<li><a href="contact">Contact Us</a></li>
							 <li><a href="teamspeak">Teamspeak Server</a></li>
							<li class="divider"></li>
							<li><a href="legal">Legal</a></li>
							</ul><!-- End dropdown-menu -->
	  						
	  					</li><!-- End dropdown -->
	  				</ul><!-- End navbar-nav -->
  				</div><!-- End navbar-left -->
  				
  				<!-- Right navigation bar segment -->
  				<div class="navbar-right">
  					<ul class="nav navbar-nav">
						<?php 
							//If the user is logged in
							if (isset ($_SESSION['user'])) {
								$user = $_SESSION['user']; 
								//If a basic user is logged in, route them to their dashboard
								if ($_SESSION['user']->admin == 0 || $_SESSION['user']->admin == 1) {
						?>
  							<li><a a class="nlink" href="logout"><span class="fa fa-fw fa-sign-out"></span> Logout</a></li>
							<li><a data-toggle="tooltip" data-placement="left" title="View your profile" a class="nlink" href="user?user=<?php echo $user->id ?>"><span class="fa fa-fw fa-user-plus"></span></a></li>
  							<li><a data-toggle="tooltip" data-placement="left" title="Go to your dashboard" a class="nlink" href="dashboard"><span class="fa fa-fw fa-dashboard"></span></a></li>
						<?php
								}
								//Otherwise it's an admin and send them to the admin panel
								else {
						?>
							<li><a a class="nlink" href="logout"><span class="fa fa-fw fa-sign-out"></span> Logout</a></li>
  							<li><a data-toggle="tooltip" data-placement="left" title="Go to your profile" a class="nlink" href="user?user=<?php echo $user->id ?>"><span class="fa fa-fw fa-user-plus"></span></a></li>
							<li><a data-toggle="tooltip" data-placement="left" title="Go to your dashboard" a class="nlink" href="dashboard"><span class="fa fa-fw fa-dashboard"></span></a></li>
							<li><a data-toggle="tooltip" data-placement="left" title="Go to the admin panel" a class="nlink" href="admin"><span class="fa fa-fw fa-cog"></span></a></li>
  						<?php
  								}
  							}
							//Otherwise they are not logged in
  							else {
  						?>
							<li><a a class="nlink" href="loginCheckCtrl"><span class="fa fa-fw fa-user"></span> Login</a></li>
						<?php
						 	} 
						?>
  					</ul> <!-- End navbar-nav -->
				<!--<p class="navbar-text"><span class="fa fa-cog"></span></p> -->
  				</div><!-- End navbar-right-->
  				
  			</div><!-- End navbar-collapse -->
  		</div><!-- End container-fluid -->
  	</nav><!-- End navigation -->
