<?php
session_start();              // mulai session dulu

// hapus semua data session
$_SESSION = [];
session_unset();
session_destroy();            // hancurkan session

// opsional: hapus cookie login jika kamu membuatnya
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

// arahkan kembali ke halaman login
header("Location: login.php");
exit;
