<div class="heading"><?php echo $this->core->translate("Search by student number"); ?></div>
<form id="idsearch" name="idsearch" method="get" action="">
	<div class="label"><?php echo $this->core->translate("Enter student number"); ?>:</div>
	<input type="text" name="uid" id="student-id" class="submit" style="width: 125px"/>
	<input type="submit" class="submit" value="<?php echo $this->core->translate("Open Record"); ?>"/>
</form>

<div style="position: absolute; top: -100px; "> <div class="heading"><?php echo $this->core->translate("Search by EduCard"); ?></div>
<form id="idsearch" name="idsearch" method="get" action="">
	<div class="label"><?php echo $this->core->translate("Scan card"); ?>:</div>
	<input type="text" name="card" id="card" style="width: 250px" class="submit"/>
	<input type="submit" class="submit" value="<?php echo $this->core->translate("Open Record"); ?>"/>
</form></div>


 <script type="text/javascript">
 document.getElementById("card").focus();
 </script>


<form id="coursesearch" name="coursesearch" method="get" action="">
	<div class="heading"><?php echo $this->core->translate("View Class List (Search by Course)"); ?></div>
	<div class="label"><?php echo $this->core->translate("Show all students from"); ?>:</div>
	<input type="hidden" name="search" value="course">
	<select name="q" id="course" class="submit" width="250" style="width: 250px">
		<?php echo $courses; ?>
	</select>

<br>
<div class="label"><?php echo $this->core->translate("Year/Semester"); ?>:</div>
 

	<select name="year" class="submit">
		<option value="all">- ALL -</option>
		<option value="2022" selected>2022</option>
		<option value="202206">202206</option>
		<option value="202205">202205</option>
		<option value="202204">202204</option>
		<option value="202201">202201</option>
		<option value="2021">2021</option>
		<option value="2020">2020</option>
		<option value="2019">2019</option>
		<option value="2018">2018</option>
		<option value="2017">2017</option>
		<option value="2016">2016</option>
		<option value="2015">2015</option>
		<option value="2014">2014</option>
		<option value="2013">2013</option>
		<option value="2012">2012</option>
		<option value="2011">2011</option>
		<option value="2010">2010</option>
		<option value="2009">2009</option>
		<option value="2008">2008</option>
	</select>
	<select name="semester" class="submit">
		<option value="1">Semester 1</option>
		<option value="2">Semester 2</option>
		<option value="1">Term 1</option>
		<option value="2">Term 2</option>
		<option value="3">Term 3</option>
	</select>

	<input type="submit" class="submit" value="<?php echo $this->core->translate("View records"); ?>"/>
</form>


<div class="heading"><?php echo $this->core->translate("Search by intake"); ?></div>
<form id="idsearch" name="yearsearch" method="get" action="">
	<div class="label"><?php echo $this->core->translate("Select year of intake"); ?>:</div>
	<select name="year" class="submit">
		<option value="all">- ALL -</option>
		<option value="202206" selected>202206</option>
        <option value="202205">202205</option>
        <option value="202204">202204</option>
		<option value="202201">202201</option>
        <option value="202112">202112</option>
		<option value="202106">202106</option>
		<option value="202105">202105</option>
		<option value="202104">202104</option>
		<option value="202101">202101</option>
		<option value="202012">202012</option>
		<option value="202007">202007</option>
		<option value="202006">202006</option>
		<option value="202005">202005</option>
		<option value="202001">202001</option>
		<option value="1901">1901</option>
		<option value="1906">1906</option>
		<option value="2018">2018</option>
		<option value="201808">201808</option>
		<option value="201809">201809</option>
		<option value="201812">201812</option>
		<option value="2017">2017</option>
		<option value="2016">2016</option>
		<option value="2015">2015</option>
		<option value="2014">2014</option>
		<option value="2013">2013</option>
		<option value="2012">2012</option>
		<option value="2011">2011</option>
		<option value="2010">2010</option>
		<option value="2009">2009</option>
		<option value="2008">2008</option>
	</select>
	<select name="mode" class="submit" style="width: 165px">
		<option value="Masters">Masters</option>
		<option value="Fulltime" selected>Fulltime</option>
		<option value="Block">Block release</option>
		<option value="Distance">Distance</option>
		<option value="Part-time">Part-time</option>
		<option value="Dismissed">Dismissed</option>
	</select>
	<select name="group" class="submit" style="width: 105px">
		<option value="" selected>Groups</option>
		<option value="1">Group 1</option>
		<option value="2">Group 2</option>
	</select>
	<input type="submit" class="submit" value="<?php echo $this->core->translate("Open Records"); ?>"/>
