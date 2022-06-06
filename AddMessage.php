<style media="screen">

  .heading{

    position: absolute;
    top: 40%;
    left: 45%

  }

  #error{
    color:red;
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

    $fromUser = $_GET['fromUsername'];
    $toUser = $_GET['toUsername'];
    $body = $_GET['body'];

    if(empty($body)){
      echo "<h1 class=heading id=error>Please enter a non-blank message</h1>";
    }else{
      $fromSQL = $conn -> query("SELECT * FROM `users` WHERE username='$fromUser'");
      if($fromSQL -> rowCount()==0){
        echo "<h1 class=heading id=error>Please enter a valid sender</h1>";
      }else{
        $fromROW = $fromSQL -> fetch();
        $fromUserID = $fromROW["userID"]; 

        $usernameArray=explode(", ", $toUser);
        $continue=true;
        for($x = 0; $x<count($usernameArray); $x++){
          $toSQL = $conn -> query("SELECT * FROM `users` WHERE username='$usernameArray[$x]'");
          if($toSQL -> rowCount()==0){
            echo "<h1 class=heading id=error>Please enter a valid recipient</h1>";  
            $continue=false;
          }
        }
        if($continue){
          $conn->exec("INSERT INTO messages(fromUserID, body) VALUES ('$fromUserID', '$body')");
          $messageID = $conn -> lastInsertId();
         for($x = 0; $x<count($usernameArray); $x++){
          $toSQL = $conn -> query("SELECT * FROM `users` WHERE username='$usernameArray[$x]'");
          $toROW = $toSQL -> fetch();
          $toUserID = $toROW["userID"];
          $conn->exec("INSERT INTO messagerecipients(messageID, toUserID) VALUES ('$messageID', '$toUserID')"); 
        }
      echo "<h1 class='heading'>Message Successfully Sent!</h1>";
        }
       } 
    }


  }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

 ?>
