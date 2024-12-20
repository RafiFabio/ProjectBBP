<?php
require 'config.php';

class Antrian {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getAntrianById($id) {
        $query = "SELECT * FROM antrian WHERE id = ?";
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }

    public function updateUrgensi($id, $urgensi) {
        $updateQuery = "UPDATE antrian SET tingkat = ? WHERE id = ?";
        if ($stmt = $this->mysqli->prepare($updateQuery)) {
            $stmt->bind_param("si", $urgensi, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function updateStatus($id, $status) {
        $updateQuery = "UPDATE antrian SET penyelesaian = ? WHERE id = ?";
        if ($stmt = $this->mysqli->prepare($updateQuery)) {
            $stmt->bind_param("si", $status, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function updateSolusi($id, $solusi) {
        $updateQuery = "UPDATE antrian SET solusi = ? WHERE id = ?";
        if ($stmt = $this->mysqli->prepare($updateQuery)) {
            $stmt->bind_param("si", $solusi, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$antrian = new Antrian($mysqli);

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

$dat = $antrian->getAntrianById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['urgensi']) && isset($_POST['id'])) {
        $urgensi = htmlspecialchars($_POST['urgensi']);
        $id = (int)$_POST['id'];
        $antrian->updateUrgensi($id, $urgensi);
    }

    if (isset($_POST['status']) && isset($_POST['id'])) {
        $status = htmlspecialchars($_POST['status']);
        $id = (int)$_POST['id'];
        $antrian->updateStatus($id, $status);
    }

    if (isset($_POST['solusi']) && isset($_POST['id'])) {
        $solusi = htmlspecialchars($_POST['solusi']);
        $id = (int)$_POST['id'];
        $antrian->updateSolusi($id, $solusi);

        header("Location: admin.php");
        exit;
    }

    $dat = $antrian->getAntrianById($id);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotak Solusi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #00ffff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update</h2>

        <?php if ($dat): ?>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Urgensi</th>
                    <th>Deskripsi</th>
                    <th>Status Penyelesaian</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($dat['kategori']); ?></td>
                    <td><?= htmlspecialchars($dat['lokasi']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?= $id; ?>" />
                            <select name="urgensi" onchange="this.form.submit()">
                                <option value="Berat" <?= $dat['tingkat'] == 'Berat' ? 'selected' : ''; ?>>Berat</option>
                                <option value="Sedang" <?= $dat['tingkat'] == 'Sedang' ? 'selected' : ''; ?>>Sedang</option>
                                <option value="Ringan" <?= $dat['tingkat'] == 'Ringan' ? 'selected' : ''; ?>>Ringan</option>
                            </select>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($dat['deskripsi']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?= $id; ?>" />
                            <select name="status" onchange="this.form.submit()">
                                <option value="Selesai" <?= $dat['penyelesaian'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                <option value="Proses" <?= $dat['penyelesaian'] == 'Proses' ? 'selected' : ''; ?>>Proses</option>
                                <option value="Menunggu" <?= $dat['penyelesaian'] == 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                            </select>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
        <h3>Solusi</h3>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $dat['id']; ?>">
            <textarea name="solusi" id="solusi" rows="5" placeholder="Solusi..." required><?= htmlspecialchars($dat['solusi']); ?></textarea>
            <br><br>
            <button type="submit">Kirim Solusi</button>
        </form>

        <?php else: ?>
            <p>Record tidak ditemukan.</p>
        <?php endif; ?>

    </div>
</body>
</html>