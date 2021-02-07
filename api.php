<?php
//developed by capo

// DB Connect
$con = mysqli_connect("localhost","x","x","x");
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//OT API Creds
$XApiId = "x";
$XApiKey = "x";
$XApiSecret = "x";

//Fetch Onetap UserID
$configid = $_GET["configid"];
$scriptid = $_GET["scriptid"];
$otuserid = $_GET["term"];


// Parameter fetch
$apiKey = $_GET["apiKey"];
$action = $_GET["action"];

// api key check
if ($apiKey == NULL) {
    die("set a api key"); 
}
if ($action == NULL) {
    die("no action set"); 
}

if ($apiKey != "x") {
    die("api key invalid"); 
}

// add subscription config https://rndm.ch/api.php?apiKey=x&action=configsub&scriptid=2455&otuserid=1234
if ($action == "configsub") {  
    $query2 = "SELECT * FROM `subs` WHERE userid='$otuserid' AND pid='$configid'";

if ($result2 = $con->query($query2)) {
if ($row2 = $result2->fetch_assoc()) {
$userid = $row2["userid"];

if ($userid != NULL) {
    die("user already subscribed"); 
}
}  
} 
    $sql2 = "INSERT INTO subs (userid, type, pid) VALUES ('$otuserid', 'config', '$configid')";
	if(mysqli_query($con, $sql2)) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.onetap.com/cloud/configs/'.$configid.'/subscriptions',   
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0, 
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'application%2Fx-www-form-urlencoded=&user_id=' . $otuserid,
      CURLOPT_HTTPHEADER => array(
        'X-Api-Id: ' . $XApiId,
        'X-Api-Secret: ' . $XApiSecret, 
        'X-Api-Key: ' . $XApiKey,
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = curl_exec($curl);
    $data = json_decode($response);
    curl_close($curl);
    die("config subscription added"); 
} else {
    die("db error");
}
}

// add subscription script  https://rndm.ch/api.php?apiKey=x&action=scriptsub&scriptid=133&otuserid=1234
if ($action == "scriptsub") {  
    $query2 = "SELECT * FROM `subs` WHERE userid='$otuserid' AND pid='$scriptid'";

    if ($result2 = $con->query($query2)) {
    if ($row2 = $result2->fetch_assoc()) {
    $userid = $row2["userid"];
    
    if ($userid != NULL) {
        die("user is already subscribed"); 
    }
    }  
    } 
    $sql2 = "INSERT INTO subs (userid, type, pid) VALUES ('$otuserid', 'script', '$scriptid')";
	if(mysqli_query($con, $sql2)) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.onetap.com/cloud/scripts/'.$scriptid.'/subscriptions',   
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0, 
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'application%2Fx-www-form-urlencoded=&user_id=' . $otuserid,
      CURLOPT_HTTPHEADER => array(
        'X-Api-Id: ' . $XApiId,
        'X-Api-Secret: ' . $XApiSecret, 
        'X-Api-Key: ' . $XApiKey,
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = curl_exec($curl);
    $data = json_decode($response);
    curl_close($curl);
    die("script subscription added"); 
}
}

// remove subscription script   https://rndm.ch/api.php?apiKey=x&action=rmvscriptsub&scriptid=133&otuserid=1234
if ($action == "rmvscriptsub") {  
    $query2 = "SELECT * FROM `subs` WHERE userid='$otuserid' AND pid='$scriptid'";

    if ($result2 = $con->query($query2)) {
    if ($row2 = $result2->fetch_assoc()) {
    $userid = $row2["userid"];
    
    if ($userid == NULL) {
        die("user is not subscribed"); 
    }
    }  
    } 
    $sql2 = "DELETE FROM subs WHERE pid='$scriptid' AND userid='$otuserid'";
	if(mysqli_query($con, $sql2)) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.onetap.com/cloud/scripts/'.$scriptid.'/subscriptions',   
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0, 
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
      CURLOPT_CUSTOMREQUEST => 'DELETE',
      CURLOPT_POSTFIELDS => 'application%2Fx-www-form-urlencoded=&user_id=' . $otuserid,
      CURLOPT_HTTPHEADER => array(
        'X-Api-Id: ' . $XApiId,
        'X-Api-Secret: ' . $XApiSecret, 
        'X-Api-Key: ' . $XApiKey,
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = curl_exec($curl);
    $data = json_decode($response);
    curl_close($curl);
    die("script subscription removed"); 

}
}

// remove subscription config   https://rndm.ch/api.php?apiKey=x&action=rmvconfigsub&scriptid=133&otuserid=1234 example
if ($action == "rmvconfigsub") {  
    $query2 = "SELECT * FROM `subs` WHERE userid='$otuserid' AND pid='$configid'";

    if ($result2 = $con->query($query2)) {
    if ($row2 = $result2->fetch_assoc()) {
    $userid = $row2["userid"];
    
    if ($userid == NULL) {
      die("user is not subscribed"); 
    }
    }  
    } 
    $sql2 = "DELETE FROM subs WHERE pid='$configid' AND userid='$otuserid'";
	if(mysqli_query($con, $sql2)) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.onetap.com/cloud/configs/'.$configid.'/subscriptions',   
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0, 
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
      CURLOPT_CUSTOMREQUEST => 'DELETE',
      CURLOPT_POSTFIELDS => 'application%2Fx-www-form-urlencoded=&user_id=' . $otuserid,
      CURLOPT_HTTPHEADER => array(
        'X-Api-Id: ' . $XApiId,
        'X-Api-Secret: ' . $XApiSecret, 
        'X-Api-Key: ' . $XApiKey,
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = curl_exec($curl);
    $data = json_decode($response);
    curl_close($curl);
    die("config subscription removed"); 

}
}

//count active subs   https://rndm.ch/api.php?apiKey=x&action=activesubs
if ($action == "activesubs") {  
    $sql = "SELECT * FROM subs";
    $mysqliStatus = $con->query($sql);
    $rows_count_value = mysqli_num_rows($mysqliStatus); 
echo $rows_count_value;
}
?>
