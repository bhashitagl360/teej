<section class="container-fluid contentbox">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="innr_contentbox">
					<h1><img src="images/heading.png" alt="" /></h1>
					<p>“Padhaaro maahre des..” says the Teej ready land of the pink city! 
It’s all set to brighten up your celebrations with the shades of Rajasthani tradition - Folk dances and songs, Mehndi and churis, Ghewar and more. Words alone can’t do justice to something we regard as an ‘experience’. So, we would like to invite you for a Teejful experience in Jaipur, July 26-27, Tripolia Gate, 6pm onwards.
					<a class="readbox" href="javascript:void(0)" onclick="menu( '<?php echo base64_encode( 'about_teej' ) ?>' );">
						Read more...
					</a>
					</p>
					
				</div>
			</div>
			
			<div class="col-xs-12">
				<div class="row mobilerow">
					<?php
						$string = "Yes";
						$cmsQuery = "SELECT slug, excerpt, front_image FROM cms WHERE is_front=?";

						/* prepare statement */
						$cms = $mysqli->prepare( $cmsQuery );

						// raise issue if false
						if($cms === false) {
		                    die('Wrong CMS Insert SQL: ' . $cmsQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
		                }

						/* bind param */
			            $cms->bind_param( "s", $string );

			            /* execute query */
			            $cms->execute();

			            /* store result */
			            $cms->store_result();

			            /* Bind the result to variables */
			            $cms->bind_result($slug, $excerpt, $front_image);

						if ($cms->num_rows > 0) {
							while ($cms->fetch()) {
					?>
					<div class="col-sm-4 no_padding">
						<div class="detailbox detailbox_<?php echo $slug; ?>">
							<img src="<?php echo $front_image; ?>" alt="<?php echo str_replace('_', ' ', strtoupper( $slug ) ); ?>" />
							<h3><?php echo str_replace('_', ' ', strtoupper( $slug ) ); ?></h3>
							<p><?php echo stripslashes( $excerpt ); ?></p>
							<a href="javascript:void(0);" data-toggle="modal" onclick="menu( '<?php echo base64_encode( $slug ); ?>' );">
								<img src="images/more_<?php echo $slug; ?>.png" alt="" />
							</a>
						</div>
					</div>
					<?php } } /* free results */$cms->free_result(); ?>
					
				</div>
			</div>
		</div>
	</div>
</section>
