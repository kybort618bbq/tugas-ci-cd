<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../auth.php';

class LoginTest extends TestCase
{
    public function testLoginValid()
    {
        // pastikan kamu punya user di database:
        // email: admin@gmail.com
        // password: 123 (hashed di database)
        $this->assertEquals("berhasil", loginUser("admin@gmail.com", "123"));
    }

    // Test password salah
    public function testPasswordSalah()
    {
        $this->assertEquals("Email atau password salah.", loginUser("admin@gmail.com", "salah"));
    }

    // Test user tidak ditemukan
    public function testUserTidakAda()
    {
        $this->assertEquals("Email atau password salah.", loginUser("tidakada@gmail.com", "123"));
    }
}
