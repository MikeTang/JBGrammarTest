<div class="content">
	<div class="row mt40">
		<div class="col-xs-12">
			<div class="box">
				<div class="box_top">
					
					<div class="hud row">
						<div class="col-xs-12 col-sm-10">
							<div class="progress_bar">
								<?php for ($x = 1; $x <= 20; $x++) :?>
									<a href="<?php echo site_url('test/grammar/'. ($x) );?>">
										<span class="progress-<?php echo $x;?> 
										<?php if (array_key_exists($x-1,$submittedAnswers)){
											if ($submittedAnswers[$x-1]['submitted answer'] != "") {
												echo "complete";
											}
											else{
												echo "empty";
											}	
										}?> 
										<?php if ($x == $num) echo "current";?> 

										"><?php echo $x; ?></span>
									</a>
									
								<?php endfor; ?>
							</div>
						</div>

						<div class="col-xs-12 col-sm-2">
							<div id="timer">
								<i class="fa fa-clock-o" aria-hidden="true"></i> <span id="countdown">00:00</span>
							</div>
						</div>

						<div class="col-xs-12"><div class="line"></div></div>
					</div>
					
					<h1 class="title"><?php echo $_SESSION['TITLE_COMPLETESENTENCE']; ?></h1>
					<h2 class="subtitle"><?php echo $_SESSION['TEXT_SELECTALL']; ?></h2>
					
					<div class="sentence"><?php echo $num.'. '. $question->tests;?></div>
					
					<div class="row">
						<div class="form_wrapper">
						<?php echo form_open('test/submit') ?>
						
						<div class="col-xs-12 col-sm-4">
						<?php if ($question->choice_A != '') :?>
							<label class="answer_wrapper">		 
								<input class="answer" type="checkbox" name="answer_a" value="A" <?php if (strpos($answer, 'A') !== false) echo 'checked'; ?>> <?php echo $question->choice_A;?>
							</label>
						<?php endif;?>	
						</div>
						
						<div class="col-xs-12 col-sm-4">
						<?php if ($question->choice_B != '') :?>
							<label class="answer_wrapper">		 
								<input class="answer" type="checkbox" name="answer_b" value="B" <?php if (strpos($answer, 'B') !== false) echo 'checked'; ?>> <?php echo $question->choice_B;?>
							</label>
						<?php endif;?>	
						</div>

						<div class="col-xs-12 col-sm-4">
						<?php if ($question->choice_C != '') :?>
							<label class="answer_wrapper">		 
								<input class="answer" type="checkbox" name="answer_c" value="C" <?php if (strpos($answer, 'C') !== false) echo 'checked'; ?>> <?php echo $question->choice_C;?>
							</label>
						<?php endif;?>	
						</div>

						<div class="col-xs-12 col-sm-4">
						<?php if ($question->choice_D != '') :?>
							<label class="answer_wrapper">		 
								<input class="answer" type="checkbox" name="answer_d" value="D" <?php if (strpos($answer, 'D') !== false) echo 'checked'; ?>> <?php echo $question->choice_D;?>
							</label>
						<?php endif;?>	
						</div>

						<div class="col-xs-12 col-sm-4">
						<?php if ($question->choice_E != '') :?>
							<label class="answer_wrapper">		 
								<input class="answer" type="checkbox" name="answer_e" value="E" <?php if (strpos($answer, 'E') !== false) echo 'checked'; ?>> <?php echo $question->choice_E;?>
							</label>
						<?php endif;?>	
						</div>
					</div>
										
					
						<input class="submitted_answer" type="hidden" autocomplete="off" name="submitted_answer" value="<?php echo $answer;?>" placeholder="Type Answer" />
						<input type="hidden" autocomplete="off" name="group_no" value=<?php echo $num; ?> />
						<input type="hidden" autocomplete="off" name="question_no" value=<?php echo $question->No; ?> />
						
					</div>

				</div>
				<div class="box_bottom">
					
					<?php if ($num > 1):?>
					<a href="<?php echo site_url('test/grammar/'. ($num-1) );?>" class="btn back_button f_l transition"><?php echo $_SESSION['BTN_BACK']; ?></a>
					<?php endif;?>

					<button type="submit" class="btn btn-default next_button f_r transition" name="submit"><?php echo $_SESSION['BTN_NEXT']; ?></button>
				</div>

				</form>


			</div>
		</div>
		
	</div>
</div>

<script>

	(function() {
		//convert date to firefox format
		var startTime = '<?php echo $startTime;?>';
		var timeLimit = <?php echo TIME_LIMIT; ?>; 
		// if(startTime.indexOf('Z')==-1)startTime=startTime.replace(' ','T')+'Z';

		// set the date we're counting down to
		// var start_date_time = new Date(startTime);
		//start_date_time.setUTCHours(15);

		// start_date_time = start_date_time.getTime();
		displayCountdown(startTime * 1000, timeLimit);

	})();

</script>


