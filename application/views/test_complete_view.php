<div class="content">
	<div class="row mt40">
		<div class="col-xs-12">
			<div class="box">
				<div class="box_top complete_page">
					
					
					<h1 class="title">Test Complete!</h1>
					<h2 class="subtitle">Let's see how well you did.</h2>
					
					<div class="score_container row">
						<div class="col-xs-6 col-sm-6 center score">
							<span class="correct_answers" id="correct_answers">
								<?php if ($correct_answers < 2) echo $correct_answers; ?>
							</span>
							<span class="total_answers">/20</span>
						</div>
					</div>
					
					<?php $study_units_string = '';?>

					<?php if ($study_units != null ) :?>
						
						<div class="row study_units">
							<div class="col-xs-12 col-sm-5 center">
								<p class="t_c">Recommended Study Units:</p>
								<?php foreach ($study_units as $study_unit): ?>
									<div class="study_unit row">
										<a class="col-xs-5" href="<?php echo site_url('study/' . $result_id . '/' . str_replace(',', '-', $study_unit['unit']) . '/1' );?>">Unit: <?php echo $study_unit['unit'];?></a>
										<div class="col-xs-7"><?php echo $study_unit['category']; ?> </div>
										 
									</div>
									<?php $study_units_string = $study_units_string . '-' . str_replace(',', '-', $study_unit['unit']);?>
								<?php endforeach;?>
							</div>
						</div>	

					<?php endif; ?>

				</div>
	


				<div class="box_bottom">
					<a href="<?php echo site_url('test/start');?>" class="btn back_button f_l transition complete_btn">Retake Test</a>
					<a href="<?php echo site_url('study/' . $result_id . '/' . $study_units_string . '/1'); ?>" type="submit" class="btn btn-default next_button f_r transition complete_btn" name="submit">Start Studying</a>
				</div>

			</div>
		</div>
		
	</div>
</div>

<script>

	
	var targetCounter = <?php echo $correct_answers ?>;
	

</script>

