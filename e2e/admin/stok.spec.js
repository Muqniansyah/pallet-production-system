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

// Test 1: Cek apakah form tambah stok tampil dengan benar
test("form tambah stok tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Targetkan container card yang memiliki judul "TAMBAH STOK"
    const tambahStokCard = page
        .locator("div")
        .filter({ hasText: /^TAMBAH STOK/i })
        .last();
    // pencarian heading langsung
    await expect(
        page.getByRole("heading", { name: /tambah stok/i }),
    ).toBeVisible();
    // Cek dropdown pilih produk terlihat
    await expect(page.locator('select[name="produk_kayu_id"]')).toBeVisible();
    // Cek input jumlah stok terlihat
    await expect(page.locator('input[name="jumlah"]')).toBeVisible();
});

// Test 2: Cek apakah admin bisa tambah stok berhasil
test("admin tambah stok berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Pilih produk pertama dari dropdown
    const firstOption = await page
        .locator('select[name="produk_kayu_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="produk_kayu_id"]', firstOption);
    // Isi jumlah stok
    await page.fill('input[name="jumlah"]', "50");
    // Hapus onclick handler pada tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll("button[onclick]");
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol submit khusus yang berada di dalam form tambah stok
    await page
        .locator(
            'form:has(select[name="produk_kayu_id"]) button[type="submit"]',
        )
        .click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Stok berhasil ditambahkan")).toBeVisible({
        timeout: 10000,
    });
});

// Test 3: Cek apakah admin gagal tambah stok jika produk tidak dipilih
test("admin tambah stok gagal produk tidak dipilih", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Biarkan dropdown produk tidak dipilih
    // Isi jumlah stok
    await page.fill('input[name="jumlah"]', "50");
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll("button[onclick]");
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol submit form tambah stok
    await page
        .locator(
            'form:has(select[name="produk_kayu_id"]) button[type="submit"]',
        )
        .click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Produk kayu wajib dipilih.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 4: Cek apakah admin gagal tambah stok jika jumlah kurang dari 1
test("admin tambah stok gagal jumlah kurang dari 1", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Pilih produk pertama dari dropdown
    const firstOption = await page
        .locator('select[name="produk_kayu_id"] option:nth-child(2)')
        .getAttribute("value");
    await page.selectOption('select[name="produk_kayu_id"]', firstOption);
    // Isi jumlah stok dengan nilai 0
    await page.fill('input[name="jumlah"]', "0");
    // Hapus onclick handler
    await page.evaluate(() => {
        const buttons = document.querySelectorAll("button[onclick]");
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Klik tombol submit form tambah stok
    await page
        .locator(
            'form:has(select[name="produk_kayu_id"]) button[type="submit"]',
        )
        .click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Jumlah stok minimal 1.")).toBeVisible({
        timeout: 10000,
    });
});
