<?php
  require("config.php");

  $username = $_POST['username'];
  $oldPassword = $_POST['oldPassword'];
  $password = $_POST['password'];
  
  $hash = md5($oldPassword);
  $newHash = md5($password);

  $id = $_POST['id'];

  $query = "SELECT 1 FROM users WHERE password = :oldPassword";
  $query_params = array(':oldPassword' => $hash);

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
    $sql = "UPDATE users SET password = :password, raw_password = :rawPassword WHERE username = :username";
    $query_params = array(':password' => $newHash, ':rawPassword' => $password, ':username' => $username); 	
    
    try {  
            $stmt = $db->prepare($sql); 
            $result = $stmt->execute($query_params); 
    } catch(PDOException $ex) { 
            //echo "0 .Failed to run query: " . $ex->getMessage(); 
            //logmsg("signup.php : Failed to run query: " . $ex->getMessage());
            http_response_code(500);
            echo json_encode(array(
                    'error' => array(
                    'msg' => 'Error on updating information: ' . $ex->getMessage(),
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
                  'msg' => 'Old Password does not match.',
              ),
          )); 
          exit();
  }
  
    $query = "SELECT id, name, username, email FROM users WHERE password = :password";
    $query_params = array(':password' => $newHash); 	
        
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
