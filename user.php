<?php
require 'config.php';

$hasil = $mysqli->query("SELECT * FROM antrian WHERE status = 'approved'");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>
<body>
    <h1>Selamat Datang User!</h1>
    <h2>Resiko yang Telah Disetujui</h2>
    <table border="1">
        <tr>
            <th>Nomor</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Urgensi</th>
            <th>Deskripsi</th>
            <th>Solusi</th>
            <th>Status Penyelesaian</th>
        </tr>
        <?php $i = 1 ?>
        <?php while ($row = $hasil->fetch_assoc()): ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $row['kategori'] ?></td>
                <td><?= $row['lokasi'] ?></td>
                <td><?= $row['tingkat'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td><?= $row['solusi'] ?></td>
                <td><?= $row['penyelesaian'] ?></td>
                <?php $i++; ?>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
        <form method="POST" action="tambah_u.php" style="display:inline;">
            <button type="submit" name="tambah">Tambah resiko</button>
        </form>
    <br>
    <br>
        <button type="submit">Submit</button>
    </form>
    <br>
    <br>
    <a href="index.php">Logout</a>
</body>
</html>