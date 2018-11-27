<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 */

// format request read dari api.php         : ?objek=val&field=val
// format request read all dari api.php     : ?objek=val
// PENTING : nama objek juga menjadi nama tabel

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require("../ManajemenDB.php");
require("PenyaringURL.php");

$db = new ManajemenDB();

$param = PenyaringURL::dapatkanParamDariURLIni();
$objek = $_GET["objek"];

if(count($param) > 1) {
  $valField = $_GET[$param[1]];
  
  $data = $db->dapatkanSatu($objek, $param[1], $valField);
  
  echo json_encode($data);
}
else {
  $data = $db->dapatkanSemuanya($objek);
  
  echo json_encode($data);
}

?>
