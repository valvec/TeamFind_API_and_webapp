<?php
$DEBUG = true;

include("orodja.php"); 			// Vključitev 'orodij'

$DB = dbConnect();			//Pridobitev povezave s podatkovno zbirko

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');	// Dovolimo dostop izven trenutne domene (CORS)
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');	
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

switch($_SERVER["REQUEST_METHOD"])			//glede na HTTP metodo izvedemo ustrezno dejanje nad virom
{
	case 'GET':
		if(!empty($_GET["username"])){ 

            if(!empty($_GET["game_id"]) and $_GET["intent"]=="get_game_relation" ){
                    get_game_relation($_GET["username"],$_GET["game_id"]);	
                }
            else{
              //  get_my_games($_GET["username"]);
              http_response_code(405);
            }	


		}
        
		else
		{
			get_games();	
		}
		break;
		
	case 'PUT':

        if(!empty($_GET["username"]) and !empty($_GET["intent"])and $_GET["intent"]=="rate")
		{
			rate_game($_GET["username"]);
        }

        elseif(!empty($_GET["username"]) and !empty($_GET["intent"])and $_GET["intent"]=="subscribe")
		{
			subscribe($_GET["username"]);
        }

        elseif(!empty($_GET["username"]) and !empty($_GET["intent"])and $_GET["intent"]=="get")
		{
			get_my_games($_GET["username"]);
        }

        else
		{
			http_response_code(400);	
		}
		break;
    case "POST":

        if(!empty($_GET["username"])){ 
                get_my_games($_GET["username"]);
            }
        else
            {
                http_response_code(400);	
            }
        break;
    case 'OPTIONS':						
        http_response_code(204);
        break;
		
	default:
		http_response_code(405);	
		break;
}

mysqli_close($DB);					




function get_my_games($username)
{
	global $DB;
	$username=mysqli_escape_string($DB, $username);
	$odgovor=array();
    
	if (!check_credentials($username)){
		http_response_code(403);
		return;
	}


    $poizvedba="SELECT name,description,subscribed,game.rating AS average_rating,user_game_relation.rating AS user_raitng, game.ID FROM game INNER JOIN user_game_relation on user_game_relation.game_id=game.ID WHERE user_game_relation.username='$username' AND subscribed!=0";
    
    $result=mysqli_query($DB, $poizvedba);

    while($vrstica=mysqli_fetch_assoc($result))
    {
        $odgovor[]=$vrstica;
    }
    
    http_response_code(200);		//OK
    echo json_encode($odgovor);	

}

function get_games()
{
	global $DB;
	
	$odgovor=array();
    


    $poizvedba="SELECT name,description, ID, rating AS average_rating FROM game";
    
    $result=mysqli_query($DB, $poizvedba);

    while($vrstica=mysqli_fetch_assoc($result))
    {
        $odgovor[]=$vrstica;
    }
    
    http_response_code(200);		//OK
    echo json_encode($odgovor);	

}


function rate_game($username){
	global $DB;        
	if (!check_credentials($username)){
		http_response_code(403);
		return;
	}

    $data = json_decode(file_get_contents('php://input'), true);
	
	if(isset($data["game_id"], $data["rating"]))	{

        $username=mysqli_escape_string($DB, $username);

        $rating=mysqli_escape_string($DB, $data["rating"]);

        if ($rating >5 or $rating<0){
            http_response_code(400);
            return;
        }

        $gameID=mysqli_escape_string($DB, $data["game_id"]);

        $query="SELECT * FROM user_game_relation WHERE user_game_relation.username='$username' AND game_id=$gameID";
        
        $result=mysqli_query($DB, $query);

        $vrstica=mysqli_fetch_assoc($result);       

        if(!is_null($vrstica)){
            $relID=$vrstica["rel_id"];
            $query = "UPDATE user_game_relation SET rating='$rating' WHERE rel_id='$relID'";
        }
        else{

            $query = "INSERT INTO user_game_relation (username, game_id, subscribed, rating) VALUES ('$username', '$gameID', 1 , '$rating')";
        }    
        
        $result=mysqli_query($DB, $query);
       
        http_response_code(204);		//OK
        echo json_encode($odgovor);


        $query="SELECT AVG(rating) FROM user_game_relation WHERE game_id=$gameID;";
        
        $result=mysqli_query($DB, $query);

        $vrstica=mysqli_fetch_assoc($result); 
        
        $avg_rt=$vrstica["AVG(rating)"];

        $query="UPDATE game set rating='$avg_rt' WHERE ID=$gameID;";
        
        $result=mysqli_query($DB, $query);



    }
    else{
        http_response_code(400);
    }
}


function subscribe($username){
	global $DB;        
	if (!check_credentials($username)){
		http_response_code(403);
		return;
	}

    $data = json_decode(file_get_contents('php://input'), true);
	
	if(isset($data["game_id"], $data["subscribed"]))	{

        $username=mysqli_escape_string($DB, $username);

        $subscribed=mysqli_escape_string($DB, $data["subscribed"]);

        $gameID=mysqli_escape_string($DB, $data["game_id"]);

        $query="SELECT * FROM user_game_relation WHERE user_game_relation.username='$username' AND game_id=$gameID";
        
        $result=mysqli_query($DB, $query);

        $vrstica=mysqli_fetch_assoc($result);       


        if(!is_null($vrstica)){
            $relID=$vrstica["rel_id"];
            $query = "UPDATE user_game_relation SET subscribed='$subscribed' WHERE rel_id='$relID'";
        }
        else{

            $query = "INSERT INTO user_game_relation (username, game_id, subscribed) VALUES ('$username', '$gameID', $subscribed)";
        }    
        
        $result=mysqli_query($DB, $query);
       
        http_response_code(204);		//OK
        echo json_encode($odgovor);	
    }
    else{
        http_response_code(400);
    }
}
/*
function get_game_relation($username,$game_id){
    global $DB;
    $username=mysqli_escape_string($DB, $username);
    $game_id=mysqli_escape_string($DB, $game_id);

    $poizvedba="SELECT * FROM user_game_relation WHERE game_id=$game_id AND username=$username";
    
    $result=mysqli_query($DB, $poizvedba);

    $odgovor=mysqli_fetch_assoc($result);

    
    http_response_code(200);		//OK
    echo json_encode($odgovor);	


}
*/
function get_game_relation($username, $game_id) {
    global $DB;
  
    // Use a prepared statement to prevent SQL injection attacks
    $stmt = $DB->prepare("SELECT * FROM user_game_relation WHERE game_id = ? AND username = ?");
    $stmt->bind_param("is", $game_id, $username);
    $stmt->execute();
  
    $result = $stmt->get_result();
  
    // Check if there are any rows in the result set
    if ($result->num_rows > 0) {
      $odgovor = $result->fetch_assoc();
      
      echo json_encode($odgovor);
    } 
    http_response_code(200);
  }





















?>