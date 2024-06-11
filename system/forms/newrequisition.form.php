<div class="heading"><?php echo $this->core->translate("Create Purchase Requisition"); ?></div>
<form id="procurement" name="procurement" method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/procurement/save">

<div class="label"><?php echo $this->core->translate("Category: "); ?></div><select name="category" style="width: 260px" required> 
		<option value="">- Choose category -</option>
<option value="Allowances">Allowances</option>
<option value="Building Materials">Building Materials</option>
<option value="Carpentry Materials">Carpentry Materials</option>
<option value="Cleaning Materials">Cleaning Materials</option>
<option value="Cleaning Services ">Cleaning Services </option>
<option value="Clinical Attachment">Clinical Attachment</option>
<option value="Consulting Services">Consulting Services</option>
<option value="Electricals">Electricals</option>
<option value="Fabrication Materials">Fabrication Materials</option>
<option value="Flights/Tickets">Flights/Tickets</option>
<option value="Fuel">Fuel</option>
<option value="Furniture">Furniture</option>
<option value="General Hardware ">General Hardware </option>
<option value="ICT Equipment/Services">ICT Equipment/Services</option>
<option value="Immigration Permits">Immigration Permits</option>
<option value="Lab Equipments">Lab Equipments</option>
<option value="Legal Services">Legal Services</option>
<option value="Marketing">Marketing</option>
<option value="Motor Vehicle And Spare Parts">Motor Vehicle And Spare Parts </option>
<option value="Plumbing Materials">Plumbing Materials</option>
<option value="Refunds">Refunds</option>
<option value="Repairs/Maintenance">Repairs/Maintenance</option>
<option value="Security Services">Security Services</option>
<option value="Services">Services</option>
<option value="Sick Bay Equipment And Drugs">Sick Bay Equipment And Drugs </option>
<option value="Stationary">Stationary</option>
<option value="Student Affairs">Student Affairs</option>
<option value="Transportation">Transportation</option>
<option value="Workshops/Venues">Workshops/Venues</option>

	</select> <i>Please select the category of goods</i><br />
	
	<div class="label"><?php echo $this->core->translate("Payment Type: "); ?></div><select name="payment" style="width: 260px"> 
		<option value="">- Choose Preferred Payment Method-</option>
		<option value="Account">To be determined</option>
		<option value="Bank Transfer">Bank Transfer</option>
		<option value="Cheque Payment">Cheque Payment</option>
		<option value="Cash Payment">Cash Payment</option>
	</select> <i>Not required to be filled in </i><br />

	<div class="label"><?php echo $this->core->translate("Requisition Description"); ?>:</div> 
	<input type="text" name="description" id="description" class="submit" style="width: 260px" required> <i>Provide a short summary description of what is being bought</i><br>
	

	
	<hr>

		<p><i>Please add each of the items you are requesting as a new line. Click on the "Add New Line" button below to add an extra line. You may enter as many lines as required.</i></p>
	<table class="table" id="tableset">
		<tr style="font-weight: bold"><td>#</td><td>Item Name</td><td>Item Specifications</td><td>Quantity</td><td>Expected UNIT Cost</td><td>Budgeted</td></tr>
		<tr>
			<td style="width:20px;">1</td>
			<td style="width:260px;"><input type="text" name="name[]" id="name" class="submit" style="width: 260px" required></td>
			<td><input type="text" name="specs[]" id="name" class="submit" style="width: 100%" required></td>
			<td style="width:80px;"><input type="number" name="quantity[]" id="name" class="submit" style="width: 80px" required></td>
			<td style="width:150px;"><input type="number" name="cost[]" id="name" class="submit" style="width: 120px" required></td>
			<td style="width:50px;"><input type="checkbox" name="budgeted[]" id="budget" class="submit" style="width: 30px" required></td>
		</tr>
		
		</table>

		<script>
	count = 1;
	$(document).on("click", "[id^=addline]", function (e) {
		console.log("Useless");
		count = count+1;
	 	$('[id^=tableset]').append('<tr><td style="width:20px;">' + count + '</td><td style="width:260px;"><input type="text" name="name[]" id="name" class="submit" style="width: 260px" required></td><td><input type="text" name="specs[]" id="name" class="submit" style="width: 100%" required></td><td style="width:80px;"><input type="number" name="quantity[]" id="name" class="submit" style="width: 80px" required></td><td style="width:150px;"><input type="number" name="cost[]" id="name" class="submit" style="width: 120px" required></td><td style="width:50px;"><input type="checkbox" name="budgeted[]" id="budget" class="submit" style="width: 30px" /></td></tr>');
	});</script>

	<input type="button" name="addline" value="Add New Line" id="addline" class="addline" style="width: 260px"/><hr>
	<input type="submit" name="submit" value="Submit Purchase Requisition" id="submit" class="" style="width: 260px"/>
</form>
