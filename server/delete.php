<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 */

// format request dari api.php : ?objek=val&kriteria_field=val
// 
// PENTING : nama objek juga menjadi nama tabel
//

require("../ManajemenDB.php");
require("PenyaringURL.php");

$db = new ManajemenDB();

if(!empty($_GET["objek"])) {
  $objek = $_GET["objek"];
  
  $daftarParam = PenyaringURL::dapatkanParamDariURLIni();
  
  if(count($daftarParam) > 1) {
    $fieldKriteria = explode("_", array_keys($_GET)[1])[1];
    $valKriteria = $_GET[array_keys($_GET)[1]];
    
    if($db->hapus($objek, $fieldKriteria, $valKriteria)) {   
      echo "{\"status\":\"sukses\"}";
    }
    else {
      echo "{\"status\":\"gagal\"}";
    }
  }
  else {
    if($db->hapusSemua($objek)) {   
      echo "{\"status\":\"sukses\"}";
    }
    else {
      echo "{\"status\":\"gagal\"}";
    }
  }
}
else {
  echo "{\"status\":\"error\"}";
}