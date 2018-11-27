<?php

/*
 * Author : Yoga Budi Yulianto (yogabudiyulianto@gmail.com)
 * 
 */

// Class PenyaringURL berisi method-method untuk
// mendapatkan URL dan parameter yang ada pada URL
// 

class PenyaringURL {

  // method ini untuk mendapatkan semua request parameter dengan method GET
  public static function dapatkanParam(string $url) {
    // siapkan array untuk menyimpan request parameter
    $daftarParam = [];

    // jika pada url terdapat "?" yang berarti terdapat parameter
    if(strpos($url, "?") !== false) {
      // pisahkan antara url dengan parameter dan ambil parameternya
      $request = explode("?", $url)[1];
      
      // jika pada url terdapat "&" yang berarti terdapat lebih dari satu parameter
      if(strpos($url, "&") !== false) {
        // pisahkan antara satu parameter dengan parameter lainnya
        $param = explode("&", $request);

        // mulai looping dari param pertama sampai terakhir
        for($i = 0; $i < count($param); $i++) {
          // pisahkan antara key dengan value nya
          // lalu masukkan masing-masing key nya ke array
          $daftarParam[$i] = explode("=", $param[$i])[0];
        }
      }
      else { // jika tidak terdapat "&" yang berarti hanya ada 1 parameter
        // langsung pisahkan key dengan value nya dan masukkan key
        // ke array index 0
        $daftarParam[0] = explode("=", $request)[0];
      }
    }

    return (array)$daftarParam;
  }

  public static function dapatkanParamDariURLIni() {
    return (array) self::dapatkanParam(self::dapatkanURL());
  }

  public static function dapatkanURL() {
    return ("http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  }
}
?>
