@extends('layouts.app')

@section('title', 'Tambah Pasien Baru - Audify')

@push('styles')
<style>
    .form-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }
    .section-title {
        color: #007bff;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }
    .required:after {
        content: " *";
        color: red;
    }
</style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Pasien Baru
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Pasien</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">
                    <i class="fas fa-edit mr-2"></i>
                    Form Data Pasien
                </h3>
                <div class="card-tools">
                    <span class="badge badge-light">No. RM akan dibuat otomatis</span>
                </div>
            </div>
            
            <form action="{{ route('patients.store') }}" method="POST" id="formPasien">
                @csrf
                
                <div class="card-body">
                    <!-- Alert -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Isi semua data pasien dengan lengkap dan benar. Tanda <span class="text-danger">*</span> wajib diisi.
                    </div>
                    
                    <!-- Informasi Pribadi -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-user-circle mr-2"></i>
                            Informasi Pribadi
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required">NIK</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" 
                                               class="form-control @error('nik') is-invalid @enderror" 
                                               name="nik" 
                                               value="{{ old('nik') }}"
                                               placeholder="Nomor Induk Kependudukan"
                                               maxlength="16"
                                               required>
                                    </div>
                                    @error('nik')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required">Nama Lengkap</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" 
                                               class="form-control @error('nama') is-invalid @enderror" 
                                               name="nama" 
                                               value="{{ old('nama') }}"
                                               placeholder="Nama sesuai KTP"
                                               required>
                                    </div>
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Panggilan</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="nama_panggilan" 
                                           value="{{ old('nama_panggilan') }}"
                                           placeholder="Opsional">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required">Tempat Lahir</label>
                                    <input type="text" 
                                           class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                           name="tempat_lahir" 
                                           value="{{ old('tempat_lahir') }}"
                                           required>
                                    @error('tempat_lahir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="date" 
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                               name="tanggal_lahir" 
                                               value="{{ old('tanggal_lahir') }}"
                                               required>
                                    </div>
                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required">Jenis Kelamin</label>
                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                            name="jenis_kelamin" 
                                            required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Kontak -->
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="fas fa-address-book mr-2"></i>
                            Informasi Kontak
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telepon / HP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" 
                                               class="form-control" 
                                               name="no_telepon" 
                                               value="{{ old('no_telepon') }}"
                                               placeholder="081234567890">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" 
                                               class="form-control" 
                                               name="email" 
                                               value="{{ old('email') }}"
                                               placeholder="nama@email.com">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="pekerjaan" 
                                           value="{{ old('pekerjaan') }}"
                                           placeholder="Contoh: Karyawan">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea class="form-control" 
                                      name="alamat" 
                                      rows="3" 
                                      placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi">{{ old('alamat') }}</textarea>
                        </div>
                    </div>           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Pasien</label>
                                    <select class="form-control" name="status">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Pasien
                    </button>
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary btn-lg px-5 ml-2">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format NIK (hanya angka)
    const nikInput = document.querySelector('input[name="nik"]');
    if (nikInput) {
        nikInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    // Hitung usia otomatis dari tanggal lahir
    const tglLahirInput = document.querySelector('input[name="tanggal_lahir"]');
    if (tglLahirInput) {
        tglLahirInput.addEventListener('change', function() {
            // Bisa ditambahkan fitur hitung usia jika diperlukan
        });
    }
});
</script>
@endpush