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

// Test 1: Cek apakah halaman produk tampil dengan benar
test("halaman admin produk tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek judul halaman DATA PRODUK terlihat
    await expect(
        page.getByRole("heading", { name: "Data Produk", exact: true }),
    ).toBeVisible();
    // Cek form tambah produk terlihat
    await expect(page.locator("text=TAMBAH PRODUK BARU")).toBeVisible();
});

// Test 2: Cek apakah admin bisa tambah produk berhasil
test("admin tambah produk berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Isi nama produk dengan nama unik
    await page.fill('input[name="nama_produk"]', `kayu test ${Date.now()}`);
    // Isi stok awal
    await page.fill('input[name="stok"]', "100");
    // Upload gambar produk
    await page.setInputFiles(
        'input[name="gambar"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Isi keterangan
    await page.fill('textarea[name="keterangan"]', "Keterangan produk test");
    // Hapus onclick handler pada tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll("button[onclick]");
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Submit form tambah produk yang mengandung input nama_produk
    await page.evaluate(() => {
        const forms = Array.from(document.querySelectorAll("form")).filter(
            (form) => form.querySelector('input[name="nama_produk"]'),
        );
        if (forms.length > 0) forms[0].submit();
    });
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Produk berhasil ditambahkan")).toBeVisible({
        timeout: 10000,
    });
});

// Test 3: Cek apakah admin gagal tambah produk jika nama kosong
test("admin tambah produk gagal nama kosong", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Biarkan nama produk kosong
    // Isi stok awal
    await page.fill('input[name="stok"]', "100");
    // Upload gambar produk
    await page.setInputFiles(
        'input[name="gambar"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Isi keterangan
    await page.fill('textarea[name="keterangan"]', "Keterangan produk test");
    // Hapus onclick handler pada tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll("button[onclick]");
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Submit form tambah produk yang mengandung input nama_produk
    await page.evaluate(() => {
        const forms = Array.from(document.querySelectorAll("form")).filter(
            (form) => form.querySelector('input[name="nama_produk"]'),
        );
        if (forms.length > 0) forms[0].submit();
    });
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Nama produk wajib diisi.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 4: Cek apakah admin gagal tambah produk jika nama sudah dipakai
test("admin tambah produk gagal nama sudah dipakai", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Isi nama produk yang sudah ada di database
    await page.fill('input[name="nama_produk"]', "kayu jati");
    // Isi stok awal
    await page.fill('input[name="stok"]', "100");
    // Upload gambar produk
    await page.setInputFiles(
        'input[name="gambar"]',
        "e2e/fixtures/desain-test.jpg",
    );
    // Isi keterangan
    await page.fill('textarea[name="keterangan"]', "Keterangan produk test");
    // Hapus onclick handler pada tombol submit
    await page.evaluate(() => {
        const buttons = document.querySelectorAll("button[onclick]");
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
    });
    // Submit form tambah produk yang mengandung input nama_produk
    await page.evaluate(() => {
        const forms = Array.from(document.querySelectorAll("form")).filter(
            (form) => form.querySelector('input[name="nama_produk"]'),
        );
        if (forms.length > 0) forms[0].submit();
    });
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(
        page.getByText("Nama produk sudah pernah dipakai, gunakan nama lain."),
    ).toBeVisible({ timeout: 10000 });
});

// Test 5: Cek apakah admin gagal tambah produk jika gambar tidak diunggah
test("admin tambah produk gagal gambar tidak diunggah", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Isi nama produk
    await page.fill('input[name="nama_produk"]', "kayu test baru");
    // Isi stok awal
    await page.fill('input[name="stok"]', "100");
    // Biarkan gambar tidak diunggah
    // Isi keterangan
    await page.fill('textarea[name="keterangan"]', "Keterangan produk test");
    // Submit via form evaluate dengan novalidate agar browser tidak blokir
    await page.evaluate(() => {
        const form = Array.from(document.querySelectorAll("form")).find((f) =>
            f.querySelector('input[name="nama_produk"]'),
        );
        if (form) {
            form.setAttribute("novalidate", "true");
            form.submit();
        }
    });
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Gambar produk wajib diunggah.")).toBeVisible({
        timeout: 10000,
    });
});

// Test 6: Cek apakah admin bisa update produk berhasil
test("admin update produk berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // 1. Tunggu dan klik tombol Edit pertama di tabel
    const editBtn = page.getByRole("button", { name: "EDIT" }).first();
    await editBtn.waitFor({ state: "visible", timeout: 10000 });
    await editBtn.click();

    // 2. Targetkan modal yang sedang AKTIF / TERBUKA (kelas 'hidden' sudah dilepas)
    const activeModal = page
        .locator('div[id^="editModal"]:not(.hidden)')
        .first();
    await activeModal.waitFor({ state: "visible", timeout: 10000 });

    // 3. Isi input di dalam modal yang aktif tersebut
    await activeModal
        .locator('input[name="nama_produk"]')
        .fill("kayu mahoni update");
    await activeModal.locator('input[name="stok"]').fill("50");

    // 4. Hapus atribut onclick pada tombol submit di modal aktif agar tidak terjadi double submit/disabled
    await activeModal.evaluate((modal) => {
        const btn = modal.querySelector('button[type="submit"]');
        if (btn) btn.removeAttribute("onclick");
    });

    // 5. Klik tombol Update di dalam modal aktif
    await activeModal.getByRole("button", { name: "Update" }).click();

    // 6. Tunggu navigasi/load selesai
    await page.waitForLoadState("load");

    // 7. Cek notifikasi sukses
    await expect(page.getByText("Produk berhasil diupdate")).toBeVisible({
        timeout: 10000,
    });
});

// Test 7: Cek apakah admin bisa hapus produk berhasil
test("admin hapus produk berhasil", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman produk admin
    await page.goto("http://localhost:8000/admin/stok", { timeout: 60000 });
    // Tunggu tombol Hapus terlihat
    await page.locator("text=Hapus").first().waitFor({ timeout: 10000 });
    // Hapus onclick handler dan override confirm dialog
    await page.evaluate(() => {
        const buttons = document.querySelectorAll("button[onclick]");
        buttons.forEach((btn) => btn.removeAttribute("onclick"));
        window.confirm = () => true;
    });
    // Klik tombol HAPUS pada produk pertama
    await page.locator("text=Hapus").first().click();
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan sukses muncul
    await expect(page.getByText("Produk berhasil dihapus")).toBeVisible({
        timeout: 10000,
    });
});
