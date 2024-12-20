<?php
require 'config.php';

class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllEntries() {
        $query = "SELECT * FROM antrian";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteEntry($id) {
        $query = "DELETE FROM antrian WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE antrian SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();
    }
}

$admin = new Admin($mysqli);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    if (isset($_POST['delete'])) {
        $admin->deleteEntry($id);
    } elseif (isset($_POST['approve'])) {
        $admin->updateStatus($id, 'approved');
    } elseif (isset($_POST['pending'])) {
        $admin->updateStatus($id, 'pending');
    }
}

$entries = $admin->getAllEntries();
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
            <th>Nomor</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Urgensi</th>
            <th>Deskripsi</th>
            <th>Solusi</th>
            <th>Status Penyelesaian</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= htmlspecialchars($entry['kategori']); ?></td>
                <td><?= htmlspecialchars($entry['lokasi']); ?></td>
                <td><?= htmlspecialchars($entry['tingkat']); ?></td>
                <td><?= htmlspecialchars($entry['deskripsi']); ?></td>
                <td><?= htmlspecialchars($entry['solusi']); ?></td>
                <td><?= htmlspecialchars($entry['penyelesaian']); ?></td>
                <td><?= htmlspecialchars($entry['status']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $entry['id']; ?>">
                        <?php if ($entry['status'] === 'pending'): ?>
                            <button type="submit" name="approve">Approve</button>
                        <?php elseif ($entry['status'] === 'approved'): ?>
                            <button type="submit" name="pending">Pending</button>
                        <?php endif; ?>
                    </form>

                    <form method="POST" action="update.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $entry['id']; ?>">
                        <button type="submit" name="update">Update</button>
                    </form>

                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $entry['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <form method="POST" action="tambah_a.php" style="display:inline;">
        <button type="submit" name="tambah">Tambah Resiko</button>
    </form>
    <br><br>
    <a href="index.php">Logout</a>
</body>
</html>
