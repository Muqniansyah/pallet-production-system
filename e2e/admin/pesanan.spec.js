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

// Test 1: Cek apakah halaman HPP & pesanan tampil dengan benar
test("halaman admin HPP dan pesanan tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP dan pesanan admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek judul halaman DATA HPP & MANAGEMENT PESANAN terlihat
    await expect(
        page.getByRole("heading", { name: "Data HPP & Management Pesanan" }),
    ).toBeVisible();
    // Cek tombol "BUAT PESANAN" terlihat
    await expect(
        page.getByRole("button", { name: "BUAT PESANAN" }),
    ).toBeVisible();
});

// Test 2: Cek apakah admin bisa membuat pesanan berhasil
test("admin membuat pesanan berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP dan pesanan admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Pilih pengajuan pertama yang tersedia di dropdown
    const firstOption = await page
        .locator('select[name="pallet_request_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="pallet_request_id"]', firstOption);
    // Tunggu qty terisi otomatis
    await page.waitForTimeout(500);
    // Isi nama project dengan nama unik
    await page.fill('input[name="nama_project"]', `Project Test ${Date.now()}`);
    // Hapus onclick handler pada tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol BUAT PESANAN
    await page.getByRole("button", { name: "Buat Pesanan" }).click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Pesanan berhasil dibuat!")).toBeVisible({
        timeout: 10000,
    });
});

// Test 3: Cek apakah admin gagal membuat pesanan jika pengajuan tidak dipilih
test("admin membuat pesanan gagal pengajuan tidak dipilih", async ({
    page,
}) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP dan pesanan admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Biarkan dropdown pengajuan tidak dipilih
    // Isi nama project
    await page.fill('input[name="nama_project"]', "Project Test Gagal");
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol BUAT PESANAN
    await page.getByRole("button", { name: "Buat Pesanan" }).click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Pengajuan palet wajib dipilih.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 4: Cek apakah admin gagal membuat pesanan jika nama project kosong
test("admin membuat pesanan gagal nama project kosong", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP dan pesanan admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Pilih pengajuan pertama yang tersedia
    await page
        .locator('select[name="pallet_request_id"]')
        .waitFor({ timeout: 10000 });
    const firstOption = await page
        .locator('select[name="pallet_request_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="pallet_request_id"]', firstOption);
    // Biarkan nama project kosong
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol BUAT PESANAN
    await page.getByRole("button", { name: "Buat Pesanan" }).click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Nama project wajib diisi.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 5: Cek apakah admin gagal membuat pesanan jika nama project sudah dipakai
test("admin membuat pesanan gagal nama project sudah dipakai", async ({
    page,
}) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP dan pesanan admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Pilih pengajuan pertama yang tersedia
    await page
        .locator('select[name="pallet_request_id"]')
        .waitFor({ timeout: 10000 });
    const firstOption = await page
        .locator('select[name="pallet_request_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="pallet_request_id"]', firstOption);
    // Isi nama project yang sudah pernah dipakai
    await page.fill('input[name="nama_project"]', "Project Test Bekasi");
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol BUAT PESANAN
    await page.getByRole("button", { name: "Buat Pesanan" }).click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(
        page.getByText("Nama project sudah pernah dipakai, gunakan nama lain."),
    ).toBeVisible({ timeout: 10000 });
});
