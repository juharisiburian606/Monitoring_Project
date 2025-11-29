<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modul Management</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
/* ===========================
   CSS ORIGINAL — TANPA PERUBAHAN
=========================== */
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
    transition: 0.3s;
}
.sidebar.collapsed { width: 80px; }
.logo-box { text-align: center; margin-bottom: 20px; }
.logo-img { width: 200px; transition: 0.3s; }
.sidebar.collapsed .logo-img { opacity: 0; width: 0; }

.menu a {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; font-size: 15px; border-radius: 10px;
    color: #cfd7e3; text-decoration: none; margin-bottom: 8px;
    transition: 0.2s; white-space: nowrap; overflow: hidden;
}
.menu a.active, .menu a:hover { background: #162941; color: #fff; }
.sidebar.collapsed .menu a span { opacity: 0; width: 0; overflow: hidden; }

/* CONTENT */
.content {
    margin-left: 250px;
    padding: 25px;
    width: calc(100% - 250px);
}
.content.collapsed {
    margin-left: 80px;
    width: calc(100% - 80px);
}

/* HEADER */
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.header h3 { font-size: 24px; font-weight: 600; color: #1a2b48; }

.user-box {
    position: relative;
    font-size: 15px; font-weight: 600;
    background: #ffffff; padding: 10px 18px;
    border-radius: 10px; color: #1a2b48;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    cursor: pointer;
}
.user-box .dropdown {
    display: none; position: absolute; top: 100%; right: 0;
    background: #fff; border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    margin-top: 8px; min-width: 180px; z-index: 100;
}
.user-box .dropdown a {
    display: block; padding: 10px 15px;
    color: #1a2b48; text-decoration: none; font-size: 14px;
}
.user-box .dropdown a:hover { background: #f1f1f1; }


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
        <img src="LOGO SCBD WHITE[1].png" class="logo-img">
    </div>

    <div class="menu">
        <a href="Dashboard.php">📊 Dashboard</a>
        <a href="Project.php">📁 Project Management</a>
        <a href="Modul.php" class="active">📦 Modul</a>
        <a href="Tickketing.php">🎫 Tickketing</a>
    </div>
</div>

<!-- CONTENT -->
<div class="content" id="content">

    <!-- HEADER -->
    <div class="header">
        <h3>Modul Management</h3>

        <div class="user-box" id="userBox">
            👋 Halo, Juhari
            <span>▼</span>
            <div class="dropdown" id="userDropdown">
                <a href="change_password.php">🔑 Change Password</a>
                <a href="logout.php">🚪 Logout</a>
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

        <tr>
            <td>1</td>
            <td>Login User</td>
            <td>Jempolku</td>
            <td>
                <button class="btn-action">✏ Edit</button>
                <button class="btn-action" style="background:#b91c1c">🗑 Hapus</button>
            </td>
        </tr>
    </table>
</div>

<!-- POPUP -->
<div id="formPopup" style="
    display:none; position:fixed; top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.45); backdrop-filter:blur(2px);
    justify-content:center; align-items:center; z-index:999;">
    
    <div class="p-4 popup-box">
        <h4 class="mb-3">Tambah Modul</h4>

        <form>
            <label>Nama Modul</label>
            <input class="form-control mb-3" type="text" placeholder="Masukkan nama modul">

            <label>Pilih Project</label>
            <select class="form-control mb-3">
                <option>-- pilih project --</option>
                <option>Jempolku</option>
                <option>Project Lain</option>
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
