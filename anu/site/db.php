<?php
$conn = mysqli_connect("localhost", "root", "", "login_db");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
} 