</form>




<form id="namesearch" name="namesearch" method="get" action="">
	<div class="heading"><?php echo $this->core->translate("Search by Name"); ?></div>

	<div class="padding">
		<div class="label"><?php echo $this->core->translate("Enter students first name"); ?>:</div>
		<input type="text" name="studentfirstname" id="studentfirstname" style="width: 250px" class="submit"/><br>
	</div>
	<div class="padding">
		<div class="label"> <?php echo $this->core->translate("and/or surname"); ?>:</div>
		<input type="text" name="studentlastname" id="studentlastname" style="width: 250px" class="submit"/>
	</div>
	<div class="label"><?php echo $this->core->translate("Show as"); ?>:</div>
	<select name="listtype" class="submit"  style="width: 250px">
		<option value="list"><?php echo $this->core->translate("List of Students"); ?></option>
		<option value="profiles"><?php echo $this->core->translate("Profile View"); ?></option>
	</select> <input type="submit" class="submit" value="<?php echo $this->core->translate("Search Records"); ?>"/>
	</select>
</form>


<form id="programmesearch" name="programmesearch" method="get" action=""> 
	<div class="heading"><?php echo $this->core->translate("View students by Programme"); ?></div>
	<div class="label"><?php echo $this->core->translate("Show all students from"); ?>:</div>
	<input type="hidden" name="search" value="programme">
	<select name="q" id="study" class="submit" width="250" style="width: 250px">
		<?php echo $study; ?>
	</select><br/>
	<div class="label"><?php echo $this->core->translate("Filter by"); ?>:</div>
	<select name="mode" class="submit">
		<option value="Fulltime">Fulltime</option>
		<option value="Distance">Distance</option>
		<option value="Part-time">Part-time</option>
		<option value="Dismissed">Dismissed</option>
	</select>
	<select name="year" class="submit" style="width: 129px;">
         <option value="all">- ALL -</option>
		 
         <option value="202206" selected>202206</option>
         <option value="202205">202205</option>
         <option value="202204">202204</option>
		 <option value="202201">202201</option>
         <option value="2022">2022</option>
         <option value="202112">202112</option>
	     <option value="202106">202106</option>
		 <option value="202105">202105</option>
		 <option value="202104">202104</option>
		 <option value="202101">202101</option>
         <option value="2021">2021</option>
	     <option value="202012">202012</option>
		<option value="202007">202007</option>
		<option value="202006">202006</option>
		<option value="202005">202005</option>
		<option value="202001">202001</option>
		<option value="2019">2019</option>
		<option value="2018">2018</option>
		<option value="2017">2017</option>
		<option value="2016">2016</option>
	</select>
	<input type="submit" class="submit" value="<?php echo $this->core->translate("View records"); ?>"/>
</form>

<form id="centersearch" name="centersearch" method="get" action="">
	<div class="heading"><?php echo $this->core->translate("View students by Exam Center"); ?></div>
	<div class="label"><?php echo $this->core->translate("Exam centre"); ?>:</div>
			<select name="examcenter" id="examcenter" class="submit" width="250" style="width: 250px">
