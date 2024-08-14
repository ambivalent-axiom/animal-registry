<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FarmController extends Controller
{
    public function index()
    {
        $farms = Farm::where('user_id', Auth::id())
            ->with('animals')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return Inertia::render('Farm/Index', [
            'farms' => $farms,
        ]);
    }
    public function show(int $farmId)
    {
        $farm = Farm::find($farmId);
        if ( ! $farm) {
            return redirect(route('farms.index'))
                ->with('error', 'Farm not found.');
        }

        return response()->json($farm);
    }
    public function create()
    {
        return Inertia::render('Farm/Create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
        ]);
        Farm::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website
        ]);
        return redirect(route('farms.index'))->with('success', 'Farm has been created.');
    }
    public function destroy(Request $request)
    {
        $farm = Farm::find($request->farm_id);
        if ( ! $farm) {
            return redirect(route('farms.index'))
                ->with('error', 'Farm not found.');
        }
        if($farm->user_id != Auth::id()){
            return redirect(route('farms.index'))
                ->with('error', 'Oops, something went wrong.');
        }
        if( $farm->animals()->count() > 0 ) {
            foreach ($farm->animals as $animal) {
                $animal->delete();
            }
        }
        $farm->delete();
        return redirect(route('farms.index'))->with('success', 'Farm has been deleted.');
    }
}
