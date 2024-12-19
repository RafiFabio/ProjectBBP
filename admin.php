<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $mysqli->query("DELETE FROM antrian WHERE id = $id");
    } elseif (isset($_POST['approve'])) {
        $id = (int)$_POST['id'];
        $mysqli->query("UPDATE antrian SET status = 'approved' WHERE id = $id");
    } elseif (isset($_POST['pending'])) {
        $id = (int)$_POST['id'];
        $mysqli->query("UPDATE antrian SET status = 'pending' WHERE id = $id");
    }
}


$hasil = $mysqli -> query("SELECT * FROM antrian");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>Selamat Datang Admin</h1>

    <h2>All Entries</h2>
    <table border="1">
        <tr>
        <tr>
            <th>Nomor</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Urgensi</th>
            <th>Deskripsi</th>
            <th>Solusi</th>
            <th>Status Penyelesaian</th>
            <th>Status</th>
        <?php $i = 1?>
        <?php foreach($hasil as $dat):?>
                <tr>
                <td><?= $i; ?></td>
                <td><?= $dat['kategori'] ?></td>
                <td><?= $dat['lokasi'] ?></td>
                <td><?= $dat['tingkat'] ?></td>
                <td><?= $dat['deskripsi'] ?></td>
                <td><?= $dat['solusi']; ?></td>
                <td><?= $dat['penyelesaian'] ?></td>
                <td><?= $dat['status'] ?></td>
                <?php $i++;?>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $dat['id'] ?>">
                        <?php if ($dat['status'] === 'pending'): ?>
                            <button type="submit" name="approve">Approve</button>
                        <?php elseif ($dat['status'] === 'approved'): ?>
                            <button type="submit" name="pending">Pending</button>
                        <?php endif; ?>
                    </form>

                    <form method="POST" action="update.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $dat['id'] ?>">
                        <button type="submit" name="update">Update</button>
                    </form>
                    
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $dat['id'] ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
                </tr>
        <?php endforeach; ?>
    </table>
                 <br>
                    <form method="POST" action="tambah_a.php" style="display:inline;">
                        <button type="submit" name="tambah">Tambah resiko</button>
                    </form>
                <br>
            <br>
    <a href="index.php">Logout</a>
</body>
</html>