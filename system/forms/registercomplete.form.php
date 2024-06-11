<div id="studentheader" class="studentname"><?php $count=1; echo $count; ?> - Student Details</div>

<script>
$( "#studentheader" ).click(function() {
$( ".studentdetails" ).slideToggle( "slow" );
$( ".results" ).slideUp( "slow" );
$( ".educationalrecords" ).slideUp( "slow" );
$( ".emergencycontacts" ).slideUp( "slow" );
$( ".programdetails" ).slideUp( "slow" );
});
</script>

<?php $countsub = 1; ?>

<div class="studentdetails formElement" style="display: none; margin-bottom: 20px;">
	<p>In this section you will provide basic information needed for your enrolment.</p>

	<table width="768" border="0" cellpadding="5" cellspacing="0">
	<tr>
		<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
		<td width="200" bgcolor="#EEEEEE"><strong>Input fields</strong></td>
		<td bgcolor="#EEEEEE"><strong>Description</strong></td>
	</tr>
	<?php
		echo '<tr> 
		<td><strong>'.$count.'.'.$countsub.' - Student number</strong></td>
		<td>
		<input type="text" name="studentno" id="studentno" value="'.$userID.'" readonly/>
		</td>
		</tr>';
	?>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> National Registration Number</strong></td>
		<td>
			<?php
				echo'<input type="text" name="studentid" id="nrc" pattern="[0-9]{6}[/]{1}[0-9]{2}[/]{1}[1]{1}|[A-Z]{2}[0-9]{7}" title="Must be entered in the NRC format i.e 111111/11/1 or Zambian Passport format i.e AA1111111" value="'.$nrc.'" required/>';
			?>
		</td>
		<td>
			<div id="status">
			Please enter the ID number provided on your National Identification Card or passport
			</div>
		</td>
	</tr>
	<?php if($role == 5){
				$nrcmust = 'required';
			}
		if ($filelocation) {
		echo '	<tr style="background-color:#00ff00">
					<td height="22"><strong> Scan of NRC/ Passport</strong></td>
					<td>
						<input type="file" name="nrcupload" id="nrcupload" accept="image/*"/>
					</td>
					<td><a href="'.$this->core->conf['conf']['path']. '/registry/show/' . $userID.'">View Uploaded File</a></td>
				</tr>';
		} else {
			echo '	<tr style="background-color:#ff3333">
						<td height="22"><strong> Scan of NRC/ Passport</strong></td>
						<td>
							<input type="file" name="nrcupload" id="nrcupload" data-pattern-name="education[++][upload]" data-pattern-id="education_++_upload" '.$nrcmust.'/>
						</td>
						<td>Upload the NRC/Passort.</td>
					</tr>';
		} ?>
		
	
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Surname </strong></td>
		<td>
			<input type="text" name="surname" value="<?php echo $surname ?>" required/></td>
		<td>Your family name</td>
	</tr>
	<tr>
		<td height="19"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> First Name</strong></td>
		<td>
			<input type="text" name="firstname" value="<?php echo $firstname ?>" required/></td>
		<td>Your given name</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Middle name</strong></td>
		<td>
			<input type="text" name="middlename" value="<?php echo $middlename ?>"/></td>
		<td>Optional</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Sex (Gender)</strong></td>
		<td>
			<select name="sex" id="gender">
				<option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
				<option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
				<option value="Unknown" <?php if ($gender == 'Unknown') echo 'selected'; ?>>Other</option>
			</select></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Date of Birth</strong></td>
		<td>
			<input type="date" name="day" value="<?php echo $dob ?>" required/>
		</td>

		<td></td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Nationality</strong></td>
		<td>
			<select name="nationality" id="nationality">
				<option value="zambian" selected="selected">Zambian</option>
				<option value="Other">Other</option>
				<option value="afghan">Afghan</option>
				<option value="albanian">Albanian</option>
				<option value="algerian">Algerian</option>
				<option value="american">American</option>
				<option value="andorran">Andorran</option>
				<option value="angolan">Angolan</option>
				<option value="antiguans">Antiguans</option>
				<option value="argentinean">Argentinean</option>
				<option value="armenian">Armenian</option>
				<option value="australian">Australian</option>
				<option value="austrian">Austrian</option>
				<option value="azerbaijani">Azerbaijani</option>
				<option value="bahamian">Bahamian</option>
				<option value="bahraini">Bahraini</option>
				<option value="bangladeshi">Bangladeshi</option>
				<option value="barbadian">Barbadian</option>
				<option value="barbudans">Barbudans</option>
				<option value="batswana">Batswana</option>
				<option value="belarusian">Belarusian</option>
				<option value="belgian">Belgian</option>
				<option value="belizean">Belizean</option>
				<option value="beninese">Beninese</option>
				<option value="bhutanese">Bhutanese</option>
				<option value="bolivian">Bolivian</option>
				<option value="bosnian">Bosnian</option>
				<option value="brazilian">Brazilian</option>
				<option value="british">British</option>
				<option value="bruneian">Bruneian</option>
				<option value="bulgarian">Bulgarian</option>
				<option value="burkinabe">Burkinabe</option>
				<option value="burmese">Burmese</option>
				<option value="burundian">Burundian</option>
				<option value="cambodian">Cambodian</option>
				<option value="cameroonian">Cameroonian</option>
				<option value="canadian">Canadian</option>
				<option value="cape verdean">Cape Verdean</option>
				<option value="central african">Central African</option>
				<option value="chadian">Chadian</option>
				<option value="chilean">Chilean</option>
				<option value="chinese">Chinese</option>
				<option value="colombian">Colombian</option>
				<option value="comoran">Comoran</option>
				<option value="congolese">Congolese</option>
				<option value="costa rican">Costa Rican</option>
				<option value="croatian">Croatian</option>
				<option value="cuban">Cuban</option>
				<option value="cypriot">Cypriot</option>
				<option value="czech">Czech</option>
				<option value="danish">Danish</option>
				<option value="djibouti">Djibouti</option>
				<option value="dominican">Dominican</option>
				<option value="dutch">Dutch</option>
				<option value="east timorese">East Timorese</option>
				<option value="ecuadorean">Ecuadorean</option>
				<option value="egyptian">Egyptian</option>
				<option value="emirian">Emirian</option>
				<option value="equatorial guinean">Equatorial Guinean</option>
				<option value="eritrean">Eritrean</option>
				<option value="estonian">Estonian</option>
				<option value="ethiopian">Ethiopian</option>
				<option value="fijian">Fijian</option>
				<option value="filipino">Filipino</option>
				<option value="finnish">Finnish</option>
				<option value="french">French</option>
				<option value="gabonese">Gabonese</option>
				<option value="gambian">Gambian</option>
				<option value="georgian">Georgian</option>
				<option value="german">German</option>
				<option value="ghanaian">Ghanaian</option>
				<option value="greek">Greek</option>
				<option value="grenadian">Grenadian</option>
				<option value="guatemalan">Guatemalan</option>
				<option value="guinea-bissauan">Guinea-Bissauan</option>
				<option value="guinean">Guinean</option>
				<option value="guyanese">Guyanese</option>
				<option value="haitian">Haitian</option>
				<option value="herzegovinian">Herzegovinian</option>
				<option value="honduran">Honduran</option>
				<option value="hungarian">Hungarian</option>
				<option value="icelander">Icelander</option>
				<option value="indian">Indian</option>
				<option value="indonesian">Indonesian</option>
				<option value="iranian">Iranian</option>
				<option value="iraqi">Iraqi</option>
				<option value="irish">Irish</option>
				<option value="israeli">Israeli</option>
				<option value="italian">Italian</option>
				<option value="ivorian">Ivorian</option>
				<option value="jamaican">Jamaican</option>
				<option value="japanese">Japanese</option>
				<option value="jordanian">Jordanian</option>
				<option value="kazakhstani">Kazakhstani</option>
				<option value="kenyan">Kenyan</option>
				<option value="kittian and nevisian">Kittian and Nevisian</option>
				<option value="kuwaiti">Kuwaiti</option>
				<option value="kyrgyz">Kyrgyz</option>
				<option value="laotian">Laotian</option>
				<option value="latvian">Latvian</option>
				<option value="lebanese">Lebanese</option>
				<option value="liberian">Liberian</option>
				<option value="libyan">Libyan</option>
				<option value="liechtensteiner">Liechtensteiner</option>
				<option value="lithuanian">Lithuanian</option>
				<option value="luxembourger">Luxembourger</option>
				<option value="macedonian">Macedonian</option>
				<option value="malagasy">Malagasy</option>
				<option value="malawian">Malawian</option>
				<option value="malaysian">Malaysian</option>
				<option value="maldivan">Maldivan</option>
				<option value="malian">Malian</option>
				<option value="maltese">Maltese</option>
				<option value="marshallese">Marshallese</option>
				<option value="mauritanian">Mauritanian</option>
				<option value="mauritian">Mauritian</option>
				<option value="mexican">Mexican</option>
				<option value="micronesian">Micronesian</option>
				<option value="moldovan">Moldovan</option>
				<option value="monacan">Monacan</option>
				<option value="mongolian">Mongolian</option>
				<option value="moroccan">Moroccan</option>
				<option value="mosotho">Mosotho</option>
				<option value="motswana">Motswana</option>
				<option value="mozambican">Mozambican</option>
				<option value="namibian">Namibian</option>
				<option value="nauruan">Nauruan</option>
				<option value="nepalese">Nepalese</option>
				<option value="new zealander">New Zealander</option>
				<option value="ni-vanuatu">Ni-Vanuatu</option>
				<option value="nicaraguan">Nicaraguan</option>
				<option value="nigerien">Nigerien</option>
				<option value="north korean">North Korean</option>
				<option value="northern irish">Northern Irish</option>
				<option value="norwegian">Norwegian</option>
				<option value="omani">Omani</option>
				<option value="pakistani">Pakistani</option>
				<option value="palauan">Palauan</option>
				<option value="panamanian">Panamanian</option>
				<option value="papua new guinean">Papua New Guinean</option>
				<option value="paraguayan">Paraguayan</option>
				<option value="peruvian">Peruvian</option>
				<option value="polish">Polish</option>
				<option value="portuguese">Portuguese</option>
				<option value="qatari">Qatari</option>
				<option value="romanian">Romanian</option>
				<option value="russian">Russian</option>
				<option value="rwandan">Rwandan</option>
				<option value="saint lucian">Saint Lucian</option>
				<option value="salvadoran">Salvadoran</option>
				<option value="samoan">Samoan</option>
				<option value="san marinese">San Marinese</option>
				<option value="sao tomean">Sao Tomean</option>
				<option value="saudi">Saudi</option>
				<option value="scottish">Scottish</option>
				<option value="senegalese">Senegalese</option>
				<option value="serbian">Serbian</option>
				<option value="seychellois">Seychellois</option>
				<option value="sierra leonean">Sierra Leonean</option>
				<option value="singaporean">Singaporean</option>
				<option value="slovakian">Slovakian</option>
				<option value="slovenian">Slovenian</option>
				<option value="solomon islander">Solomon Islander</option>
				<option value="somali">Somali</option>
				<option value="south african">South African</option>
				<option value="south korean">South Korean</option>
				<option value="spanish">Spanish</option>
				<option value="sri lankan">Sri Lankan</option>
				<option value="sudanese">Sudanese</option>
				<option value="surinamer">Surinamer</option>
				<option value="swazi">Swazi</option>
				<option value="swedish">Swedish</option>
				<option value="swiss">Swiss</option>
				<option value="syrian">Syrian</option>
				<option value="taiwanese">Taiwanese</option>
				<option value="tajik">Tajik</option>
				<option value="tanzanian">Tanzanian</option>
				<option value="thai">Thai</option>
				<option value="togolese">Togolese</option>
				<option value="tongan">Tongan</option>
				<option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
				<option value="tunisian">Tunisian</option>
				<option value="turkish">Turkish</option>
				<option value="tuvaluan">Tuvaluan</option>
				<option value="ugandan">Ugandan</option>
				<option value="ukrainian">Ukrainian</option>
				<option value="uruguayan">Uruguayan</option>
				<option value="uzbekistani">Uzbekistani</option>
				<option value="venezuelan">Venezuelan</option>
				<option value="vietnamese">Vietnamese</option>
				<option value="welsh">Welsh</option>
				<option value="yemenite">Yemenite</option>
				<option value="zambian" selected="selected">Zambian</option>
				<option value="zimbabwean">Zimbabwean</option>
			</select></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Streetname and number</strong></td>
		<td>
			<input type="text" name="streetname" id="streetname" value="<?php echo $street ?>"/></td>
		<td>For example: Munkoyo Street 1583</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> P.O Box</strong></td>
		<td>
			<input type="text" name="postalcode" id="postalcode" value="<?php echo $postal ?>"/></td>
		<td>For example: 804040</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> City/Town</strong></td>
		<td>
			<input type="text" name="town" id="town" value="<?php echo $town ?>"/></td>
		<td></td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Phone Number</strong></td>
		<td>
			<input type="text" name="celphone" id="phone" pattern="[0]{1}[0-9]{9}|[0-9]{12}" title="Must be entered in the format 0966554433 or 0777888999" value="<?php echo $celphone ?>"/>
		</td>
		<td>For example: 0978168860</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Email Address</strong></td>
		<td>
			<input type="email" name="email" id="email" value="<?php echo $email ?>"/>
		</td>
		<td>Optional (Yahoo, Hotmail, Gmail, etc)</td>
	</tr>
	<tr>
	<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Country</strong></td>
	<td>
	<select name="country" id="country">
	<option value="<?php echo $country ?>"><?php echo $country ?></option>
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
	<option value="ethiopia">Ethiopia</option>
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
	<option value="Palau">Palau</option>
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
	<option value="Seychelles">Seychelles</option>
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
	<option value="Zambia">Zambia</option>
	<option value="Zimbabwe">Zimbabwe</option>
	</select></td>
	<td>&nbsp;</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Disability</strong></td>
		<td>
			<div style="float:left;"><select name="dissability" id="dissability">
				<?php if (isset($disability) && $disability != '') {
					echo '<option value="'.$disability .'">'.$disability .'</option>';
				}  ?>
					<option value="No">No</option>
					<option value="Yes">Yes</option>
				</select></div>
			<div style="float:left;"><select name="dissabilitytype" id="dissabilitytype">
					<?php if (isset($disabilitytype) && $disabilitytype != '') {
						echo '<option value="'.$disabilitytype .'">'.$disabilitytype .'</option>';
					}  ?>
					<option value="">No Disability</option>
					<option value="blind/part.sight">Blind or partially sighted</option>
					<option value="deaf">Deaf</option>
					<option value="speech">Speech impairment</option>
					<option value="physical">Physical</option>
					<option value="mental">Mental</option>
					<option value="other">Other</option>
				</select></div>
		</td>


		<td></td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Marital Status</strong></td>
		<td>
			<select name="mstatus" id="mstatus">
				<option value="Married" <?php if ($mstatus == 'Married') echo 'selected'; ?>>Married</option>
				<option value="Single" <?php if ($mstatus == 'Single') echo 'selected'; ?>>Single</option>
				<option value="Divorced" <?php if ($mstatus == 'Divorced') echo 'selected'; ?>>Divorced</option>
				<option value="Widowed" <?php if ($mstatus == 'Widowed') echo 'selected'; ?>>Widowed</option>
			</select></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Study Delivery Mode</strong></td>
		<td>
			<select name="studytype" id="studytype">
				<option value="Fulltime" <?php if ($stype == 'Fulltime') echo 'selected'; ?>>Fulltime</option>
				<option value="Partime" <?php if ($stype == 'Partime') echo 'selected'; ?>>Partime</option>
				<option value="Distance" <?php if ($stype == 'Distance') echo 'selected'; ?>>Distance</option>
			</select>
		</td>
		<td>&nbsp;</td>
	</tr>

