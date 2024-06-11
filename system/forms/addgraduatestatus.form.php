<form id="edithostels" name="edithostels" method="post" action="<?php echo $this->core->conf['conf']['path'] . "/graduates/assignpass/" . $this->core->subitem; ?>">
	<p></p>
	<table width="768" border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td width="225" height="28" bgcolor="#EEEEEE"><strong><?php echo $Programme ?></strong></td>
			<td width="200" bgcolor="#EEEEEE"><strong><?php echo $Description ?></strong></td>
        </tr>

        <tr>
            <td width="205" height="28" bgcolor="#EEEEEE"><strong><?php echo 'Programme semester count: '. $timeBlocks ?></strong></td>
			<td width="200" bgcolor="#EEEEEE"></td>
        </tr>

		 <tr>
                        <td><strong><?php echo $this->core->translate("Hostel name"); ?> </strong></td>
                        <td>
                                <input type="text" name="name" class="form-control" style="width:260px;" value ="<?php echo $hostelName; ?>"  /></td>
                        <!-- <td><?php echo $this->core->translate("Name of hostel"); ?></td> -->
                </tr>
                <tr>
                        <td><strong><?php echo $this->core->translate("Number of rooms"); ?> </strong></td>
                        <td>
                                <input type="text" name="room" class="form-control" style="width:260px;" value="<?php echo $totalRooms; ?>"/></td>
                        <!-- <td><?php echo $this->core->translate("Number of rooms in the hostel");?></td> -->
                </tr>
                <tr>
                        <td><strong><?php echo $this->core->translate("Gender"); ?></strong></td>
                        <td>
                                <select name="gender" class="form-control" style="width:260px;">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Mixed">Mixed</option>
                                </select></td>
                        <!-- <td></td> -->
                </tr>
                <tr>
                        <td><strong><?php echo $this->core->translate("Undergraduate room price"); ?> </strong></td>
                        <td>
                                <b>K</b> <input type="text" name="roomPrice_ug" class="form-control" style="width:260px;" value = "<?php echo $roomPrice_ug; ?>"/></td>
                        <!-- <td><?php echo $this->core->translate("Number of students the hostel can hold");?></td> -->
                </tr>

                <tr>
                        <td><strong><?php echo $this->core->translate("Postgraduate room price"); ?> </strong></td>
                        <td>
                                <b>K</b> <input type="text" name="roomPrice_pg" class="form-control" style="width:260px;" value = "<?php echo $roomPrice_pg; ?>"/></td>
                        <!-- <td><?php echo $this->core->translate("Number of students the hostel can hold");?></td> -->
                </tr>

                <tr>
                        <td><strong><?php echo $this->core->translate("Lock status");?></strong></td>
                        <td>
                                <select name="lockstatus" class="form-control" style="width:260px;">
                                        <option value="1">Open</option>
                                        <option value="0">Locked</option>
                                </select></td>
                        <!-- <td></td> -->
                </tr>
<!-- 
             	 <tr>
                        <td><strong><?php echo $this->core->translate("Hostel location"); ?> </strong></td>
                        <td>
                                <input type="text" name="location" value ="<?php echo $fetch[2]; ?>"  /></td>
                        <td><?php echo $this->core->translate("Location of the hostel"); ?></td>
                </tr> -->

                <!-- <tr>
                        <td><strong><?php echo $this->core->translate("Optional description"); ?></strong></td>
                        <td>
                                <textarea rows="4" cols="37" class="editable" name="description" ><?php echo $fetch[5]?> </textarea>
                        </td>
                        <td></td><tr>
                        <td><strong><?php $this->core->translate("hostels location"); ?></strong>
                        <td></td>
                </tr> -->

	</table>
	<br />

	<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Save hostels" />
	<p>&nbsp;</p>

</form>