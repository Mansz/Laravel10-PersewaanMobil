<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'plate_number' => 'required|string|unique:cars',
            'rental_rate' => 'required|numeric',
            'available' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('cars', 'public');
        }

        Car::create($validated);

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'plate_number' => 'required|string|unique:cars,plate_number,' . $car->id,
            'rental_rate' => 'required|numeric',
            'available' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($car->photo) {
                Storage::disk('public')->delete($car->photo);
            }
            $validated['photo'] = $request->file('photo')->store('cars', 'public');
        }

        $car->update($validated);

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui.');
    }
}