<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('select').ddslick({width:280, height:300,
	    onSelected: function(selectedData){
	        console.log(selectedData.selectedData.text);
	    }
	});
});
</script>
<h1>Sponsor Information</h1>
<form id="adduser" name="adduser" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/contact/save/" . $this->core->item; ?>">
<p>Please add a sponsor to your account</p>
<table cellspacing="0">
<tr>
<td>
<table width="768" height="465" border="0" cellpadding="5" cellspacing="0">
<tr>
	<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
	<td width="200" bgcolor="#EEEEEE"><strong>Input field</strong></td>
	<td bgcolor="#EEEEEE"><strong>Description</strong></td>
</tr>

<tr>
	<td><strong>Type of Sponsor</strong></td>
	<td>
		<select name="relation" id="relation" required>
						<option value="" selected="selected">SELECT RELATIONSHIP</option>
						<option value="Spouse">Self Sponsored</option>
						<option value="Spouse">Spouse</option>
						<option value="Parent">Parent</option>
						<option value="Guardian">Legal Guardian</option>
						<option value="NGO">NGO</option>
						<option value="Employer">Employer</option>
						<option value="Family">Other Family</option>
		</select></td>
	<td>&nbsp;</td>
</tr>

<tr>
	<td height="19"><strong> Name</strong></td>
	<td>
		<input type="text" name="name" required></td>
	<td>Sponsor given name or company</td>
</tr>
<tr>
	<td><strong>Streetname / Plot number</strong></td>
	<td>
		<input type="text" name="streetname" id="textfield77" required></td>
	<td>For example: Jambo drive 115</td>
</tr>
<tr>
	<td><strong>P.O Box</strong></td>
	<td>
		<input type="text" name="postalcode" id="textfield78" required></td>
	<td>For example: P.O Box 2169</td>
</tr>
<tr>
	<td><strong>City/Town</strong></td>
	<td>
		<input type="text" name="town" id="town" required></td>
	<td></td>
</tr>
<tr>
<td><strong>Country</strong></td>
<td>
<select name="country" id="country">
<option value="Zambia">Zambia</option>
<option value="USA">USA</option>
<option value="UK">UK</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua">Antigua</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Barbuda">Barbuda</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bonaire">Bonaire</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="Virgin islands">British Virgin isl.</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman isl">Cayman Islands</option>
<option value="Central African Rep">Central African Rep.</option>
<option value="Chad">Chad</option>
<option value="Channel isl">Channel Islands</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Colombia">Colombia</option>
<option value="Congo">Congo</option>
<option value="cook isl">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Croatia">Croatia</option>
<option value="Curacao">Curacao</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="ethiopia=">Ethiopia</option>
<option value="Faeroe isl">Faeroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Gemany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="GB">Great Britain</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guinea Bissau">Guinea Bissau</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Irak">Irak</option>
<option value="Iran">Iran</option>
<option value="Ireland">Ireland</option>
<option value="Northern Ireland">Ireland, Northern</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Ivory Coast">Ivory Coast</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan&quot;">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kuwait&quot;">Kuwait</option>
<option value="Kyrgyzstan&quot;">Kyrgyzstan</option>
<option value="Latvia&quot;">Latvia</option>
<option value="Lebanon&quot;">Lebanon</option>
<option value="Liberia">Liberia</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malawi">Malawi</option>
<option value="Malaysia">Malaysia</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall isl">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mexico">Mexico</option>
<option value="Micronesia">Micronesia</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar/Burma</option>
<option value="Namibia">Namibia</option>
<option value="Nepal">Nepal</option>
<option value="Netherlands">Netherlands</option>
<option value="Netherlands Antilles">Netherlands Antilles</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="" palau="Palau">Palau</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Philippines">Philippines</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Reunion">Reunion</option>
<option value="Rwanda">Rwanda</option>
<option value="Saba">Saba</option>
<option value="Saipan">Saipan</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Scotland">Scotland</option>
<option value="Senegal">Senegal</option>
<option value="seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovac Republic">Slovak Republic</option>
<option value="Slovenia">Slovenia</option>
<option value="South Africa">South Africa</option>
<option value="South Korea">South Korea</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Taiwan">Taiwan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Trinidad-Tobago">Trinidad-Tobago</option>
<option value="Tunesia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="United Arab Emirates">United Arab Emirates</option>
<option value="U.S. Virgin isl">U.S. Virgin Islands</option>
<option value="USA">U.S.A.</option>
<option value="Uganda">Uganda</option>
<option value="United Kingdom">United Kingdom</option>
<option value="Urugay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City">Vatican City</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="Wales">Wales</option>
<option value="Yemen">Yemen</option>
<option value="Zaire">Zaire</option>
<option value="Zambia" selected="selected">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
</select></td>
<td>&nbsp;</td>
</tr>
<tr>
	<td><strong>Phone Number</strong></td>
	<td>
		<input type="text" name="celphone" required></td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td><strong>Email Address</strong></td>
	<td>
		<input type="text" name="email" id="textfield87"></td>
	<td>Optional (Yahoo, Hotmail, Gmail, etc)</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<br>
<input type="submit" class="register" name="submit-registrar" id="submit-registrar" value="Save Sponsor Contact"/>

<p>&nbsp;</p>

</form>