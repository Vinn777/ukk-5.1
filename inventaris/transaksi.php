<?php
require_once 'koneksi.php';
require_once 'helpers.php';
require_login();

$sql = "SELECT t.*, b.nama AS nama_barang FROM transaksi t JOIN barang b ON t.barang_id = b.id ORDER BY t.tanggal DESC";
$res = $mysqli->query($sql);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transaksi</title>
</head>
<style>
/* ===== WARNA TEMA MERCEDES F1 ===== */
:root {
    --hitam: #0a0a0a;
    --abu: #c0c0c0;
    --turquoise: #00d2be;
    --putih: #ffffff;
}

/* ===== BODY ===== */
body {
    background-color: var(--hitam);
    color: var(--putih);
    font-family: 'Roboto', sans-serif;
    padding: 20px;
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

/* ===== LINK KEMBALI ===== */
a {
    color: var(--turquoise);
    text-decoration: none;
    font-weight: bold;
}
a:hover {
    color: var(--abu);
}

/* ===== TABEL ===== */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #111;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid var(--turquoise);
}

/* HEADER TABEL */
th {
    background-color: var(--turquoise);
    color: var(--hitam);
    padding: 12px;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 14px;
}

/* ISI TABEL */
td {
    padding: 12px;
    border-bottom: 1px solid #222;
    color: var(--abu);
}

/* HOVER ROW */
tr:hover td {
    background-color: #1a1a1a;
    color: var(--putih);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 600px) {
    table, thead, tbody, tr, th, td {
        display: block;
    }
    tr { margin-bottom: 15px; }
}
</style>
<body>
    <div class="container">
        <h2>Daftar Transaksi</h2>
        <p><a href="index.php">Kembali</a></p>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr>

                <th>Tanggal</th>
                <th>Barang</th>
                <th>Peminjam</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>

                    <td><?= $row['tanggal'] ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['peminjam']) ?></td>
                    <td><?= $row['jenis'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= htmlspecialchars($row['catatan']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>