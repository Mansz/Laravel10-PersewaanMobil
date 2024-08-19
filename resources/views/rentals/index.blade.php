@extends('layouts.app')

@section('content')
    <h1>Daftar Peminjaman</h1>
    <a href="{{ route('rentals.create') }}">Tambah Peminjaman</a>
    <ul>
        @foreach ($rentals as $rental)
            <li>{{ $rental->car->model }} oleh {{ $rental->user->name }}</li>
        @endforeach
    </ul>
@endsection