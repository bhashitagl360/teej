<?php
	require_once 'inc/config.php';

	$json=array();
	$post_data = $_POST['slug'];

	if( !empty( $post_data ) ) { 

        $post_name = base64_decode( $post_data );

		$cmsQuery = "SELECT title, description, image FROM cms WHERE slug=?";
        if ( $slug = $mysqli->prepare( $cmsQuery ) ) {

            if($slug === false) {
                die('Wrong CMS content SQL: ' . $cmsQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
            }

            /* bind param */
            $slug->bind_param( "s", $post_name );

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
                $json['error'] = "There is no result matching your";
            }  

            /* free results */
            $slug->free_result();

        } else {
            $json['error'] = "Menu Popup Query Issue: There is some issue with the menu query!";
        }
	} else {
		$json['error'] = "Menu Popup Query Issue: Slug is empty!";
	}

	echo json_encode($json);

	die();
?>