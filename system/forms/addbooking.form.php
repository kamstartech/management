<form id="addbooking" name="addbooking" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/accommodation/booking/save" . $this->core->item; ?>">
<p>Create booking period</p>
<table cellspacing="0">
<tr>
<td>
<table width="500" border="0" cellpadding="5" cellspacing="0">
<tr>
	<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
	<td width="200" bgcolor="#EEEEEE"><strong>Input field</strong></td>
</tr>

<tr>
	<td><strong>Select study type</strong></td>
	<?php
		if($item == 3){
			echo 
			'<td>
			<select name="studytype" id="studytype">
				<option value="3">Undergraduate</option>
				
			</select></td>
			<td>&nbsp;</td>';
		}else{
			echo 
			'<td>
			<select name="studytype" id="studytype">
				
				<option value="5">Post-graduate</option>
			</select></td>
			<td>&nbsp;</td>';
		}
		
	?>
</tr>
<tr>
	<td><strong>Booking opening date </strong></td>
	<td>
		<input type="date" name="openDate" id="openDate" required/></td>
</tr>
<tr>
	<td><strong>Booking closing date</strong></td>
	<td>
		<input type="date" name="closeDate" required/></td>
</tr>


</table>
</td>
</tr>
</table>

<p>&nbsp;</p>

<input type="submit" class="register" name="open-booking" id="open-booking" value="Open Booking"/>

<p>&nbsp;</p>

</form>