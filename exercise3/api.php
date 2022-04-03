<?php

//obtien toutes les headers
$all = getallheaders();
header("Content-Type: application/json");

// retourner hello world
// $reply = ["hello" => "world"];
// echo json_encode($reply);
// echo "\n";

//retourner toutes les headers
// echo json_encode($all);
// echo "\n";

$xmen = $all["X-Men"] ?? null;
if (!$xmen) {
    http_response_code(400);
    exit;
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

$reply = ["mutant" => $xmen, "name" => $name];
echo json_encode($reply);
echo "\n";

?>
