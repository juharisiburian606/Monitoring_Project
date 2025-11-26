<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form Tiket - Monitoring Project</title>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Poppins", sans-serif; }
    body { display: flex; background: #f5f6fa; }

    /* SIDEBAR */
    .sidebar {
        width: 250px;
        background: #1b2a41;
        color: white;
        height: 100vh;
        padding: 25px 20px;
        position: fixed;
    }

    .sidebar.collapsed { width: 80px; transition: 0.3s; }
    .content.collapsed { margin-left: 80px; width: calc(100% - 80px); }

    .logo-box { text-align: center; margin-bottom: 20px; }
    .logo-img { width: 200px; height: auto; filter: drop-shadow(0 0 2px #fff) drop-shadow(0 0 1px #fff); }

    .menu a {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px;
        font-size: 15px; border-radius: 10px;
        color: #cfd7e3; text-decoration: none;
        margin-bottom: 8px; transition: 0.2s;
    }
    .menu a.active, .menu a:hover { background: #162941; color: #fff; }

    /* TOGGLE */
    .toggle-btn {
        position: absolute;
        top: 20px; right: -15px;
        width: 32px; height: 32px;
        background: #162941; color: #fff;
        border-radius: 50%;
        display: flex; justify-content: center; align-items: center;
        cursor: pointer; z-index: 99;
        border: 2px solid #fff;
    }

    /* CONTENT */
    .content {
        margin-left: 250px;
        padding: 25px;
        width: calc(100% - 250px);
    }

    .header {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 25px;
    }

    .header h3 { font-size: 24px; font-weight: 600; color: #1a2b48; }

    /* USER BOX */
    .user-box {
        position: relative;
        background: #fff;
        padding: 10px 18px;
        font-size: 15px; font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .user-box .dropdown {
        display: none;
        position: absolute;
        top: 100%; right: 0;
        background: #fff;
        border-radius: 10px;
        min-width: 180px;
        overflow: hidden; margin-top: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        z-index: 100;
    }
    .user-box .dropdown a {
        padding: 10px 15px;
        display: block;
        text-decoration: none;
        font-size: 14px;
        color: #1a2b48;
    }
    .user-box .dropdown a:hover { background: #f1f1f1; }

    /* ---- FORM ---- */
    .form-box {
        background: #fff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        max-width: 750px;
    }

    .form-box h4 { margin-bottom: 20px; color: #1a2b48; font-size: 20px; }
    .form-group { margin-bottom: 15px; }
    label { font-size: 14px; font-weight: 600; color: #1a2b48; display: block; margin-bottom: 6px; }

    input, select, textarea {
        width: 100%; padding: 11px;
        border-radius: 8px;
        border: 1px solid #d5d9e2;
        font-size: 14px;
    }

    textarea { resize: vertical; height: 90px; }

    button {
        width: 100%; background: #1b2a41;
        padding: 12px; font-size: 15px;
        color: #fff; border: none; border-radius: 8px;
        cursor: pointer; margin-top: 10px;
    }
    button:hover { background: #162941; }
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">❮</div>

    <div class="logo-box">
        <img src="SCBD LOGO.png" class="logo-img">
    </div>

    <div class="menu">
        <a href="Dashboard.php">📊 Dashboard</a>
        <a href="Project.php">📁 Project Management</a>
        <a href="FormTiket.php" class="active">🎫 Form Tiket</a>
    </div>
</div>

<!-- CONTENT -->
<div class="content" id="content">
    <div class="header">
        <h3>Form Tiket Masalah Project</h3>
        <div class="user-box" id="userBox">
            👋 Halo, Juhari ▼
            <div class="dropdown" id="userDropdown">
                <a href="change_password.php">🔑 Change Password</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>

    <!-- FORM -->
    <div class="form-box">
        <h4>Input Tiket Baru</h4>

        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>No Tiket</label>
                <input type="text" name="no_tiket" value="TKT-<?php echo time(); ?>" readonly>
            </div>

            <div class="form-group">
                <label>Tanggal Tiket</label>
                <input type="text" name="tgl_tiket" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Project</label>
                <select name="project">
                    <option selected disabled>-- Pilih Project --</option>
                    <option>Project A</option>
                    <option>Project B</option>
                    <option>Project C</option>
                </select>
            </div>

            <div class="form-group">
                <label>Modul</label>
                <select name="modul">
                    <option selected disabled>-- Pilih Modul --</option>
                    <option>Modul 1</option>
                    <option>Modul 2</option>
                </select>
            </div>

            <div class="form-group">
                <label>Sub Modul</label>
                <select name="sub_modul">
                    <option selected disabled>-- Pilih Sub Modul --</option>
                    <option>Sub Modul A</option>
                    <option>Sub Modul B</option>
                </select>
            </div>

            <div class="form-group">
                <label>Topik</label>
                <input type="text" name="topik" placeholder="Masukkan topik">
            </div>

            <div class="form-group">
                <label>Deskripsi Masalah</label>
                <textarea name="deskripsi" placeholder="Jelaskan permasalahan..."></textarea>
            </div>

            <div class="form-group">
                <label>Lampiran (Foto)</label>
                <input type="file" name="lampiran">
            </div>

            <div class="form-group">
                <label>Prioritas</label>
                <select name="prioritas">
                    <option>Low</option>
                    <option>Medium</option>
                    <option>High</option>
                </select>
            </div>

            <button type="submit">💾 Simpan Tiket</button>
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

document.getElementById("userBox").addEventListener("click", function() {
    let dropdown = document.getElementById("userDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
});
window.addEventListener("click", function(e) {
    let userBox = document.getElementById("userBox");
    let dropdown = document.getElementById("userDropdown");
    if (!userBox.contains(e.target)) dropdown.style.display = "none";
});
</script>

</body>
</html>
