<x-app-layouts title="Manajemen Antrian Pasien">
    <div class="container-fluid px-0 px-md-2">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
            <div>
                <h4 class="fw-semibold mb-1">
                    Manajemen Antrian Pasien
                </h4>
                <p class="text-muted mb-0" style="font-size: .9rem;">
                    Panel admin untuk memantau dan mengatur antrian pasien pada hari tertentu.
                </p>
            </div>
            <div class="text-end">
                <span class="badge bg-light text-muted border">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
                <div class="small text-muted mt-1">
                    Data antrian per tanggal:
                    <strong>{{ \Illuminate\Support\Carbon::parse($tanggal)->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>

        {{-- Filter card --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body py-3">
                <form id="filterForm" method="GET" action="{{ route('admin.antrian.index') }}"
                    class="d-flex flex-wrap align-items-end gap-3">

                    {{-- Tanggal --}}
                    <div>
                        <label for="tanggal" class="form-label mb-1 fw-semibold" style="font-size: .85rem;">
                            Tanggal
                        </label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}"
                            class="form-control form-control-sm" style="min-width: 180px;">
                    </div>

                    {{-- Poli --}}
                    <div>
                        <label for="poli_id" class="form-label mb-1 fw-semibold" style="font-size: .85rem;">
                            Poli
                        </label>

                        <div class="position-relative">
                            <select name="poli_id" id="poli_id" class="form-select form-select-sm poli-select"
                                style="min-width: 200px;">
                                <option value="">Semua Poli</option>
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}" @selected($poliId == $poli->id)>
                                        {{ $poli->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="ms-auto d-flex align-items-end gap-2">
                        <button class="btn btn-sm btn-primary d-flex align-items-center gap-1" type="submit"
                            title="Terapkan filter">
                            <i class="fas fa-filter"></i>
                            <span>Terapkan</span>
                        </button>

                        @if ($poliId || $tanggal !== now()->toDateString())
                            <a href="{{ route('admin.antrian.index') }}"
                                class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                                title="Reset filter">
                                <i class="fas fa-undo-alt"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <small>{{ session('success') }}</small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <small>{{ session('error') }}</small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        {{-- Card tabel antrian --}}
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center py-2">
                <div>
                    <span class="fw-semibold">Daftar Antrian</span>
                    <span class="text-muted small d-block">
                        Tanggal: <strong>{{ \Illuminate\Support\Carbon::parse($tanggal)->format('d/m/Y') }}</strong>
                    </span>
                </div>
                <div class="text-end small text-muted">
                    Total: <strong>{{ $antrians->count() }}</strong> pasien
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 40px;">#</th>
                                <th>Poli</th>
                                <th style="width: 80px;">Loket</th>
                                <th>Nama Pasien</th>
                                <th class="text-center" style="width: 90px;">No. Antrian</th>
                                <th class="text-center" style="width: 110px;">Pembayaran</th>
                                <th class="text-center" style="width: 130px;">Status</th>
                                <th class="text-center" style="width: 100px;">Estimasi</th>
                                <th class="text-end" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($antrians as $index => $item)
                                @php
                                    $rowClass = $item->status === 'dipanggil' ? 'table-info' : '';
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td class="text-center">
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        {{ $item->poli?->nama_poli }}
                                    </td>
                                    <td>
                                        {{ $item->poli?->loket ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $item->nama_pasien }}
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold">{{ $item->nomor_antrian }}</span>
                                    </td>
                                    <td class="text-center text-uppercase">
                                        <span class="badge bg-secondary-subtle text-dark px-2">
                                            {{ $item->jenis_pembayaran }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusLabel = ucfirst($item->status);
                                            $badgeClass = match ($item->status) {
                                                'menunggu' => 'bg-warning text-dark',
                                                'dipanggil' => 'bg-info text-dark',
                                                'selesai' => 'bg-success',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-3">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->estimasi_waktu)
                                            <span class="small">
                                                {{ $item->estimasi_waktu->format('H:i') }} WIB
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if ($item->status !== 'selesai')
                                            <form method="POST" action="{{ route('admin.antrian.panggil', $item) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-primary mb-1 d-inline-flex align-items-center gap-1">
                                                    <i class="fas fa-bullhorn"></i>
                                                    <span>Panggil</span>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.antrian.selesai', $item) }}"
                                                class="d-inline"
                                                onsubmit="return confirm('Tandai nomor ini sebagai selesai?')">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-success mb-1 d-inline-flex align-items-center gap-1">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Selesai</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">
                                                Sudah selesai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        Belum ada antrian untuk tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Legend status kecil di footer --}}
            <div class="card-footer bg-light small text-muted">
                <span class="me-3">
                    <span class="badge bg-warning text-dark me-1">&nbsp;</span> Menunggu
                </span>
                <span class="me-3">
                    <span class="badge bg-info text-dark me-1">&nbsp;</span> Dipanggil
                </span>
                <span>
                    <span class="badge bg-success me-1">&nbsp;</span> Selesai
                </span>
            </div>
        </div>

        <div class="text-center text-muted small mt-3">
            Admin Antrian Klinik &middot; Laravel
        </div>
    </div>
</x-app-layouts>

<style>
    /* Dropdown poli – versi modern */
    .poli-select {
        border: 1px solid #d1d5db !important;
        border-radius: 10px !important;
        padding: 6px 10px !important;
        font-size: 0.85rem !important;
        background-color: white !important;
        transition: all 0.15s ease-in-out;
    }

    /* Saat hover */
    .poli-select:hover {
        border-color: #9ca3af !important;
        /* abu lebih gelap */
    }

    /* Saat fokus (on click) */
    .poli-select:focus {
        border-color: #2563eb !important;
        /* biru */
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
    }

    /* Dropdown list saat dibuka (Chrome, Edge) */
    select.poli-select:focus-visible {
        outline: none !important;
    }
</style>
