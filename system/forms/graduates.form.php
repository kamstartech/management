
<br>
<div class="heading">Print list of Graduates per Program</div>
<form id="graduateprogram" name="graduateprogram" method="get"  action="<?php echo $this->core->conf['conf']['path'] . "/examination/graduateslist/"; ?>">

<?php       $select = new optionBuilder($this->core);
			$program = $select->showexamsStudies(null, $programselected);
			
	echo '<div class="label">Program:  <select name="program" id="program" class="submit" width="250" style="width: 250px">
			' . $program . '
		  </select></div><br>
		 ';
			
?>
	<br>
	<div class="label">Print graduates from intake year and semester:</div>
	<br>
	<select name="beforeyear" id="beforeyear" class="submit" width="250" style="width: 250px">
		<option value="2016" selected>2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020" >2020</option>
	</select>
	<select name="beforesemester" id="beforesemester" class="submit" width="250" style="width: 250px">
		<option value="0">Both Semesters</option>
		<option value="1">Semester 1</option>
		<option value="2">Semester 2</option>
	</select>
		
	<br>	
	<div class="label">Print graduates to intake year and semester:</div>
	<br>
	<select name="afteryear" id="afteryear" class="submit" width="250" style="width: 250px">
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020" selected>2020</option>
	</select>
	<select name="aftersemester" id="aftersemester" class="submit" width="250" style="width: 250px">
		<option value="0">Both Semesters</option>
		<option value="1">Semester 1</option>
		<option value="2">Semester 2</option>
	</select>
	<br>
	<br>
	<input type="submit" class="submit" value="Show graduates list"/>
</form>