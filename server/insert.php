<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 */

// format request dari api.php : ?objek=val&field1=val&field2=val&field...
// 
// PENTING : nama objek juga menjadi nama tabel
//

require("../ManajemenDB.php");

$db = new ManajemenDB();

$objek = $_POST["objek"];
$daftarField = $db->dapatkanSemuaFieldTanpaId($objek);
$data = [];

foreach ($daftarField as $field) {
  $data[$field] = (!empty($_POST[$field])) ? $_POST[$field] : "";
}

if($db->masukkan($objek, $data)) {
  echo "{\"status\":\"sukses\"}";
}
else {
  echo "{\"status\":\"gagal\"}";
}