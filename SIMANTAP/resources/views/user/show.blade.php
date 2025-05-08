<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row align-items-center">
                <div class="col-12 col-md-auto text-center mb-3 mb-md-0">
                    <img src="{{ $user->foto_profile ? asset('images/' . $user->foto_profile) : asset('profile_placeholder.png') }} ? {{ now() }}"
                        alt="Foto Profil" class="rounded-circle img-fluid"
                        style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <div class="col-12 col-md">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td style="width: 150px;"><strong>ID</strong></td>
                            <td>: {{ $user->user_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Role</strong></td>
                            <td>: {{ $user->role->nama_role }}</td>
                        </tr>
                        @if ($user->role->nama_role === 'Teknisi')
                            <tr>
                                <td><strong>Jenis Teknisi</strong></td>
                                <td>: {{ $user->teknisi->jenis_teknisi->nama_jenis_teknisi }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Username</strong></td>
                            <td>: {{ $user->username }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>: {{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Password</strong></td>
                            <td>: ********</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>