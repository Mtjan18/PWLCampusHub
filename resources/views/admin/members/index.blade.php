@extends('layouts.app')

@section('title', 'Daftar Member')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Daftar Member</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($members->isEmpty())
            <p>Tidak ada member yang terdaftar.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->created_at->format('d M Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.members.promote') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $member->id }}">
                                    <input type="hidden" name="new_role_id" value="3">
                                    <button class="btn btn-sm btn-success" type="submit">Jadikan Tim Keuangan</button>
                                </form>

                                <form method="POST" action="{{ route('admin.members.promote') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $member->id }}">
                                    <input type="hidden" name="new_role_id" value="4">
                                    <button class="btn btn-sm btn-primary" type="submit">Jadikan Panitia</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
