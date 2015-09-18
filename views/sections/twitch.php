<?php 
if (!isset($stream) && !isset($_GET['channel'])) { die; }

if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {$video="250px"; $chat="300px"; } else { $video="500px"; $chat="500px"; } 
?>


<!-- Twitch (Currently very very basic demo) section 
================================================== -->
<div class="container">
    <h3 class="text-center">You Are Watching: <?php echo htmlspecialchars($_GET['channel']) ?></h3>
    <!-- Plays the top stream -->
    <div class="col-md-9">
        <iframe height=<?php echo $video ?> width="100%" frameborder="0" scrolling="no" src="http://www.twitch.tv/<?php echo htmlspecialchars($stream); ?>/embed"></iframe>     
    </div>
    <div class="col-md-3">
          <iframe frameborder="0" 
                  scrolling="no" 
                  id="chat_embed" 
                  src="http://www.twitch.tv/<?php echo htmlspecialchars($stream); ?>/chat" 
                  height=<?php echo $chat ?>; 
                  width="100%">
          </iframe>
    </div>
</div><!-- End div for twitch page -->
<br/>


