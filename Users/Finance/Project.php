<?php
include "config.php";
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['id_akun'])) {
    header("Location: ../../login.php");
    exit;
}

// Cek apakah jabatan sesuai Finance
if ($_SESSION['nama_jabatan'] !== "Finance") {
    echo "<script>alert('Anda tidak memiliki akses ke dashboard Finance'); window.location='../';</script>";
    exit;
}

/*
  Jika form dikirim (POST), proses simpan terlebih dahulu
  lalu redirect agar form tidak double-submit saat refresh.
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Ambil & sanitize input
    $kode    = mysqli_real_escape_string($conn, $_POST['kodeProject'] ?? '');
    $name    = mysqli_real_escape_string($conn, $_POST['projectName'] ?? '');
    $customer= mysqli_real_escape_string($conn, $_POST['customerName'] ?? '');
    $marketing = mysqli_real_escape_string($conn, $_POST['marketing'] ?? '');
    $presales  = mysqli_real_escape_string($conn, $_POST['presales'] ?? '');
    $produksi  = mysqli_real_escape_string($conn, $_POST['produksi'] ?? '');
    $implementasi = mysqli_real_escape_string($conn, $_POST['implementasi'] ?? '');
    $support = mysqli_real_escape_string($conn, $_POST['support'] ?? '');
    $jumlah  = (int)($_POST['jumlahModule'] ?? 0);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi'] ?? '');
    $priority = mysqli_real_escape_string($conn, $_POST['priority'] ?? '');
    $start   = mysqli_real_escape_string($conn, $_POST['startDate'] ?? '');
    $timeline= mysqli_real_escape_string($conn, $_POST['timeline'] ?? '');

    // Query insert
    $query = "INSERT INTO project
    (kode_project, project_name, customer_name, marketing, presales, produksi, implementasi, support, jumlah_module, lokasi, priority, start_date, timeline)
    VALUES
    ('$kode', '$name', '$customer', '$marketing', '$presales', '$produksi', '$implementasi', '$support', $jumlah, '$lokasi', '$priority', '$start', '$timeline')";

    if (mysqli_query($conn, $query)) {
        // sukses -> redirect ke halaman yang sama (mengosongkan POST)
        header("Location: Project.php");
        exit;
    } else {
        // tampilkan error (untuk debugging)
        die("Error saat menyimpan: " . mysqli_error($conn));
    }
}

/*
  Generate kode otomatis untuk ditampilkan di form.
  Letakkan di sini sehingga nilai tersedia saat HTML dirender.
*/
$res = mysqli_query($conn, "SELECT MAX(id_project) AS maxCode FROM project");
$data = mysqli_fetch_assoc($res);
$next = (int)$data['maxCode'] + 1;
$kodeAuto = "P" . sprintf("%03d", $next);
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Management - Logbook</title>
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
            <img src="LOGO SCBD WHITE[1].png" alt="Logo" class="logo-img">
        </div>


        <div class="menu">
            <a href="Dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="Project.php" class="active"><i class="fa-solid fa-folder-tree"></i> Project Management</a>
            <a href="Modul.php"><i class="fa-solid fa-cubes"></i> Modul</a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content" id="content">

        <!-- HEADER -->
        <div class="header">
            <h3>Project Management</h3>
            <div class="user-box" id="userBox">👋 Halo, <?= $_SESSION['nama']; ?> (<?= $_SESSION['nama_jabatan']; ?>)
                <span class="arrow">▼</span>
            <div class="dropdown" id="userDropdown">
                <a href="change_password.php">🔑 Change Password</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
        </div>

        <!-- FILTER -->
    <div class="filter-box">
        <input type="text" placeholder="🔎 Search..." id="searchProject">
    </div>
    <!-- BUTTON TAMBAH -->
    <div class="mb-3">
        <button class="btn btn-primary" onclick="openForm('project')">➕ Tambah Project</button>
    </div>


    <!-- TABLE -->
    <div class="table-responsive table-container">
    <table id="projectTable">
    <tr>
        <th>No</th>
        <th>Project</th>
        <th>KodeProject</th>
        <th>Customer</th>
        <th>Priority</th>
        <th>Alamat</th>
        <th>Tanggal</th>
        <th>TanggalMulai</th>
        <th>Deadline</th>
        <th>Action</th>
    </tr>

        <!-- LOOP DATABASE -->
        <?php
        include "config.php";
        $no = 1;
        $query = mysqli_query($conn, "SELECT * FROM project ORDER BY id_project DESC");
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['project_name']; ?></td>
            <td><?= $row['kode_project']; ?></td>
            <td><?= $row['customer_name']; ?></td>
            <td><?= $row['priority']; ?></td>
            <td><?= $row['lokasi']; ?></td>
            <td><?= date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
            <td><?= date('d-m-Y', strtotime($row['start_date'])); ?></td>
            <td><?= date('d-m-Y', strtotime($row['timeline'])); ?></td>
            <td><button class="btn-action">Detail</button></td>
        </tr>
        <?php } ?>
    </table>
