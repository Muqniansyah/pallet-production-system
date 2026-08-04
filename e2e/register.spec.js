// Import library test dan expect dari Playwright
import { test, expect } from "@playwright/test";

// Hapus cookies sebelum setiap test agar sesi tidak tercampur
test.beforeEach(async ({ page }) => {
    await page.context().clearCookies();
});

// Test 1: Cek apakah halaman register tampil dengan benar
test("halaman register tampil dengan benar", async ({ page }) => {
    // Buka halaman register (dengan timeout 60 detik agar Firefox tidak timeout)
    await page.goto("http://localhost:8000/register", { timeout: 60000 });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek tombol "Daftar Sekarang" terlihat di halaman
    await expect(
        page.getByRole("button", { name: "Daftar Sekarang" }),
    ).toBeVisible();
});

// Test 2: Cek apakah register berhasil
test("register berhasil", async ({ page }) => {
    // Buka halaman register (dengan timeout 60 detik agar Firefox tidak timeout)
    await page.goto("http://localhost:8000/register", { timeout: 60000 });
    // Isi input nama
    await page.fill('input[name="name"]', "User Test");
    // Email unik setiap kali test dijalankan
    const email = `usertest${Date.now()}@gmail.com`;
    // Isi input email baru yang belum terdaftar
    await page.fill('input[name="email"]', email);
    // Isi input password yang memenuhi syarat
    await page.fill('input[name="password"]', "Test1234!");
    // Isi input konfirmasi password
    await page.fill('input[name="password_confirmation"]', "Test1234!");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Screenshot untuk lihat kondisi halaman setelah submit
    // await page.screenshot({ path: "test-results/register-debug.png" });
    // Cek apakah URL berubah ke dashboard client
    await expect(page).toHaveURL(/client\/dashboard/, { timeout: 60000 });
});

// Test 3: Cek apakah register gagal jika email sudah terdaftar
test("register gagal email sudah terdaftar", async ({ page }) => {
    // Buka halaman register (dengan timeout 60 detik agar Firefox tidak timeout)
    await page.goto("http://localhost:8000/register", { timeout: 60000 });
    // Isi input nama
    await page.fill('input[name="name"]', "User Test");
    // Isi input email yang sudah terdaftar
    await page.fill('input[name="email"]', "muqniansyah@gmail.com");
    // Isi input password
    await page.fill('input[name="password"]', "Test1234!");
    // Isi input konfirmasi password
    await page.fill('input[name="password_confirmation"]', "Test1234!");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("networkidle");
    // Cek apakah pesan error email sudah terdaftar muncul
    await expect(
        page.getByText(
            "Email ini sudah terdaftar. Gunakan email lain atau masuk.",
        ),
    ).toBeVisible();
});

// Test 4: Cek apakah register gagal jika password tidak sesuai
test("register gagal password tidak sesuai", async ({ page }) => {
    // Buka halaman register (dengan timeout 60 detik agar Firefox tidak timeout)
    await page.goto("http://localhost:8000/register", { timeout: 60000 });
    // Isi input nama
    await page.fill('input[name="name"]', "User Test");
    // Isi input email baru
    await page.fill('input[name="email"]', "usertest2@gmail.com");
    // Isi input password
    await page.fill('input[name="password"]', "Test1234!");
    // Isi input konfirmasi password yang tidak sesuai
    await page.fill('input[name="password_confirmation"]', "SalahPassword!");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Cek apakah pesan error konfirmasi password muncul
    await expect(
        page.getByText("Konfirmasi password tidak cocok."),
    ).toBeVisible();
});

// Test 5: Cek apakah register gagal jika password lemah
test("register gagal password lemah", async ({ page }) => {
    // Buka halaman register (dengan timeout 60 detik agar Firefox tidak timeout)
    await page.goto("http://localhost:8000/register", { timeout: 60000 });
    // Isi input nama
    await page.fill('input[name="name"]', "User Test");
    // Isi input email baru
    await page.fill('input[name="email"]', `usertest${Date.now()}@gmail.com`);
    // Isi input password tanpa huruf besar dan simbol
    await page.fill('input[name="password"]', "password123");
    // Isi input konfirmasi password
    await page.fill('input[name="password_confirmation"]', "password123");
    // Klik tombol submit dulu baru waitForLoadState
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("networkidle");
    // Screenshot untuk debug
    // await page.screenshot({ path: "test-results/password-lemah-debug.png" });
    // Cek apakah pesan error password lemah muncul
    await expect(
        page.getByText(
            "Password harus mengandung huruf besar, huruf kecil, angka, dan simbol (contoh: !@#$%^&*).",
        ),
    ).toBeVisible();
});

// Test 6: Cek apakah register gagal jika nama kosong
test("register gagal nama kosong", async ({ page }) => {
    // Buka halaman register (dengan timeout 60 detik agar Firefox tidak timeout)
    await page.goto("http://localhost:8000/register", { timeout: 60000 });
    // Biarkan input nama kosong
    // Isi input email
    await page.fill('input[name="email"]', "usertest4@gmail.com");
    // Isi input password
    await page.fill('input[name="password"]', "Test1234!");
    // Isi input konfirmasi password
    await page.fill('input[name="password_confirmation"]', "Test1234!");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Cek apakah pesan error nama kosong muncul
    await expect(page.getByText("Nama lengkap wajib diisi.")).toBeVisible();
});
