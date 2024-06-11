<div class="floater">


	<div class="hr">
		<div class="homeboxr"><br>
			<form name="login" action="login" method="POST">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="2" valign="top" style="padding-left:0px;"><h2><strong>STAFF LOGIN</strong></h2>

							<p> Please use your or username and password to log in to the system. <br>
							</p></td>
					</tr>
					<tr>
						<td width="124" valign="middle"><b>Username</b></td>
						<td width="363" valign="top"><input type="text" name="username" class="login" id="username"/>
						</td>
					</tr>
					<tr>
						<td valign="middle"><b>Password</b></td>
						<td valign="top"><input type="password" name="password" class="login" id="password"/></td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
						<td valign="top">
								<input type="submit" class="login" name="submit" id="submit" value="Login"/>
						</td>
					</tr>
					<tr>
						<td colspan="2" valign="top" style="padding-left:0px;">
							<p><br><a href="<?php echo $this->core->conf['conf']['path']; ?>/meetings/schedule"><strong> SCHEDULE MEETING</strong></a><br></p>
						</td>
					</tr>
				</table>	
			</form>
		</div>
	</div>

