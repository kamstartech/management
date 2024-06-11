<div class="heading"><?php echo $this->core->translate("Add payment"); ?></div>
<form id="idsearch" name="paymentadd" method="get" action="<?php echo $this->core->conf['conf']['path']; ?>/payments/save">

<div class="label"><?php echo $this->core->translate("Type of payment"); ?></div>

	<select name="paymenttype" style="width: 260px">
		<option value="" selected>-choose-</option>
		<option value="1">Bank Payment</option>
		<option value="0">Bank Payment VAT EXEMPT</option>
		<option value="10">Cash payment</option>
		<option value="2">Cheque</option>
		<option value="3">Mobile Money</option>
		<option value="5">Direct bank transfer</option>
		<option value="20">CREDIT NOTE</option>
	</select><br />



<div class="label"><?php echo $this->core->translate("Bank"); ?></div>
	<select name="bank" style="width: 260px">
		<option value="0" selected>-choose-</option>
		<option value="8">Cash</option>
		<option value="1">Atlas Mara</option>
		<option value="2">Mobile Money</option>
	</select><br />

	<div class="label"><?php echo $this->core->translate("Client"); ?>:</div>
	<input type="text" name="uidvisible" id="studentid" class="submit" style="width: 260px" value="<?php echo $item; ?>"/>
	<input type="hidden" name="uid" id="uid" class="submit" style="width: 260px" value="<?php echo $item; ?>"/><br />

	<div class="label"><?php echo $this->core->translate("Payment Amount"); ?>:</div>
	<input type="number" name="amount" id="amount" class="submit" style="width: 260px" value="<?php echo $amount; ?>"/> ZMW<br />

	<div class="label"><?php echo $this->core->translate("Payment reference / cheque"); ?>:</div>
	<input type="text" name="reference" id="paymentid" class="submit" style="width: 260px" value="<?php echo $paymentid; ?>"/><br />

	<div class="label"><?php echo $this->core->translate("Payment for"); ?>:</div>
	<input type="text" name="description" id="description" class="submit" style="width: 260px" value="<?php echo $description; ?>"/><br />

	<div class="label"><?php echo $this->core->translate("Date of Payment"); ?>:</div>
	<input type="date" name="date" id="date" class="submit" style="width: 260px" value="<?php echo date('Y-m-d'); ?>"/> YYYY-MM-DD<br />

	<div class="label"><?php echo $this->core->translate("Submit"); ?></div>
	<input type="submit" class="submit" value="<?php echo $this->core->translate("Add Payment"); ?>" style="width: 260px"/>
	<br>


</form>

