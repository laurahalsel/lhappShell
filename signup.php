<?php
  require("config.php");

//print_r($_POST); exit();
if(empty($_POST['username'])) die("Username required");
if(empty($_POST['password'])) die("Password required");	
if(empty($_POST['name'])) die("First name required");	
if(empty($_POST['email'])) die("email required");	
    
	$username = $_POST['username'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$hash = md5($password);
	
    $query = "SELECT 1 FROM users WHERE username = :username";
	$query_params = array(':username' => $username);

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
    if($row) { 
        //die("This username address is already registered"); 
        // setup reset password button and sent password via email
        //echo "0 .This username is already registered"; // for failure
        http_response_code(500);
        echo json_encode(array(
			'error' => array(	
			    'msg' => 'This username is already registered. ',
			),
        )); 
        exit();
    } 
	
	//inserting some some data
	$sql = 'INSERT INTO users (name, username, email, raw_password, password) 
	VALUES (:name, :username, :email, :rawPassword, :password)';
	
	$query_params = array(
		':username' => $username, 
		':name' => $name, 
		':email' => $email, 
		':rawPassword' => $password, 		
		':password' => $hash
	); 	
		
	//print_r($query_params); exit();
	
	try {  
            $stmt = $db->prepare($sql); 
            $result = $stmt->execute($query_params); 
    } catch(PDOException $ex) { 
	        //echo "0 .Failed to run query: " . $ex->getMessage(); 
			//logmsg("signup.php : Failed to run query: " . $ex->getMessage());
			http_response_code(500);
			echo json_encode(array(
					'error' => array(
					'msg' => 'Error on insert of new user: ' . $ex->getMessage(),
					'code' => $ex->getCode(),
				),
			));
			exit();
    } 	  

	$query = "SELECT ID, username, name, email FROM users WHERE username = :userName";
    $query_params = array(':userName' => $username);

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
?>