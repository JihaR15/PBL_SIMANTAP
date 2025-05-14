<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title">Profil Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row justify-content-center mb-3">
                <!-- Foto Profil -->
                <div class="col-md-4">
                    <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }}?{{ now() }}"
                        alt="Foto Profil"
                        class="img-thumbnail rounded-circle shadow"
                        style="width: 150px; height: 150px; object-fit: cover;">
                </div>
            </div>
            <!-- Data Pengguna -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <tr>
                            <th>Role</th>
                            <td>{{ $user->role->nama_role ?? 'Tidak ada role' }}</td> <!-- Menampilkan nama_role jika ada -->
                        </tr>
                        @if ($user->role->nama_role === 'Teknisi')
                            <tr>
                                <th>Jenis Teknisi</th>
                                <td>{{ $user->teknisi->jenis_teknisi->nama_jenis_teknisi }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>********</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer justify-content-between">
            <button onclick="modalAction('{{ url('profile/edit') }}')" class="btn btn-primary" data-dismiss="modal" id="btn-edit-profile">Edit Profil</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
