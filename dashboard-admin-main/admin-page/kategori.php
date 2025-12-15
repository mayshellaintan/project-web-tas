<?php
// ==================== KONEKSI DATABASE ====================
$conn = mysqli_connect("localhost", "root", "", "katalog_tas");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ==================== TAMBAH KATEGORI ====================
if (isset($_POST['simpan'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
  $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);

  mysqli_query($conn, "INSERT INTO kategori (nama_kategori, deskripsi)
                       VALUES ('$nama','$desk')");

  echo "<script>
    alert('✅ Kategori berhasil ditambahkan');
    window.location='?page=kategori';
  </script>";
}

// ==================== HAPUS KATEGORI ====================
if (isset($_GET['hapus'])) {
  $id = (int)$_GET['hapus'];
  mysqli_query($conn, "DELETE FROM kategori WHERE k_id='$id'");

  echo "<script>
    alert('🗑️ Kategori berhasil dihapus');
    window.location='?page=kategori';
  </script>";
  exit;
}

// ==================== UPDATE KATEGORI ====================
if (isset($_POST['update'])) {
  $id   = $_POST['k_id'];
  $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
  $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);

  mysqli_query($conn, "UPDATE kategori SET
      nama_kategori='$nama',
      deskripsi='$desk'
    WHERE k_id='$id'");

  echo "<script>
    alert('✅ Kategori berhasil diperbarui');
    window.location='?page=kategori';
  </script>";
}

// ==================== DATA KATEGORI ====================
$result = mysqli_query($conn, "SELECT * FROM kategori ORDER BY k_id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Kategori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<h3 class="text-center mb-4">Manajemen Kategori</h3>

<!-- FORM TAMBAH -->
<div class="card mb-4">
<div class="card-header bg-primary text-white">Tambah Kategori</div>
<div class="card-body">
<form method="POST">
  <div class="mb-3">
    <label>Nama Kategori</label>
    <input type="text" name="nama_kategori" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
  </div>
  <div class="text-end">
    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
  </div>
</form>
</div>
</div>

<!-- TABEL KATEGORI -->
<div class="card">
<div class="card-header bg-dark text-white">Daftar Kategori</div>
<div class="card-body">
<table class="table table-bordered table-hover">
<thead class="table-primary text-center">
<tr>
  <th>ID</th>
  <th>Nama Kategori</th>
  <th>Deskripsi</th>
  <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($result) > 0): ?>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
  <td><?= $row['k_id'] ?></td>
  <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
  <td><?= htmlspecialchars($row['deskripsi']) ?></td>
  <td class="text-center">
    <a href="?page=kategori&edit=<?= $row['k_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="?page=kategori&hapus=<?= $row['k_id'] ?>" class="btn btn-danger btn-sm"
       onclick="return confirm('Hapus kategori ini?')">Hapus</a>
  </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="4" class="text-center">Belum ada kategori</td></tr>
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
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kategori WHERE k_id='$id'"));
?>
<div class="modal show" style="display:block; background:rgba(0,0,0,.5)">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST">
<div class="modal-header bg-warning">
<h5>Edit Kategori</h5>
<a href="?page=kategori" class="btn-close"></a>
</div>
<div class="modal-body">
<input type="hidden" name="k_id" value="<?= $data['k_id'] ?>">
<div class="mb-2">
  <label>Nama Kategori</label>
  <input type="text" name="nama_kategori" class="form-control"
         value="<?= $data['nama_kategori'] ?>" required>
</div>
<div class="mb-2">
  <label>Deskripsi</label>
  <textarea name="deskripsi" class="form-control" rows="3"><?= $data['deskripsi'] ?></textarea>
</div>
</div>
<div class="modal-footer">
<a href="?page=kategori" class="btn btn-secondary">Batal</a>
<button type="submit" name="update" class="btn btn-warning">Update</button>
</div>
</form>
</div>
</div>
</div>
<?php endif; ?>

</body>
</html>
