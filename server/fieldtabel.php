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

$param = PenyaringURL::dapatkanParamDariURLIni();
$objek = $_GET["objek"];

$data = $db->dapatkanSemuaField($objek);
echo json_encode($data);

?>
