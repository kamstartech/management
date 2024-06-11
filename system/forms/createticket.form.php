<form id="sendmessage" name="sendmessage" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/helpdesk/send/" . $this->core->item; ?>">
	<p>Please enter the following information</p>
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td width="" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
			<td width="" bgcolor="#EEEEEE"><strong>Input field</strong></td>
		</tr>
		<tr>
			<td width="250px;"><b>Subject for your ticket</b><br>Example: Missing Results </td>
			<td>
				<input type="input" name="title" style="width: 100%;" required>
					
			</td>
			
		</tr>
		<tr>
			<td><b>Type of problem</b><br>Select from the dropdown </td>
			<td>
				<select name="recipient" style="width:100%" onchange="schoolCheck(this)" required>
					<option value=""style="font-weight: bold;">SELECT HERE</option>
					<option value="" style="font-weight: bold;" disabled>Academic Office</option>
						<option value="580">&nbsp &nbsp &nbsp Registration Problem</option>
						<option value="580">&nbsp &nbsp &nbsp Change of Personal Details</option>
						<option value="580">&nbsp &nbsp &nbsp Request for Results Transcript</option>
					<option value=""style="font-weight: bold;" disabled>Accounts Problems</option>
						<option value="581">&nbsp &nbsp &nbsp Incorrect Invoice</option>
						<option value="581">&nbsp &nbsp &nbsp Payment not reflecting</option>
						<option value="581">&nbsp &nbsp &nbsp Request for payment plan</option>
						<option value="581">&nbsp &nbsp &nbsp Bursary Problem</option>
					<option value="" style="font-weight: bold;" disabled>ICT Problems</option>
						<option value="311">&nbsp &nbsp &nbsp Laptop/desktop problem (Staff)</option>
						<option value="713">&nbsp &nbsp &nbsp Network problem</option>
						<option value="1140">&nbsp &nbsp &nbsp Student Information System Problem</option>
						<option value="688">&nbsp &nbsp &nbsp Moodle (eLearning) Problem</option>
						<option value="1">&nbsp &nbsp &nbsp RFC (Request for Change)</option>
					<option value="" style="font-weight: bold;" disabled>School Problems eg. Missing Results</option>
						<option value="703">&nbsp &nbsp &nbsp School of Business</option>
						<option value="756">&nbsp &nbsp &nbsp School of Education</option>
						<option value="593">&nbsp &nbsp &nbsp School of Medicine</option>
						<option value="604">&nbsp &nbsp &nbsp School of Social Sciences</option>
						<option value="625">&nbsp &nbsp &nbsp School of Science Egineering, Technology</option>
						<option value="806">&nbsp &nbsp &nbsp School of Agriculture</option>
					<option value="" style="font-weight: bold;" disabled>Dean of Students</option>
						<option value="383">&nbsp &nbsp &nbsp Accommodation Problem</option>
						<option value="548">&nbsp &nbsp &nbsp Sexual Abuse</option>
						<option value="383">&nbsp &nbsp &nbsp Food Problem</option>
					<option value="" style="font-weight: bold;" disabled>Registrar</option>
						<option value="813">&nbsp &nbsp &nbsp Occupational Health or Safety Problem</option>
						<option value="813">&nbsp &nbsp &nbsp Workplace Conflict</option>
				</select>
				<input type="hidden" name="mainproblem" id="mainproblem" value="">
			</td>
		</tr>
		<tr id="schoolIssue" style="display: none;">
			<td><b>School Related Problem</b><br>Select from the dropdown </td>
			<td>
				<select name="schoolproblem" style="width:100%; padding-left: 20px;">
					<option value=""style="font-weight: bold;">SPECIFY SCHOOL PROBLEM HERE</option> 
						<option value="Missing Result">Missing Result</option>
						<option value="Registration Not Approved">Registration Not Approved</option>
						<option value="Registration Problem">Registration Problem</option>
						<option value="No Course Materials on Moodle">No Course Materials on Moodle</option>
						<option value="Lecturer not Teaching">Lecturer not Teaching</option>
						<option value="Delayed Feedback from Lecturer">Delayed Feedback from Lecturer</option>
						<option value="CA Problem">CA Problem</option>
						<option value="Request Remarking">Request Remarking (K500 fee)</option>
						<option value="Graduating student problem">Graduating student problem</option>
						<option value="Withdraw from program">Withdraw from program</option>
				</select>
			</td>
			
		</tr>
		<tr>
			<td><b>Ticket information</b><br>Write a description on what the problem is. Be as specific as possible. </td>
			<td>
				<textarea rows="4" cols="37" style="width: 100%;" class="editable" name="message" required></textarea>
			</td>
			
		</tr>
		<tr>
			<td><strong>SUBMIT </strong></td>
			<td>
				<input type="submit" class="submit" name="submit" id="submit" value="Create ticket" style="font-weight: bold; font-size: 14px;" />
			</td>
		</tr>
	</table>
	<br />

	
	<p>&nbsp;</p>

</form>

<script>
function schoolCheck(that) {
	document.getElementById("mainproblem").value = that.options[that.selectedIndex].text;
    if (that.value == "703" || that.value == "756" || that.value == "593" || that.value == "604" || that.value == "625" || that.value == "806") {
        document.getElementById("schoolIssue").style.display = "contents";
    } else {
        document.getElementById("schoolIssue").style.display = "none";
    }
}
</script>