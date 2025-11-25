<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Management - Logbook</title>

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
        background: #1b2a41;
        color: white;
        height: 100vh;
        padding: 25px 20px;
        position: fixed;
        transition: 0.3s;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    /* Logo Box */
    .logo-box {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo-img {
        width: 200px;
        transition: 0.3s;
        filter: drop-shadow(0 0 2px #fff)
                drop-shadow(0 0 1px #fff)
                drop-shadow(0 0 1px #fff);
    }

    .sidebar.collapsed .logo-img {
        opacity: 0;
        width: 0;
        height: 0;
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


    /* Menu */
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
        white-space: nowrap;
        overflow: hidden;
    }

    .menu a.active,
    .menu a:hover {
        background: #162941;
        color: #fff;
    }

    .sidebar.collapsed .menu a span {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    .sidebar.collapsed .logo-img {
    opacity: 0;
    width: 0;
    height: 0;
}

.sidebar.collapsed .menu a span {
    opacity: 0;
    width: 0;
    overflow: hidden;
}


    /* CONTENT */
    .content {
        margin-left: 250px;
        padding: 25px;
        width: calc(100% - 250px);
        transition: 0.3s;
    }

    .content.collapsed {
        margin-left: 80px;
        width: calc(100% - 80px);
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

    .user-box {
        font-size: 15px;
        font-weight: 600;
        background: #ffffff;
        padding: 10px 18px;
        border-radius: 10px;
        color: #1a2b48;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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

    .filter-box input {
        padding: 10px 14px;
        width: 250px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .filter-box input:focus {
        border-color: #1b2a41;
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

    /* ACTION BUTTON */
    .btn-action {
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        color: white;
        background: #1b2a41;
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


    @media (max-width: 900px) {
    .sidebar {
        width: 250px;
    }
    .content {
        margin-left: 200px;
        width: calc(100% - 200px);
    }
    }

    @media (max-width: 600px) {
        .sidebar {
            width: 200px;
        }
        .content {
            margin-left: 200px;
            width: calc(100% - 150px);
        }
    }


    
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

        <div class="toggle-btn" onclick="toggleSidebar()">❮</div>
        <div class="logo-box">
            <img src="SCBD LOGO.png" alt="Logo" class="logo-img">
        </div>


        <div class="menu">
            <a href="Dashboard.php" class="active">📊 Dashboard</a>
            <a href="Project.php">📁 Project Management</a>
        </div>
    </div>

<!-- CONTENT -->
<div class="content" id="content">

    <!-- HEADER -->
    <div class="header">
        <h3>Project Management</h3>
        <div class="user-box">👋 Halo, Juhari</div>
    </div>

    <!-- FILTER -->
    <div class="filter-box">
        <input type="text" placeholder="🔎 Search..." id="searchProject">
    </div>

    <!-- TABLE -->
    <table id="projectTable">
        <tr>
            <th>No</th>
            <th>Nama Project</th>
            <th>Kode Project</th>
            <th>Customer</th>
            <th>Lokasi</th>
            <th>Tanggal Mulai</th>
            <th>Deadline</th>
            <th>Action</th>
        </tr>

        <!-- DATA DEFAULT -->
        <tr>
            <td>1</td>
            <td>Belum ada data</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td><button class="btn-action">Detail</button></td>
        </tr>
    </table>

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

</body>
</html>
