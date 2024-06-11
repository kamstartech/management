
<div class="heading">Search by student number</div>
<form id="results" name="results" method="get"  action="<?php echo $this->core->conf['conf']['path'] . "/examination/results/"; ?>">
	<div class="label">Enter student number:</div>
	<input type="text" name="uid" id="student-id" class="submit" style="width: 125px"/>
	<br><div class="label">Select  Year:</div>
	<select name="year" id="year" class="submit" width="250" style="width: 250px">
		<option value="2009">2009</option>
		<option value="2010">2010</option>
		<option value="2011">2011</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
		<option value="2015">2015</option>
		<option value="2016" >2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019" selected>2019</option>
		<option value="2020">2020</option>
	</select>
	<br><div class="label">Select  Semester:</div>
	<select name="semester" id="semester" class="submit" width="250" style="width: 250px">
		<option value="1">1</option>
		<option value="2">2</option>
	</select>
<br><div class="label">&nbsp;</div>

	<input type="submit" class="submit" value="Print Exam Slip"/>
</form>
<br>
<div class="heading">Print list of exam slips per intake</div>
<form id="overview" name="overview" method="get"  action="<?php echo $this->core->conf['conf']['path'] . "/examination/batch/"; ?>">
	<div class="label">Mode of delivery</div>
	<select name="time" id="time" class="submit" width="250" style="width: 250px">
		<option value="Fulltime">Fulltime</option>
		<option value="Distance">Distance</option>
		<option value="Parttime">Part-time</option>
	</select>

<br>
	<div class="label">Select Year:</div>

	<select name="year" id="year" class="submit" width="250" style="width: 250px">
		<option value="2009">2009</option>
		<option value="2010">2010</option>
		<option value="2011">2011</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
		<option value="2015">2015</option>
		<option value="2016" selected>2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020">2020</option>
		<option value="%">ALL</option>
	</select>
	<br><div class="label">Select  Semester:</div>
	<select name="semester" id="semester" class="submit" width="250" style="width: 250px">
		<option value="1">1</option>
		<option value="2">2</option>
	</select>

	<br><div class="label">Program</div>
	<select name="program" id="program" class="submit" width="250" style="width: 250px">
		<?php echo $programs; ?>
	</select>

	<input type="submit" class="submit" value="Show print list"/>
</form>
