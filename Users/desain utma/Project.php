<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Management - Logbook</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">


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

    .btn-action svg {
        stroke: #fff;
    }

    .btn-action:hover {
        background: #163c72ff;
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
            <img src="LOGO SCBD WHITE[1].png" alt="Logo" class="logo-img">
        </div>


        <div class="menu">
            <a href="Dashboard.php">📊 Dashboard</a>
            <a href="Project.php"class="active">📁 ProjectManagement</a>
            <a href="Tickketing.php">🎫 Tickketing</a>
        </div>
    </div>

<!-- CONTENT -->
<div class="content" id="content">

    <!-- HEADER -->
    <div class="header">
        <h3>Project Management</h3>
        <div class="user-box" id="userBox">👋 Halo, Juhari
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

    <!-- TABLE -->
    <table id="projectTable">
        <tr>
            <th>No</th>
            <th>Project</th>
            <th>KodeProject</th>
            <th>Customer</th>
            <th>Priority</th>
            <th>Lokasi</th>
            <th>TanggalMulai</th>
            <th>Deadline</th>
            <th>Action</th>
        </tr>

        <!-- DATA DEFAULT -->
        <tr>
            <td>1</td>
            <td>Jempolku</td>
            <td>0001</td>
            <td>PT Maju bersama</td>
            <td>Medium</td>
            <td>jl kapten muslim kec. medan helvetia </td>
            <td>01 Decemeber 2025</td>
            <td>01 Oktober 2026</td>
            <td>
            <button class="btn-action">
                <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="9" r="3"></circle>
                    <path d="M1 9s3-5 8-5 8 5 8 5-3 5-8 5-8-5-8-5z"></path>
                </svg>
                Detail
                </button>
            </td>
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


</body>
</html>
