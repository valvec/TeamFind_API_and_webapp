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
        get_languages();
        break;
    case 'OPTIONS':						
        http_response_code(204);
        break;
		
	default:
		http_response_code(405);	
		break;
}

mysqli_close($DB);					






function get_languages()
{
	global $DB;
	
	$odgovor=array();   


    $poizvedba="SELECT * FROM languages";
    
    $result=mysqli_query($DB, $poizvedba);

    while($vrstica=mysqli_fetch_assoc($result))
    {
        $odgovor[]=$vrstica;
    }
    
    http_response_code(200);		//OK
    echo json_encode($odgovor);	

}



?>