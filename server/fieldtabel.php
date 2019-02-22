<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 */

// format request tampilkan field dari api.php     : ?objek=val
// PENTING : nama objek juga menjadi nama tabel

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require("../ManajemenDB.php");
require("PenyaringURL.php");

$db = new ManajemenDB();
$objek = $_GET["objek"];

$data = $db->dapatkanSemuaField($objek);
$json = "{";

for($i = 0; $i < count($data); $i++) {
    $json .= "\"field" . $i . "\":\"" . $data[$i] . "\"";

    if($i < count($data) - 1) {
        $json .= ",";
    }
}

$json .= "}";

echo $json;

?>
