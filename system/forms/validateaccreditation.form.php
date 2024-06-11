<form id="accredval" name="accredval" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/accreditation/savecertfile">
	<p><b>Please enter the following information</b></p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="360" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>

              <!-- <tr>
                <td><strong></strong></td>
                <td>
                  <input type="text" name="refnumb" value="<?php echo $referenceNumber?>" style="border-radius: 4px;" required hidden/>
		            </td>
              </tr> -->

              <tr>
                <td><strong>Accreditation Date </strong></td>
                <td>
                  <input type="date" name="apdate" id="apdate" required/>
		            </td>
              </tr>
              <input type="hidden" name="uniqueID" value="<?php echo $uniqueID; ?>" style="border-radius: 4px;"/>
              <tr>
                <td><strong>Unique ID </strong></td>
                <td>
                  <input type="text" name="tempid" value="<?php echo $uniqueID; ?>" style="border-radius: 4px;" disabled/>
		            </td>
              </tr>

              <tr>
                <td><strong>File Name </strong></td>
                <td>
                  <input type="text" name="name" value="" style="border-radius: 4px;" required/>
		</td>
              </tr>


              <tr>
                <td><strong></strong></td>
                <td>
                  <input type="hidden" name="accreditor" value="<?php echo $accreditorID?>" style="border-radius: 4px;" required/>
		            </td>
              </tr>

              <tr>
                <td><strong></strong></td>
                <td>
                  <input type="hidden" name="study" value="<?php echo $StudyID?>" style="border-radius: 4px;" required/>
		            </td>
              </tr>


              <tr>
                <td><strong>File Attachment</strong></td>
                <td>
                  <input type="file" name="file" required style="border-radius: 4px;"> <br>
                </td>
              </tr>

            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" style="border-radius: 4px;" value="Update details" />
        <p>&nbsp;</p>

      </form>
