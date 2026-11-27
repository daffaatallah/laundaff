<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_laundry";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

function cek_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function cek_admin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: dashboard.php?err=akses");
        exit;
    }
}

function rupiah($angka) {
    return "Rp " . number_format((int)$angka, 0, ',', '.');
}