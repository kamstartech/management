<h1>Leave Request Form</h1>
<p>Please note that leave may only be taken if your leave request has been approved. Submit your request well in advance to prevent delays. Taking leave without authorization is the same as absconding work and is a dismissable offence.</p>
<form id="requestleave" name="requestleave" method = "post"action = "<?php echo $this->core->conf['conf']['path'] . "/staff/leaverequest/". $this->core->item; ?>" >

<div class="table-responsive">
<table class="table">
	<?php
		if($this->core->role == 107 || $this->core->role == 1000){
			echo'
				<tr>
					<td style="width: 200px;">Member of Staff:</td>
					<td>
						<select name="staff" style="width: 250px; margin-right: -10px;" class="select" required> 
							<option value="">-Choose Staff Member-</option>
							'.$staff .' 
						</select>
						 <i>Select the staff you want to apply for.</i></td>
				</tr>';
		}
	?>
	<tr>
		<td style="width: 200px;">Leave Start Date:</td>
		<td><input type="date" id="name" name="start" required> <i>The day your leave starts.</i></td>
	</tr>
	<tr>
		<td>Leave End Date:</td>
		<td><input type="date" id="name" name="end" required>  <i>The last day of your leave.</i></td>
	</tr>
	<tr>	
		<td>Reason for leave:</div></td>
		<td><input type="text" id="name" name="description" required> <i>For example: Holiday.</i></td>
	</tr>
	<tr>	
		<td>Type of Leave<br> </td>
		<td>
			<select name="type" style="width: 250px; margin-right: -10px;" class="select" required> 
			<option value="">-Choose type-</option>
			<?php echo $leavetypes; ?> 
		</select>
		</td>
	</tr>
	<tr>
</table>

	
	<div class="label"></div><input type="submit" name="submit" value="Submit Leave Request" id="submit" class="bigbutton" style="width: 100%; padding: 20px !important;"/>
</form>
</div>
