<h1>Create Supplier</h1>
<p>Use the form below to define a new supplier.</p>
<form id="requestleave" name="requestleave" method="POST" action = "<?php echo $this->core->conf['conf']['path'] . "/suppliers/save/". $this->core->item; ?>" >

<div class="table-responsive">
<table class="table">
	<tr>
		<td style="width: 200px;">Supplier Name:</td>
		<td><input type="text" id="name" name="name" value="<?php echo $name; ?>" required> <i>Supplier Name.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Supplier  Address:</td>
		<td><textarea name="address" rows="4" cols="50" required><?php echo $address; ?></textarea> <i>Address .</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Supplier Email:</td>
		<td><input type="email" id="email" name="email" value="<?php echo $email; ?>" > <i>Email.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Supplier Phone:</td>
		<td><input type="number" id="phone" name="phone" value="<?php echo $phone; ?>" required> <i>Phone.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">TPIN:</td>
		<td><input type="number" id="tpin" name="tpin"  value="<?php echo $tpin; ?>" > <i>TPIN</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">PACRA:</td>
		<td><input type="number" id="pacra" name="pacra" value="<?php echo $pacra; ?>" > <i>PACRA number</i></td>
	</tr>

	<tr>
		<td style="width: 200px;" >Supplier Categories:</td>
		<td><select name="category" style="width: 250px; margin-right: -10px;" class="select" required> 
				<?php if($category != ''){ echo "<option>". $category . "</option>"; } ?>
				<option value="Stationary">Stationary</option>
				<option value="Hardware">Hardware</option>
				<option value="Office Equipment">Office Equipment</option>
				<option value="ICT">ICT</option>
				<option value="Cleaning">Cleaning Services</option>
				<option value="Medical">Medical Services</option>
				<option value="Security">Security Services</option>
				<option value="Accommodation">Accommodation Services</option>
			</select> <i>Category of supplier.</i></td>
	</tr>
</table>

	
	<div class="label"></div><input type="submit" name="submit" value="Create Supplier" id="submit" class="submit" style="width: 100%; padding: 20px !important;"/>
</form>
</div>
   