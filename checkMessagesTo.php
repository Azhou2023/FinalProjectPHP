<style media="screen">

#result{
    margin-left:100px;
    margin-top: 10px;
    margin-bottom: 10px;
    font-size: 15px;
  }
  #heading{
    /* position: fixed; */
    text-align: center;

  }
  #error{
    color: red;
    position: absolute;
    top:40%;
    left: 45%;  }

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

  $recipientUsername = $_GET["recipientUsername"];
  $recipientSQL = $conn -> query("SELECT * FROM `users` WHERE username='$recipientUsername'");

    if($recipientSQL -> rowCount()==0){
      echo "<h1 id=error>Please enter a valid username</h1>";
    }else{
    $recipientROW = $recipientSQL -> fetch();
    $userID = $recipientROW['userID'];

    $messageRecipientSQL = $conn->query("SELECT * FROM messagerecipients WHERE toUserID = '$userID'");


    echo "<h1 id=heading>Messages to $recipientUsername: </h1> <br><br>";

    foreach($messageRecipientSQL as $row){

    $messageID = $row["messageID"];

    $countSQL = $conn->query("SELECT COUNT(body) FROM messages WHERE messageID='messageID'");

    $messageSQL = $conn->query("SELECT * FROM messages WHERE messageID = '$messageID'");
    $messageROW = $messageSQL -> fetch();
    $message = $messageROW["body"];

    $senderID = $messageROW["fromUserID"];
    $senderSQL = $conn->query("SELECT * FROM users WHERE userID='$senderID'");
    $senderROW = $senderSQL -> fetch();
    $sender = $senderROW["username"];


    echo "<div id=result><b>-From ".$sender.": </b>".$message."</div>";
    }
  }
  




}catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }


 ?>
