@extends('layouts.dashboard')

@section('title', 'Pendaftaran Step 2 — PPDB Nashirussunnah')
@section('page_title', 'Form Pendaftaran')

@section('content')

<div class="page-heading">
    <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text"></i></span>
        <div>
            <p class="eyebrow mb-1">Calon Santri</p>
            <h1 class="h3 mb-1">Form Pendaftaran</h1>
            <p class="text-muted mb-0">Lengkapi data orang tua / wali.</p>
        </div>
    </div>
</div>

{{-- Progress Bar --}}
<div class="panel p-4 mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="small fw-semibold">Step 2 dari 3 — Data Orang Tua / Wali</span>
        <span class="small text-muted">66%</span>
    </div>
    <div class="progress" style="height: 8px;">
        <div class="progress-bar bg-primary" style="width: 66%"></div>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <span class="badge text-bg-success">✓ Data Diri</span>
        <span class="badge text-bg-primary">2. Data Orang Tua / Wali</span>
        <span class="badge text-bg-light text-muted">3. Dokumen</span>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="panel p-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('pendaftaran.simpanStep2') }}">
                @csrf

                {{-- Status Orang Tua --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Status Orang Tua <span class="text-danger">*</span>
                    </label>
                    <select name="status_ortu" id="status_ortu"
                        class="form-select" onchange="toggleForm(this.value)">
                        <option value="lengkap"
                            {{ old('status_ortu', $pendaftaran->status_ortu ?? 'lengkap') === 'lengkap' ? 'selected' : '' }}>
                            Orang Tua Lengkap (Ayah & Ibu)
                        </option>
                        <option value="yatim"
                            {{ old('status_ortu', $pendaftaran->status_ortu ?? '') === 'yatim' ? 'selected' : '' }}>
                            Yatim (Ayah telah meninggal)
                        </option>
                        <option value="piatu"
                            {{ old('status_ortu', $pendaftaran->status_ortu ?? '') === 'piatu' ? 'selected' : '' }}>
                            Piatu (Ibu telah meninggal)
                        </option>
                        <option value="yatim_piatu"
                            {{ old('status_ortu', $pendaftaran->status_ortu ?? '') === 'yatim_piatu' ? 'selected' : '' }}>
                            Yatim Piatu (Ayah & Ibu telah meninggal)
                        </option>
                        <option value="wali"
                            {{ old('status_ortu', $pendaftaran->status_ortu ?? '') === 'wali' ? 'selected' : '' }}>
                            Diasuh Wali
                        </option>
                    </select>
                </div>

                {{-- Data Ayah --}}
                <div id="form-ayah">
                    <hr class="my-3">
                    <p class="fw-semibold text-muted small mb-3">
                        <i class="bi bi-person me-1"></i>DATA AYAH
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Ayah <span class="text-danger" id="required-ayah">*</span>
                        </label>
                        <input type="text" name="nama_ayah"
                            value="{{ old('nama_ayah', $pendaftaran->nama_ayah ?? '') }}"
                            class="form-control"
                            placeholder="Nama lengkap ayah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Pekerjaan Ayah <span class="text-danger" id="required-pkj-ayah">*</span>
                        </label>
                        <input type="text" name="pekerjaan_ayah"
                            value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah ?? '') }}"
                            class="form-control"
                            placeholder="Contoh: Wiraswasta">
                    </div>
                </div>

                {{-- Data Ibu --}}
                <div id="form-ibu">
                    <hr class="my-3">
                    <p class="fw-semibold text-muted small mb-3">
                        <i class="bi bi-person me-1"></i>DATA IBU
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Ibu <span class="text-danger" id="required-ibu">*</span>
                        </label>
                        <input type="text" name="nama_ibu"
                            value="{{ old('nama_ibu', $pendaftaran->nama_ibu ?? '') }}"
                            class="form-control"
                            placeholder="Nama lengkap ibu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Pekerjaan Ibu <span class="text-danger" id="required-pkj-ibu">*</span>
                        </label>
                        <input type="text" name="pekerjaan_ibu"
                            value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu ?? '') }}"
                            class="form-control"
                            placeholder="Contoh: Ibu Rumah Tangga">
                    </div>
                </div>

                {{-- Data Wali --}}
                <div id="form-wali" style="display:none;">
                    <hr class="my-3">
                    <p class="fw-semibold text-muted small mb-3">
                        <i class="bi bi-person-badge me-1"></i>DATA WALI
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Wali <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_wali"
                            value="{{ old('nama_wali', $pendaftaran->nama_wali ?? '') }}"
                            class="form-control"
                            placeholder="Nama lengkap wali">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Hubungan dengan Santri <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="hubungan_wali"
                            value="{{ old('hubungan_wali', $pendaftaran->hubungan_wali ?? '') }}"
                            class="form-control"
                            placeholder="Contoh: Paman, Kakek, Kakak">
                    </div>
                </div>

                {{-- HP Orang Tua / Wali --}}
                <div id="form-hp-ortu">
                    <hr class="my-3">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Nomor HP Orang Tua / Wali yang Bisa Dihubungi
                            <span class="text-danger">*</span>
                        </label>
                        <input type="tel" name="hp_ortu"
                            value="{{ old('hp_ortu', $pendaftaran->hp_ortu ?? '') }}"
                            class="form-control"
                            placeholder="08xxxxxxxxxx"
                            minlength="10" maxlength="15"
                            oninput="this.value = this.value.replace(/[^0-9+\-\s]/g, '')">
                        <div class="form-text">
                            Nomor HP yang aktif untuk dihubungi panitia.
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('pendaftaran.step1') }}"
                        class="btn btn-outline-secondary w-25">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        Simpan & Lanjut <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
function toggleForm(status) {
    const formAyah  = document.getElementById('form-ayah');
    const formIbu   = document.getElementById('form-ibu');
    const formWali  = document.getElementById('form-wali');
    const formHpOrtu = document.getElementById('form-hp-ortu');

    // Reset semua dulu
    formAyah.style.display  = 'block';
    formIbu.style.display   = 'block';
    formWali.style.display  = 'none';
    formHpOrtu.style.display = 'block';

    if (status === 'yatim') {
        // Ayah meninggal → sembunyikan form ayah
        formAyah.style.display = 'none';
    } else if (status === 'piatu') {
        // Ibu meninggal → sembunyikan form ibu
        formIbu.style.display = 'none';
    } else if (status === 'yatim_piatu') {
        // Keduanya meninggal → sembunyikan form ayah & ibu, tampilkan wali
        formAyah.style.display = 'none';
        formIbu.style.display  = 'none';
        formWali.style.display = 'block';
    } else if (status === 'wali') {
        // Diasuh wali → sembunyikan form ortu, tampilkan wali
        formAyah.style.display = 'none';
        formIbu.style.display  = 'none';
        formWali.style.display = 'block';
    }
}

// Jalankan saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    const status = document.getElementById('status_ortu').value;
    toggleForm(status);
});
</script>
@endsection