<h1>Create Performance Indicator</h1>
<p>Use the form below to define a new indicator.</p>
<form id="requestleave" name="requestleave" method = "post" action = "<?php echo $this->core->conf['conf']['path'] . "/performance/save/". $this->core->item; ?>" >

<div class="table-responsive">
<table class="table">
	<tr>
		<td style="width: 200px;">Performance Objective:</td>
		<td><input type="text" id="name" name="name" required> <i>Enter the performance objective.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Performance Indicator:</td>
		<td><textarea name="description" rows="4" cols="50"></textarea></td>
	</tr>
	<tr>
		<td>Maximum Points:</td>
		<td><input type="text" id="points" name="points" required> <i>Maximum points to score.</i></td>
	</tr>
</table>

	
	<div class="label"></div><input type="submit" name="submit" value="Save Changes" id="submit" class="submit" style="width: 100%; padding: 20px !important;"/>
</form>
</div>
   