</div>


<!-- FORM POPUP TAMBAH PROJECT & MODUL -->
<div id="formPopup" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; 
background: rgba(0,0,0,0.45); backdrop-filter: blur(2px); 
justify-content:center; align-items:center; z-index:999;">
    
    <div class="p-4 popup-box">
        <h4 id="popupTitle" class="mb-3"></h4>

        <form id="popupForm" method="POST" action="">
            <div id="formFields"><!-- input akan diganti lewat JS --></div>

            <div class="d-flex justify-content-end mt-3" style="gap:10px;">
                <button type="button" class="btn btn-secondary" onclick="closeForm()">Cancel</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>
<script>
function toggleSidebar(){
    let sidebar = document.getElementById("sidebar");
    let content = document.getElementById("content");

    sidebar.classList.toggle("collapsed");
    content.classList.toggle("collapsed");
}

// FILTER SEARCH
document.getElementById("searchProject").addEventListener("keyup", function() {
    let q = this.value.toLowerCase();
    let rows = document.querySelectorAll("#projectTable tr:not(:first-child)");

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(q) ? "" : "none";
    });
});
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
</script>


<script>
function openForm(type){
    document.getElementById("formPopup").style.display = "flex";
    let title = document.getElementById("popupTitle");
    let fields = document.getElementById("formFields");

    if(type === 'project'){
    title.textContent = "Tambah Project";
    fields.innerHTML = `
        <div class="row">
            <div class="col-md-6 mb-2">
            <label>kodeProject</label>
            <input class="form-control" type="text" name="kodeProject" value="<?= $kodeAuto ?>" readonly>
            </div>

            <div class="col-md-6 mb-2">
            <label>ProjectName</label>
            <input class="form-control" type="text" name="projectName" placeholder="Project Name">
            </div>

            <div class="col-md-6 mb-2">
            <label>Customer Name</label>
            <input class="form-control" type="text" name="customerName" placeholder="Customer Name">
            </div>

            <div class="col-md-6 mb-2">
            <label>Marketing</label>
            <select class="form-control" name="marketing">
                <option value="">--pilihMarketing--</option>
                <option value="sabda (CEO)">sabda (CEO)</option>
                <option value="juhari(CEO)">juhari(CEO)</option>
            </select>
            </div>

            <div class="col-md-6 mb-2">
            <label>Presales</label>
            <select class="form-control" name="presales">
                <option value="">--pilihPresales--</option>
                <option value="sabda (CEO)">sabda (CEO)</option>
                <option value="juhari(CEO)">juhari(CEO)</option>
            </select>
            </div>

            <div class="col-md-6 mb-2">
            <label>Produksi</label>
            <select class="form-control" name="produksi">
                <option value="">--pilihProduksi--</option>
                <option value="sabda (CEO)">sabda (CEO)</option>
                <option value="juhari(CEO)">juhari(CEO)</option>
            </select>
            </div>

            <div class="col-md-6 mb-2">
            <label>Implementasi</label>
            <select class="form-control" name="implementasi">
                <option value="">--pilihImplementasi--</option>
                <option value="sabda (CEO)">sabda (CEO)</option>
                <option value="juhari(CEO)">juhari(CEO)</option>
            </select>
            </div>

            <div class="col-md-6 mb-2">
            <label>Support</label>
            <select class="form-control" name="support">
                <option value="">--pilihSupport--</option>
                <option value="sabda (CEO)">sabda (CEO)</option>
                <option value="juhari(CEO)">juhari(CEO)</option>
            </select>
            </div>

            <div class="col-md-6 mb-2">
                <label>Jumlah Module</label>
                <input class="form-control" type="number" name="jumlahModule" placeholder="Jumlah Module">
            </div>

            <div class="col-md-6 mb-2">
                <label>Alamat</label>
                <input class="form-control" type="text" id="lokasi" name="lokasi" placeholder="Alamat">
            </div>


            <div class="col-md-6 mb-2">
            <label>Priority</label>
            <select class="form-control" name="priority">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
            </div>

            <div class="col-md-6 mb-2">
            <label>Start Date</label>
            <input class="form-control" type="date" name="startDate">
            </div>

            <div class="col-md-6 mb-2">
            <label>Timeline</label>
            <input class="form-control" type="date" name="timeline">
            </div>
        </div>
        `;

    }

}

function closeForm(){
    document.getElementById("formPopup").style.display = "none";
}
</script>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUemkvf5Ov8qy23wJWRSLB6YgzLuaJgqM&libraries=places"></script>
<script>
function initAutocomplete() {
    var input = document.getElementById("lokasi");
    var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode'],
        componentRestrictions: { country: 'id' } // hanya Indonesia
    });
}
google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>


</body>
</html>