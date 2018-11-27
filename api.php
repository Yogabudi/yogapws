<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 * File ini dipanggil oleh aplikasi yang akan memanggil API
 * 
 */

// sintaks API read       : ?perintah=operasi,objek,fieldkriteria:valuekriteria
// sintaks API read all   : ?perintah=operasi,objek
// sintaks API insert     : ?perintah=operasi,objek,field1:val1,field2:val2...
// sintaks API update     : ?perintah=operasi,objek,fieldKriteria:valKriteria,field:valbaru
// sintaks API delete     : ?perintah=operasi,objek,fieldKriteria:valKriteria
// sintaks API delete all : ?perintah=operasi,objek

// contoh read       : ?perintah=read,buku,judul:Android Cookbook
// contoh read all   : ?perintah=read,buku
// contoh insert     : ?perintah=insert,buku,judul:A,edisi:B,penulis:C
// contoh update     : ?perintah=update,buku,judul;Android Cookbook,judul:B
// contoh delete     : ?perintah=delete,buku,judul:A
// contoh delete all : ?perintah=delete,buku

// format request read ke server         : ?objek=val&field=val
// format request read all ke server     : ?objek=val
// format request insert ke server       : ?objek=val&field1=val&field2=val&field...
// format request update ke server       : ?objek=val&kriteria_field=val&field=valbaru
// format request delete ke server       : ?objek=val&kriteria_field=val
// format request delete all ke server   : ?objek=val

// PENTING : nama objek juga menjadi nama tabel

// simpan url CRUD server
$urlRead = "http://localhost/SimpleWebService/server/read.php";
$urlInsert = "http://localhost/SimpleWebService/server/insert.php";
$urlUpdate = "http://localhost/SimpleWebService/server/update.php";
$urlDelete = "http://localhost/SimpleWebService/server/delete.php";

