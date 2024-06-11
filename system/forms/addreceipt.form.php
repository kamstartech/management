
<h1>Upload a Proof of Payment</h1>
<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="">
	<p>After paying with a manual deposit method please upload your receipt here. It will be added to your electronic registry and emailed to accounts.</p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
              <tr>
                <td><strong>Amount </strong></td>
                <td>
                  <input type="number" name="amount" value="" required>
				</td>
              </tr>
              <tr>
                <td><strong>Date </strong></td>
                <td>
                  <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
				</td>
              </tr>
              <tr>
                <td><strong>Bank</strong></td>
                <td>
                  <select name="bank" id="bank">
					<option value="ZANACO Bank">ZANACO Bank</option>
					<option value="Indo Zambia Bank">Indo Zambia Bank</option>
					<option value="First National Bank">First National Bank</option>
					<option value="Zambia Industrial Commercial Bank">Zambia Industrial Commercial Bank</option>
					<option value="Atlas Mara Bank">Atlas Mara Bank</option>
                  </select></td>
              </tr>

              <tr>
                <td><strong>UPLOAD RECEIPT</strong></td>
                <td>
			 <input type="file" name="file" required> <br>
			</td>
            </tr>




            </table>
	<br />

	  <input type="submit" class="submit" name="submit" id="submit" value="SUBMIT RECEIPT" />
        <p>&nbsp;</p>

      </form>
