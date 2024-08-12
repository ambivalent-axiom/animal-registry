<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Rules\MaxAnimalsPerFarm;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'farm_id' => ['required', 'exists:farms,id', new MaxAnimalsPerFarm($request->farm_id)],
            'animal_number' => ['required', 'integer'],
            'type_name' => ['required', 'string'],
            'years' => 'integer',
        ]);
        ANimal::create([
            'farm_id' => $request->farm_id,
            'animal_number' => $request->animal_number,
            'type_name' => $request->type_name,
            'years' => $request->years
        ]);
        return redirect(route('farms.index'))
            ->with('success', 'Animal has been added to the farm.');
    }
}
