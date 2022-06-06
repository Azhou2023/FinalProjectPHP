<style media="screen">

  #result{
    margin-left:100px;
    margin-top: 10px;
    margin-bottom: 10px;
    margin: 10px 10px 10px 100px;
    font-size: 15px;
    word-break: normal;
    overflow-wrap: break-word;
  }
  #heading{
    text-align: center;

  }
  #error{
    color: red;
    position: absolute;
    top:40%;
    left: 45%;
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

  $senderUsername = $_GET["senderUsername"];

  $senderSQL = $conn -> query("SELECT * FROM `users` WHERE username='$senderUsername'");

  if($senderSQL -> rowCount()==0){
    echo "<h1 id=error>Please enter a valid username</h1>";
  }else{

  $senderROW = $senderSQL -> fetch();
  $userID = $senderROW['userID'];

  $messageSenderSQL = $conn->query("SELECT * FROM messages WHERE fromUserID = '$userID'");

    echo "<h1 id=heading>Messages from ".$senderUsername.": </h1><br><br>";


    foreach($messageSenderSQL as $row){
      $message = $row["body"];
      $messageID = $row["messageID"];
      $recipientSQL = $conn->query("SELECT * FROM messagerecipients WHERE messageID='$messageID'");
      $recipient = '';
      foreach($recipientSQL as $row){
        $recipientID = $row["toUserID"];
        $recipientUserSQL = $conn->query("SELECT * FROM users WHERE userID='$recipientID'");
        $recipientUserROW = $recipientUserSQL -> fetch();
        $recipient .= $recipientUserROW["username"].", ";
      }

      echo "<div id=result><b>-To ".substr($recipient, 0, -2).": </b>".$message."</div>";
  }
}
  echo "<br><br><br>";

}catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }


 ?>
