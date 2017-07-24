<?php

	function confirmIPAddress( $mysqli, $ip_address ) {

        $confirmIPQuery = "SELECT attempts, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL ".TIME_PERIOD.
      " MINUTE)>NOW() then 1 else 0 end) as Denied FROM ".TBL_ATTEMPTS." WHERE ip=?";

      	//echo $confirmIPQuery;die();

      	$confirmIP = $mysqli->prepare($confirmIPQuery);

       	if($confirmIP === false) {
            die('Wrong User content SQL: ' . $confirmIPQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
        }

        /* bind param */
        $confirmIP->bind_param("s", $ip_address);

        /* execute query */
        $confirmIP->execute();

        /* store result */
        $confirmIP->store_result();

        /* Get the number of rows */
        $num_of_rows = $confirmIP->num_rows;

        /* Bind the result to variables */
        $confirmIP->bind_result($attempts, $Denied);

        /*initialize a array() */
        $json = array();

        if ($num_of_rows >= "1") {

        	$confirmIP->fetch();
            // while ($confirmIP->fetch()) {
            //     $json['attempts'] = $attempts;
            //     $json['Denied'] = $Denied;
            // }

            if ($attempts > 3) {

            	if($Denied == 1) {

	        		$_SESSION['Denied'] = "Ask Administrator to provide you access again!";

            	}
	        }

        }

        $confirmIP->free_result();

        $confirmIP->close();
        //$mysqli->close();
    }
	
    function addLoginAttempt( $mysqli, $jp_address ) {


        $loginAttampQuery = "SELECT attempts FROM LoginAttempts WHERE ip=?";
       	//die( $loginAttampQuery );
        $loginAttamp = $mysqli->prepare( $loginAttampQuery );

       //	die( $loginAttamp );
        if($loginAttamp === false) {
            die('Wrong User content SQL: ' . $loginAttampQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
        }

        /* bind param */
        $loginAttamp->bind_param("s", $jp_address);

        /* execute query */
        $loginAttamp->execute();

        /* store result */
        $loginAttamp->store_result();

        /* Get the number of rows */
        $num_of_rows = $loginAttamp->num_rows;

        /* Bind the result to variables */
        $loginAttamp->bind_result( $attempts );

        /*initialize a array() */
        $json = array();

        if ($num_of_rows >= "1") {
        	//die( 'ssssdfsdf');
            $loginAttamp->fetch();

            $attempts = $attempts+1;
            $updateAttamps = $mysqli->prepare( "UPDATE ".TBL_ATTEMPTS." SET attempts=? WHERE ip=?" );
            if($updateAttamps === false) {
                die('Wrong Menu Update SQL: ' . $updateAttampsQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
            }
            $updateAttamps->bind_param("is",$attempts, $jp_address);
            $updateAttamps->execute();
            $updateAttamps->close();
            $mysqli->close();

        } else {

            $insertAttamps = $mysqli->prepare( "INSERT INTO ".TBL_ATTEMPTS." (attempts, ip) VALUES (?, ?)" );
            if($insertAttamps === false) {
                die('Wrong Menu Update SQL: ' . $insertAttamps . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
            }
            $attamp = 1;
            $insertAttamps->bind_param("is", $attamp, $jp_address);
            $insertAttamps->execute();
            $insertAttamps->close();
            $mysqli->close();
        }

        $loginAttamp->close();
        //$mysqli->close();

    }

    function clearLoginAttempts($value) {

        $updateClearAttampsQuery = "UPDATE ".TBL_ATTEMPTS." SET attempts = 0 WHERE ip=?";
        $updateClearAttamps = $mysqli->prepare($updateClearAttampsQuery);
        if($updateClearAttamps === false) {
            die('Wrong Menu Update SQL: ' . $updateClearAttampsQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
        }
        $updateClearAttamps->bind_param("s", $jp_address);
        $updateClearAttamps->execute();
        $updateClearAttamps->close();
        //$mysqli->close();
    }


    function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
?>