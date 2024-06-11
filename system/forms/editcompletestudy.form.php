<script type="text/javascript">

jQuery(document).ready(function(){

	jQuery(function() {
		jQuery('.datepicker').datepicker({
			dateFormat : 'yy-mm-dd'
		});
	});	

	jQuery('select').ddslick({width:400, height:300,
	    onSelected: function(selectedData){
	        console.log(selectedData.selectedData.text);
	    }
	});

});

</script>

<form id="addcompletestudy" name="addcompletestudystudy" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/studies/completesave/" . $this->core->item; ?>">
	<p>This form creates an entire for the total count of courses needed to compelete a specific program.
	</p>

	<p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
			<td width="300" bgcolor="#EEEEEE"><strong>Input field</strong></td>
			
		</tr>

		<tr>
			<td>Program</td>
			<td>
					<?php echo '<b>'.$programName.' - '. $programcode.'</b>'; ?>
				</td>
			<td></td>
		</tr>
		<tr>
			<td>Number of courses needed</td>
			<td><b><input name="coursescount" type="text" value="<?php echo $total_count;?>" style="width:100px"> courses</b></td>
			<td></td>
		</tr>
		

		<tr>
			<td></td>
			<td>
			</td>
			<td></td>
		</tr>
	</table>
	</p><input type="submit" class="submit" name="submit" id="submit" value="Edit Count"/>
</form>
