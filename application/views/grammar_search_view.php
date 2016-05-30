<div class="content">
	<div class="row mt40">
		<div class="col-xs-12">
			<div class="box">
				<div class="box_top search_page">


					<h1 class="title"><?php echo $_SESSION['TITLE_GRAMMAR_DICT']; ?></h1>

					<div class="row">
						<div class="col-xs-10 center">
							<form action="<?php echo site_url("study/search_result"); ?>">
								<input type="text" name="query" class="col-xs-12 searchbar" placeholder="Search"/>
								<button class="searchbar_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
							</form>

						</div>

					</div>

				</div>

			</div>
		</div>

	</div>
</div>
