<form id="calendar" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/calendar/save/<?php echo $item ?>">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Start Time and Date</strong></td>
                <td>
                  <input type="time" name="stime" value="" />
                  <input type="date" name="sdate" value="" />
		</td>
              </tr>

              <tr>
                <td><strong>End Time and Date</strong></td>
                <td>
                  <input type="time" name="etime" value="" />
                  <input type="date" name="edate" value="" />
		</td>
              </tr>


              <tr>
                <td><strong>Event Title </strong></td>
                <td>
                  <input type="text" name="name" value="" />
		</td>
              </tr>



              <tr>
                <td><strong>Event Location </strong></td>
                <td>
                  <input type="text" name="location" value="" />
		</td>
              </tr>


              <tr>
                <td><strong>Description </strong></td>
                <td>
                  <input type="text" name="description" value="" />
		</td>
              </tr>

            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Create Event" />
        <p>&nbsp;</p>

      </form>
