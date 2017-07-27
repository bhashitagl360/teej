<?php 
    require_once "inc/admin.php"; 
    require_once "../csrf.class.php";
    $csrf = new csrf();
    $token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);

    if (isset($_POST['page'])):
        $paged = $_POST['page'];
        $siteUrl = $_POST['siteUrl'];
        $sql = "SELECT * FROM visitor WHERE deleted=0 order by id desc limit $paged,10 ";
        $result = $mysqli->query($sql); 
       
        $num_rows = $result->num_rows;
        
        $html = '';
        if ($num_rows > 0) {
            while ($data = mysqli_fetch_array($result)) {

                $postID = $data["id"];
                $status = $data["status"];
                $firstname = $data["firstname"];
                $image = $data["image"];
                $status = $data["status"];

                $delete = "deleteMessage('".$postID."', '".$token_id."', '".$token_value."')";
                $inactive = "inactiveMessage('".$postID."', '".$token_id."', '".$token_value."')";
                $active = "activeMessage('".$postID."', '".$token_id."', '".$token_value."')";

                $t1 = ($status == 1) ? '' : "style='display:none'";
                $t2 = ($status == 0) ? '' : "style='display:none'";
                
                $html .= '<li id="main_'.$postID. '">';
                    $html .= '<div class="main doc">';
                        $html .= '<div class="queto">';
                            $html .= '<img src="'. siteUrl. '/images/top_qeto.png" alt="'. $firstname. '" />';
                        $html .= '</div>';

                        $html .= '<div class="right_icon">';
                            $html .= '<a href="javascript:void(0);" class="icon-btn" title="Delete" onclick="'.$delete.'"><i class="fa fa-trash"></i></a>';

                            $html .= '<a href="javascript:void(0);" '. $t1 .' class="icon-btn" title="Inactive" id="inactive_'.$postID.'"  onclick="'.$inactive.'"><i class="fa fa-close"></i></a>';

                            $html .= '<a href="javascript:void(0);" '. $t2 .' class="icon-btn" title="Active" id="active_'.$postID.'" onclick="'.$active.'"><i class="fa fa-check"></i></a>';
                        
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
                        $html .= '</div>';
                        $html .= '<div class="name">';
                            $html .= $firstname;
                        $html .= '</div>';

                        switch( $data['document_type'] ) {
                            case "image":
                                $html .= '<div class="video_box"><img src="' . siteUrl . '/upload/' . $image . '" alt="' . $firstname . '" /></div>';
                            break;

                            case "video":
                                $videoURL = siteUrl.'/upload/'.$image;
                                $html .= '<p> <video controls><source src="'.$videoURL.'" type="video/mp4">Your browser does not support the video tag.</video> </p>';
                            break;
                        }

                        if( strlen( $data['message'] ) > 100 ) {
                            $html .= '<p>'. substr($data['message'], 0, 100).' ... </p>';
                        } else {
                            $html .= '<p>'. $data['message'] .'</p>';
                        }
                    $html .= '</div>';
                $html .= '</li> ';
            }
        }else{
            $html = '';
        }

        echo $html;die();
        
    endif;
?>