
<form id="appeal" name="appeal" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/records/save/". $item; ?>">
	<p>Please enter the following information</p>
	<table border="0" cellpadding="5" cellspacing="0" width="100%">

              <tr>
                <td width="250" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>

              <tr>
                <td><strong>Title for Formal Record</strong></td>
                <td>
                   <input type="text"  name="reason" id="reason" required>
				  </td>
              </tr>

              <tr>
                <td><strong>Description of Record</strong></td>
                <td>
					<textarea rows="4" cols="37" class="editable" name="description" required></textarea>
				</td>
                <td></td>
              </tr>
			  
			  
              <tr>
                <td><strong>Date of Incident</strong></td>
                <td>
                   <input type="date" name="date" id="date" required>
				  </td>
              </tr>

            </table>
	<br />

		<input type="hidden" value="<?php echo $school; ?>" name="school">
	  <input type="submit" class="submit" name="submit" id="submit" value="Submit formal Record" />
        <p>&nbsp;</p>

      </form>