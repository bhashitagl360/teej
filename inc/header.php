<section class="bannerbox">
	<header >
		<div class="col-xs-12" >
			<div class="logo">
				<a href="javascript:void(0);"><img src="images/logo.png" alt="TeejTaiyyari" /></a>
			</div>
			<div class="menubx">
				<?php

					$menuQuery = "SELECT name, slug FROM menu order by position";

					/* prepare statement */
					$menu = $mysqli->prepare( $menuQuery );

					// raise issue if false
					if($menu === false) {
	                    die('Wrong Menu Insert SQL: ' . $menuQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
	                }

		            /* execute query */
		            $menu->execute();

		            /* store result */
		            $menu->store_result();

		            /* Bind the result to variables */
		            $menu->bind_result($name, $slug);

					if ($menu->num_rows > 0) {
						
				?>
				<ul>
					<?php while ( $menu->fetch() ) { ?>
						<li>
							<a href="javascript:void(0)" onclick="menu( '<?php echo base64_encode( $slug ); ?>' );">
							<?php echo $name; ?>
							</a>
						</li>
					<?php } ?>
				</ul>
				<?php } /* free results */$menu->free_result(); ?>
			</div>
		</div>
	</header>
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	  	<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			<li data-target="#carousel-example-generic" data-slide-to="3"></li>
		</ol>

	  	<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
			  <img src="images/banner1.jpg" alt="" class="bannerimage" />		
				
			</div>
			<div class="item">
			  <img src="images/banner2.jpg" alt="" class="bannerimage" />		
				
			</div>
			<div class="item">
			  <img src="images/banner3.jpg" alt="" class="bannerimage" />		
				
			</div>
			<div class="item">
			  <img src="images/banner4.jpg" alt="" class="bannerimage" />		
				
			</div>
		</div>
	  
		<div class="carousel-caption">
			<p onclick="share_teej_form();">Shuru Karo #TeejTaiyyari</p>
		</div>
		<div class="dummyimage">
			<img src="images/banner_below.png" alt="" />
		</div>
	</div>
</section>
