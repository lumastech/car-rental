<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all cars with availability = true with pagination
        $cars = Car::where('availability', true)->paginate(10);
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new car
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'price_per_day' => 'required|numeric',
        ]);

        // Create a new car
        Car::create([
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'price_per_day' => $request->price_per_day,
            'availability' => true,
        ]);

        // Redirect to the cars index page
        return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        // show the car details
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        // Return the view for editing the car
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        // Validate the request
        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'price_per_day' => 'required|numeric',
        ]);

        // Update the car
        $car->update([
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'price_per_day' => $request->price_per_day,
        ]);

        // Redirect to the cars index page
        return redirect()->route('cars.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        // Delete the car
       if ($car->bookings()->count() > 0) {
            return redirect()->route('cars.index')->with('error', 'Car has bookings and cannot be deleted');
        }

        // Redirect to the cars index page
        return redirect()->route('cars.index');
    }
}
