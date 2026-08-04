// Import library test dan expect dari Playwright
import { test, expect } from "@playwright/test";

// Login sebagai client sebelum setiap test
test.beforeEach(async ({ page }) => {
    // Tambah timeout 2 menit untuk mengantisipasi browser yang lambat
    test.setTimeout(120000);
    // Hapus cookies agar sesi tidak tercampur
    await page.context().clearCookies();
    // Buka halaman login
    await page.goto("http://localhost:8000/login", { timeout: 60000 });
    // Isi input email client
    await page.fill('input[name="email"]', "muqniansyah@gmail.com");
    // Isi input password client
    await page.fill('input[name="password"]', "Muqn1804!");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu sampai berhasil login dan redirect ke dashboard client
    await page.waitForURL(/client\/dashboard/, { timeout: 60000 });
});

// Test 1: Cek apakah halaman pesanan & HPP tampil dengan benar
test("halaman pesanan dan HPP tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pesanan client
    await page.goto("http://localhost:8000/client/pesanan", { timeout: 60000 });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek judul halaman MANAJEMEN PESANAN & HPP terlihat
    await expect(page.locator("text=MANAJEMEN")).toBeVisible();
    // Cek tabel pesanan terlihat
    await expect(page.locator("text=PESANAN SAYA")).toBeVisible();
});

// Test 2: Cek apakah klien bisa konfirmasi deal (proses HPP)
test("klien konfirmasi pesanan deal berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pesanan client
    await page.goto("http://localhost:8000/client/pesanan", { timeout: 60000 });
    // Tunggu sampai ada pesanan dengan status pending
    await page.locator("text=pending").first().waitFor({ timeout: 10000 });
    // Hapus onclick handler pada semua tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol PROSES HPP pada pesanan pertama yang pending
    await page.locator("text=Proses HPP").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Pesanan siap diproses HPP")).toBeVisible({
        timeout: 10000,
    });
});

// Test 3: Cek apakah klien bisa membatalkan pesanan
test("klien membatalkan pesanan berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pesanan client
    await page.goto("http://localhost:8000/client/pesanan", { timeout: 60000 });
    // Tunggu sampai ada pesanan dengan status pending
    await page.locator("text=pending").first().waitFor({ timeout: 10000 });
    // Hapus onclick handler pada semua tombol submit termasuk confirm dialog
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
        // Override confirm dialog agar otomatis return true
        window.confirm = () => true;
    });
    // Klik tombol BATALKAN pada pesanan pertama yang pending
    await page.locator("text=Batalkan").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Pesanan berhasil dibatalkan")).toBeVisible({
        timeout: 10000,
    });
});
