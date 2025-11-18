<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cek Posisi Antrian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        input,
        select,
        textarea {
            box-sizing: border-box !important;
        }
    </style>
</head>

<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background:#f3f4f6;">

    <div
        style="max-width:480px;margin:30px auto;padding:20px;background:white;border-radius:12px;box-shadow:0 10px 30px rgba(15,23,42,.1);">
        <h1 style="font-size:20px;font-weight:700;margin-bottom:4px;">Cek Posisi Antrian</h1>
        <p style="font-size:14px;color:#6b7280;margin-bottom:16px;">
            Pilih cara cek antrian, lalu isi data yang diminta.
        </p>

        {{-- Pesan error --}}
        @if (session('error'))
            <div
                style="background:#fee2e2;color:#b91c1c;padding:10px 12px;border-radius:8px;font-size:14px;margin-bottom:16px;">
                {{ session('error') }}
            </div>
        @endif

        {{-- Error validasi --}}
        @if ($errors->any())
            <div
                style="background:#fee2e2;color:#b91c1c;padding:10px 12px;border-radius:8px;font-size:14px;margin-bottom:16px;">
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin-top:6px;padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            // Default mode: kalau nik lama terisi, pilih "nik", selain itu "nomor"
            $mode = old('nik') ? 'nik' : 'nomor';
        @endphp

        <form action="{{ route('antrian.cek') }}" method="POST" style="display:flex;flex-direction:column;gap:12px;">
            @csrf

            {{-- Pilih Metode Cek --}}
            <div
                style="padding:10px 12px;border-radius:10px;background:#f9fafb;border:1px solid #e5e7eb;margin-bottom:4px;">
                <div style="font-size:13px;font-weight:600;margin-bottom:6px;">
                    Pilih cara cek antrian:
                </div>
                <div style="display:flex;flex-direction:column;gap:4px;font-size:13px;color:#374151;">
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                        <input type="radio" name="mode" value="nomor" {{ $mode === 'nomor' ? 'checked' : '' }}>
                        <span>Cek menggunakan <strong>Nomor Antrian</strong></span>
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                        <input type="radio" name="mode" value="nik" {{ $mode === 'nik' ? 'checked' : '' }}>
                        <span>Cek menggunakan <strong>NIK</strong></span>
                    </label>
                </div>
                <div style="font-size:11px;color:#6b7280;margin-top:6px;">
                    Untuk pasien lansia, petugas bisa memilih metode yang paling mudah (Nomor Antrian atau NIK).
                </div>
            </div>

            {{-- Nomor Antrian --}}
            <div id="group-nomor">
                <label for="nomor_antrian" style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                    Nomor Antrian
                </label>
                <input type="number" min="1" name="nomor_antrian" id="nomor_antrian"
                    value="{{ old('nomor_antrian') }}" placeholder="Contoh: 12"
                    style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">
                <p style="font-size:11px;color:#9ca3af;margin-top:4px;">
                    Gunakan jika Anda ingin cek menggunakan <strong>Nomor Antrian</strong>.
                </p>
            </div>

            {{-- NIK --}}
            <div id="group-nik">
                <label for="nik" style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                    NIK
                </label>
                <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                    placeholder="Masukkan NIK"
                    style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">
                <p style="font-size:11px;color:#9ca3af;margin-top:4px;">
                    Gunakan jika pasien lupa <strong>Nomor Antrian</strong> dan ingin cek menggunakan
                    <strong>NIK</strong>.
                </p>
            </div>

            {{-- Poli (wajib) --}}
            <div>
                <label for="poli_id" style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                    Poli <span style="color:#dc2626;">*</span>
                </label>
                <select name="poli_id" id="poli_id" required
                    style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;background:white;">
                    <option value="">-- Pilih Poli --</option>
                    @foreach ($polis as $poli)
                        <option value="{{ $poli->id }}" @selected(old('poli_id') == $poli->id)>
                            {{ $poli->nama_poli }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                style="margin-top:8px;width:100%;padding:10px 12px;border:none;border-radius:9999px;
                       background:#2563eb;color:white;font-weight:600;font-size:14px;cursor:pointer;">
                Cek Posisi Antrian
            </button>
        </form>

        <hr style="border:none;border-top:1px solid #e5e7eb;margin:20px 0;">

        <div style="text-align:center;">
            <p style="font-size:13px;color:#6b7280;margin-bottom:8px;">
                Belum punya nomor antrian?
            </p>
            <a href="{{ route('antrian.form') }}"
                style="font-size:13px;color:#2563eb;text-decoration:none;font-weight:600;">
                Daftar Antrian Baru
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modeRadios = document.querySelectorAll('input[name="mode"]');
            const nomorInput = document.getElementById('nomor_antrian');
            const nikInput = document.getElementById('nik');
            const groupNomor = document.getElementById('group-nomor');
            const groupNik = document.getElementById('group-nik');

            function updateMode() {
                const checked = document.querySelector('input[name="mode"]:checked');
                const mode = checked ? checked.value : 'nomor';

                if (mode === 'nomor') {
                    // Tampilkan nomor, sembunyikan NIK
                    groupNomor.style.display = 'block';
                    groupNik.style.display = 'none';

                    nomorInput.disabled = false;
                    nikInput.disabled = true;
                    nikInput.value = '';
                } else {
                    // Tampilkan NIK, sembunyikan nomor
                    groupNomor.style.display = 'none';
                    groupNik.style.display = 'block';

                    nikInput.disabled = false;
                    nomorInput.disabled = true;
                    nomorInput.value = '';
                }
            }

            modeRadios.forEach(r => r.addEventListener('change', updateMode));
            updateMode(); // inisialisasi menurut pilihan awal (old value)
        });
    </script>

</body>

</html>
