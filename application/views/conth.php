<?php
//include kan koneksi ke database disini
include "config.php";

//jika form pencarian mengandung isi maka akan di proses
if ((isset($_POST['submit'])) AND ($_POST['search'] <> ""))
{
  //menerima dan membaca data yang di terima via form metode POST
  $search = $_POST['search'];
 
  //memilih table ke satu dari database mysql
  $sql1 = mysql_query("SELECT * FROM table1 WHERE detail LIKE '%$search%' ") or die(mysql_error());
 
  //membuat jumlah hasil pencarian pada table ke satu
  //dengan fungsi mysql_num_rows()
  $jumlah1 = mysql_num_rows($sql1);
 
  //jika hasil pada table ke satu lebih dari pada 0 maka akan di proses
  if ($jumlah1 > 0)
  {
   //menampilkan jumlah hasil pencarian pada table ke satu
   echo '<p>Ditemukan '.$jumlah1.' data yang sesuai pada table ke satu!</p>';
  
   //membuat pengulangan dengan fungsi while
   //untuk tampilan hasil table ke satu
   while ($hasil1 = mysql_fetch_array($sql1))
  {
   //menampilkan nomor urut
   $num++; echo $num.'. ';
  
   //menampilkan hasil pencarian pada table ke satu
   echo $hasil1[detail].'<br>';
  }
  }

  //jika data tidak di temukan pada table ke satu
  //maka akan dilanjutkan ke table yang ke dua
  else
  {
   //memilih table ke satu dari database mysql
   $sql2 = mysql_query("SELECT * FROM table2 WHERE detail LIKE '%$search%' ") or die(mysql_error());
  
   //membuat jumlah hasil pencarian pada table ke dua
   //dengan fungsi mysql_num_rows()
   $jumlah2 = mysql_num_rows($sql2);
  
   //jika hasil pada table ke dua lebih dari pada 0 maka akan di proses
   if ($jumlah2 > 0)
   {
   //menampilkan jumlah hasil pencarian pada table ke dua
    echo '<p>Ditemukan '.$jumlah2.' data yang sesuai pada table ke dua!</p>';
   
   //membuat pengulangan dengan fungsi while
   //untuk tampilan hasil table ke dua
    while ($hasil2 = mysql_fetch_array($sql2))
    {
    //menampilkan nomor urut
    $num2++; echo $num2.'. ';
   
    //menampilkan hasil pencarian pada table ke dua
    echo $hasil2[detail].'<br>';
    }
    }
 
  //jika data tidak di temukan pada table ke dua, maka akan dilanjutkan ke table yang ke tiga
  else
  {
  //memilih table ke tiga dari database mysql
  $sql3 = mysql_query("SELECT * FROM table3 WHERE detail LIKE '%$search%' ") or die(mysql_error());
 
  //membuat jumlah hasil pencarian pada table ke tiga
  //dengan fungsi mysql_num_rows()
  $jumlah3 = mysql_num_rows($sql3);
 
  //jika hasil pada table ke tiga lebih dari pada 0 maka akan di proses
  if ($jumlah3 > 0)
  {
   //menampilkan jumlah hasil pencarian pada table ke dua
   echo '<p>Ditemukan '.$jumlah3.' data yang sesuai pada table ke tiga!</p>';
  
   //membuat pengulangan dengan fungsi while
   //untuk tampilan hasil table ke tiga
   while ($hasil3 = mysql_fetch_array($sql3))
  {
   //menampilkan nomor urut
   $num3++; echo $num3.'. ';
  
   //menampilkan hasil pencarian pada table ke tiga
   echo $hasil3[detail].'<br>';
  }
  }
  
  //jika semua data tidak di temukan pada ke 3 table
  else
  {
  echo "Data yang kamu cari tidak ada pada ke tiga table database kami!";
  }
 
  }
  }
  }
 
  //jika form pencarian kosong
  else
  {
  echo 'Silahkan masukkan kata kunci yang kamu cari!';
  }
?>