<?php
// ==================== KONEKSI DATABASE ====================
$conn = mysqli_connect("localhost", "root", "", "katalog_tas");
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// ==================== TAMBAH PRODUK ====================
if (isset($_POST['simpan'])) {
  $nama  = mysqli_real_escape_string($conn, $_POST['nama_produk']);
  $bahan = mysqli_real_escape_string($conn, $_POST['bahan']);
  $warna = mysqli_real_escape_string($conn, $_POST['warna']);
  $harga = $_POST['harga'];
  $stok  = $_POST['stok'];

  mysqli_query($conn, "INSERT INTO produk (nama_produk, bahan, warna, harga, stok)
                       VALUES ('$nama','$bahan','$warna','$harga','$stok')");

  echo "<script>
    alert('✅ Produk berhasil ditambahkan');
    window.location='?page=produk';
  </script>";
}

// ==================== HAPUS PRODUK ====================
if (isset($_GET['hapus'])) {
  $id = (int)$_GET['hapus'];
  mysqli_query($conn, "DELETE FROM produk WHERE p_id='$id'");
  echo "<script>
    alert('🗑️ Produk berhasil dihapus');
    window.location='?page=produk';
  </script>";
  exit;
}

// ==================== UPDATE PRODUK ====================
if (isset($_POST['update'])) {
  $id    = $_POST['p_id'];
  $nama  = mysqli_real_escape_string($conn, $_POST['nama_produk']);
  $bahan = mysqli_real_escape_string($conn, $_POST['bahan']);
  $warna = mysqli_real_escape_string($conn, $_POST['warna']);
  $harga = $_POST['harga'];
  $stok  = $_POST['stok'];

  mysqli_query($conn, "UPDATE produk SET
      nama_produk='$nama',
      bahan='$bahan',
      warna='$warna',
      harga='$harga',
      stok='$stok'
    WHERE p_id='$id'");

  echo "<script>
    alert('✅ Produk berhasil diupdate');
    window.location='?page=produk';
  </script>";
}

// ==================== DATA PRODUK ====================
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY p_id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<h3 class="text-center mb-4">Dashboard Manajemen Produk</h3>

<!-- FORM TAMBAH -->
<div class="card mb-4">
<div class="card-header bg-primary text-white">Tambah Produk</div>
<div class="card-body">
<form method="POST">
<div class="row g-3">
  <div class="col-md-6">
    <label>Nama Produk</label>
    <input type="text" name="nama_produk" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label>Bahan</label>
    <input type="text" name="bahan" class="form-control" required>
  </div>
  <div class="col-md-4">
    <label>Warna</label>
    <input type="text" name="warna" class="form-control" required>
  </div>
  <div class="col-md-4">
    <label>Harga</label>
    <input type="number" step="0.01" name="harga" class="form-control" required>
  </div>
  <div class="col-md-4">
    <label>Stok</label>
    <input type="number" name="stok" class="form-control" required>
  </div>
</div>
<div class="mt-3 text-end">
  <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
</div>
</form>
</div>
</div>

<!-- TABEL PRODUK -->
<div class="card">
<div class="card-header bg-dark text-white">Data Produk</div>
<div class="card-body">
<table class="table table-bordered table-hover">
<thead class="table-primary text-center">
<tr>
  <th>ID</th>
  <th>Nama</th>
  <th>Bahan</th>
  <th>Warna</th>
  <th>Harga</th>
  <th>Stok</th>
  <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($result) > 0): ?>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
  <td><?= $row['p_id'] ?></td>
  <td><?= htmlspecialchars($row['nama_produk']) ?></td>
  <td><?= htmlspecialchars($row['bahan']) ?></td>
  <td><?= htmlspecialchars($row['warna']) ?></td>
  <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
  <td><?= $row['stok'] ?></td>
  <td class="text-center">
    <a href="?page=produk&edit=<?= $row['p_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="?page=produk&hapus=<?= $row['p_id'] ?>" class="btn btn-danger btn-sm"
       onclick="return confirm('Hapus produk ini?')">Hapus</a>
  </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="7" class="text-center">Data masih kosong</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>

<?php
// ==================== FORM EDIT ====================
if (isset($_GET['edit'])):
$id = (int)$_GET['edit'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE p_id='$id'"));
?>
<div class="modal show" style="display:block; background:rgba(0,0,0,.5)">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header bg-warning">
<h5>Edit Produk</h5>
<a href="?page=produk" class="btn-close"></a>
</div>
<div class="modal-body">
<input type="hidden" name="p_id" value="<?= $data['p_id'] ?>">
<input type="text" name="nama_produk" class="form-control mb-2" value="<?= $data['nama_produk'] ?>" required>
<input type="text" name="bahan" class="form-control mb-2" value="<?= $data['bahan'] ?>" required>
<input type="text" name="warna" class="form-control mb-2" value="<?= $data['warna'] ?>" required>
<input type="number" name="harga" class="form-control mb-2" value="<?= $data['harga'] ?>" required>
<input type="number" name="stok" class="form-control mb-2" value="<?= $data['stok'] ?>" required>
</div>
<div class="modal-footer">
<a href="?page=produk" class="btn btn-secondary">Batal</a>
<button type="submit" name="update" class="btn btn-warning">Update</button>
</div>
</form>
</div>
</div>
</div>
<?php endif; ?>

</body>
</html>
