
<form id="transcript" name="transcript" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/transcript/save"; ?>">
	<p>Please enter the following information</p>
	<table border="0" cellpadding="5" cellspacing="0">

              <tr>
                <td width="250" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="200" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>

              <tr>
                <td><strong> Date Required</strong></td>
                <td>
                   <input type="date" name="date" id="date" required>
				  </td>
              </tr>


              <tr>
                <td><strong>Reason for Application</strong></td>
                <td>
                 <select name="reason">
					<option value="Sponsor" selected>Sponsor needs results</option>
					<option value="Transfer" >Transfer to other university</option>
					<option value="Self" >Record keeping</option>
					<option value="Verification" >External verification</option>
					<option value="Employer" >Employer record</option>
				 </select>
		</td>
              </tr>

            <tr>
                <td><strong>Year Requested</strong></td>
                <td>
                  <select name="year" id="year" required>
						<option value="2022">2022</option>
						<option value="2021">2021</option>
						<option value="2020">2020</option>
						<option value="2019">2019</option>
						<option value="2018">2018</option>
						<option value="2017">2017</option>
						<option value="2016">2016</option>
						<option value="2015">2015</option>
						<option value="2014">2014</option>
						<option value="ALL" SELECTED>ALL YEARS</option>
                  </select></td>
              </tr>

    
            </table>
	<br />

		<input type="hidden" value="<?php echo $school; ?>" name="school">
	  <input type="submit" class="submit" name="submit" id="submit" value="Submit Request" />
        <p>&nbsp;</p>

      </form>