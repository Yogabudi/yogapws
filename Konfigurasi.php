<?php

/*
 * Author : Yoga Budi Yulianto
 * 
 * Class InfoDB menyimpan informasi database
 * Ubah value sesuai informasi database anda
 * 
 */

class Konfigurasi {
  // lokasi web service pada server
  // contoh : http://localhost/webservice (tanpa diakhiri "/" )
  public static $LOKASIWS = "http://localhost/yogapws"; 

  // nama database
  // contoh : db_buku
  public static $NAMA_DB = "db_buku";

  // url hosting
  // contoh : localhost
  public static $HOST = "localhost";    
  
  // username database
  // contoh : root
  public static $USER = "root";

  // password database
  public static $PASSWORD = "";
}

?>
