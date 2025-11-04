<?php

namespace Modules\Reviews\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Modules\Reviews\Models\Review;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reviews::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reviews::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        // Vérifier que l'utilisateur a acheté le cours
        $course = Course::findOrFail($request->course_id);
        
        if (!auth()->user()->purchasedCourses()->where('course_id', $course->id)->exists()) {
            abort(403, 'You must purchase this course to review it.');
        }

        // Vérifier que l'utilisateur n'a pas déjà fait une review
        if (auth()->user()->hasReviewedCourse($course->id)) {
            return redirect()->back()->with('error', 'You have already reviewed this course.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'course_id' => $request->course_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // Par défaut pending
        ]);

        return redirect()->route('pages.home')->with('success', 'Review submitted successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('reviews::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('reviews::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
