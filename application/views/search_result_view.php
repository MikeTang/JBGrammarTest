<div class="content">
	<div class="row mt40">
		<div class="col-xs-12">
			<div class="box">
				<div class="box_top">
					
					
					<h1 class="title"><?php echo $_SESSION['TITLE_GRAMMAR_DICT']; ?></h1>
					
					<div class="row">
						<div class="col-xs-10 center">
							<form action="<?php echo site_url("study/search_result"); ?>">
								<input type="text" name="query" class="col-xs-12 searchbar" value="<?php echo $query; ?>" placeholder="Search"/>
								<button class="searchbar_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
							</form>
							
						</div>
						
					</div>
					
					<?php $study_units_string = '';?>
					<?php $study_unit_tracker = 0;?>

					<?php if ($study_units != null ) :?>
						
						<div class="row study_units">
							<div class="col-xs-12 col-sm-5 center">
								<br><br>
								<?php foreach ($study_units as $study_unit): ?>
									<?php if ($study_unit->Grammar_Units != $study_unit_tracker):?>
										<div class="study_unit row">
											<a class="col-xs-5" href="
												<?php
													$toURL = "study/0/{$study_unit->Grammar_Units}/1";
													echo site_url($toURL);
												?>
											" 
											target="_blank" 
											>
											<?php echo "Unit: {$study_unit->Grammar_Units}"?></a>

											<div class="col-xs-7">
												<?php echo $study_unit->Category; ?>
											
											</div>
											 
										</div>
										<?php $study_unit_tracker = $study_unit->Grammar_Units;?>
									<?php endif;?>
									
									<?php $study_units_string = $study_units_string . '-' . $study_unit->Grammar_Units;?>
								<?php endforeach;?>
							</div>
						</div>	

					<?php endif; ?>

				</div>
	


				<div class="box_bottom">
					
					<a href="<?php echo site_url('study/0/' . $study_units_string . '/1'); ?>" type="submit" class="btn btn-default next_button f_r transition complete_btn" name="submit"><?php echo $_SESSION['BTN_STUDYALL']; ?></a>
				</div>

			</div>
		</div>
		
	</div>
</div>

