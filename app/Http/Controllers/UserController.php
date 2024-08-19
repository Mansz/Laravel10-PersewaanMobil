<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'license_number' => 'required',
        ]);
    
        Users::create($validated);
        return redirect()->route('users.index');
    }
}
