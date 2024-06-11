<script type="text/javascript">
	Aloha.ready( function(){
		var $ = Aloha.jQuery;
		$('#description').aloha();
		$('#submit').click(function(){
			$("form:first").submit(); 
		});
	});
</script>

<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path'] . "/registry/save/" . $item; ?>">
	<p>Please enter the following information</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Quote Supplier </strong></td>
                <td>
                  	<select name="supplier"  style="width: 250px">
						 <?php echo $suppliers; ?>
					</select>
				</td> 
              </tr>
              <tr>
                <td><strong>Quote Total</strong></td>
                <td>
			<input type="number" class="input" id="total" name="total"></textarea>
		  </td>
              </tr>
              <tr>
                <td><strong>Quotation file</strong></td>
                <td>
			 <input type="file" name="file" accept="*.pdf,*.doc,*.docx,*.jpg" multiple> <br>
		  </td>
         </tr>
     </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="Save Quotation" />
        <p>&nbsp;</p>

      </form>
