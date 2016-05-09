<div class="content">
	<div class="row mt40">
		<div class="col-xs-12 t_c nopl nopr">			
			<img class="main_logo" src="<?php echo asset_url();?>img/main_logo.png"/>
		</div>
		<?php if ($loggedIn == 1) :?>
			<div class="col-xs-4 center t_c nopl nopr">	
				<a class="btn btn-default green_button transition home_page" href="<?php echo site_url('test/start');?>"> Start Test</a> 
			</div> 
		<?php else :?>
			<div class="col-xs-6 center tc nopl nopr">
				<div class="row">
					<div class="col-xs-6">
						<a class="btn btn-default back_button transition home_page" href="<?php echo site_url('login/index');?>"> Log In</a>
					</div>
					<div class="col-xs-6">
						<a class="btn btn-default green_button green_button2 transition home_page" href="<?php echo site_url('signup/index');?>"> Sign Up</a>
					</div>
					
					
				</div>
				

			</div>
		<?php endif; ?>
		
		
	</div>
</div>


