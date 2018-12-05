# Pengenalan YogaPWS
YogaPWS adalah sebuah web service RESTful portable yang bisa disambungkan ke setiap tabel yang ada pada database

## Apa itu Web Service RESTful ?
REST (REpresentational State Transfer) merupakan standar arsitektur komunikasi berbasis web yang sering diterapkan dalam pengembangan layanan berbasis web. Umumnya menggunakan HTTP (Hypertext Transfer Protocol) sebagai protocol untuk komunikasi data. REST pertama kali diperkenalkan oleh Roy Fielding pada tahun 2000.

Pada arsitektur REST, REST server menyediakan resources (sumber daya/data) dan REST client mengakses dan menampilkan resource tersebut untuk penggunaan selanjutnya. Setiap resource diidentifikasi oleh URIs (Universal Resource Identifiers) atau global ID. Resource tersebut direpresentasikan dalam bentuk format teks, JSON atau XML. Pada umumnya formatnya menggunakan JSON dan XML.

## Instalasi
1. Buat database pada MySQL
2. Edit file Konfigurasi.php dan isi beberapa variabel tentang informasi database dan url
```php
// lokasi web service pada server
// contoh : http://localhost/webservice (tanpa diakhiri "/" )
public static $LOKASIWS = ""; 
// nama database
// contoh : db_buku
public static $NAMA_DB = "";
// url hosting
// contoh : localhost
public static $HOST = "";    

// username database
// contoh : root
public static $USER = "";
// password database
public static $PASSWORD = "";
```
3. Host web service pada layanan webhosting

## Penggunaan
### sintaks API read
```?perintah=operasi,objek,fieldkriteria:valuekriteria```
### sintaks API read all
```?perintah=operasi,objek```
### sintaks API insert
```?perintah=operasi,objek,field1:val1,field2:val2...```
### sintaks API update
```?perintah=operasi,objek,fieldKriteria:valKriteria,field:valbaru```
### sintaks API delete
```?perintah=operasi,objek,fieldKriteria:valKriteria```
### sintaks API delete all
```?perintah=operasi,objek```
### contoh read
```?perintah=read,buku,judul:Android Cookbook```
### contoh read all
```?perintah=read,buku```
### contoh insert
```?perintah=insert,buku,judul:A,edisi:B,penulis:C```
### contoh update
```?perintah=update,buku,judul;Android Cookbook,judul:B```
### contoh delete
```?perintah=delete,buku,judul:A```
### contoh delete all
```?perintah=delete,buku```

#### Referensi
[Mengenal Web Service](https://www.codepolitan.com/mengenal-restful-web-services "Codepolitan")
