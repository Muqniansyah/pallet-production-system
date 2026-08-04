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

// Test 1: Cek apakah admin bisa upload HPP berhasil
test("admin upload HPP berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Tunggu dropdown pesanan tersedia
    await page.locator('select[name="pesanan_id"]').waitFor({ timeout: 10000 });
    // Pilih pesanan pertama yang tersedia di dropdown
    const firstOption = await page
        .locator('select[name="pesanan_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="pesanan_id"]', firstOption);
    // Upload file HPP
    await page.setInputFiles(
        'input[name="file_hpp"]',
        "e2e/fixtures/hpp-test.pdf",
    );
    // Hapus onclick handler pada tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol UNGGAH HPP
    await page.locator("text=Unggah HPP").click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("HPP berhasil diunggah")).toBeVisible({
        timeout: 10000,
    });
});

// Test 2: Cek apakah admin gagal upload HPP jika pesanan tidak dipilih
test("admin upload HPP gagal pesanan tidak dipilih", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Biarkan dropdown pesanan tidak dipilih
    // Upload file HPP
    await page.setInputFiles(
        'input[name="file_hpp"]',
        "e2e/fixtures/hpp-test.pdf",
    );
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol UNGGAH HPP
    await page.locator("text=Unggah HPP").click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Pesanan wajib dipilih.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 3: Cek apakah admin gagal upload HPP jika file tidak diunggah
test("admin upload HPP gagal file tidak diunggah", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Tunggu dropdown pesanan tersedia
    await page.locator('select[name="pesanan_id"]').waitFor({ timeout: 10000 });
    // Pilih pesanan pertama yang tersedia
    const firstOption = await page
        .locator('select[name="pesanan_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="pesanan_id"]', firstOption);
    // Biarkan file HPP tidak diunggah
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol UNGGAH HPP
    await page.locator("text=Unggah HPP").click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("File HPP wajib diunggah.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 4: Cek apakah admin gagal upload HPP dengan format file salah
test("admin upload HPP gagal format file salah", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman HPP admin
    await page.goto("http://localhost:8000/admin/hpp", { timeout: 60000 });
    // Tunggu dropdown pesanan tersedia
    await page.locator('select[name="pesanan_id"]').waitFor({ timeout: 10000 });
    // Pilih pesanan pertama yang tersedia
    const firstOption = await page
        .locator('select[name="pesanan_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="pesanan_id"]', firstOption);
    // Upload file dengan format salah (JPG bukan PDF/Excel)
    await page.setInputFiles(
        'input[name="file_hpp"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol UNGGAH HPP
    await page.locator("text=Unggah HPP").click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(
        page.getByText("File HPP harus berformat PDF atau Excel."),
    ).toBeVisible({ timeout: 10000 });
});
