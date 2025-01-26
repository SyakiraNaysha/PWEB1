<?php
include 'Latihan_09_config.php'; // Memasukkan file konfigurasi untuk koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengamankan input
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $pesan = trim($_POST['pesan']);

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Format email tidak valid.</div>";
        exit();
    }

    // Menyiapkan query untuk memasukkan data menggunakan prepared statements
    $stmt = $conn->prepare("INSERT INTO HalamanBukuTamu (nama, email, pesan) VALUES (?, ?, ?)");
    
    // Mengikat parameter
    $stmt->bind_param("sss", $nama, $email, $pesan); // "sss" menunjukkan bahwa semua parameter adalah string

    // Menjalankan query dan memeriksa hasilnya
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Pesan berhasil dikirim.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    // Menutup statement
    $stmt->close();

    // Redirect ke halaman Buku Tamu setelah pengiriman
    header("Location: HalamanBukuTamu.php");
    exit();
}
?>
