<?php
$DEBUG = true;							// Priprava podrobnejših opisov napak (med testiranjem)

include("orodja.php"); 					// Vključitev 'orodij'

$DB = dbConnect();					// Pridobitev povezave s podatkovno zbirko

header('Content-Type: application/json');	// Nastavimo MIME tip vsebine odgovora
header('Access-Control-Allow-Origin: *');	// Dovolimo dostop izven trenutne domene (CORS)
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');		//v preflight poizvedbi za CORS sta dovoljeni le metodi GET in POST

switch($_SERVER["REQUEST_METHOD"])		// Glede na HTTP metodo v zahtevi izberemo ustrezno dejanje nad virom
{
	case 'GET':
        if (!empty($_GET["username"])){
          #  if(!empty($_GET["intent"])and$_GET["intent"]=="login" )
        #    {
		#		get_user($_GET["username"]);	
       #     }
      #      else
       #     {
                matchmake($_GET["username"]);		
       #     }
         }
        else
        {
            http_response_code(400);	
        }
            break;
		
	
	case 'POST':
		if(!empty($_GET["intent"])and$_GET["intent"]=="login" )
		{
			get_user($_GET["username"]);		
		}
		else{
		add_user();
		}
		break;
		
	case 'PUT':
		if(!empty($_GET["username"]))
		{
			update_user($_GET["username"]);
		}
		else
		{
			http_response_code(400);	
		}
		break;

	case 'OPTIONS':						//Options dodan zaradi pre-fight poizvedbe za CORS (pri uporabi metod PUT in DELETE)
		http_response_code(204);
		break;
		
	default:
		http_response_code(405);		//Če naredimo zahtevo s katero koli drugo metodo je to 'Method Not Allowed'
		break;
}

mysqli_close($DB);					// Sprostimo povezavo z zbirko


// ----------- konec skripte, sledijo funkcije -----------

function get_user($username)
{
	global $DB;
	

	
	if (!check_credentials($username)){
		http_response_code(403);
		return;
	}

	$username=mysqli_escape_string($DB, $username);
	
	$poizvedba="SELECT * FROM user WHERE username='$username'";
	
	$rezultat=mysqli_query($DB, $poizvedba);

	if(mysqli_num_rows($rezultat)>0)	//igralec obstaja
	{
		$odgovor=mysqli_fetch_assoc($rezultat);
		
		http_response_code(200);		//OK
		echo json_encode($odgovor);
	}
	else							// igralec ne obstaja
	{
		http_response_code(404);		//Not found
	}
}





function matchmake($username)
{
	global $DB;
	$user_data=array();
    

	$poizvedba="SELECT username, contact, game_times, game_days, language FROM user WHERE username='$username'";	
	
	$rezultat=mysqli_query($DB, $poizvedba);
	
	while($vrstica=mysqli_fetch_assoc($rezultat))
	{
		$user_data[]=$vrstica;
	}
	
	//pripravi_odgovor_napaka($odgovor);

    $language=$user_data[0]["language"];

    $game_times=$user_data[0]["game_times"];
    $game_days=$user_data[0]["game_days"];


	
	$matchmaked_users=array();
    $poizvedba="SELECT username, contact, game_times, game_days, language FROM user WHERE language='$language' AND ('$game_times'&game_times) AND ('$game_days'&game_days)";	
    $rezultat=mysqli_query($DB, $poizvedba);
	
	while($vrstica=mysqli_fetch_assoc($rezultat))
	{
		$matchmaked_users[]=$vrstica;
	}


	$my_games=array();
	$poizvedba="SELECT username, game_id FROM user_game_relation WHERE username='$username' AND subscribed";	

    $rezultat=mysqli_query($DB, $poizvedba);

	while($vrstica=mysqli_fetch_assoc($rezultat))
	{
		$my_games[]=$vrstica;
	}
	

	$odgovor=array();

	foreach ($matchmaked_users as $user){
		$matchmaked_username=$user['username'];

		foreach ($my_games as $game){
			$game_id=$game["game_id"];
			$poizvedba="SELECT user_game_relation.username, game_id, game.name, contact, game_times, game_days, language FROM user_game_relation INNER JOIN user on user_game_relation.username=user.username 
			INNER JOIN game on game.id = user_game_relation.game_id WHERE user_game_relation.username='$matchmaked_username' AND subscribed AND game_id='$game_id' ORDER BY game.name";

			$rezultat=mysqli_query($DB, $poizvedba);
			while($vrstica=mysqli_fetch_assoc($rezultat))
			{
				$odgovor[]=$vrstica;
			}
		}

	}
	
	


	http_response_code(200);		//OK
	echo json_encode($odgovor);
}




