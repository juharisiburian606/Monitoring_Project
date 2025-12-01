<?php
include "config.php";
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['id_akun'])) {
    header("Location: ../login.php");
    exit;
}

// Cek apakah jabatan sesuai Finance
if ($_SESSION['nama_jabatan'] !== "Finance") {
    echo "<script>alert('Anda tidak memiliki akses ke dashboard Finance'); window.location='../';</script>";
    exit;
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $namaModul = mysqli_real_escape_string($conn, $_POST['nama_modul'] ?? '');
    $idProject = (int)($_POST['id_project'] ?? 0);

    if ($namaModul && $idProject) {
        $query = "INSERT INTO modul (nama_modul, id_project) VALUES ('$namaModul', $idProject)";
        if (mysqli_query($conn, $query)) {
            header("Location: Modul.php");
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    }
}

// Ambil daftar project untuk dropdown
$projects = mysqli_query($conn, "SELECT id_project, project_name FROM project ORDER BY project_name ASC");

// Ambil semua modul beserta nama project
$moduls = mysqli_query($conn, "
    SELECT m.id_modul, m.nama_modul, p.project_name 
    FROM modul m
    JOIN project p ON m.id_project = p.id_project
    ORDER BY m.id_modul DESC
");
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ticketing Project</title>
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
    /* BUTTON */
    .btn-add { background: #14365f; color: white; }

   /* FILTER */
.filter-box {
    background: #fff; padding: 18px; border-radius: 12px;
    margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex; align-items: center; gap: 15px;
}
.filter-box input {
    padding: 10px 14px; width: 250px;
    border-radius: 8px; border: 1px solid #d1d5db;
    font-size: 14px; outline: none;
}

/* TABLE */
table {
    width: 100%; background: #fff; border-radius: 12px;
    padding: 20px; border-collapse: collapse;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
th, td {
    padding: 14px; text-align: left; font-size: 14px;
    border-bottom: 1px solid #ececec;
}
th { color: #6b7280; font-weight: 500; }
td { color: #1f2b44; font-weight: 500; }

/* BUTTON ACTION */
.btn-action {
    padding: 8px 14px; background: #1b2a41; color: #fff;
    border: none; border-radius: 8px; cursor: pointer;
    font-size: 14px; display: inline-flex; align-items: center; gap: 6px;
}

/* POPUP */
.popup-box {
    width: 95%; max-width: 450px; background: #fff;
    border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);
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
            <img src="LOGO SCBD WHITE[1].png" alt="Logo" class="logo-img">
        </div>  


        <div class="menu">
            <a href="Dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="Project.php"><i class="fa-solid fa-folder-tree"></i> Project Management</a>
            <a href="Modul.php"class="active"><i class="fa-solid fa-cubes"></i> Modul</a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content" id="content">

    <!-- HEADER -->
    <div class="header">
        <h3>Modul Management</h3>

        <div class="user-box" id="userBox">👋 Halo, <?= $_SESSION['nama']; ?> (<?= $_SESSION['nama_jabatan']; ?>)
            <span>▼</span>
            <div class="dropdown" id="userDropdown">
                <a href="change_password.php">🔑 Change Password</a>
                <a href="../logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>

        <!-- FILTER -->
    <div class="filter-box">
        <input type="text" placeholder="🔎 Search Modul..." id="searchModul">
    </div>

    <!-- BUTTON TAMBAH -->
    <div class="mb-3">
        <button class="btn btn-primary" onclick="openForm()">➕ Tambah Modul</button>
    </div>

    <!-- TABLE MODUL -->
    <table id="modulTable">
        <tr>
            <th>No</th>
            <th>Nama Modul</th>
            <th>Project</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($m = mysqli_fetch_assoc($moduls)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $m['nama_modul'] ?></td>
                <td><?= $m['project_name'] ?></td>
                <td>
                    <button class="btn-action">✏ Edit</button>
                    <button class="btn-action" style="background:#b91c1c">🗑 Hapus</button>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- POPUP -->
<div id="formPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.45); backdrop-filter:blur(2px);
    justify-content:center; align-items:center; z-index:999;">
    
    <div class="p-4 popup-box">
        <h4 class="mb-3">Tambah Modul</h4>

        <form method="POST" action="">
            <label>Nama Modul</label>
            <input class="form-control mb-3" type="text" name="nama_modul" placeholder="Masukkan nama modul" required>

            <label>Pilih Project</label>
            <select class="form-control mb-3" name="id_project" required>
                <option value="">-- pilih project --</option>
                <?php while ($p = mysqli_fetch_assoc($projects)) { ?>
                    <option value="<?= $p['id_project'] ?>"><?= $p['project_name'] ?></option>
                <?php } ?>
            </select>

            <div class="d-flex justify-content-end" style="gap:10px;">
                <button type="button" class="btn btn-secondary" onclick="closeForm()">Cancel</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>


<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("content").classList.toggle("collapsed");
}

document.getElementById("userBox").onclick = () => {
    let d = document.getElementById("userDropdown");
    d.style.display = d.style.display === "block" ? "none" : "block";
};

function openForm(){
    document.getElementById("formPopup").style.display = "flex";
}
function closeForm(){
    document.getElementById("formPopup").style.display = "none";
}

document.getElementById("searchModul").addEventListener("keyup", function(){
    let q = this.value.toLowerCase();
    let rows = document.querySelectorAll("#modulTable tr:not(:first-child)");

    rows.forEach(r => {
        r.style.display = r.innerText.toLowerCase().includes(q) ? "" : "none";
    });
});
</script>

</body>
</html>
