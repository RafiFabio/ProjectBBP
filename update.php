<?php
require 'config.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

$query = "SELECT * FROM antrian WHERE id = $id";
$result = $mysqli->query($query);

$dat = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['urgensi']) && isset($_POST['id'])) {
        $urgensi = htmlspecialchars($_POST['urgensi']);
        $id = (int)$_POST['id'];

        $updateQuery = "UPDATE antrian SET tingkat = '$urgensi' WHERE id = $id";
        $mysqli->query($updateQuery);
    }

    if (isset($_POST['status']) && isset($_POST['id'])) {
        $status = htmlspecialchars($_POST['status']);
        $id = (int)$_POST['id'];

        $updateQuery = "UPDATE antrian SET penyelesaian = '$status' WHERE id = $id";
        $mysqli->query($updateQuery);
    }

    $result = $mysqli->query("SELECT * FROM antrian WHERE id = $id");
    $dat = $result->fetch_assoc();
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
<form method="POST" action="admin.php">
    <input type="hidden" name="id" value="<?= $dat['id']; ?>"> <!-- Include hidden field for ID -->
    <td><?= htmlspecialchars($dat['solusi']); ?></td>
    <textarea name="solusi" id="solusi" rows="5" placeholder="Solusi..." required></textarea>
    <button type="submit">Kirim Solusi</button>
</form>

<?php
// Check if form is submitted and required data is present
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['solusi']) && isset($_POST['id'])) {
    $solusi = htmlspecialchars($_POST['solusi']);
    $id = (int)$_POST['id']; // Cast to integer to avoid SQL injection

    // Prepare and execute the update query with prepared statements
    if ($stmt = $mysqli->prepare("UPDATE antrian SET solusi = ? WHERE id = ?")) {
        $stmt->bind_param("si", $solusi, $id); // "si" means string and integer types
        $stmt->execute();
        $stmt->close();

        // Display the solution after submitting
        echo "<div><strong>Solusi Anda:</strong> <p>" . nl2br($solusi) . "</p></div>";
    } else {
        echo "Error preparing the query.";
    }
}
       ?>       

        <?php else: ?>
            <p>Record tidak ditemukan.</p>
        <?php endif; ?>

    </div>
</body>
</html>
