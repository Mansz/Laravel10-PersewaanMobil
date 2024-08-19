<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\Retun; 
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function store(Request $request) {
        // Validasi
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id', // Ganti user_id menjadi customer_id
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
    
        // Cek ketersediaan mobil
        $car = Car::find($validated['car_id']);
        if (!$car->available) {
            return redirect()->back()->withErrors('Mobil tidak tersedia.');
        }
    
        // Buat peminjaman
        Rental::create($validated);
    
        // Update status mobil
        $car->update(['available' => false]);
    
        return redirect()->route('rentals.index')->with('success', 'Mobil berhasil dipinjam.');
    }

    public function return(Request $request, $id) {
        // Validasi
        $validated = $request->validate([
            'return_date' => 'required|date',
        ]);
    
        // Temukan peminjaman
        $rental = Rental::findOrFail($id);
    
        // Hitung biaya total
        $car = Car::find($rental->car_id);
        $rentalDays = now()->diffInDays($rental->start_date);
        $totalCost = $rentalDays * $car->rental_rate;
    
        // Buat pengembalian
        $return = new Retun(); // Pastikan nama model sesuai
        $return->rental_id = $rental->id;
        $return->return_date = $validated['return_date'];
        $return->total_cost = $totalCost;
        $return->save();
    
        // Update status mobil
        $car->update(['available' => true]);
    
        return redirect()->route('rentals.index')->with('success', 'Mobil berhasil dikembalikan. Total biaya: ' . $totalCost);
    }
}