<?php
	 $countsub++;

	
	if($this->core->role > 10) {
		echo'<tr style="background-color:#F5EF73">
			<td><strong>'. $count .'.'. $countsub . ' -  Select the year of study</strong></td>
			<td>
				
				<select name="yearofstudy" id="yearofstudy">
					<option value="'.$yos.'">Year '.$yos.'</option>
					<option value="1">1st Year</option>
					<option value="2">2nd Year</option>
					<option value="3">3rd Year</option>
					<option value="4">4th Year</option>
				</select>
			</td>
			<td>For exemption purposes</td>
		</tr>';
	} else {
		echo'<input name="yearofstudy" value="'.$yos.'" type="hidden">';
	}
	



	echo'<tr>
		<td><strong>'. $count .'.'. $countsub . ' Please select the examination center location from which you will be taking your examination</strong></td>
		<td>
			<select name="examcenter" id="examcenter">';
			if (isset($examcentre) && $examcentre != '') {
						echo '<option value="'.$examcentre .'">'.$examcentre .'</option>';
			}
	echo	'<option value="Chipata Center">Chipata Center</option>
				<option value="Choma Center">Choma Center</option>
				<option value="Kabwe Center">Kabwe Center</option>
				<option value="Kasama Center">Kasama Center</option>
				<option value="Lusaka Center">Lusaka Center</option>
				<option value="Ndola Center">Ndola Center</option>
			</select>
		</td>
		<td>&nbsp;</td>
	</tr>';

	$sql = "SELECT * FROM `registry` WHERE registry.`Name` = 'Deposit Slip' AND registry.StudentID = '$userID' ";
	$run = $this->core->database->doSelectQuery($sql);
	$i=0;
	if($run->num_rows > 0){
		echo '<tr style="background-color:#00ff00">
			<td height="22"><strong>Scan of Deposit Slip</strong></td>
			<td>
				<input type="file" name="depslip" id="depslip" accept="image/*" />
			</td>
			<td><a href="'.$this->core->conf['conf']['path']. '/registry/show/' . $userID.'">View Uploaded File</a></td>
		</tr>';
	} else {
		echo '<tr style="background-color:#F5EF73">
			<td height="22"><strong>Scan of Deposit Slip</strong></td>
			<td>
				<input type="file" name="depslip" id="depslip" accept="image/*" />
			</td>
			<td>Upload the proof of payment.</td>
		</tr>';
	}
