@extends('adminlte::page')

@section('title', 'Tambah Tamu')

@section('content_header')
    <h1>Tambah Tamu Baru</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Tamu</h3>
        </div>
        <form method="POST" action="{{ route('admin.guestbook.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                           id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                           id="telepon" name="telepon" value="{{ old('telepon') }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instansi">Instansi</label>
                    <input type="text" class="form-control @error('instansi') is-invalid @enderror"
                           id="instansi" name="instansi" value="{{ old('instansi') }}">
                    @error('instansi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('keperluan') is-invalid @enderror"
                           id="keperluan" name="keperluan" value="{{ old('keperluan') }}" required>
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bidang">Bidang <span class="text-danger">*</span></label>
                    <select class="form-control @error('bidang') is-invalid @enderror" id="bidang" name="bidang" required>
                        <option value="">Pilih Bidang</option>
                        @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->id }}" {{ old('bidang') == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('bidang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.guestbook.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@stop
