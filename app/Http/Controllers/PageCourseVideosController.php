<?php

namespace App\Http\Controllers;

use App\Models\Course;

class PageCourseVideosController extends Controller
{
    public function __invoke(Course $course)
    {
        return view('pages.course-videos', compact('course'));
    }
}