?>
<!-- 
<tr style="background-color:#F5EF73">
	<td height="22"><strong>Scan of Deposit Slip</strong></td>
	<td>
		<input type="file" name="depslip" id="depslip" accept="image/*" />
	</td>
	<td>Upload the proof of payment.</td>
</tr> -->
	<!-- <tr>
		<td><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?>  Student Lodging?</strong></td>
		<td>
			<select name="payment" id="payment">
				<?php //echo $paymenttypes; ?>
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
		</td>
		<td>&nbsp;</td>
	</tr> -->
	</table>
</div>

<?php
if($this->core->cleanGet['existing'] != "yes"){
	$currentyear = Date('Y');
	$yeardropdown = '';
	for ($i=0; $i < 100; $i++) { 
		$yeardropdown .= '<option value="'.($currentyear - $i).'">'.($currentyear - $i).'</option>';
	}
	// echo $currentyear;
	$count++;
	echo'<div id="certheader" class="studentname">'. $count .' - School Certificate Examination Results</div>

	<script>
	$( "#certheader" ).click(function() {
	$( ".results" ).slideToggle( "slow" );
	$( ".studentdetails" ).slideUp( "slow" );
	$( ".educationalrecords" ).slideUp( "slow" );
	$( ".emergencycontacts" ).slideUp( "slow" );
	$( ".programdetails" ).slideUp( "slow" );
	});
	</script>

	<div class="results formElement" style="display: none;  margin-bottom: 20px;">
	<p>Fill in the grades that you have scored in your secondary education.
	These grades will determine if you are eligible to enrol for a program. <br>
	Please make sure that the information entered is correct and correlates with the scan of the certificate<br>
	Also ensure that the scan is readable. Failing to do the above will automatically disqualify you.</p>


	<p>
		<strong> Examination number: </strong>
		<input type="text" name="examinationid" id="examinationid" value="'.$examNo.'"/>
	
		
	</p>
	<p>
		<strong> Year of completion: </strong>
		<select name="yearofcompletion" id="yearofcompletion">
			<option value="'.$yoc.'"> '.$yoc.'</option>
			'.$yeardropdown.'
		</select>
	</p>

	<p>
		<strong> Scan of document</strong><br>
		<b><a href="'.$this->core->conf['conf']['path']. '/registry/show/' . $userID.'">View Uploaded File</a></b>
		<input type="file" name="grade12" id="grade12" accept="image/*"/>
		
	</p>

	<table class="table table-bordered table-striped" cellspacing="0" cellpadding="5" >
	<thead>
		<tr>
		<th><b>Grade code</b></th>
		<th>Grade</th>
		<th><b>Grade code</b></th>
		<th>Grade</th>
		<th><b>Grade code</b></th>
		<th>Grade</th>
		</tr>
	</thead>
	<tbody>';
	
		$sql = "SELECT * FROM `subjects` LEFT JOIN `subject-grades` ON `subjects`.`ID` = `subject-grades`.`SubjectID` AND `subject-grades`.`StudentID` = '$userID' ";//
		$run = $this->core->database->doSelectQuery($sql);
		$i=0;
		while ($fetch = $run->fetch_row()) {
			if($i == 0){
				echo'<tr>';
				$i++;
			}else if($i==4){
				echo'</tr><tr>';
				$i=1;
			}

			echo'<td>'.$fetch[1].'</td><td><input name="grade['.$fetch[4].']" type="text" class="grade" value = "'.$fetch[6].'"></td>';
			$i++;
		}

		if($i ==0){
			$sql = "SELECT * FROM `subjects`";

			$run = $this->core->database->doSelectQuery($sql);
			while ($fetch = $run->fetch_row()) {
				if($i == 0){
					echo'<tr>';
					$i++;
				}else if($i==4){
					echo'</tr><tr>';
					$i=1;
				}

				echo'<td>'.$fetch[1].'</td><td><input name="grade['.$fetch[0].']" type="text" class="grade"></td>';
				$i++;
			}
		}
	
	echo'</tbody>
	</table>
	</div>';

$count++;

echo'<div id="educationrecordheader" class="studentname"> '. $count.' - Education background</div>';

echo'<script>
$( "#educationrecordheader" ).click(function() {
$( ".educationalrecords" ).slideToggle( "slow" );
$( ".studentdetails" ).slideUp( "slow" );
$( ".results" ).slideUp( "slow" );
$( ".emergencycontacts" ).slideUp( "slow" );
$( ".programdetails" ).slideUp( "slow" );
});
</script>';

 $countsub = 1; 

echo'<div class="educationalrecords formElement" style="display: none;  margin-bottom: 20px;">
<p>In this section you will need to provide records of your previously followed education (Dertificate/Diploma/Degree), you can use the Add button below this section to add more than one record, please enter as many records as needed.</p>';

$sql = "SELECT * FROM `education-background` WHERE `StudentID` LIKE '" . $nrc . "' OR `education-background`.`StudentID` = '" . $userID . "'";
// echo $sql;
$run = $this->core->database->doSelectQuery($sql);
$edrec = 0;

while ($row = $run->fetch_assoc()) {
	echo '<div class="educationalrecord">
	<input type="hidden" name="education['.$edrec.'][id]" value="'.$row['ID'].'" data-pattern-name="education[++][id]" data-pattern-id="education_++_index"/>

	<table width="768" height="94" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
			<td width="200" bgcolor="#EEEEEE"><strong>Input fields</strong></td>
			<td bgcolor="#EEEEEE">
				<div class="deleteeducationalrecord">
					<b><a href="#">REMOVE RECORD</a></b>
				</div>
			</td>
		</tr>
		<tr>
			<td height="19"><strong>'.$countsub++.' '.$count .'.'. $countsub . ' -  Type of certificate</strong></td>
			<td>
				<select name="education['.$edrec.'][type]" id="education_0_type" data-pattern-name="education[++][type]" data-pattern-id="education_++_type">
					<option value="'.$row['TypeOfCertificate'].'">'.$row['TypeOfCertificate'].'</option>
					<option value="Certificate">Certificate</option>
					<option value="Advanced Certificate">Advanced Certificate</option>
					<option value="Diploma">Diploma</option>
					<option value="Advanced Diploma">Advanced Diploma</option>	
					<option value="Degree">Degree</option>
					<option value="Masters Degree">Masters Degree</option>
					<option value="Post Doctorate">Post Doctorate</option>
					<option value="Professional certification">Professional certification</option>
				</select></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td height="22"><strong>'. $countsub++ .'  '. $count .'.'. $countsub . ' - Name of institution</strong></td>
			<td>
				<input type="text" value="'.$row['InstitutionName'].'" name="education['.$edrec.'][institution]" id="education_0_institution" data-pattern-name="education[++][institution]" data-pattern-id="education_++_institution"/></td>
			<td>For example: Evelyn Hone</td>
		</tr>
		<tr>
			<td height="22"><strong>'. $countsub++ .'  '. $count .'.'. $countsub . ' -  Name of certification</strong></td>
			<td>
				<input type="text" value="'.$row['CertificateName'].'" name="education['.$edrec.'][name]" id="education_0_name" data-pattern-name="education[++][name]" data-pattern-id="education_++_name"/></td>
			<td>For example: Diploma in Business Studies</td>
		</tr>
		<tr>
			<td height="22"><strong> Scan of document</strong></td>
			<td>
				<input type="file" name="education['.$edrec.'][upload]" id="education_0_upload" data-pattern-name="education[++][upload]" data-pattern-id="education_++_upload" accept="image/*"/></td>
			<td>Upload the certificate, degree or diploma.</td>
		</tr>
	</table>
</div>';

$edrec++;
}

echo	'<div class="educationalrecordnew">
		<!-- <input type="hidden" name="education['.$edrec.'][id]" data-pattern-name="education[++][id]" data-pattern-id="education_++_index"/> -->

		<table width="768" height="94" border="0" cellpadding="5" cellspacing="0">
			<tr>
				<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
				<td width="200" bgcolor="#EEEEEE"><strong>Input fields</strong></td>
				<td bgcolor="#EEEEEE">
					<div class="deleteeducationalrecord">
						<b><a href="#">REMOVE RECORD</a></b>
					</div>
				</td>
			</tr>
			<tr>
				<td height="19"><strong>'.$countsub++.' '.$count .'.'. $countsub . ' -  Type of certificate</strong></td>
				<td>
					<select name="education['.$edrec.'][type]" id="education_0_type" data-pattern-name="education[++][type]" data-pattern-id="education_++_type">
						<option value="Certificate">Certificate</option>
						<option value="Advanced Certificate">Advanced Certificate</option>
						<option value="Diploma">Diploma</option>
						<option value="Advanced Diploma">Advanced Diploma</option>	
						<option value="Degree">Degree</option>
						<option value="Masters Degree">Masters Degree</option>
						<option value="Post Doctorate">Post Doctorate</option>
						<option value="Professional certification">Professional certification</option>
					</select></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="22"><strong>'. $countsub++ .'  '. $count .'.'. $countsub . ' - Name of institution</strong></td>
				<td>
					<input type="text" name="education['.$edrec.'][institution]" id="education_0_institution" data-pattern-name="education[++][institution]" data-pattern-id="education_++_institution"/></td>
				<td>For example: Evelyn Hone</td>
			</tr>
			<tr>
				<td height="22"><strong>'. $countsub++ .'  '. $count .'.'. $countsub . ' -  Name of certification</strong></td>
				<td>
					<input type="text" name="education['.$edrec.'][name]" id="education_0_name" data-pattern-name="education[++][name]" data-pattern-id="education_++_name"/></td>
				<td>For example: Diploma in Business Studies</td>
			</tr>
			<tr>
				<td height="22"><strong> Scan of document</strong></td>
				<td>
					<input type="file" name="education['.$edrec.'][upload]" id="education_0_upload" data-pattern-name="education[++][upload]" data-pattern-id="education_++_upload" accept="image/*"/></td>
				<td>Upload the certificate, degree or diploma.</td>
			</tr>
		</table>

		<!-- <div class="addeducationalrecord" style="margin-left: 10px; padding: 20px;">
			<a href="#"> <img src="'. $this->core->fullTemplatePath .'/images/plus.png" width="16" height="16"/> <b> Add another education record </b></a>
		</div> -->
	</div>

</div>


<script type="text/javascript">
 $(\'.educationalrecords\').repeater({
	btnAddClass: \'addeducationalrecord\',
	btnRemoveClass: \'deleteeducationalrecord\',
	groupClass: \'educationalrecord\',
	minItems: 1,
	maxItems: 0,
	startingIndex: 0,
	reindexOnDelete: true,
	repeatMode: \'append\',
	animation: null,
	animationSpeed: 600,
	animationEasing: \'swing\',
	clearValues: true
});
</script>
';

}
?>


