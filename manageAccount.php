<?php
  require("config.php");

  $username = $_POST['username'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $id = $_POST['id'];

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
              'msg' => 'Sorry, please pick a different username.',
          ),
      )); 
      exit();
  } else {
      
        $sql = "UPDATE users SET name = :name, username = :username, email = :email WHERE id = :id";
        $query_params = array(':name' => $name,':username' => $username, ':email' => $email, ':id' => $id); 	
        
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
  }
  
    $query = "SELECT id, name, username, email FROM users WHERE (name = :name OR username = :username OR email = :email)";
    $query_params = array(':name' => $name, 'username' => $username, 'email' => $email);
        
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
