
<form id="appeal" name="appeal" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/missing/save"; ?>">
	<p>Please enter the following information</p>
	<table border="0" cellpadding="5" cellspacing="0">

              <tr>
                <td width="250" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="200" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>

              <tr>
                <td><strong>Course for appeal </strong></td>
                <td>
                   <select name="course" id="course" required>
						<?php echo $courses; ?>
                  </select>
				  </td>
              </tr>


              <tr>
                <td><strong>Reason for appeal</strong></td>
                <td>
                 <select name="reason">
					<option value="Missing result" selected>Missing result</option>
					<option value="Incorrect course" >Incorrect course</option>
					<option value="Change of grade" >Change of grade</option>
					<option value="Change of comment" >Change of comment</option>
					<option value="Script Verification" >Script Verification</option>
				 </select>
		</td>
              </tr>

            <tr>
                <td><strong>Year</strong></td>
                <td>
                  <select name="year" id="year" required>
						<option value="2022">2022</option>
						<option value="2021">2021</option>
                  </select></td>
              </tr>

            <tr>
                <td><strong>Exam Period</strong></td>
                <td>
                  <select name="semester" id="semester" required>
						<option value="1" selected>Semester 1 (Jan-June)</option>
						<option value="2" selected>Semester 2 (Jul-Dec)</option>
                  </select></td>
              </tr>

              <tr>
                <td><strong>Reason for appeal</strong></td>
                <td>
					<textarea rows="4" cols="37" class="editable" name="description" required></textarea>
				</td>
                <td></td>
              </tr>

            </table>
	<br />

		<input type="hidden" value="<?php echo $school; ?>" name="school">
	  <input type="submit" class="submit" name="submit" id="submit" value="Submit Appeal" />
        <p>&nbsp;</p>

      </form>