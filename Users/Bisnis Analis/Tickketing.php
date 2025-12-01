<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['id_akun'])) {
    header("Location: ../login.php");
    exit;
}

// Cek apakah jabatan sesuai Finance
if ($_SESSION['nama_jabatan'] !== "Bisnis Analis") {
    echo "<script>alert('Anda tidak memiliki akses ke dashboard Finance'); window.location='../login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Business Analis  </title>
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
        color:rgb(0, 0, 0);
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
    /* CARD WRAPPER */
    .cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .card-title {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .card-value {
        font-size: 26px;
        font-weight: 700;
        color: #0f1c2e;
    }

    /* TABLE */
    table {
        width: 100%;
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border-collapse: collapse;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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
    /* Ubah warna ikon tombol close menjadi putih */
    .btn-close.white {
        filter: invert(1);
        opacity: 1;
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
            <img src="LOGO SCBD WHITE1.png" alt="Logo" class="logo-img">
        </div>  


        <div class="menu">
            <a href="Dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="Project.php"><i class="fa-solid fa-folder-tree"></i> Project Management</a>
            <a href="Tickketing.php"class="active"><i class="fa-solid fa-ticket"></i> Tickketing</a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content" id="content">

        <!-- HEADER -->
        <div class="header">
            <h3>📌 Ticketing Project</h3>
            <div class="user-box" id="userBox">👋 Halo, Juhari
                <span class="arrow">▼</span>
            <div class="dropdown" id="userDropdown">
                <a href="change_password.php">🔑 Change Password</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
        </div>

        <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Nama Project</th>
                    <th>Tgl Tiket</th>
                    <th>Modul</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <td>Project A</td>
                <td>2025-11-28</td>
                <td>Dashboard</td>
                <td>High</td>
                <td>Pending</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="showDetail(
                        'TCK-001','2025-11-28','Project A','Dashboard','UI Design',
                        'Perbaikan UI bagian tabel','Perbaikan UI bagian tabel','LampiranUI.png','High','Pending'
                    )">Detail</button>
                </td>
            </tbody>
        </table>
    </div>


    <!-- CARD DETAIL (MODAL) -->
<div class="modal fade" id="modalDetail">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header bg-dark text-white">
    <h5 class="modal-title">Detail Ticketing</h5>
    <button class="btn-close white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <div class="row g-3">

        <div class="col-md-6"><label>No Tiket</label><input id="d_no" class="form-control" disabled></div>
        <div class="col-md-6"><label>Tgl Tiket</label><input id="d_tgl" class="form-control" disabled></div>
        <div class="col-md-6"><label>Nama Project</label><input id="d_project" class="form-control" disabled></div>
        <div class="col-md-6"><label>Modul</label><input id="d_modul" class="form-control" disabled></div>
        <div class="col-md-6"><label>Sub Modul</label><input id="d_submod" class="form-control" disabled></div>
        <div class="col-md-6"><label>Prioritas</label><input id="d_prioritas" class="form-control" disabled></div>
        <div class="col-md-6"><label>Status</label><input id="d_status" class="form-control" disabled></div>
        <div class="col-md-6"><label>Topik</label><input id="t_topik" class="form-control" disabled></div>
        
        
        <div class="col-md-12">
            <label>Deskripsi</label>
            <textarea id="d_deskripsi" class="form-control" rows="3" disabled></textarea>
        </div>

        <div class="col-md-12">
            <label>Lampiran</label><br>
            <div class="col-md-12">
    

    <!-- Preview foto/video -->
    <div id="preview_area">
        <img id="preview_img" class="img-fluid rounded border d-none" style="max-height:220px;">
        <video id="preview_video" class="img-fluid rounded border d-none" style="max-height:220px;" controls></video>
    </div>

    <!-- Input upload -->
    <input type="file" id="upload_lampiran" class="form-control mt-2"
           accept="image/*,video/*" onchange="previewLampiran()">
</div>

            <img id="d_foto" src="LOGO SCBD WHITE[1].png" class="img-fluid rounded border" style="max-height:220px;">
        </div>
        <div class="modal-footer d-flex justify-content-end">

    <!-- Tombol REJECT sekarang di kiri -->
    <button class="btn btn-danger me-2" onclick="rejectTicket()">
        <i class="fa-solid fa-xmark"></i> Reject
    </button>

    <!-- Tombol APPROVE sekarang di kanan -->
    <button class="btn btn-success" onclick="approveTicket()">
        <i class="fa-solid fa-check"></i> Approve
    </button>

</div>


</div>

    </div>
</div>
</div>
</div>
</div>

    <!-- MODAL FORM -->
<div class="modal fade" id="modalForm">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

   
</div>
</div>
</div>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleSidebar(){
        let sidebar = document.getElementById("sidebar");
        let content = document.getElementById("content");

        sidebar.classList.toggle("collapsed");
        content.classList.toggle("collapsed");
    }
    </script>


    <script>
        // Toggle dropdown saat klik user-box
        document.getElementById("userBox").addEventListener("click", function() {
            let dropdown = document.getElementById("userDropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });

        // Tutup dropdown kalau klik di luar
        window.addEventListener("click", function(e) {
            let userBox = document.getElementById("userBox");
            let dropdown = document.getElementById("userDropdown");
            if (!userBox.contains(e.target)) {
                dropdown.style.display = "none";
            }
        });


        function showDetail(no,tgl,project,modul,sub,top,desk,foto,prio,status){
        document.getElementById("d_no").value = no;
        document.getElementById("d_tgl").value = tgl;
        document.getElementById("d_project").value = project;
        document.getElementById("d_modul").value = modul;
        document.getElementById("d_submod").value = sub;
        document.getElementById("t_topik").value = top;
        document.getElementById("d_deskripsi").value = desk;
        document.getElementById("d_prioritas").value = prio;
        document.getElementById("d_status").value = status;
        document.getElementById("d_foto").src = foto;

        new bootstrap.Modal(document.getElementById("modalDetail")).show();
    }


        function previewLampiran() {
            const file = document.getElementById("upload_lampiran").files[0];
            const img = document.getElementById("preview_img");
            const vid = document.getElementById("preview_video");

            img.classList.add("d-none");
            vid.classList.add("d-none");

            if (!file) return;

            const url = URL.createObjectURL(file);

            if (file.type.startsWith("image/")) {
                img.src = url;
                img.classList.remove("d-none");
            } else if (file.type.startsWith("video/")) {
                vid.src = url;
                vid.classList.remove("d-none");
            }
        }



    </script>

    

</body>
</html>