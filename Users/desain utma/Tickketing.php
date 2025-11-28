<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ticketing Project</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
    /* ====== CSS SAMA PUNYA KAMU (tidak dihapus, hanya dipertahankan) ====== */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Poppins", sans-serif; }
    body { display: flex; background: #f5f6fa; }
    .sidebar { width: 250px; background: #1b2a41; color: white; height: 100vh; padding: 25px 20px; position: fixed; }
    .sidebar h2 { font-size: 20px; margin-bottom: 40px; font-weight: 700; }
    .sidebar.collapsed { width: 80px; transition: 0.3s; }
    .content.collapsed { margin-left: 80px; width: calc(100% - 80px); }
    .sidebar .logo { display: flex; align-items: center; gap: 10px; padding: 20px; font-size: 20px; font-weight: bold; white-space: nowrap;}
    .sidebar .logo img { width: 40px; transition: 0.3s; }
    .sidebar .menu a { display: flex; align-items: center; gap: 12px; padding: 12px 20px; font-size: 16px; white-space: nowrap; overflow: hidden; transition: 0.3s;}
    .menu a.active, .menu a:hover { background: #162941; color: #fff; }
    .content { margin-left: 250px; padding: 25px; width: calc(100% - 250px); }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .user-box { position: relative; font-size: 15px; font-weight: 600; background: #ffffff; padding: 10px 18px; border-radius: 10px; color: #1a2b48; cursor: pointer; }
    .user-box .dropdown { display: none; position: absolute; top: 100%; right: 0; background: #fff; border-radius: 10px; margin-top: 8px; min-width: 180px; overflow: hidden; z-index: 100; box-shadow: 0 2px 8px rgba(0,0,0,0.15);}
    .user-box .dropdown a { display: block; padding: 10px 15px; text-decoration: none; color: #1a2b48; }
    table { width: 100%; background: #fff; border-radius: 12px; border-collapse: collapse; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    th, td { padding: 14px; border-bottom: 1px solid #e6e6e6; }
    .btn-add { background: #14365f; color: white; }
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()" style="position:absolute;top:20px;right:-15px;width:32px;height:32px;background:#162941;color:#fff;display:flex;justify-content:center;align-items:center;border-radius:50%;cursor:pointer;border:2px solid white;">❮</div>
    <div class="logo-box text-center"><img src="SCBD LOGO.png" class="logo-img" style="width:200px;"></div>
    <div class="menu">
        <a href="Dashboard.php" class="active">📊 Dashboard</a>
        <a href="Project.php">📁 ProjectManagement</a>
        <a href="Tickketing.php">🎫 Ticketing</a>
    </div>
</div>

<!-- CONTENT -->
<div class="content" id="content">

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
        <button class="btn btn-add mb-3" data-bs-toggle="modal" data-bs-target="#modalForm">➕ Tambah Ticketing</button>
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No Tiket</th>
                    <th>Tgl Tiket</th>
                    <th>Nama Project</th>
                    <th>Modul</th>
                    <th>Sub Modul</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <!-- Contoh 1 baris data -->
            <tbody>
                <tr>
                    <td>TCK-001</td>
                    <td>2025-11-28</td>
                    <td>Project A</td>
                    <td>Dashboard</td>
                    <td>UI Design</td>
                    <td>High</td>
                    <td>Pending</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="showDetail(
                            'TCK-001','2025-11-28','Project A','Dashboard','UI Design',
                            'Perbaikan UI bagian tabel','LampiranUI.png','High','Pending'
                        )">Detail</button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
</div>

<!-- CARD DETAIL (MODAL) -->
<div class="modal fade" id="modalDetail">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header bg-dark text-white">
    <h5 class="modal-title">Detail Ticketing</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
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
        
        <div class="col-md-12">
            <label>Topik / Deskripsi</label>
            <textarea id="d_deskripsi" class="form-control" rows="3" disabled></textarea>
        </div>

        <div class="col-md-12">
            <label>Lampiran</label><br>
            <img id="d_foto" src="" class="img-fluid rounded border" style="max-height:220px;">
        </div>

    </div>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("content").classList.toggle("collapsed");
}

function showDetail(no,tgl,project,modul,sub,desk,foto,prio,status){
    document.getElementById("d_no").value = no;
    document.getElementById("d_tgl").value = tgl;
    document.getElementById("d_project").value = project;
    document.getElementById("d_modul").value = modul;
    document.getElementById("d_submod").value = sub;
    document.getElementById("d_deskripsi").value = desk;
    document.getElementById("d_prioritas").value = prio;
    document.getElementById("d_status").value = status;
    document.getElementById("d_foto").src = foto;

    new bootstrap.Modal(document.getElementById("modalDetail")).show();
}

document.getElementById("userBox").addEventListener("click", () => {
    let dropdown = document.getElementById("userDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
});
</script>

</body>
</html>
