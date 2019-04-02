<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 */

// format request update dari api.php : ?objek=val&kriteria_field=val&field=valbaru
//
// PENTING : nama objek juga menjadi nama tabel
//

require("../ManajemenDB.php");

$db = new ManajemenDB();

$objek = $_POST["objek"];
$fieldKriteria = explode("->", array_keys($_POST)[1])[1];

if(count($_POST) > 2) {
  $field = array_keys($_POST)[2];
  $valBaru = $_POST[$field];
  
  if($db->ubah($objek, $fieldKriteria, $_POST[array_keys($_POST)[1]],
          $field, $valBaru)) {   
    echo "{\"status\":\"sukses\"}";
  }
  else {
    echo "{\"status\":\"gagal\"}";
  }
}
else {
  echo "{\"status\":\"error\"}";
}