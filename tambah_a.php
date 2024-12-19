<?php
require 'config.php';  // Menghubungkan ke database atau konfigurasi lainnya

// Mendapatkan data dari enum untuk kategori, lokasi, urgensi
$enumKategori = enum('kategori');
$enumLokasi = enum('lokasi');
$enumUrgensi = enum('tingkat');
$enumPenyelesaian = enum('penyelesaian');

// Proses form setelah tombol Kirim ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan dari form
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'];
    $tingkat = $_POST['tingkat'];
    $deskripsi = $_POST['deskripsi'];

    // Masukkan data ke dalam tabel antrian
    $query = "INSERT INTO antrian (kategori, lokasi, tingkat, deskripsi) VALUES ('$kategori', '$lokasi', '$tingkat', '$deskripsi')";
    if ($mysqli->query($query) === TRUE) {
        // Kirim email ke admin
        $to = "admin@example.com";
        $subject = "Resiko Baru: $kategori - $tingkat";
        $message = "Kategori: $kategori\nLokasi: $lokasi\nUrgensi: $tingkat\nDeskripsi: $deskripsi";
        $headers = "From: noreply@example.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "Data berhasil dikirim dan email terkirim ke admin.";
        } else {
            echo "Gagal mengirim email ke admin.";
        }
    } else {
        echo "Terjadi kesalahan dalam menyimpan data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resiko Baru</title>
</head>
<body>
    <h1>Tambah Resiko Baru</h1>
    <form action="" method="POST">
        <div class="input-container">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" required>
                <?php foreach($enumKategori as $kategori): ?>
                    <option value="<?= $kategori ?>"><?= $kategori ?></option>
                <?php endforeach; ?>
            </select>

            <label for="lokasi">Lokasi</label>
            <select name="lokasi" id="lokasi" required>
                <?php foreach($enumLokasi as $lokasi): ?>
                    <option value="<?= $lokasi ?>"><?= $lokasi ?></option>
                <?php endforeach; ?>
            </select>

            <label for="tingkat">Urgensi</label>
            <select name="tingkat" id="tingkat" required>
                <?php foreach($enumUrgensi as $urgensi): ?>
                    <option value="<?= $urgensi ?>"><?= $urgensi ?></option>
                <?php endforeach; ?>
            </select>

            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" required></textarea>
        </div>
        <br>
        <button type="submit">Kirim</button>
    </form>
    <br>
    <a href="admin.php">Kembali</a>
</body>
</html>