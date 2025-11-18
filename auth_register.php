<?php
include "koneksi.php";

function registerUser($fullname, $email, $password)
{
    global $conn;

    // Validasi input kosong
    if (empty($fullname) || empty($email) || empty($password)) {
        return "Input tidak boleh kosong";
    }

    // Cek email sudah terdaftar
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        return "Email sudah terdaftar";
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user baru
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, failed_attempts, lock_time) VALUES (?, ?, ?, 0, 0)");
    $result = $stmt->execute([$fullname, $email, $hashed]);

    if ($result) {
        return "berhasil";
    } else {
        return "Gagal registrasi";
    }
}