<div id="emergencyheader" class="studentname"><?php $count++; echo $count; ?> - Next of Kin Information</div>

<script>
$( "#emergencyheader" ).click(function() {
$( ".educationalrecords" ).slideUp( "slow" );
$( ".studentdetails" ).slideUp( "slow" );
$( ".results" ).slideUp( "slow" );
$( ".emergencycontacts" ).slideToggle( "slow" );
$( ".programdetails" ).slideUp( "slow" );
});
</script>

<?php $countsub = 0; ?>


<div class="emergencycontacts formElement" style="display: none;  margin-bottom: 20px;">
<p>In this section you provide your next of kin's contact information.</p>
	<div class="emergencycontact">
		<input type="hidden" name="econtact[0][id]" data-pattern-name="econtact[++][id]" data-pattern-id="econtact_++_index"/>

		<table width="768" height="135" border="0" cellpadding="5" cellspacing="0">
			<tr>
				<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
				<td width="200" bgcolor="#EEEEEE"><strong>Input fields</strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="19"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Full Name</strong></td>
				<td>
					<input type="text" name="econtact[0][fullname]" id="econtact_0_fullname" data-pattern-name="econtact[++][fullname]" data-pattern-id="contact_++_fullname"/></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="19"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Relationship</strong></td>
				<td>
					<select name="econtact[0][relationship]" id="econtact_0_relationship" data-pattern-name="econtact[++][relationship]" data-pattern-id="contact_++_relationship">
						<option value="">Select Relationship</option>
						<option value="Spouse">Spouse</option>
						<option value="Parent">Parent</option>
						<option value="Guardian">Legal Guardian</option>
						<option value="Uncle">Uncle</option>
						<option value="Son">Son</option>
						<option value="Daughter">Daughter</option>
						<option value="Grandparrent">Grandparrent</option>
						<option value="Aunt">Aunt</option>
						<option value="Cousing">Cousin</option>
						<option value="Sibling">Sibling</option>
					</select>

				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Phone Number</strong></td>
				<td>
					<input type="text" name="econtact[0][phonenumber]" id="econtact_0_phonenumber" data-pattern-name="econtact[++][phonenumber]" data-pattern-id="contact_++_phonenumber"/></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Street</strong></td>
				<td>
					<input type="text" name="econtact[0][street]" id="econtact_0_street" data-pattern-name="econtact[++][street]" data-pattern-id="contact_++_street"/></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Town</strong></td>
				<td><input type="text" name="econtact[0][town]" id="econtact_0_town" data-pattern-name="econtact[++][town]" data-pattern-id="contact_++_town"/></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Postalcode</strong></td>
				<td><input type="text" name="econtact[0][postalcode]" id="econtact_0_postalcode" data-pattern-name="econtact[++][postalcode]" data-pattern-id="contact_++_postalcode"/></td>
				<td>&nbsp;</td>
			</tr>
		</table>

		<!-- <div class="addemergencycontact" style="margin-left: 10px; padding: 20px;">
			<a href="#"> <img src="<?php echo $this->core->fullTemplatePath; ?>/images/plus.png" width="16" height="16"/> <b>Add another sponsor</b></a>
		</div> -->
	</div>


