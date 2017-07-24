<?php 
	for( $j=0; $j<count($js); $j++) {
		echo '<script type="text/javascript" src="'. $js[$j] .'"></script>';
	}
?>
<script type="text/javascript">
	$( window ).on( "load", recent_posts() );
</script>