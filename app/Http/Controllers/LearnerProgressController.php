<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Learner;

class LearnerProgressController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::orderBy('name')->get(['id', 'name']);

        $learners = Learner::with(['enrolments.course'])->orderBy('firstname')->get();


        return view('learner-progress', compact('learners', 'courses'));
    }
}