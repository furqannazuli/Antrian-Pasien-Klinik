<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tiket Nomor Antrian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background:#0f172a;">

    <div style="max-width:420px;margin:30px auto;padding:20px;">
        <div
            style="background:white;border-radius:16px;padding:20px 18px 18px;box-shadow:0 15px 40px rgba(15,23,42,.35);position:relative;overflow:hidden;">
            <div
                style="position:absolute;inset:0;opacity:.06;background-image:radial-gradient(circle at 10px 10px,#4f46e5 1px,transparent 0);background-size:16px 16px;">
            </div>

            <div style="position:relative;">
                <h1 style="font-size:18px;font-weight:700;margin:0 0 4px;">Nomor Antrian Anda</h1>
                <p style="font-size:13px;color:#6b7280;margin:0 0 12px;">
                    Mohon simpan atau screenshot halaman ini sebagai bukti pendaftaran.
                </p>

                <!-- Kartu Info Antrian -->
                <div
                    style="margin:14px 0 16px;padding:14px 12px;border-radius:14px;background:#111827;color:white;display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <div style="font-size:11px;text-transform:uppercase;color:#9ca3af;letter-spacing:.08em;">
                            Nomor Antrian
                        </div>
                        <div style="font-size:34px;font-weight:800;line-height:1;margin-top:4px;">
                            {{ $antrian->nomor_antrian }}
                        </div>
                        <div style="font-size:12px;color:#d1d5db;margin-top:4px;">
                            Poli: <strong>{{ $antrian->poli?->nama_poli }}</strong>
                        </div>
                        <div style="font-size:12px;color:#d1d5db;margin-top:2px;">
                            Loket: <strong>{{ $antrian->poli?->loket ?? '-' }}</strong>
                        </div>
                    </div>
                    <div style="text-align:right;font-size:12px;color:#e5e7eb;">
                        <div>Jenis Pembayaran:</div>
                        <div style="font-weight:600;text-transform:uppercase;margin-top:2px;">
                            {{ strtoupper($antrian->jenis_pembayaran) }}
                        </div>
                        <div style="margin-top:10px;font-size:11px;color:#9ca3af;">
                            Tanggal: {{ $antrian->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <!-- BARCODE -->
                <div style="margin-top:12px;margin-bottom:18px;text-align:center;">
                    <div style="font-size:11px;color:#6b7280;margin-bottom:4px;">
                        Barcode Antrian (scan di loket pendaftaran)
                    </div>
                    <div>
                        {!! DNS1D::getBarcodeSVG((string) $antrian->id, 'C39', 1.6, 60) !!}
                    </div>
                </div>

                <!-- Info Waktu -->
                <div style="font-size:13px;color:#374151;margin-bottom:10px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                        <span>Estimasi waktu panggilan</span>
                        <strong>
                            @if ($antrian->estimasi_waktu)
                                {{ $antrian->estimasi_waktu->format('H:i') }} WIB
                            @else
                                -
                            @endif
                        </strong>
                    </div>

                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:12px;">
                        <span>Nomor yang sedang dipanggil</span>
                        <strong>
                            @if ($nomorSedangDipanggil > 0)
                                {{ $nomorSedangDipanggil }}
                            @else
                                Belum ada
                            @endif
                        </strong>
                    </div>

                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:12px;">
                        <span>Jumlah yang menunggu di depan Anda</span>
                        <strong>{{ $jumlahMenungguDiDepan }}</strong>
                    </div>

                    <div style="display:flex;justify-content:space-between;font-size:12px;color:#6b7280;">
                        <span>Status saat ini</span>
                        <span style="font-weight:600;text-transform:capitalize;">
                            {{ $antrian->status }}
                        </span>
                    </div>
                </div>

                <!-- Catatan -->
                <div
                    style="margin-top:14px;padding:10px 12px;border-radius:10px;background:#eff6ff;font-size:12px;color:#1e40af;">
                    <strong>Catatan:</strong><br>
                    • Silakan datang beberapa menit sebelum estimasi waktu panggilan.<br>
                    • Tunjukkan nomor antrian ini kepada petugas pendaftaran.<br>
                    • Disarankan untuk <strong>screenshoot</strong> halaman ini.
                </div>

                <div
                    style="margin-top:14px;padding:10px 12px;border-radius:10px;background:#eff6ff;font-size:12px;color:#1e40af;">
                    <strong>Berkas yang harus dibawa:</strong><br>

                    @if ($antrian->jenis_pembayaran === 'bpjs')
                        {{-- Dummy untuk BPJS - nanti client bisa edit sendiri --}}
                        • KTP asli / fotokopi<br>
                        • Kartu BPJS aktif<br>
                        • Kartu berobat klinik (jika sudah punya)<br>
                    @else
                        {{-- Dummy untuk Umum - nanti client bisa edit sendiri --}}
                        • KTP asli / fotokopi (jika ada)<br>
                        • Kartu berobat klinik (jika sudah punya)<br>
                    @endif

                    <br>
                    <strong>Catatan Tambahan:</strong><br>
                    • Silakan datang beberapa menit sebelum estimasi waktu panggilan.<br>
                    • Tunjukkan nomor antrian ini kepada petugas pendaftaran.<br>
                    • Disarankan untuk <strong>screenshoot</strong> halaman ini.
                </div>

                <!-- Tombol -->
                <div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('antrian.cek.form') }}"
                        style="display:block;text-align:center;padding:9px 12px;border-radius:9999px;
                          background:#2563eb;color:white;text-decoration:none;font-size:14px;font-weight:600;">
                        Cek Posisi Antrian
                    </a>

                    <a href="{{ route('antrian.form') }}"
                        style="display:block;text-align:center;padding:8px 12px;border-radius:9999px;
                          border:1px solid #d1d5db;color:#374151;text-decoration:none;font-size:13px;font-weight:500;background:white;">
                        Daftar Antrian Baru
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