</div>


<div id="sponsorheader" class="studentname"><?php $count++; echo $count; ?> - Sponsor Information</div>

<script>
$( "#sponsorheader" ).click(function() {
$( ".educationalrecords" ).slideUp( "slow" );
$( ".studentdetails" ).slideUp( "slow" );
$( ".results" ).slideUp( "slow" );
$( ".emergencycontacts" ).slideUp( "slow" );
$( ".sponsorcontacts" ).slideToggle( "slow" );
$( ".programdetails" ).slideUp( "slow" );
});
</script>

<?php $countsub = 0; ?>


<div class="sponsorcontacts formElement" style="display: none;  margin-bottom: 20px;">
<p>In this section you select whether you are self sponsored or you have a sponsor. If you're sponsored you can provide your sponsor's contact information.</p>
<div class="form-group">
<label for="selfsponsored">Are you self sponsored?</label>
<select name="selfsponsored" id="selfsponsored">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
</select>
</div>
	<div class="emergencycontact" id="sponsor" style="display:block">
		<input type="hidden" id="scontact_id" name="scontact_id" value="<?php echo $scontactid; ?>" data-pattern-name="scontact[++][id]" data-pattern-id="scontact_++_index"/>

		<table width="768" height="135" border="0" cellpadding="5" cellspacing="0">
			<tr>
				<td height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
				<td bgcolor="#EEEEEE"><strong>Input fields</strong></td>
				
			</tr>
			<tr>
				<td height="19"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Full Name</strong></td>
				<td>
					<input type="text" name="scontact_fullname" id="scontact_fullname" value="<?php echo $scontact_fullname; ?>" data-pattern-name="scontact[++][fullname]" data-pattern-id="contact_++_fullname"/></td>
				
			</tr>
			<tr>
				<td height="19"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Relationship</strong></td>
				<td>
					<select name="scontact_relationship" id="scontact_relationship" data-pattern-name="scontact[++][relationship]" data-pattern-id="contact_++_relationship">
						<?php if(isset($scontact_relationship)) echo '<option value="'.$scontact_relationship.'">'.$scontact_relationship.'</option>';  ?>
						<option value="">Select Relationship</option>
						<option value="Self">Self</option>
						<option value="Spouse">Spouse</option>
						<option value="Parent">Parent</option>
						<option value="Guardian">Legal Guardian</option>
						<option value="Uncle">Uncle</option>
						<option value="Son">Son</option>
						<option value="Daughter">Daughter</option>
						<option value="Grandparrent">Grandparrent</option>
						<option value="Aunt">Aunt</option>
						<option value="Cousing">Cousin</option>
						<option value="Sibling">Sibling</option>
					</select>

				</td>
				
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Phone Number</strong></td>
				<td>
					<input type="text" name="scontact_phonenumber" id="scontact_phonenumber" value="<?php echo $scontact_phonenumber; ?>" data-pattern-name="scontact[++][phonenumber]" data-pattern-id="contact_++_phonenumber"/></td>
				
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Address</strong></td>
				<td>
					<input type="text" name="scontact_street" id="scontact_street" value="<?php echo $scontact_street; ?>" data-pattern-name="scontact[++][street]" data-pattern-id="contact_++_street"/></td>
				
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Start Date</strong></td>
				<td><input type="date" name="scontact_town" id="scontact_town" value="<?php echo $scontact_town; ?>" data-pattern-name="scontact[++][town]" data-pattern-id="contact_++_town"/></td>
				
			</tr>
			<tr>
				<td height="22"><strong><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> End Date</strong></td>
				<td><input type="date" name="scontact_postalcode" id="scontact_postalcode" value="<?php echo $scontact_postalcode; ?>" data-pattern-name="scontact[++][postalcode]" data-pattern-id="contact_++_postalcode"/></td>
				
			</tr>
		</table>
	</div>
