<script type="text/javascript">
	Aloha.ready( function(){
		var $ = Aloha.jQuery;
		$('#description').aloha();
		$('#submit').click(function(){
			$("form:first").submit(); 
		});
	});
</script>

<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/library/save/category">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Category Name</strong></td>
                <td>
                  <input type="text" name="name" value="" />
		</td>
              </tr>

              <tr>
                <td><strong>Category Description </strong></td>
                <td>
                  <input type="text" name="name" value="" />
		</td>
              </tr>
            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Save Category" />
        <p>&nbsp;</p>

      </form>
