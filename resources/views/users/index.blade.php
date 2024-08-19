@extends('layouts.app')

@section('content')
    <h1>Daftar Pengguna</h1>
    <a href="{{ route('users.create') }}">Tambah Pengguna</a>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} - {{ $user->phone }}</li>
        @endforeach
    </ul>
@endsection