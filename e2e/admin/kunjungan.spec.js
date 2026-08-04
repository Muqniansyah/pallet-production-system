// Import library test dan expect dari Playwright
import { test, expect } from "@playwright/test";

// Login sebagai admin sebelum setiap test
test.beforeEach(async ({ page }) => {
    // Tambah timeout 2 menit untuk mengantisipasi browser yang lambat
    test.setTimeout(120000);
    // Hapus cookies agar sesi tidak tercampur
    await page.context().clearCookies();
    // Buka halaman login
    await page.goto("http://localhost:8000/login", { timeout: 60000 });
    // Isi input email admin
    await page.fill('input[name="email"]', "admin@gmail.com");
    // Isi input password admin
    await page.fill('input[name="password"]', "password");
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu sampai berhasil login dan redirect ke dashboard admin
    await page.waitForURL(/admin\/dashboard/, { timeout: 60000 });
});

// Test 1: Cek apakah halaman admin kunjungan tampil dengan benar
test("halaman admin kunjungan tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman kunjungan admin
    await page.goto("http://localhost:8000/admin/kunjungan", {
        timeout: 60000,
    });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek judul halaman DATA JADWAL KUNJUNGAN terlihat
    await expect(page.locator("text=DATA JADWAL KUNJUNGAN")).toBeVisible();
});

// Test 2: Cek apakah admin bisa menyetujui kunjungan
test("admin menyetujui kunjungan berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman kunjungan admin
    await page.goto("http://localhost:8000/admin/kunjungan", {
        timeout: 60000,
    });
    // Tunggu sampai ada data kunjungan dengan status pending
    await page.locator("text=PENDING").first().waitFor({ timeout: 10000 });
    // Hapus onclick handler pada semua tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol DISETUJUI pada kunjungan pertama yang pending
    await page.locator("text=Disetujui").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Kunjungan disetujui")).toBeVisible({
        timeout: 10000,
    });
});

// Test 3: Cek apakah admin bisa menolak kunjungan
test("admin menolak kunjungan berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman kunjungan admin
    await page.goto("http://localhost:8000/admin/kunjungan", {
        timeout: 60000,
    });
    // Tunggu sampai ada data kunjungan dengan status pending
    await page.locator("text=PENDING").first().waitFor({ timeout: 10000 });
    // Isi alasan penolakan pada kunjungan pertama yang pending
    await page
        .locator('input[name="keterangan"]')
        .first()
        .fill("Jadwal tidak tersedia");
    // Hapus onclick handler pada semua tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol DITOLAK pada kunjungan pertama yang pending
    await page.locator("text=Ditolak").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Kunjungan ditolak dengan alasan")).toBeVisible(
        { timeout: 10000 },
    );
});

// Test 4: Cek apakah admin gagal menolak kunjungan tanpa alasan
test("admin menolak kunjungan gagal tanpa alasan", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman kunjungan admin
    await page.goto("http://localhost:8000/admin/kunjungan", {
        timeout: 60000,
    });
    // Tunggu sampai ada data kunjungan dengan status pending
    await page.locator("text=PENDING").first().waitFor({ timeout: 10000 });
    // Biarkan alasan penolakan kosong
    // Hapus onclick handler pada semua tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol DITOLAK tanpa isi alasan
    await page.locator("text=Ditolak").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Alasan penolakan wajib diisi.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 5: Cek apakah admin bisa menghapus kunjungan
test("admin menghapus kunjungan berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman kunjungan admin
    await page.goto("http://localhost:8000/admin/kunjungan", {
        timeout: 60000,
    });
    // Tunggu sampai ada tombol hapus (data yang sudah diproses)
    await page.locator("text=Hapus").first().waitFor({ timeout: 10000 });
    // Hapus onclick handler pada semua tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol HAPUS pada kunjungan pertama
    await page.locator("text=Hapus").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(
        page.getByText("Data kunjungan berhasil dihapus."),
    ).toBeVisible({ timeout: 10000 });
});
