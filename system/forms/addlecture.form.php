<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/attendance/save/<?php echo $item ?>">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Lecture Time and Date</strong></td>
                <td>
                  <input type="time" name="time" value="" />
                  <input type="date" name="date" value="" />
		</td>
              </tr>

              <tr>
                <td><strong>Lecture Title </strong></td>
                <td>
                  <input type="text" name="name" value="" />
		</td>
              </tr>

              <tr>
                <td><strong>Lecture Venue </strong></td>
                <td>
                  <input type="text" name="venue" value="" />
		</td>
              </tr>

            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Create Lecture" />
        <p>&nbsp;</p>

      </form>
