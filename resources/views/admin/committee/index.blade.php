@extends('layouts.app') {{-- Ganti ini jika kamu pakai layout lain --}}

@section('title', 'Daftar Panitia')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Panitia</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($committees->isEmpty())
        <p>Tidak ada panitia yang terdaftar.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Dibuat Pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($committees as $committee)
                    <tr>
                        <td>{{ $committee->name }}</td>
                        <td>{{ $committee->email }}</td>
                        <td>{{ $committee->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
