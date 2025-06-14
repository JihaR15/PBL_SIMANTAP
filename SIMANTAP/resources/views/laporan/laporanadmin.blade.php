<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Admin</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .d-block {
            display: block;
        }

        img.image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }



        .table-summary td,
        .table-teknisi td,
        .table-teknisi th {
            padding: 4px 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgOk1o9DKh__qOFazj2DSIJx7nP6Ei4C_eHA&s" class="image">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN
                    TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341)
                    404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN ADMIN SARPRAS ({{ $periode_terpilih->nama_periode ?? 'Semua' }})</h3>

    <div style="width: 100%;" >
        {{-- Tabel Rangkuman Kiri --}}
        <table class="table-summary" style="float: left; width: 48%;">
            <tr>
                <td colspan="2"><strong>Rangkuman Laporan</strong></td>
            </tr>
            <tr>
                <td>Total Laporan</td>
                <td>: {{ $totalLaporan }}</td>
            </tr>
            <tr>
                <td>Jumlah Diverifikasi</td>
                <td>: {{ $jumlahVerif }}</td>
            </tr>
            <tr>
                <td>Jumlah Ditolak</td>
                <td>: {{ $jumlahTolak }}</td>
            </tr>
            <tr>
                <td>Jumlah Belum Diverifikasi</td>
                <td>: {{ $jumlahBelum }}</td>
            </tr>
            <tr>
                <td>Jumlah Perbaikan Selesai</td>
                <td>: {{ $jumlahPerbaikanSelesai }}</td>
            </tr>
            <tr>
                <td><strong>Total Biaya Perbaikan</strong></td>
                <td><strong>: Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td><strong>Fasilitas Paling Sering Dilaporkan</strong></td>
                <td><strong>: {{ $fasilitasTerbanyak }}</strong></td>
            </tr>
            <tr>
                <td><strong>Tempat Paling Banyak Laporan</strong></td>
                <td><strong>: {{ $tempatTerbanyak }}</strong></td>
            </tr>
        </table>

        {{-- Tabel Teknisi Kanan --}}
        <table class="table-teknisi" style="float: right; width: 48%;">
            <thead>
                <tr>
                    <th>Nama Teknisi</th>
                    <th>Jumlah Perbaikan</th>
                    <th>Jumlah Selesai</th>
                    <th>Total Biaya (Rp)</th>
                    <th>Rating (Avg)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teknisiStats as $namaTeknisi => $stat)
                    <tr>
                        <td>{{ $namaTeknisi }}</td>
                        <td>{{ $stat['jumlah_perbaikan'] }}</td>
                        <td>{{ $stat['jumlah_selesai'] }}</td>
                        <td>{{ number_format($stat['total_biaya'], 0, ',', '.') }}</td>
                        <td>{{  $stat['rata_rata_rating'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>

            <tr>
                <th colspan="5" class="text-center">Total Fasilitas</th>
            </tr>
            <thead>
                <tr>
                    <th>Ket.</th>
                    <th>Fasilitas</th>
                    <th>Rusak</th>
                    <th>Sudah Diperbaiki</th>
                    <th>Belum Diperbaiki</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total :</td>
                    <td>{{ isset($totalFasilitasTersedia) && $totalFasilitasTersedia !== null ? $totalFasilitasTersedia : '-' }}</td>
                    <td>{{ isset($totalFasilitasRusak) && $totalFasilitasRusak !== null ? $totalFasilitasRusak : '-' }}</td>
                    <td>{{ isset($totalFasilitasSudahDiperbaiki) && $totalFasilitasSudahDiperbaiki !== null ? $totalFasilitasSudahDiperbaiki : '-' }}</td>
                    <td>{{ isset($totalFasilitasBelumDiperbaiki) && $totalFasilitasBelumDiperbaiki !== null ? $totalFasilitasBelumDiperbaiki : '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="clear: both;"></div>

    <table class="table-teknisi" style="margin-top: 10px">
        <thead>
                <tr>
                    <th>Nama Verifikator</th>
                    <th>Jumlah Verifikasi</th>
                    <th>Diverifikasi</th>
                    <th>Ditolak</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($verifikatorStats as $namaVerifikator => $stat)
                    <tr>
                        <td>{{ $namaVerifikator }}</td>
                        <td>{{ $stat['total_dilaporkan'] }}</td>
                        <td>{{ $stat['jumlah_diverifikasi'] }}</td>
                        <td>{{ $stat['jumlah_ditolak'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
    </table>

    <table class="border-all" style="margin-top: 10px">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tempat</th>
                <th>Fasilitas</th>
                <th>Rusak</th>
                <th>Tanggal dibuat</th>
                <th>Tanggal Diverif</th>
                <th>Status Verifikasi</th>
                <th>Verifikator</th>
                <th>Teknisi</th>
                <th>Status Perbaikan</th>
                <th>Tanggal Selesai</th>
                <th>Rating</th>
                <th class="text-right">Biaya</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($laporan as $l)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $l->tempat->nama_tempat }}</td>
                    <td>{{ $l->barangLokasi->jenisBarang->nama_barang ?? '-' }}</td>
                    <td>{{ $l->jumlah_barang_rusak ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($l->created_at)->locale('id')->translatedFormat('d F Y') ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($l->updated_at)->locale('id')->translatedFormat('d F Y') ?? '-' }}</td>

                    <td>{{ $l->status_verif ?? '-' }}</td>
                    <td>{{ $l->verifikator->name ?? '-' }}</td>
                    <td>{{ $l->perbaikan->teknisi->user->name ?? '-' }}</td>
                    <td>{{ $l->perbaikan->status_perbaikan ?? '-' }}</td>
                    <td>{{ optional($l->perbaikan)->selesai_pada ? \Carbon\Carbon::parse($l->perbaikan->selesai_pada)->locale('id')->translatedFormat('d F Y') : '-' }}
                    </td>
                    
                    <td>{{ $l->feedback->first()?->rating_id ?? '-' }} </td>
                    <td class="text-right">
                        {{ isset($l->perbaikan->biaya) ? number_format($l->perbaikan->biaya, 0, ',', '.') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>