// jika perintah ada pada url atau perintah tersedia
if(!empty($_GET["perintah"])) {
  // simpan perintah
  $perintah = $_GET["perintah"];
  
  // mulai terjemahkan sintaks perintah
  // masukkan masing-masing sintaks perintah yang dipisahkan oleh koma (,)
  // ke dalam array
  $sintaks = explode(",", $perintah);
  // sintaks memiliki 2 statement
  // sintaks pertama di index 0 : operasi dari perintah tersebut (read, insert, update, delete)
  // sintaks kedua di index 1 : objek/nama tabel yang akan menjadi target perintah
  $operasi = $sintaks[0];
  $objek = $sintaks[1];
  
  // jika operasi yang diinginkan adalah read
  if($operasi == "read") {
    // jika sintaks perintah memiliki parameter maka pada operasi read
    // statement ke 3 adalah parameter
    // contoh : read,buku,judul:A
    // dari contoh diatas berarti judul adalah parameter dari sintaks
    if(count($sintaks) > 2) {
      // sintaks perintah yang berupa parameter adalah kriteria pada operasi read
      // maka ambil sintaks tersebut 
      $kriteria = $sintaks[2];
      // sintaks parameter ini memiliki format field:value
      // maka ambil field dan value nya
      $field = explode(":", $kriteria)[0];
      $value = explode(":", $kriteria)[1];

      // buat request parameter untuk dikirimkan ke server
      // dengan request param : objek={valobjek}&{namafield}={valfield}
      $param = "objek=" . urlencode($objek) . "&" . $field . "=" . urlencode($value);

      // akses url read dengan curl dan request parameter yang sudah ditentukan
      // menggunakan method GET
      $curl = curl_init($urlRead . "?" . $param);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $respon = curl_exec($curl);
      curl_close($curl);

      // lalu tampilkan respon yang berformat JSON dari server
      echo $respon;
    }
    else { // jika tidak ada parameter pada sintaks
      // atur request parameter,
      // kirimkan hanya objek/nama tabel ke server
      $param = "objek=" . urlencode($objek);
      
      // akses url read dengan curl dan request parameter yang sudah ditentukan
      // meggunakan method GET
      $curl = curl_init($urlRead . "?" . $param);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $respon = curl_exec($curl);
      curl_close($curl);

      // lalu tampilkan respon yang berformat JSON dari server
      echo $respon;
    }
  }
  else if($operasi == "insert") { // jika operasi yang diinginkan adalah insert
    // siapkan array assosiatif untuk menyimpan data request 
    // yang akan dikirimkan ke server
    // key pertama berupa objek/nama tabel
    $data = [];
    $data["objek"] = $objek;
    
    // mulai looping dari sintaks perintah statement ke 3 dan seterusnya
    // statement ke 3 dan seterusnya dari sintaks pada operasi insert adalah
    // data yang akan dimasukkan ke database
    // contoh : insert,buku,judul:A,edisi:B,penulis:C
    for($i = 2; $i < count($sintaks); $i++) {
      // ambil field dan value dari sintaks
      $field = explode(":", $sintaks[$i])[0];
      $value = explode(":", $sintaks[$i])[1];
      
      // dan masukkan masing-masing field dan value ke array $data
      // field akan menjadi key nya
      $data[$field] = $value;
    }
    
    // akses url insert dengan curl
    // array $data akan diubah ke format request parameter
    // dengan fungsi http_build_query()
    // lalu kirim ke server dengan method POST
    $curl = curl_init($urlInsert);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respon = curl_exec($curl);
    curl_close($curl);
    
    // lalu tampilkan respon yang berformat JSON dari server
    echo $respon;
  }
  else if($operasi == "update") { // jika operasi yang diinginkan adalah update
    // statement ke 3 adalah kriteria
    // statement ke 4 adalah data baru
    
    // siapkan array assosiatif untuk menyimpan data request 
    // yang akan dikirimkan ke server
    // key pertama berupa objek/nama tabel
    $data = [];
    $data["objek"] = $objek;
    
    // ambil field kriteria (sintaks perintah statement ke 3)
    // tambahkan teks "kriteria_" pada awal nama field
    // untuk membedakan antara nama field kriteria dengan nama field yang
    // akan ditambahkan dengan data baru.
    $fieldKriteria = "kriteria_" . explode(":", $sintaks[2])[0];
    // ambil value kriteria, lalu ambil nama field yang akan ditambahkan
    // dengan data baru beserta datanya di statement ke 4
    $valKriteria = explode(":", $sintaks[2])[1];
    $field = explode(":", $sintaks[3])[0];
    $valBaru = explode(":", $sintaks[3])[1];
    
    // masukkan nama field kriteria sebagai key pada array dan masukkan valuenya
    // begitu juga dengan nama field yang akan ditambahkan data beserta valuenya
    $data[$fieldKriteria] = $valKriteria;
    $data[$field] = $valBaru;
    
    // akses url insert dengan curl
    // array $data akan diubah ke format request parameter
    // dengan fungsi http_build_query()
    // lalu kirim ke server dengan method POST
    $curl = curl_init($urlUpdate);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respon = curl_exec($curl);
    curl_close($curl);
    
    // lalu tampilkan respon yang berformat JSON dari server
    echo $respon;
  }
  else if($operasi == "delete") { // jika operasi yang diinginkan adalah delete
    // jika sintaks perintah memiliki parameter maka pada operasi delete
    // statement ke 3 adalah parameter
    // contoh : delete,buku,judul:A
    // dari contoh diatas berarti judul adalah parameter dari sintaks
    if(count($sintaks) > 2) {
      // sintaks parameter ini memiliki forma/ sintaks parameter ini memiliki format field:value
      // maka ambil field dan value nyat field:value
      // maka ambil field dan value nya
      $fieldKriteria = explode(":", $sintaks[2])[0];
      $valKriteria = explode(":", $sintaks[2])[1];
      
      // siapkan request parameter untuk dikirimkan ke server
      $param = "objek=" . urlencode($objek) . "&" .
              "kriteria_" . $fieldKriteria . "=" . urlencode($valKriteria);
      
      // akses url delete dengan curl dan request parameter yang sudah ditentukan
      // menggunakan method GET
      $curl = curl_init($urlDelete . "?" . $param);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $respon = curl_exec($curl);
      curl_close($curl);
      
      // lalu tampilkan respon yang berformat JSON dari server
      echo $respon;
    }
    else { // jika tidak ada sintaks statement ke 3, maka hapus semua
      // siapkan request parameter dan kirimkan objek/nama tabel
      $param = "objek=" . urlencode($objek);
      
      // akses url delete dengan curl dan request parameter yang sudah ditentukan
      // menggunakan method GET
      $curl = curl_init($urlDelete . "?" . $param);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $respon = curl_exec($curl);
      curl_close($curl);
      
      // lalu tampilkan respon yang berformat JSON dari server
      echo $respon;
    }
  }
}