@extends('layouts.app')

@section('content')
    <h1>Daftar Mobil</h1>
    <a href="{{ route('cars.create') }}">Tambah Mobil</a>
    <ul>
        @foreach ($cars as $car)
            <li>{{ $car->brand }} - {{ $car->model }} - {{ $car->plate_number }}</li>
        @endforeach
    </ul>
@endsection