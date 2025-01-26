<?php
$servername = "localhost"; // Alamat server database
$username = "root"; // Username untuk koneksi database
$password = ""; // Sesuaikan password untuk user root (default di Laragon adalah kosong)
$dbname = "db_alumni"; // Nama database yang akan digunakan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil!";
}

// Pastikan untuk menutup koneksi di akhir skrip jika tidak lagi digunakan
// $conn->close();
?>
