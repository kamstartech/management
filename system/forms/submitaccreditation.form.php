<script type="text/javascript">
	Aloha.ready( function(){
		var $ = Aloha.jQuery;
		$('#description').aloha();
		$('#submit').click(function(){
			$("form:first").submit(); 
		});
	});
</script>

<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/accreditation/submit/save">
	<p><b>Please enter the following information</b></p>
  <div class="submit" style="width:30%; border-radius: 4px;"><?php echo $programmeName; echo '<br>'; echo $accredInstitution; echo '<br>';?></div>
	<table width="620" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="360" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>

              <tr>
                <td><strong></strong></td>
                <td>
                  <input type="text" name="accreditor" value="<?php echo $accreditor?>" style="border-radius: 4px;" required hidden/>
		            </td>
              </tr>

              <tr>
                <td><strong></strong></td>
                <td>
                  <input type="text" name="study" value="<?php echo $study?>" style="border-radius: 4px;" required hidden/>
		            </td>
              </tr>

              <tr>
                <td><strong>Accreditation Date </strong></td>
                <td>
                  <input type="date" name="checkinDate" id="checkinDate" required/>
		            </td>
              </tr>

              <tr>
                <td><strong></strong></td>
                <td>
                  <input type="text" name="accreditor" value="<?php echo $AccreditorID?>" style="border-radius: 4px;" required hidden/>
		            </td>
              </tr>

              <tr>
                <td><strong></strong></td>
                <td>
                  <input type="text" name="study" value="<?php echo $StudyID?>" style="border-radius: 4px;" required hidden/>
		            </td>
              </tr>

<!--
              <tr>
                <td><strong>Access to the item</strong></td>
                <td>
			<select name="roles[]" multiple="multiple" size="10" style="width: 250px">
				 <?php echo $roles; ?>
			</select>
		  </td>
              </tr> -->



            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" style="border-radius: 4px;" value="Submit request" />
        <p>&nbsp;</p>

      </form>
