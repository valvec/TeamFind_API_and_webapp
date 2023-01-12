<?php

/**
 * Funkcija vzpostavi povezavo z zbirko podatkov na proceduralni način
 *
 * @return $conn objekt, ki predstavlja povezavo z izbrano podatkovno zbirko
 */
function dbConnect()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "teamfind";

	// Ustvarimo povezavo do podatkovne zbirke
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conn,"utf8");
	
	// Preverimo uspeh povezave
	if (mysqli_connect_errno())
	{
		printf("Povezovanje s podatkovnim strežnikom ni uspelo: %s\n", mysqli_connect_error());
		exit();
	} 	
	return $conn;
}




function pripravi_odgovor_napaka($vsebina)
{
	$odgovor=array(
		'status' => 0,
		'error_message'=>$vsebina
	);
	echo json_encode($odgovor);
}



function user_exists($username)
{	
	global $DB;
	$username=mysqli_escape_string($DB, $username);
	
	$poizvedba="SELECT * FROM user WHERE username='$username'";
	
	if(mysqli_num_rows(mysqli_query($DB, $poizvedba)) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}	
}










function URL_vira($vir)
{
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	{
		$url = "https"; 
	}
	else
	{
		$url = "http"; 
	}
	$url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $vir;
	
	return $url; 
}






function check_credentials($username)
{
	$data = json_decode(file_get_contents('php://input'), true);
	if(!isset($data["password"])){
		$odgovor=0;
		http_response_code(400);		//OK
		//echo json_encode($odgovor);
		return $odgovor;
	}

	global $DB;
	$username=mysqli_escape_string($DB, $username);

	
	
	if(isset($data["password"])) { 
		$password = $data["password"];


		$poizvedba="SELECT username, password FROM user WHERE username='$username'";

			
		$rezultat=mysqli_query($DB, $poizvedba);
	
	}

	if(mysqli_num_rows($rezultat)>0){

		$DBdata=mysqli_fetch_assoc($rezultat);
		$hasshed_pass_from_db=$DBdata["password"];

		if (password_verify($password, $hasshed_pass_from_db)) {
			$odgovor=1;
			http_response_code(200);
		}
		else {
			$odgovor=0;
			http_response_code(403);
		}
	}
	else {
		$odgovor=0;
		http_response_code(403);
	}

			//OK
	//echo json_encode($odgovor);
	return $odgovor;
}








?>