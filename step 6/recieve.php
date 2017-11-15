<?php


	$token = "";
	$chatid = "";


	$jsonArray = json_decode(file_get_contents("php://input"),true); //json decode



	$payLoad = $jsonArray["DevEUI_uplink"]["payload_hex"]; // get payload key from array
	$payload = hex2bin($payload);

	file_put_contents('data.txt', $payLoad);


	$servdername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "";

	$datum = date("d-m-Y H:i:s", time());

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO volt (message)
	VALUES ('$payLoad')";

	if ($conn->query($sql) === TRUE) {
	   // echo "New record created successfully";
	} else {
	  //  echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();


	$payLoad = explode("f", $payLoad);

	$payLoad[0] = substr_replace( $payLoad[0], ',', -2, 0 );
	$payLoad[1] = substr_replace( $payLoad[1], ',', -2, 0 );

	$payLoad[0] = ltrim($payLoad[0], '0');
	$payLoad[0] = rtrim($payLoad[0], '0');

	$payLoad[1] = ltrim($payLoad[1], '0');
	$payLoad[1] = rtrim($payLoad[1], '0');

	$payLoad = "Het is " . $payLoad[0] . " graden en de vochtigheid is " . $payLoad[1] . "%";

	sendMessage($chatid, $payLoad, $token);

	function sendMessage($chatID, $messaggio, $token) {
    echo "sending message to " . $chatID . "\n";


    $url = "https://api.telegram.org/" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
	}
?>
