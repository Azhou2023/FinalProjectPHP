<style>

.heading{

position: absolute;
top: 40%;
left: 45%

}

#error{
    color: red;
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

    $username = $_GET["username"];
    $select = $_GET["select"];
    $update = $_GET["updateField"];

    $checkSQL = $conn -> query("SELECT * FROM users WHERE username='$username'");
    if($checkSQL -> rowCount()==0){
        echo "<h1 class=heading id=error>Please enter a valid username";
    }else{

        if($select=="true"){  //update username
            $conn -> exec("UPDATE users SET `username`='$update' WHERE username='$username'");
            echo "<h1 class=heading>Username Updated!</h1>";
        }else{ //update password
            $conn -> exec("UPDATE users SET `password` ='$update' WHERE username='$username'");
            echo "<h1 class=heading>Password Updated!</h1>";
        }
    }


}catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
