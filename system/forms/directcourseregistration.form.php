<form id="addcourse" name="addcourse" method="post" action="<?php echo $this->core->conf['conf']['path']; ?>/register/directsave/">
	<p>Please enter the following information</p>
                  <input type="hidden" name="uid" value="<?php echo $this->core->item; ?>" /></td>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="200" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Select Course</strong></td>
                <td>
                  <select name="course" id="course">
					<?php echo $courses; ?>
                  </select></td>
              </tr>
                <tr>
                <td><strong>Select Term</strong></td>
                <td>
                  <select name="period" id="period">
					<?php echo $periods; ?>
                  </select></td>
              </tr>
  
            </table>
		<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Add Course" />
        <p>&nbsp;</p>

      </form>
