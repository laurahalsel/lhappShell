<?php
	
    // These variables define the connection information for your MySQL database 
    $username = "root"; 
    $password = ""; 
    $host = "localhost"; 
    $dbname = "appshell"; 
     
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { 
	    $db = new PDO("mysql:host={$host};  dbname={$dbname};charset=utf8", $username, $password, $options); 
	}     
    catch(PDOException $ex){
		//header("http/1.0 503 Service Unavailable");		
		//logmsg("Config.php : Failed to connect to the database: "  . $ex->getMessage());
	    echo "0 Failed to connect to the database: " . $ex->getMessage();
	}	
	 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    //header('Content-Type: text/html; charset=utf-8'); 
    //session_start(); 
?>