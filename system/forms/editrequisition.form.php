<div class="heading"><?php echo $this->core->translate("Update Purchase Requisition Item"); ?></div>
<form id="procurement" name="procurement" method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/procurement/saveedit/<?php echo $item; ?>">

<table class="table" id="tableset">
		<tr style="font-weight: bold"><td>#</td><td>Item Name</td><td>Item Specifications</td><td>Quantity</td><td>Expected UNIT Cost</td></tr>
		<tr>
			<td style="width:20px;">1</td>
			<td style="width:260px;"><input type="text" name="name" id="name" class="submit" style="width: 260px" value="<?php echo $name; ?>" required></td>
			<td><input type="text" name="specs" id="name" class="submit" style="width: 100%" value="<?php echo $specs; ?>" required></td>
			<td style="width:80px;"><input type="number" name="quantity" id="name" class="submit" style="width: 80px" value="<?php echo $qty; ?>" required></td>
			<td style="width:150px;"><input type="number" name="cost" id="name" class="submit" style="width: 120px" value="<?php echo $cost; ?>" required></td>
		</tr>
		
		</table>


	<input type="submit" name="submit" value="Update Purchase Requisition" id="submit" class="" style="width: 260px"/>
</form>
