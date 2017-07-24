<?php
   require_once "../inc/config.php";

    $uid = $_SESSION['login_user'];
    if((isset($uid))){
         header("location: dashboard.php");
         exit();
    }

    $error  = '';
    if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		  $errors = array();
        
		  if( empty( $_POST['username'] )) {
			  $errors['username'] = "Please enter username!";
		  }
		  
		  if ( !empty( $_POST['username'] ) &&  !preg_match('/^[a-zA-Z]*$/', $_POST['username'])) { 
			  $errors['valid_name'] = "Please enter valid username!";
		  }
		  
		  if( empty( $_POST['password'] )) {
			  $errors['password'] = "Please enter password!";
		  }
        
          if( empty( $_POST['captcha'] )) {
			  $errors['captcha_error'] = "Please fill your captcha code";
		  }
		  
		  if( !empty( $_POST['captcha'] ) && $_POST['captcha'] != $_SESSION["captcha_code"] ) {
			  $errors['incorrect_captcha'] = "Your Captcha code is incorrect";
		  }
		  
		  
		  if( count( $errors ) > 0 ) {
			  $_SESSION['validations'] = $errors;
			  header("location: dashboard.php");
			  exit();
		  }
		  
		  $user_name =  $_POST['username'];
		  $password =  md5( $_POST['password'] );
		  $captcha =  $_POST['captcha'];

        /* Prepared statement, stage 1: prepare */


        $loginQuery = "SELECT id, role_id, user_name FROM admin WHERE user_name =? AND password =?";
        if ($login = $mysqli->prepare($loginQuery)) {

            /* bind param */
            $login->bind_param("ss", $user_name, $password);

            /* execute query */
            $login->execute();

            /* store result */
            $login->store_result();

            /* Get the number of rows */
            $num_of_rows = $login->num_rows;

            /* Bind the result to variables */
            $login->bind_result($id, $role_id, $user_name);

            if ($num_of_rows >= "1") { 
                while ($login->fetch()) {
                    $_SESSION['login_user'] = $id;
                    $_SESSION['role_id'] = $role_id;
                    $_SESSION['user_name'] = $user_name;
                }
                header("location: dashboard.php");
            }else{
                $errors['wrong_password'] = "Your Login Name or Password is invalid";
                $_SESSION['validations'] = $errors;
				header("location: dashboard.php");
				exit();
            }  

            /* free results */
            $login->free_result();

        }
    }
?>




<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Teej Admin | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form method="post">
                <div class="body bg-gray">
					<ul>
						<?php
							
							if( count( $_SESSION['validations'] ) > 0 ) {
								foreach ( $_SESSION['validations'] as $validation ) {
									echo '<li>'.$validation.'</li>';
									$validation='';
								}
							}
                            
						?>
					</ul>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="User Name" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off"  />
                    </div>
                    <div class="form-group">
                        <input type="text" name="captcha" id="captcha" placeholder="captcha" />
                        <img id="captcha_code" src="../captcha.php" />
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>
                    <p><?php echo $error; ?></p>
                    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
                </div>
            </form>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
