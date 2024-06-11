
<form id="appeal" name="appeal" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/missing/save/response"; ?>">
	<p>Please enter the following information</p>
	<table border="0" cellpadding="5" cellspacing="0">

              <tr>
                <td width="250" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="200" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Response to student</strong></td>
                <td>
                  <select name="response">
                  <option value="Results unavailable due to non-payment">Results unavailable due to non-payment</option>
                  <option value="Senate decision maintained">Senate decision maintained</option>
                   <option value="Results found and updated">Results found and updated</option>
                    <option value="Scripts remarked and results updated">Scripts remarked and results updated</option>
                     </select>
					
			<input type="hidden" name="appeal" value="<?php echo $item; ?>">
				</td>
                <td></td>
              </tr>

            </table>
	<br />

		<input type="hidden" value="<?php echo $school; ?>" name="school">
	  <input type="submit" class="submit" name="submit" id="submit" value="Submit response" />
        <p>&nbsp;</p>

      </form>