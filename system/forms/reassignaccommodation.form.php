<div class="heading"><?php echo $this->core->translate("Apply for accommodation online"); ?></div>
<form id="idsearch" name="paymentadd" method="get" action="<?php echo $this->core->conf['conf']['path']; ?>/accommodation/apply/save">

	<div class="label"><?php echo $this->core->translate("Select your province"); ?>:</div><select name="province" id="province">
					<!-- <option selected> PROVINCE SELECTION </option> -->
					<option value="Central">Central</option>
					<option value="Copperbelt">Copperbelt</option>
					<option value="Eastern">Eastern</option>
					<option value="Luapula">Luapula</option>
					<option value="Lusaka">Lusaka</option>
					<option value="Muchinga">Muchinga</option>
					<option value="North-Western">North-Western</option>
					<option value="Northern">Northern</option>
					<option value="Southern">Southern</option>
					<option value="Western">Western</option>

	</select> <br>


	<!-- <input type="hidden" name="district" value="<?php echo $item; ?>"/> -->

	<div class="label"><?php echo $this->core->translate("What district do you live in?"); ?> </div><input type="text" name="district" value="" class="submit" style="width: 260px" style="width: 260px" required/> <br>

	<!-- <div class="label"><?php echo $this->core->translate("Do you have a disability"); ?> </div><select name="disability" id="disability">
					<option selected  value="No"> NO</option>
					<option value="Yes">Yes</option>
	</select> <br> -->

	<div class="label"> Select a hostel</div>
	<select name="hostel" id="hostel" required>
		<option value="">none selected</option>
		<?php
					include $this->core->conf['conf']['classPath'] . "showoptions.inc.php";

					$optionBuilder = new optionBuilder($this->core);
					$hostels  = 	$optionBuilder->showHostels();
					echo $hostels;
		?>
	</select> <br>

	<div class="label"> Available rooms</div>
	<select name="room" id="room" required>
		<option value="">Room 1A</option>
	</select> <br>

	<div class="label">&nbsp;</div><input type="submit" name="submit" id="submit" value="Apply now" class="submit" style="width: 260px"/>
</form>

<script>
$(document).ready(function(){
	$("#hostel").change(function(){
		$.ajax({ 
		type: "GET",
		url: "/api/accommodation",
		data:'data='+$(this).val(),
		success: function(data){
			// $("#suggesstion-box").show();
			$("#room").html(data);
			//$("#search-box").css("background","#FFF");
		}
		});
	});
});
</script>
