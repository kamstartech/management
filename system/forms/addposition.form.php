<h1>Create Position</h1>
<p>Use the form below to define a new position.</p>
<form id="requestleave" name="requestleave" method = "post" action = "<?php echo $this->core->conf['conf']['path'] . "/positions/save/". $this->core->item; ?>" >

<div class="table-responsive">
<table class="table">
	<tr>
		<td style="width: 200px;">Job Title:</td>
		<td><input type="text" id="name" name="name" value="<?php echo $jobtitle; ?>" required> <i>Full job title.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Detailed Job Description:</td>
		<td><textarea name="description"  rows="4" cols="50" required> <?php echo $description; ?></textarea> <i>Provide the detailed job description</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Salary Grade:</td>
		<td><input type="text" id="grade" name="grade" value="<?php echo $grade; ?>" required> <i>Salary grade level.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Basic Pay:</td>
		<td><input type="text" id="pay" name="pay" value="<?php echo $pay; ?>" required> <i>Basic pay salary.</i></td>
	</tr>
		<tr>
		<td style="width: 200px;">Leave days (month):</td>
		<td><input type="number" step="0.01" id="leave" name="leave"  value="<?php echo $leave; ?>" required> <i>Number of leave days per month.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Establishment Required:</td>
		<td><input type="number" id="establishment" name="establishment"  value="<?php echo $establishment; ?>" required> <i>Number of employees to be filled.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Entitlements:</td>
		<td><input type="text" id="entitlements" name="entitlements" value="<?php echo $entitlement; ?>" > <i>For example: Transport, Talktime, Entertainment allowance.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Contract Type:</td>
		<td><select name="type" style="width: 250px; margin-right: -10px;" class="select" required> 
				<?php if($contract != ''){  echo '<option value="'.$contract.'">' . $contract .'</options>';  } ?>
				<option value="Permanent and Pensionable">Permanent and Pensionable</options>
				<option value="Short Term Contract">Short Term Contract</option>
				<option value="Fixed Term Contract">Fixed Term Contract</option>
				<option value="Part-time Contract">Part-time Contract</option>
				<option value="Consultant">Consultant</option>
			</select> <i>Basic pay salary.</i></td>
	</tr>
	<tr>
		<td>Supervisor:</td>
		<td>
			<select name="managed" style="width: 250px; margin-right: -10px;" class="select" required> 
				<?php echo $staff; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Department:</td>
		<td>
			<select name="department" style="width: 250px; margin-right: -10px;" class="select" required> 
				<?php echo $departments; ?>
			</select>
		</td>
	</tr>
</table>

	
	<div class="label"></div><input type="submit" name="submit" value="Create Position" id="submit" class="submit" style="width: 100%; padding: 20px !important;"/>
</form>
</div>
   