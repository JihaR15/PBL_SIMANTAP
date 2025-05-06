<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

<!-- jquery.vectormap map -->
<script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const bootstrapStyle = document.getElementById('bootstrap-style');
        const appStyle = document.getElementById('app-style');

        // Fungsi untuk mengatur tema
        const setTheme = (theme) => {
            if (theme === 'dark') {
                bootstrapStyle.setAttribute('href', 'assets/css/bootstrap-dark.min.css');
                appStyle.setAttribute('href', 'assets/css/app-dark.min.css');
                themeIcon.classList.remove('ri-sun-line');
                themeIcon.classList.add('ri-moon-line');
            } else {
                bootstrapStyle.setAttribute('href', 'assets/css/bootstrap.min.css');
                appStyle.setAttribute('href', 'assets/css/app.min.css');
                themeIcon.classList.remove('ri-moon-line');
                themeIcon.classList.add('ri-sun-line');
            }
            localStorage.setItem('theme', theme); // Simpan preferensi tema di localStorage
        };

        // Deteksi preferensi tema perangkat
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // Periksa apakah ada preferensi tema yang disimpan di localStorage
        const savedTheme = localStorage.getItem('theme');

        if (savedTheme) {
            setTheme(savedTheme); // Gunakan tema yang disimpan
        } else {
            setTheme(systemPrefersDark ? 'dark' : 'light'); // Gunakan preferensi perangkat
        }

        // Tambahkan event listener untuk tombol toggle tema
        themeToggle.addEventListener('click', () => {
            const currentTheme = localStorage.getItem('theme') || (systemPrefersDark ? 'dark' : 'light');
            setTheme(currentTheme === 'dark' ? 'light' : 'dark'); // Toggle tema
        });

        // Setelah tema diterapkan, tampilkan halaman
        document.body.style.visibility = 'visible';
    });
</script>
