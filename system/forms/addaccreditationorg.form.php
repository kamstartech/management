<script type="text/javascript">
	Aloha.ready( function(){
		var $ = Aloha.jQuery;
		$('#description').aloha();
		$('#submit').click(function(){
			$("form:first").submit(); 
		});
	});
</script>

<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/accreditation/saveaccreditor">
	<p><b>Please enter the following information</b></p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Institution Name</strong></td>
                <td>
                  <input type="text" name="name" value="" style="border-radius: 4px;" required/>
		          </td>
              </tr>

              <tr>
                <td><strong>Institution abbreviation </strong></td>
                <td>
                  <input type="text" name="shortname" value="" style="border-radius: 4px;" required/>
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

	  <input type="submit" class="submit" name="submit" id="submit" style="border-radius: 4px;" value="Add Institution" />
        <p>&nbsp;</p>

      </form>
