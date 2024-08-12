<?php

namespace App\Http\Controllers\Farm;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmController extends Controller
{
    public function index()
    {
//        $farms = Farm::where('user_id', Auth::id())->with('animals')->paginate(10);
//        return view('farm.index', compact('farms'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'farm_name' => ['required', 'string', 'max:255'],
            'farm_email' => ['required', 'string', 'max:255'],
            'farm_website' => ['string', 'max:255'],
        ]);
        Farm::create([
            'user_id' => Auth::id(),
            'name' => $request->farm_name,
            'email' => $request->farm_email,
            'website' => $request->farm_website
        ]);
        return redirect(route('farms.index'))->with('success', 'Farm has been created.');
    }
}
