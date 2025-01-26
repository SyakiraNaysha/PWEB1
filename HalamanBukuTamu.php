<?php
include 'Latihan_09_config.php'; // Memasukkan file konfigurasi untuk koneksi database

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menyimpan data buku tamu ke dalam session jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];

    // Simpan data ke dalam session untuk penyimpanan nanti
    $_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;
    $_SESSION['pesan'] = $pesan;

    // Redirect ke SubmitHalBukuTamu.php untuk proses penyimpanan
    header("Location: SubmitHalBukuTamu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu</title>
</head>
<body>
    <h1>Buku Tamu</h1>
    <form action="SubmitHalBukuTamu.php" method="POST">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>

        <label for="pesan">Pesan:</label><br>
        <textarea id="pesan" name="pesan" required></textarea><br><br>

        <button type="submit">Kirim</button>
    </form>

    <!-- Daftar Pesan -->
    <h2>Daftar Pesan</h2>
    <ul>
        <?php
        
        // Query untuk ambil data dari buku tamu
        $sql = "SELECT nama, email, pesan FROM buku_tamu ORDER BY pesan DESC";
        
        try {
            // Eksekusi query dan simpan resultnya ke dalam variable result
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                
                // Looping untuk menampilkan tiap-tiap baris data dari result
                
                while ($row = $result->fetch_assoc()) {
                    
                    // Tampilkan isi kolom nama,email,pesan
                    
                    echo "<li><strong>{$row['nama']}</strong> (<span style='color:#007bff;'>{$row['email']}</span>): {$row['pesan']}</li>";
                }
                
            } else {
                
               // Tampilkan pesan jika tidak ada data
                
               echo "<li>Belum ada pesan.</li>";
           }
       }catch(Exception $ex){ 
           
          // Handle exception jika terjadi kesalahan
            
          echo '<pre>' .$ex -> getMessage(). '</pre>';

      }
      
      // Tutup connection
      
      $conn -> close ();
      
      ?>
