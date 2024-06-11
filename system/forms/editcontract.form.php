<div class="heading"><?php echo $this->core->translate("Save Contract Salary Conditions"); ?></div>
<form id="contract" name="contract" method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/staff/savecontract/<?php echo $item; ?>">


	<table class="table" style="width: 20% !important;">
		<tr style="font-weight: bold"><td>#</td><td>Category</td><td>Gross Amount</td><td>Taxed</td><td>Monthly</td></tr>
		<tr>
			<td style="width:20px;">1</td>
			<td style="width:260px;"><select name="category[]" style="width: 260px"> 
				<?php if($category[0] == ''){ echo '<option value="">-Choose category-</option>'; } else {  echo '<option value="'.$category[0].'">'.$category[0].'</option>'; } ?>
				<option value="Basic Pay">Basic Pay</option>
				<option value="Housing Allowance">Housing Allowance</option>
				<option value="Transport Allowanc">Transport Allowance</option>
				<option value="Vechicle Replacement Allowance">Vechicle Replacement Allowance</option>
				<option value="Lunch Allowance">Lunch Allowance</option>
				<option value="Acting/Responsibility Alowance">Acting/Responsibility Alowance</option>
				<option value="Entertainment Allowance">Entertainment Allowance</option>
				<option value="Workers Allowance">Workers Allowance</option>
				<option value="Cellphone/Internet Allowance">Cellphone/Internet Allowance</option>
				<option value="Rural/Remote Hardship Allowance">Rural/Remote Hardship Allowance</option>
				<option value="Rural Hardship Allowance">Double Class Allowance</option>
				<option value="Education/Development Allowance">Education/Development Allowance</option>
			</select></td>
			<td><input type="number" name="amount[]" id="amountgross" class="submit" style="width: 150px" value="<?php echo $amount[0]; ?>"/></td>
			<td style="width:150px;"><select name="taxed[]" style="width: 150px"> 
				<?php if($taxed[0] == ''){ echo '<option value="">-Choose Tax Type-</option>'; } else {  echo '<option value="'.$taxed[0].'">'.$taxed[0].'</option>'; } ?>
				<option value="PAYE">PAYE</option>
				<option value="NHIMA">NHIMA</option>
				<option value="NAPSA">NAPSA</option>
				<option value="PAYE,NHIMA">PAYE,NHIMA</option>
				<option value="NHIMA,NAPS">NHIMA,NAPSA</option>
				<option value="PAYE,NHIMA,NAPSA">PAYE,NHIMA,NAPSA</option>
				<option value="">Not Taxed</option>
			</select></td>
			<td style="width:50px;"><input type="checkbox" name="monthly[]" id="budget" class="submit" style="width: 30px" value="<?php echo $monthly[0]; ?>"/></td>
		</tr>
		<tr>
			<td style="width:20px;">2</td>
			<td style="width:260px;"><select name="category[1]" style="width: 260px"> 
				<?php if($category[1] == ''){ echo '<option value="">-Choose category-</option>'; } else {  echo '<option value="'.$category[1].'">'.$category[1].'</option>'; } ?>
				<option value="Basic Pay">Basic Pay</option>
				<option value="Housing Allowance">Housing Allowance</option>
				<option value="Transport Allowanc">Transport Allowance</option>
				<option value="Vechicle Replacement Allowance">Vechicle Replacement Allowance</option>
				<option value="Lunch Allowance">Lunch Allowance</option>
				<option value="Acting/Responsibility Alowance">Acting/Responsibility Alowance</option>
				<option value="Entertainment Allowance">Entertainment Allowance</option>
				<option value="Workers Allowance">Workers Allowance</option>
				<option value="Cellphone/Internet Allowance">Cellphone/Internet Allowance</option>
				<option value="Rural/Remote Hardship Allowance">Rural/Remote Hardship Allowance</option>
				<option value="Rural Hardship Allowance">Double Class Allowance</option>
				<option value="Education/Development Allowance">Education/Development Allowance</option>
			</select></td>
			<td><input type="number" name="amount[]" id="amountgross" class="submit" style="width: 150px" value="<?php echo $amount[1]; ?>"/></td>
			<td style="width:150px;"><select name="taxed[]" style="width: 150px"> 
				<?php if($taxed[1] == ''){ echo '<option value="">-Choose Tax Type-</option>'; } else {  echo '<option value="'.$taxed[1].'">'.$taxed[1].'</option>'; } ?>
				<option value="PAYE">PAYE</option>
				<option value="NHIMA">NHIMA</option>
				<option value="NAPSA">NAPSA</option>
				<option value="PAYE,NHIMA">PAYE,NHIMA</option>
				<option value="NHIMA,NAPS">NHIMA,NAPSA</option>
				<option value="PAYE,NHIMA,NAPSA">PAYE,NHIMA,NAPSA</option>
				<option value="">Not Taxed</option>
			</select></td>
			<td style="width:50px;"><input type="checkbox" name="monthly[]" id="budget" class="submit" style="width: 30px" value="<?php echo $monthly[1]; ?>"/></td>
		</tr>
		<tr>
			<td style="width:20px;">3</td>
			<td style="width:260px;"><select name="category[2]" style="width: 260px"> 
				<?php if($category[2] == ''){ echo '<option value="">-Choose category-</option>'; } else {  echo '<option value="'.$category[2].'">'.$category[2].'</option>'; } ?>
				<option value="Basic Pay">Basic Pay</option>
				<option value="Housing Allowance">Housing Allowance</option>
				<option value="Transport Allowanc">Transport Allowance</option>
				<option value="Vechicle Replacement Allowance">Vechicle Replacement Allowance</option>
				<option value="Lunch Allowance">Lunch Allowance</option>
				<option value="Acting/Responsibility Alowance">Acting/Responsibility Alowance</option>
				<option value="Entertainment Allowance">Entertainment Allowance</option>
				<option value="Workers Allowance">Workers Allowance</option>
				<option value="Cellphone/Internet Allowance">Cellphone/Internet Allowance</option>
				<option value="Rural/Remote Hardship Allowance">Rural/Remote Hardship Allowance</option>
				<option value="Rural Hardship Allowance">Double Class Allowance</option>
				<option value="Education/Development Allowance">Education/Development Allowance</option>
			</select></td>
			<td><input type="number" name="amount[]" id="amountgross" class="submit" style="width: 150px" value="<?php echo $amount[2]; ?>"/></td>
			<td style="width:150px;"><select name="taxed[]" style="width: 150px"> 
				<?php if($taxed[2] == ''){ echo '<option value="">-Choose Tax Types-</option>'; } else {  echo '<option value="'.$taxed[2].'">'.$taxed[2].'</option>'; } ?>
				<option value="PAYE">PAYE</option>
				<option value="NHIMA">NHIMA</option>
				<option value="NAPSA">NAPSA</option>
				<option value="PAYE,NHIMA">PAYE,NHIMA</option>
				<option value="NHIMA,NAPS">NHIMA,NAPSA</option>
				<option value="PAYE,NHIMA,NAPSA">PAYE,NHIMA,NAPSA</option>
				<option value="">Not Taxed</option>
			</select></td>
			<td style="width:50px;"><input type="checkbox" name="monthly[]" id="budget" class="submit" style="width: 30px" value="<?php echo $monthly[2]; ?>"/></td>
		</tr>
		<tr>
			<td style="width:20px;">4</td>
			<td style="width:260px;"><select name="category[]" style="width: 260px"> 
				<?php if($category[3] == ''){ echo '<option value="">-Choose category-</option>'; } else {  echo '<option value="'.$category[3].'">'.$category[3].'</option>'; } ?>
				<option value="Basic Pay">Basic Pay</option>
				<option value="Housing Allowance">Housing Allowance</option>
				<option value="Transport Allowanc">Transport Allowance</option>
				<option value="Vechicle Replacement Allowance">Vechicle Replacement Allowance</option>
				<option value="Lunch Allowance">Lunch Allowance</option>
				<option value="Acting/Responsibility Alowance">Acting/Responsibility Alowance</option>
				<option value="Entertainment Allowance">Entertainment Allowance</option>
				<option value="Workers Allowance">Workers Allowance</option>
				<option value="Cellphone/Internet Allowance">Cellphone/Internet Allowance</option>
				<option value="Rural/Remote Hardship Allowance">Rural/Remote Hardship Allowance</option>
				<option value="Rural Hardship Allowance">Double Class Allowance</option>
				<option value="Education/Development Allowance">Education/Development Allowance</option>
			</select></td>
			<td><input type="number" name="amount[]" id="amountgross" class="submit" style="width: 150px" value="<?php echo $amount[3]; ?>"/></td>
			<td style="width:150px;"><select name="taxed[]" style="width: 150px"> 
				<?php if($taxed[3] == ''){ echo '<option value="">-Choose Tax Type-</option>'; } else {  echo '<option value="'.$taxed[3].'">'.$taxed[3].'</option>'; } ?>
				<option value="PAYE">PAYE</option>
				<option value="NHIMA">NHIMA</option>
				<option value="NAPSA">NAPSA</option>
				<option value="PAYE,NHIMA">PAYE,NHIMA</option>
				<option value="NHIMA,NAPS">NHIMA,NAPSA</option>
				<option value="PAYE,NHIMA,NAPSA">PAYE,NHIMA,NAPSA</option>
				<option value="">Not Taxed</option> 
			</select></td>
			<td style="width:50px;"><input type="checkbox" name="monthly[]" id="budget" class="submit" style="width: 30px" value="<?php echo $monthly[3]; ?>"/></td>
		</tr>
		<tr>
			<td style="width:20px;">5</td>
			<td style="width:260px;"><select name="category[]" style="width: 260px"> 
				<?php if($category[4] == ''){ echo '<option value="">-Choose category-</option>'; } else {  echo '<option value="'.$category[4].'">'.$category[4].'</option>'; } ?>
				<option value="Basic Pay">Basic Pay</option>
				<option value="Housing Allowance">Housing Allowance</option>
				<option value="Transport Allowanc">Transport Allowance</option>
				<option value="Vechicle Replacement Allowance">Vechicle Replacement Allowance</option>
				<option value="Lunch Allowance">Lunch Allowance</option>
				<option value="Acting/Responsibility Alowance">Acting/Responsibility Alowance</option>
				<option value="Entertainment Allowance">Entertainment Allowance</option>
				<option value="Workers Allowance">Workers Allowance</option>
				<option value="Cellphone/Internet Allowance">Cellphone/Internet Allowance</option>
				<option value="Rural/Remote Hardship Allowance">Rural/Remote Hardship Allowance</option>
				<option value="Rural Hardship Allowance">Double Class Allowance</option>
				<option value="Education/Development Allowance">Education/Development Allowance</option>
			</select></td>
			<td><input type="number" name="amount[]" id="amountgross" class="submit" style="width: 150px" value="<?php echo $amount[4]; ?>"/></td>
			<td style="width:150px;"><select name="taxed[]" style="width: 150px"> 
				<?php if($taxed[4] == ''){ echo '<option value="">-Choose Tax Type-</option>'; } else {  echo '<option value="'.$taxed[4].'">'.$taxed[4].'</option>'; } ?>
				<option value="PAYE">PAYE</option>
				<option value="NHIMA">NHIMA</option>
				<option value="NAPSA">NAPSA</option>
				<option value="PAYE,NHIMA">PAYE,NHIMA</option>
				<option value="NHIMA,NAPS">NHIMA,NAPSA</option>
				<option value="PAYE,NHIMA,NAPSA">PAYE,NHIMA,NAPSA</option>
				<option value="">Not Taxed</option>
			</select></td>
			<td style="width:50px;"><input type="checkbox" name="monthly[]" id="budget" class="submit" style="width: 30px" value="<?php echo $monthly[4]; ?>"/></td>
		</tr>
		
	</table>

	<input type="submit" name="submit" value="Save Contract" id="submit" class="submit" style="width: 260px"/>
</form>
