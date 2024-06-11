<script type="text/javascript">
	Aloha.ready( function(){
		var $ = Aloha.jQuery;
		$('#description').aloha();
		$('#submit').click(function(){
			$("form:first").submit(); 
		});
	});
</script>

<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path']; ?>/accreditation/saveaccredrole">
	<p><b>Please enter the following information</b></p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Position assignment</strong></td>
                <td>
                <select name="position" class="form-control" style="width:200px;" required>
                    <?php
                    echo '<option value="">-SELECT ROLE-</option> ';
                    echo '<option value="Coordinator">Coordinator</option>';
                    echo '<option value="Validator">Validator</option>';
                    echo '<option value="Approver">Approver</option>';
                    ?>
				      </select>
		          </td>
              </tr>

              <tr>
                <td><strong>New user </strong></td>
                <td>
                      <select name="uid" class="form-control" style="width:200px;" required>
                      <?php
                          $sql = "SELECT CONCAT(`basic-information`.`FirstName`,' ',`basic-information`.`Surname`) AS 'Name', `basic-information`.`ID` FROM `basic-information` WHERE `basic-information`.`Status` = 'Employed' ";
                          $run = $this->core->database->doSelectQuery($sql);
                          $users .= '<option value="">PLEASE SELECT</option>';
                          while ($row = $run->fetch_assoc()) {
                            $users .= '<option value="'.$row["ID"].'">'.$row["Name"].'</option>';
                          }
                          echo $users;
                      ?>
                      </select>
		            </td>
              </tr>

            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" style="border-radius: 4px;" value="Add user" />
        <p>&nbsp;</p>

      </form>
