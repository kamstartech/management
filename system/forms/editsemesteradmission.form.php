<script type="text/javascript">
	Aloha.ready( function() {
		var $ = Aloha.jQuery;
		$('.editable').aloha();
	});
</script>

<form id="addcommentadmission" name="addcommentadmission" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/admission/applicantsemestersave/" . $this->core->item; ?>">
<input type="hidden" name="id" value="update-account">
<input type="hidden" name="studentid" id="studentid" value="<?php echo $studentid; ?>"/>

<?php echo '
	<div style="padding: 20px; border: solid 1px #ccc;">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="200" bgcolor="#EEEEEE"><strong>Input fields</strong></td>
		<td width="200" bgcolor="#EEEEEE"><strong>Description</strong></td>

               </tr>
             <tr>
		<td><strong>Applicant Year: </strong></td>
		<td>
		<select name="year" id="year">
			<option value="'.$year.'"> '.$year.' </option>
			<option value="2020">2020</option>
			<option value="2021">2021</option>
			<option value="2022">2022</option>
			<option value="2023">2023</option>
			<option value="2024">2024</option>
		</select>
		</td>
		<td>Current Year:<label> '.$year.' </label></td>
	       </tr>	
	       <tr>
		<td><strong>Applicant Semester: </strong></td>
		<td>
		<select name="semester" id="semester">
			<option value="'. $semester .'">'.$semester.'</option>
			<option value="1">1</option>
			<option value="2">2</option>
		</select>
		</td>
		<td>Current Semester:<label>'.$semester.' </label></td>

	       </tr>	
          </table>
		<br/>
	  </div>
	        <br/>
	  <center><input type="submit" class="submit" name="submit" id="submit" value="Update semester" onclick="return confirm(\'Are you sure you want to change the applicants year or semester of study?\')"/></center>
        <p>&nbsp;</p>'
 ?>
      </form>