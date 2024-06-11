<form id="editdiscount" name="editdiscount" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/discount/save/" . $this->core->item; ?>">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="200" bgcolor="#EEEEEE"><strong>Input field</strong></td>
                <td  bgcolor="#EEEEEE"><strong>Description</strong></td>
              </tr>
              <tr>
                <td><strong>Student ID </strong></td>
                <td>
                  <input type="text" name="uid" value="<?php echo $item; ?>" /></td>
                <td>Student ID</td>
              </tr>
              <tr>
                <td><strong>Staff ID</strong></td>
                <td>
                  <select name="sid" id="owner">
					<?php echo $owner; ?>
                  </select></td>
                <td>Functional head of fee</td>
              </tr>
              <tr>
                <td><strong>Percentage</strong></td>
                <td>
                  <input type="number" name="percent" size="20" value="<?php echo $percentage; ?>" /> <input style="margin: 10px; width: 20px;" type="checkbox" name="fees" value="fees"> On fees only
				</td>
                <td></td>
              </tr>
			 <tr>
                <td><strong>Date Awarded</strong></td>
                <td>
                  <input type="date" name="date" size="20" value="<?php echo $date; ?>" />
				  </td>
                <td></td>
              </tr>
             </table>
		<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Update Discount" />
        <p>&nbsp;</p>

      </form>
