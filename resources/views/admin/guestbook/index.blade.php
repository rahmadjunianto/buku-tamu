@extends('adminlte::page')

@section('title', 'Daftar Tamu')

@section('content_header')
    <h1>Daftar Tamu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Tamu</h3>
            {{-- <div class="card-tools">
                <a href="{{ route('admin.guestbook.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Tamu
                </a>
            </div> --}}
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Instansi</th>
                            <th>Keperluan</th>
                            <th>Bidang</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guests as $guest)
                        <tr>
                            <td>{{ $loop->iteration + ($guests->currentPage() - 1) * $guests->perPage() }}</td>
                            <td>{{ $guest->nama }}</td>
                            <td>{{ $guest->telepon ?? '-' }}</td>
                            <td>{{ $guest->instansi ?? '-' }}</td>
                            <td>{{ $guest->keperluan }}</td>
                            <td>{{ $guest->bidangInfo->nama ?? '-' }}</td>
                            <td>{{ $guest->check_in_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($guest->check_out_at)
                                    {{ $guest->check_out_at->format('d/m/Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($guest->check_out_at)
                                    <span class="badge badge-success">Sudah Checkout</span>
                                @else
                                    <span class="badge badge-warning">Belum Checkout</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.guestbook.show', $guest->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.guestbook.edit', $guest->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$guest->check_out_at)
                                        <form method="POST" action="{{ route('admin.guestbook.checkout', $guest->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin checkout tamu ini?')">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.guestbook.destroy', $guest->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada data tamu</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $guests->links() }}
        </div>
    </div>
@stop
