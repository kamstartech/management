<script type="text/javascript">
	Aloha.ready( function() {
		var $ = Aloha.jQuery;
		$('.editable').aloha();
	});
</script>
<form id="calendar" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/calendar/save/<?php echo $item ?>">
	<p>Please enter the following information</p>
	<input type="hidden" name="item" value="<?php echo $item; ?>" />
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Start Time and Date</strong></td>
                <td>
                  <input type="time" name="stime" value="<?php echo date('H:i:s',$starttime); ?>" />
                  <input type="date" name="sdate" value="<?php echo date('Y-m-d',$startdate); ?>" />
		</td>
              </tr>

              <tr>
                <td><strong>End Time and Date</strong></td>
                <td>
                  <input type="time" name="etime" value="<?php echo date('H:i:s',$endtime); ?>" />
                  <input type="date" name="edate" value="<?php echo date('Y-m-d',$enddate); ?>" />
		</td>
              </tr>


              <tr>
                <td><strong>Event Title </strong></td>
                <td>
                  <input type="text" name="name" value="<?php echo $name; ?>" />
		</td>
              </tr>



              <tr>
                <td><strong>Event Location </strong></td>
                <td>
                  <input type="text" name="location" value="<?php echo $location; ?>" />
		</td>
              </tr>


              <tr>
                <td><strong>Description </strong></td>
                <td>
                  <input type="text" name="description" value="<?php echo $description; ?>" />
		</td>
              </tr>

            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Update Event" />
        <p>&nbsp;</p>

      </form>
