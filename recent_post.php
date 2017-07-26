<?php
	require_once 'inc/config.php';

	$json=array();
    $recent_posts = '';

    $visitorQuery = "SELECT id, firstname, email, message, image, document_type 
                     FROM visitor
                     WHERE deleted=0
                     AND status=1
                     ORDER BY id DESC
                     LIMIT 10";

    $result = $mysqli->query($visitorQuery);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
		
			$firstname = '';
			if( strlen( $row['firstname'] ) > 20 ) {
                $firstname = substr($row['firstname'], 0, 25 ) .' ...';
            }  else {
                $firstname = $row['firstname'];
            }
			
            $recent_posts .= '<div class="col-xs-4 thumbnail">';
                $recent_posts .= '<div class="inrthumbnail">';
                    $recent_posts .= '<div class="titlename">';
                        $recent_posts .= '<h4>'.$firstname.'</h4>';
                    $recent_posts .= '</div>';
                    $recent_posts .= '<div class="postname">';
                        $recent_posts .= '<h5>';
                            $recent_posts .= '#TeejTaiyyari';
                            $document_type = '';
                            switch( $row['document_type'] ) {
                                case "text":
                                    $recent_posts .= '<img src="'.siteUrl.'/images/text-image.png" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" />';
                                break;
                                case "image":
                                    $recent_posts .= '<img src="'.siteUrl.'/images/photoicon.png" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" />';
                                break;
                                case "video":
                                    $recent_posts .= '<img src="'.siteUrl.'/images/videoicon.png" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" />';
                                break;
                            }
                        $recent_posts .= '</h5>';
                    $recent_posts .= '</div>';

                    switch( $row['document_type'] ) {
                        case "text":
                            $recent_posts .= '<p>'.$row['message'].'</p>';
                        break;
                        case "image":
                            $recent_posts .= '<p>'.$row['message'].'</p>';
                            $recent_posts .= '<p> <img src="'.siteUrl.'/upload/'. $row['image'] .'" alt="'.$row['firstname'].'" title="'.$row['firstname'].'" > </p>';
                        break;
                        case "video":
                            $recent_posts .= '<p> <video controls>
                                      <source src="'.siteUrl.'/upload/'.$row['image'].'" type="video/mp4">
                                      Your browser does not support the video tag.
                                    </video> </p>';
                        break;
                    }
                    $user_id = $row['id'];
                    $site_url = siteUrl;
                    $onclick = "user_popup('".$site_url."', '".$user_id."')";
                    $recent_posts .= '<a href="javascript:void(0);" onclick="'.$onclick.'">Read More +</a>';
                $recent_posts .= '</div>';
            $recent_posts .= '</div>';
        }

        $json['message'] = $recent_posts;
        echo json_encode( $json );
        die();
    } else {
        $json['error'] = "Recent Post OnWindowLoad Query Issue: There is no recent post!";
    }

	echo json_encode( $json );

	die();
?>