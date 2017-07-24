<?php
//ini_set("display_errors", 1);
if($_REQUEST['key']=='login' ){
	$output = array();
	$output['result'] = 'false';
	$output['message'] = 'Login failed';
	if(strlen($_REQUEST['dealerCode']) > 3 && ( $_REQUEST['password']==$_REQUEST['dealerCode'].'@mtv' || $_REQUEST['password']==$_REQUEST['dealerCode'].'@MTV')){
		$connection = new MongoClient("mongodb://52.76.154.16:27017");
		$collection = $connection->mtv->dealerParent;
		$cursor = $collection->find(array('M_MUL_DEALER_CD' => $_REQUEST['dealerCode']));
		$cursor->limit(1);
		if($cursor->count() > 0) {
			foreach ($cursor as $key => $value) {$i++;	
				if($value['logginCount'] < 1 ) $value['logginCount'] = 1;
				else $value['logginCount'] = $value['logginCount'] + 1; 
				$output['result'] = 'true';
				$output['message'] = 'Login successfully';
				$output['categories'][] = array('dealerCode'=>$_REQUEST['dealerCode'], 'password' => $_REQUEST['password']);				
				$value['logged_in'] = true;
				$value['loggin_time'] = date("H:i d M, Y");
				$collection->update(array("M_MUL_DEALER_CD" => $_REQUEST['dealerCode']), array('$set' => $value));
			}
		}	
	}
	$output['categories'] = array();
	echo json_encode($output);
	die;
} else if($_REQUEST['key']=='sendOTP' ){
	$output = array();
	$output['result'] = 'false';
	$output['message'] = 'Authentication failed';
	if(strlen($_REQUEST['dealerCode']) >= 3){
		$connection = new MongoClient("mongodb://52.76.154.16:27017");
		$collection = $connection->mtv->dealerParent;
		$cursor = $collection->find(array('M_MUL_DEALER_CD' => $_REQUEST['dealerCode']));
		$cursor->limit(1);
		if($cursor->count() > 0) {
			$output['result'] = 'true';
			$output['message'] = 'OTP Sent successfully';
			$otp = rand(111111 , 999999);
			$output['otp'] = $otp;
			foreach ($cursor as $key => $value) {$i++;
				$msg = "Dear User, your 6 digit OTP is ".$otp. ". Use this code to login into the Maruti Suzuki Event App.";
				$cUrl = "http://203.212.70.200/smpp/sendsms?username=adglobalapi&password=del12345&to=".$value['phoneNumber']."&from=AGLENQ&text=" . urlencode($msg);
			    $ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $cUrl);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    $response = curl_exec($ch);
			}
		}	
	}
	$output['categories'] = array();
	echo json_encode($output);
	die;
} else if ($_REQUEST['key']=='script'){
	
	$connection = new MongoClient("mongodb://52.76.154.16:27017");
	$collection = $connection->mtv->dealerParent;
	foreach(json_decode($json) as $value) { 
		print_r($value);
		if(strlen($value->UserName) < 4){ 
         	$value->UserName = '0'.$value->UserName;
		 }
	 	//$collection->update(array("M_MUL_DEALER_CD" => $value->UserName), array('$set' => array('phoneNumber'=>$value->MobileNumber)));
	 	//die;
	}
	
	
} else if($_REQUEST['key']=='dashboard'){
	
	$output = array();
	$output['result'] = 'true'; 
	$output['message'] = 'Listed Successfully';
	$output['categories'][] = array('module_id'=>'1', 'type'=>'list', 'thumb' => 'http://52.76.154.16/mtv/assests/dealer-metting-icon.png', 'title'=>'Dealer Meeting Agenda','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'8', 'type'=>'personalinfo', 'thumb' => 'http://52.76.154.16/mtv/assests/personal-info-icon.png', 'title'=>'Register for Event','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'2', 'type'=>'location','thumb' => 'http://52.76.154.16/mtv/assests/location--icon.png','lat'=>'28.5435413' , 'long'=> '77.1198187', 'title'=>'Location of the Event');
	$output['categories'][] = array('module_id'=>'3', 'type'=>'location', 'thumb' => 'http://52.76.154.16/mtv/assests/pilot-site-icon.png','lat'=>'28.4860344' , 'long'=>'77.0579928','title'=>'Location of the Pilot');
	$output['categories'][] = array('module_id'=>'9', 'type'=>'checkin', 'thumb' => 'http://52.76.154.16/mtv/assests/reached-icon.png', 'title'=>'Check In','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'4', 'type'=>'QR', 'thumb' => 'http://52.76.154.16/mtv/assests/qr-car-icon.png', 'title'=>'QR The Car','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'5', 'type'=>'list', 'thumb' => 'http://52.76.154.16/mtv/assests/digital-evaluation-icon.png', 'title'=>'Digital Evaluation Process','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'6', 'type'=>'list', 'thumb' => 'http://52.76.154.16/mtv/assests/digital-channels-icon.png', 'title'=>'Digital Channels','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'7', 'type'=>'list', 'thumb' => 'http://52.76.154.16/mtv/assests/intelligent-reporting-icon.png', 'title'=>'Intelligent Reporting','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'10', 'type'=>'list', 'thumb' => 'http://52.76.154.16/mtv/assests/gallery-icon.png', 'title'=>'Gallery','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'11', 'type'=>'feedback', 'thumb' => 'http://52.76.154.16/mtv/assests/feedback-icon.png', 'title'=>'Feedback','lat'=>'','long'=>'');
	$output['categories'][] = array('module_id'=>'12', 'type'=>'notification', 'thumb' => 'http://52.76.154.16/mtv/assests/notification-icon.png', 'title'=>'Notifications','lat'=>'','long'=>'');
	echo json_encode($output);
	die;
} else if($_REQUEST['key']=='detail' && $_REQUEST['module_id'] > 0){
	$info = array();
	$info['1'][] = array('type' => 'File','datetime' => date('d M, Y',strtotime('2017-01-05')), 'title' => 'North & East','thumb' => 'http://52.76.154.16/mtv/assests/agenda.png', 'url' => 'http://52.76.154.16/mtv/assests/NorthEast.pdf' );
	$info['1'][] = array('type' => 'File','datetime' => date('d M, Y',strtotime('2016-01-06')), 'title' => 'South & West','thumb' => 'http://52.76.154.16/mtv/assests/agenda.png', 'url' => 'http://52.76.154.16/mtv/assests/SouthWest.pdf' );

	$info['5'] = array();
	// $info['5'][] = array('type' => 'AV' , 'datetime' => date('H:i d M, Y',strtotime('2016-12-29')),'title' => 'TruValuation App', 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png', 'url' => 'http://52.76.154.16/mtv/assests/true-value.mp4' );
	// $info['5'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Certification App', 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png', 'url' => 'http://52.76.154.16/mtv/assests/true-value.mp4');
	
	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Website', 'thumb' => 'http://52.76.154.16/mtv/assests/WebsiteHomepage.png', 'url' => 'http://52.76.154.16/mtv/assests/Website-Take-1.mp4' );
	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Website Buy Car', 'thumb' => 'http://52.76.154.16/mtv/assests/WebsiteBuying.png', 'url' => 'http://52.76.154.16/mtv/assests/BuyCar.mp4' );

	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Store LMS Customer', 'thumb' => 'http://52.76.154.16/mtv/assests/StoreLMSCustomer.png', 'url' => 'http://52.76.154.16/mtv/assests/StoreLMSCustomer.mp4' );
	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Store LMS Receptionist', 'thumb' => 'http://52.76.154.16/mtv/assests/StoreLMSReception.png', 'url' => 'http://52.76.154.16/mtv/assests/StoreLMSReceptionist.mp4' );
	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Store LMS Sales Rep', 'thumb' => 'http://52.76.154.16/mtv/assests/StoreLMSSalesRep.png', 'url' => 'http://52.76.154.16/mtv/assests/StoreLMSSalesRep.mp4' );

	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Consumer APP', 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png',  'url' => 'http://52.76.154.16/mtv/assests/true-value.mp4' );

	//$info['6'][] = array('type' => 'AV' , 'title' => 'Lead Management System', 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png',  'url' => 'http://52.76.154.16/mtv/assests/StoreLMSReceptionist.mp4' );
	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Dealer Mircosite 1', 'thumb' => 'http://52.76.154.16/mtv/assests/DealerMicrosite.png',  'url' => 'http://52.76.154.16/mtv/assests/DealerMicrosite.mp4' );
	// $info['6'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Dealer Mircosite 2', 'thumb' => 'http://52.76.154.16/mtv/assests/DealerMicrosite.png',  'url' => 'http://52.76.154.16/mtv/assests/DealerMicrosite2.mp4' );

	$info['6'] = array();
	
	$info['7'] = array();
	//$info['7'][] = array('type' => 'AV' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'TRV Portal', 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png', 'url' => 'http://52.76.154.16/mtv/assests/true-value.mp4' );
	$info['10'][0] = array('type' => 'File' ,'datetime' => date('H:i d M, Y',strtotime('2017-01-16 10:00')), 'gallery_id' => 'File'  , 'title' => 'Event Gallery' , 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png', 'url' => 'http://52.76.154.16/mtv/assests/trv-portel.png' ); 

	$files = scandir('mtv/assests/gallery');
	foreach ($files as $file) { 
		if($file != '..' && $file != '.' && $file != 'old' && $file != 'thumb'){
			$info['10'][0]['images'][] = array('type' => 'File' ,'datetime' => date('H:i d M, Y',strtotime('2017-01-16 10:00')), 'gallery_id' => 'File'  , 'title' => $file , 'thumb' => 'http://52.76.154.16/mtv/assests/gallery/thumb/'.str_replace('.JPG', '.png', $file), 'url' => 'http://52.76.154.16/mtv/assests/gallery/'.$file ); 
		}
	}

	// $info['10'][] = array('type' => 'File' ,'datetime' => date('H:i d M, Y',strtotime('2017-01-16 10:00')), 'gallery_id' => 'File'  , 'title' => 'Event Gallery' , 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png', 'url' => 'http://52.76.154.16/mtv/assests/trv-portel.png' ); 

	// $info['10'][1]['images'][] = array('type' => 'File' ,'datetime' => date('H:i d M, Y',strtotime('2017-01-16 10:00')), 'gallery_id' => 'File'  , 'title' => 'Event Gallery' , 'thumb' => 'http://52.76.154.16/mtv/assests/trv-portel.png', 'url' => 'http://52.76.154.16/mtv/assests/trv-portel.png' ); 

	// $info['10'][] = array('type' => 'file' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Event at Radisson', 'thumb' => 'http://52.76.154.16/mtv/assests/1.jpg', 'url' => 'http://52.76.154.16/mtv/assests/1.jpg' );
	// $info['10'][] = array('type' => 'file' ,'datetime' => date('H:i d M, Y',strtotime('2016-12-29')), 'title' => 'Event Inauguration', 'thumb' => 'http://52.76.154.16/mtv/assests/3.jpg', 'url' => 'http://52.76.154.16/mtv/assests/3.jpg' );

	//$info['10'] = array();
	
	$output = array();
	$output['result'] = 'true';
	$output['message'] = 'Listed Successfully';
	$output['categories'] = $info[$_REQUEST['module_id']];
	echo json_encode($output);
	die;
}  else if($_REQUEST['key']=='notifications'){

	$notification = array();

	
	$notification[] = array('datetime' => date('H:i d M, Y',strtotime('2017-01-12 15:20')), 'msg' => 'Your feedback is important to us. Please share your valuable feedback regarding the Transformotion event  with us. Kindly ignore if already shared.');

	$notification[] = array('datetime' => date('H:i d M, Y',strtotime('2017-01-09 15:20')), 'msg' => 'Please share your feedback regarding the new infrastructure and event by visiting the feedback section on the App.');
	
	$notification[] = array('datetime' => date('H:i d M, Y',strtotime('2017-01-09 15:05')), 'msg' => 'Maruti True Value would like to thank you for attending the MSTV Transformotion event and making it a huge success with your presence.');

	$notification[] = array('datetime' => date('H:i d M, Y',strtotime('2017-01-04 13:15')), 'msg' => 'Please update your arrival details in "Register For Events" section');
	
	// $notification[] = array('datetime' => date('H:i d M, Y',strtotime('2016-12-29 12:12')), 'msg' => 'For Guests traveling on 6th are requested to check out by 12:00 noon');
	// $notification[] = array('datetime' => date('H:i d M, Y',strtotime('2016-12-28 11:2')), 'msg' => 'For Guests traveling on 5th are requested to check out by 10:30 a.mt');
	// $notification[] = array('datetime' => date('H:i d M, Y',strtotime('2016-12-28 10:15')), 'msg' => 'The dinner has been arranged at Radisson');
	// $notification[] = array('datetime' => date('H:i d M, Y',strtotime('2016-12-27 14:20')), 'msg' => 'You are requested to take your seats by 2PM. at Crystal Hall');
	// $notification[] = array('datetime' => date('H:i d M, Y',strtotime('2016-12-27 10:12')), 'msg' => 'Thank you for your arrival confirmation');
	// $notification[] = array('datetime' => date('H:i d M, Y',strtotime('2016-12-26 15:12')), 'msg' => 'Thank you for registering yourself');

	$output = array();
	$output['result'] = 'true';
	$output['message'] = 'Listed Successfully';
	$output['categories'] = $notification;
	echo json_encode($output);
	die;
} else if($_REQUEST['key']=='checkin' ){
	$output = array();
	if($_REQUEST['dealerCode']){
		

		$connection = new MongoClient("mongodb://52.76.154.16:27017");
		$collection = $connection->mtv->dealerParent;
		$cursor = $collection->find(array('M_MUL_DEALER_CD' => $_REQUEST['dealerCode']));
		$cursor->limit(1);
		if($cursor->count() > 0) {
		
			$output['result'] = 'true';
			$output['message'] = 'Checked in successfully';

			$value = array();
			$value['reached'] = date("H:i d M, Y");
			$collection->update(array("M_MUL_DEALER_CD" => $_REQUEST['dealerCode']), array('$set' => $value));
			
		}

	} else {
		$output['result'] = 'false';
		$output['message'] = 'Request Failed';
	}
	echo json_encode($output);
	die;
} else if($_REQUEST['key']=='personalinfo' ){
	$output = array();
	if($_REQUEST['dealerCode'] && $_REQUEST['name1']){
		
		$output['result'] = 'true';
		$output['message'] = 'Registration successfull.';

		$connection = new MongoClient("mongodb://52.76.154.16:27017");
		$collection = $connection->mtv->dealerParent;
		$cursor = $collection->find(array('M_MUL_DEALER_CD' => $_REQUEST['dealerCode']));
		$cursor->limit(1);
		if($cursor->count() > 0) {
			$value = array();
			$value['name1'] = $_REQUEST['name1'];
			$value['name2'] = $_REQUEST['name2'];
			$value['name3'] = $_REQUEST['name3'];
			$value['dealername'] = $_REQUEST['dealername'];
			$value['arrivalDateTime'] = $_REQUEST['arrivalDateTime'];

			$collection->update(array("M_MUL_DEALER_CD" => $_REQUEST['dealerCode']), array('$set' => $value));

			
			$value['dealerCode'] = $_REQUEST['dealerCode'];
			$connection->mtv->registration->insert($value);

		}

	} else {
		$output['result'] = 'false';
		$output['message'] = 'Request Failed';
	}
	echo json_encode($output);
	die;
} else if($_REQUEST['key']=='feedback' ){
	$output = array();
	if($_REQUEST['dealerCode'] && $_REQUEST['feedback']){
		

		$connection = new MongoClient("mongodb://52.76.154.16:27017");
		$collection = $connection->mtv->dealerParent;
		$cursor = $collection->find(array('M_MUL_DEALER_CD' => $_REQUEST['dealerCode']));
		$cursor->limit(1);
		if($cursor->count() > 0) {
			foreach ($cursor as $key => $v) {
				$output['result'] = 'true';
				$output['message'] = 'Feedback has been sent successfully';

				$value = array();
				$value['M_MUL_DEALER_CD'] = $_REQUEST['dealerCode'];
				$value['DEALER_NAME'] = $v['DEALER_NAME'];
				$value['feedback'] = $_REQUEST['feedback'];
				$value['infrafeedback'] = $_REQUEST['infrafeedback'];
				$value['datetime'] = date("H:i d M, Y");
				$connection->mtv->dealerFeedback->insert($value);
			}
		}

	} else {
		$output['result'] = 'false';
		$output['message'] = 'Request Failed';
	}
	echo json_encode($output);
	die;
} else if($_REQUEST['key']=='updateToken'){
	$output = array();
	if($_REQUEST['dealerCode'] && $_REQUEST['token']){
		$output['result'] = 'true';
		$output['message'] = 'Token saved';
		$connection = new MongoClient("mongodb://52.76.154.16:27017");
		$collection = $connection->mtv->dealerParent;
		$cursor = $collection->find(array('M_MUL_DEALER_CD' => $_REQUEST['dealerCode']));
		$cursor->limit(1);
		if($cursor->count() > 0) {
			foreach ($cursor as $key => $value) {$i++;	

				$output['result'] = 'true';
				$output['message'] = 'Login successfully';

				$value = array();
				$value['token'] = $_REQUEST['token'];
				$collection->update(array("M_MUL_DEALER_CD" => $_REQUEST['dealerCode']), array('$set' => $value));
			}
		}
	} else {
		$output['result'] = 'false';
		$output['message'] = 'Request Failed';
	}
	echo json_encode($output);
	die;
}elseif($_REQUEST['key']=='pushNotification'){
	// $deviceToken = '';
	// $apnsHost = 'gateway.sandbox.push.apple.com';
	// $apnsPort = 2195;
	// $apnsCert = 'apns-dev.pem';

	// $streamContext = stream_context_create();
	// stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

	// $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
	// var_dump($apns);

	// $payload['aps'] = array('alert' => 'This is the alert text', 'badge' => 1, 'sound' => 'default');
	// $payload['server'] = array('serverId' => $serverId, 'name' => $name);
	// $output = json_encode($payload);
	// $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken)) . chr(0) . chr(strlen($payload)) . $payload;

	// fwrite($apns, $apnsMessage);
	// socket_close($apns);
	// fclose($apns);

  

	$API_ACCESS_KEY = 'AIzaSyBIIIovJvY-xoPO_o8mH5v3KgqLV0Aib54';
	$ids =array('czAetKyvVUI:APA91bHZZoVBo_UKkkli0jeUxCtjzy6UxGTAEew38rFaZfqk1Z2LR-kHrTLaLc1xfNOOl8uMcQD9N69TfOF84Bpb4m2Y1HUqzVQ67DcJrGoAjaRacM7wtZMs5t5lca0QK36Z5mv6oJxA');
	$fields = array(
	    'registration_ids'     => $ids,
	    'data'        => array("message" => "MTV: Thank you for registering yourself.","ownerId"=> 'ZN01')
	);
	$headers = array(
	        'Authorization: key=' . $API_ACCESS_KEY,
	        'Content-Type: application/json'
	    );

	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	echo "Notification sent";
}else {
	$output = array();
	$output['result'] = 'false';
	$output['message'] = 'Login failed';
	$output['categories'][] = array('msg'=>'Failed');
	echo json_encode($output);

	
}	
?>