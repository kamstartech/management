		</main>
	</div>
</div>
			  

<div class="footer">
	<div class="center">




		<div class="float" style="">
			<img src="https://edurole.mu.ac.zm/templates/edurole/images/apple-touch-icon-precomposed.png">
		</div>
		<div class="float" style="">
			Copyright © 2011-2022 <b> Powered by <a href="http://www.edurole.com">EduRole </a> </b>| <b> Customized by <a href="http://www.unilus.ac.zm">Corelink Consulting Ltd.</a></b> <br> <div style="color: #999;">	
			Edurole is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons Attribution-NC-ND 3.0 Unported License</a>.
			<br> You accessing EduRole from: <?php echo $_SERVER['REMOTE_ADDR']; ?>
		</div>

		<div class="float">
			<form name="templatef" id="templatef" action="<?php echo $this->core->conf['conf']['path']; ?>/template" method="POST">
				<select name="templated" id="templated" onchange='this.form.submit()'>
				<option value="0">Template</option>	
				<?php echo $this->core->showTemplate(); ?>
				</select>
				<input name="template" id="template" type="hidden"  value="" />
			</form>
		</div>
		<div class="float">
			<form name="languagef" id="languagef" action="<?php echo $this->core->conf['conf']['path']; ?>/template" method="POST">
				<select name="languaged" id="languaged" onchange='this.form.submit()'>
				<option value="0">Language</option>
				<?php echo $this->core->showLanguages(); ?>
				</select>
				<input name="template" id="template" type="hidden"  value="" />
			</form>
		</div>
	</div>
</div>
