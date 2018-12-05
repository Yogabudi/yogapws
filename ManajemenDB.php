<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 */

// Class ManajemenDB mengatur semua tabel yang ada di database
// Pastikan nama semua tabel tidak mengandung kata "tabel"
// agar bisa disamakan dengan nama objek
// 
// PENTING : nama objek juga menjadi nama tabel

require("Konfigurasi.php");

class ManajemenDB {

  // menyimpan informasi status koneksi database
  protected $koneksi;

  public function __construct() {
    $this->koneksi = false;
  }

  // method ini selalu dipanggil sebelum memulai operasi database
  public function sambungkan() {
    // jika belum tersambung, maka sambungkan
    if(!$this->koneksi) {
      $this->koneksi = mysqli_connect(Konfigurasi::$HOST, Konfigurasi::$USER,
                                      Konfigurasi::$PASSWORD, Konfigurasi::$NAMA_DB);
    }

    return (boolean)$this->koneksi;
  }

  // method ini untuk mendapatkan semua data pada tabel tertentu
  public function dapatkanSemuanya(string $tabel) {
    // siapkan array 2-dimensional untuk menyimpan data
    // (format akses : $semuaData[index]["field"] )
    $semuaData = [];

    // sambungkan sebelum memulai operasi
    if($this->sambungkan()) {
      // eksekusi query
      $query = mysqli_query($this->koneksi, "select * from " . $tabel);

      // masukkan masing-masing data assosiatif ke array $semuaData
      $i = 0;
      while($data = mysqli_fetch_assoc($query)) {
        $semuaData[$i] = $data;
        $i++;
      }
    }

    return (array)$semuaData;
  }

  // method ini untuk mendapatkan satu data berdasarkan kriteria
  public function dapatkanSatu(string $tabel, string $fieldKriteria,
                                string $valKriteria) {
    // siapkan array assosiatif untuk menyimpan sebaris data
    $sebarisData = [];

    // sambungkan sebelum memulai operasi
    if($this->sambungkan()) {
      // eksekusi query select berdasarkan kriteria
      $query = mysqli_query($this->koneksi,
                  "select * from " . $tabel .
                  " where " . $fieldKriteria . " = '" .
                              $valKriteria . "'");

      // masukkan sebaris data ke array
      $sebarisData = mysqli_fetch_assoc($query);
    }

    return (array)$sebarisData;
  }

  // method ini untuk memasukkan data ke tabel
  // menggunakan array assosiatif
  public function masukkan(string $tabel, array $dataAssoc) {
    $sukses = false;
    
    // dapatkan daftar semua field kecuali id (primary key)
    $dataField = $this->dapatkanSemuaFieldTanpaId($tabel);

    // sambungkan sebelum memulai operasi
    if($this->sambungkan()) {
      // buat daftar field dan sebaris data
      // sesuai dengan sintaks SQL
      // (field1, field2,...)
      // ('dataField1, dataField2,...)
      $sebarisField = "(" . implode(", ", $dataField) . ")";
      $sebarisData = "('" . implode("', '", $dataAssoc) . "')";

      // masukkan sebaris field dan data ke string query insert
      $sql = "insert into " . $tabel . $sebarisField . " values " .
                $sebarisData;

      // eksekusi query insert
      $query = mysqli_query($this->koneksi, $sql);

      // jika query berhasil dieksekusi, maka return status
      if($query) {
        $sukses = true;
      }
    }

    return (boolean)$sukses;
  }

  // method ini untuk mengubah satu record data pada satu field
  // berdasarkan kriteria
  public function ubah(string $tabel, string $fieldKrit, string $valKrit,
                        string $field, string $val) {
    $sukses = false;

    // sambungkan sebelum memulai operasi
    if($this->sambungkan()) {
      // siapkan perintah sql lalu eksekusi perintah sql
      $sql = "update " . $tabel . " set " . $field . " = '" . $val . "' where " .
              $fieldKrit . " = '" . $valKrit . "'";
      $query = mysqli_query($this->koneksi, $sql);

      // jika berhasil maka return status
      if($query) {
        $sukses = true;
      }
    }

    return (boolean)$sukses;
  }

  // method ini untuk menghapus sebaris data pada tabel dengan kriteria tertentu
  public function hapus(string $tabel, string $fieldKrit, string $valKrit) {
    $sukses = false;

    // sambungkan sebelum memulai operasi
    if($this->sambungkan()) {
      // siapkan perintah sql lalu eksekusi
      $sql = "delete from " . $tabel .
              " where " . $fieldKrit . " = '" . $valKrit . "'";
      $query = mysqli_query($this->koneksi, $sql);

      // jika query berhasil maka return status
      if($query) {
        $sukses = true;
      }
    }

    return (boolean)$sukses;
  }

  // method ini untuk menghapus semua data pada tabel
  public function hapusSemua(string $tabel) {
    $sukses = false;

    // sambungkan sebelum memulai operasi
    if($this->sambungkan()) {
      // siapkan perintah sql lalu eksekusi
      $sql = "delete from " . $tabel;
      $query = mysqli_query($this->koneksi, $sql);

      // jika query berhasil maka return status
      if($query) {
        $sukses = true;
      }
    }

    return (boolean)$sukses;
  }

  // method ini untuk mengambil semua field tabel
  // dan menyimpannya ke array
  public function dapatkanSemuaField(string $tabel) {
    // siapkan array untuk menyimpan daftar field tabel
    $field = [];

    if($this->sambungkan()) {
      // eksekusi query describe
      $query = mysqli_query($this->koneksi, "describe " . $tabel);
      
      $i = 0;
      while($data = mysqli_fetch_assoc($query)) {
        // jika field bukan id maka masukkan field ke array
        $field[$i++] = $data["Field"];
      }
    }

    return (array)$field;
  }

  // method ini untuk mengambil daftar field kecuali id (primary key)
  // dan menyimpannya ke array
  public function dapatkanSemuaFieldTanpaId(string $tabel) {
    // siapkan array untuk menyimpan daftar field
    $field = [];

    if($this->sambungkan()) {
      // eksekusi query describe
      $query = mysqli_query($this->koneksi, "describe " . $tabel);

      // mulai looping dari field pertama sampai field terakhir
      $i = 0;
      while($data = mysqli_fetch_assoc($query)) {
        // jika field bukan id maka masukkan field ke array
        if($data["Field"] != "id") {
          $field[$i++] = $data["Field"];
        }
      }
    }

    return (array)$field;
  }
  
  function testing() {
    if ($this->sambungkan()) {
      $query = mysqli_query($this->koneksi, "describe buku");
      
      while($data = mysqli_fetch_assoc($query)) {
        echo $data["Field"] . "<br>";
      }
    }
  }

}
?>
