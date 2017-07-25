<?php
	require_once 'inc/config.php';
  $totalBytesToUpload = 5000000; // 2M

  $match = array("image/png","image/jpg","image/jpeg","video/mp4");
	$visitor_msg = htmlspecialchars( addslashes( $_POST['visitor_msg'] ), ENT_QUOTES, 'UFT-8' );
  $errors = array();
  $data = array();

  $allowedExts = array("mp4", "jpeg", "jpg", "png");
  $extension = end(explode(".", $_FILES["upload_file"]["name"]));


  /*
    Server Side Validation on form inputs
  */
  if ( trim( strip_tags( addslashes( $_POST['vistior_name'] ) ) ) == '' ) {
    $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please enter your name");
  }

  if ( !empty( $_POST['vistior_name'] ) &&  !preg_match('/^[a-zA-Z ]*$/', $_POST['vistior_name'])) { 
    ///^[a-zA-Z]+$/
    $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please enter valid name");
  }
	
	if( !empty( $_POST['vistior_email'] ) ) {
		if( filter_var($_POST['vistior_email'], FILTER_VALIDATE_EMAIL) === false ) {
			$errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Enter valid email");  
		}
	}

  if( !empty ( $visitor_msg ) ) {

    if ( !empty( $visitor_msg ) &&  !preg_match('/^[a-zA-Z ]*$/', $visitor_msg ) ) { 

      $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please enter valid comment");

    }

    if( strlen( $visitor_msg ) > 250 ){
      $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Only 250 characters are allowed");
    }
  }

  if ( trim( $_POST['visitor_msg'] ) == '' && ( $_FILES['upload_file']['size'] == 0 && $_FILES['upload_file']['name'] == '' ) ) {
    $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please add your comment or upload image/video!");

    if ( $_FILES['upload_file']['error']  == 1 ) {
      $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Your file size is exceeding to 5M");
    }
  }
	
  if( empty( $_POST['captcha'] )) {
     $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please fill your captcha code");
  }

  if( !empty( $_POST['captcha'] ) && $_POST['captcha'] != $_SESSION["captcha_code"] ) {
     $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Your Captcha code is incorrect");
  }
    
  if( $_FILES['upload_file']['size'] > 0 && $_FILES['upload_file']['name'] != '') {

    	if( isset($_FILES['upload_file']) && $_FILES['upload_file']['size'] == 0  &&  $_FILES['upload_file']['error'] != 0) {
      	$errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please upload image/video");
    	}

    	if( isset($_FILES['upload_file']) && $_FILES['upload_file']['size'] > 0  &&  $_FILES['upload_file']['error'] == 0) {

      	if ($_FILES['upload_file']['size'] > $totalBytesToUpload) {
        		$errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Your file size is exceeding");
      	}
    	}

    	if( isset($_FILES['upload_file']) && $_FILES['upload_file']['type'] != '') {
      
      	$imageType =  $_FILES['upload_file']['type'];
      
      	if(!( ($imageType==$match[0]) || ($imageType==$match[1]) || ($imageType==$match[2]) || ($imageType==$match[3]) )) {
        		$errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please upload image or video files only!");
      	}

        // if( !in_array($extension, $allowedExts) ) {
        //   $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please upload image or video files only!");
        // }

        $pos = strpos($_FILES['upload_file']['name'],'php');
        if(!($pos === false)) {
          $errors[] = array("status"=>0, "id"=>"other_place", "message"=>"Please upload image or video files only!");
        }
    	}
  }

 	if ( count($errors) > 0) {
    	echo json_encode($errors);
    	die();
  } else {

    // create document_type;
    $document_type = '';

    if( $_FILES['upload_file']['type'] == 'image/png' || $_FILES['upload_file']['type'] == 'image/jpg' || $_FILES['upload_file']['type'] == 'image/jpeg' ) {
      $document_type = 'image';
    } else if($_FILES['upload_file']['type'] == 'video/mp4') {
      $document_type = 'video';
    } else {
      if( empty( $_FILES['upload_file']['type'] ) && !empty( $_POST['visitor_msg'] ) ) {
        $document_type = 'text';
      }
    }

    if( $_FILES['upload_file']['size'] > 0 && $_FILES['upload_file']['name'] != '') {

    	$target_dir = "./upload/";

      if (!is_dir($target_dir)) {
          mkdir($target_dir, 777);
      }

      $visitorName = strtolower( str_replace('', '_', $_POST['vistior_name']) );
      $imageSplit=explode('.',$_FILES['upload_file']['name']);
      $newImageFileName = $imageSplit[0].'_'.$visitorName.'_'.date('y-m-d-s').'.'.$extension;
      $ImageFilePath = $target_dir . $newImageFileName;
      //echo $ImageFilePath;die('s');
    } else {
	    $newImageFileName = '';
    } 
  
    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $ImageFilePath)) { 

      $upload = $mysqli->prepare("INSERT INTO visitor (firstname, email, message, image, document_type) VALUES (?, ?, ?, ?, ?)");
	    $upload->bind_param("sssss", $_POST['vistior_name'], $_POST['vistior_email'], $visitor_msg, $newImageFileName, $document_type);
	    $upload->execute();
    } else {
      $upload = $mysqli->prepare("INSERT INTO visitor (firstname, email, message, document_type) VALUES (?, ?, ?, ?)");
	    $upload->bind_param("ssss", $_POST['vistior_name'], $_POST['vistior_email'], $visitor_msg, $document_type);
	    $upload->execute();
    }

    if ( $upload->insert_id ) {
    	$data[] = array('status'=>1, 'id'=>'', 'message'=>"Data has been added Successfully!");
    } else {
    	$data[] = array('status'=>1, 'id'=>'', 'message'=>"There is some issue in Query!");
    }

    echo json_encode( $data );
    $upload->close();
    $mysqli->close();
    die();
  }
?>
