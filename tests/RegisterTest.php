<?php
use PHPUnit\Framework\Testcase;

require_once__DIR__ . '/../auth_register.php';

class RegisterTest extends TestCase
{
    public function testRegisterBerhasil()
    {
        $randomEmail = "user" . rand(1, 99999) . "@gamil.com";
        $hasil = registerUser("Test User", $randomEmail, "123456");
        $this->assertEquals("berhasil", $hasil);
    }
    public function testRegisterEmailSudahAda()
    {
        $hasil = registerUser("User Lama", "admin@gmail.com", "123");
        $this->assertEquals("Email sudah terdaftar", $hasil);
    }
    public function testRegisterInputKosong()
    {
        $hasil = registerUser("", "", "");
        $this->assertEquals("Input tidak boleh kosong", $hasil);
    }
}