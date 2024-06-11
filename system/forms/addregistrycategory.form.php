<script type="text/javascript">
	Aloha.ready( function(){
		var $ = Aloha.jQuery;
		$('#description').aloha();
		$('#submit').click(function(){
			$("form:first").submit(); 
		});
	});
</script>

<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/registry/save/category">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Folder Name</strong></td>
                <td>
                  <input type="text" name="name" value="" />
		</td>
              </tr>

              <tr>
                <td><strong>Folder Description </strong></td>
                <td>
                  <input type="text" name="name" value="" />
		</td>
              </tr>
              <tr>
                <td><strong>Access to the item</strong></td>
                <td>
			<select name="roles[]" multiple="multiple" size="10" style="width: 250px">
				 <?php echo $roles; ?>
			</select>
		  </td>
              </tr>



            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Save Document" />
        <p>&nbsp;</p>

      </form>
