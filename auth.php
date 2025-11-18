<?php
include "koneksi.php";

function loginUser($email, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return "Email atau password salah.";
    }

    if ($user['failed_attempts'] >= 3 && timw() < $user['lock_time']) {
        return "Akun terkunci";
    }

    if (password_verify($password, $user['password'])) {
        $stmt = $conn->prepare("UPDATE users SET failed_attempts=0, lock_time=0 WHERE email=?");
        $stmt->execute([$email]);

        return "berhasil";
    } else {
        $failed = $user['failed_attempts'] + 1;
        if ($failed >= 3) {
            $lock_time = time() + 300;
            $stmt = $conn->prepare("UPDATE users SET failed_attempts=?, lock_time=? WHERE email=?");
            $stmt->execute([$failed, $lock_time, $email]);

            return "Akun terkunci";
        }
        $stmt = $conn->prepare("UPDATE users Set failed_attempts=? WHERE email=?");
        $stmt->execute([$failed, $email]);

        return "Email; atau password salah.";
    }
}