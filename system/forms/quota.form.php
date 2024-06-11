<form id="quota" name="quota" enctype="multipart/form-data"   method="POST" action="<?php echo $this->core->conf['conf']['path']; ?>/quota/save">

<h1>Quota Application Form</h1>
<p>Please enter the following information</p>



	<div id="certheader" class="studentname">Program Choice</div>
	<div class="results formElement" style=" margin-bottom: 20px; ">
	<table width="" height="94" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
			<td width="200" bgcolor="#EEEEEE"><strong>Selection</strong></td>
			<td bgcolor="#EEEEEE"></td>
		</tr>
		<tr>
			<td height="22"><b> First Choice:</b><br></td>
			<td>
				<select name="choiceone" id="mda">
					<option value="141">Bachelor of Medicine and Bachelor of Surgery (MbChb)</option>
					<option value="176">Bachelor of Pharmacy</option>
					<option value="125">Bachelor of Science in Clinical Medicine</option>
					<option value="166">Bachelor of Science in Environmental Health</option>
					<option value="126">Bachelor of Science in Nursing</option>
				</select>
			</td>
		</tr>


		<tr>
			<td height="22"><b>Second Choice:</b><br></td>
			<td>
				<select name="choicetwo" id="mdb">
					<option value="141">Bachelor of Medicine and Bachelor of Surgery (MbChb)</option>
					<option value="176">Bachelor of Pharmacy</option>
					<option value="125">Bachelor of Science in Clinical Medicine</option>
					<option value="166">Bachelor of Science in Environmental Health</option>
					<option value="126">Bachelor of Science in Nursing</option>
				</select>
				</select>
			</td>
		</tr>
	</td>

	</table>
	</div>

	<br>

	<div id="certheader" class="studentname">School certificate examination results</div>
	<div class="results formElement" style=" margin-bottom: 20px; ">
	<p>In this form enter the grades that you have scored in your secondary education.
	These grades will determine if you are elligable to enrol for a quota program.</p>

	<table width="" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>School</strong></td>
                <td>
					<input type="text" name="school" id="school" class="input" required><br />
				</td> 
              </tr>
              <tr>
                <td><strong>Examination Number</strong></td>
                <td>
			<input type="number" class="input" id="number" name="number" required></textarea>
		  </td>
              </tr>
              <tr>
                <td><strong>Grade 12 Certificate (Scans/Photos)</strong></td>
                <td>
			 <input type="file" name="file" accept="*.pdf,*.doc,*.docx,*.jpg" multiple required> (Include all certificates including any GCE)<br>
		  </td>
         </tr>
     </table>
</div>
	<input type="submit" class="submit" value="<?php echo $this->core->translate("Submit Application"); ?>"/>
</form>