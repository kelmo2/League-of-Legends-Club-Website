<!-- Demo for championlist dropdown section 
================================================== -->
<div class="container">
	<!-- Select champion dropdown -->
	<select class="form-control">
		<option disabled="true" selected="true">Select yo champ dog</option>
		<?php
		foreach ($champObj->championList as $champ) {
		?>
			<option value="<?php echo htmlspecialchars($champ['name']); ?>"> <?php echo htmlspecialchars($champ['name']); ?> </option>
		<?php } ?>
	</select><!-- End select dropdown -->
</div><!-- End section -->
