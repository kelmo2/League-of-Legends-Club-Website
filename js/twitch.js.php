<script>
	/*********************************
	Author: Corey Muniz
	Javascript for the list of live streams
	*********************************/

	var topStreams;
	var clubStreams;

	/*********************************
	Checks to see if the user is on a phone, if so
	a class to make the images mobile friendly swaps
	for the current one.
	*********************************/
	function checkPhone(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$("#streamRow").find("#preview").attr("class", "img-thumbnail mobilePics");
			$("#streamRow2").find("#preview").attr("class", "img-thumbnail mobilePics");
			$("#streamRow3").find("#preview").attr("class", "img-thumbnail mobilePics");
		}
	};


	//Load all the live streams that the user is following
	function loadUserStreams() {

		$.getJSON("proxy.php?user").done(function(clubChannels) {
	        /*********************************
	        This part loops over each channel and makes a call
	        for each channel that is LIVE. We don't really care for offline 
	        channels at this point but it can be added in later if needed. 
	        *********************************/

	        clubChannels.forEach(function(stream) {
			$.getJSON("proxy.php?channel="+stream).done( function(clubChannel) {
				if  (clubChannel["stream"] != null) {
					newRow = $("#streamRow3").clone();
					$("#streamRow3").before(newRow);
	                        	newRow.show();
	                        	/*********************************
	                        	Change all the data in the new clone created
	                        	and give it an id so we can access it later. 
	                        	*********************************/
	                        	$(newRow).find("#playing").html(clubChannel['stream']['game'])
	                        	$(newRow).find("#viewers").html(clubChannel['stream']['viewers'])
	                        	$(newRow).find("#channel").html(clubChannel['stream']['channel']['display_name'])
	                        	$(newRow).find("#channel").attr("href", "twitch.php?channel="+clubChannel['stream']['channel']['name'])
	                        	$(newRow).find("#picLink").attr("href", "twitch.php?channel="+clubChannel['stream']['channel']['name'])
	                        	$(newRow).find("#preview").attr("src", clubChannel['stream']['preview']['medium'])
				}
	                });
		});
		//Let the user know the channels are loaded by changing the loading icon to a checkmark
	        $("#loading3").attr("class", "fa fa-check")
	        }).fail(function(){
	                console.log("failed to open api - club");
	                $("#loading3").attr("class", "fa fa-times");
			$("#error1").show();		
		});
	}	


	/*********************************
	Adds the top 5 overall streams on twitch as well as 
	whatever streams are being followed by the club on twitch
	to the table. 
	*********************************/
	function addTopStreams() {
		console.log("Trying to fetch top");
		//Gets the top 5 streams on twitch
		$.getJSON("proxy.php?top").done(function(channel) {
			console.log("Loading top streams");
			
			//If the stream grab was successful, do the following
			if (channel["stream"] == null) { 
		    	//For each stream in the top 5 do the following
		        channel.forEach(function(stream) {

		        	//Clone the template to inflate it with the pulled data
					newRow = $("#streamRow").clone();							
					$("#streamRow").before(newRow);							
					newRow.show();	


					/*********************************
					Change all the data in the new clone created
					and give it an id so we can access it later. 
					*********************************/		
					$(newRow).find("#playing").html(stream['game'])				
					$(newRow).find("#viewers").html(stream['viewers'])			
					$(newRow).find("#channel").html(stream['channel']['display_name'])		
					$(newRow).find("#channel").attr("href", "twitch.php?channel="+stream['channel']['name'])		
					$(newRow).find("#picLink").attr("href", "twitch.php?channel="+stream['channel']['name'])
					$(newRow).find("#preview").attr("src", stream['preview']['medium'])	
					$(newRow).attr("id", stream['channel']['name'])
				
			});
			$("#loading").attr("class", "fa fa-check")
		    } else {
		        //Failed
		        console.log("failed to call api");
		    }
		}).fail(function() {
			console.log("failed to open api - top");
			$("#loading").attr("class", "fa fa-times")
			$("#error3").show();
		});

	}

	//Load all the streams that the club's twitch channel is following
	function loadClubStreams() {

		$.getJSON("proxy.php?club").done(function(clubChannels) {
	        /*********************************
	        This part loops over each channel and makes a call
	        for each channel that is LIVE. We don't really care for offline 
	        channels at this point but it can be added in later if needed. 
	        *********************************/

	        clubChannels.forEach(function(stream) {
			$.getJSON("proxy.php?channel="+stream).done( function(clubChannel) {
				if  (clubChannel["stream"] != null) {
					newRow = $("#streamRow2").clone();
					$("#streamRow2").before(newRow);
	                        	newRow.show();
	                        	/*********************************
	                        	Change all the data in the new clone created
	                        	and give it an id so we can access it later. 
	                        	*********************************/
	                        	$(newRow).find("#playing").html(clubChannel['stream']['game'])
	                        	$(newRow).find("#viewers").html(clubChannel['stream']['viewers'])
	                        	$(newRow).find("#channel").html(clubChannel['stream']['channel']['display_name'])
	                        	$(newRow).find("#channel").attr("href", "twitch.php?channel="+clubChannel['stream']['channel']['name'])
	                        	$(newRow).find("#picLink").attr("href", "twitch.php?channel="+clubChannel['stream']['channel']['name'])
	                        	$(newRow).find("#preview").attr("src", clubChannel['stream']['preview']['medium'])
				}
	                });
		});
		//Let the user know the channels are loaded by changing the loading icon to a checkmark
	        $("#loading2").attr("class", "fa fa-check")
	        }).fail(function(){
	                console.log("failed to open api - club");
	                $("#loading2").attr("class", "fa fa-times");
			$("#error3").show();		
		});
	}	

	checkPhone();
	loadUserStreams();
	addTopStreams();
	loadClubStreams();
	$("#streamRow").hide();
	$("#streamRow2").hide();
	$("#streamRow3").hide();
	$("#error1").hide();
	$("#error2").hide();
	$("#error3").hide();
</script>
