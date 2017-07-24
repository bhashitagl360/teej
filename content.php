<?php
	require_once 'inc/config.php';

	$json=array();
	$mSlug = $_POST['slug'];

	if( !empty( $mSlug ) ) { 

		$cmsQuery = "SELECT title, description, image FROM cms WHERE slug=?";
        if ($slug = $mysqli->prepare($cmsQuery)) {

            /* bind param */
            $slug->bind_param("s", $mSlug);

            /* execute query */
            $slug->execute();

            /* store result */
            $slug->store_result();

            /* Get the number of rows */
            $num_of_rows = $slug->num_rows;

            /* Bind the result to variables */
            $slug->bind_result($title, $description, $image);

            if ($num_of_rows >= "1") { 
                while ($slug->fetch()) {
                   $json['title'] = $title;
                   $json['description'] = stripslashes( $description );
                   $json['image'] = $image;
                }
            }else{
                $json['error'] = "Menu Popup Query Issue: There is some issue with the menu query!";
            }  

            /* free results */
            $slug->free_result();

        }
	} else {
		$json['error'] = "Menu Popup Query Issue: Slug is empty!";
	}

	echo json_encode($json);

	die();
?>