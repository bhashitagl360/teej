<section class="container-fluid postbox">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="innr_postbox">
					<h3>Recent Posts</h3>
					<ul>
						<li>Images </li><li>Videos</li><li>Comments</li>
					</ul>
					
					<img src="images/top_image.png" alt="" class="topimage">
						<div class="innpostbx1">
							<div class="innpostbx11">
								<div class="row grid">
									<?php
										$visitorQuery = "SELECT id, firstname, email, message, image, document_type FROM visitor order by id desc limit 20";
										$result = $mysqli->query($visitorQuery);
										if ($result->num_rows > 0) {
									?>
									<?php while($row = $result->fetch_assoc()) { ?>
									<div class="col-xs-4 thumbnail">
										<div class="inrthumbnail">
											<div class="titlename">
												<h4><?php echo $row['firstname']; ?></h4>
											</div>
											<div class="postname">
												<h5>#TeejTaiyyari
												<?php
													$document_type = '';
													switch( $row['document_type'] ) {
														case "text":
															echo '<img src="'.siteUrl.'/images/text-image.png" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" />';
														break;
														case "image":
															echo '<img src="'.siteUrl.'/images/photoicon.png" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" />';
														break;
														case "video":
															echo '<img src="'.siteUrl.'/images/videoicon.png" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" />';
														break;
													}

													echo $document_type;
												?>
												</h5>
											</div>
											<?php
												$document_type = '';
												switch( $row['document_type'] ) {
													case "text":
														echo '<p>'.$row['message'].'</p>';
													break;
													case "image":
														echo '<p>'.$row['message'].'</p>';
														echo '<p> <img src="'.siteUrl.'/upload/'. $row['image'] .'" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" > </p>';
													break;
													case "video":
														echo '<p> <video controls>
																  <source src="'.siteUrl.'/upload/'.$row['image'].'" type="video/mp4">
																  Your browser does not support the video tag.
																</video> </p>';
													break;
												}
											?>
											
											<a href="javascript:void(0);" onclick="user_popup( '<?php echo siteUrl; ?>', '<?php echo $row['id']; ?>');">Read More +</a>
										</div>    
									</div>    
									<?php } }?>
									   
								</div>
								<div class="uploadbox">
									<a href="javascript:void(0)" onclick="share_teej_form('<?php echo siteUrl; ?>', '<?php echo shareTitle; ?>');">
										<img src="images/upload.png" alt="">
									</a>
								</div>
							</div>
						</div>
					<img src="images/bottom_image.png" alt="" class="bottomimage" />
				</div>
			</div>
		</div>
	</div>
</section>
