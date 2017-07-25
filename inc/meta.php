<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 user-scalable=0"/>
	<link rel="shortcut icon" href="<?php echo siteUrl; ?>/images/favicon.ico" type="image/x-icon" />
	<title><?php echo site_title; ?></title>
	<script type="text/javascript">
		 var siteURL = '<?php echo siteUrl; ?>',
		 	key = '<?php echo token_id; ?>',
		 	value = '<?php echo token_value; ?>';
	</script>
	<?php 
		for( $c=0; $c<count($css); $c++) {
			echo '<link href="'. siteUrl.'/'.$css[$c] .'" type="text/css" rel="stylesheet" />';
		}
	?>
</head>
