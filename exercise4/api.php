<?php
header("Content-Type: application/json");

//obtien toutes les headers
$all = getallheaders();

// retourner hello world
// $reply = ["hello" => "world"];
// echo json_encode($reply);
// echo "\n";

//retourner toutes les headers
// echo json_encode($all);
// echo "\n";

function error($error) {
    echo json_encode($error);
    echo "\n";
    exit;
}

//vérifier si le header "X-Men" existe
$xmen = $all["X-Men"] ?? null;
if (!$xmen) {
    http_response_code(400);
    error(["error" => "Please provide an X-Men mutant and reveal their human name.", "headers" => $all]) ;
}
//vérifier si le header "Authentication" existe
$auth = $all["Authentication"] ?? null;
if (!$auth) {
    http_response_code(400);
    error(["error" => "Please provide an authentication token.", "headers" => $all]);
} 

// noms de tout les membres des x-men des années 1970s https://en.wikipedia.org/wiki/List_of_X-Men_members
switch ($xmen) {
    case "Wolverine":
        $name = "James \"Logan\" Howlett";
        break;
    case "Sway":
        $name = "Suzanne Chan";
        break;
    case "Darwin":
        $name = "Armando Muñoz";
        break;
    case "Vulcan":
        $name = "Gabriel Summers";
        break;
    case "Nightcrawler":
        $name = "Kurt Wagner";
        break;
    case "Banshee":
        $name = "Sean Cassidy";
        break;
    case "Storm":
        $name = "Ororo Munroe";
        break;
    case "Sunfire":
        $name = "Shiro Yoshida";
        break;
    case "Colossus": 	
        $name = "Piotr Nikolaievitch Rasputin";
        break;
    case "Thunderbird":
        $name = "John Proudstar";
        break; 
    default:
        $name = "Unknown";
}

//Authentification
$auth_header = explode(" ", $auth);
$auth_info = [
    "token" => $auth_header[1],
    "type" => $auth_header[0] 
]; 
switch ($auth_info["token"]) {
    case "professorcharlesxavier":
        break;
    default:
        http_response_code(401);
        $auth_info["error"] = "Invalid token.";
        error($auth_info);
        break;
}

$reply = ["mutant" => $xmen, "name" => $name];
echo json_encode($reply);
echo "\n";

?>
