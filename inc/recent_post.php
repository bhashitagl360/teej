<section class="container-fluid postbox">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="innr_postbox">
					<h3>Recent Posts</h3>
					<ul>
						<li>Images </li><li>Videos</li><li>Comments</li>
					</ul>
					
					<img src="<?php echo siteUrl; ?>/images/top_image.png" alt="" class="topimage">
						<div class="innpostbx1">
							<div class="innpostbx11">
								<div class="row grid" id="recent_posts">
									   
								</div>
								<div class="uploadbox" id="uploadDiv" style="display: none;">
									<a href="javascript:void(0)" class="loadmore">
										<img src="<?php echo siteUrl; ?>/images/more_button.png" alt="Load More" />
									</a>
									<a href="javascript:void(0)" onclick="share_teej_form();">
										<img src="<?php echo siteUrl; ?>/images/upload.png" alt="" />
									</a>
									<input type="hidden" id="result_no" value="10" />
								</div>
							</div>
						</div>
					<img src="<?php echo siteUrl; ?>/images/bottom_image.png" alt="" class="bottomimage" />
				</div>
			</div>
		</div>
	</div>
</section>
