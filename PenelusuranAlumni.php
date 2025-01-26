<?php 
include 'Latihan_09_config.php'; // Pastikan file konfigurasi ada dan koneksi berhasil

// Tambah data alumni
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($conn)) {
    $nama = $conn->real_escape_string(trim($_POST['nama']));
    $tahun_lulus = $conn->real_escape_string(trim($_POST['tahun_lulus']));
    $pekerjaan_saat_ini = $conn->real_escape_string(trim($_POST['pekerjaan_saat_ini']));
    $lokasi = $conn->real_escape_string(trim($_POST['lokasi']));

    $sql = "INSERT INTO penelusuran_alumni (nama, tahun_lulus, pekerjaan_saat_ini, lokasi) 
            VALUES ('$nama', '$tahun_lulus', '$pekerjaan_saat_ini', '$lokasi')";

    if ($conn->query($sql) === TRUE) {
        $message = "Data alumni berhasil ditambahkan!";
        $message_type = "success";
    } else {
        $message = "Kesalahan: " . $conn->error;
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penelusuran Alumni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        li strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Penelusuran Alumni</h1>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form untuk menambah alumni -->
        <h2>Tambah Alumni</h2>
        <form action="" method="POST">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="tahun_lulus">Tahun Lulus:</label>
            <input type="number" id="tahun_lulus" name="tahun_lulus" required>

            <label for="pekerjaan_saat_ini">Pekerjaan Saat Ini:</label>
            <input type="text" id="pekerjaan_saat_ini" name="pekerjaan_saat_ini">

            <label for="lokasi">Lokasi:</label>
            <input type="text" id="lokasi" name="lokasi" required>

            <button type="submit">Tambah Alumni</button>
        </form>

        <!-- Form untuk mencari alumni -->
        <h2>Cari Alumni</h2>
        <form action="" method="GET">
            <label for="cari">Nama atau Lokasi:</label>
            <input type="text" id="cari" name="cari">
            <button type="submit">Cari</button>
        </form>

        <!-- Hasil pencarian -->
        <h2>Hasil Pencarian</h2>
        <ul>
            <?php
            if (isset($_GET['cari'])) {
                $cari = $conn->real_escape_string(trim($_GET['cari']));
                $sql = "SELECT nama, tahun_lulus, pekerjaan_saat_ini, lokasi 
                        FROM penelusuran_alumni 
                        WHERE nama LIKE '%$cari%' OR lokasi LIKE '%$cari%' 
                        ORDER BY tahun_lulus DESC";
            } else {
                $sql = "SELECT nama, tahun_lulus, pekerjaan_saat_ini, lokasi 
                        FROM penelusuran_alumni 
                        ORDER BY tahun_lulus DESC";
            }

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li><strong>{$row['nama']}</strong> (Lulus: {$row['tahun_lulus']}) - {$row['pekerjaan_saat_ini']} di {$row['lokasi']}</li>";
                }
            } else {
                echo "<li>Belum ada data alumni.</li>";
            }

            // Menutup koneksi
            $conn->close();
            ?>
        </ul>
    </div>
</body>
</html>
