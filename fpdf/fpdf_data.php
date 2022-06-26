<?php
//koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbnm = "mhs3";

$conn = mysqli_connect($host, $user, $pass);
if ($conn) {
$open = mysqli_select_db($conn, $dbnm);
if (!$open) {
die ("Database tidak dapat dibuka karena " . mysqli_error($conn));
}
} else {
die ("Server MySQL tidak terhubung karena " . mysqli_error($conn));
}
//akhir koneksi

#ambil data di tabel dan masukkan ke array
$query = "SELECT * FROM data ORDER BY judul";
$sql = mysqli_query ($conn, $query);
$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
array_push($data, $row);
}

#setting judul laporan dan header tabel
$judul = "Data Buku Di Perpustakaan";
$header = array(
array("label"=>"JUMLAH", "length"=>20, "align"=>"L"),
array("label"=>"JUDUL", "length"=>75, "align"=>"L"),
array("label"=>"PENERBIT", "length"=>65, "align"=>"L"),
array("label"=>"TAHUN TERBIT", "length"=>30, "align"=>"L")
);

#sertakan library FPDF dan bentuk objek
require_once ("fpdf.php");
$pdf = new FPDF();
$pdf->AddPage();

#tampilkan judul laporan
$pdf->SetFont('Arial','B','16');
$pdf->Cell(0,20, $judul, '0', 1, 'C');

#buat header tabel
$pdf->SetFont('Arial','','10');
$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128,0,0);
foreach ($header as $kolom) {
$pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', $kolom['align'], true);
}
$pdf->Ln();

#tampilkan data tabelnya
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill=false;
foreach ($data as $baris) {
$i = 0;
foreach ($baris as $cell) {
$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $kolom['align'], $fill);
$i++;
}
$fill = !$fill;
$pdf->Ln();
}

#output file PDF
$pdf->Output();
?>