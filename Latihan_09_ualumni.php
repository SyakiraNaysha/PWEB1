<?php
include 'Latihan_09_config.php'; // Memasukkan file konfigurasi untuk koneksi database

// Memeriksa apakah parameter ID ada dalam URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengamankan input ID

    // Mengambil data dari database
    $sql = "SELECT * FROM alumni WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
        exit(); // Keluar jika data tidak ditemukan
    }
}

// Menangani pembaruan data ketika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tahun_lulus = $_POST['tahun_lulus'];
    $jurusan = $_POST['jurusan'];

    // Mengelola pembaruan foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/"; // Tentukan direktori untuk menyimpan foto
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Memeriksa apakah file benar-benar gambar
        if (getimagesize($_FILES["foto"]["tmp_name"]) === false) {
            echo "<div class='alert alert-danger'>File bukan gambar.</div>";
            $uploadOk = 0;
        }

        // Memeriksa ukuran file (5MB maks)
        if ($_FILES["foto"]["size"] > 5000000) {
            echo "<div class='alert alert-danger'>Ukuran file terlalu besar.</div>";
            $uploadOk = 0;
        }

        // Mengizinkan format file tertentu
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<div class='alert alert-danger'>Hanya file JPG, JPEG, PNG & GIF yang diizinkan.</div>";
            $uploadOk = 0;
        }

        // Cek apakah uploadOk sudah di-set menjadi 0 oleh error
        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>File tidak berhasil diunggah.</div>";
        } else {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // Jika file berhasil diunggah, tambahkan data ke database
                $sql = "UPDATE alumni SET nama=?, tahun_lulus=?, jurusan=?, foto=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $nama, $tahun_lulus, $jurusan, $target_file, $id);

                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Data berhasil diperbarui.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengunggah file.</div>";
            }
        }
    } else {
        // Jika tidak ada foto yang diunggah, hanya memperbarui data tanpa foto
        $sql = "UPDATE alumni SET nama=?, tahun_lulus=?, jurusan=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama, $tahun_lulus, $jurusan, $id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Data berhasil diperbarui.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }

    // Menutup statement dan koneksi
    $stmt->close();
}

$conn->close(); // Menutup koneksi
?>

<div class="container mt-5">
    <h2 class="mb-4">Update Data Alumni</h2>

    <!-- Form update data -->
    <?php if (isset($row)) { ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" value="<?php echo htmlspecialchars($row['tahun_lulus']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo htmlspecialchars($row['jurusan']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto (biarkan kosong jika tidak diubah)</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>

            <button type="submit" class="btn btn-primary">Perbarui Data</button>
        </form>
    <?php } ?>
</div>
