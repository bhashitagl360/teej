<?php require_once "inc/admin.php"; ?>
<?php
if (isset($_POST['page'])):
    $paged = $_POST['page'];
    $siteUrl = $_POST['siteUrl'];
    $sql = "SELECT * FROM visitor WHERE deleted=0 order by id desc limit $paged,10 ";
    $result = $mysqli->query($sql); 
   
    $num_rows = $result->num_rows;
    
    $html = '';
    if ($num_rows > 0) {
       while ($data = mysqli_fetch_array($result)) {
           $id = $data['id'];
            $firstname = $data['firstname'];
            $image = $data['image'];
            $message = $data['message'];
            $status = $data['status'];
            $t1 = ($status == 1) ? '' : "style='display:none'";
            $t2 = ($status == 0) ? '' : "style='display:none'";
            
            $html .= '<li id="main_'.$id.'"><div class="main doc"><div class="queto">';
            $html .= '<img src="' . $siteUrl . '/images/top_qeto.png" alt=' . $firstname . ' />';
            $html .= '</div><div class="right_icon">';
            $html .= '<a href="javascript:void(0);" class="icon-btn" title="Delete" onclick="deleteMessage('.$id.');"><i class="fa fa-trash"></i></a>';
            $html .= '<a href="javascript:void(0);"  '.$t1.' class="icon-btn" title="Inactive" id="inactive_'.$id.'" onclick="inactiveMessage('.$id.');"><i class="fa fa-close"></i></a>';
            $html .= '<a href="javascript:void(0);" '.$t2.' class="icon-btn" title="Active" id="active_'.$id.'" onclick="activeMessage('.$id.');"><i class="fa fa-check"></i></a>';

            switch( $data['document_type'] ) {
                case "text":
                    $html .= '<img src="' . siteUrl . '/images/text-image.png" alt="' . $firstname . '" />';
                break;

                case "image":
                    $html .= '<img src="' . siteUrl . '/images/photoicon.png" alt="' . $firstname . '" />';
                break;

                case "video":
                    $html .= '<img src="' . siteUrl . '/images/videoicon.png" alt="' . $firstname . '" />';
                break;
            }

            $html .= '</div><div class="name">' . $firstname . '';
            $html .= '</div>';

            switch( $data['document_type'] ) {
                case "image":
                    $html .= '<div class="video_box">';
                    $html .= '<img src="' . siteUrl . '/upload/' . $image . '" alt="' . $firstname . '" />';
                    $html .= '</div>';
                break;

                case "video":
                    $videoURL = siteUrl.'/upload/'.$image;
                    $html += '<p> <video controls>';
                        $html += '<source src="'+videoURL+'" type="video/mp4">';
                        $html += 'Your browser does not support the video tag.';
                    $html += '</video> </p>';
                break;
            }
            
            if( strlen( $data['message'] ) > 100 ) {
                $html .= '<p>' .  substr($data['message'], 0, 100).' ...</p></div></li>';
            } else {
                $html .= '<p>' .  $data['message'].'</p></div></li>';
            }
            
        }
        echo $html;
    }else{
        echo '0';
    }
    
endif;
?>