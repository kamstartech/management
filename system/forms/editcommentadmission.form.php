<script type="text/javascript">
	Aloha.ready( function() {
		var $ = Aloha.jQuery;
		$('.editable').aloha();
	});
</script>

<form id="addcommentadmission" name="addcommentadmission" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/admission/commentsave/" . $this->core->item; ?>">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="200" bgcolor="#EEEEEE"><strong>Description</strong></td>
               </tr>
              <tr>
                <td><strong>New Comment by: </strong></td>
                <td>
                  <input type="hidden" name="owner" value="<?php $owner; ?>"/> <label for="owner"> <?php echo $owner;  ?> </label></td>
                
              </tr>
		<tr>
		<td><strong>Old Comment by : </strong></td>
		<td><label for="dbowner"> <?php echo $dbowner;  ?> </label></td>
	       </tr>	

	       <tr>
		<td><strong>Old Date Commented: </strong></td>
		<td><label for="date"> <?php echo $dbdate;  ?> </label></td>
	       </tr>	
              <tr>
                <td><strong>Comment description</strong></td>
                <td>
			<textarea rows="4" cols="37" class="editable" name="comment"><?php echo $comment;?></textarea>
		  </td>
                <td></td>
              </tr>
            </table>
		<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Update comment" />
        <p>&nbsp;</p>

      </form>