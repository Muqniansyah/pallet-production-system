// Import library test dan expect dari Playwright
import { test, expect } from "@playwright/test";

// Login sebagai client sebelum setiap test
test.beforeEach(async ({ page }) => {
    // Tambah timeout 2 menit untuk mengantisipasi browser yang lambat seperti Firefox
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
    // Tunggu sampai berhasil login dan redirect ke dashboard
    await page.waitForURL(/client\/dashboard/, { timeout: 60000 });
});

// Test 1: Cek apakah halaman pengajuan palet tampil dengan benar
test("halaman pengajuan palet tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet
    await page.goto("http://localhost:8000/client/pallet-request", {
        timeout: 60000,
    });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek tombol "AJUKAN PALET" terlihat di halaman
    await expect(
        page.getByRole("button", { name: "AJUKAN PALET" }),
    ).toBeVisible();
    // Cek dropdown jenis kayu tersedia
    await expect(page.locator('select[name="jenis_palet"]')).toBeVisible();
});

// Test 2: Cek apakah pengajuan palet berhasil
test("pengajuan palet berhasil", async ({ page }) => {
    // Tambah timeout 2 menit karena proses submit dan redirect membutuhkan waktu lebih lama
    test.setTimeout(120000);
    // Buka halaman pengajuan palet
    await page.goto("http://localhost:8000/client/pallet-request", {
        timeout: 60000,
    });
    // Pilih jenis kayu jati dari dropdown
    await page.selectOption('select[name="jenis_palet"]', "kayu jati");
    // Isi input qty minimal 50
    await page.fill('input[name="qty"]', "50");
    // Upload file desain
    await page.setInputFiles(
        'input[name="file_desain"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Isi input alamat kirim
    await page.fill('textarea[name="alamat_kirim"]', "Jl. Test No. 1, Bekasi");
    // Isi input catatan
    await page.fill('textarea[name="catatan"]', "Catatan test pengajuan palet");
    // Hapus onclick handler untuk bypass loading button
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        button.removeAttribute("onclick");
    });
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(
        page.getByText("Pengajuan palet berhasil dikirim"),
    ).toBeVisible({ timeout: 10000 });
});

// Test 3: Cek apakah pengajuan gagal jika jenis palet tidak dipilih
test("pengajuan palet gagal jenis palet tidak dipilih", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet
    await page.goto("http://localhost:8000/client/pallet-request", {
        timeout: 60000,
    });
    // Biarkan jenis palet tidak dipilih
    // Isi input qty
    await page.fill('input[name="qty"]', "50");
    // Upload file desain
    await page.setInputFiles(
        'input[name="file_desain"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Isi input alamat kirim
    await page.fill('textarea[name="alamat_kirim"]', "Jl. Test No. 1, Bekasi");
    // Isi input catatan
    await page.fill('textarea[name="catatan"]', "Catatan test");
    // Hapus onclick handler
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        button.removeAttribute("onclick");
    });
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Jenis palet wajib dipilih.")).toBeVisible();
});

// Test 4: Cek apakah pengajuan gagal jika qty kurang dari 50
test("pengajuan palet gagal qty kurang dari 50", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet
    await page.goto("http://localhost:8000/client/pallet-request", {
        timeout: 60000,
    });
    // Pilih jenis kayu
    await page.selectOption('select[name="jenis_palet"]', "kayu jati");
    // Isi input qty kurang dari 50
    await page.fill('input[name="qty"]', "10");
    // Upload file desain
    await page.setInputFiles(
        'input[name="file_desain"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Isi input alamat kirim
    await page.fill('textarea[name="alamat_kirim"]', "Jl. Test No. 1, Bekasi");
    // Isi input catatan
    await page.fill('textarea[name="catatan"]', "Catatan test");
    // Hapus onclick handler
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        button.removeAttribute("onclick");
    });
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Jumlah (qty) minimal 50 PCS.")).toBeVisible();
});

// Test 5: Cek apakah pengajuan gagal jika file desain tidak diunggah
test("pengajuan palet gagal file desain tidak diunggah", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet
    await page.goto("http://localhost:8000/client/pallet-request", {
        timeout: 60000,
    });
    // Pilih jenis kayu
    await page.selectOption('select[name="jenis_palet"]', "kayu jati");
    // Isi input qty
    await page.fill('input[name="qty"]', "50");
    // Biarkan file desain tidak diunggah
    // Isi input alamat kirim
    await page.fill('textarea[name="alamat_kirim"]', "Jl. Test No. 1, Bekasi");
    // Isi input catatan
    await page.fill('textarea[name="catatan"]', "Catatan test");
    // Hapus onclick handler
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        button.removeAttribute("onclick");
    });
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("File desain wajib diunggah.")).toBeVisible();
});

// Test 6: Cek apakah pengajuan gagal jika alamat kirim kosong
test("pengajuan palet gagal alamat kirim kosong", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman pengajuan palet
    await page.goto("http://localhost:8000/client/pallet-request", {
        timeout: 60000,
    });
    // Pilih jenis kayu
    await page.selectOption('select[name="jenis_palet"]', "kayu jati");
    // Isi input qty
    await page.fill('input[name="qty"]', "50");
    // Upload file desain
    await page.setInputFiles(
        'input[name="file_desain"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Biarkan alamat kirim kosong
    // Isi input catatan
    await page.fill('textarea[name="catatan"]', "Catatan test");
    // Hapus onclick handler
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        button.removeAttribute("onclick");
    });
    // Klik tombol submit
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(
        page.getByText("Alamat pengiriman wajib diisi."),
    ).toBeVisible();
});
