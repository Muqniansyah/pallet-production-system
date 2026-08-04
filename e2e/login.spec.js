// Import library test dan expect dari Playwright
import { test, expect } from "@playwright/test";

// Hapus cookies sebelum setiap test agar sesi tidak tercampur
test.beforeEach(async ({ page }) => {
    await page.context().clearCookies();
});

// Test 1: Cek apakah halaman login tampil dengan benar
test("halaman login tampil dengan benar", async ({ page }) => {
    // Buka halaman login
    await page.goto("http://localhost:8000/login");
    // Cek judul halaman mengandung "SiPalet"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek tombol "Masuk" terlihat di halaman
    await expect(page.getByRole("button", { name: "Masuk" })).toBeVisible();
});

// Test 2: Cek apakah login berhasil sebagai client
test("login berhasil sebagai client", async ({ page }) => {
    // Buka halaman login
    await page.goto("http://localhost:8000/login");
    // Isi input email dengan email client
    await page.fill('input[name="email"]', "muqniansyah@gmail.com");
    // Isi input password dengan password client
    await page.fill('input[name="password"]', "Muqn1804!");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Cek apakah URL berubah ke dashboard client (tambah timeout 60detik)
    await expect(page).toHaveURL(/client\/dashboard/, { timeout: 60000 });
});

// Test 3: Cek apakah login berhasil sebagai admin
test("login berhasil sebagai admin", async ({ page }) => {
    // Buka halaman login
    await page.goto("http://localhost:8000/login");
    // Isi input email dengan email admin
    await page.fill('input[name="email"]', "admin@gmail.com");
    // Isi input password dengan password admin
    await page.fill('input[name="password"]', "password");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Cek apakah URL berubah ke dashboard admin
    await expect(page).toHaveURL(/admin\/dashboard/);
});

// Test 4: Cek apakah login gagal dengan kredensial salah
test("login gagal dengan kredensial salah", async ({ page }) => {
    // Buka halaman login
    await page.goto("http://localhost:8000/login");
    // Isi input email dengan email yang salah
    await page.fill('input[name="email"]', "salah@gmail.com");
    // Isi input password dengan password yang salah
    await page.fill('input[name="password"]', "passwordsalah");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Cek apakah pesan error muncul
    await expect(
        page.getByText("Email atau password yang Anda masukkan salah"),
    ).toBeVisible();
});
