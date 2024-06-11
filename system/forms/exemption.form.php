<form id="exemption" name="exemption" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path'] . "/exemption/save/".$item."/" . $this->core->subitem; ?>">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Student ID </strong></td>
                <td>
                  <input type="text" name="registryid" value="<?php echo $item; ?>" />
		</td>
              </tr>

              <tr>
                <td><strong>Course ID </strong></td>
                <td>
                  <input type="text" name="course" value="<?php echo $this->core->subitem; ?>" />
		</td>
              </tr>


              <tr>
                <td><strong>Reason for Request</strong></td>
                <td>
                  <input type="text" name="name" value="" />
		</td>
              </tr>
              <tr>
                <td><strong>Evidence for Exemption</strong></td>
                <td>
			 <input type="file" name="file" accept=".pdf,*.doc,*.docx"> <br>
		  </td>
              </tr>



            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Submit request" />
        <p>&nbsp;</p>

      </form>
