@extends('adminlte::page')

@section('title', 'Edit Tamu')

@section('content_header')
    <h1>Edit Data Tamu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Tamu</h3>
        </div>
        <form method="POST" action="{{ route('admin.guestbook.update', $guest->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                           id="nama" name="nama" value="{{ old('nama', $guest->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                           id="telepon" name="telepon" value="{{ old('telepon', $guest->telepon) }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instansi">Instansi</label>
                    <input type="text" class="form-control @error('instansi') is-invalid @enderror"
                           id="instansi" name="instansi" value="{{ old('instansi', $guest->instansi) }}">
                    @error('instansi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('keperluan') is-invalid @enderror"
                           id="keperluan" name="keperluan" value="{{ old('keperluan', $guest->keperluan) }}" required>
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bidang">Bidang <span class="text-danger">*</span></label>
                    <select class="form-control @error('bidang') is-invalid @enderror" id="bidang" name="bidang" required>
                        <option value="">Pilih Bidang</option>
                        @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->id }}"
                                {{ old('bidang', $guest->bidang) == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('bidang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Check In</label>
                            <input type="text" class="form-control" value="{{ $guest->check_in_at->format('d/m/Y H:i:s') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Check Out</label>
                            <input type="text" class="form-control"
                                   value="{{ $guest->check_out_at ? $guest->check_out_at->format('d/m/Y H:i:s') : 'Belum Checkout' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.guestbook.show', $guest->id) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
                <a href="{{ route('admin.guestbook.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@stop
