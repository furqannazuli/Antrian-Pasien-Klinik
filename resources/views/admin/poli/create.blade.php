<x-app-layouts title="Tambah Poli">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Poli</h5>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 0.9rem;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.poli.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_poli" class="form-label">Nama Poli</label>
                    <input type="text" name="nama_poli" id="nama_poli"
                        class="form-control @error('nama_poli') is-invalid @enderror" value="{{ old('nama_poli') }}"
                        required>
                    @error('nama_poli')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="loket" class="form-label">Loket</label>
                    <input type="text" name="loket" id="loket"
                        class="form-control @error('loket') is-invalid @enderror" value="{{ old('loket') }}"
                        placeholder="Contoh: Loket 1">
                    @error('loket')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="text-muted">Opsional. Isi nomor / nama loket untuk poli ini.</small>
                </div>


                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('admin.poli.index') }}" class="btn btn-outline-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layouts>
