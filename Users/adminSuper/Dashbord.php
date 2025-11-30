<?php
include "config.php";

// Proses POST untuk tambah akun
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
    $email    = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp'] ?? '');
    $id_jabatan = (int)($_POST['id_jabatan'] ?? 0);

    $query = "INSERT INTO akun (nama, email, password, whatsapp, id_jabatan)
              VALUES ('$nama', '$email', '$password', '$whatsapp', $id_jabatan)";
    if (mysqli_query($conn, $query)) {
        header("Location: akun.php");
        exit;
    } else {
        die("Error saat menyimpan: " . mysqli_error($conn));
    }
}

// Ambil data akun
$akunData = mysqli_query($conn, "SELECT a.*, j.nama_jabatan FROM akun a LEFT JOIN jabatan j ON a.id_jabatan = j.id_jabatan ORDER BY id_akun DESC");

// Ambil daftar jabatan
$jabatanData = mysqli_query($conn, "SELECT * FROM jabatan ORDER BY nama_jabatan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Akun</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* Copy semua style sidebar & content dari kode Project Management-mu */
<?php include "style_sidebar_header.php"; ?>
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">❮</div>
    <div class="logo-box">
        <img src="LOGO SCBD WHITE[1].png" alt="Logo" class="logo-img">
    </div>
    <div class="menu">
        <a href="Dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        <a href="akun.php" class="active"><i class="fa-solid fa-users"></i> Manajemen Akun</a>
        <a href="Project.php"><i class="fa-solid fa-folder-tree"></i> Project Management</a>
    </div>
</div>

<!-- CONTENT -->
<div class="content" id="content">
    <!-- HEADER -->
    <div class="header">
        <h3>Manajemen Akun</h3>
        <div class="user-box" id="userBox">👋 Halo, Juhari
            <span class="arrow">▼</span>
            <div class="dropdown" id="userDropdown">
                <a href="change_password.php">🔑 Change Password</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>

    <!-- FILTER & BUTTON TAMBAH -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" placeholder="🔎 Search..." id="searchAkun" class="form-control w-50">
        <button class="btn btn-primary" onclick="openForm()">➕ Tambah Akun</button>
    </div>

    <!-- TABEL AKUN -->
    <div class="table-responsive table-container">
        <table id="akunTable">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>WhatsApp</th>
                <th>Jabatan</th>
                <th>Action</th>
            </tr>
            <?php $no = 1; while($row = mysqli_fetch_assoc($akunData)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['whatsapp']; ?></td>
                <td><?= $row['nama_jabatan'] ?? '-'; ?></td>
                <td><button class="btn-action">Detail</button></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<!-- FORM POPUP TAMBAH AKUN -->
<div id="formPopup" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; 
background: rgba(0,0,0,0.45); backdrop-filter: blur(2px); justify-content:center; align-items:center; z-index:999;">
    <div class="p-4 popup-box">
        <h4 class="mb-3">Tambah Akun</h4>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label>Nama</label>
                    <input class="form-control" type="text" name="nama" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>WhatsApp</label>
                    <input class="form-control" type="text" name="whatsapp">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Jabatan</label>
                    <select class="form-control" name="id_jabatan">
                        <option value="">-- Pilih Jabatan --</option>
                        <?php while($jab = mysqli_fetch_assoc($jabatanData)) { ?>
                        <option value="<?= $jab['id_jabatan']; ?>"><?= $jab['nama_jabatan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3" style="gap:10px;">
                <button type="button" class="btn btn-secondary" onclick="closeForm()">Cancel</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

<script>
// Sidebar toggle
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("content").classList.toggle("collapsed");
}

// User dropdown
document.getElementById("userBox").addEventListener("click", function() {
    let dropdown = document.getElementById("userDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
});
window.addEventListener("click", function(e) {
    let userBox = document.getElementById("userBox");
    let dropdown = document.getElementById("userDropdown");
    if (!userBox.contains(e.target)) dropdown.style.display = "none";
});

// Popup form
function openForm() { document.getElementById("formPopup").style.display = "flex"; }
function closeForm() { document.getElementById("formPopup").style.display = "none"; }

// Filter search
document.getElementById("searchAkun").addEventListener("keyup", function() {
    let q = this.value.toLowerCase();
    let rows = document.querySelectorAll("#akunTable tr:not(:first-child)");
    rows.forEach(row => row.style.display = row.innerText.toLowerCase().includes(q) ? "" : "none");
});
</script>

</body>
</html>
