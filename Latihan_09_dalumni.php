<?php

include 'Latihan_09_config.php'; // Memasukkan file konfigurasi untuk koneksi database

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengamankan input ID

    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM alumni WHERE id = ?"; // Menggunakan prepared statement untuk keamanan

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter

    if ($stmt->execute()) {
        echo "Data berhasil dihapus";
        header("Location: Latihan_09_index.php?menu=alumni"); // Mengarahkan ulang setelah penghapusan
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close(); // Menutup statement
}

$conn->close(); // Menutup koneksi
?>
