<h3>DAFTAR ALUMNI</h3>
<hr>
<a href="?menu=calumni" class="btn btn-primary mb-3">Tambah</a>

<?php
include 'Latihan_09_config.php';

$sql = "SELECT * FROM alumni";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tahun Lulus</th>
                    <th>Jurusan</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["nama"]) . "</td>
                <td>" . htmlspecialchars($row["tahun_lulus"]) . "</td>
                <td>" . htmlspecialchars($row["jurusan"]) . "</td>
                <td><img src='" . htmlspecialchars($row["foto"]) . "' width='50' alt='Foto Alumni'></td>
                <td>
                    <a class='btn btn-warning' href='Latihan_09_index.php?menu=ualumni&id=" . urlencode($row["id"]) . "'>Edit</a> |
                    <a class='btn btn-danger' href='Latihan_09_dalumni.php?id=" . urlencode($row["id"]) . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-warning'>Tidak ada data.</div>";
}

$conn->close();
?>
