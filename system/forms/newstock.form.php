<div class="heading"><?php echo $this->core->translate("Create Purchase Order"); ?></div>
<form id="procurement" name="procurement" method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/stock/save/<?php echo $item; ?>">


	
	<div class="label"><?php echo $this->core->translate("Description"); ?>:</div> 
	<input type="text" name="description" id="description" class="submit" style="width: 260px" value="<?php echo $description; ?>" ><br />
	<input type="hidden" name="category" id="category" class="submit" style="width: 260px" value="<?php echo $category; ?>" ><br />
	<hr>


	<table class="table">
		<tr style="font-weight: bold"><td>#</td><td>Item Name</td><td>Item Specifications</td><td>Quantity</td></td><td>Value</td><td>Received</td></tr>

		<?php
			
			$sql = "SELECT * FROM `order-lines` 
			WHERE `order-lines`.OrderID = $item";
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
					<td style="width:80px;"><input type="text" name="unit[]" id="name" class="submit" style="width: 80px" value="'.$cost.'" disabled></td>
					<td style="width:50px;"><input type="checkbox" name="received[]" id="received" class="submit" style="width: 30px" value="on"/></td>
				</tr>';
				
				$x++;				
			}
			
		?>

	</table>

	<input type="submit" name="submit" value="Receive Marked Goods" id="submit" class="submit" style="width: 260px"/>
</form>