<script>
	var selfsponsored = document.getElementById("selfsponsored");
	var sponser = document.getElementById("sponsor");
	var sname = document.getElementById("scontact_fullname");
	var srelation = document.getElementById("scontact_relationship");
	var sphone = document.getElementById("scontact_phonenumber");
	var sstreet = document.getElementById("scontact_street");
	var start = document.getElementById("scontact_town");
	var end = document.getElementById("scontact_postalcode");
	selfsponsored.onchange = function showSponsor() {
        if (selfsponsored.value == 'Yes') {
            // sponsor.style.display = 'none';
			sname.value = "<?php echo $firstname.' '.$middlename.' '.$surname; ?>";
			srelation.value = "Self";
			sphone.value = "<?php echo $celphone; ?>";
			sstreet.value = "<?php echo $street; ?>";
			// start = '<?php echo $scontactid; ?>';
			// end = '<?php echo $scontactid; ?>';
        }
        if (selfsponsored.value == 'No') {
            sponsor.style.display = 'block';
			sname.value = "<?php echo $scontact_fullname; ?>";
			srelation.value = "<?php echo $scontact_relationship; ?>";
			sphone.value = "<?php echo $scontact_phonenumber; ?>";
			sstreet.value = "<?php echo $scontact_street; ?>";
			start.value = "<?php echo $scontact_town; ?>";
			end.value = "<?php echo $scontact_postalcode; ?>";
        }

    }