<?php echo $centres; ?>
			</select> <br/>
	<div class="label"><?php echo $this->core->translate("Filter by"); ?>:</div>
	<select name="mode" class="submit">
		<option value="Block">Block release</option>
		<option value="Fulltime">Fulltime</option>
		<option value="Distance">Distance</option>
		<option value="Part-time">Part-time</option>
		<option value="Dismissed">Dismissed</option>
	</select>
	<select name="year" class="submit" style="width: 129px;">
		<option value="1">1st Year</option>
		<option value="2">2nd Year</option>
		<option value="3">3rd Year</option>
		<option value="4">4th Year</option>
		<option value="%">ALL</option>
	</select>
	<input type="submit" class="submit" value="<?php echo $this->core->translate("View records"); ?>"/>
</form>




<form id="rolesearch" name="rolesearch" method="get" action="">
<input type="hidden" name="search" value="true">
	<div class="heading"><?php echo $this->core->translate("View users by Role"); ?></div>
	<div class="label"><?php echo $this->core->translate("Show all users who are"); ?>:</div>
	<input type="hidden" name="search" value="role">
	<select name="role" id="role" class="submit" width="250" style="width: 250px">
		<?php echo $roles; ?>
	</select> 
	<input type="submit" class="submit" value="<?php echo $this->core->translate("View Records"); ?>"/>
</form>

<form id="statussearch" name="statussearch" method="get" action="">
<input type="hidden" name="search" value="true">
	<div class="heading"><?php echo $this->core->translate("View users by Status"); ?></div>
	<div class="label"><?php echo $this->core->translate("Show all users who are"); ?>:</div>
	<input type="hidden" name="search" value="status">
	<select name="status" id="status" class="submit" width="250" style="width: 250px">
		<option value="Active">Active</option>
		<option value="Suspended">Suspended</option>
		<option value="New">New</option>
		<option value="Requesting">Requesting</option>
		<option value="Locked">Locked</option>
		<option value="Employed">Employed</option>
	</select> 
	<input type="submit" class="submit" value="<?php echo $this->core->translate("View Records"); ?>"/>
</form>

<form id="nationalitysearch" name="nationalitysearch" method="get" action="">
<input type="hidden" name="search" value="true">
	<div class="heading"><?php echo $this->core->translate("View users by Nationality"); ?></div>
	<div class="label"><?php echo $this->core->translate("Show users from"); ?>:</div>
	<input type="hidden" name="search" value="nationality">


		<select name="nationality">
			<option value="<?php echo $nationality; ?>" selected="selected">- <?php echo $nationality; ?> -</option>
			<option value="ALL">ALL FOREIGN</option>
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
			<option value="botswana">Botswana</option>
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
			<option value="zambian">Zambian</option>
			<option value="zimbabwean">Zimbabwean</option>
		</select>


	<select name="year" class="submit">
		<option value="all" selected>- ALL -</option>
		<option value="202206" >202206</option>
        <option value="202205">202205</option>
        <option value="202204">202204</option>
		<option value="202201">202201</option>
        <option value="202112">202112</option>
		<option value="202106">202106</option>
		<option value="202105">202105</option>
		<option value="202104">202104</option>
		<option value="202101">202101</option>
		<option value="202012">202012</option>
		<option value="202007">202007</option>
		<option value="202006">202006</option>
		<option value="202005">202005</option>
		<option value="202001">202001</option>
		<option value="1901">1901</option>
		<option value="1906">1906</option>
		<option value="2018">2018</option>
		<option value="201808">201808</option>
		<option value="201809">201809</option>
		<option value="201812">201812</option>
		<option value="2017">2017</option>
		<option value="2016">2016</option>
		<option value="2015">2015</option>
		<option value="2014">2014</option>
		<option value="2013">2013</option>
		<option value="2012">2012</option>
		<option value="2011">2011</option>
		<option value="2010">2010</option>
		<option value="2009">2009</option>
		<option value="2008">2008</option>
	</select>
	
	
	<select name="period">
		<?php echo $periods; ?>
	</select>


	<input type="submit" class="submit" value="<?php echo $this->core->translate("View Records"); ?>"/>
</form>
