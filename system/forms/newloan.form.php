<h1>Loan Request Form</h1>
<p>A staff member can apply for a loan that must be payable within 12 months or your contract end date and must not exceed 50% of your net salary. Loans may only be taken out if no current loans are outstanding with other finance companies, banks or other loan providers.</p>
<form id="loanrequest" name="loanrequest" method="post" action = "<?php echo $this->core->conf['conf']['path'] . "/loan/request/". $this->core->item; ?>" >

<div class="table-responsive">
<table class="table">
	<?php
		if($this->core->role == 107 || $this->core->role == 1000){
			echo'
				<tr>
					<td style="width: 200px;">Member of Staff:</td>
					<td>
						<select name="type" style="width: 250px; margin-right: -10px;" class="select" required> 
							<option value="">-Choose Staff Member-</option>
							'.$staff .' 
						</select>
						 <i>Select the staff you want to apply for.</i></td>
				</tr>';
		}
	?>
	<tr>
		<td style="width: 200px;">Loan Duration (months):</td>
		<td><input type="number" id="duration" name="duration" required> <i>The length of your loan 1-12 months.</i></td>
	</tr>
	<tr>	
		<td>Purpose for loan:</div></td>
		<td><input type="text" id="description" name="description" required> <i>For example: Building.</i></td>
	</tr>

	<tr>
</table>
<div class="label"></div><input type="submit" name="submit" value="Submit Loan Request" id="submit" class="bigbutton" style="width: 100%; padding: 20px !important;"/>
</form>
</div>
