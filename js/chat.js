msgs = $(".msg-wrap").children().length;
div = $(".msg-wrap").children()[msgs-1];

lastId = $(div).attr('id');
var objDiv = document.getElementById("msg-wrap");
objDiv.scrollTop = objDiv.scrollHeight;

$(function(){
setInterval(update, 2000);
});

function update() {

	$.getJSON("chat?fetch="+lastId).done(function(messages) {
		//If a new message has been entered, render it onto the users screen
		if (messages != false) {	
			messages.forEach(function(msg) {
				if (msg['status'] == 0) {
					addClass = "";
					style = "";
				}
				else if (msg['status'] == 1) {
					addClass = "paid";
					style = "<i class=\"fa fa-star\" style=\"color:gold\"></i></i>";
				}
				else {
					addClass = "admin";
					style = "<i class=\"fa fa-star\" style=\"color:red\"></i>";
				}


				newRow = $("#"+lastId).clone();
				$("#"+lastId).after(newRow);
				$(newRow).attr('id', msg['id']);
				$(newRow).find("#chatMsg").html(msg['post']);
				$(newRow).find("#chatDate").html("<i class=\"fa fa-clock-o\"></i> "+msg['date']);
				$(newRow).find("#chatName").html(style+" "+msg['name']);
				$(newRow).find("#chatPic").attr("class", "media-object "+addClass);
				$(newRow).find("#chatPic").attr("src", "img/icons/"+msg['champion']+".png");
				$(newRow).find("#chatLink").attr("href", "user?user="+msg['userid']);
				lastId ++;	
				//Move the div to the bottom so they can see new messages
				var objDiv = document.getElementById("msg-wrap");
				objDiv.scrollTop = objDiv.scrollHeight;
			})
		}
	}).fail(function(){
		console.log("failed");
	})
}

$("#enterMsg").click(function(){
	$.getJSON("chat?msg="+$("#txtbox").val()).done(function(clubChannels) {
		//Send the message
	})
	update();
	$("#txtbox").val("")
})
