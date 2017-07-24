<?php
/* -----------------------------------------------------------------------------------------
   Adglobal360 - Vipin Yadav - http://www.adglobal360.com/
   -----------------------------------------------------------------------------------------
*/
    require_once('config/config.php'); 

    $demo_mode = false;
    $upload_dir = 'documents/image/';
    $allowed_ext = array('jpg', 'jpeg', 'png');
    define ("MAX_SIZE","20971520"); // 2mb = 2097152 // 3mb => 3145728 

    if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
            exit_status('Error! Wrong HTTP method!');
    }  
	
    if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){
        
        $pic = $_FILES['pic']; 

        if(!in_array(get_extension($pic['name']),$allowed_ext)){
                exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');
        } 

        if($pic['size'] > MAX_SIZE) {
                exit_status("Can't upload file! Limit is high!");
        } 

        // Move the uploaded file from the temporary 
        // directory to the uploads folder:

        $imgExt = get_extension($pic['name']);
        $uID = trim($_GET['user_id']);
        $dateVar = date("y-m-d-H-m-s");
        $hash = 'karsalaam';
        $newImageIs = $uID.'-'.$dateVar.'-'.$hash.'.'.$imgExt;
        
        $document_type = $_GET['document_type'];
        $user_id = $_GET['user_id'];
         
          
        if(move_uploaded_file($pic['tmp_name'], $upload_dir.$newImageIs)) {

            $sql = "UPDATE user_data SET document_type = '$document_type', image = '$newImageIs' where id = '$user_id'";
            
            if ($conn->query($sql) === TRUE) {
                $json = array();
                $json['success'] = 'File was uploaded successfuly';
                $json['file_path'] = $upload_dir.$newImageIs; 
                $json['fileDestPath'] = $_FILES;
                echo json_encode($json);
                exit();
            } else {
                 $json['success'] = "Error updating record: " . $conn->error;
                 echo json_encode($json);
                 exit();
            }
            
        }

    } else { 
        exit_status('Something went wrong with your upload!'); 
    }

    // Helper functions
    function exit_status($str){
            $json = array();
            $json['status'] = $str;
            echo json_encode($json);
            exit;
    }

    function get_extension($file_name){
            $ext = explode('.', $file_name);
            $ext = array_pop($ext);
            return strtolower($ext);
    }
    die();
?>
