@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'PIC Staff'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">PIC Staff</h6>
                <a href="{{ route('pic_staff.create') }}" class="btn btn-primary btn-sm mb-0">
                    + Tambah PIC
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <form method="GET" action="{{ route('pic_staff.index') }}" class="d-flex gap-2 ms-auto me-4 mb-3"
                        style="max-width: 500px;" class="no-spinner">
                        <input type="text" name="search" placeholder="Cari nama/email PIC..."
                            value="{{ request('search') }}" class="form-control">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </form>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Jabatan</th>
                                <th>Alamat</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($picStaffs as $staff)
                            <tr class="text-center text-sm">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $staff->full_name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->phone_number }}</td>
                                <td>{{ $staff->position }}</td>
                                <td>{{ $staff->address }}</td>
                                <td>{{ $staff->note }}</td>
                                <td>
                                    <a href="{{ route('pic_staff.edit', $staff->id) }}"
                                        class="btn btn-info btn-sm mb-0">Edit</a>
                                    <form action="{{ route('pic_staff.destroy', $staff->id) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('Hapus PIC ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-0">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted text-sm">Belum ada PIC Staff.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection