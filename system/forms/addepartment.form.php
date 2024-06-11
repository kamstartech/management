<h1>Create Department</h1>
<p>Use the form below to define a new department.</p>
<form id="requestleave" name="requestleave" method = "post" action = "<?php echo $this->core->conf['conf']['path'] . "/departments/save/". $this->core->item; ?>" >

<div class="table-responsive">
<table class="table">
	<tr>
		<td style="width: 200px;">Department Name:</td>
		<td><input type="text" id="name" name="name" value="<?php echo $name; ?>" required> <i>Short name for department.</i></td>
	</tr>
	<tr>
		<td style="width: 200px;">Description of Department:</td>
		<td><input type="text" id="description" name="description"  value="<?php echo $description; ?>"  required> <i>Description of department function.</i></td>
	</tr>
	<tr>
		<td>Department Managed by:</td>
		<td>
			<select name="managed" style="width: 250px; margin-right: -10px;" class="select" required> 
				<?php echo $staff; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Department is under:</td>
		<td>
			<select name="under" style="width: 250px; margin-right: -10px;" class="select" required> 
				<?php echo $departments; ?>
			</select>
		</td>
	</tr>
</table>

	
	<div class="label"></div><input type="submit" name="submit" value="Create Department" id="submit" class="submit" style="width: 100%; padding: 20px !important;"/>
</form>
</div>
   