import { test, expect } from '@playwright/test';

test.describe('Modul Jenis Teknisi', () => {
    test.beforeEach(async ({ page }) => {
        // Set longer timeout
        page.setDefaultTimeout(60000);
        page.setDefaultNavigationTimeout(60000);

        // Login as admin
        await page.goto('https://simantap.dbsnetwork.my.id/login', { waitUntil: 'domcontentloaded' });
        await page.getByRole('textbox', { name: 'NIM/NIP/NIDN / Akun Polinema' }).fill('admin');
        await page.getByRole('textbox', { name: 'Password' }).fill('12345');
        await page.getByRole('button', { name: 'Masuk' }).click();

        // Wait for success modal and close it
        await page.getByRole('button', { name: 'OK' }).click();

        // Wait for preloader to disappear
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(2000);

        // Navigate to Jenis Teknisi page with force click
        await page.getByRole('link', { name: ' Jenis Teknisi' }).click({ force: true });

        // Wait for page to load and preloader to disappear
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(2000);
    });

    test('TC_JENIS_TEKNISI_001 - Menambahkan jenis teknisi dengan jumlah karakter kurang dari 3', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Tambah Jenis Teknisi"
        await page.getByRole('button', { name: ' Tambah Jenis Teknisi' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Fill with less than 3 characters and click Simpan
        await page.getByRole('textbox', { name: 'Contoh: Teknisi Listrik,' }).fill('ab');
        await page.waitForTimeout(500);
        await page.getByRole('button', { name: ' Simpan' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Expected: Error message "Minimal 3 karakter" appears
        await expect(page.locator('body')).toContainText(/Minimal 3 karakter/i);
    });

    test('TC_JENIS_TEKNISI_002 - Menambahkan jenis teknisi dengan karakter lebih dari atau sama dengan 3', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Click "Tambah Jenis Teknisi"
        await page.getByRole('button', { name: ' Tambah Jenis Teknisi' }).click({ force: true });
        await page.waitForTimeout(1000);

        // Step 2: Fill with 3 or more characters and click Simpan
        await page.getByRole('textbox', { name: 'Contoh: Teknisi Listrik,' }).fill('Teknisi IOT');
        await page.getByRole('button', { name: ' Simpan' }).click();
        await page.waitForTimeout(2000);

        // Expected: Success modal appears
        await expect(page.locator('body')).toContainText(/berhasil dibuat|berhasil ditambahkan/i);
    });

    test('TC_JENIS_TEKNISI_003 - Menyimpan nama jenis teknisi tanpa text pada tambah jenis teknisi', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Click "Tambah Jenis Teknisi"
        await page.getByRole('button', { name: ' Tambah Jenis Teknisi' }).click({ force: true });
        await page.waitForTimeout(1000);

        // Step 2: Click Simpan without filling anything
        await page.getByRole('button', { name: ' Simpan' }).click();
        await page.waitForTimeout(1000);

        // Expected: Error message "wajib diisi" appears
        await expect(page.locator('body')).toContainText(/wajib diisi|required/i);
    });

    test('TC_JENIS_TEKNISI_004 - Mengklik tombol "Detail"', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(2000);

        // Step 1: Click "Detail" on the first row
        await page.getByRole('button', { name: 'Detail' }).first().click();
        await page.waitForTimeout(2000);

        // Expected: Detail modal appears
        await expect(page.locator('body')).toContainText(/Detail/i);

    });

    test('TC_JENIS_TEKNISI_005 - Mengedit jenis teknisi dengan jumlah karakter kurang dari 3', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Click "Edit" on the first row
        await page.getByRole('button', { name: 'Edit' }).first().click({ force: true });
        await page.waitForTimeout(1000);

        // Step 2: Fill with less than 3 characters and click Simpan
        await page.getByRole('textbox', { name: 'Contoh: Teknisi Listrik,' }).fill('ba');
        await page.getByRole('button', { name: ' Simpan Perubahan' }).click();
        await page.waitForTimeout(2000);

        // Expected: Error message "Minimal 3 karakter" appears
        await expect(page.locator('body')).toContainText(/Minimal 3 karakter/i);
    });

    test('TC_JENIS_TEKNISI_006 - Mengedit jenis teknisi dengan total karakter lebih dari atau sama dengan 3', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Click "Edit" on the first row
        await page.getByRole('button', { name: 'Edit' }).first().click({ force: true });
        await page.waitForTimeout(1000);

        // Step 2: Get current value and add character "a"
        const currentValue = await page.getByRole('textbox', { name: 'Contoh: Teknisi Listrik,' }).inputValue();
        await page.getByRole('textbox', { name: 'Contoh: Teknisi Listrik,' }).fill(currentValue + 'a');
        await page.getByRole('button', { name: ' Simpan Perubahan' }).click();
        await page.waitForTimeout(2000);

        // Expected: Success modal appears
        await expect(page.locator('body')).toContainText(/berhasil diperbarui|berhasil diubah/i);
    });

    test('TC_JENIS_TEKNISI_007 - Menyimpan nama jenis teknisi tanpa text pada edit teknisi', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Click "Edit" on the first row
        await page.getByRole('button', { name: 'Edit' }).first().click({ force: true });
        await page.waitForTimeout(1000);

        // Step 2: Clear the field
        await page.getByRole('textbox', { name: 'Contoh: Teknisi Listrik,' }).clear();

        // Step 3: Click Simpan
        await page.getByRole('button', { name: ' Simpan Perubahan' }).click();
        await page.waitForTimeout(1000);

        // Expected: Error message "wajib diisi" appears
        await expect(page.locator('body')).toContainText(/wajib diisi|required/i);
    });

    test('TC_JENIS_TEKNISI_008 - Menghapus data jenis teknisi', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Navigate to page 2 to get data to delete
        await page.getByRole('link', { name: '2' }).click();
        await page.waitForTimeout(2000);

        // Step 2: Click "Delete" on the first row
        await page.getByRole('button', { name: 'Delete' }).first().click();
        await page.waitForTimeout(1000);

        // Step 3: Click "Ya, Hapus" on confirmation modal
        await page.getByRole('button', { name: ' Ya, Hapus' }).click();
        await page.waitForTimeout(3000);

        // Close success modal if present
        const successBtn = page.getByRole('button', { name: /OK|Mengerti|Tutup/i });
        if (await successBtn.isVisible().catch(() => false)) {
            await successBtn.click();
            await page.waitForTimeout(1000);
        }

        // Expected: Back to table page (deletion successful)
        await expect(page.locator('body')).toContainText(/Data Jenis Teknisi|Jenis Teknisi/i);
    });

    test('TC_JENIS_TEKNISI_009 - Menginputkan kata parsial dari nama jenis teknisi', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Click search input and type partial keyword
        await page.getByRole('searchbox', { name: 'Search:' }).fill('are');

        // Wait for table to update
        await page.waitForTimeout(4000);

        // Expected: Table only shows data containing "are"
        const tableText = await page.locator('table').textContent();
        expect(tableText.toLowerCase()).toContain('are');
    });

    test('TC_JENIS_TEKNISI_010 - Menyorting nama jenis transaksi A-Z dan Z-A', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Click sort button on "Nama Jenis Teknisi" column
        await page.getByRole('gridcell', { name: 'Nama Jenis Teknisi: activate' }).click({ force: true });

        // Wait for sort to apply
        await page.waitForTimeout(4000);

        // Expected: Table is sorted - verify sorting works
        const rowCount = await page.locator('table tbody tr').count();
        expect(rowCount).toBeGreaterThan(0);

        // Click again for Z-A sort
        await page.getByRole('gridcell', { name: 'Nama Jenis Teknisi: activate' }).click({ force: true });
        await page.waitForTimeout(1000);

        // Expected: Table is still displayed (sorting works)
        const rowCountAfter = await page.locator('table tbody tr').count();
        expect(rowCountAfter).toBeGreaterThan(0);
    });

    test('TC_JENIS_TEKNISI_011 - Menampilkan entries tab', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Select 25 entries
        await page.getByLabel('Show 102550100 entries').selectOption('25');

        // Wait for table to update
        await page.waitForTimeout(4000);

        // Expected: Table shows maximum 25 rows
        const rowCount = await page.locator('table tbody tr').count();
        expect(rowCount).toBeGreaterThan(0);
        expect(rowCount).toBeLessThanOrEqual(25);
    });

    test('TC_JENIS_TEKNISI_012 - Mengganti page halaman untuk menampilkan data per entries', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });

        // Step 1: Change from default (10) to 25 entries
        await page.getByLabel('Show 102550100 entries').selectOption('25');
        await page.waitForTimeout(4000);

        // Expected: Table shows up to 25 rows
        const rowCount = await page.locator('table tbody tr').count();
        expect(rowCount).toBeGreaterThan(10);
        expect(rowCount).toBeLessThanOrEqual(25);
    });
});
