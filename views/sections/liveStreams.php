<!-- liveStream List
================================================== -->
<div class="container">

	<div class="page-header text-center">
		<h1 >Live Streams</h1>    
		<p>Log in with your account to see if streams you are following are live</p>
	</div>
	<hr>
	<?php 
			if (isset($user)) {
	?>
	<div class="text-center"><h1 ><i class="fa fa-twitch"></i> Your Streams <i id="loading3" class="fa fa-spinner fa-pulse"></i></h1></div>
	<div class="table-responsive">
		<table class="table">
			<tr>
				<th></th>
				<th class="text-center">Currently Streaming</th>
				<th></th>
			</tr>
			<tr id = "tableHeader">
				<th>Preview</th>
				<th>Playing</th>
				<th>Viewers</th>
				<th>Stream</th>
			</tr>
			<!--Start of table row-->
			<tr id = "streamRow3">
				<td><a id="picLink" href=""><img id="preview" class="img-thumbnail pics" src="img/icons/loading.gif"/></a></td>
				<td id="playing">Stream Template</td>
				<td id="viewers">0</td>
				<td><a id="channel" href="">Link</a></td>
			</tr><!--End of table row-->
		</table>
	<?php } ?>
	</div>


	<h1 class="text-center" style="color:red" id="error2">Failed to open stream, try again later</h1>
	<div class="text-center"><h1 ><i class="fa fa-twitch"></i> Top 5 Streams <i id="loading" class="fa fa-spinner fa-pulse"></i></h1></div>
	<div class="table-responsive">
		<table class="table">
			<tr>
				<th></th>
				<th class="text-center">Currently Streaming</th>
				<th></th>
			</tr>
			<tr id = "tableHeader">
				<th>Preview</th>
				<th>Playing</th>
				<th>Viewers</th>
				<th>Stream</th>
			</tr>

			<!--Start of table row-->
			<tr id = "streamRow">
				<td><a id="picLink" href=""><img id="preview" class="img-thumbnail pics" src="img/icons/loading.gif"/></a></td>
				<td id="playing">Stream Template</td>
				<td id="viewers">0</td>
				<td><a id="channel" href="">Link</a></td>
			</tr><!--End of table row-->

		</table>
	</div>


	<h1 class="text-center" style="color:red" id="error3">Failed to open stream, try again later</h1>
	<div class="text-center"><h1 ><i class="fa fa-twitch"></i> Club Streams <i id="loading2" class="fa fa-spinner fa-pulse"></i></h1></div>
	<div class="table-responsive">	
		<table class="table">
			<tr>
				<th></th>
				<th class="text-center">Currently Streaming</th>
				<th></th>
			</tr>
			<tr id = "tableHeader">
				<th>Preview</th>
				<th>Playing</th>
				<th>Viewers</th>
				<th>Stream</th>
			</tr>
			<!--Start of table row-->
			<tr id = "streamRow2">
				<td><a id="picLink" href=""><img id="preview" class="img-thumbnail pics" src="img/icons/loading.gif"/></a></td>
				<td id="playing">Stream Template</td>
				<td id="viewers">0</td>
				<td><a id="channel" href="">Link</a></td>
			</tr><!--End of table row-->
		</table>
	</div>
</div>
