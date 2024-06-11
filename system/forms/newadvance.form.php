<h1>Salary Advance</h1>
<p>A staff member can apply for a salary advance that is up to 50% of their NET pay. The advance will be paid within 2 workdays if approved and will be deducted from the salary at the end of the month.</p>
<form id="advancerequest" name="advancerequest" method="post" action = "<?php echo $this->core->conf['conf']['path'] . "/loan/advancerequest/". $this->core->item; ?>" >

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
		<td style="width: 200px;">Advance amount:</td>
		<td><input type="number" id="amount" name="amount" required> <i>Salary advance amount.</i></td>
	</tr>
	<tr>	
		<td>Purpose for loan:</div></td>
		<td><input type="text" id="description" name="description" required> <i>For example: Medical emergency.</i></td>
	</tr>

	<tr>
</table>
<div class="label"></div><input type="submit" name="submit" value="Submit Salary Advance Request" id="submit" class="bigbutton" style="width: 100%; padding: 20px !important;"/>
</form>
</div>
