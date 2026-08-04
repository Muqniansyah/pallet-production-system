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
    await page.locator('button[type="submit"]').click({ force: true });
    // Tunggu sampai berhasil login dan redirect ke dashboard
    await page.waitForURL(/client\/dashboard/, { timeout: 60000 });
});

// Test 1: Cek apakah halaman kunjungan tampil dengan benar
test("halaman kunjungan tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit karena proses submit dan redirect membutuhkan waktu lebih lama
    test.setTimeout(120000);
    // Buka halaman kunjungan dengan timeout 60 detik
    await page.goto("http://localhost:8000/client/kunjungan", {
        timeout: 60000,
    });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek tombol "AJUKAN KUNJUNGAN" terlihat di halaman
    await expect(
        page.getByRole("button", { name: "AJUKAN KUNJUNGAN" }),
    ).toBeVisible();
});

// Test 2: Cek apakah pengajuan kunjungan berhasil
test("pengajuan kunjungan berhasil", async ({ page }) => {
    // Tambah timeout 2 menit karena proses submit dan redirect membutuhkan waktu lebih lama
    test.setTimeout(120000);
    // Buka halaman kunjungan
    await page.goto("http://localhost:8000/client/kunjungan", {
        timeout: 60000,
    });
    // Isi input judul kunjungan
    await page.fill('input[name="judul"]', "Peninjauan Palet");
    // Isi input tanggal kunjungan (besok agar tidak lewat)
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tanggal = tomorrow.toISOString().slice(0, 16);
    await page.fill('input[name="tanggal_kunjungan"]', tanggal);
    // Disable dulu onclick handler lalu klik tombol
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        // Hapus onclick handler sementara
        button.removeAttribute("onclick");
    });
    // Klik tombol submit biasa
    await page.click('button[type="submit"]');

    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Screenshot untuk debug
    // await page.screenshot({ path: "test-results/kunjungan-debug.png" });
    // Cek apakah pesan sukses muncul
    await expect(
        page.getByText("Jadwal kunjungan berhasil dibuat"),
    ).toBeVisible({ timeout: 10000 }); // tunggu 10 detik
});

// Test 3: Cek apakah pengajuan gagal jika judul kosong
test("pengajuan kunjungan gagal judul kosong", async ({ page }) => {
    // Tambah timeout 2 menit karena proses submit dan redirect membutuhkan waktu lebih lama
    test.setTimeout(120000);
    // Buka halaman kunjungan
    await page.goto("http://localhost:8000/client/kunjungan", {
        timeout: 60000,
    });
    // Biarkan input judul kosong
    // Isi input tanggal kunjungan
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tanggal = tomorrow.toISOString().slice(0, 16);
    await page.fill('input[name="tanggal_kunjungan"]', tanggal);
    // Disable dulu onclick handler lalu klik tombol
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        // Hapus onclick handler sementara
        button.removeAttribute("onclick");
    });
    // Klik tombol submit biasa
    await page.click('button[type="submit"]');
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(page.getByText("Judul kunjungan wajib diisi.")).toBeVisible();
});

// Test 4: Cek apakah pengajuan gagal jika tanggal sudah lewat
test("pengajuan kunjungan gagal tanggal sudah lewat", async ({ page }) => {
    // Tambah timeout 2 menit karena proses submit dan redirect membutuhkan waktu lebih lama
    test.setTimeout(120000);
    // Buka halaman kunjungan
    await page.goto("http://localhost:8000/client/kunjungan", {
        timeout: 60000,
    });
    // Isi input judul kunjungan
    await page.fill('input[name="judul"]', "Peninjauan Palet");
    // Isi input tanggal yang sudah lewat (kemarin)
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    const tanggal = yesterday.toISOString().slice(0, 16);
    await page.fill('input[name="tanggal_kunjungan"]', tanggal);
    // Klik tombol submit
    await page.locator('button[type="submit"]').click({ force: true });
    // Tunggu halaman selesai load
    await page.waitForLoadState("load");
    // Cek apakah pesan error muncul
    await expect(
        page.getByText(
            "Waktu kunjungan tidak boleh di hari/jam yang sudah lewat.",
        ),
    ).toBeVisible();
});

// Test 5: Cek apakah pengajuan gagal jika sudah 3 kunjungan hari ini
test("pengajuan kunjungan gagal maksimal 3 per hari", async ({ page }) => {
    // Tambah timeout 2 menit karena proses submit dan redirect membutuhkan waktu lebih lama
    test.setTimeout(120000);
    // Buka halaman kunjungan
    await page.goto("http://localhost:8000/client/kunjungan", {
        timeout: 60000,
    });
    // Buat 3 kunjungan terlebih dahulu
    for (let i = 0; i < 3; i++) {
        await page.fill('input[name="judul"]', `Kunjungan Test ${i + 1}`);
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1 + i);
        const tanggal = tomorrow.toISOString().slice(0, 16);
        await page.fill('input[name="tanggal_kunjungan"]', tanggal);
        await page.locator('button[type="submit"]').click({ force: true });
        await page.waitForLoadState("load");
    }
    // Coba ajukan kunjungan ke-4
    await page.fill('input[name="judul"]', "Kunjungan Test 4");
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 4);
    const tanggal = tomorrow.toISOString().slice(0, 16);
    await page.fill('input[name="tanggal_kunjungan"]', tanggal);
    await page.locator('button[type="submit"]').click({ force: true });
    await page.waitForLoadState("load");
    // Cek apakah pesan error maksimal muncul
    await expect(
        page.getByText("Maksimal 3 pengajuan kunjungan per hari."),
    ).toBeVisible();
});
