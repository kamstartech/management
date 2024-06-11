<div class="heading"><?php echo $this->core->translate("Schedule Meeting"); ?></div>
<form id="procurement" name="procurement" method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/meetings/save">

<div class="label"><?php echo $this->core->translate("Client Organization: "); ?></div> <select name="client" style="width: 260px"> 
		<option value="">-choose client-</option>
		<?php echo $clients; ?>

	</select><br />

	<div class="label"><?php echo $this->core->translate("Meeting Description"); ?>:</div> 
	<input type="text" name="description" id="description" class="submit" style="width: 260px" /><br>
	

	<div class="label"><?php echo $this->core->translate("Meeting Venue"); ?>:</div> 
	<input type="text" name="venue" id="venue" class="submit" style="width: 260px" /><br>
	



	<div class="label"><?php echo $this->core->translate("Meeting Start Time"); ?>:</div> 
	<input type="datetime-local" name="start" id="time" class="submit" style="width: 260px" /><br>
	
	
	
	<div class="label"><?php echo $this->core->translate("Meeting End Time"); ?>:</div> 
	<input type="datetime-local" name="end" id="time" class="submit" style="width: 260px" /><br>
	

	<hr>
	
	<p><b>Note:</b> Clients requesting for consultancy services on premise outside of an active Service Level Agreement or Consultancy Agreement will be charged the standard hourly or daily rate depending on the general terms and conditions set forth by Corelink Consulting Ltd. </p>
	
	<hr>


	<input type="submit" name="submit" value="Submit Meeting Request" id="submit" class="submit" style="width: 260px"/>
</form>
