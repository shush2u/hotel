<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('user')->latest()->get();

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        // For simplicity, we just return the view. You might pass specific item IDs here later.
        return view('reviews.create');
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return back()->withErrors(['auth' => 'You must be logged in to leave a review.']);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            // Assuming you have an authenticated user, or passing user_id explicitly
            // For production, you would typically use auth()->id() here: 'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|max:500',
            // NOTE: user_id is expected to be handled by the form or session logic
        ]);

        // Assuming user_id is handled in the form or is hardcoded for this example
        // In a real app, you would use $request->user()->id or a hidden field
        $validatedData['user_id'] = Auth::id();

        Review::create($validatedData);

        return redirect()->route('reviews.index')
            ->with('success', 'Your review has been successfully submitted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
