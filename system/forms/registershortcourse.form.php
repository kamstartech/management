<div id="studentheader" class="studentname"><?php $count=1; //echo $count; ?>Applicant Details</div>

<p class="text-center">Please provide the basic information needed for your application.</p>
<?php $countsub = 1; ?>
<div class="row" style="padding-left: 140px; padding-right: 140px;">
    <!-- <div class="card col-lg-4">
        <div class="card-body">
            
        </div>
    </div> -->
    <div class="form-group col-lg-4">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
    </div>
    <div class="form-group col-lg-4">
        <label for="middlename">Middle Name</label>
        <input type="text" class="form-control" name="middlename" placeholder="Middle Name">
    </div>
    <div class="form-group col-lg-4">
        <label for="surname">Surname</label>
        <input type="text" class="form-control" name="surname" placeholder="Surname" required>
    </div>

    <div class="form-group" style="padding-left:15px; padding-right:15px;">
        <label for="gender">Sex (Gender)</label>
        <select class="form-control" name="sex" id="gender">
            <option value="Male">Male</option>
            <option value="Female" selected>Female</option>
            <option value="Female">Other</option>
        </select>
    </div>

    <h5 class="card-title text-center">Enter date of birth</h5>
    <div class="form-group col-lg-4">
        <label for="day">Day</label>
        <select class="form-control" name="day" id="day" required>
            <option selected> Day</option>
            <?php for ($i=1; $i < 32; $i++) { 
						echo '<option value="'.$i.'">'.$i.'</option>';
					} ?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="month">Month</label>
        <select class="form-control" name="month" id="month">
            <option selected> Month</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="year">Year</label>
        <select class="form-control" name="year" id="year">
            <option> Year</option>
            <?php for ($i=1900; $i < 2016; $i++) {
						$selected="";
						if ($i==1983) {
							$selected="selected";
						} 
						echo '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
					} ?>
        </select>
    </div>

    <div class="form-group" style="padding-left:15px; padding-right:15px;">
        <label for="nrc">NRC or Passport</label>
        <?php
				if($existing=="yes"){
					echo'<input class="form-control" type="text" name="studentid" id="username"/>'; 
				}else{
					echo'<input class="form-control" type="text" name="studentid" id="nrc" placeholder="123456/78/9" required/>';
				}
			?>
    </div>
    <div class="form-group" style="padding-left:15px; padding-right:15px;">
        <label for="number">Phone Number</label>
        <input class="form-control" type="number" name="celphone" id="phone" placeholder="0955443322" required />
    </div>

    <div class="form-group" style="padding-left:15px; padding-right:15px;">
        <label for="country">Nationality</label>
        <select class="form-control" name="nationality" id="nationality">
            <!-- <option value="zambian" selected="selected">Zambian</option> -->
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
            <option value="zambian" selected>Zambian</option>
            <option value="zimbabwean">Zimbabwean</option>
        </select>
    </div>

    <div class="form-group" style="padding-left:15px; padding-right:15px;">
        <label for="email">Email address</label>
        <input class="form-control" type="email" name="email" aria-describedby="emailHelp" id="email"
            placeholder="support@mu.ac.zm" required />
    </div>

    <p><b>Click on the button to submit the form. </p>
    <div class="error" id="laststatus"></div>
    <input type="submit" class="register" name="submit-registrar" id="submit-registrar" value="SUBMIT APPLICATION" />
</div>

<!-- <div class="studentdetails formElement"> -->
<input type="hidden" value="Single" name="mstatus">
<input type="hidden" name="country" id="country" value="zambian">
<input type="hidden" name="postalcode" id="postalcode" value="10101">
<input type="hidden" name="streetname" id="streetname" value="Ghana Avenue">
<!-- <hr> -->


<!-- <div style="padding-left: 20px;">
        
    </div> -->
<!-- </div> -->

</form>