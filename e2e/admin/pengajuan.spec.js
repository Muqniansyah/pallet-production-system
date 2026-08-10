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

// Test 1: Cek apakah halaman pengajuan palet admin tampil dengan benar
test("halaman admin pengajuan palet tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet admin
    await page.goto("http://localhost:8000/admin/pallet-request", {
        timeout: 60000,
    });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek tabel pengajuan palet terlihat
    await expect(page.locator("text=DATA PENGAJUAN")).toBeVisible();
});

// Test 2: Cek apakah admin bisa menyetujui pengajuan palet
test("admin menyetujui pengajuan palet berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet admin
    await page.goto("http://localhost:8000/admin/pallet-request", {
        timeout: 60000,
    });
    // Tunggu sampai ada data pengajuan dengan status pending
    await page.locator("text=PENDING").first().waitFor({ timeout: 10000 });
    // Hapus onclick handler pada tombol disetujui pertama
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol DISETUJUI pada pengajuan pertama yang pending
    await page.locator("text=Disetujui").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(
        page.getByText("Pengajuan palet berhasil disetujui"),
    ).toBeVisible({ timeout: 10000 });
});

// Test 3: Cek apakah admin bisa menolak pengajuan palet
test("admin menolak pengajuan palet berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet admin
    await page.goto("http://localhost:8000/admin/pallet-request", {
        timeout: 60000,
    });
    // Tunggu sampai ada data pengajuan dengan status pending
    await page.locator("text=PENDING").first().waitFor({ timeout: 10000 });
    // Isi alasan penolakan pada pengajuan pertama yang pending
    await page
        .locator('input[name="keterangan"]')
        .first()
        .fill("Desain tidak sesuai standar");
    // Hapus onclick handler pada tombol ditolak
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol DITOLAK pada pengajuan pertama yang pending
    await page.locator("text=Ditolak").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(
        page.getByText("Pengajuan palet berhasil ditolak."),
    ).toBeVisible({ timeout: 10000 });
});

// Test 4: Cek apakah admin gagal menolak tanpa alasan
test("admin menolak pengajuan palet gagal tanpa alasan", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet admin
    await page.goto("http://localhost:8000/admin/pallet-request", {
        timeout: 60000,
    });
    // Tunggu sampai ada data pengajuan dengan status pending
    await page.locator("text=PENDING").first().waitFor({ timeout: 10000 });
    // Biarkan alasan penolakan kosong
    // Hapus onclick handler hanya pada tombol di form reject
    await page.evaluate(() => {
        const rejectForms = Array.from(
            document.querySelectorAll("form"),
        ).filter((form) => form.action.includes("reject"));
        if (rejectForms.length > 0) {
            const btn = rejectForms[0].querySelector('button[type="submit"]');
            if (btn) btn.removeAttribute("onclick");
        }
    });
    // Klik tombol DITOLAK pada form reject pertama
    await page
        .locator('form[action*="reject"] button[type="submit"]')
        .first()
        .click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Alasan penolakan wajib diisi.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 5: Cek apakah admin bisa menghapus pengajuan palet
test("admin menghapus pengajuan palet berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet admin
    await page.goto("http://localhost:8000/admin/pallet-request", {
        timeout: 60000,
    });
    // Tunggu sampai ada tombol hapus (data yang sudah diproses)
    await page.locator("text=Hapus").first().waitFor({ timeout: 10000 });
    // Hapus onclick handler pada tombol hapus
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol HAPUS pada pengajuan pertama
    await page.locator("text=Hapus").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(
        page.getByText("Pengajuan palet berhasil dihapus."),
    ).toBeVisible({ timeout: 10000 });
});
