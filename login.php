<?php
  require("config.php");
  session_start();

//print_r($_POST); exit();
if(empty($_POST['username'])) die("Username required");
if(empty($_POST['password'])) die("Password required");	
    
	$username = $_POST['username'];
    $email = $_POST['username'];
	$password = $_POST['password'];
	$hash = md5($password);

	// Remove all illegal characters from email
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);

	// Validate e-mail
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$query = "SELECT 1 FROM users WHERE email = :userName AND password = :password";
		$query_params = array(':userName' => $email, ':password' => $hash);
		
	} else {
		$query = "SELECT 1 FROM users WHERE username = :userName AND password = :password";
		$query_params = array(':userName' => $username, ':password' => $hash);

	}

    try { 
        $stmt = $db->prepare($query); 
		$result = $stmt->execute($query_params); 

    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error on select checking for dupes: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		exit();
    } 
	
	$row = $stmt->fetch(); 
    if($row > 0) { 

		$query = "SELECT id, username, name, email FROM users WHERE (username = :userName OR email = :userName) AND password = :password";
		$query_params = array(':userName' => $username, ':password' => $hash);
		

	    try { 
	        $stmt = $db->prepare($query); 
	        $result = $stmt->execute($query_params); 
			
			$outData = array();
			while($row = $stmt->fetch()) {
				$outData[] = $row;
			} 
			//echo json_encode($outData);
			echo '{"user":' . json_encode($outData) . '}'; 
			exit();
	    } catch(PDOException $ex){ 
			http_response_code(500);
			echo json_encode(array(
				'error' => array(	
				'msg' => 'Error on select user: ' . $ex->getMessage(),
				'code' => $ex->getCode(),
				),
			));
			exit();
		} 

    } else {
    	//die("This username address is already registered"); 
        // setup reset password button and sent password via email
        //echo "0 .This username is already registered"; // for failure
        http_response_code(500);
        echo json_encode(array(
			'error' => array(	
			    'msg' => 'Invalid Login. ',
			),
        )); 
        exit();
    }

?>