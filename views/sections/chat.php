<div class="container">
    <div class="row">
    	<h3 class="text-center"> Chat for cool people </h3>
        <div class="message-wrap col-lg-offset-2 col-lg-8">
            <div id = "msg-wrap" class="msg-wrap">
            	<?php
            		if (!isset($user)) {
            			$disabled = "disabled=\"true\"";
            		}
            		else {
            			$disabled = "";
            		}

            		foreach ($chats as $msg) {
            			$member = $guy->findUser($dbh, $msg->userid);
	            	/*****************************
					Need to cache the images for improved performance, can't completely
					rely on Riot's server for everything
					*****************************/

					//The path needed for the champion's image (locally)
					$path = "img/icons/".$member->champion.".png";
						
					//The path needed for the free week champion's image (remotely)
					$url = "http://ddragon.leagueoflegends.com/cdn/5.14.1/img/champion/".$member->champion.".png";
					//If the file isn't on our server, download it
					if (!file_exists($path)) {
						file_put_contents($path, file_get_contents($url));
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
	                <div id="<?php echo $msg->id; ?>" class="media msg">
	                    <a id="chatLink" class="pull-left" href="user?user=<?php echo htmlspecialchars($msg->userid); ?>">
	                        <img id="chatPic" class="<?php echo $class; ?> media-object" alt="64x64" style="width: 32px; height: 32px;" src="<?php echo htmlspecialchars($path); ?>">
	                    </a>
	                    <div class="media-body">
	                        <small id="chatDate" class="pull-right time"><i class="fa fa-clock-o"></i> <?php echo htmlspecialchars($msg->date); ?></small>

	                        <h5 id="chatName" class="media-heading"><?php echo $style." ".htmlspecialchars($member->first_name); ?></h5>
	                        <small id="chatMsg" class="col-lg-10"><?php echo htmlspecialchars($msg->post); ?></small>
	                    </div>
	                </div>
	            <?php
	            	}
	            ?>
            </div>

            <div class="send-wrap ">
                <textarea <?php echo $disabled; ?> id = "txtbox" class="form-control send-message" maxlength="300" rows="3" placeholder="Write a reply..."></textarea>
            </div>
            <div class="btn-panel">
            	<div class="form-group">
					<button style="color: white" <?php echo $disabled; ?> id = "enterMsg" class="btn btn-primary btn-lg btn-block">Send Message</button>
				</div>
            </div>
        </div>
    </div>
    <hr>
</div>
<script src="js/chat.js"></script>
