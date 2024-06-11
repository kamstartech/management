</div>
<div class="footer">

	<div class="center">

	<div class="float">
		<form name="templatef" id="templatef" action="<?php echo $this->core->conf['conf']['path']; ?>/template" method="POST">
			<select name="templated" id="templated" onchange='this.form.submit()'>
			<option value="0">template</option>	
			<?php echo $this->core->showTemplate(); ?>
			</select>
			<input name="template" id="template" type="hidden"  value="" />
		</form>
	</div>
	<div class="float">
		<form name="languagef" id="languagef" action="<?php echo $this->core->conf['conf']['path']; ?>/template" method="POST">
			<select name="languaged" id="languaged" onchange='this.form.submit()'>
			<option value="0">language</option>
			<?php echo $this->core->showLanguages(); ?>
			</select>
			<input name="template" id="template" type="hidden"  value="" />
		</form>
	</div>

	<div class="float" style="padding-top: 25px;">
		Copyright © 2011-2019 <a href="http://www.edurole.com">EduRole </a>|  <b>Powered by <a href="http://www.edurole.com">EduRole</a></b> <br> <div style="color: #999;">	
		Edurole is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons Attribution-NC-ND 3.0 Unported License</a>.
		<br> You accessing EduRole from: <?php echo $_SERVER['REMOTE_ADDR']; ?>
	</div>

	<script>
		jQuery('#templated').ddslick({width:120,onSelected: function(data){
			if(data.selectedIndex > 0) {
			 $('#template').val(data.selectedData.value);
		        document.getElementById("templatef").submit();
			}
		    }
		});

		jQuery('#languaged').ddslick({width:120,onSelected: function(data){
			if(data.selectedIndex > 0) {
			 $('#template').val(data.selectedData.value);
		        document.getElementById("languagef").submit();
			}
		    }
		});
	</script>
	
	</div>

</div>

</div>
</div>
</div></div>
