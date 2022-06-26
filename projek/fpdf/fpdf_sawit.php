<?php
//koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbnm = "projek";

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
$query = "SELECT * FROM fpdf_sawit ORDER BY nama";
$sql = mysqli_query ($conn, $query);
$data = array();
while ($row = mysqli_fetch_assoc($sql)) {
array_push($data, $row);
}

#setting judul laporan dan header tabel
$judul = "Data Penduduk Dusun Sawit Desa Bandungrejo";
$header = array(
array("label"=>"Id", "length"=>5, "align"=>"L"),
array("label"=>"Nama", "length"=>15, "align"=>"L"),
array("label"=>"NIK", "length"=>20, "align"=>"L"),
array("label"=>"Jenis Kelamin", "length"=>23, "align"=>"L"),
array("label"=>"Tempat Tanggal Lahir", "length"=>45, "align"=>"L"),
array("label"=>"Agama", "length"=>20, "align"=>"L"),
array("label"=>"Alamat", "length"=>64, "align"=>"L")
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