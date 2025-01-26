<?php
include 'Latihan_09_config.php'; 

// Tambah data lowongan kerja
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengamankan input dengan real_escape_string
    $judul_pekerjaan = $conn->real_escape_string(trim($_POST['judul_pekerjaan']));
    $nama_perusahaan = $conn->real_escape_string(trim($_POST['nama_perusahaan']));
    $deskripsi_pekerjaan = $conn->real_escape_string(trim($_POST['deskripsi_pekerjaan']));
    $lokasi = $conn->real_escape_string(trim($_POST['lokasi']));

    // Menyiapkan query untuk memasukkan data
    $sql = "INSERT INTO bursa_kerja (judul_pekerjaan, nama_perusahaan, deskripsi_pekerjaan, lokasi) 
            VALUES ('$judul_pekerjaan', '$nama_perusahaan', '$deskripsi_pekerjaan', '$lokasi')";

    // Menjalankan query dan memeriksa hasilnya
    if ($conn->query($sql) === TRUE) {
        $message = "Lowongan kerja berhasil ditambahkan!";
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
    <title>Bursa Kerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
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

        input, textarea, button {
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
        <h1>Bursa Kerja</h1>

        <?php if (isset($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="judul_pekerjaan">Judul Pekerjaan:</label>
            <input type="text" id="judul_pekerjaan" name="judul_pekerjaan" required>

            <label for="nama_perusahaan">Nama Perusahaan:</label>
            <input type="text" id="nama_perusahaan" name="nama_perusahaan" required>

            <label for="deskripsi_pekerjaan">Deskripsi Pekerjaan:</label>
            <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="4" required></textarea>

            <label for="lokasi">Lokasi:</label>
            <input type="text" id="lokasi" name="lokasi" required>

            <button type="submit">Tambah Lowongan</button>
        </form>

        <h2>Daftar Lowongan</h2>
        <ul>
            <?php
            // Query untuk mengambil data lowongan kerja
            $sql = "SELECT judul_pekerjaan, nama_perusahaan, lokasi, deskripsi_pekerjaan 
                    FROM bursa_kerja ORDER BY judul_pekerjaan ASC"; // Mengurutkan berdasarkan judul pekerjaan
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li><strong>{$row['judul_pekerjaan']}</strong> di <strong>{$row['nama_perusahaan']}</strong>: {$row['deskripsi_pekerjaan']} ({$row['lokasi']})</li>";
                }
            } else {
                echo "<li>Belum ada lowongan kerja.</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
