<x-app-layouts title="Dashboard">
    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Dashboard Admin</h4>
            <small class="text-muted">
                Ringkasan antrian pasien tanggal <strong>{{ $tanggalHuman }}</strong>
            </small>
        </div>

        <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
            <div>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control"
                    style="min-width: 160px;">
            </div>
            <button class="btn btn-outline-primary btn-sm" type="submit">
                Ganti Tanggal
            </button>
        </form>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Total Antrian Hari Ini</div>
                    <div class="fs-3 fw-bold">{{ $totalHariIni }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Sedang Menunggu</div>
                    <div class="fs-3 fw-bold text-warning">{{ $menungguHariIni }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Sedang Dipanggil</div>
                    <div class="fs-3 fw-bold text-info">{{ $dipanggilHariIni }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Selesai</div>
                    <div class="fs-3 fw-bold text-success">{{ $selesaiHariIni }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-wrap gap-2">
                <a href="{{ route('admin.antrian.index') }}" class="btn btn-primary">
                    Kelola Antrian Pasien
                </a>
                <a href="{{ route('admin.poli.index') }}" class="btn btn-outline-primary">
                    Kelola Data Poli
                </a>
            </div>
        </div>
    </div>

    {{-- Tabel ringkasan per poli --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Ringkasan Antrian per Poli</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Poli</th>
                        <th>Total</th>
                        <th>Menunggu</th>
                        <th>Dipanggil</th>
                        <th>Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statsByPoli as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->poli?->nama_poli ?? '-' }}</td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->menunggu }}</td>
                            <td>{{ $row->dipanggil }}</td>
                            <td>{{ $row->selesai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada antrian untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layouts>
