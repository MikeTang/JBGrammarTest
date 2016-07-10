
<div class="content">
<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
?>
	<div class="row mt40">
		<div class="col-xs-12">
			<div class="box">
				<div class="box_top search_page">

					<img class="main_banner " src=
						<?php 
						$asset_url = asset_url();
						echo "$asset_url/img/banner.png";
						?>
					>

					<div class="row">
						<div class="col-xs-10 center">
							<form action="<?php echo site_url("study/search_result"); ?>">
								<input type="text" name="query" class="col-xs-12 searchbar" placeholder="Search"/>
								<button class="searchbar_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
							</form>

						</div>

					</div>

				</div>


<div>
<!-- 			<img class="tip_icon_gif " src=
						<?php 
						// $asset_url = asset_url();
						$asset_url = asset_url();
						echo "$asset_url/img/tip.png";
						?>
						> -->

		<img class="main_intro_gif " src=
						<?php 
						// $asset_url = asset_url();
						$asset_url = asset_url();

						echo "$asset_url/img/search_intro.gif";
						?>
						>
					</div>

			</div>

					</div>

		</div>

	</div>
</div>
