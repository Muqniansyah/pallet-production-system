// Import library test dan expect dari Playwright
import { test, expect } from "@playwright/test";

// Login sebagai admin sebelum setiap test
test.beforeEach(async ({ page }) => {
    // Tambah timeout 2 menit untuk mengantisipasi browser yang lambat
    test.setTimeout(180000);
    // Hapus cookies agar sesi tidak tercampur
    await page.context().clearCookies();
    // Buka halaman login
    await page.goto("http://localhost:8000/login", { timeout: 90000 });
    // Isi input email admin
    await page.fill('input[name="email"]', "admin@gmail.com");
    // Isi input password admin
    await page.fill('input[name="password"]', "password");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu sampai berhasil login dan redirect ke dashboard admin
    await page.waitForURL(/admin\/dashboard/, { timeout: 90000 });
});

// Test 1: Cek apakah halaman kelola klien tampil dengan benar
test("halaman admin kelola klien tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman kelola klien
    await page.goto("http://localhost:8000/admin/client", { timeout: 60000 });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek judul halaman DATA KLIEN terlihat
    await expect(page.locator("text=DATA KLIEN")).toBeVisible();
    // Cek tabel klien terlihat
    await expect(page.locator("text=Nama")).toBeVisible();
    await expect(page.locator("text=Email")).toBeVisible();
});

// Test 2: Cek apakah admin bisa update role klien menjadi admin
test("admin update role klien menjadi admin berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman kelola klien
    await page.goto("http://localhost:8000/admin/client", { timeout: 60000 });
    // Tunggu sampai ada data klien
    await page.locator("text=UPDATE").first().waitFor({ timeout: 10000 });
    // Pilih role admin pada klien pertama
    await page.locator('select[name="role"]').first().selectOption("admin");
    // Submit form langsung tanpa klik tombol
    await page.evaluate(() => {
        // Cari form yang mengandung select role
        const forms = Array.from(document.querySelectorAll("form")).filter(
            (form) => form.querySelector('select[name="role"]'),
        );
        if (forms.length > 0) forms[0].submit();
    });
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Role berhasil diubah")).toBeVisible({
        timeout: 10000,
    });
});
