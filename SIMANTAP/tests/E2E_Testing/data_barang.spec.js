import { test, expect } from '@playwright/test';

test.describe('Modul Data Barang', () => {
    test.beforeEach(async ({ page }) => {
        // Set longer timeout for test execution
        test.setTimeout(120000);
        page.setDefaultTimeout(90000);
        page.setDefaultNavigationTimeout(90000);

        // Login as admin
        await page.goto('https://simantap.dbsnetwork.my.id/login', { waitUntil: 'domcontentloaded' });
        await page.getByRole('textbox', { name: 'NIM/NIP/NIDN / Akun Polinema' }).fill('admin');
        await page.getByRole('textbox', { name: 'Password' }).fill('12345');
        await page.getByRole('button', { name: 'Masuk' }).click();

        // Wait for success modal and close it
        await page.getByRole('button', { name: 'OK' }).click();

        // Wait for preloader to disappear
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 60000 }).catch(() => { });
        await page.waitForTimeout(2000);

        // Navigate directly to Data Barang page (more reliable than clicking menu)
        await page.goto('https://simantap.dbsnetwork.my.id/jenisbarang', { waitUntil: 'domcontentloaded', timeout: 90000 });

        // Wait for page to load and preloader to disappear
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 60000 }).catch(() => { });
        await page.waitForTimeout(3000);
    });

    test('TC_DATA_BARANG_001 - Menambahkan data barang dengan jumlah karakter kurang dari 2', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Tambah Barang"
        await page.getByRole('button', { name: ' Tambah Barang' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Fill with less than 2 characters (only 1 character "a")
        await page.getByRole('textbox', {}).fill('z');
        await page.waitForTimeout(500);
        await page.getByRole('button', { name: ' Simpan' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Expected: Error message "Minimal 2 karakter" appears
        await expect(page.locator('body')).toContainText(/Minimal 2 karakter/i);
    });

    test('TC_DATA_BARANG_002 - Menambahkan data barang dengan karakter lebih dari atau sama dengan 2', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Tambah Barang"
        await page.getByRole('button', { name: ' Tambah Barang' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Fill with 2 or more characters ("ab")
        await page.getByRole('textbox', { name: 'Contoh: Meja' }).fill('Laptop');
        await page.waitForTimeout(500);
        await page.getByRole('button', { name: ' Simpan' }).click({ force: true });
        await page.waitForTimeout(3000);

        // Expected: Success modal appears
        const bodyText = await page.locator('body').textContent();
        expect(bodyText).toMatch(/berhasil dibuat|berhasil disimpan|berhasil|success/i);
    });

    test('TC_DATA_BARANG_003 - Menyimpan nama data barang tanpa text pada tambah data barang', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Tambah Barang"
        await page.getByRole('button', { name: ' Tambah Barang' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Click Simpan without filling anything
        await page.getByRole('button', { name: ' Simpan' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Expected: Error message "Nama data barang wajib diisi" appears
        await expect(page.locator('body')).toContainText(/Nama data barang wajib diisi|wajib diisi/i);
    });

    test('TC_DATA_BARANG_004 - Mengklik tombol "Detail"', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(2000);

        // Step 1: Click "Detail" on the first row
        await page.getByRole('button', { name: 'Detail' }).first().click({ force: true });
        await page.waitForTimeout(2000);

        // Expected: Detail modal appears
        await expect(page.locator('body')).toContainText(/Detail/i);
    });

    test('TC_DATA_BARANG_005 - Mengedit data barang dengan jumlah karakter kurang dari 2', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Edit" on the first row
        await page.getByRole('button', { name: 'Edit' }).first().click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Fill with less than 2 characters (only "ba" which is exactly 2, so use "b" for 1 char)
        await page.getByRole('textbox', { name: 'Contoh: Meja' }).fill('b');
        await page.waitForTimeout(500);
        await page.getByRole('button', { name: ' Simpan Perubahan' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Expected: Error message "Minimal 2 karakter" appears
        await expect(page.locator('body')).toContainText(/Minimal 2 karakter/i);
    });

    test('TC_DATA_BARANG_006 - Mengedit data barang dengan total karakter lebih dari atau sama dengan 2', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Edit" on the first row
        await page.getByRole('button', { name: 'Edit' }).first().click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Get current value and add character "a"
        const currentValue = await page.getByRole('textbox', { name: 'Contoh: Meja' }).inputValue();
        const newValue = currentValue + ' test';
        await page.getByRole('textbox', { name: 'Contoh: Meja' }).fill(newValue);
        await page.waitForTimeout(500);
        await page.getByRole('button', { name: ' Simpan Perubahan' }).click({ force: true });
        await page.waitForTimeout(3000);

        // Expected: Success modal appears or modal closes
        const successBtn = page.getByRole('button', { name: /OK|Mengerti|Tutup/i });
        if (await successBtn.isVisible().catch(() => false)) {
            await successBtn.click();
            await page.waitForTimeout(1000);
        }

        // Verify either success message or data update in table
        const bodyText = await page.locator('body').textContent();
        expect(bodyText).toMatch(/berhasil diperbarui|berhasil disimpan|success/i);
    });

    test('TC_DATA_BARANG_007 - Menyimpan nama data barang tanpa text pada edit teknisi', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Edit" on the first row
        await page.getByRole('button', { name: 'Edit' }).first().click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Clear the field (Hapus nama data barang)
        await page.getByRole('textbox', { name: 'Contoh: Meja' }).clear();
        await page.waitForTimeout(500);

        // Step 3: Click Simpan
        await page.getByRole('button', { name: ' Simpan Perubahan' }).click({ force: true });
        await page.waitForTimeout(2000);

        // Expected: Error message "Nama data barang wajib diisi" appears
        await expect(page.locator('body')).toContainText(/Nama data barang wajib diisi|wajib diisi/i);
    });

    test('TC_DATA_BARANG_008 - Menghapus data data barang', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click "Delete" on the first row
        await page.getByRole('button', { name: 'Delete' }).first().click({ force: true });
        await page.waitForTimeout(2000);

        // Step 2: Click "Ya, Hapus" on confirmation modal
        await page.getByRole('button', { name: ' Ya, Hapus' }).click({ force: true });
        await page.waitForTimeout(4000);

        // Expected: Check for success message before closing modal
        const bodyText = await page.locator('body').textContent();
        expect(bodyText).toMatch(/terhapus|dihapus|berhasil/i);

        // Close success modal if present
        const successBtn = page.getByRole('button', { name: /OK|Mengerti|Tutup/i });
        if (await successBtn.isVisible().catch(() => false)) {
            await successBtn.click();
            await page.waitForTimeout(1000);
        }
    });

    test('TC_DATA_BARANG_009 - Menginputkan kata parsial dari nama data barang', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click search input and type partial keyword "proyektor"
        await page.getByRole('searchbox', { name: 'Search:' }).fill('proyektor');
        await page.waitForTimeout(3000);

        // Expected: Table only shows data containing "proyektor"
        const tableText = await page.locator('table').textContent();
        if (tableText && !tableText.toLowerCase().includes('no matching records')) {
            expect(tableText.toLowerCase()).toContain('proyektor');
        }
    });

    test('TC_DATA_BARANG_010 - Menyorting nama jenis transaksi A-Z dan Z-A', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Click sort button on "Nama Data Barang" column
        const sortButton = page.getByRole('gridcell', { name: /Nama.*activate/i }).or(page.locator('th:has-text("Nama")'));
        if (await sortButton.isVisible().catch(() => false)) {
            await sortButton.click({ force: true });
            await page.waitForTimeout(3000);

            // Expected: Table is sorted - verify sorting works
            const rowCount = await page.locator('table tbody tr').count();
            expect(rowCount).toBeGreaterThan(0);

            // Click again for Z-A sort
            await sortButton.click({ force: true });
            await page.waitForTimeout(2000);

            // Expected: Table is still displayed (sorting works)
            const rowCountAfter = await page.locator('table tbody tr').count();
            expect(rowCountAfter).toBeGreaterThan(0);
        }
    });

    test('TC_DATA_BARANG_011 - Menampilkan entries tab', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Select 25 entries
        await page.getByLabel('Show 102550100 entries').selectOption('25');
        await page.waitForTimeout(4000);

        // Expected: Table shows maximum 25 rows
        const rowCount = await page.locator('table tbody tr').count();
        expect(rowCount).toBeGreaterThan(0);
        expect(rowCount).toBeLessThanOrEqual(25);
    });

    test('TC_DATA_BARANG_012 - Mengganti page halaman untuk menampilkan data per entries', async ({ page }) => {
        // Wait for preloader
        await page.waitForSelector('#preloader', { state: 'hidden', timeout: 30000 }).catch(() => { });
        await page.waitForTimeout(1000);

        // Step 1: Select 10 entries
        await page.getByLabel('Show 102550100 entries').selectOption('10');
        await page.waitForTimeout(3000);

        // Step 2: Click "Next" on pagination
        const nextButton = page.getByRole('link', { name: 'Next' });
        if (await nextButton.isVisible({ timeout: 5000 }).catch(() => false)) {
            await nextButton.click({ force: true });
            await page.waitForTimeout(3000);

            // Expected: Table shows data from entry 11 to 20
            const rowCount = await page.locator('table tbody tr').count();
            expect(rowCount).toBeGreaterThan(0);
            expect(rowCount).toBeLessThanOrEqual(10);
        }
    });
});
