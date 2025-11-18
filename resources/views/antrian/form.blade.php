<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Antrian Pasien</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        input,
        select,
        textarea {
            box-sizing: border-box !important;
        }
    </style>

</head>

<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background:#0f172a;">

    <div style="max-width:480px;margin:30px auto;padding:20px;">
        <div style="background:white;border-radius:16px;padding:20px;box-shadow:0 15px 35px rgba(15,23,42,.35);">
            <h1 style="font-size:20px;font-weight:700;margin-bottom:4px;">Pendaftaran Antrian Pasien</h1>
            <p style="font-size:13px;color:#6b7280;margin-bottom:16px;">
                Isi data berikut untuk mendapatkan nomor antrian di klinik.
            </p>

            {{-- error flash --}}
            @if ($errors->any())
                <div
                    style="background:#fee2e2;color:#b91c1c;padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin-top:6px;padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('antrian.store') }}" method="POST"
                style="display:flex;flex-direction:column;gap:12px;">
                @csrf

                {{-- Nama Pasien --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Nama Pasien <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="nama_pasien" value="{{ old('nama_pasien') }}" required
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">
                </div>

                {{-- NIK --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        NIK <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="nik" value="{{ old('nik') }}" required
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Jenis Kelamin <span style="color:#dc2626;">*</span>
                    </label>
                    <div style="display:flex;gap:16px;font-size:14px;">
                        <label>
                            <input type="radio" name="jenis_kelamin" value="L"
                                {{ old('jenis_kelamin') === 'L' ? 'checked' : '' }}> Laki-laki
                        </label>
                        <label>
                            <input type="radio" name="jenis_kelamin" value="P"
                                {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }}> Perempuan
                        </label>
                    </div>
                </div>

                {{-- Nomor HP --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Nomor HP <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                        placeholder="Contoh: 0812xxxx"
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">
                </div>

                {{-- Alamat --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Alamat <span style="color:#dc2626;">*</span>
                    </label>
                    <textarea name="alamat" rows="2" required
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">{{ old('alamat') }}</textarea>
                </div>

                {{-- Tanggal lahir --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Tanggal Lahir
                    </label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">
                </div>

                {{-- Poli --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Poli Tujuan <span style="color:#dc2626;">*</span>
                    </label>
                    <select name="poli_id" required
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;background:white;">
                        <option value="">-- Pilih Poli --</option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}" @selected(old('poli_id') == $poli->id)>
                                {{ $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Keluhan --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Keluhan (opsional)
                    </label>
                    <textarea name="keluhan" rows="2"
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;">{{ old('keluhan') }}</textarea>
                </div>

                {{-- Jenis Pembayaran --}}
                <div>
                    <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">
                        Jenis Pembayaran <span style="color:#dc2626;">*</span>
                    </label>
                    <select name="jenis_pembayaran" required
                        style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #d1d5db;font-size:14px;background:white;">
                        <option value="">-- Pilih Jenis Pembayaran --</option>
                        <option value="bpjs" @selected(old('jenis_pembayaran') === 'bpjs')>BPJS</option>
                        <option value="umum" @selected(old('jenis_pembayaran') === 'umum')>Umum</option>
                    </select>
                </div>

                <button type="submit"
                    style="margin-top:8px;width:100%;padding:10px 12px;border:none;border-radius:9999px;
                               background:#2563eb;color:white;font-weight:600;font-size:14px;cursor:pointer;">
                    Daftar & Dapatkan Nomor Antrian
                </button>
                <p style="margin-top:10px;font-size:12px;color:#6b7280;text-align:center;">
                    Setelah mendaftar, Anda akan mendapatkan nomor antrian dan estimasi waktu panggilan.
                </p>
            </form>
            <hr style="border:none;border-top:1px solid #e5e7eb;margin:20px 0;">

            <div style="text-align:center;">
                <p style="font-size:13px;color:#6b7280;margin-bottom:8px;">
                    Sudah punya nomor antrian?
                </p>
                <a href="{{ route('antrian.cek.form') }}"
                    style="font-size:13px;color:#2563eb;text-decoration:none;font-weight:600;">
                    Cek Posisi Antrian
                </a>
            </div>
        </div>
    </div>

</body>

</html>
