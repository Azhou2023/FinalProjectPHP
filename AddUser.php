<style media="screen">

  .heading{
    position: absolute;
    top: 40%;
    left: 50%;
  }
  #error{
    color: red;
    left:45%;
  }

</style>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "chatlog";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    //EVERYTHING ABOVE, and the catch block below, is part of a template that we
    //will use every time we want to connect to the database…
    //BELOW THIS is where you will vary the response...put your application logic between
    //this comment and the catch block below

    $username = $_GET["username"];
    $password = $_GET["password"];
    $email = $_GET["email"];

    if(empty($username) or empty($password) or empty($email)){
      echo "<h1 class=heading id=error>Please fill all required fields</h1>";
    }else{
        $sql = "INSERT INTO users (username, password, email)
          VALUES ('$username', '$password', '$email')";
        $conn->exec($sql);
        echo "<h1 class='heading'>New User Created!</h1>";
    }
  
  }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }


 ?>
