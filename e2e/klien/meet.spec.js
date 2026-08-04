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

// Test 1: Cek apakah halaman meeting tampil dengan benar
test("halaman meeting tampil dengan benar", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman meeting
    await page.goto("http://localhost:8000/client/meeting-request", {
        timeout: 60000,
    });
    // Cek judul halaman mengandung "SIPALET"
    await expect(page).toHaveTitle(/SIPALET/);
    // Cek tombol "AJUKAN PERTEMUAN" terlihat di halaman
    await expect(
        page.getByRole("button", { name: "AJUKAN PERTEMUAN" }),
    ).toBeVisible();
});

// Test 2: Cek apakah pengajuan meeting berhasil
test("pengajuan meeting berhasil", async ({ page }) => {
    // Tambah timeout 2 menit karena proses submit dan redirect membutuhkan waktu lebih lama
    test.setTimeout(120000);
    // Buka halaman meeting
    await page.goto("http://localhost:8000/client/meeting-request", {
        timeout: 60000,
    });
    // Isi input judul meeting
    await page.fill('input[name="judul"]', "Konsultasi Proyek");
    // Isi input deskripsi
    await page.fill(
        'textarea[name="deskripsi"]',
        "Detail singkat konsultasi proyek palet",
    );
    // Isi input tanggal meeting (besok agar tidak lewat)
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tanggal = tomorrow.toISOString().slice(0, 16);
    await page.fill('input[name="start_time"]', tanggal);
    // Pilih durasi 30 menit
    await page.selectOption('select[name="durasi"]', "30");
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
        page.getByText("Jadwal Pertemuan berhasil dikirim"),
    ).toBeVisible({ timeout: 10000 });
});

// Test 3: Cek apakah pengajuan gagal jika judul kosong
test("pengajuan meeting gagal judul kosong", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman meeting
    await page.goto("http://localhost:8000/client/meeting-request", {
        timeout: 60000,
    });
    // Biarkan input judul kosong
    // Isi input deskripsi
    await page.fill('textarea[name="deskripsi"]', "Detail singkat");
    // Isi input tanggal meeting
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tanggal = tomorrow.toISOString().slice(0, 16);
    await page.fill('input[name="start_time"]', tanggal);
    // Pilih durasi
    await page.selectOption('select[name="durasi"]', "15");
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
    await expect(page.getByText("Judul meeting wajib diisi.")).toBeVisible();
});

// Test 4: Cek apakah pengajuan gagal jika deskripsi kosong
test("pengajuan meeting gagal deskripsi kosong", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman meeting
    await page.goto("http://localhost:8000/client/meeting-request", {
        timeout: 60000,
    });
    // Isi input judul
    await page.fill('input[name="judul"]', "Konsultasi Proyek");
    // Biarkan deskripsi kosong
    // Isi input tanggal meeting
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tanggal = tomorrow.toISOString().slice(0, 16);
    await page.fill('input[name="start_time"]', tanggal);
    // Pilih durasi
    await page.selectOption('select[name="durasi"]', "15");
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
    await expect(page.getByText("Deskripsi wajib diisi.")).toBeVisible();
});

// Test 5: Cek apakah pengajuan gagal jika tanggal sudah lewat
test("pengajuan meeting gagal tanggal sudah lewat", async ({ page }) => {
    // Tambah timeout 2 menit
    test.setTimeout(120000);
    // Buka halaman meeting
    await page.goto("http://localhost:8000/client/meeting-request", {
        timeout: 60000,
    });
    // Isi input judul
    await page.fill('input[name="judul"]', "Konsultasi Proyek");
    // Isi input deskripsi
    await page.fill('textarea[name="deskripsi"]', "Detail singkat");
    // Isi input tanggal yang sudah lewat (kemarin)
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    const tanggal = yesterday.toISOString().slice(0, 16);
    await page.fill('input[name="start_time"]', tanggal);
    // Pilih durasi
    await page.selectOption('select[name="durasi"]', "15");
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
        page.getByText(
            "Tanggal & waktu tidak boleh di hari/jam yang sudah lewat.",
        ),
    ).toBeVisible();
});

// Test 6: Cek apakah pengajuan gagal jika sudah 3 meeting hari ini
test("pengajuan meeting gagal maksimal 3 per hari", async ({ page }) => {
    // Tambah timeout 3 menit karena ada loop 3x submit
    test.setTimeout(180000);
    // Buka halaman meeting
    await page.goto("http://localhost:8000/client/meeting-request", {
        timeout: 60000,
    });
    // Buat 3 meeting terlebih dahulu
    for (let i = 0; i < 3; i++) {
        await page.fill('input[name="judul"]', `Meeting Test ${i + 1}`);
        await page.fill(
            'textarea[name="deskripsi"]',
            `Deskripsi test ${i + 1}`,
        );
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1 + i);
        const tanggal = tomorrow.toISOString().slice(0, 16);
        await page.fill('input[name="start_time"]', tanggal);
        await page.selectOption('select[name="durasi"]', "15");
        // Hapus onclick handler setiap iterasi
        await page.evaluate(() => {
            const button = document.querySelector('button[type="submit"]');
            button.removeAttribute("onclick");
        });
        await page.click('button[type="submit"]');
        await page.waitForLoadState("load");
    }
    // Coba ajukan meeting ke-4
    await page.fill('input[name="judul"]', "Meeting Test 4");
    await page.fill('textarea[name="deskripsi"]', "Deskripsi test 4");
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 4);
    const tanggal = tomorrow.toISOString().slice(0, 16);
    await page.fill('input[name="start_time"]', tanggal);
    await page.selectOption('select[name="durasi"]', "15");
    await page.evaluate(() => {
        const button = document.querySelector('button[type="submit"]');
        button.removeAttribute("onclick");
    });
    await page.click('button[type="submit"]');
    await page.waitForLoadState("load");
    // Cek apakah pesan error maksimal muncul
    await expect(
        page.getByText("Maksimal 3 pengajuan meeting per hari."),
    ).toBeVisible();
});
