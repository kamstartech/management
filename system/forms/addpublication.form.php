<div style="padding: 50px;">
<h1>COMPLETED PUBLICATION OR RESEARCH PROJECT SUBMISSION</h1>
<p>All fields are mandatory, please ensure you check you have completed the form before attempting to submit. Incomplete submissions will not be processed.</p>

<style>
h2 {
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    margin: 0px;
	margin-bottom: 5px;
    background-color: #6297c3;
    padding: 10px;
}
</style>
<form id="edititem" name="additem" method="post"  enctype="multipart/form-data"  action="<?php echo $this->core->conf['conf']['path'] . "/research/save/publication" . $this->core->item; ?>">
	<h2>PART 1 GENERAL INFORMATION</h2><br>
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
			  
		<tr>
            <td><strong>Title of Research/Publication</strong></td>
            <td><input type="text" name="name" value="" /></td>
        </tr>
		
		<tr>
			<td><strong>School</strong></td>
			<td><select name="school" id="school" class="form-control" style="width:250px;">
					<?php echo $schools; ?>
				</select></td>
		</tr>
        <tr>
            <td><strong>Thematic Area </strong></td>
            <td><select name="area" class="form-control" style="width:250px;">
			<option value="Agriculture and/or Botany">Agriculture and/or Botany</option>
			<option value="Anatomy &amp; Physiology - Terrestrial">Anatomy &amp; Physiology - Terrestrial</option><option value="Biochemistry">Biochemistry</option><option value="Biological Sciences">Biological Sciences</option><option value="Biophysics">Biophysics</option><option value="Cell &amp; Molecular Biology">Cell &amp; Molecular Biology</option><option value="Climate Change &amp; Coastal Resiliency">Climate Change &amp; Coastal Resiliency</option><option value="Conservation Biology">Conservation Biology</option><option value="Ecology">Ecology</option><option value="Epidemiology">Epidemiology</option><option value="Evolutionary Biology">Evolutionary Biology</option><option value="Food Science">Food Science</option><option value="Genetics &amp; Epigenetics">Genetics &amp; Epigenetics</option><option value="Genomics / Gene Sequencing">Genomics / Gene Sequencing</option><option value="Immunology">Immunology</option><option value="Microbiology">Microbiology</option><option value="Neurosciences">Neurosciences</option><option value="Organismal Biology">Organismal Biology</option><option value="Pharmaceutical Sciences - Basic R&amp;D">Pharmaceutical Sciences - Basic R&amp;D</option><option value="Pharmacy Practice &amp; Clinical Research">Pharmacy Practice &amp; Clinical Research</option><option value="Physics">Physics</option><option value="Plant Sciences">Plant Sciences</option><option value="Proteomics / Metabolomics">Proteomics / Metabolomics</option><option value="Veterinary Sciences">Veterinary Sciences</option>
			<option value="Analytical Chemistry">Analytical Chemistry</option>
			<option value="Applied Chemistry - Explosives">Applied Chemistry - Explosives</option><option value="Artificial Intelligence">Artificial Intelligence</option><option value="Biomedical Engineering">Biomedical Engineering</option><option value="Biophysical Chemistry">Biophysical Chemistry</option><option value="Chemical Engineering">Chemical Engineering</option><option value="Civil Engineering">Civil Engineering</option><option value="Composites">Composites</option><option value="Computer Sciences">Computer Sciences</option><option value="Cybersecurity">Cybersecurity</option><option value="Forensic Chemistry">Forensic Chemistry</option><option value="Green Chemistry">Green Chemistry</option><option value="Geology">Geology</option><option value="Geophysical Sciences - Terrestrial">Geophysical Sciences - Terrestrial</option><option value="Industrial and System Engineering">Industrial and System Engineering</option><option value="Materials Engineering">Materials Engineering</option><option value="Ocean Engineering">Ocean Engineering</option><option value="Organic Chemistry">Organic Chemistry</option><option value="Physical Chemistry">Physical Chemistry</option><option value="Polymer Chemistry">Polymer Chemistry</option><option value="Nanotechnology">Nanotechnology</option><option value="Sensors">Sensors</option>
			<option value="Anatomy &amp; Physiology - Marine/Oceans">Anatomy &amp; Physiology - Marine/Oceans</option><option value="Aquaculture">Aquaculture</option><option value="Aquatic/Marine Biology">Aquatic/Marine Biology</option><option value="Atmospheric Science/Chemistry">Atmospheric Science/Chemistry</option><option value="Biochemistry - Marine/Oceans">Biochemistry - Marine/Oceans</option><option value="Biological Oceanography">Biological Oceanography</option><option value="Chemical Oceanography">Chemical Oceanography</option><option value="Climate Change &amp; Coastal Resiliency">Climate Change &amp; Coastal Resiliency</option><option value="Environmental Chemistry">Environmental Chemistry</option><option value="Fisheries">Fisheries</option><option value="Geological Oceanography">Geological Oceanography</option><option value="Geophysical Sciences - Marine/Oceans">Geophysical Sciences - Marine/Oceans</option><option value="Marine Affairs">Marine Affairs</option><option value="Marine Environmental Physiology">Marine Environmental Physiology</option><option value="Microbial Ecology">Microbial Ecology</option><option value="Marine Pollution / Conservation">Marine Pollution / Conservation</option><option value="Natural Resources Science">Natural Resources Science</option><option value="Physical Chemistry - Marine">Physical Chemistry - Marine</option><option value="Physical Oceanography">Physical Oceanography</option>
			<option value="Audiology &amp; Speech Sciences">Audiology &amp; Speech Sciences</option><option value="Behavioral Health / Behavioral Medicine">Behavioral Health / Behavioral Medicine</option><option value="Diagnostics">Diagnostics</option><option value="Epidemiology / Population Health">Epidemiology / Population Health</option><option value="Gerontology">Gerontology</option><option value="Healthcare Policy &amp; Administration">Healthcare Policy &amp; Administration</option><option value="Healthcare Technology / Tele-Health">Healthcare Technology / Tele-Health</option><option value="Kinesiology &amp; Physical Therapy">Kinesiology &amp; Physical Therapy</option><option value="Nursing">Nursing</option><option value="Pharmaceutical Sciences">Pharmaceutical Sciences</option><option value="Psychology - healthcare service related">Psychology - healthcare service related</option><option value="Other Clinical Sciences">Other Clinical Sciences</option>
			<option value="Anthropology">Anthropology</option><option value="Business / Entrepreneurship">Business / Entrepreneurship</option><option value="Economics">Economics</option><option value="Education">Education</option><option value="Finance">Finance</option><option value="Human Development">Human Development</option><option value="Landscape Architecture">Landscape Architecture</option><option value="Library Services">Library Services</option><option value="Management">Management</option><option value="Marketing">Marketing</option><option value="Mathmatics">Mathmatics</option><option value="Political Science">Political Science</option><option value="Psychology - non-healthcare service related">Psychology - non-healthcare service related</option><option value="Sociology">Sociology</option><option value="Statistics">Statistics</option><option value="Supply Chain Management">Supply Chain Management</option>
			<option value="Art History">Art History</option><option value="Communication &amp; Media Studies">Communication &amp; Media Studies</option><option value="English">English</option><option value="Gender and Women's Studies">Gender and Women's Studies</option><option value="History">History</option><option value="Journalism">Journalism</option><option value="Languages">Languages</option><option value="Music">Music</option><option value="Philosophy">Philosophy</option><option value="Textiles, Fashion Merchandising, Design">Textiles, Fashion Merchandising, Design</option><option value="Theatre Arts">Theatre Arts</option><option value="Visual Arts">Visual Arts</option><option value="Writing &amp; Rhetoric">Writing &amp; Rhetoric</option>
			</select>
			</td>
        </tr>

		<tr>
			<td><strong>Research project/publication funding locale </strong></td>
			<td>
			<select name="locale" class="form-control" style="width:250px;" >
						<option value="local">Local</option>
						<option value="international">International</option>
					</select>
			</td>
		</tr>

		<tr>
			<td><strong>Start of research project/publication </strong></td>
			<td><input name="start" type="date" class="" value=""></td>

		</tr>

		<tr>
			<td><strong>End of research project/publication </strong></td>
			<td><input name="end" type="date" class="" value=""></td>

		</tr>

		<tr>
            <td><strong>Document URL reference</strong></td>
            <td><input type="text" name="urlref" value="" /></td>
        </tr>

		<tr>
            <td><strong>ISBN/DOI/ISSN</strong></td>
            <td><input type="text" name="isbndoi" value="" /></td>
        </tr>
		
		
		<tr>
            <td><strong>Total Budget (ZMW)</strong></td>
            <td><input type="number" name="budget" value=""  /></td>
        </tr>

		<tr>
            <td><strong>Research project/publicaton abstract <br>(250-500 words)</strong></td>
            <td><textarea  name="abstract" style="width: 665px; height: 250px;" /></textarea></td>
        </tr>
    </table>
	<br />

	<hr>

	<h2>PART 2 RESEARCH PROJECT PARTICIPANTS</h2>
	<p>Names, Addresses and Institutions of Principal Investigator and Collaborators/research team members participating in the research project</p>
	<table  width="100%"  border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
		<tr>
			<td><strong>Name of Researcher</strong></td>
			<td><select id="external" name="rresearcher[]" class="form-control" style="width:250px;" onchange="showExternal(0)">
					<option value="external">External Researcher</option>
					<?php echo $manager; ?>
				</select></td>
		</tr>
		
        <tr style="display:table-row;" class="external">
            <td><strong>Name of Researcher </strong></td>
            <td><input type="text" name="rname[]" value="" /></td>
        </tr>
		
		<tr style="display:table-row;"  class="external">
            <td><strong>Title</strong></td>
            <td><select name="rtitle[]" class="form-control" style="width:250px;" >
				<option value="Professor">Professor </option>
				<option value="Associate Professor">Associate Professor </option>
				<option value="Doctor (Md)">Doctor (Md)</option>
				<option value="Doctor (PhD)">Doctor (PhD)</option>
				<option value="Engineer">Engineer (IR/Eng.)</option>
				<option value="Mrs">Mrs.</option>
				<option value="Mr">Mr.</option>
				<option value="Ms">Ms.</option>
				</select>
			</td>
        </tr>
		
		<tr style="display:table-row;" class="external">
			<td><strong>Gender</strong></td>
			<td><select name="rgender[]" class="form-control" style="width:250px;">
				<option value="Female">Female </option>
				<option value="Male">Male </option>
				<option value="Not specified">Not specified</option>
				</select>
			</td>
		</tr>

		<tr style="display:table-row;" class="external">
			<td><strong>Institution / University</strong></td>
			<td><input name="runiversity[]" type="text" class="" value=""></td>
		</tr>
		
		<!-- <tr style="display:table-row;" class="external">
			<td><strong>School / Faculty</strong></td>
			<td><input name="rschool[]" type="text" class="" value=""></td>
		</tr> -->

		<tr>
			<td><strong>School / Faculty</strong></td>
			<td><select id="school" name="rschool[]" class="form-control" style="width:250px;" required>
					<option value="">SCHOOLS</option>
					<?php echo $schools; ?>
				</select></td>
		</tr>

		<tr style="display:table-row;" class="external">
			<td><strong>Department</strong></td>
			<td><input name="rdepartment[]" type="text" class="" value=""></td>
		</tr>
		<tr style="display:table-row;" class="external">
			<td><strong>Telephone</strong></td>
			<td><input name="rphone[]" type="number" class="" value=""></td>
		</tr>
		<tr style="display:table-row;" class="external">
			<td><strong>Email</strong></td>
			<td><input name="remail[]" type="email" class="" value=""></td>
		</tr>
				
		<tr>
			<td><strong>Research position</strong></td>
			<td><select name="rposition[]" class="form-control" style="width:250px;">
				<option value="Principal Researcher">Principal Researcher </option>
				<option value="Co-Researcher">Co-Researcher </option>
				<option value="Researcher">Researcher</option>
				<option value="Assistant">Assistant</option>
				<option value="Administrative">Administrative</option>
				</select>
			</td>
		</tr>
		
    </table>
	<br/>
	<div id="container"></div>
		<b> <button type="button" id="addline" class="btn btn-primary">ADD ANOTHER RESEARCHER</button> </b>
	<br />
	<hr />	
	
	<h2>PART 3 UPLOAD PUBLICATION FILE</h2>
		<!-- <p>Download the detailed research proposal template <b><a href="/datastore/uploads/template.docx">FROM HERE</a></b> then upload it below</p> -->
	<table  width="100%"  border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>
                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>
              </tr>
        <tr>
            <td><strong>File Attachment</strong></td>
            <td><input type="file" name="filea" required></td>
        </tr>

		<!-- <tr>
            <td><strong>File URL Reference</strong></td>
            <td><input type="text" name="file_url" value="" required/></td>
        </tr> -->
    </table>
	<br />
	<hr />
	
	<br />

	<hr>
	<p><b>By submitting this form I verify that the information submitted in this form is true, complete and accurate. I understand that incomplete submissions will not be processed and that ICT is in no form or way responsible for the omission of information contained in this form. </b></p>
	  <input type="submit"  class="btn btn-primary" name="submit" id="submit" value="Upload Publication" />
        <p>&nbsp;</p>

      </form>	

	<script>
		function showExternal(counts) {
			var classname = "external";
			if(counts > 0) {
				classname = classname + counts;
			}
			var lst = document.getElementsByClassName(classname);
			var researcher = document.getElementById(classname);
			if (researcher.value == "external") {
				for(var i = 0; i < lst.length; ++i) {				
					lst[i].style.display = "table-row";
				}
			} else {
				for(var i = 0; i < lst.length; ++i) {				
					lst[i].style.display = "none";
				}
			}
		}
	</script>

	<script>
		count = 1;
		$(document).on("click", "[id^=addline]", function (e) {
			console.log(count);
			$('[id^=container]').append('<table width="100%" border="0" cellpadding="5" cellspacing="0"> <tr> <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td> <td width="560" bgcolor="#EEEEEE"> <strong>Input field</strong> </td> </tr> <tr>			<td><strong>Name of Researcher</strong></td>			<td><select id="external' + count + '" name="rresearcher[]" class="form-control" style="width:250px;" onchange="showExternal(' + count + ')">					<option value="external">External Researcher</option>					<?php echo $manager; ?>				</select></td>		</tr>		        <tr style="display:table-row;" class="external' + count  + '">            <td><strong>Name of Researcher </strong></td>            <td><input type="text" name="rname[]" value="" /></td>        </tr>				<tr style="display:table-row;"  class="external' + count  + '">            <td><strong>Title</strong></td>            <td><select name="rtitle[]" class="form-control" style="width:250px;" >				<option value="Professor">Professor </option>				<option value="Associate Professor">Associate Professor </option>				<option value="Doctor (Md)">Doctor (Md)</option>				<option value="Doctor (PhD)">Doctor (PhD)</option>				<option value="Engineer">Engineer (IR/Eng.)</option>				<option value="Mrs">Mrs.</option>				<option value="Mr">Mr.</option>				<option value="Ms">Ms.</option>				</select>			</td>        </tr>				<tr style="display:table-row;" class="external' + count  + '">			<td><strong>Gender</strong></td>			<td><select name="rtitle[]" class="form-control" style="width:250px;">				<option value="Female">Female </option>				<option value="Male">Male </option>				<option value="Not specified">Not specified</option>				</select>			</td>		</tr>		<tr style="display:table-row;" class="external' + count  + '">			<td><strong>Institution / University</strong></td>			<td><input name="runiversity[]" type="text" class="" value=""></td>		</tr>				<tr style="display:table-row;" class="external' + count  + '">			<td><strong>School / Faculty</strong></td>			<td><input name="rschool[]" type="text" class="" value=""></td>		</tr>		<tr style="display:table-row;" class="external' + count  + '">			<td><strong>Department</strong></td>			<td><input name="rdepartment[]" type="text" class="" value=""></td>		</tr>		<tr style="display:table-row;" class="external' + count  + '">			<td><strong>Telephone</strong></td>			<td><input name="rphone[]" type="number" class="" value=""></td>		</tr>		<tr style="display:table-row;" class="external' + count  + '">			<td><strong>Email</strong></td>			<td><input name="remail[]" type="email" class="" value=""></td>		</tr>						<tr>			<td><strong>Research position</strong></td>			<td><select name="rposition[]" class="form-control" style="width:250px;">				<option value="Principal Researcher">Principal Researcher </option>				<option value="Co-Researcher">Co-Researcher </option>				<option value="Researcher">Researcher</option>				<option value="Assistant">Assistant</option>				<option value="Administrative">Administrative</option>				</select>			</td>		</tr>		    </table>');
			count++; //= count+1;
		 	// $('[id^=container]').append('<table  width="100%"  border="0" cellpadding="5" cellspacing="0">              <tr>                <td width="205" height="28" bgcolor="#EEEEEE"><strong>Information</strong></td>                <td width="560" bgcolor="#EEEEEE"><strong>Input field</strong></td>              </tr>        <tr>            <td><strong>Name of Researcher </strong></td>            <td><input type="text" name="rname[]" value="" /></td>        </tr><tr>            <td><strong>Title</strong></td>            <td><select name="rtitle[]" class="form-control" style="width:250px;" ><option value="Professor">Professor </option><option value="Associate Professor">Associate Professor </option><option value="Doctor (Md)">Doctor (Md)</option><option value="Doctor (PhD)">Doctor (PhD)</option><option value="Engineer">Engineer (IR/Eng.)</option><option value="Mrs">Mrs.</option><option value="Mr">Mr.</option><option value="Ms">Ms.</option></select></td>        </tr><tr><td><strong>Gender</strong></td><td><select name="rtitle[]" class="form-control" style="width:250px;"><option value="Female">Female </option><option value="Male">Male </option><option value="Not specified">Not specified</option></select></td></tr><tr><td><strong>Institution / University</strong></td><td><input name="runiversity[]" type="text" class="" value=""></td></tr><tr><td><strong>School / Faculty</strong></td><td><input name="rschool[]" type="text" class="" value=""></td></tr><tr><td><strong>Department</strong></td><td><input name="rdepartment[]" type="text" class="" value=""></td></tr><tr><td><strong>Telephone</strong></td><td><input name="rphone[]" type="number" class="" value=""></td></tr><tr><td><strong>Email</strong></td><td><input name="remail[]" type="email" class="" value=""></td></tr><tr><td><strong>Research position</strong></td><td><select name="rposition[]" class="form-control" style="width:250px;"><option value="Principal Researcher">Principal Researcher </option><option value="Co-Researcher">Co-Researcher </option><option value="Researcher">Researcher</option><option value="Assistant">Assistant</option><option value="Administrative">Administrative</option></select></td></tr>    </table>');
		});
	</script>
</div>