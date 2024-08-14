<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Rules\MaxAnimalsPerFarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnimalController extends Controller
{
    public function show($animal_id)
    {
        $animal = Animal::find($animal_id);
        if ( ! $animal) {
            return redirect(route('farms.index'))
                ->with('error', 'Animal not found.');
        }
        return Inertia::render('Animal/Update', [
            'animal' => $animal,
        ]);
    }


    public function create(int $farmId)
    {
        return Inertia::render('Animal/Create',
        [
            'farmId' => $farmId,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => ['required', 'exists:farms,id', new MaxAnimalsPerFarm($request->farm_id)],
            'animal_number' => ['required', 'integer'],
            'type_name' => ['required', 'string'],
            'years' => ['nullable', 'integer'],
        ]);
        Animal::create([
            'user_id' => Auth::id(),
            'farm_id' => $request->farm_id,
            'animal_number' => $request->animal_number,
            'type_name' => $request->type_name,
            'years' => $request->years
        ]);
        return redirect(route('farms.index'))
            ->with('success', 'Animal has been added to the farm.');
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'animal_id' => ['required', 'numeric' ,'exists:animals,id'],
        ]);
        $animal = Animal::find($request->animal_id);
        if ( ! $animal) {
            return redirect(route('farms.index'))
                ->with('error', 'Animal not found.');
        }
        if ($animal->user_id !== Auth::id()) {
            return redirect(route('farms.index'))
                ->with('error', 'Oops, something went wrong.');
        }
        $animal->delete();
        return redirect(route('farms.index'))
            ->with('success', 'Animal has been removed.');
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => ['required', 'numeric' ,'exists:animals,id'],
            'animal_number' => ['required', 'integer'],
            'type_name' => ['required', 'string'],
            'years' => ['nullable', 'integer'],
        ]);
        $animal = Animal::find($request->animal_id);
        $animal->update($validated);
        return redirect(route('farms.index'))->with('success', 'Animal has been updated.');
    }
}
