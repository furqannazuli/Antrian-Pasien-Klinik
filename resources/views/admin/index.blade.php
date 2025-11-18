<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Antrian - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background:#f3f4f6;">

<div style="max-width:1024px;margin:24px auto;padding:0 16px;">
    <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
        <div>
            <h1 style="font-size:22px;font-weight:700;margin:0;">Manajemen Antrian Pasien</h1>
            <p style="font-size:13px;color:#6b7280;margin:4px 0 0;">
                Panel admin untuk memantau dan mengatur antrian hari ini.
            </p>
        </div>
        <div style="font-size:13px;color:#4b5563;">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </header>

    {{-- Flash message --}}
    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:10px 12px;border-radius:8px;font-size:14px;margin-bottom:14px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fee2e2;color:#b91c1c;padding:10px 12px;border-radius:8px;font-size:14px;margin-bottom:14px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.antrian.index') }}"
          style="margin-bottom:16px;padding:10px 12px;border-radius:12px;background:white;display:flex;flex-wrap:wrap;gap:10px;align-items:center;box-shadow:0 8px 20px rgba(15,23,42,.08);">

        <div>
            <label for="tanggal" style="font-size:12px;color:#6b7280;display:block;margin-bottom:2px;">Tanggal</label>
            <input type="date"
                   id="tanggal"
                   name="tanggal"
                   value="{{ $tanggal }}"
                   style="padding:6px 8px;border-radius:8px;border:1px solid #d1d5db;font-size:13px;">
        </div>

        <div>
            <label for="poli_id" style="font-size:12px;color:#6b7280;display:block;margin-bottom:2px;">Poli</label>
            <select id="poli_id"
                    name="poli_id"
                    style="padding:6px 8px;border-radius:8px;border:1px solid #d1d5db;font-size:13px;min-width:160px;">
                <option value="">Semua Poli</option>
                @foreach($polis as $poli)
                    <option value="{{ $poli->id }}" {{ $poliId == $poli->id ? 'selected' : '' }}>
                        {{ $poli->nama_poli }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit"
                    style="margin-top:18px;padding:7px 12px;border:none;border-radius:9999px;background:#2563eb;color:white;font-size:13px;font-weight:600;cursor:pointer;">
                Terapkan Filter
            </button>
        </div>
    </form>

    {{-- Tabel antrian --}}
    <div style="background:white;border-radius:12px;box-shadow:0 10px 25px rgba(15,23,42,.08);overflow:hidden;">
        <div style="padding:10px 14px;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:14px;font-weight:600;">Daftar Antrian ({{ $tanggal }})</span>
            <span style="font-size:12px;color:#6b7280;">Total: {{ $antrians->count() }} pasien</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th style="text-align:left;padding:8px 10px;border-bottom:1px solid #e5e7eb;">No</th>
                        <th style="text-align:left;padding:8px 10px;border-bottom:1px solid #e5e7eb;">Poli</th>
                        <th style="text-align:left;padding:8px 10px;border-bottom:1px solid #e5e7eb;">Nama Pasien</th>
                        <th style="text-align:left;padding:8px 10px;border-bottom:1px solid #e5e7eb;">No Antrian</th>
                        <th style="text-align:left;padding:8px 10px;border-bottom:1px solid #e5e7eb;">Pembayaran</th>
                        <th style="text-align:left;padding:8px 10px;border-bottom:1px solid #e5e7eb;">Status</th>
                        <th style="text-align:left;padding:8px 10px;border-bottom:1px solid #e5e7eb;">Estimasi</th>
                        <th style="text-align:center;padding:8px 10px;border-bottom:1px solid #e5e7eb;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrians as $index => $item)
                        @php
                            $isDipanggil = $item->status === 'dipanggil';
                            $bg = $isDipanggil ? '#eff6ff' : 'transparent';
                        @endphp
                        <tr style="background:{{ $bg }};">
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;">
                                {{ $index + 1 }}
                            </td>
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;">
                                {{ $item->poli?->nama_poli }}
                            </td>
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;">
                                {{ $item->nama_pasien }}
                            </td>
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;font-weight:700;">
                                {{ $item->nomor_antrian }}
                            </td>
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;text-transform:uppercase;font-size:12px;">
                                {{ $item->jenis_pembayaran }}
                            </td>
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;">
                                @php
                                    $labelStatus = ucfirst($item->status);
                                @endphp
                                <span style="
                                    display:inline-flex;align-items:center;gap:4px;
                                    padding:2px 8px;border-radius:9999px;font-size:11px;
                                    @if($item->status === 'menunggu')
                                        background:#fef9c3;color:#854d0e;
                                    @elseif($item->status === 'dipanggil')
                                        background:#dbeafe;color:#1d4ed8;
                                    @else
                                        background:#dcfce7;color:#166534;
                                    @endif
                                ">
                                    {{ $labelStatus }}
                                </span>
                            </td>
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;">
                                @if($item->estimasi_waktu)
                                    {{ $item->estimasi_waktu->format('H:i') }} WIB
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding:7px 10px;border-bottom:1px solid #f3f4f6;text-align:center;">
                                <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                                    {{-- Tombol panggil --}}
                                    @if($item->status !== 'selesai')
                                        <form action="{{ route('admin.antrian.panggil', $item) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                    style="padding:4px 8px;border-radius:9999px;border:none;
                                                           background:#2563eb;color:white;font-size:11px;font-weight:600;cursor:pointer;">
                                                Panggil
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol selesai --}}
                                    @if($item->status !== 'selesai')
                                        <form action="{{ route('admin.antrian.selesai', $item) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                    style="padding:4px 8px;border-radius:9999px;border:none;
                                                           background:#16a34a;color:white;font-size:11px;font-weight:600;cursor:pointer;">
                                                Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span style="font-size:11px;color:#6b7280;">Sudah selesai</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:16px 10px;text-align:center;font-size:13px;color:#6b7280;">
                                Belum ada antrian untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top:16px;font-size:12px;color:#9ca3af;text-align:center;">
        Admin Antrian Klinik &middot; Laravel
    </div>
</div>

</body>
</html>
