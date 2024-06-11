<div class="heading"><?php echo $this->core->translate("Create Quotation"); ?></div>
<form id="procurement" name="procurement" method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/quotation/save">

<div class="label"><?php echo $this->core->translate("Client: "); ?></div>
	<select name="client" style="width: 260px" required> 
		<option value="">-choose client-</option>
		<?php echo $clients; ?>
	</select><br />

	<div class="label"><?php echo $this->core->translate("Description"); ?>:</div> 
	<input type="text" name="description" id="description" class="submit" style="width: 260px" required><br>
	
	
	<div class="label"><?php echo $this->core->translate("Payment Terms"); ?>:</div> 
	<input type="text" name="terms" id="terms" class="submit" style="width: 260px"><br>
	
	
	<div class="label"><?php echo $this->core->translate("Currency"); ?>:</div> 
	<select name="currency" required>
		<option>Currency</option>
		<option value="USD">USD</option>
		<option value="ZMW">ZMW</option>
		<option value="EUR">EUR</option>
		<option value="ZAR">ZAR</option>
	</select><br>
	
	<hr>

	<table class="table" id="quotation">
		<tr style="font-weight: bold"><td>#</td><td>Item Name</td><td>Item Specifications</td><td>Quantity</td><td> UNIT Cost</td><td>Stock</td></tr>
		<tr>
			<td style="width:20px;">1</td>
			<td style="width:260px;"><input type="text" name="name[]" id="name" class="submit" style="width: 260px" /></td>
			<td><input type="text" name="specs[]" id="name" class="submit" style="width: 100%" /></td>
			<td style="width:80px;"><input type="text" name="quantity[]" id="name" class="submit" style="width: 80px" /></td>
			<td style="width:150px;"><input type="text" name="cost[]" id="name" class="submit" style="width: 120px" /></td>
			<td style="width:50px;"><input type="checkbox" name="stock[]" id="budget" class="submit" style="width: 30px" /></td>
		</tr>
		<tr>
			<td>2</td>
			<td><input type="text" name="name[]" id="name" class="submit" style="width: 260px" /></td>
			<td><input type="text" name="specs[]" id="specs" class="submit" style="width: 100%" /></td>
			<td><input type="text" name="quantity[]" id="quantity" class="submit" style="width: 80px" /></td>
			<td><input type="text" name="cost[]" id="cost" class="submit" style="width: 120px" /></td>
			<td><input type="checkbox" name="stock[]" id="budget" class="submit" style="width: 30px" /></td>
		</tr>
		<tr>
			<td>3</td>
			<td><input type="text" name="name[]" id="name" class="submit" style="width: 260px" /></td>
			<td><input type="text" name="specs[]" id="name" class="submit"  style="width: 100%" /></td>
			<td><input type="text" name="quantity[]" id="name" class="submit" style="width: 80px" /></td>
			<td><input type="text" name="cost[]" id="name" class="submit" style="width: 120px" /></td>
			<td><input type="checkbox" name="stock[]" id="budget" class="submit" style="width: 30px" /></td>
		</tr>
		<tr>
			<td>4</td>
			<td><input type="text" name="name[]" id="name" class="submit" style="width: 260px" /></td>
			<td><input type="text" name="specs[]" id="name" class="submit"  style="width: 100%"/></td>
			<td><input type="text" name="quantity[]" id="name" class="submit" style="width: 80px" /></td>
			<td><input type="text" name="cost[]" id="name" class="submit" style="width: 120px" /></td>
			<td><input type="checkbox" name="stock[]" id="budget" class="submit" style="width: 30px" /></td>
		</tr>
		<tr>
			<td>5</td>
			<td><input type="text" name="name[]" id="name" class="submit" style="width: 260px" /></td>
			<td><input type="text" name="specs[]" id="name" class="submit"  style="width: 100%" /></td>
			<td><input type="text" name="quantity[]" id="name" class="submit" style="width: 80px" /></td>
			<td><input type="text" name="cost[]" id="name" class="submit" style="width: 120px" /></td>
			<td><input type="checkbox" name="stock[]" id="budget" class="submit" style="width: 30px" /></td>
		</tr>
		
	</table>

	<a href="#"  onclick="addTableRow()"> Add extra line </a> <hr>
	
	<input type="submit" name="submit" value="Create Quotation" id="submit" class="submit" style="width: 260px"/>
</form>


<script>
var count = 6; 

function addTableRow() {
  var newRow = document.createElement("tr");

  count

  newRow.innerHTML = `
    <td>` + count + `</td>
    <td><input type="text" name="name[]" class="submit" style="width: 260px" /></td>
    <td><input type="text" name="specs[]" class="submit" style="width: 100%" /></td>
    <td><input type="text" name="quantity[]" class="submit" style="width: 80px" /></td>
    <td><input type="text" name="cost[]" class="submit" style="width: 120px" /></td>
    <td><input type="checkbox" name="stock[]" class="submit" style="width: 30px" /></td>
  `;

  var table = document.getElementById("quotation");

  table.appendChild(newRow);
  count++;
}

</script>
