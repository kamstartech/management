<div class="heading"><?php echo $this->core->translate("Create Purchase Order"); ?></div>
<form id="procurement" name="procurement" method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/orders/save">

<div class="label"><?php echo $this->core->translate("Category: "); ?></div>

	<select name="category" style="width: 260px"> 
		<option value="">- Item category -</option>
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
	</select><br />

	<div class="label"><?php echo $this->core->translate("Supplier"); ?>:</div> 
	<select name="supplier" style="width: 260px"> 
		<option value="">-Choose selected supplier-</option>
		<?php echo $suppliers; ?>
		</select><br />

	
	<div class="label"><?php echo $this->core->translate("Description"); ?>:</div> 
	<input type="text" name="description" id="description" class="submit" style="width: 260px" value="<?php echo $description; ?>" ><br />
	<hr>


	<table class="table">
		<tr style="font-weight: bold"><td>#</td><td>Item Name</td><td>Item Specifications</td><td>Quantity</td><td>Unit Cost</td><td>Order</td></tr>

		<?php
			
			$sql = "SELECT * FROM `requisition-lines` 
			WHERE `requisition-lines`.RequisitionID = $item";
			$rund = $this->core->database->doSelectQuery($sql);

			$x=1;
			while ($fetchd = $rund->fetch_assoc()) {
				$plid = $fetchd['ID'];
				$name = $fetchd['ItemName'];
				$specs = $fetchd['ItemDescription'];
				$quantity = $fetchd['ItemQuantity'];
				$unit = $fetchd['ExpectedCost'];
				$cost = $unit*$quantity;

				
				echo '<tr>
					<td style="width:20px;">'.$x.'</td>
					<td style="width:260px;"><input type="text" name="name[]" id="name" class="submit" style="width: 260px" value="'.$name.'" /></td>
					<td><input type="text" name="specs[]" id="name" class="submit" style="width: 100%" value="'.$specifications.'" /></td>
					<td style="width:80px;"><input type="text" name="quantity[]" id="name" class="submit" style="width: 80px" value="'.$quantity.'" /></td>
					<td style="width:150px;"><input type="text" name="cost[]" id="name" class="submit" style="width: 120px" value="'.$unit.'" /></td>
					<td style="width:50px;"><input type="checkbox" name="budgeted[]" id="budget" class="submit" style="width: 30px" value="on"/></td>
				</tr>';
				
				$x++;				
			}
			
		?>

	</table>

	<input type="submit" name="submit" value="Create Purchase Order" id="submit" class="submit" style="width: 260px"/>
</form>