function add_user()
{
	global $DB, $DEBUG;
    
	
	$data = json_decode(file_get_contents('php://input'), true);
	
	if(isset($data["username"], $data["email"], $data["password"]))

	{
		$username = mysqli_escape_string($DB, $data["username"]);
		$email = mysqli_escape_string($DB, $data["email"]);
		$password = password_hash(mysqli_escape_string($DB, $data["password"]), PASSWORD_DEFAULT);

        if(isset($data["game_times"], $data["game_days"]))
	    {

                $game_times = mysqli_escape_string($DB, $data["game_times"]);
                $game_days = mysqli_escape_string($DB, $data["game_days"]);

                }
        else{
                $game_times = 0;
                $game_days = 0;
            }
        if(isset($data["language"]))
            {
    
                    $language = mysqli_escape_string($DB, $data["language"]);
    
                    }
        else{
                    $language = NULL;
            }

        if(isset($data["contact"]))
            {
    
                    $contact = mysqli_escape_string($DB, $data["contact"]);
    
                    }
        else{
                    $contact = NULL;
            }
        


		if(!user_exists($username))
		{	
			$poizvedba="INSERT INTO user (username, password, email, game_times, game_days, language, contact) VALUES ('$username', '$password', '$email', '$game_times', '$game_days', '$language', '$contact')";
			

			try{
				if(mysqli_query($DB, $poizvedba))
				{
					http_response_code(201);	// Created
					$odgovor=URL_vira($username);
					echo json_encode($odgovor);
				}
				else
				{
					http_response_code(500);	// Internal Server Error (ni nujno vedno streznik kriv!)
					
					if($DEBUG)	//Pozor: vračanje podatkov o napaki na strežniku je varnostno tveganje!
					{
						pripravi_odgovor_napaka(mysqli_error($DB));
					}
				}
			}
			catch (mysqli_sql_exception $e) {
				http_response_code(400);
				exit;
			}
		}
		else
		{
			http_response_code(409);	// Conflict
			pripravi_odgovor_napaka("Igralec že obstaja!");
		}
	}


	else
	{
		http_response_code(400);
        pripravi_odgovor_napaka(file_get_contents('php://input'));	// Bad Request
	}
}






function update_user($username)
{
	global $DB, $DEBUG;
	
	$username = mysqli_escape_string($DB, $username);
	
	

	if (!check_credentials($username)){
		http_response_code(403);
		return;
	}
	
	$data = json_decode(file_get_contents("php://input"),true);
		
	if(user_exists($username))
	{

		$sucess=false;

        if(isset($data["game_times"], $data["game_days"]))
	    {

            $game_times = mysqli_escape_string($DB, $data["game_times"]);
            $game_days = mysqli_escape_string($DB, $data["game_days"]);
            $query = "UPDATE user SET game_times='$game_times', game_days='$game_days' WHERE username='$username'";
			if(mysqli_query($DB, $query))
			{
				$sucess=true;
			}
            }

        if(isset($data["language"]))
        {
    
            $language = mysqli_escape_string($DB, $data["language"]);
            $query = "UPDATE user SET language='$language' WHERE username='$username'";
			try{
				if(mysqli_query($DB, $query))
				{
					$sucess=true;
				}
					}
			catch (mysqli_sql_exception $e) {
				http_response_code(400);
				exit;
			}
				
				
		}


        if(isset($data["contact"]))
        {
    
            $contact = mysqli_escape_string($DB, $data["contact"]);
            $query = "UPDATE user SET contact='$contact' WHERE username='$username'";
			if(mysqli_query($DB, $query))
			{
				$sucess=true;
			}
            }
        
        if(isset($data["new_password"]))
        {
            
            $password = password_hash(mysqli_escape_string($DB, $data["new_password"]), PASSWORD_DEFAULT);
            $query = "UPDATE user SET password='$password' WHERE username='$username'";
			if(mysqli_query($DB, $query))
			{
				$sucess=true;
			}
            
        }


			
        if($sucess==true)
        {
            http_response_code(204);	//OK with no content
        }
        else
		{
            http_response_code(500);	// Internal Server Error (ni nujno vedno streznik kriv!)
            
            if($DEBUG)	//Pozor: vračanje podatkov o napaki na strežniku je varnostno tveganje!
            {
                pripravi_odgovor_napaka(mysqli_error($DB));
                }
        }
	}        
	
	else
	{
		http_response_code(404);	// Not Found
	}
}	


?>