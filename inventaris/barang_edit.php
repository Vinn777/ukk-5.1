<?php
require_once 'koneksi.php';
require_once 'helpers.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if (!$data = $res->fetch_assoc()) {
    die("Barang tidak ditemukan.");
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $jumlah = (int)$_POST['jumlah'];
    $lokasi = trim($_POST['lokasi']);
    $kode = trim($_POST['kode']);

    // adjust 'tersedia' bila total jumlah berubah
    $selisih = $jumlah - $data['jumlah'];
    $tersedia = $data['tersedia'] + $selisih;
    if ($tersedia < 0) $tersedia = 0;

    $stmt = $mysqli->prepare("UPDATE barang SET nama=?, deskripsi=?, jumlah=?, tersedia=?, lokasi=?, kode=? WHERE id=?");
    $stmt->bind_param('ssiissi', $nama, $deskripsi, $jumlah, $tersedia, $lokasi, $kode, $id);
    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Gagal update: " . $mysqli->error;
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Barang</title>
</head>
<style>
/* ===== WARNA TEMA MERCEDES F1 ===== */
:root {
    --hitam: #0a0a0a;
    --abu: #c0c0c0;
    --abu-tua: #1a1a1a;
    --turquoise: #00d2be;
    --putih: #ffffff;
}

/* ===== BODY ===== */
body {
    background-color: var(--hitam);
    color: var(--putih);
    font-family: 'Roboto', sans-serif;
    padding: 30px;
}

/* ===== JUDUL ===== */
h2, h1 {
    color: var(--turquoise);
    font-size: 32px;
    margin-bottom: 20px;
    border-left: 6px solid var(--turquoise);
    padding-left: 12px;
    text-transform: uppercase;
}

/* ===== FORM WRAPPER ===== */
form {
    background-color: var(--abu-tua);
    padding: 25px;
    border-radius: 10px;
    width: 350px;
    border: 2px solid var(--turquoise);
    box-shadow: 0 0 15px rgba(0, 210, 190, 0.3);
}

/* ===== LABEL ===== */
label {
    font-weight: bold;
    color: var(--turquoise);
    margin-top: 12px;
    display: block;
    text-transform: uppercase;
}

/* ===== INPUT & TEXTAREA ===== */
input, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 15px;
    background-color: #111;
    border: 2px solid #333;
    border-radius: 6px;
    color: var(--abu);
    font-size: 14px;
}

input:focus,
textarea:focus {
    border-color: var(--turquoise);
    outline: none;
    box-shadow: 0 0 10px rgba(0, 210, 190, 0.4);
}

/* ===== BUTTON ===== */
button, input[type="submit"] {
    background-color: var(--turquoise);
    color: var(--hitam);
    border: none;
    padding: 12px 18px;
    border-radius: 6px;
    font-weight: bold;
    width: 100%;
    cursor: pointer;
    font-size: 16px;
    text-transform: uppercase;
    transition: 0.3s ease;
}

button:hover,
input[type="submit"]:hover {
    background-color: #00b8a6;
    transform: scale(1.04);
}

/* ===== LINK KEMBALI ===== */
a {
    color: var(--turquoise);
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    margin-top: 15px;
}

a:hover {
    color: var(--abu);
}
</style>
<body>
    <div class="container">
        <h2>Edit Barang</h2>
        <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post">
            <label>Nama</label><br>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required><br>
            <label>Kode</label><br>
            <input type="text" name="kode" value="<?= htmlspecialchars($data['kode']) ?>"><br>
            <label>Deskripsi</label><br>
            <textarea name="deskripsi"><?= htmlspecialchars($data['deskripsi']) ?></textarea><br>
            <label>Jumlah (total)</label><br>
            <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" min="0" required><br>
            <label>Lokasi</label><br>
            <input type="text" name="lokasi" value="<?= htmlspecialchars($data['lokasi']) ?>"><br><br>
            <button type="submit">Update</button>
        </form>
        <p><a href="index.php">Kembali</a></p>
    </div>
</body>

</html>