</script>


</div>

<!-- <script type="text/javascript">
 $('.emergencycontacts').repeater({
	btnAddClass: 'addemergencycontact',
	btnRemoveClass: 'deleteemergencycontact',
	groupClass: 'emergencycontact',
	minItems: 1,
	maxItems: 0,
	startingIndex: 0,
	reindexOnDelete: true,
	repeatMode: 'append',
	animation: null,
	animationSpeed: 600,
	animationEasing: 'swing',
	clearValues: true
});
</script> -->



<div id="programheader" class="studentname"><?php $count++; echo $count; ?> - Alternative Program Selection</div>

<script>
$( "#programheader" ).click(function() {
$( ".educationalrecords" ).slideUp( "slow" );
$( ".studentdetails" ).slideUp( "slow" );
$( ".results" ).slideUp( "slow" );
$( ".emergencycontacts" ).slideUp( "slow" );
$( ".programdetails" ).slideToggle( "slow" );
});
</script>

<?php $countsub = 0; ?>

<div class="programdetails formElement" style="display: none;  margin-bottom: 20px;">
	<p>This is the final part of your application. Select two more programs you would like to be considered for in case your first choice is not available.</p>

	<table width="768" height="94" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
			<td width="200" bgcolor="#EEEEEE"><strong>Selection</strong></td>
			<td width="363" bgcolor="#EEEEEE"></td>
		</tr>
		<?php
			if($this->core->role > 10) {
				//change program here
				echo'<tr style="background-color:#F5EF73">
					<td><strong>'. $count .'.'. $countsub . ' -  First Choice Program</strong></td>
					<td>
						
						<select name="studyid" id="studyid">
							'.$programselected.'
						</select>
					</td>
					<td>For the change of program</td>
				</tr>';
			} else {
				echo'<input name="yearofstudy" value="'.$yos.'" type="hidden">';
			}
		?>
		<tr>
			<td height="22"><b><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Second choice:</b><br></td>
			<td>
				<select name="choiceb" id="mda">
					<?php echo '<option value="'.$major.'">'.$majora.'</option>'.$programs; ?>
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>


		<tr>
			<td height="22"><b><?php $countsub++; echo $count .'.'. $countsub . ' - '; ?> Third choice:</b><br></td>
			<td>
				<select name="choicec" id="mdb">
					<?php echo '<option value="'.$minor.'">'.$minora.'</option>'.$programs; ?>
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		<input type="hidden" name="dateofenrollment" value="<?php echo date("Y-m-d"); ?>"></td>

	</table>
</div> 



<div class="submitdetails formElement" style="display: block; padding-left: 30px;  margin-bottom: 20px;">
	<p><b>Click on the button to submit the form. </p>

	<div class="error" id="laststatus"></div>
	<?php
		echo '<input type="submit" class="register" name="submit-registrar" id="submit-registrar" value="UPDATE INFORMATION"/>';
	?>
</div>

</form>