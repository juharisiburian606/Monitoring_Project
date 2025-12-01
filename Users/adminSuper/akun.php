<?php
include "../Finance/config.php";

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
* {
        margin: 0; padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        display: flex;
        background: #f5f6fa;
    }

    /* SIDEBAR */
    .sidebar {
        width: 250px;
        background: rgb(0,0,0);
        color: white;
        height: 100vh;
        padding: 25px 20px;
        position: fixed;
    }

    .sidebar h2 {
        font-size: 20px;
        margin-bottom: 40px;
        font-weight: 700;
    }

    .sidebar.collapsed {
        width: 80px;
        transition: 0.3s;
    }

    .content.collapsed {
        margin-left: 80px;
        width: calc(100% - 80px);
    }


    /* --- LOGO NORMAL --- */
    .sidebar .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 20px;
        font-size: 20px;
        font-weight: bold;
        white-space: nowrap;
    }

    /* Logo gambar */
    .sidebar .logo img {
        width: 40px;
        transition: 0.3s;
    }

    /* --- MENU TEXT NORMAL --- */
    .sidebar .menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        font-size: 16px;
        white-space: nowrap;
        overflow: hidden;
        transition: 0.3s;
    }

    /* --- MODE COLLAPSED --- */
    .sidebar.collapsed {
        width: 80px;
    }

    /* Collapsed: sembunyikan teks menu */
    .sidebar.collapsed .menu a span {
        opacity: 0;
        width: 0;
        overflow: hidden;
        transition: 0.3s;
    }

        /* Ketika sidebar collapse, kecilkan logo */
    .sidebar.collapsed .logo-box img {
        opacity: 0;
        width: 0;
        height: 0;
        transition: 0.3s;
    }


    /* Sembunyikan teks logo (kalau ada) */
    .sidebar.collapsed .logo-box {
        margin-bottom: 10px;
    }

    .menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        font-size: 15px;
        border-radius: 10px;
        color: #cfd7e3;
        text-decoration: none;
        margin-bottom: 8px;
        transition: 0.2s;
    }

    .menu a.active,
    .menu a:hover {
        background: #162941;
        color: #fff;
    }

    /* CONTENT */
    .content {
        margin-left: 250px;
        padding: 25px;
        width: calc(100% - 250px);
    }

    /* HEADER */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .header h3 {
        font-size: 24px;
        font-weight: 600;
        color: #1a2b48;
    }

    .logo-box {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo-img {
        width: 200px;       /* Bisa kamu sesuaikan */
        height: auto;
    }


    .user-box {
    position: relative; /* penting agar dropdown muncul di bawah */
    font-size: 15px;
    font-weight: 600;
    background: #ffffff;
    padding: 10px 18px;
    border-radius: 10px;
    color: #1a2b48;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    cursor: pointer;
}

    /* Dropdown container */
    .user-box .dropdown {
        display: none;
        position: absolute;
        top: 100%; /* tepat di bawah user-box */
        right: 0;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        overflow: hidden;
        margin-top: 8px;
        min-width: 180px;
        z-index: 100;
    }

    /* Dropdown links */
    .user-box .dropdown a {
        display: block;
        padding: 10px 15px;
        color: #1a2b48;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s;
    }

    .user-box .dropdown a:hover {
        background: #f1f1f1;
    }

    /* TOGGLE BUTTON */
    .toggle-btn {
        position: absolute;
        top: 20px;
        right: -15px;
        width: 32px;
        height: 32px;
        background: #162941;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
        transition: 0.3s;
        border: 2px solid white;
        z-index: 99;
    }

    /* SEARCH FILTER */
    .filter-box {
        background: #fff;
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    


    .table-container {
    width: 100%;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 14px;
    text-align: left;
    font-size: 14px;
    border-bottom: 1px solid #ececec;
}

th {
    color: #6b7280;
    font-weight: 500;
}

td {
    color: #1f2b44;
    font-weight: 500;
}

/* BUTTON */
.btn-action {
    padding: 8px 14px;
    background: #1b2a41;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-action:hover {
    background: #163c72ff;
}

.popup-box {
    width: 95%;
    max-width: 450px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}


/* Tambahan biar lebih responsif */
@media (max-width: 500px) {
    .popup-box {
        width: 92%;
        max-width: 95%;
        padding: 18px;
    }

    #popupTitle {
        font-size: 18px;
    }

    .popup-box input,
    .popup-box select {
        font-size: 14px;
        padding: 9px;
    }
}



     /* ==== RESPONSIVE TABLET ==== */
    @media (max-width: 900px) {
    .sidebar {
        width: 200px;
    }
    .content {
        margin-left: 200px;
        width: calc(100% - 200px);
    }

    /* WRAPPER AGAR TABEL RESPONSIF */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* TABEL */
.table-responsive table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px; /* agar kolom tidak hancur di layar kecil */
}

.table-responsive th,
.table-responsive td {
    padding: 14px;
    text-align: left;
    font-size: 14px;
    border-bottom: 1px solid #ececec;
}

.table-responsive th {
    color: #6b7280;
    font-weight: 500;
}

.table-responsive td {
    color: #1f2b44;
    font-weight: 500;
}
}

    @media (max-width: 600px) {
        .sidebar {
            position: fixed;
            width: 200px;
        }
        .content {
            margin-left: 200px;
        }
        .cards {
            grid-template-columns: repeat(1, 1fr);
        }
    }

    

</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">❮</div>
    <div class="logo-box">
        <img src="../LOGO SCBD WHITE[1].png" alt="Logo" class="logo-img">
    </div>
    <div class="menu">
        <a href="Dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        <a href="akun.php"class="active"><i class="fa-solid fa-users"></i> Manajemen Akun</a>
        <a href="jabatan.php" ><i class="fa-solid fa-briefcase"></i> Manajemen Jabatan</a>
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
